<?php
require_once 'includes/auth.php';
require_login();

if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('⛔ Admin only');
}

require_once 'includes/header.php';
?>

<h2>🛠 Admin Panel</h2>
<ul>
    <li>📊 Quản lý hệ thống</li>
    <li>👤 Quản lý sinh viên</li>
    <li>🧾 Xem log đăng nhập</li>
</ul>

<?php require_once 'includes/footer.php'; ?>
