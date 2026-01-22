<?php 
// Đảm bảo đường dẫn tới config đúng
require_once __DIR__ . '/../../config/config.php';
require '../app/views/layout/header.php'; 
?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="bi bi-list-ul me-2"></i>Danh sách Nhân viên
        </h4>
    </div>
    <div class="card-body">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                <i class="bi bi-<?php echo ($_SESSION['flash_type'] ?? 'success') === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill me-2"></i>
                <?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash'], $_SESSION['flash_type']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" action="<?php echo url('employees'); ?>" class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" 
                               name="keyword" 
                               class="form-control" 
                               placeholder="Nhập tên hoặc email để tìm..." 
                               value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        
                        <?php if (!empty($keyword)): ?>
                            <a href="<?php echo url('employees'); ?>" class="btn btn-outline-secondary" title="Hủy tìm kiếm">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <div class="col-md-4 text-end">
                <a href="<?php echo url('employees/create'); ?>" class="btn btn-success shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Thêm nhân viên mới
                </a>
            </div>
        </div>

        <?php if (empty($employees)): ?>
            <div class="alert alert-info text-center py-4">
                <div class="display-1 text-info mb-3"><i class="bi bi-search"></i></div>
                <h5>Không tìm thấy nhân viên nào.</h5>
                <p class="text-muted">Thử tìm kiếm với từ khóa khác hoặc thêm nhân viên mới.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Họ và tên</th>
                            <th style="width: 20%;">Email</th>
                            <th style="width: 12%;">Số điện thoại</th>
                            <th style="width: 10%;">Chức vụ</th>
                            <th style="width: 10%;">Lương</th>
                            <th style="width: 8%;">Trạng thái</th>
                            <th style="width: 15%;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($employee['id']); ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($employee['full_name']); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($employee['phone'] ?? '-'); ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark"><?php echo htmlspecialchars($employee['position']); ?></span>
                                </td>
                                <td class="text-end">
                                    <?php echo $employee['salary'] ? number_format($employee['salary'], 0, ',', '.') . ' ₫' : '-'; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($employee['status']): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="bi bi-slash-circle me-1"></i>Ngừng</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo url('employees/edit?id=' . $employee['id']); ?>" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Sửa thông tin">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <a href="<?php echo url('employees/delete?id=' . $employee['id']); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa nhân viên <?php echo htmlspecialchars($employee['full_name']); ?> không?');" 
                                           title="Xóa nhân viên">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3 text-muted">
                <small><i class="bi bi-info-circle me-1"></i>Hiển thị <strong><?php echo count($employees); ?></strong> kết quả.</small>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require '../app/views/layout/footer.php'; ?>