<?php 
require_once __DIR__ . '/flash.php';
require_once __DIR__ . '/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy thông tin hiển thị (SV hoặc Admin)
$user = $_SESSION['student'] ?? $_SESSION['user'] ?? null;
$displayName = $user['full_name'] ?? $user['username'] ?? 'Khách';
?>
<div class="header">
    <div class="logo">🎓 Student Portal</div>

    <div class="nav-links">
        <a href="/lab05_hw_1/dashboard.php">🏠 Dashboard</a>
        <?php if ($user): ?>
            <a href="/lab05_hw_1/student/profile.php">👤 Hồ sơ</a>
            <a href="/lab05_hw_1/student/courses.php">📚 Học phần</a>
            <a href="/lab05_hw_1/student/registrations.php">📝 Đăng ký</a>
            <a href="/lab05_hw_1/student/grades.php">📊 Bảng điểm</a>

            <?php if (isset($user['role']) && $user['role'] === 'admin'): ?>
                <a href="/lab05_hw_1/admin.php" class="admin-link">🛠 Admin</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="user-menu">
        <?php if ($user): ?>
            <span class="user-info">Chào, <strong><?= htmlspecialchars($displayName) ?></strong></span>
            <form action="/lab05_hw_1/logout.php" method="POST" style="margin:0;">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <button type="submit" class="logout-btn">🚪 Đăng xuất</button>
            </form>
        <?php else: ?>
            <a href="/lab05_hw_1/login.php" class="logout-btn">🔑 Đăng nhập</a>
        <?php endif; ?>
    </div>
</div>

<?php if ($msg = get_flash('success')): ?>
    <div class="flash-success"><span>✅</span> <?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if ($msg = get_flash('error')): ?>
    <div class="flash-error"><span>❌</span> <?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if ($msg = get_flash('info')): ?>
    <div class="flash-info"><span>ℹ️</span> <?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
