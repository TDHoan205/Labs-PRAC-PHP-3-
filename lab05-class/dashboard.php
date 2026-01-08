<?php
/**
 * File: dashboard.php
 * Mục tiêu: Trang bảo vệ, hiển thị session user
 */

include 'require_login.php';

$user = $_SESSION['user'];

function h($s) {
    return htmlspecialchars($s);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
}

.header {
    background: #4e73df;
    color: white;
    padding: 15px 30px;
}

.container {
    padding: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 600px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card h3 {
    margin-top: 0;
}

.menu a {
    display: inline-block;
    margin-right: 15px;
    text-decoration: none;
    color: #4e73df;
    font-weight: bold;
}

.menu a:hover {
    text-decoration: underline;
}

.logout {
    display: inline-block;
    margin-top: 15px;
    color: #e74c3c;
}
</style>
</head>

<body>

<div class="header">
    <h2>📊 Dashboard</h2>
</div>

<div class="container">
    <div class="card">
        <h3>Xin chào <?= h($user['email']) ?></h3>
        <p>🕒 Thời điểm đăng nhập: <?= h($user['login_time']) ?></p>

        <hr>

        <div class="menu">
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a class="logout" href="logout.php">Logout</a>
        </div>
    </div>
</div>

</body>
</html>

