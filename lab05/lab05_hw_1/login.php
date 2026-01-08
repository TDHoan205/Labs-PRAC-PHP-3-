<?php
session_start();

require_once 'includes/data.php';
require_once 'includes/flash.php';

// Nếu đã login → dashboard
if (!empty($_SESSION['auth'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = trim($_POST['student_code'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if ($code === '' || $pass === '') {
        $error = '⚠️ Vui lòng nhập đầy đủ mã SV và mật khẩu.';
    } else {

        // Đọc JSON sinh viên
        $students = read_json(__DIR__ . '/data/students.json', []);
        $found = null;

        foreach ($students as $s) {
            if (isset($s['student_code']) && strtoupper($s['student_code']) === strtoupper($code)) {
                $found = $s;
                break;
            }
        }

        if ($found && password_verify($pass, $found['password_hash'])) {
            $_SESSION['auth']    = true;
            $_SESSION['student'] = $found;

            set_flash('success', '🎉 Đăng nhập thành công!');
            header('Location: dashboard.php');
            exit;
        } else {
            $error = '❌ Sai mã sinh viên hoặc mật khẩu.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="center-box">
<div class="login-box">

    <h2>🎓 Student Portal</h2>

    <?php if ($error): ?>
        <div class="error"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Mã sinh viên</label>
        <input type="text" name="student_code" value="<?= h($_POST['student_code'] ?? '') ?>" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <button>🚀 Đăng nhập</button>
    </form>

</div>
</div>

</body>
</html>
