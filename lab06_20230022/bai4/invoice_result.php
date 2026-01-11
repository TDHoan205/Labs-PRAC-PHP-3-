<?php
$file = basename($_GET['file'] ?? '');
$path = __DIR__ . '/data/invoices/' . $file;

if (!file_exists($path)) {
    echo "Hóa đơn không tồn tại. <a href='invoice_form.php'>Quay lại</a>";
    exit;
}

$inv = json_decode(file_get_contents($path), true);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hóa đơn</title>
<style>
body{font-family:Arial;background:#e6f0ff;padding:20px;}
h2{color:#003366;}
table{border-collapse:collapse;width:80%;background:#cce0ff;}
th,td{border:1px solid #99c2ff;padding:8px;}
th{background:#3399ff;color:#fff;}
</style>
</head>
<body>

<h2>HÓA ĐƠN BÁN HÀNG</h2>
<p>
Khách hàng: <?=htmlspecialchars($inv['customer']['name'])?><br>
SĐT: <?=htmlspecialchars($inv['customer']['phone'])?>
</p>

<table>
<tr>
<th>Mặt hàng</th>
<th>SL</th>
<th>Đơn giá</th>
<th>Thành tiền</th>
</tr>

<?php foreach ($inv['items'] as $it): ?>
<?php if ($it['name'] && $it['qty']>0 && $it['price']>0): ?>
<tr>
<td><?=htmlspecialchars($it['name'])?></td>
<td><?=$it['qty']?></td>
<td><?=number_format($it['price'])?></td>
<td><?=number_format($it['qty']*$it['price'])?></td>
</tr>
<?php endif; ?>
<?php endforeach; ?>

<tr><td colspan="3">Tạm tính</td><td><?=number_format($inv['subtotal'])?></td></tr>
<tr><td colspan="3">Giảm giá <?=$inv['discount']?>%</td><td>-</td></tr>
<tr><td colspan="3">VAT <?=$inv['vat']?>%</td><td>-</td></tr>
<tr><td colspan="3"><b>Tổng thanh toán</b></td><td><b><?=number_format($inv['total'])?></b></td></tr>
</table>

<p>Thanh toán: <?=htmlspecialchars($inv['payment'])?></p>

<a href="invoice_form.php">Tạo hóa đơn mới</a>

</body>
</html>
