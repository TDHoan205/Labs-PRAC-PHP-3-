<?php

// 1. Cấu hình đường dẫn tới dữ liệu bài 2
$dataDir = __DIR__ . '/../bai2/data';
$booksFile = $dataDir . '/books.json';

// 2. Đọc dữ liệu sách
$books = [];
if (file_exists($booksFile)) {
    $books = json_decode(file_get_contents($booksFile), true) ?? [];
}

// 3. Tiếp nhận tham số tìm kiếm từ GET
$kw        = trim($_GET['kw'] ?? '');
$category  = $_GET['category'] ?? 'all';
$year_from = isset($_GET['year_from']) && $_GET['year_from'] !== '' ? (int)$_GET['year_from'] : null;
$year_to   = isset($_GET['year_to']) && $_GET['year_to'] !== '' ? (int)$_GET['year_to'] : null;

$categories = ['all', 'Giáo trình', 'Kỹ năng', 'Văn học', 'Khoa học', 'Khác'];

// 4. Thực hiện lọc dữ liệu (Filter)
$results = array_filter($books, function($b) use ($kw, $category, $year_from, $year_to) {
    // Lọc theo Thể loại
    if ($category !== 'all' && $b['category'] !== $category) {
        return false;
    }
    
    // Lọc theo Từ khóa (Tìm trong Tên sách hoặc Tác giả)
    if ($kw !== '') {
        $searchIn = $b['title'] . ' ' . $b['author'];
        if (stripos($searchIn, $kw) === false) {
            return false;
        }
    }
    
    // Lọc theo Năm xuất bản (Từ năm)
    if ($year_from !== null && $b['year'] < $year_from) {
        return false;
    }
    
    // Lọc theo Năm xuất bản (Đến năm)
    if ($year_to !== null && $b['year'] > $year_to) {
        return false;
    }
    
    return true;
});
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống tìm kiếm sách</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f9; padding: 30px; line-height: 1.6; }
        .container { max-width: 1000px; margin: auto; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        
        /* Form Search Style */
        .search-box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .form-row { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 13px; font-weight: bold; margin-bottom: 5px; color: #666; }
        
        input, select { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; outline: none; }
        input:focus { border-color: #3498db; }
        .btn-search { background: #3498db; color: white; border: none; padding: 9px 25px; cursor: pointer; font-weight: bold; border-radius: 4px; transition: 0.3s; }
        .btn-search:hover { background: #2980b9; }
        .btn-reset { color: #7f8c8d; text-decoration: none; font-size: 14px; margin-left: 10px; }

        /* Table Style */
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        th { background: #3498db; color: white; padding: 12px 15px; text-align: left; font-size: 14px; }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f9f9f9; }
        
        .no-result { background: #fff; padding: 30px; text-align: center; color: #95a5a6; border-radius: 8px; }
        .highlight { color: #e67e22; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>🔍 Tìm kiếm sách nâng cao</h2>

    <div class="search-box">
        <form method="get">
            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <label>Từ khóa (Tên/Tác giả)</label>
                    <input type="text" name="kw" value="<?= htmlspecialchars($kw) ?>" placeholder="Nhập tên sách hoặc tác giả...">
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Thể loại</label>
                    <select name="category">
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c ?>" <?= ($category == $c) ? 'selected' : '' ?>>
                                <?= $c === 'all' ? '-- Tất cả --' : $c ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Từ năm</label>
                    <input type="number" name="year_from" value="<?= $year_from ?>" placeholder="1900" style="width: 80px;">
                </div>

                <div class="form-group">
                    <label>Đến năm</label>
                    <input type="number" name="year_to" value="<?= $year_to ?>" placeholder="<?= date('Y') ?>" style="width: 80px;">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-search">Tìm kiếm</button>
                </div>
            </div>
            <?php if($kw || $category != 'all' || $year_from || $year_to): ?>
                <a href="search_books.php" class="btn-reset">✖ Xóa bộ lọc</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if(empty($results)): ?>
        <div class="no-result">
            <p>Không tìm thấy quyển sách nào khớp với điều kiện tìm kiếm.</p>
        </div>
    <?php else: ?>
        <p style="margin-bottom: 10px; font-size: 14px; color: #666;">Tìm thấy <strong><?= count($results) ?></strong> kết quả:</p>
        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Năm</th>
                    <th>Thể loại</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $b): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($b['isbn']) ?></strong></td>
                    <td><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><?= htmlspecialchars($b['year']) ?></td>
                    <td><span style="background: #ebf5fb; padding: 2px 8px; border-radius: 10px; font-size: 12px;"><?= htmlspecialchars($b['category']) ?></span></td>
                    <td><?= htmlspecialchars($b['quantity']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>