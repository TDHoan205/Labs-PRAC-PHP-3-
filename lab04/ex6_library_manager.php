<?php
require_once 'Book.php';

function h($s){ return htmlspecialchars($s); }

$books = [];
$q = $_POST['q'] ?? '';
$sort = isset($_POST['sort']);

if ($_SERVER['REQUEST_METHOD']==='POST') {

    $raw = $_POST['data'] ?? '';
    $records = explode(';', $raw);

    foreach ($records as $rec) {
        $parts = explode('-', trim($rec));
        if (count($parts)!==3) continue;
        [$id,$title,$qty] = $parts;
        if (!is_numeric($qty)) continue;
        $books[] = new Book(trim($id),trim($title),(int)$qty);
    }

    if ($q!=='') {
        $books = array_filter($books, function($b) use ($q){
            return stripos($b->getTitle(), $q) !== false;
        });
    }

    if ($sort) {
        usort($books, fn($a,$b)=>$b->getQty()<=>$a->getQty());
    }
}

$totalBooks = count($books);
$totalQty = 0;
$out = 0;
$maxBook = null;

foreach ($books as $b) {
    $totalQty += $b->getQty();
    if ($b->getQty()==0) $out++;
    if (!$maxBook || $b->getQty()>$maxBook->getQty()) $maxBook=$b;
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Bài 6A</title></head>
<body>

<form method="post">
<textarea name="data" rows="5" cols="60"><?= h($_POST['data'] ?? '') ?></textarea><br>
Search title: <input name="q" value="<?= h($q) ?>">
<label><input type="checkbox" name="sort" <?= $sort?'checked':'' ?>>Sort Qty ↓</label>
<br><button>Show</button>
</form>

<table border="1">
<tr><th>STT</th><th>ID</th><th>Title</th><th>Qty</th><th>Status</th></tr>
<?php foreach ($books as $i=>$b): ?>
<tr>
<td><?= $i+1 ?></td>
<td><?= h($b->getId()) ?></td>
<td><?= h($b->getTitle()) ?></td>
<td><?= $b->getQty() ?></td>
<td><?= $b->status() ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>Tổng đầu sách: <?= $totalBooks ?></p>
<p>Tổng số quyển: <?= $totalQty ?></p>
<p>Sách Out of stock: <?= $out ?></p>

</body>
</html>
