<?php
require_once 'Student.php';
function h($s) {
    return htmlspecialchars($s);
}

$students = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $raw = $_POST['data'] ?? '';
    $threshold = $_POST['threshold'] ?? '';
    $sortDesc = isset($_POST['sort_desc']);
    $records = explode(';', $raw);

    foreach ($records as $rec) {
        $rec = trim($rec);
        if ($rec === '') continue;
        $parts = explode('-', $rec);
        if (count($parts) !== 3) continue;
        [$id, $name, $gpaStr] = $parts;
        if (!is_numeric($gpaStr)) continue;
        $gpa = (float)$gpaStr;
        $students[] = new Student(trim($id), trim($name), $gpa);
    }

    if (count($students) === 0) {
        $error = 'Không có dữ liệu sinh viên hợp lệ';
    }

    if ($threshold !== '' && is_numeric($threshold)) {
        $students = array_filter($students, function ($s) use ($threshold) {
            return $s->getGpa() >= (float)$threshold;
        });
    }

    if ($sortDesc) {
        usort($students, function ($a, $b) {
            return $b->getGpa() <=> $a->getGpa();
        });
    }
}

$stats = ['Giỏi'=>0,'Khá'=>0,'Trung bình'=>0];
$gpas = [];

foreach ($students as $s) {
    $stats[$s->rank()]++;
    $gpas[] = $s->getGpa();
}

$avg = count($gpas) ? array_sum($gpas)/count($gpas) : 0;
$max = count($gpas) ? max($gpas) : 0;
$min = count($gpas) ? min($gpas) : 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bài 5 - Student Manager</title>
</head>
<body>
<h3>Student Manager</h3>
<form method="post">
<textarea name="data" rows="5" cols="60"><?= h($_POST['data'] ?? '') ?></textarea><br><br>
GPA >= <input type="text" name="threshold" value="<?= h($_POST['threshold'] ?? '') ?>">

<label>
    <input type="checkbox" name="sort_desc" <?= isset($_POST['sort_desc'])?'checked':'' ?>>
    Sort GPA giảm dần
</label>

<br><br>
<button type="submit">Parse & Show</button>
</form>

<?php if ($error): ?>
<p style="color:red"><?= h($error) ?></p>
<?php endif; ?>

<?php if (count($students)): ?>
<table bord er="1">
<tr>
<th>STT</th><th>ID</th><th>Name</th><th>GPA</th><th>Rank</th>
</tr>
<?php foreach ($students as $i=>$s): ?>
<tr>
<td><?= $i+1 ?></td>
<td><?= h($s->getId()) ?></td>
<td><?= h($s->getName()) ?></td>
<td><?= $s->getGpa() ?></td>
<td><?= $s->rank() ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>Avg GPA: <?= number_format($avg,2) ?></p>
<p>Max GPA: <?= $max ?></p>
<p>Min GPA: <?= $min ?></p>

<ul>
<?php foreach ($stats as $k=>$v): ?>
<li><?= $k ?>: <?= $v ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

</body>
</html>
