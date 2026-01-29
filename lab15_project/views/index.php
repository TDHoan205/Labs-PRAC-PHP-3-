<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Danh sách sản phẩm</h2>
    <a href="index.php?action=form" class="btn btn-success">+ Thêm mới</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td>
                <?php if($p['image']): ?>
                    <img src="uploads/<?= $p['image'] ?>" width="60" height="60" style="object-fit: cover; border-radius: 5px;">
                <?php else: ?>
                    <span class="text-muted">Không có ảnh</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><strong><?= number_format($p['price']) ?> đ</strong></td>
            <td>
                <a href="index.php?action=form&id=<?= $p['id'] ?>&page=<?= $page ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="index.php?action=delete&id=<?= $p['id'] ?>&page=<?= $page ?>" onclick="return confirm('Chắc chắn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
    <span>Trang <?= $page ?> / <?= $totalPages ?> – Tổng <?= $totalRecords ?> bản ghi</span>
    <nav>
        <ul class="pagination">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=1">First</a>
            </li>
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $totalPages ?>">Last</a>
            </li>
        </ul>
    </nav>
</div>