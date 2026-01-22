<?php
require_once __DIR__ . '/../models/ProductRepository.php';

class ProductController {
    private $repo;
    public function __construct($pdo) { $this->repo = new ProductRepository($pdo); }

    public function index() {
        $kw = trim($_GET['kw'] ?? '');
        $products = $this->repo->getAll($kw);
        require __DIR__ . '/../views/products/index.php';
    }
    public function create() { require __DIR__ . '/../views/products/create.php'; }
    public function store() {
        $name = trim($_POST['name'] ?? '');
        $sku = strtoupper(trim($_POST['sku'] ?? ''));
        $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
        $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
        if ($name === '' || $sku === '') {
            $error = "Vui lòng nhập tên và SKU.";
            require __DIR__ . '/../views/products/create.php';
            return;
        }
        if ($price < 0 || $stock < 0) {
            $error = "Lỗi: Giá và số lượng phải >= 0!";
            require __DIR__ . '/../views/products/create.php';
            return;
        }
        $this->repo->create($name, $sku, $price, $stock);
        header('Location: index.php?c=products');
    }
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $error = "Thiếu mã sản phẩm.";
            $products = $this->repo->getAll();
            require __DIR__ . '/../views/products/index.php';
            return;
        }
        $product = $this->repo->getById($id);
        if (!$product) {
            $error = "Không tìm thấy sản phẩm.";
            $products = $this->repo->getAll();
            require __DIR__ . '/../views/products/index.php';
            return;
        }
        require __DIR__ . '/../views/products/edit.php';
    }
    public function update() {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $sku = strtoupper(trim($_POST['sku'] ?? ''));
        $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
        $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
        if (!$id) {
            $error = "Thiếu mã sản phẩm.";
            $products = $this->repo->getAll();
            require __DIR__ . '/../views/products/index.php';
            return;
        }
        if ($name === '' || $sku === '') {
            $error = "Vui lòng nhập tên và SKU.";
            $product = ['id'=>$id, 'name'=>$name, 'sku'=>$sku, 'price'=>$price, 'stock'=>$stock];
            require __DIR__ . '/../views/products/edit.php';
            return;
        }
        if ($price < 0 || $stock < 0) {
            $error = "Lỗi: Giá và số lượng phải >= 0!";
            $product = ['id'=>$id, 'name'=>$name, 'sku'=>$sku, 'price'=>$price, 'stock'=>$stock];
            require __DIR__ . '/../views/products/edit.php';
            return;
        }
        $this->repo->update($id, $name, $sku, $price, $stock);
        header('Location: index.php?c=products');
    }
    public function delete() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->repo->delete($id);
        }
        header('Location: index.php?c=products');
    }
}