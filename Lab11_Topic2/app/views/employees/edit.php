<?php 
require_once __DIR__ . '/../../config/config.php';
require '../app/views/layout/header.php'; 
?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>Sửa Thông tin Nhân viên
        </h4>
    </div>
    <div class="card-body">
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="full_name" class="form-label">
                        Họ và tên <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?php echo !empty($errors['full_name']) ? 'is-invalid' : ''; ?>" 
                           id="full_name" 
                           name="full_name" 
                           value="<?php echo htmlspecialchars($employee['full_name'] ?? ''); ?>" 
                           required>
                    <?php if (!empty($errors['full_name'])): ?>
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($errors['full_name']); ?>
                        </div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Từ 3 đến 120 ký tự</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" 
                           class="form-control <?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>" 
                           id="email" 
                           name="email" 
                           value="<?php echo htmlspecialchars($employee['email'] ?? ''); ?>" 
                           required>
                    <?php if (!empty($errors['email'])): ?>
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($errors['email']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" 
                           class="form-control" 
                           id="phone" 
                           name="phone" 
                           value="<?php echo htmlspecialchars($employee['phone'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="position" class="form-label">
                        Chức vụ <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?php echo !empty($errors['position']) ? 'is-invalid' : ''; ?>" 
                           id="position" 
                           name="position" 
                           value="<?php echo htmlspecialchars($employee['position'] ?? ''); ?>" 
                           required>
                    <?php if (!empty($errors['position'])): ?>
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($errors['position']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="salary" class="form-label">Lương</label>
                    <div class="input-group">
                        <input type="number" 
                               class="form-control <?php echo !empty($errors['salary']) ? 'is-invalid' : ''; ?>" 
                               id="salary" 
                               name="salary" 
                               value="<?php echo htmlspecialchars($employee['salary'] ?? ''); ?>" 
                               min="0" 
                               step="1000">
                        <span class="input-group-text">VNĐ</span>
                        <?php if (!empty($errors['salary'])): ?>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($errors['salary']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <small class="form-text text-muted">Số >= 0 (để trống nếu không có)</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select <?php echo !empty($errors['status']) ? 'is-invalid' : ''; ?>" 
                            id="status" 
                            name="status">
                        <option value="1" <?php echo ($employee['status'] ?? '1') == '1' ? 'selected' : ''; ?>>Hoạt động</option>
                        <option value="0" <?php echo ($employee['status'] ?? '1') == '0' ? 'selected' : ''; ?>>Ngừng</option>
                    </select>
                    <?php if (!empty($errors['status'])): ?>
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($errors['status']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?php echo url('employees'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<?php require '../app/views/layout/footer.php'; ?>