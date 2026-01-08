<?php
/**
 * File: login.php
 * Tác giả: <Họ tên SV>
 * Lớp: <Tên lớp>
 * Mục tiêu: Hiển thị form đăng nhập và lỗi nếu có
 */

session_start();

// Nếu đã login thì chuyển dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// Lỗi từ query string
$error = isset($_GET['err']) ? 'Email hoặc mật khẩu không đúng' : '';

// Cookie remember email
$rememberEmail = $_COOKIE['remember_email'] ?? '';

function h($s) {
    return htmlspecialchars($s);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-box {
    background: #fff;
    width: 380px;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.login-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.login-box label {
    font-weight: bold;
    display: block;
    margin-top: 15px;
}

.login-box input {
    width: 360px;
    padding: 10px;
    margin-top: 6px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.login-box input:focus {
    outline: none;
    border-color: #4e73df;
}

.login-box button {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

.login-box button:hover {
    background: #2e59d9;
}

.error {
    background: #ffe0e0;
    color: #c0392b;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🔐 Đăng nhập</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="process_login.php">
        <label>Email</label>
        <input type="text" name="email"
               value="<?= h($rememberEmail) ?>"
               placeholder="admin@example.com">

        <label>Password</label>
        <input type="password" name="password"
               placeholder="******">

        <button type="submit">Đăng nhập</button>
    </form>
</div>

</body>
</html>

