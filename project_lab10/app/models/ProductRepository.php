<?php
class ProductRepository {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function getAll($kw = '') {
        $sql = "SELECT * FROM products WHERE name LIKE ? OR sku LIKE ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$kw%", "%$kw%"]);
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($name, $sku, $price, $stock) {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, sku, price, stock) VALUES (?,?,?,?)");
        return $stmt->execute([$name, $sku, $price, $stock]);
    }
    public function update($id, $name, $sku, $price, $stock) {
        $stmt = $this->pdo->prepare("UPDATE products SET name=?, sku=?, price=?, stock=? WHERE id=?");
        return $stmt->execute([$name, $sku, $price, $stock, $id]);
    }
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id=?");
        return $stmt->execute([$id]);
    }
}