<?php
$rawNames = $_GET['names'] ?? '';
$parts = explode(',', $rawNames);
$trimmed = array_map('trim', $parts);
$names = array_filter($trimmed, function ($n) {
    return $n !== '';
});

$count = count($names);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bài 1 - Danh sách tên</title>
</head>
<body>

<h3>Chuỗi gốc:</h3>
<p><?= htmlspecialchars($rawNames) ?></p>

<?php if ($count === 0): ?>
    <p><b>Chưa có dữ liệu hợp lệ</b></p>
<?php else: ?>
    <p>Số lượng tên hợp lệ: <?= $count ?></p>

    <ol>
        <?php foreach ($names as $name): ?>
            <li><?= htmlspecialchars($name) ?></li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

</body>
</html>
