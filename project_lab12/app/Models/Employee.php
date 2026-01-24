<?php
require_once __DIR__ . '/../../core/Database.php';
class Employee {
    private $db;
    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = (new Database($config))->getConnection();
    }
    public function getAll($q = '') {
        $sql = "SELECT * FROM employees WHERE full_name LIKE :q OR phone LIKE :q ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $search = "%$q%";
        $stmt->bindParam(':q', $search);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function insert($data) {
        $sql = "INSERT INTO employees (full_name, phone, position, salary) VALUES (:full_name, :phone, :position, :salary)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':position' => $data['position'],
            ':salary' => $data['salary'],
        ]);
    }
    public function findById($id) {
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    public function update($id, $data) {
        $sql = "UPDATE employees SET full_name = :full_name, phone = :phone, position = :position, salary = :salary WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':position' => $data['position'],
            ':salary' => $data['salary'],
            ':id' => $id,
        ]);
    }
    public function delete($id) {
        $sql = "DELETE FROM employees WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function existsPhone($phone, $excludeId = null) {
        $sql = "SELECT id FROM employees WHERE phone = :phone";
        if ($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->db->prepare($sql);
        $params = [':phone' => $phone];
        if ($excludeId) $params[':id'] = $excludeId;
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
}
