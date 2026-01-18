<?php
require_once '../app/core/Database.php';
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM students");
    $res = $stmt->fetch();
    echo "<h2>Kết nối thành công!</h2>";
    echo "<p>Tổng số sinh viên: " . $res['total'] . "</p>";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}