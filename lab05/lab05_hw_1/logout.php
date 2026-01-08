<?php
// ===============================
// NẠP FILE
// ===============================
require_once 'includes/auth.php';
require_once 'includes/csrf.php';
require_once 'includes/flash.php';

// ===============================
// CHỈ POST
// ===============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

// ===============================
// CSRF
// ===============================
if (!csrf_verify($_POST['csrf'] ?? null)) {
    set_flash('error', 'Phiên không hợp lệ.');
    header('Location: dashboard.php');
    exit;
}

// ===============================
// HỦY SESSION
// ===============================
session_unset();
session_destroy();

// ===============================
// FLASH + REDIRECT
// ===============================
session_start();
set_flash('info', '👋 Bạn đã đăng xuất.');

header('Location: login.php');
exit;
