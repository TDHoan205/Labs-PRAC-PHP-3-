<?php
require_once 'includes/auth.php';
require_once 'includes/csrf.php';
require_once 'includes/flash.php';
require_once 'includes/logger.php';
require_once 'includes/remember.php';

// Chỉ cho phép POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

// CSRF không hợp lệ
if (!csrf_verify($_POST['csrf'] ?? null)) {
    set_flash('error', 'Phiên đăng nhập không hợp lệ.');
    header('Location: dashboard.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| GHI LOG LOGOUT (PHẢI TRƯỚC session_destroy)
|--------------------------------------------------------------------------
*/
$username = $_SESSION['user']['username'] ?? 'unknown';
write_log('logout', $username);

/*
|--------------------------------------------------------------------------
| XÓA REMEMBER TOKEN NÂNG CAO
|--------------------------------------------------------------------------
*/
if (!empty($_COOKIE['remember_token'])) {
    $tokens = load_tokens();
    $token = $_COOKIE['remember_token'];

    // Xóa token phía server
    if (isset($tokens[$token])) {
        unset($tokens[$token]);
        save_tokens($tokens);
    }

    // Xóa cookie phía client
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);
}

/*
|--------------------------------------------------------------------------
| GIỮ TƯƠNG THÍCH: XÓA COOKIE CŨ (nếu còn)
|--------------------------------------------------------------------------
*/
setcookie('remember_username', '', time() - 3600, '/');

/*
|--------------------------------------------------------------------------
| HỦY SESSION
|--------------------------------------------------------------------------
*/
session_unset();
session_destroy();

/*
|--------------------------------------------------------------------------
| TẠO SESSION MỚI ĐỂ DÙNG FLASH
|--------------------------------------------------------------------------
*/
session_start();
set_flash('info', '👋 Bạn đã đăng xuất.');

// Quay về login
header('Location: login.php');
exit;
