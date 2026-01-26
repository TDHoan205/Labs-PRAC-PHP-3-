<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function search($keyword) {
        // Chỉ lấy sản phẩm chưa bị xóa (is_deleted = 0)
        $sql = "SELECT id, code, name, price, created_at FROM products
            WHERE is_deleted = 0
            AND (name LIKE :keyword OR code LIKE :keyword)
            ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $searchParam = '%' . $keyword . '%';
        $stmt->bindValue(':keyword', $searchParam, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function softDelete($id) {
        // UPDATE để xóa mềm, không dùng DELETE
        $sql = "UPDATE products SET is_deleted = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>