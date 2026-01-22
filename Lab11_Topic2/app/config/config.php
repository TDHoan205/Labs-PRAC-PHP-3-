<?php
// Tự động lấy đường dẫn thư mục gốc (Base URL)
// Giúp chạy được dù bạn đặt tên thư mục là gì (Lab11, ProjectA,...)

// 1. Xác định giao thức (http hoặc https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// 2. Lấy host (localhost)
$host = $_SERVER['HTTP_HOST'];

// 3. Lấy thư mục chứa file index.php đang chạy
$scriptDir = dirname($_SERVER['SCRIPT_NAME']); 

// 4. Xử lý dấu gạch chéo (Windows dùng \, Linux dùng /)
$scriptDir = str_replace('\\', '/', $scriptDir);
$scriptDir = rtrim($scriptDir, '/'); // Xóa dấu / ở cuối nếu có

// 5. Định nghĩa hằng số BASE_URL
define('BASE_URL', $protocol . '://' . $host . $scriptDir);

// Hàm hỗ trợ tạo link trong View
function url($path = '') {
    if (empty($path)) {
        return BASE_URL;
    }
    // Đảm bảo không bị dư dấu /
    return BASE_URL . '/' . ltrim($path, '/');
}