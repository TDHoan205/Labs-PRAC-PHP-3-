<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/ProductModel.php';

try {
    $q = isset($_GET['q']) ? trim($_GET['q']) : '';
    $model = new ProductModel($conn);
    $data = $model->search($q);
    echo json_encode(['success' => true, 'message' => 'OK', 'data' => $data]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error', 'data' => null]);
}

?>
