<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: return_form.php');
    exit;
}

$borrowsFile = __DIR__ . '/data/borrows.json';
$booksFile   = __DIR__ . '/../bai2/data/books.json';

// Lấy dữ liệu
$borrow_id   = trim($_POST['borrow_id'] ?? '');
$member_id   = trim($_POST['member_id'] ?? '');
$book_isbn   = trim($_POST['book_isbn'] ?? '');
$return_date = $_POST['return_date'] ?? '';

// Load dữ liệu
$borrows = file_exists($borrowsFile) ? json_decode(file_get_contents($borrowsFile), true) : [];
$books   = file_exists($booksFile) ? json_decode(file_get_contents($booksFile), true) : [];

$foundIndex = -1;
$error = '';

// 1. Tìm phiếu mượn hợp lệ
foreach ($borrows as $i => $b) {
    // Điều kiện 1: Tìm theo Mã phiếu
    if (!empty($borrow_id) && $b['borrow_id'] === $borrow_id) {
        $foundIndex = $i;
        break;
    }
    // Điều kiện 2: Tìm theo Mã TV + Mã Sách (nếu Mã phiếu rỗng)
    if (empty($borrow_id) && !empty($member_id) && !empty($book_isbn)) {
        if ($b['member_id'] === $member_id && $b['book_isbn'] === $book_isbn && $b['status'] === 'Đang mượn') {
            $foundIndex = $i;
            break;
        }
    }
}

// 2. Kiểm tra lỗi
if ($foundIndex === -1) {
    $error = "Không tìm thấy phiếu mượn hợp lệ hoặc thông tin không khớp.";
} elseif ($borrows[$foundIndex]['status'] !== 'Đang mượn') {
    $error = "Phiếu này đã được trả trước đó rồi.";
} elseif (strtotime($return_date) < strtotime($borrows[$foundIndex]['borrow_date'])) {
    $error = "Ngày trả không thể nhỏ hơn ngày mượn.";
}

if ($error) {
    header("Location: return_form.php?error=" . urlencode($error));
    exit;
}

// 3. Xử lý Trả sách (Nếu không lỗi)
// Cập nhật trạng thái phiếu
$borrows[$foundIndex]['status'] = 'Đã trả';
$borrows[$foundIndex]['return_actual_date'] = $return_date; // Lưu thêm ngày trả thực tế

// Tăng số lượng sách trong kho
$returnedIsbn = $borrows[$foundIndex]['book_isbn'];
foreach ($books as $k => $bk) {
    if ($bk['isbn'] === $returnedIsbn) {
        $books[$k]['quantity']++;
        break;
    }
}

// Lưu file
file_put_contents($borrowsFile, json_encode($borrows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
file_put_contents($booksFile, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

// Hiển thị kết quả
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trả Sách Hoàn Tất</title>
    <style>
        body{font-family:Arial;background:#e6f0ff;padding:20px;}
        .box{background:#cce0ff;padding:20px;border-radius:10px;max-width:500px;margin:0 auto;border:1px solid #99c2ff;}
        h2{color:#003366;text-align:center;}
        table{width:100%;border-collapse:collapse;margin-top:10px;}
        td{padding:8px;border-bottom:1px solid #99c2ff;}
        .btn{display:inline-block;width:45%;text-align:center;background:#3399ff;color:white;padding:10px;text-decoration:none;border-radius:5px;margin-top:15px;}
        .btn-green{background:#28a745;}
    </style>
</head>
<body>
    <div class="box">
        <h2>🎉 Đã Trả Sách Thành Công</h2>
        <table>
            <tr><td>Mã phiếu:</td><td><?= $borrows[$foundIndex]['borrow_id'] ?></td></tr>
            <tr><td>Sách:</td><td><?= $borrows[$foundIndex]['book_title'] ?></td></tr>
            <tr><td>Ngày mượn:</td><td><?= $borrows[$foundIndex]['borrow_date'] ?></td></tr>
            <tr><td>Ngày trả:</td><td><?= $return_date ?></td></tr>
            <tr><td>Trạng thái:</td><td><b>Đã trả</b></td></tr>
        </table>
        <div style="display:flex; justify-content:space-between;">
            <a href="borrow_form.php" class="btn">Mượn tiếp</a>
            <a href="return_form.php" class="btn btn-green">Trả tiếp</a>
        </div>
    </div>
</body>
</html>