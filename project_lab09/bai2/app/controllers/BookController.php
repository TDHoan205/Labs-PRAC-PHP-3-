<?php
require_once __DIR__ . '/../models/BookModel.php';

class BookController {
    private $model;

    public function __construct() {
        $this->model = new BookModel();
    }

    public function index() {
        $pageTitle = "Quản lý Sách";
        ob_start();
        require __DIR__ . '/../views/books/index.php';
        $pageContent = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    private function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function api_list() {
        $this->json(['success' => true, 'data' => $this->model->getAll()]);
    }

    public function api_get() {
        $id = $_GET['id'] ?? 0;
        $item = $this->model->find($id);
        $this->json($item ? ['success' => true, 'data' => $item] : ['success' => false, 'message' => 'Không tìm thấy']);
    }

    public function api_create() {
        $data = $_POST;

        // Xóa trường id nếu tồn tại
        unset($data['id']);

        // Xử lý các trường optional rỗng → null
        if (isset($data['category']) && $data['category'] === '') {
            $data['category'] = null;
        }

        // Quantity là số, nếu rỗng hoặc không hợp lệ → mặc định 1
        if (!isset($data['quantity']) || $data['quantity'] === '' || $data['quantity'] < 0) {
            $data['quantity'] = 1;
        } else {
            $data['quantity'] = (int)$data['quantity'];
        }

        if (empty($data)) {
            $this->json(['success' => false, 'message' => 'Không nhận được dữ liệu']);
            return;
        }

        $errors = $this->model->validate($data);
        if ($errors) {
            $this->json(['success' => false, 'errors' => $errors]);
            return;
        }

        try {
            $newId = $this->model->create($data);
            $newRecord = $this->model->find($newId);
            $this->json(['success' => true, 'message' => 'Thêm thành công', 'data' => $newRecord]);
        } catch (PDOException $e) {
            $this->json(['success' => false, 'message' => 'Lỗi khi thêm: ' . $e->getMessage()]);
        }
    }

    public function api_update() {
        $id = $_POST['id'] ?? 0;
        if (!$id || !$this->model->find($id)) {
            $this->json(['success' => false, 'message' => 'ID không hợp lệ hoặc không tồn tại']);
            return;
        }

        $data = $_POST;

        // Xử lý optional fields
        if (isset($data['category']) && $data['category'] === '') {
            $data['category'] = null;
        }

        if (isset($data['quantity']) && $data['quantity'] !== '') {
            $data['quantity'] = (int)$data['quantity'];
            if ($data['quantity'] < 0) {
                $data['quantity'] = 0;
            }
        }

        $errors = $this->model->validate($data, $id);
        if ($errors) {
            $this->json(['success' => false, 'errors' => $errors]);
            return;
        }

        try {
            $this->model->update($id, $data);
            $updatedRecord = $this->model->find($id);
            $this->json(['success' => true, 'message' => 'Cập nhật thành công', 'data' => $updatedRecord]);
        } catch (PDOException $e) {
            $this->json(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $e->getMessage()]);
        }
    }

    public function api_delete() {
        $id = $_POST['id'] ?? 0;
        if ($this->model->find($id)) {
            $this->model->delete($id);
            $this->json(['success' => true, 'message' => 'Xóa thành công']);
        } else {
            $this->json(['success' => false, 'message' => 'ID không tồn tại']);
        }
    }
}