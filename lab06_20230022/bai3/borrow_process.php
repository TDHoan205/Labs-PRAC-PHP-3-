<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: borrow_form.php');
    exit;
}

// 1. Khai báo đường dẫn
$membersFile = __DIR__ . '/../bai1/data/members.csv';
$booksFile   = __DIR__ . '/../bai2/data/books.json';
$borrowsFile = __DIR__ . '/data/borrows.json';

// 2. Lấy dữ liệu Input
$member_id   = trim($_POST['member_id'] ?? '');
$book_isbn   = trim($_POST['book_isbn'] ?? '');
$borrow_date = $_POST['borrow_date'] ?? '';
$days        = (int)($_POST['days'] ?? 0);

$errors = [];

// 3. Đọc dữ liệu nguồn
// --- Đọc Members (CSV không tiêu đề) ---
$members = [];
if (file_exists($membersFile)) {
    $members = array_map('str_getcsv', file($membersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
}

// --- Đọc Books ---
$books = file_exists($booksFile) ? json_decode(file_get_contents($booksFile), true) : [];

// 4. Validate dữ liệu
// 4a. Kiểm tra thành viên tồn tại
$memberExists = false;
$memberName = '';
foreach ($members as $m) {
    // Cột 0 là ID, Cột 1 là Tên
    if (isset($m[0]) && strtoupper($m[0]) === strtoupper($member_id)) {
        $memberExists = true;
        $memberName = $m[1] ?? 'Không tên';
        break;
    }
}
if (!$memberExists) {
    $errors[] = "Mã thành viên '$member_id' không tồn tại.";
}

// 4b. Kiểm tra sách tồn tại và còn hàng
$bookIndex = -1;
$bookTitle = '';
foreach ($books as $index => $b) {
    if ($b['isbn'] === $book_isbn) {
        $bookIndex = $index;
        $bookTitle = $b['title'];
        break;
    }
}

if ($bookIndex === -1) {
    $errors[] = "Sách không tồn tại.";
} elseif ($books[$bookIndex]['quantity'] <= 0) {
    $errors[] = "Sách '$bookTitle' đã hết hàng.";
}

// 4c. Kiểm tra ngày
if ($days < 1 || $days > 30) {
    $errors[] = "Số ngày mượn không hợp lệ (1-30 ngày).";
}

// 4d. Kiểm tra chưa trả sách cũ (Tránh mượn chồng chéo cùng 1 cuốn)
$borrows = file_exists($borrowsFile) ? json_decode(file_get_contents($borrowsFile), true) : [];
foreach ($borrows as $br) {
    if ($br['member_id'] === $member_id && $br['book_isbn'] === $book_isbn && $br['status'] === 'Đang mượn') {
        $errors[] = "Thành viên đang mượn cuốn này chưa trả.";
        break;
    }
}

// 5. Xử lý Lỗi hoặc Thành công
if (!empty($errors)) {
    // Quay lại form và báo lỗi đầu tiên tìm thấy
    $msg = urlencode($errors[0]);
    header("Location: borrow_form.php?error=$msg");
    exit;
} else {
    // --- THÀNH CÔNG ---
    
    // Tạo thư mục data nếu chưa có
    if (!is_dir(__DIR__ . '/data')) mkdir(__DIR__ . '/data', 0777, true);

    $borrow_id = 'PH' . time();
    $due_date = date('Y-m-d', strtotime("$borrow_date +$days days"));

    // Thêm bản ghi mượn
    $newBorrow = [
        'borrow_id'   => $borrow_id,
        'member_id'   => $member_id,
        'member_name' => $memberName,
        'book_isbn'   => $book_isbn,
        'book_title'  => $bookTitle,
        'borrow_date' => $borrow_date,
        'due_date'    => $due_date,
        'status'      => 'Đang mượn'
    ];
    $borrows[] = $newBorrow;
    file_put_contents($borrowsFile, json_encode($borrows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

    // Trừ tồn kho sách
    $books[$bookIndex]['quantity']--;
    file_put_contents($booksFile, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

    // Hiển thị thông báo thành công (HTML ngay tại đây cho tiện)
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Thành công</title>
        <style>
            body{font-family:Arial;background:#e6f0ff;padding:20px;}
            .box{background:#cce0ff;padding:20px;border-radius:10px;max-width:500px;margin:0 auto;border:1px solid #99c2ff;}
            h2{color:#003366;text-align:center;}
            table{width:100%;border-collapse:collapse;margin-top:10px;}
            td{padding:8px;border-bottom:1px solid #99c2ff;}
            .btn{display:block;width:100%;text-align:center;background:#3399ff;color:white;padding:10px;text-decoration:none;border-radius:5px;margin-top:15px;}
        </style>
    </head>
    <body>
        <div class="box">
            <h2>✅ Mượn Sách Thành Công</h2>
            <table>
                <tr><td>Mã phiếu:</td><td><b><?= $borrow_id ?></b></td></tr>
                <tr><td>Người mượn:</td><td><?= $memberName ?> (<?= $member_id ?>)</td></tr>
                <tr><td>Sách:</td><td><?= $bookTitle ?></td></tr>
                <tr><td>Hạn trả:</td><td><?= $due_date ?></td></tr>
            </table>
            <a href="borrow_form.php" class="btn">Tiếp tục mượn</a>
        </div>
    </body>
    </html>
    <?php
}
?>