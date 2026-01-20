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
        $name = $_POST['full_name']; $email = $_POST['email']; $phone = $_POST['phone'];
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
        $customer = $this->repo->getById($_GET['id']);
        require __DIR__ . '/../views/customers/edit.php';
    }
    public function update() {
        $this->repo->update($_POST['id'], $_POST['full_name'], $_POST['email'], $_POST['phone']);
        header('Location: index.php?c=customers');
    }
}