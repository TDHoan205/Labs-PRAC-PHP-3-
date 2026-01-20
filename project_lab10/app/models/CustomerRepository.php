<?php
class CustomerRepository {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM customers ORDER BY id DESC")->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($name, $email, $phone) {
        $stmt = $this->pdo->prepare("INSERT INTO customers (full_name, email, phone) VALUES (?,?,?)");
        return $stmt->execute([$name, $email, $phone]);
    }
    public function update($id, $name, $email, $phone) {
        $stmt = $this->pdo->prepare("UPDATE customers SET full_name=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([$name, $email, $phone, $id]);
    }
}