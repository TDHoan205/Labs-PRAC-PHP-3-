<?php
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Helpers/SessionHelper.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    // Ghi log lỗi (Yêu cầu Lab 15)
    private function logError($msg) {
        $logFile = __DIR__ . '/../../storage/logs/app.log';
        $content = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $msg . PHP_EOL;
        file_put_contents($logFile, $content, FILE_APPEND);
    }

    // Xử lý upload ảnh (Yêu cầu Lab 14)
    private function uploadImage($file) {
        if ($file['error'] !== 0) return null;

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) throw new Exception("File ảnh không hợp lệ.");
        if ($file['size'] > 2 * 1024 * 1024) throw new Exception("File quá lớn (>2MB).");

        $fileName = uniqid() . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/uploads/' . $fileName)) {
            throw new Exception("Không thể lưu file.");
        }
        return $fileName;
    }

    public function index() {
        // Xử lý Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 5; // 5 sản phẩm mỗi trang
        $totalRecords = $this->model->countAll();
        $totalPages = ceil($totalRecords / $limit);
        $page = min($page, $totalPages);

        $offset = ($page - 1) * $limit;
        $products = $this->model->getPaginated($limit, $offset);

        // Load View
        $content = __DIR__ . '/../../views/index.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function form() {
        $product = null;
        if (isset($_GET['id'])) {
            $product = $this->model->getById($_GET['id']);
        }
        $content = __DIR__ . '/../../views/form.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function save() {
        try {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $currentImage = $_POST['current_image'] ?? null;

            $image = $currentImage;
            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadImage($_FILES['image']);
                if ($currentImage && file_exists(__DIR__ . '/../../public/uploads/' . $currentImage)) {
                    unlink(__DIR__ . '/../../public/uploads/' . $currentImage);
                }
            }

            if ($id) {
                $this->model->update([
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'description' => $description,
                    'image' => $image
                ]);
                SessionHelper::setFlash('success', 'Cập nhật sản phẩm thành công!');
            } else {
                $this->model->add([
                    'name' => $name,
                    'price' => $price,
                    'description' => $description,
                    'image' => $image
                ]);
                SessionHelper::setFlash('success', 'Thêm sản phẩm mới thành công!');
            }

            header('Location: index.php?page=' . ($_GET['page'] ?? 1));
            exit;
        } catch (Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: index.php?action=form&page=' . ($_GET['page'] ?? 1));
            exit;
        }
    }

    public function delete() {
        try {
            $id = $_GET['id'];
            $product = $this->model->getById($id);
            
            if ($product && $product['image']) {
                if (file_exists(__DIR__ . '/../../public/uploads/' . $product['image'])) {
                    unlink(__DIR__ . '/../../public/uploads/' . $product['image']);
                }
            }

            $this->model->delete($id);
            SessionHelper::setFlash('success', 'Đã xóa sản phẩm!');
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            SessionHelper::setFlash('danger', 'Xóa thất bại!');
        }
        header('Location: index.php');
    }
}