<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/csrf.php';
require_login();

$student = current_student();
$code    = $student['student_code'];

$enrollments = read_json('enrollments.json', []);
$courses     = read_json('courses.json', []);

// map course_code → course
$map = [];
foreach ($courses as $c) $map[$c['course_code']] = $c;

require_once '../includes/header.php';
?>

<h2>📝 Học phần đã đăng ký</h2>

<?php foreach ($enrollments as $e): ?>
    <?php if ($e['student_code'] === $code): ?>
        <form method="post" action="unregister.php">
            <b><?= htmlspecialchars($map[$e['course_code']]['course_name'] ?? '') ?></b>

            <input type="hidden" name="course_code" value="<?= $e['course_code'] ?>">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <button>Hủy</button>
        </form>
    <?php endif; ?>
<?php endforeach; ?>

<?php require_once '../includes/footer.php'; ?>
