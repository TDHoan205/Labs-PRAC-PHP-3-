<?php
require_once __DIR__ . '/../core/Database.php';

class BookModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM books ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO books (isbn, title, author, category, quantity) VALUES (:isbn, :title, :author, :category, :quantity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE books SET isbn = :isbn, title = :title, author = :author, category = :category, quantity = :quantity WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function validate($data, $id = null) {
        $errors = [];
        if (empty($data['isbn'])) $errors['isbn'] = 'ISBN bắt buộc';
        if (empty($data['title'])) $errors['title'] = 'Tiêu đề bắt buộc';
        if (empty($data['author'])) $errors['author'] = 'Tác giả bắt buộc';
        if (!isset($data['quantity']) || $data['quantity'] < 0) $errors['quantity'] = 'Số lượng ≥ 0';

        $sql = "SELECT id FROM books WHERE isbn = :isbn";
        $params = [':isbn' => $data['isbn']];
        if ($id) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $errors['duplicate'] = 'ISBN đã tồn tại';
        }
        return $errors;
    }
}