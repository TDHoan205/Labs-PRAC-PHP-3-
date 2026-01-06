<?php
$scores = [8.5, 7.0, 9.25, 6.5, 8.0, 5.75];
$sum = array_sum($scores);
$count = count($scores);
$avg = $sum / $count;
$goodScores = array_filter($scores, function ($s) {
    return $s >= 8.0;
});
$max = max($scores);
$min = min($scores);
$asc = $scores;
sort($asc);
$desc = $scores;
rsort($desc);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bài 2 - Thống kê điểm</title>
</head>
<body>
<p>Điểm trung bình: <?= number_format($avg, 2) ?></p>
<p>Số điểm >= 8.0: <?= count($goodScores) ?></p>
<ul>
    <?php foreach ($goodScores as $s): ?>
        <li><?= $s ?></li>
    <?php endforeach; ?>
</ul>
<p>Max: <?= $max ?></p>
<p>Min: <?= $min ?></p>
<p>Tăng dần: <?= implode(', ', $asc) ?></p>
<p>Giảm dần: <?= implode(', ', $desc) ?></p>
</body>
</html>
