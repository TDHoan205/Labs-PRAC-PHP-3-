<?php
class ProductModel {
    private $conn;

    public function __construct() {
        $config = require __DIR__ . '/../../config/db.php';
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            $this->conn = new PDO($dsn, $config['username'], $config['password']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối DB: " . $e->getMessage());
        }
    }

    // Đếm tổng số bản ghi (Cho Pagination)
    public function countAll() {
        return $this->conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }

    // Lấy danh sách có phân trang
    public function getPaginated($limit, $offset) {
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $sql = "INSERT INTO products (name, price, description, image) VALUES (:name, :price, :desc, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'], 'price' => $data['price'],
            'desc' => $data['description'], 'image' => $data['image']
        ]);
    }

    public function update($data) {
        $sql = "UPDATE products SET name=:name, price=:price, description=:desc, image=:image WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'], 'price' => $data['price'],
            'desc' => $data['description'], 'image' => $data['image'], 'id' => $data['id']
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}