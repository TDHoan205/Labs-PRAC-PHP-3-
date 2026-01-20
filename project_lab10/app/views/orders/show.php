<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <h2>Chi Tiết Đơn Hàng #<?= $order['id'] ?></h2>
    <div class="alert">
        <strong>Khách hàng:</strong> <?= $order['full_name'] ?> | 
        <strong>Ngày đặt:</strong> <?= $order['order_date'] ?>
    </div>
    
    <table>
        <thead><tr><th>Sản phẩm</th><th>SKU</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
        <tbody>
            <?php foreach($items as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['sku'] ?></td>
                <td><?= number_format($item['price']) ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'] * $item['qty']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align:right; font-weight:bold;">TỔNG CỘNG:</td>
                <td style="color:red; font-weight:bold; font-size:1.2rem;"><?= number_format($order['total']) ?> đ</td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="index.php?c=orders" class="btn">Quay lại danh sách</a>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>