<?php
require_once 'Product.php';
function h($s){ return htmlspecialchars($s); }

$products=[];
$minPrice=$_POST['minPrice']??'';
$sort=isset($_POST['sort']);

if($_SERVER['REQUEST_METHOD']==='POST'){
    $raw=$_POST['data']??'';
    foreach(explode(';',$raw) as $rec){
        $p=explode('-',trim($rec));
        if(count($p)!==4) continue;
        [$id,$name,$price,$qty]=$p;
        if(!is_numeric($price)||!is_numeric($qty)) continue;
        $products[]=new Product(trim($id),trim($name),$price,$qty);
    }

    if($minPrice!=='' && is_numeric($minPrice)){
        $products=array_filter($products,fn($p)=>$p->getPrice()>=(float)$minPrice);
    }

    if($sort){
        usort($products,fn($a,$b)=>$b->amount()<=>$a->amount());
    }
}

// Thống kê
$total=0;$prices=[];
$max=null;
foreach($products as $p){
    $total+=$p->amount();
    $prices[]=$p->getPrice();
    if(!$max||$p->amount()>$max->amount()) $max=$p;
}
$avg=count($prices)?array_sum($prices)/count($prices):0;
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Bài 6B</title></head>
<body>

<form method="post">
<textarea name="data" rows="5" cols="60"><?= h($_POST['data'] ?? '') ?></textarea><br>
Min price: <input name="minPrice" value="<?= h($minPrice) ?>">
<label><input type="checkbox" name="sort" <?= $sort?'checked':'' ?>>Sort Amount ↓</label>
<br><button>Show</button>
</form>

<table border="1">
<tr><th>STT</th><th>ID</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th></tr>
<?php foreach($products as $i=>$p): ?>
<tr>
<td><?= $i+1 ?></td>
<td><?= h($p->getId()) ?></td>
<td><?= h($p->getName()) ?></td>
<td><?= $p->getPrice() ?></td>
<td><?= $p->getQty() ?></td>
<td><?= $p->getQty()>0?$p->amount():'Invalid qty' ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>Tổng tiền: <?= $total ?></p>
<p>Avg price: <?= number_format($avg,2) ?></p>
<?php if($max): ?>
<p>Amount lớn nhất: <?= h($max->getName()) ?></p>
<?php endif; ?>

</body>
</html>
