<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Bán Hàng</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="bar page-shell">
            <a href="index.php" class="brand">
                <span class="dot"></span>
                <span>Sales Console</span>
            </a>
            <span class="nav-links">
                <?php $page = $_GET['c'] ?? 'products'; ?>
                <a href="index.php?c=products" class="<?= $page==='products' ? 'active' : '' ?>">Sản phẩm</a>
                <a href="index.php?c=customers" class="<?= $page==='customers' ? 'active' : '' ?>">Khách hàng</a>
                <a href="index.php?c=orders" class="<?= $page==='orders' ? 'active' : '' ?>">Đơn hàng</a>
                <a href="index.php?c=orders&a=create" class="btn btn-sm">+ Tạo đơn</a>
            </span>
        </div>
    </nav>

    <div class="page-shell">
        <div class="hero">
            <h1>Bảng điều khiển bán hàng</h1>
            <p>Tập trung vào hiệu suất, dữ liệu thời gian thực và trải nghiệm hiện đại.</p>
            <div class="actions">
                <a class="btn" href="index.php?c=orders&a=create">Tạo đơn ngay</a>
                <a class="btn btn-ghost" href="index.php?c=products">Xem danh mục</a>
            </div>
        </div>
        <main>