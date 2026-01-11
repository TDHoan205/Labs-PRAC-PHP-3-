<?php
$errors = [];
$name = $email = $phone = '';
$discount = 0;
$vat = 0;
$payment = 'Tiền mặt';

$items = [];
for ($i = 0; $i < 3; $i++) {
    $items[$i] = ['name' => '', 'qty' => '', 'price' => ''];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $discount = (float)($_POST['discount'] ?? 0);
    $vat = (float)($_POST['vat'] ?? 0);
    $payment = $_POST['payment'] ?? 'Tiền mặt';

    for ($i = 0; $i < 3; $i++) {
        $items[$i]['name'] = trim($_POST['item_name'][$i] ?? '');
        $items[$i]['qty'] = (int)($_POST['item_qty'][$i] ?? 0);
        $items[$i]['price'] = (float)($_POST['item_price'][$i] ?? 0);
    }

    // ===== VALIDATE =====
    if (!$name) $errors[] = "Họ tên là bắt buộc.";
    if (!$phone) $errors[] = "Số điện thoại là bắt buộc.";
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Email không hợp lệ.";

    $validItem = false;
    foreach ($items as $it) {
        if ($it['name'] && $it['qty'] > 0 && $it['price'] > 0) {
            $validItem = true;
        }
    }
    if (!$validItem) $errors[] = "Phải có ít nhất 1 mặt hàng hợp lệ.";

    if ($discount < 0 || $discount > 30) $errors[] = "Giảm giá từ 0–30%.";
    if ($vat < 0 || $vat > 15) $errors[] = "VAT từ 0–15%.";

    // ===== XỬ LÝ =====
    if (empty($errors)) {
        $subtotal = 0;
        foreach ($items as $it) {
            if ($it['name'] && $it['qty'] > 0 && $it['price'] > 0) {
                $subtotal += $it['qty'] * $it['price'];
            }
        }
        $afterDiscount = $subtotal * (1 - $discount / 100);
        $total = $afterDiscount * (1 + $vat / 100);

        $dir = __DIR__ . '/data/invoices';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $fileName = 'invoice_' . time() . '.json';
        $path = $dir . '/' . $fileName;

        file_put_contents($path, json_encode([
            'customer' => [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ],
            'items' => $items,
            'discount' => $discount,
            'vat' => $vat,
            'payment' => $payment,
            'subtotal' => $subtotal,
            'total' => $total
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        header("Location: invoice_result.php?file=$fileName");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tạo hóa đơn</title>
<style>
body{font-family:Arial;background:#e6f0ff;padding:20px;}
h2{color:#003366;}
form{background:#cce0ff;padding:20px;border-radius:10px;max-width:600px;}
input{width:100%; margin:5px 0 15px;padding:8px;border-radius:5px;border:1px solid #99c2ff;}
input[type=submit]{width:auto;background:#3399ff;color:#fff;border:none;cursor:pointer;padding:10px 20px;}
input[type=submit]:hover{background:#0066cc;}
ul{color:red;}
</style>
</head>
<body>

<h2>Tạo hóa đơn bán hàng</h2>

<?php if ($errors): ?>
<ul>
<?php foreach ($errors as $e): ?>
<li><?=htmlspecialchars($e)?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post">
Họ tên: <input type="text" name="name" value="<?=htmlspecialchars($name)?>">
Email: <input type="email" name="email" value="<?=htmlspecialchars($email)?>">
Số điện thoại: <input type="text" name="phone" value="<?=htmlspecialchars($phone)?>">

<h3>Danh sách hàng hóa</h3>
<?php for ($i=0;$i<3;$i++): ?>
Tên hàng: <input type="text" name="item_name[]" value="<?=htmlspecialchars($items[$i]['name'])?>">
Số lượng: <input type="number" min="0" name="item_qty[]" value="<?=htmlspecialchars($items[$i]['qty'])?>">
Đơn giá: <input type="number" min="0" name="item_price[]" value="<?=htmlspecialchars($items[$i]['price'])?>">
<?php endfor; ?>

Giảm giá (%): <input type="number" name="discount" value="<?=htmlspecialchars($discount)?>">
VAT (%): <input type="number" name="vat" value="<?=htmlspecialchars($vat)?>">

Phương thức thanh toán:
<input type="radio" name="payment" value="Tiền mặt" <?=$payment=='Tiền mặt'?'checked':''?>> Tiền mặt
<input type="radio" name="payment" value="Chuyển khoản" <?=$payment=='Chuyển khoản'?'checked':''?>> Chuyển khoản
<br><br>

<input type="submit" value="Tạo hóa đơn">
</form>

</body>
</html>
 