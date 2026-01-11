<?php
// ===============================
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';
// ===============================
require_login();

// ===============================
// CHỈ POST + CSRF
// ===============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? null)) {
    http_response_code(400);
    exit('Bad Request');
}

$student = current_student();
$code    = $student['student_code'];
$course  = trim($_POST['course_code'] ?? '');

// ===============================
// KIỂM TRA TRÙNG
// ===============================
$enrollments = read_json('enrollments.json', []);

foreach ($enrollments as $e) {
    if ($e['student_code'] === $code && $e['course_code'] === $course) {
        set_flash('error', '❌ Bạn đã đăng ký học phần này.');
        header('Location: courses.php');
        exit;
    }
}

// ===============================
// LƯU ĐĂNG KÝ
// ===============================
$enrollments[] = [
    'student_code' => $code,
    'course_code'  => $course,
    'created_at'   => date('Y-m-d H:i:s')
];

write_json('enrollments.json', $enrollments);

set_flash('success', '✅ Đăng ký học phần thành công!');
header('Location: registrations.php');
exit;
