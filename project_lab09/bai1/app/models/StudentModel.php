<?php
require_once __DIR__ . '/../core/Database.php';

class StudentModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM students ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO students (code, full_name, email, dob) VALUES (:code, :full_name, :email, :dob)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE students SET code = :code, full_name = :full_name, email = :email, dob = :dob WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function validate($data, $id = null) {
        $errors = [];
        if (empty($data['code'])) $errors['code'] = 'Mã SV bắt buộc';
        if (empty($data['full_name'])) $errors['full_name'] = 'Họ tên bắt buộc';
        if (empty($data['email'])) $errors['email'] = 'Email bắt buộc';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email không hợp lệ';

        $sql = "SELECT id FROM students WHERE (code = :code OR email = :email)";
        $params = [':code' => $data['code'], ':email' => $data['email']];
        if ($id) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $errors['duplicate'] = 'Mã SV hoặc Email đã tồn tại';
        }
        return $errors;
    }
}