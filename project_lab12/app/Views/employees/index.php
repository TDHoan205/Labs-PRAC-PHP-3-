<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: linear-gradient(120deg, #e0eafc, #cfdef3 100%); min-height: 100vh; }
        .main-header {
            background: #0d6efd;
            color: #fff;
            border-radius: 0 0 1.5rem 1.5rem;
            box-shadow: 0 4px 16px rgba(13,110,253,0.08);
            padding: 2rem 1rem 1.5rem 1rem;
            margin-bottom: 2rem;
        }
        .main-header h2 {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .search-bar {
            margin-bottom: 1.5rem;
        }
        .table {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .table th {
            background: #f1f3f6;
            font-weight: 600;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn-action {
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-right: 6px;
        }
        .btn-action:last-child { margin-right: 0; }
        .btn-action.btn-warning { color: #fff; background: #ffc107; border: none; }
        .btn-action.btn-danger { color: #fff; background: #dc3545; border: none; }
        .btn-action.btn-warning:hover { background: #e0a800; }
        .btn-action.btn-danger:hover { background: #bb2d3b; }
        .btn-add {
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.08);
        }
        @media (max-width: 768px) {
            .main-header { padding: 1.2rem 0.5rem 1rem 0.5rem; }
            .table-responsive { font-size: 0.97rem; }
        }
    </style>
</head>
<body>
<div class="container py-3">
    <div class="main-header text-center">
        <h2><i class="fa-solid fa-users"></i> Quản lý nhân viên</h2>
        <div class="mt-2">Hệ thống quản lý nhân sự chuyên nghiệp, hiện đại</div>
    </div>
    <form class="row search-bar g-2 align-items-center" method="get" action="">
        <input type="hidden" name="c" value="employee">
        <input type="hidden" name="a" value="index">
        <div class="col-md-7 col-12">
            <input type="text" name="q" class="form-control form-control-lg" placeholder="🔍 Tìm theo tên hoặc SĐT" value="<?= htmlspecialchars($q) ?>">
        </div>
        <div class="col-md-5 col-12 text-md-end text-start">
            <button class="btn btn-primary btn-lg me-2" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            <a href="index.php?c=employee&a=create" class="btn btn-success btn-lg btn-add"><i class="fa fa-plus-circle"></i> Thêm nhân viên</a>
        </div>
    </form>
    <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle bg-white">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Họ tên</th>
                <th>SĐT</th>
                <th>Vị trí</th>
                <th class="text-end">Lương</th>
                <th>Ngày tạo</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($employees as $emp): ?>
            <tr>
                <td class="text-center fw-bold text-primary-emphasis"><?= htmlspecialchars($emp['id']) ?></td>
                <td><?= htmlspecialchars($emp['full_name']) ?></td>
                <td><?= htmlspecialchars($emp['phone']) ?></td>
                <td><?= htmlspecialchars($emp['position']) ?></td>
                <td class="text-end text-success fw-semibold"><?= number_format($emp['salary']) ?>₫</td>
                <td><?= htmlspecialchars($emp['created_at']) ?></td>
                <td class="text-center">
                    <a href="index.php?c=employee&a=edit&id=<?= $emp['id'] ?>" class="btn-action btn-warning" title="Sửa"><i class="fa fa-pen"></i></a>
                    <a href="index.php?c=employee&a=delete&id=<?= $emp['id'] ?>" class="btn-action btn-danger" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
