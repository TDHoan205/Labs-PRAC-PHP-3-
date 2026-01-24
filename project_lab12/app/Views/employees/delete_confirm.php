<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận xóa nhân viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: linear-gradient(120deg, #e0eafc, #cfdef3 100%); min-height: 100vh; }
        .card-confirm {
            max-width: 420px;
            margin: 60px auto 0 auto;
            border-radius: 1.2rem;
            box-shadow: 0 2px 16px rgba(220,53,69,0.10);
        }
        .icon-warning {
            font-size: 2.5rem;
            color: #dc3545;
        }
        .btn-lg { font-weight: 600; letter-spacing: 0.5px; }
    </style>
</head>
<body>
<div class="container py-3">
    <div class="card card-confirm p-4 bg-white text-center">
        <div class="icon-warning mb-3"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h4 class="mb-3">Xác nhận xóa nhân viên</h4>
        <div class="alert alert-danger">Bạn có chắc chắn muốn xóa nhân viên <strong><?= htmlspecialchars($employee['full_name']) ?></strong>?</div>
        <form method="post" class="d-flex justify-content-center gap-3 mt-3">
            <button class="btn btn-danger btn-lg px-4" name="confirm" value="1" type="submit"><i class="fa fa-trash"></i> Xóa</button>
            <a href="index.php?c=employee&a=index" class="btn btn-secondary btn-lg px-4"><i class="fa fa-arrow-left"></i> Hủy</a>
        </form>
    </div>
</div>
</body>
</html>
