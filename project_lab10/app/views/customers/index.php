<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="card">
    <div class="d-flex" style="justify-content:space-between;">
        <h2>Khách Hàng</h2>
        <a href="index.php?c=customers&a=create" class="btn">Thêm Khách</a>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Thao tác</th></tr></thead>
        <tbody>
            <?php foreach($customers as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['full_name'] ?></td>
                <td><?= $c['email'] ?></td>
                <td><?= $c['phone'] ?></td>
                <td><a href="index.php?c=customers&a=edit&id=<?= $c['id'] ?>" class="btn btn-sm">Sửa</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>