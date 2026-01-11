<?php
$dataDir = __DIR__ . '/data';
$booksFile = $dataDir . '/books.json';

$books = [];
if (file_exists($booksFile)) {
    $jsonContent = file_get_contents($booksFile);
    $books = json_decode($jsonContent, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sách</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e6f0ff; padding: 20px; }
        h2 { color: #003366; }
        table { border-collapse: collapse; width: 100%; background: #fff; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #3399ff; color: #fff; text-transform: uppercase; font-size: 14px; }
        tr:hover { background-color: #f1f1f1; }
        .empty-msg { text-align: center; color: #666; font-style: italic; padding: 20px; }
        .btn-add { display: inline-block; background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-bottom: 15px; }
        .btn-add:hover { background: #218838; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 12px; color: white; }
        .badge-instock { background-color: #28a745; }
        .badge-outstock { background-color: #dc3545; }
    </style>
</head>
<body>

    <h2>📖 Danh Sách Sách Trong Kho</h2>
    
    <a href="add_book.php" class="btn-add">+ Thêm sách mới</a>

    <table>
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Năm XB</th>
                <th>Thể loại</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($books)): ?>
                <tr>
                    <td colspan="7" class="empty-msg">Hiện chưa có cuốn sách nào trong kho dữ liệu.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($books as $b): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($b['isbn']) ?></strong></td>
                        <td><?= htmlspecialchars($b['title']) ?></td>
                        <td><?= htmlspecialchars($b['author']) ?></td>
                        <td><?= htmlspecialchars($b['year']) ?></td>
                        <td><?= htmlspecialchars($b['category']) ?></td>
                        <td><?= htmlspecialchars($b['quantity']) ?></td>
                        <td>
                            <?php if($b['quantity'] > 0): ?>
                                <span class="badge badge-instock">Còn hàng</span>
                            <?php else: ?>
                                <span class="badge badge-outstock">Hết hàng</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>