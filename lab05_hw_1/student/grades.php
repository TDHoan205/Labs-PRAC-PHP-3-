<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_login();

$student = current_student();
$code    = $student['student_code'];

$grades  = read_json('grades.json', []);
$courses = read_json('courses.json', []);

// map course_code
$map = [];
foreach ($courses as $c) $map[$c['course_code']] = $c;

require_once '../includes/header.php';
?>

<h2>📊 Bảng điểm</h2>

<table>
    <tr>
        <th>Học phần</th>
        <th>Giữa kỳ</th>
        <th>Cuối kỳ</th>
        <th>Tổng</th>
    </tr>

<?php foreach ($grades as $g): ?>
    <?php if ($g['student_code'] === $code): ?>
    <tr>
        <td><?= htmlspecialchars($map[$g['course_code']]['course_name'] ?? '') ?></td>
        <td><?= $g['midterm'] ?></td>
        <td><?= $g['final'] ?></td>
        <td><?= $g['total'] ?></td>
    </tr>
    <?php endif; ?>
<?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>
