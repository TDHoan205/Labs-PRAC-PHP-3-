<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/ProductModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed', 'data' => null]);
    exit;
}

try {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid id', 'data' => null]);
        exit;
    }

    $model = new ProductModel($conn);
    $ok = $model->softDelete($id);
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Deleted', 'data' => null]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Delete failed', 'data' => null]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error', 'data' => null]);
}

?>
