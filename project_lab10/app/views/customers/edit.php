<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 640px; margin: auto;">
    <div class="section-title">
        <h2>Sửa khách hàng</h2>
        <span class="pill">ID #<?= $customer['id'] ?></span>
    </div>
    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    <form action="index.php?c=customers&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">
        <label>Họ tên</label>
        <input type="text" name="full_name" value="<?= $customer['full_name'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $customer['email'] ?>" required>

        <label>SĐT</label>
        <input type="text" name="phone" value="<?= $customer['phone'] ?>">

        <div class="spaced">
            <span class="text-muted">Kiểm tra lại email và số điện thoại.</span>
            <button class="btn">Lưu thay đổi</button>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>