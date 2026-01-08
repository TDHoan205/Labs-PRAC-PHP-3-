<?php
// Nạp file xử lý flash message (hiển thị thông báo 1 lần)
require_once __DIR__ . '/flash.php';

// Bảo đảm đã có session (tránh lỗi khi include)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- CSS dùng chung -->
<link rel="stylesheet" href="assets/style.css">

<!-- ===== HEADER / MENU ===== -->
<div class="header">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="products.php">🛒 Products</a>
    <a href="cart.php">🧺 Cart</a>

    <!-- 🔐 CHỈ ADMIN MỚI THẤY -->
    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="admin.php">🛠 Admin Panel</a>
    <?php endif; ?>

    <!-- 👤 Hiển thị username -->
    <?php if (!empty($_SESSION['user'])): ?>
        <span class="user-info">
            👤 <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </span>
    <?php endif; ?>

    <a href="logout.php">🚪 Logout</a>
</div>

<!-- ===== NỘI DUNG CHÍNH ===== -->
<div class="container">

    <!-- Flash SUCCESS -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="flash-success">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <!-- Flash ERROR -->
    <?php if ($msg = get_flash('error')): ?>
        <div class="flash-error">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <!-- Flash INFO -->
    <?php if ($msg = get_flash('info')): ?>
        <div class="flash-info">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>
