<?php
// Đường dẫn file dữ liệu
$booksFile = __DIR__ . '/../bai2/data/books.json';

// Đọc danh sách sách để đổ vào dropdown
$books = [];
if (file_exists($booksFile)) {
    $books = json_decode(file_get_contents($booksFile), true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lập Phiếu Mượn</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e6f0ff; padding: 20px; }
        .container { background: #cce0ff; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; border: 1px solid #99c2ff; }
        h2 { color: #003366; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #99c2ff; box-sizing: border-box; }
        button { width: 100%; background: #3399ff; color: white; padding: 10px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0066cc; }
        .alert { padding: 10px; background: #ffcccc; color: #cc0000; border-radius: 5px; margin-bottom: 10px; }
        .nav { text-align: center; margin-top: 15px; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Lập Phiếu Mượn Sách</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="borrow_process.php" method="POST">
        <label>Mã thành viên:</label>
        <input type="text" name="member_id" placeholder="Ví dụ: TV001" required>

        <label>Chọn sách:</label>
        <select name="book_isbn" required>
            <option value="">-- Chọn sách --</option>
            <?php foreach ($books as $b): ?>
                <?php 
                    $disabled = ($b['quantity'] <= 0) ? 'disabled' : '';
                    $status = ($b['quantity'] > 0) ? "Còn {$b['quantity']}" : "Hết hàng";
                ?>
                <option value="<?= $b['isbn'] ?>" <?= $disabled ?>>
                    <?= htmlspecialchars($b['title']) ?> (<?= $status ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Ngày mượn:</label>
        <input type="date" name="borrow_date" value="<?= date('Y-m-d') ?>" required>

        <label>Số ngày mượn (1-30):</label>
        <input type="number" name="days" min="1" max="30" value="7" required>

        <button type="submit">Lập Phiếu Mượn</button>
    </form>

    <div class="nav">
        <a href="return_form.php">Chuyển sang Trả Sách ➡</a>
    </div>
</div>

</body>
</html>