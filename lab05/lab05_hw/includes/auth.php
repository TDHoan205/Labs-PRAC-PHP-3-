<?php
// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đã đăng nhập hay chưa
function is_logged_in(): bool {
    return !empty($_SESSION['user']);
}

// Bắt buộc đăng nhập
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
