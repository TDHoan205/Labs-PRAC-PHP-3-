<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <h2>Lịch Sử Đơn Hàng</h2>
    <table>
        <thead><tr><th>Mã Đơn</th><th>Khách Hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Chi tiết</th></tr></thead>
        <tbody>
            <?php foreach($orders as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= $o['full_name'] ?></td>
                <td><?= $o['order_date'] ?></td>
                <td style="color:blue; font-weight:bold;"><?= number_format($o['total']) ?> đ</td>
                <td><a href="index.php?c=orders&a=show&id=<?= $o['id'] ?>" class="btn btn-sm">Xem</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>