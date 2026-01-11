<?php
require_once 'includes/auth.php';
require_once 'includes/csrf.php';
require_login();
include 'includes/header.php';
?>

<h2>👋 Xin chào <?= htmlspecialchars($_SESSION['user']['username']) ?></h2>
<p>Chào mừng bạn đến hệ thống Shop Demo.</p>

<form method="post" action="logout.php">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button>Đăng xuất</button>
</form>

<?php include 'includes/footer.php'; ?>
