<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="section-title">
        <div>
            <h2>Tạo đơn hàng mới</h2>
            <p class="text-muted">Chọn khách hàng, sản phẩm và xác nhận thanh toán.</p>
        </div>
        <span class="pill">Tốc độ giao dịch cao</span>
    </div>

    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    
    <form action="index.php?c=orders&a=store" method="POST">
        <div class="form-row">
            <div class="form-col">
                <label>Chọn Khách Hàng</label>
                <select name="customer_id" required>
                    <option value="">-- Chọn khách hàng --</option>
                    <?php foreach($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['full_name'] ?> (<?= $c['email'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label>Tóm tắt thanh toán</label>
                <div class="alert">
                    <div class="stack">
                        <span class="badge">Tổng dự kiến</span>
                        <strong id="order-total">0 đ</strong>
                    </div>
                    <small class="text-muted">Tự động tính theo sản phẩm được chọn.</small>
                </div>
            </div>
        </div>

        <h3>Chọn sản phẩm</h3>
        <table id="product-table">
            <tr><th>Chọn</th><th>Sản phẩm (Kho)</th><th>Giá</th><th>Số lượng</th></tr>
            <?php foreach($products as $p): ?>
            <tr data-price="<?= $p['price'] ?>">
                <td><input type="checkbox" name="product_ids[<?= $p['id'] ?>]" value="1"></td>
                <td><?= $p['name'] ?> <span class="badge-muted">Kho: <?= $p['stock'] ?></span></td>
                <td><?= number_format($p['price']) ?> đ</td>
                <td><input type="number" name="qtys[<?= $p['id'] ?>]" value="1" min="1" max="<?= $p['stock'] ?>" style="width:90px;"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <div class="spaced">
            <span class="text-muted">Đảm bảo tồn kho được kiểm tra khi tạo đơn.</span>
            <button class="btn">Thanh toán & tạo đơn</button>
        </div>
    </form>
</div>
<script>
    const table = document.getElementById('product-table');
    const totalEl = document.getElementById('order-total');
    if (table && totalEl) {
        const updateTotal = () => {
            let total = 0;
            table.querySelectorAll('tr').forEach(row => {
                const checkbox = row.querySelector('input[type="checkbox"]');
                const qtyInput = row.querySelector('input[type="number"]');
                const price = parseFloat(row.dataset.price || '0');
                if (checkbox && checkbox.checked) {
                    const qty = parseInt(qtyInput.value || '0', 10);
                    total += price * qty;
                }
            });
            totalEl.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' đ';
        };
        table.addEventListener('change', updateTotal);
        table.addEventListener('input', updateTotal);
    }
</script>
<?php include __DIR__ . '/../layout/footer.php'; ?>