<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="section-title">
        <div>
            <h2>Danh sách sản phẩm</h2>
            <p class="text-muted">Quản lý danh mục, tồn kho và giá bán.</p>
        </div>
        <a href="index.php?c=products&a=create" class="btn">+ Thêm sản phẩm</a>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="GET" style="margin: 15px 0;" class="spaced">
        <input type="hidden" name="c" value="products">
        <div class="stack">
            <input type="text" name="kw" placeholder="Tìm tên hoặc SKU..." value="<?= htmlspecialchars($kw) ?>" style="width:240px;">
            <button type="submit" class="btn btn-sm">Tìm kiếm</button>
        </div>
        <span class="text-muted">Hiển thị <?= count($products) ?> sản phẩm</span>
    </form>
    <table>
        <thead>
            <tr>
                <th>SKU</th> <th>Tên</th> <th>Giá</th> <th>Tồn kho</th> <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="5" class="empty">Chưa có sản phẩm nào.</td></tr>
            <?php else: ?>
                <?php foreach($products as $p): ?>
                <tr>
                    <td><?= $p['sku'] ?></td>
                    <td><?= $p['name'] ?></td>
                    <td><span class="badge"><?= number_format($p['price']) ?> đ</span></td>
                    <td><span class="badge <?= $p['stock'] > 0 ? 'badge-success' : 'badge-muted' ?>"><?= $p['stock'] ?> cái</span></td>
                    <td class="stack">
                        <a href="index.php?c=products&a=edit&id=<?= $p['id'] ?>" class="btn btn-sm">Sửa</a>
                        <form action="index.php?c=products&a=delete" method="POST" style="display:inline;" onsubmit="return confirm('Xóa sản phẩm này?');">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>