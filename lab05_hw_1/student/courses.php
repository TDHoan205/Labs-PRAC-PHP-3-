<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/csrf.php';
require_login();
$courses = read_json('courses.json', []);
require_once '../includes/header.php';
?>

<h2>📚 Danh sách học phần</h2>

<?php foreach ($courses as $c): ?>
<form method="post" action="register.php" class="card">
    <b><?= htmlspecialchars($c['course_name']) ?></b>
    (<?= $c['credits'] ?> tín chỉ)

    <input type="hidden" name="course_code" value="<?= $c['course_code'] ?>">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button>Đăng ký</button>
</form>
<?php endforeach; ?>

<?php require_once '../includes/footer.php'; ?>
