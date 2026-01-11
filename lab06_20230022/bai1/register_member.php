<?php
$name = $email = $phone = $dob = $gender = $address = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $dob     = trim($_POST['dob'] ?? '');
    $gender  = $_POST['gender'] ?? 'Khác';
    $address = trim($_POST['address'] ?? '');

    // 1. Validate dữ liệu
    if ($name === '')  $errors[] = "Họ tên là bắt buộc.";
    if ($email === '') $errors[] = "Email là bắt buộc.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";

    if ($phone === '') $errors[] = "Số điện thoại là bắt buộc.";
    elseif (!preg_match('/^\d{9,11}$/', $phone)) $errors[] = "Số điện thoại phải từ 9–11 chữ số.";

    if ($dob === '') $errors[] = "Ngày sinh là bắt buộc.";

    // 2. Xử lý lưu dữ liệu
    if (empty($errors)) {
        $dataDir = __DIR__ . '/data';
        if (!is_dir($dataDir)) mkdir($dataDir, 0777, true);
        
        $file = $dataDir . '/members.csv';

        // --- Tự động sinh Mã thẻ thư viện (TVxxx) ---
        $member_id = 'TV001';
        if (file_exists($file)) {
            $rows = array_map('str_getcsv', file($file));
            if (!empty($rows)) {
                $lastRow = end($rows);
                $lastId = $lastRow[0]; // Cột đầu tiên là ID
                $lastNum = (int)substr($lastId, 2);
                $member_id = 'TV' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
            }
        }

        // --- Ghi vào file CSV ---
        $fp = fopen($file, 'a');
        fputcsv($fp, [$member_id, $name, $email, $phone, $dob, $gender, $address]);
        fclose($fp);

        // Chuyển hướng sang trang kết quả
        header('Location: member_result.php?id=' . urlencode($member_id));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thẻ thư viện</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 40px; }
        .form-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h2 { color: #1a5cff; text-align: center; margin-bottom: 25px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #444; }
        input[type=text], input[type=email], input[type=date], textarea { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .gender-group { margin-bottom: 20px; }
        .gender-group input { margin-right: 5px; }
        .btn-group { display: flex; gap: 10px; }
        input[type=submit] { background: #1a5cff; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; flex: 2; font-weight: bold; }
        input[type=reset] { background: #e2e8f0; color: #4a5568; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; flex: 1; }
        .errors { background: #fff5f5; border-left: 4px solid #f56565; color: #c53030; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>📋 Đăng Ký Thẻ Thư Viện</h2>

    <?php if ($errors): ?>
        <div class="errors">
            <ul style="margin:0; padding-left:20px;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Họ và tên *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Nguyễn Văn A">

        <label>Email *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="name@example.com">

        <label>Số điện thoại *</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" placeholder="09xxxxxxxx">

        <label>Ngày sinh *</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($dob) ?>">

        <label>Giới tính</label>
        <div class="gender-group">
            <input type="radio" name="gender" value="Nam" <?= $gender==='Nam'?'checked':'' ?>> Nam
            <input type="radio" name="gender" value="Nữ" <?= $gender==='Nữ'?'checked':'' ?>> Nữ
            <input type="radio" name="gender" value="Khác" <?= $gender==='Khác'?'checked':'' ?>> Khác
        </div>

        <label>Địa chỉ</label>
        <textarea name="address" rows="3" placeholder="Nhập địa chỉ cư trú..."><?= htmlspecialchars($address) ?></textarea>

        <div class="btn-group">
            <input type="submit" value="Đăng ký ngay">
            <input type="reset" value="Xóa form">
        </div>
    </form>
</div>

</body>
</html>