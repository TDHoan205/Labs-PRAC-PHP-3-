<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 720px; margin: auto;">
    <div class="section-title">
        <h2>Thêm sản phẩm</h2>
        <span class="pill">Nhập SKU duy nhất</span>
    </div>
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="index.php?c=products&a=store" method="POST">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" required placeholder="VD: Tai nghe không dây">

        <label>Mã SKU</label>
        <input type="text" name="sku" required placeholder="VD: SP-001">

        <div class="form-row">
            <div class="form-col">
                <label>Giá</label>
                <input type="number" name="price" min="0" step="0.01" required placeholder="0">
            </div>
            <div class="form-col">
                <label>Tồn kho</label>
                <input type="number" name="stock" min="0" required placeholder="0">
            </div>
        </div>
        <div class="spaced">
            <span class="text-muted">Giá và tồn kho có thể cập nhật bất kỳ lúc nào.</span>
            <button type="submit" class="btn">Lưu sản phẩm</button>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>