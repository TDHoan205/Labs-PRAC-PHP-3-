<?php
require_once 'Student.php';
$students = [
    new Student('SV01', 'An', 3.4),
    new Student('SV02', 'Binh', 2.8),
    new Student('SV03', 'Chi', 3.6),
    new Student('SV04', 'Dung', 2.2),
    new Student('SV05', 'Hoa', 3.0),
];

$gpas = array_map(fn($s) => $s->getGpa(), $students);
$avg = array_sum($gpas) / count($gpas);
$stats = ['Giỏi'=>0,'Khá'=>0,'Trung bình'=>0];
foreach ($students as $s) {
    $stats[$s->rank()]++;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bài 4 - Student</title>
</head>
<body>

<table border="1">
<tr>
<th>STT</th><th>ID</th><th>Name</th><th>GPA</th><th>Rank</th>
</tr>
<?php foreach ($students as $i => $s): ?>
<tr>
<td><?= $i+1 ?></td>
<td><?= htmlspecialchars($s->getId()) ?></td>
<td><?= htmlspecialchars($s->getName()) ?></td>
<td><?= $s->getGpa() ?></td>
<td><?= $s->rank() ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>GPA trung bình lớp: <?= number_format($avg,2) ?></p>

<ul>
<?php foreach ($stats as $k=>$v): ?>
<li><?= $k ?>: <?= $v ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>
