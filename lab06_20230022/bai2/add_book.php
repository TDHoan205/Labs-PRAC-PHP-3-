<?php

$errors = [];
$isbn = $title = $author = $year = $category = '';
$quantity = '';
$categories = ['Giáo trình', 'Kỹ năng', 'Văn học', 'Khoa học', 'Khác'];

// Đường dẫn file data (Lưu ý: để thư mục data nằm trong bai2)
$dataDir = __DIR__ . '/data'; 
$booksFile = $dataDir . '/books.json';

// 1. Đọc dữ liệu cũ để kiểm tra trùng mã
$books = [];
if (file_exists($booksFile)) {
    $jsonContent = file_get_contents($booksFile);
    $books = json_decode($jsonContent, true) ?? [];
}

// 2. Xử lý khi Submit Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy và làm sạch dữ liệu
    $isbn     = trim($_POST['isbn'] ?? '');
    $title    = trim($_POST['title'] ?? '');
    $author   = trim($_POST['author'] ?? '');
    $year     = (int)($_POST['year'] ?? 0);
    $category = $_POST['category'] ?? '';
    // Ép kiểu số nguyên cho số lượng
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : -1;

    // --- Validate dữ liệu ---
    if ($isbn === '')   $errors[] = "Mã sách (ISBN) là bắt buộc.";
    if ($title === '')  $errors[] = "Tên sách là bắt buộc.";
    if ($author === '') $errors[] = "Tác giả là bắt buộc.";

    $currentYear = date('Y');
    if ($year < 1900 || $year > $currentYear) {
        $errors[] = "Năm xuất bản phải từ 1900 đến $currentYear.";
    }

    if (!in_array($category, $categories)) {
        $errors[] = "Thể loại không hợp lệ.";
    }

    if ($quantity < 0) {
        $errors[] = "Số lượng sách phải lớn hơn hoặc bằng 0.";
    }

    // --- Kiểm tra trùng mã ISBN ---
    foreach ($books as $b) {
        if ($b['isbn'] === $isbn) {
            $errors[] = "Mã sách '$isbn' đã tồn tại trong hệ thống.";
            break;
        }
    }

    // --- Lưu dữ liệu nếu không có lỗi ---
    if (empty($errors)) {
        // Tạo thư mục data nếu chưa có
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        // Thêm sách mới vào mảng
        $books[] = [
            'isbn'     => $isbn,
            'title'    => $title,
            'author'   => $author,
            'year'     => $year,
            'category' => $category,
            'quantity' => $quantity
        ];

        // Ghi vào file JSON (LOCK_EX để tránh xung đột khi ghi)
        file_put_contents(
            $booksFile, 
            json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 
            LOCK_EX
        );

        // Chuyển hướng về trang danh sách
        header("Location: list_books.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sách mới</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e6f0ff; padding: 20px; }
        h2 { color: #003366; }
        form { background: #cce0ff; padding: 20px; border-radius: 10px; max-width: 500px; border: 1px solid #99c2ff; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input[type=text], input[type=number], select { width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #99c2ff; box-sizing: border-box; }
        .btn-group { margin-top: 20px; }
        input[type=submit], input[type=reset] { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; color: #fff; font-weight: bold; }
        input[type=submit] { background: #3399ff; }
        input[type=submit]:hover { background: #0066cc; }
        input[type=reset] { background: #999; margin-left: 10px; }
        ul.error { color: #cc0000; background: #ffcccc; padding: 10px 30px; border-radius: 5px; }
        a { display: inline-block; margin-top: 15px; color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h2>📚 Thêm Sách Mới</h2>

    <?php if (!empty($errors)): ?>
        <ul class="error">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <label>Mã sách (ISBN):</label>
        <input type="text" name="isbn" value="<?= htmlspecialchars($isbn) ?>" required placeholder="Nhập mã sách...">

        <label>Tên sách:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required placeholder="Nhập tên sách...">

        <label>Tác giả:</label>
        <input type="text" name="author" value="<?= htmlspecialchars($author) ?>" required placeholder="Nhập tên tác giả...">

        <label>Năm xuất bản:</label>
        <input type="number" name="year" value="<?= htmlspecialchars($year) ?>" required min="1900" max="<?= date('Y') ?>">

        <label>Thể loại:</label>
        <select name="category">
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c ?>" <?= ($category === $c) ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>

        <label>Số lượng:</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($quantity) ?>" required min="0">

        <div class="btn-group">
            <input type="submit" value="Lưu sách">
            <input type="reset" value="Nhập lại">
        </div>
    </form>

    <a href="list_books.php">➡ Xem danh sách sách</a>

</body>
</html>