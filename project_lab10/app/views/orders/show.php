<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="section-title">
        <div>
            <h2>Đơn hàng #<?= $order['id'] ?></h2>
            <p class="text-muted">Thông tin chi tiết và trạng thái thanh toán.</p>
        </div>
        <span class="badge badge-success">Hoàn tất</span>
    </div>

    <div class="alert">
        <div class="stack">
            <strong>Khách hàng:</strong> <?= $order['full_name'] ?>
            <span class="pill"><?= $order['email'] ?> | <?= $order['phone'] ?></span>
        </div>
        <div class="stack" style="margin-top:8px;">
            <strong>Ngày đặt:</strong> <?= $order['order_date'] ?>
            <span class="badge">Tổng: <?= number_format($order['total']) ?> đ</span>
        </div>
    </div>
    
    <table>
        <thead><tr><th>Sản phẩm</th><th>SKU</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
        <tbody>
            <?php foreach($items as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['sku'] ?></td>
                <td><?= number_format($item['price']) ?> đ</td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'] * $item['qty']) ?> đ</td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align:right; font-weight:bold;">TỔNG CỘNG:</td>
                <td><span class="badge badge-success" style="font-size:1rem;"><?= number_format($order['total']) ?> đ</span></td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="index.php?c=orders" class="btn btn-ghost">Quay lại danh sách</a>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>