<?php
// ===============================
// Khởi động session
// ===============================
session_start();

// ===============================
// Nạp file dùng chung
// ===============================
require_once 'includes/users.php';
require_once 'includes/flash.php';
require_once 'includes/remember.php'; // ⭐ remember token
require_once 'includes/logger.php';   // ⭐ GHI LOG LOGIN

// ===============================
// AUTO LOGIN BẰNG REMEMBER TOKEN
// ===============================
if (!isset($_SESSION['user']) && !empty($_COOKIE['remember_token'])) {

    $tokens = load_tokens();
    $token  = $_COOKIE['remember_token'];

    if (
        isset($tokens[$token]) &&
        $tokens[$token]['expire'] > time() &&
        isset($users[$tokens[$token]['username']])
    ) {
        $_SESSION['user'] = [
            'username' => $tokens[$token]['username'],
            'role'     => $users[$tokens[$token]['username']]['role']
        ];

        header('Location: dashboard.php');
        exit;
    }
}

// ===============================
// Nếu đã login → không cho vào login
// ===============================
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// ===============================
// Biến hiển thị lỗi
// ===============================
$error = '';

// ===============================
// Hàm chống XSS
// ===============================
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ===============================
// XỬ LÝ SUBMIT LOGIN
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiểm tra rỗng
    if ($username === '' || $password === '') {
        $error = '⚠️ Vui lòng nhập đầy đủ tài khoản và mật khẩu.';
    }
    // Kiểm tra tài khoản
    elseif (
        isset($users[$username]) &&
        password_verify($password, $users[$username]['hash'])
    ) {

        // ===============================
        // Lưu session đăng nhập
        // ===============================
        $_SESSION['user'] = [
            'username' => $username,
            'role'     => $users[$username]['role']
        ];

        // ===============================
        // ⭐ GHI LOG ĐĂNG NHẬP (CHUẨN)
        // ===============================
        write_log('login', $username);

        // ⭐ XÓA flash cũ (vd: "Bạn đã đăng xuất")
        unset($_SESSION['flash']);

        // ===============================
        // REMEMBER ME NÂNG CAO (TOKEN)
        // ===============================
        if (!empty($_POST['remember'])) {

            $token  = generate_token();
            $tokens = load_tokens();

            $tokens[$token] = [
                'username' => $username,
                'expire'   => time() + 7 * 24 * 60 * 60
            ];

            save_tokens($tokens);

            setcookie(
                'remember_token',
                $token,
                time() + 7 * 24 * 60 * 60,
                '/',
                '',
                false,
                true // httponly
            );
        }

        // ===============================
        // Flash + redirect
        // ===============================
        set_flash('success', '🎉 Đăng nhập thành công!');
        header('Location: dashboard.php');
        exit;

    } else {
        $error = '❌ Sai tài khoản hoặc mật khẩu.';
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

    <h2>🔐 Đăng nhập Shop Demo</h2>

    <?php if ($error): ?>
        <div class="error"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">

        <label>👤 Username</label>
        <input type="text"
               name="username"
               placeholder="Nhập username"
               required>

        <label>🔑 Password</label>
        <input type="password"
               name="password"
               placeholder="Nhập mật khẩu"
               required>

        <label class="remember">
            <input type="checkbox" name="remember">
            💾 Ghi nhớ đăng nhập
        </label>

        <button type="submit">🚀 Đăng nhập</button>

    </form>
</div>
</div>
</body>
</html>
