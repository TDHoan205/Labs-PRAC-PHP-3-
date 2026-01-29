<h2 class="text-primary mb-4"><?= isset($product) ? 'Cập nhật' : 'Thêm mới' ?> sản phẩm</h2>
<form action="index.php?action=save&page=<?= $page ?? 1 ?>" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
    <input type="hidden" name="id" value="<?= $product['id'] ?? '' ?>">
    <input type="hidden" name="current_image" value="<?= $product['image'] ?? '' ?>">

    <div class="mb-3">
        <label class="form-label">Tên sản phẩm:</label>
        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?? '' ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Giá:</label>
        <input type="number" name="price" class="form-control" value="<?= $product['price'] ?? '' ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Mô tả:</label>
        <textarea name="description" class="form-control" rows="4"><?= $product['description'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh sản phẩm:</label>
        <input type="file" name="image" class="form-control">
        <?php if (!empty($product['image'])): ?>
            <div class="mt-2">
                <strong>Ảnh hiện tại:</strong> <img src="uploads/<?= $product['image'] ?>" width="100" class="border rounded">
            </div>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success">Lưu lại</button>
        <a href="index.php?page=<?= $page ?? 1 ?>" class="btn btn-secondary">Quay lại</a>
    </div>
</form>