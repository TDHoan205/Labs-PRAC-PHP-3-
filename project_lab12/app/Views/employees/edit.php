<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa nhân viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: linear-gradient(120deg, #e0eafc, #cfdef3 100%); min-height: 100vh; }
        .main-header {
            background: #ffc107;
            color: #212529;
            border-radius: 0 0 1.5rem 1.5rem;
            box-shadow: 0 4px 16px rgba(255,193,7,0.08);
            padding: 2rem 1rem 1.5rem 1rem;
            margin-bottom: 2rem;
        }
        .main-header h2 {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .card-form {
            max-width: 520px;
            margin: 0 auto;
            border-radius: 1.2rem;
            box-shadow: 0 2px 16px rgba(255,193,7,0.10);
        }
        .form-label { font-weight: 600; }
        .btn-lg { font-weight: 600; letter-spacing: 0.5px; }
    </style>
</head>
<body>
<div class="container py-3">
    <div class="main-header text-center">
        <h2><i class="fa-solid fa-user-pen"></i> Sửa nhân viên</h2>
        <div class="mt-2">Cập nhật thông tin nhân viên</div>
    </div>
    <div class="card card-form p-4 bg-white">
    <form method="post">
        <div class="mb-3">
            <label for="full_name" class="form-label">Họ tên <span class="text-danger">*</span></label>
            <input type="text" name="full_name" id="full_name" class="form-control form-control-lg" value="<?= htmlspecialchars($old['full_name'] ?? $employee['full_name']) ?>">
            <?php if (!empty($errors['full_name'])): ?>
                <div class="text-danger small mt-1"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($errors['full_name']) ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
            <input type="text" name="phone" id="phone" class="form-control form-control-lg" value="<?= htmlspecialchars($old['phone'] ?? $employee['phone']) ?>">
            <?php if (!empty($errors['phone'])): ?>
                <div class="text-danger small mt-1"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($errors['phone']) ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Vị trí <span class="text-danger">*</span></label>
            <input type="text" name="position" id="position" class="form-control form-control-lg" value="<?= htmlspecialchars($old['position'] ?? $employee['position']) ?>">
            <?php if (!empty($errors['position'])): ?>
                <div class="text-danger small mt-1"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($errors['position']) ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="salary" class="form-label">Lương <span class="text-danger">*</span></label>
            <input type="number" name="salary" id="salary" class="form-control form-control-lg" value="<?= htmlspecialchars($old['salary'] ?? $employee['salary']) ?>">
            <?php if (!empty($errors['salary'])): ?>
                <div class="text-danger small mt-1"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($errors['salary']) ?></div>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-warning btn-lg px-4 text-white" type="submit"><i class="fa fa-save"></i> Cập nhật</button>
            <a href="index.php?c=employee&a=index" class="btn btn-secondary btn-lg px-4"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
    </div>
</div>
</body>
</html>
