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

// Xử lý thêm vào giỏ
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    if (isset($products[$id])) {
        cart_add($id);
        set_flash('success', 'Đã thêm sản phẩm vào giỏ hàng');
        header('Location: products.php');
        exit;
    }
}

include 'includes/header.php';
?>

<h2>🛍️ Danh sách sản phẩm</h2>
<p>Chọn sản phẩm bạn muốn mua</p>

<div class="product-grid">

<?php foreach ($products as $id => $p): ?>
    <div class="product-card">
        <div class="product-image">
            📦
        </div>

        <div class="product-name">
            <?= htmlspecialchars($p['name']) ?>
        </div>

        <div class="product-price">
            <?= number_format($p['price']) ?> đ
        </div>

        <a class="btn-add" href="?add=<?= $id ?>">
            ➕ Thêm vào giỏ
        </a>
    </div>
<?php endforeach; ?>

</div>

<?php include 'includes/footer.php'; ?>
