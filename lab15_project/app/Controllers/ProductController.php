<?php
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Helpers/SessionHelper.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    // --- Hàm ghi log (Đáp ứng Topic 3: Log lỗi) ---
    private function logError($msg) {
        // Đảm bảo đường dẫn file log đúng yêu cầu
        $logFile = __DIR__ . '/../../storage/logs/app.log';
        
        // Tạo thư mục nếu chưa có (để tránh lỗi khi mới deploy)
        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $content = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $msg . PHP_EOL;
        file_put_contents($logFile, $content, FILE_APPEND);
    }

    // --- Hàm Upload ảnh (Đã sửa để ghi Log cụ thể) ---
    private function uploadImage($file) {
        if ($file['error'] !== 0) return null;

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // 1. Kiểm tra đuôi file và GHI LOG nếu sai
        if (!in_array($ext, $allowed)) {
            $this->logError("Upload thất bại: Định dạng file không hợp lệ ($ext)"); // <--- THÊM MỚI
            throw new Exception("File ảnh không hợp lệ (Chỉ nhận jpg, png, webp).");
        }

        // 2. Kiểm tra dung lượng và GHI LOG nếu quá lớn
        if ($file['size'] > 2 * 1024 * 1024) {
            $this->logError("Upload thất bại: File quá lớn (" . $file['size'] . " bytes)"); // <--- THÊM MỚI
            throw new Exception("File quá lớn (>2MB).");
        }

        $fileName = uniqid() . '.' . $ext;
        $targetPath = __DIR__ . '/../../public/uploads/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            $this->logError("Upload thất bại: Không thể di chuyển file vào thư mục uploads"); // <--- THÊM MỚI
            throw new Exception("Lỗi hệ thống: Không thể lưu file.");
        }
        
        return $fileName;
    }

    public function index() {
        // Xử lý Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 5; // 5 sản phẩm mỗi trang
        $totalRecords = $this->model->countAll();
        $totalPages = ceil($totalRecords / $limit);
        
        // Ràng buộc page
        if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
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
            $id = $_POST['id'] ?? '';
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'image' => $_POST['current_image'] ?? null
            ];

            // Xử lý file upload
            if (!empty($_FILES['image']['name'])) {
                // Gọi hàm upload (nếu lỗi nó sẽ tự ghi log và ném Exception)
                $newImage = $this->uploadImage($_FILES['image']);
                
                if ($newImage) {
                    // Xóa ảnh cũ nếu có
                    if ($data['image'] && file_exists(__DIR__ . '/../../public/uploads/' . $data['image'])) {
                        unlink(__DIR__ . '/../../public/uploads/' . $data['image']);
                    }
                    $data['image'] = $newImage;
                }
            }

            if ($id) {
                $this->model->update($data);
                SessionHelper::setFlash('success', 'Cập nhật thành công!');
            } else {
                $this->model->add($data);
                SessionHelper::setFlash('success', 'Thêm mới thành công!');
            }

            // PRG Pattern
            header('Location: index.php');
            exit;

        } catch (Exception $e) {
            // Log lỗi chung (Database hoặc Upload)
            $this->logError($e->getMessage()); 
            
            SessionHelper::setFlash('danger', 'Lỗi: ' . $e->getMessage());
            
            // Redirect về lại form để nhập lại
            $redirectUrl = 'index.php?action=form';
            if (!empty($_POST['id'])) {
                $redirectUrl .= '&id=' . $_POST['id'];
            }
            header('Location: ' . $redirectUrl);
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
            $this->logError("Lỗi xóa: " . $e->getMessage());
            SessionHelper::setFlash('danger', 'Xóa thất bại!');
        }
        header('Location: index.php');
    }
}