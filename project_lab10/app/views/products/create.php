<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 600px; margin: auto;">
    <h2>Thêm Sản Phẩm</h2>
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="index.php?c=products&a=store" method="POST">
        <label>Tên sản phẩm:</label> <input type="text" name="name" required>
        <label>Mã SKU:</label> <input type="text" name="sku" required>
        <div class="d-flex">
            <div style="flex:1"><label>Giá:</label> <input type="number" name="price" min="0" required></div>
            <div style="flex:1"><label>Kho:</label> <input type="number" name="stock" min="0" required></div>
        </div>
        <button type="submit" class="btn">Lưu Sản Phẩm</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>