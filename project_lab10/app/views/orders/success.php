<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="text-align:center; padding: 50px;">
    <div style="font-size: 3rem; color: #22c55e; margin-bottom: 10px;">✓</div>
    <h2>Đơn hàng #<?= $_GET['id'] ?> đã tạo thành công!</h2>
    <p class="text-muted">Kho đã được trừ và thông tin đã lưu trữ an toàn.</p>
    <br>
    <div class="stack" style="justify-content:center;">
        <a href="index.php?c=orders&a=show&id=<?= $_GET['id'] ?>" class="btn">Xem chi tiết</a>
        <a href="index.php?c=orders" class="btn btn-ghost">Về danh sách đơn</a>
        <a href="index.php?c=orders&a=create" class="btn btn-sm">Tạo đơn mới</a>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>