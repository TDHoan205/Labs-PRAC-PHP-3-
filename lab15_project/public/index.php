<?php
require_once __DIR__ . '/../app/Helpers/Logger.php'; // Gọi Logger vào đầu tiên

// --- CẤU HÌNH MÔI TRƯỜNG ---
// Đổi thành false khi upload lên Hosting
define('IS_DEV', false); 

if (IS_DEV) {
    // Môi trường Dev: Hiện lỗi ra màn hình để sửa
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // Môi trường Production (Topic 3): Tắt hiện lỗi, chỉ ghi log
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

require_once __DIR__ . '/../app/Controllers/ProductController.php';

try {
    $ctrl = new ProductController();
    $action = $_GET['action'] ?? 'index';

    if ($action == 'form') $ctrl->form();
    elseif ($action == 'save') $ctrl->save();
    elseif ($action == 'delete') $ctrl->delete();
    else $ctrl->index();

} catch (Throwable $e) {
    // --- XỬ LÝ LOG LỖI (Topic 3) ---

    // 1. Ghi vào file log
    $errorMsg = "Lỗi hệ thống: " . $e->getMessage() . " tại dòng " . $e->getLine() . " file " . $e->getFile();
    Logger::log($errorMsg);

    // 2. Hiển thị thông báo thân thiện cho người dùng
    if (IS_DEV) {
        echo "<pre>$errorMsg</pre>";
    } else {
        // Trên host chỉ hiện dòng này, không hiện code lỗi
        echo "<h1>Hệ thống đang bảo trì. Vui lòng quay lại sau.</h1>";
    }
}