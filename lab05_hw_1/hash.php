<?php
// hash.php
// Tạo hash thực cho mật khẩu sinh viên, ví dụ "123456"

$password = "123456";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Mật khẩu: $password\n";
echo "Hash: $hash\n";
