<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 720px; margin: auto;">
    <div class="section-title">
        <h2>Cập nhật sản phẩm</h2>
        <span class="pill">ID #<?= $product['id'] ?></span>
    </div>
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>
    <form action="index.php?c=products&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" value="<?= $product['name'] ?>" required>

        <label>Mã SKU</label>
        <input type="text" name="sku" value="<?= $product['sku'] ?>" required>

        <div class="form-row">
            <div class="form-col">
                <label>Giá</label>
                <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required>
            </div>
            <div class="form-col">
                <label>Tồn kho</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
            </div>
        </div>
        <div class="spaced">
            <span class="text-muted">Kiểm tra lại tồn kho trước khi lưu.</span>
            <button type="submit" class="btn">Cập nhật</button>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>