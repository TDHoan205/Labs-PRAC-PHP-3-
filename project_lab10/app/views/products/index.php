<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Danh Sách Sản Phẩm</h2>
        <a href="index.php?c=products&a=create" class="btn">Thêm Mới</a>
    </div>
    <form action="" method="GET" style="margin: 15px 0;">
        <input type="hidden" name="c" value="products">
        <input type="text" name="kw" placeholder="Tìm tên hoặc SKU..." value="<?= htmlspecialchars($kw) ?>" style="width:auto; display:inline-block;">
        <button type="submit" class="btn btn-sm">Tìm kiếm</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>SKU</th> <th>Tên</th> <th>Giá</th> <th>Tồn kho</th> <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $p): ?>
            <tr>
                <td><?= $p['sku'] ?></td>
                <td><?= $p['name'] ?></td>
                <td><?= number_format($p['price']) ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a href="index.php?c=products&a=edit&id=<?= $p['id'] ?>" class="btn btn-sm">Sửa</a>
                    <form action="index.php?c=products&a=delete" method="POST" style="display:inline;" onsubmit="return confirm('Xóa?');">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>