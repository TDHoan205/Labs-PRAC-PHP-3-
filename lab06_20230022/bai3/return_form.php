<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trả Sách</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e6f0ff; padding: 20px; }
        .container { background: #cce0ff; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; border: 1px solid #99c2ff; }
        h2 { color: #003366; text-align: center; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input { width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #99c2ff; box-sizing: border-box; }
        button { width: 100%; background: #28a745; color: white; padding: 10px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; font-size: 16px; }
        button:hover { background: #218838; }
        .alert { padding: 10px; background: #ffcccc; color: #cc0000; border-radius: 5px; margin-bottom: 10px; }
        .note { font-size: 13px; color: #555; margin-top: 5px; font-style: italic; }
        .nav { text-align: center; margin-top: 15px; }
        a { color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>📖 Form Trả Sách</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="return_process.php" method="POST">
        
        <p style="border-bottom: 1px solid #99c2ff; padding-bottom: 5px;">Nhập <b>Mã phiếu</b> HOẶC (<b>Mã TV</b> + <b>Mã sách</b>)</p>

        <label>Cách 1: Mã phiếu mượn</label>
        <input type="text" name="borrow_id" placeholder="Ví dụ: PH170...">

        <label>Cách 2: Mã thành viên & Mã sách</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" name="member_id" placeholder="Mã TV (TV001)">
            <input type="text" name="book_isbn" placeholder="Mã Sách (978-...)">
        </div>

        <label>Ngày trả thực tế:</label>
        <input type="date" name="return_date" value="<?= date('Y-m-d') ?>" required>

        <button type="submit">Xác Nhận Trả Sách</button>
    </form>

    <div class="nav">
        <a href="borrow_form.php">⬅ Quay lại Mượn Sách</a>
    </div>
</div>

</body>
</html>