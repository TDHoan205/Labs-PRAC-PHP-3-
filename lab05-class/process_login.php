<?php
/**
 * File: process_login.php
 * Mục tiêu: Kiểm tra login, tạo session, redirect
 */

session_start();

// Lấy dữ liệu POST
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Kiểm tra rỗng
if ($email === '' || $password === '') {
    header('Location: login.php?err=1');
    exit;
}

// Tài khoản demo
$demoEmail = 'admin@example.com';
$demoPassword = '123456';

// Kiểm tra thông tin
if ($email === $demoEmail && $password === $demoPassword) {

    // Tạo session user
    $_SESSION['user'] = [
        'email' => $email,
        'role'  => 'admin',
        'login_time' => date('Y-m-d H:i:s')
    ];

    // Remember email 7 ngày
    setcookie(
        'remember_email',
        $email,
        time() + 7 * 24 * 60 * 60,
        '/'
    );

    header('Location: dashboard.php');
    exit;
}

// Sai thông tin
header('Location: login.php?err=1');
exit;
