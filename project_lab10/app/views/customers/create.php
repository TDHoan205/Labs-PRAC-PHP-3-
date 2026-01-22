<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card" style="max-width: 640px; margin: auto;">
    <div class="section-title">
        <h2>Thêm khách hàng</h2>
        <span class="pill">Thông tin liên hệ</span>
    </div>
    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    <form action="index.php?c=customers&a=store" method="POST">
        <label>Họ tên</label>
        <input type="text" name="full_name" required placeholder="Nguyễn Văn A">

        <label>Email</label>
        <input type="email" name="email" required placeholder="email@domain.com">

        <label>SĐT</label>
        <input type="text" name="phone" placeholder="09xx xxx xxx">

        <div class="spaced">
            <span class="text-muted">Email phải hợp lệ và duy nhất.</span>
            <button class="btn">Lưu khách hàng</button>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>