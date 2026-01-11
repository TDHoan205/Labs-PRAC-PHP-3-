<?php

$member_id = $_GET['id'] ?? '';

if (!$member_id) {
    header("Location: register_member.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành công</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .result-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; max-width: 400px; }
        .icon { font-size: 50px; color: #48bb78; margin-bottom: 20px; }
        h2 { color: #2d3748; margin-bottom: 10px; }
        .id-box { background: #edf2f7; border: 2px dashed #cbd5e0; padding: 15px; font-size: 24px; font-weight: bold; color: #1a5cff; margin: 20px 0; letter-spacing: 2px; }
        p { color: #718096; line-height: 1.6; }
        .btn-back { display: inline-block; margin-top: 25px; padding: 10px 20px; background: #1a5cff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="result-card">
    <div class="icon">✔</div>
    <h2>Đăng ký thành công!</h2>
    <p>Chào mừng bạn gia nhập thư viện. Đây là mã số thẻ của bạn:</p>
    
    <div class="id-box">
        <?= htmlspecialchars($member_id) ?>
    </div>

    <p style="font-size: 0.9em; color: #e53e3e;">* Lưu ý: Bạn cần sử dụng mã này để thực hiện mượn sách tại quầy.</p>
    
    <a href="register_member.php" class="btn-back">Đăng ký thêm người mới</a>
    <br><br>
    <a href="../bai3/borrow_form.php" style="color: #666;">➡ Đi đến trang mượn sách</a>
</div>

</body>
</html>