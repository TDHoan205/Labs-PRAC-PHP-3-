<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <h2>Tạo Đơn Hàng Mới</h2>
    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    
    <form action="index.php?c=orders&a=store" method="POST">
        <label>Chọn Khách Hàng:</label>
        <select name="customer_id" required>
            <?php foreach($customers as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['full_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Chọn sản phẩm:</h3>
        <table>
            <tr><th>Chọn</th><th>Sản phẩm (Kho)</th><th>Giá</th><th>Số lượng</th></tr>
            <?php foreach($products as $p): ?>
            <tr>
                <td><input type="checkbox" name="product_ids[<?= $p['id'] ?>]" value="1"></td>
                <td><?= $p['name'] ?> (Kho: <?= $p['stock'] ?>)</td>
                <td><?= number_format($p['price']) ?></td>
                <td><input type="number" name="qtys[<?= $p['id'] ?>]" value="1" min="1" max="<?= $p['stock'] ?>" style="width:70px;"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button class="btn">Thanh Toán & Tạo Đơn</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>