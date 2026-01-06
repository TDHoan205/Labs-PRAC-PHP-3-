<?php
function h($s) {
    return htmlspecialchars($s);
}

$products = [
    ['name' => 'Pen', 'price' => 5, 'qty' => 10],
    ['name' => 'Notebook', 'price' => 20, 'qty' => 3],
    ['name' => 'Bag', 'price' => 50, 'qty' => 1],
];

$products = array_map(function ($p) {
    $p['amount'] = $p['price'] * $p['qty'];
    return $p;
}, $products);

$total = array_reduce($products, function ($sum, $p) {
    return $sum + $p['amount'];
}, 0);

$maxProduct = $products[0];
foreach ($products as $p) {
    if ($p['amount'] > $maxProduct['amount']) {
        $maxProduct = $p;
    }
}
$sorted = $products;
usort($sorted, function ($a, $b) {
    return $b['price'] <=> $a['price'];
});
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bài 3 - Giỏ hàng</title>
</head>
<body>

<table border ="1" cellpadding="5">
<tr>
    <th>STT</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th>
</tr>
<?php foreach ($products as $i => $p): ?>
<tr>
    <td><?= $i + 1 ?></td>
    <td><?= h($p['name']) ?></td>
    <td><?= $p['price'] ?></td>
    <td><?= $p['qty'] ?></td>
    <td><?= $p['amount'] ?></td>
</tr>
<?php endforeach; ?>
<tr>
    <td colspan="4"><b>Tổng tiền</b></td>
    <td><?= $total ?></td>
</tr>
</table>

<p>Sản phẩm có số lượng(Amount) lớn nhất: <?= h($maxProduct['name']) ?></p>

</body>
</html>
