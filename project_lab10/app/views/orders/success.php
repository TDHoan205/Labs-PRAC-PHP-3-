<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="text-align:center; padding: 50px;">
    <h1 style="color:green; font-size: 3rem;">✓</h1>
    <h2 style="color:green;">Tạo đơn hàng #<?= $_GET['id'] ?> thành công!</h2>
    <p>Đã ghi nhận đơn hàng và trừ kho.</p>
    <br>
    <a href="index.php?c=orders&a=show&id=<?= $_GET['id'] ?>" class="btn">Xem chi tiết</a>
    <a href="index.php?c=products" class="btn">Về trang chủ</a>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>