<?php
require_once __DIR__ . '/../models/CustomerRepository.php';

class CustomerController {
    private $repo;
    public function __construct($pdo) { $this->repo = new CustomerRepository($pdo); }

    public function index() {
        $customers = $this->repo->getAll();
        require __DIR__ . '/../views/customers/index.php';
    }
    public function create() { require __DIR__ . '/../views/customers/create.php'; }
    public function store() {
        $name = trim($_POST['full_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $phone = trim($_POST['phone'] ?? '');

        if ($name === '' || $email === '') {
            $error = "Họ tên và email là bắt buộc.";
            require __DIR__ . '/../views/customers/create.php';
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email không hợp lệ!";
            require __DIR__ . '/../views/customers/create.php';
            return;
        }
        try {
            $this->repo->create($name, $email, $phone);
            header('Location: index.php?c=customers');
        } catch (PDOException $e) {
            $error = "Email đã tồn tại.";
            require __DIR__ . '/../views/customers/create.php';
        }
    }
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $error = "Thiếu mã khách hàng.";
            $customers = $this->repo->getAll();
            require __DIR__ . '/../views/customers/index.php';
            return;
        }
        $customer = $this->repo->getById($id);
        if (!$customer) {
            $error = "Không tìm thấy khách hàng.";
            $customers = $this->repo->getAll();
            require __DIR__ . '/../views/customers/index.php';
            return;
        }
        require __DIR__ . '/../views/customers/edit.php';
    }
    public function update() {
        $id = $_POST['id'] ?? null;

        $name = trim($_POST['full_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $phone = trim($_POST['phone'] ?? '');

        if (!$id) {
            $error = "Thiếu mã khách hàng.";
            $customers = $this->repo->getAll();
            require __DIR__ . '/../views/customers/index.php';
            return;
        }
        if ($name === '' || $email === '') {
            $error = "Họ tên và email là bắt buộc.";
            $customer = $this->repo->getById($id);
            require __DIR__ . '/../views/customers/edit.php';
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email không hợp lệ!";
            $customer = ['id' => $id, 'full_name' => $name, 'email' => $email, 'phone' => $phone];
            require __DIR__ . '/../views/customers/edit.php';
            return;
        }

        $this->repo->update($id, $name, $email, $phone);
        header('Location: index.php?c=customers');
    }
}