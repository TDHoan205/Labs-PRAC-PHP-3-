<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Thêm Khách Hàng</h2>
    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    <form action="index.php?c=customers&a=store" method="POST">
        <label>Họ tên:</label> <input type="text" name="full_name" required>
        <label>Email:</label> <input type="email" name="email" required>
        <label>SĐT:</label> <input type="text" name="phone">
        <button class="btn">Lưu Khách Hàng</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>