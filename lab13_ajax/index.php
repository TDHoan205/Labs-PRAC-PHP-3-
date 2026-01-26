<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lab 13 - Quản lý Sản phẩm (Ajax)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #loading { display: none; color: blue; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">📦 Quản lý Sản phẩm (Live Search + Ajax Delete)</h2>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="txtSearch" class="form-control" placeholder="🔍 Nhập tên hoặc mã sản phẩm...">
            </div>
            <div class="col-md-6 text-end">
                <span id="loading">Đang tải dữ liệu...</span>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã SP</th>
                    <th>Tên Sản phẩm</th>
                    <th>Giá (VND)</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="tbData">
                </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="public/js/app.js"></script>
</body>
</html>