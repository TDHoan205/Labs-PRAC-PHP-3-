<?php
class ProductModel {
    private $conn;

public function __construct() {
    try {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
        $this->conn = new PDO($dsn, $config['username'], $config['password']);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Topic 3: Ghi log lỗi kết nối DB
        require_once __DIR__ . '/../Helpers/Logger.php';
        Logger::log("Lỗi kết nối DB: " . $e->getMessage());

        // Ném lỗi ra để index.php xử lý tiếp
        throw new Exception("Không thể kết nối CSDL");
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