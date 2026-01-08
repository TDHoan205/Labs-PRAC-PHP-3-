<?php
/**
 * File: logout.php
 * Mục tiêu: Hủy session và quay về login
 */

session_start();

// Xóa dữ liệu session
$_SESSION = [];

// Xóa cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy session
session_destroy();

// (Tùy chọn) Xóa remember email
// setcookie('remember_email', '', time()-3600, '/');

header('Location: login.php');
exit;
