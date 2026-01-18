<?php
require_once __DIR__ . '/../models/MemberModel.php';

class MemberController {
    private $model;

    public function __construct() {
        $this->model = new MemberModel();
    }

    public function index() {
        $pageTitle = "Quản lý Độc giả";
        ob_start();
        require __DIR__ . '/../views/members/index.php';
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

        // Xử lý phone rỗng → null
        if (isset($data['phone']) && $data['phone'] === '') {
            $data['phone'] = null;
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

        // Xử lý phone rỗng → null
        if (isset($data['phone']) && $data['phone'] === '') {
            $data['phone'] = null;
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