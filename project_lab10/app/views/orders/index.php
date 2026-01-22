<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="section-title">
        <div>
            <h2>Lịch sử đơn hàng</h2>
            <p class="text-muted">Theo dõi mọi giao dịch và giá trị đơn hàng.</p>
        </div>
        <a class="btn btn-sm" href="index.php?c=orders&a=create">+ Tạo đơn mới</a>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <table>
        <thead><tr><th>Mã Đơn</th><th>Khách Hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Chi tiết</th></tr></thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr><td colspan="5" class="empty">Chưa có giao dịch nào.</td></tr>
            <?php else: ?>
                <?php foreach($orders as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= $o['full_name'] ?></td>
                    <td><?= $o['order_date'] ?></td>
                    <td><span class="badge badge-success"><?= number_format($o['total']) ?> đ</span></td>
                    <td><a href="index.php?c=orders&a=show&id=<?= $o['id'] ?>" class="btn btn-sm">Xem</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>