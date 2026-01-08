<?php
require_once 'includes/auth.php';

// Bắt buộc đăng nhập
require_login();

// Kiểm tra quyền admin
if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('⛔ Access denied – Admin only');
}

include 'includes/header.php';
?>

<h2>🛠 Admin Panel</h2>

<p>Chỉ tài khoản <b>admin</b> mới thấy trang này.</p>

<ul>
    <li>📊 Quản lý hệ thống</li>
    <li>👤 Quản lý user</li>
    <li>🧾 Xem log login / logout</li>
</ul>

<?php include 'includes/footer.php'; ?>
