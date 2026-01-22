<?php
// Khởi động session để dùng Flash Message
session_start();

// -----------------------------------------------------------
// 1. LOAD CÁC FILE HỆ THỐNG
// -----------------------------------------------------------
// Sử dụng __DIR__ để đường dẫn luôn chính xác
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';

// -----------------------------------------------------------
// 2. LOAD MODEL VÀ CONTROLLER (Topic 2: Employees)
// -----------------------------------------------------------
require_once __DIR__ . '/../app/models/EmployeeModel.php';
require_once __DIR__ . '/../app/controllers/EmployeesController.php';

// -----------------------------------------------------------
// 3. KHỞI TẠO ĐỐI TƯỢNG
// -----------------------------------------------------------
// Lấy biến kết nối PDO từ file db.php
// (Giả định db.php gán biến $pdo vào $GLOBALS hoặc return biến đó)
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : null;

if (!$pdo) {
    die("Lỗi: Không tìm thấy kết nối Database trong index.php. Kiểm tra lại file db.php");
}

$router = new Router();
$employeesController = new EmployeesController($pdo);

// -----------------------------------------------------------
// 4. ĐỊNH NGHĨA ROUTES (Đường dẫn)
// -----------------------------------------------------------

// Route 1: Trang danh sách (Trang chủ)
$router->add('/employees', [$employeesController, 'index']);

// Route 2: Trang thêm mới
$router->add('/employees/create', [$employeesController, 'create']);

// Route 3: Trang sửa (Dùng hàm nặc danh để kiểm tra ID trước)
$router->add('/employees/edit', function() use ($employeesController) {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $employeesController->edit($id);
    } else {
        // Nếu không có ID, báo lỗi và quay về
        $_SESSION['flash'] = 'ID không hợp lệ.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: ' . url('employees'));
        exit;
    }
});

// Route 4: Trang xóa
$router->add('/employees/delete', function() use ($employeesController) {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $employeesController->delete($id);
    } else {
        $_SESSION['flash'] = 'ID không hợp lệ.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: ' . url('employees'));
        exit;
    }
});

// -----------------------------------------------------------
// 5. CHẠY ỨNG DỤNG
// -----------------------------------------------------------
// Truyền toàn bộ URL hiện tại vào Router để xử lý
$router->dispatch($_SERVER['REQUEST_URI']);