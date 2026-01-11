<?php
// Lưu thông báo vào session
function set_flash(string $type, string $message): void {
    $_SESSION['flash'][$type] = $message;
}

// Lấy và xóa thông báo (chỉ hiển thị 1 lần)
function get_flash(string $type): ?string {
    if (empty($_SESSION['flash'][$type])) return null;
    $msg = $_SESSION['flash'][$type];
    unset($_SESSION['flash'][$type]);
    return $msg;
}
