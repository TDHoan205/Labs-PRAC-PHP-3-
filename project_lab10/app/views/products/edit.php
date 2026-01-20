<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 600px; margin: auto;">
    <h2>Cập Nhật Sản Phẩm</h2>
    <form action="index.php?c=products&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <label>Tên sản phẩm:</label> <input type="text" name="name" value="<?= $product['name'] ?>" required>
        <label>Mã SKU:</label> <input type="text" name="sku" value="<?= $product['sku'] ?>" required>
        <div class="d-flex">
            <div style="flex:1"><label>Giá:</label> <input type="number" name="price" value="<?= $product['price'] ?>" required></div>
            <div style="flex:1"><label>Kho:</label> <input type="number" name="stock" value="<?= $product['stock'] ?>" required></div>
        </div>
        <button type="submit" class="btn">Cập Nhật</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>