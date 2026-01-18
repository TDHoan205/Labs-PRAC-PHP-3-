<?php
require_once __DIR__ . '/../core/Database.php';

class MemberModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM members ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO members (member_code, full_name, email, phone) VALUES (:member_code, :full_name, :email, :phone)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE members SET member_code = :member_code, full_name = :full_name, email = :email, phone = :phone WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM members WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function validate($data, $id = null) {
        $errors = [];
        if (empty($data['member_code'])) $errors['member_code'] = 'Mã thẻ bắt buộc';
        if (empty($data['full_name'])) $errors['full_name'] = 'Họ tên bắt buộc';
        if (empty($data['email'])) $errors['email'] = 'Email bắt buộc';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email không hợp lệ';

        $sql = "SELECT id FROM members WHERE (member_code = :member_code OR email = :email)";
        $params = [':member_code' => $data['member_code'], ':email' => $data['email']];
        if ($id) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $errors['duplicate'] = 'Mã thẻ hoặc Email đã tồn tại';
        }
        return $errors;
    }
}