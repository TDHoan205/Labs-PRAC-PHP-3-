<?php
// Thêm sản phẩm vào giỏ
function cart_add(int $id, int $qty = 1): void {
    if ($qty < 1) $qty = 1;
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
}

// Cập nhật số lượng
function cart_update(int $id, int $qty): void {
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}
