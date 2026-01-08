<?php
require_once '../includes/auth.php';
require_login();
$sv = current_student();
require_once '../includes/header.php';
?>

<h2>👤 Hồ sơ sinh viên</h2>
<ul>
    <li>Mã SV: <?= htmlspecialchars($sv['student_code']) ?></li>
    <li>Họ tên: <?= htmlspecialchars($sv['full_name']) ?></li>
    <li>Email: <?= htmlspecialchars($sv['email']) ?></li>
</ul>

<?php require_once '../includes/footer.php'; ?>
