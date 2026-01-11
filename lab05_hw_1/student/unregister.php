<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? null)) {
    http_response_code(400);
    exit('Bad Request');
}

$student = current_student();
$code    = $student['student_code'];
$course  = trim($_POST['course_code'] ?? '');

// ===============================
// NẾU ĐÃ CÓ ĐIỂM → KHÔNG HỦY
// ===============================
$grades = read_json('grades.json', []);
foreach ($grades as $g) {
    if ($g['student_code'] === $code && $g['course_code'] === $course) {
        set_flash('error', '❌ Không thể hủy: học phần đã có điểm.');
        header('Location: registrations.php');
        exit;
    }
}

// ===============================
// XÓA ĐĂNG KÝ
// ===============================
$enrollments = read_json('enrollments.json', []);
$enrollments = array_values(array_filter(
    $enrollments,
    fn($e) => !($e['student_code'] === $code && $e['course_code'] === $course)
));

write_json('enrollments.json', $enrollments);

set_flash('info', '🗑️ Đã hủy đăng ký học phần.');
header('Location: registrations.php');
exit;
