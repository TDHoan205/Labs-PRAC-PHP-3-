<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả đăng ký</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; list-style-type: disc; margin-left: 20px; }
        .success-table { border-collapse: collapse; width: 50%; }
        .success-table td, .success-table th { border: 1px solid #ddd; padding: 8px; }
        .success-table th { background-color: #f2f2f2; text-align: left; }
        .btn-back { display: inline-block; margin-top: 20px; text-decoration: none; padding: 10px 15px; background: #eee; color: #333; border: 1px solid #ccc; }
    </style>
</head>
<body>

<?php
/**
 * Hàm hỗ trợ escape dữ liệu để chống XSS
 */
function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// BƯỚC 1: Chặn truy cập trực tiếp
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h3>Lỗi: Bạn chưa submit form.</h3>";
    echo "<a href='form.php' class='btn-back'>Quay lại Form</a>";
    exit; // Dừng kịch bản ngay lập tức
}

// BƯỚC 2: Đọc dữ liệu an toàn
// Dùng toán tử ?? (Null Coalescing) để gán giá trị mặc định nếu field không tồn tại
$fullName = trim($_POST['full_name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$age      = trim($_POST['age'] ?? '');
$gender   = $_POST['gender'] ?? '';
$hobbies  = $_POST['hobbies'] ?? []; // Mặc định là mảng rỗng
$notes    = trim($_POST['notes'] ?? '');

// BƯỚC 3: Validate dữ liệu
$errors = [];

// 3.1 Kiểm tra Họ tên
if ($fullName === '') {
    $errors[] = 'Họ tên không được để trống.';
}

// 3.2 Kiểm tra Email
if ($email === '') {
    $errors[] = 'Email không được để trống.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Định dạng Email không hợp lệ.';
}

// 3.3 Kiểm tra Tuổi
if ($age === '') {
    $errors[] = 'Tuổi không được để trống.';
} elseif (!is_numeric($age)) {
    $errors[] = 'Tuổi phải là một số.';
} else {
    // Ép kiểu sang số nguyên để so sánh
    $ageInt = (int)$age;
    if ($ageInt < 10 || $ageInt > 80) {
        $errors[] = 'Tuổi phải nằm trong khoảng từ 10 đến 80.';
    }
}

// 3.4 Kiểm tra Giới tính (phòng trường hợp user hack html xóa radio)
if ($gender === '') {
    $errors[] = 'Vui lòng chọn giới tính.';
}

// BƯỚC 4 & 5: Hiển thị kết quả
if (!empty($errors)) {
    // === TRƯỜNG HỢP CÓ LỖI ===
    echo "<h3>Đã xảy ra lỗi nhập liệu:</h3>";
    echo "<ul class='error'>";
    foreach ($errors as $err) {
        echo "<li>" . escape($err) . "</li>";
    }
    echo "</ul>";
    
    // Mẹo nhỏ: Dùng javascript:history.back() để quay lại mà vẫn giữ dữ liệu cũ (Sticky Form giả lập)
    echo "<a href='javascript:history.back()' class='btn-back'>&laquo; Quay lại sửa (Giữ dữ liệu)</a>";
    // Hoặc link cứng theo yêu cầu cơ bản:
    // echo "<br><a href='form.php' class='btn-back'>Nhập lại từ đầu</a>";

} else {
    // === TRƯỜNG HỢP HỢP LỆ ===
    echo "<h3>Đăng ký thành công!</h3>";
    echo "<p>Dưới đây là thông tin bạn đã nhập:</p>";

    echo "<table class='success-table'>";
    
    echo "<tr><th>Họ tên</th><td>" . escape($fullName) . "</td></tr>";
    echo "<tr><th>Email</th><td>" . escape($email) . "</td></tr>";
    echo "<tr><th>Tuổi</th><td>" . escape($age) . "</td></tr>";
    echo "<tr><th>Giới tính</th><td>" . escape($gender) . "</td></tr>";
    
    // Xử lý sở thích (Mảng -> Chuỗi)
    $hobbiesStr = empty($hobbies) ? 'Không có' : implode(", ", $hobbies);
    echo "<tr><th>Sở thích</th><td>" . escape($hobbiesStr) . "</td></tr>";
    
    // Xử lý ghi chú (Cho phép xuống dòng hiển thị đúng)
    echo "<tr><th>Ghi chú</th><td>" . nl2br(escape($notes)) . "</td></tr>";
    
    echo "</table>";

    echo "<br><a href='form.php' class='btn-back'>Nhập lại form mới</a>";
}
?>

</body>
</html>