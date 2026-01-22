<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="section-title">
        <div>
            <h2>Danh sách khách hàng</h2>
            <p class="text-muted">Thông tin liên hệ & lịch sử giao dịch.</p>
        </div>
        <a href="index.php?c=customers&a=create" class="btn">+ Thêm khách</a>
    </div>
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>
    <table>
        <thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Thao tác</th></tr></thead>
        <tbody>
            <?php if (empty($customers)): ?>
                <tr><td colspan="5" class="empty">Chưa có khách hàng.</td></tr>
            <?php else: ?>
                <?php foreach($customers as $c): ?>
                <tr>
                    <td>#<?= $c['id'] ?></td>
                    <td><?= $c['full_name'] ?></td>
                    <td><?= $c['email'] ?></td>
                    <td><?= $c['phone'] ?></td>
                    <td><a href="index.php?c=customers&a=edit&id=<?= $c['id'] ?>" class="btn btn-sm">Sửa</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>