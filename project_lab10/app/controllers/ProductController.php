<?php
require_once __DIR__ . '/../models/ProductRepository.php';

class ProductController {
    private $repo;
    public function __construct($pdo) { $this->repo = new ProductRepository($pdo); }

    public function index() {
        $kw = $_GET['kw'] ?? '';
        $products = $this->repo->getAll($kw);
        require __DIR__ . '/../views/products/index.php';
    }
    public function create() { require __DIR__ . '/../views/products/create.php'; }
    public function store() {
        $name = $_POST['name']; $sku = $_POST['sku'];
        $price = (float)$_POST['price']; $stock = (int)$_POST['stock'];
        if ($price < 0 || $stock < 0) {
            $error = "Lỗi: Giá và số lượng phải >= 0!";
            require __DIR__ . '/../views/products/create.php';
            return;
        }
        $this->repo->create($name, $sku, $price, $stock);
        header('Location: index.php?c=products');
    }
    public function edit() {
        $product = $this->repo->getById($_GET['id']);
        require __DIR__ . '/../views/products/edit.php';
    }
    public function update() {
        $id = $_POST['id']; $name = $_POST['name']; $sku = $_POST['sku'];
        $price = (float)$_POST['price']; $stock = (int)$_POST['stock'];
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
        $this->repo->delete($_POST['id']);
        header('Location: index.php?c=products');
    }
}