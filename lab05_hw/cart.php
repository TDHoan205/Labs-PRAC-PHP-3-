<?php
require_once 'includes/auth.php';
require_once 'includes/cart.php';
require_once 'includes/flash.php';

require_login();

/*
    Danh sách sản phẩm demo
*/
$products = [
    1 => ['name' => 'Áo thun xanh', 'price' => 150000],
    2 => ['name' => 'Quần jean', 'price' => 350000],
    3 => ['name' => 'Giày sneaker', 'price' => 550000],
];

$cart = $_SESSION['cart'] ?? [];

include 'includes/header.php';
?>

<h2>🛒 Giỏ hàng của bạn</h2>

<?php if (empty($cart)): ?>
    <p>Giỏ hàng đang trống.</p>
<?php else: ?>

<table class="cart-table">
    <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Tạm tính</th>
    </tr>

    <?php
    $total = 0;
    foreach ($cart as $id => $qty):
        $p = $products[$id];
        $sub = $p['price'] * $qty;
        $total += $sub;
    ?>
    <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $qty ?></td>
        <td><?= number_format($p['price']) ?> đ</td>
        <td><?= number_format($sub) ?> đ</td>
    </tr>
    <?php endforeach; ?>

    <tr class="cart-total">
        <th colspan="3">Tổng cộng</th>
        <th><?= number_format($total) ?> đ</th>
    </tr>
</table>

<div style="margin-top:20px;">
    <a href="products.php" class="btn-back">⬅ Tiếp tục mua</a>
</div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
