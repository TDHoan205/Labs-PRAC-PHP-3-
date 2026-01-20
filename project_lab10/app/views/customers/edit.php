<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Sửa Khách Hàng</h2>
    <form action="index.php?c=customers&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">
        <label>Họ tên:</label> <input type="text" name="full_name" value="<?= $customer['full_name'] ?>" required>
        <label>Email:</label> <input type="email" name="email" value="<?= $customer['email'] ?>" required>
        <label>SĐT:</label> <input type="text" name="phone" value="<?= $customer['phone'] ?>">
        <button class="btn">Lưu Thay Đổi</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>