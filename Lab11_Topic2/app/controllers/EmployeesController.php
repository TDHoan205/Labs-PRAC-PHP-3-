<?php
// Load các file cần thiết (nếu chưa được load từ index)
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/EmployeeModel.php';

class EmployeesController {
    private $employeeModel;

    public function __construct($pdo) {
        // Khởi tạo Model với kết nối PDO được truyền vào
        $this->employeeModel = new EmployeeModel($pdo);
    }

    /**
     * TRANG DANH SÁCH & TÌM KIẾM
     */
    public function index() {
    $keyword = $_GET['keyword'] ?? '';
    
    // --- THÊM DÒNG NÀY ĐỂ TEST ---
    // var_dump($_GET); die("Dừng lại kiểm tra"); 
    // ----------------------------

    $employees = $this->employeeModel->getAll($keyword);
    require_once __DIR__ . '/../views/employees/index.php';
}
    /**
     * TRANG THÊM MỚI (CREATE)
     */
    public function create() {
        $errors = [];
        // Dữ liệu mặc định cho form
        $data = [
            'full_name' => '',
            'email' => '',
            'phone' => '',
            'position' => '',
            'salary' => '',
            'status' => '1' // Mặc định là Hoạt động
        ];

        // Xử lý khi người dùng bấm nút Lưu (Method POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $data = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'phone'     => trim($_POST['phone'] ?? ''),
                'position'  => trim($_POST['position'] ?? ''),
                'salary'    => trim($_POST['salary'] ?? ''),
                'status'    => $_POST['status'] ?? '1'
            ];

            // --- VALIDATE DỮ LIỆU ---
            $errors = $this->validate($data);

            // Kiểm tra trùng Email (cho trường hợp thêm mới)
            if (empty($errors['email']) && $this->employeeModel->emailExists($data['email'])) {
                $errors['email'] = 'Email này đã tồn tại trong hệ thống.';
            }

            // Nếu không có lỗi -> Lưu vào DB
            if (empty($errors)) {
                // Chuyển salary thành null nếu rỗng
                $saveData = $data;
                $saveData['salary'] = ($data['salary'] === '') ? null : (int)$data['salary'];

                if ($this->employeeModel->create($saveData)) {
                    // Lưu thông báo vào Session
                    $_SESSION['flash'] = 'Thêm nhân viên mới thành công!';
                    $_SESSION['flash_type'] = 'success';
                    
                    // Chuyển hướng về trang danh sách
                    header('Location: ' . url('employees'));
                    exit;
                } else {
                    $errors['general'] = 'Lỗi hệ thống: Không thể thêm nhân viên.';
                }
            }
        }

        // Hiển thị View Create (kèm lỗi nếu có)
        require_once __DIR__ . '/../views/employees/create.php';
    }

    /**
     * TRANG CẬP NHẬT (EDIT)
     */
    public function edit($id) {
        // Lấy thông tin nhân viên cũ
        $employee = $this->employeeModel->find($id);

        // Nếu không tìm thấy ID thì báo lỗi
        if (!$employee) {
            $_SESSION['flash'] = 'Không tìm thấy nhân viên cần sửa.';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . url('employees'));
            exit;
        }

        $errors = [];

        // Xử lý khi người dùng bấm Lưu (Method POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'phone'     => trim($_POST['phone'] ?? ''),
                'position'  => trim($_POST['position'] ?? ''),
                'salary'    => trim($_POST['salary'] ?? ''),
                'status'    => $_POST['status'] ?? '1'
            ];

            // --- VALIDATE DỮ LIỆU ---
            $errors = $this->validate($data);

            // Kiểm tra trùng Email (Trừ chính nhân viên này ra)
            if (empty($errors['email']) && $this->employeeModel->emailExists($data['email'], $id)) {
                $errors['email'] = 'Email này đã thuộc về nhân viên khác.';
            }

            if (empty($errors)) {
                $updateData = $data;
                $updateData['salary'] = ($data['salary'] === '') ? null : (int)$data['salary'];

                if ($this->employeeModel->update($id, $updateData)) {
                    $_SESSION['flash'] = 'Cập nhật thông tin thành công!';
                    $_SESSION['flash_type'] = 'success';
                    header('Location: ' . url('employees'));
                    exit;
                } else {
                    $errors['general'] = 'Lỗi hệ thống: Không thể cập nhật.';
                }
            }

            // Nếu có lỗi, cập nhật lại biến $employee để form giữ lại dữ liệu vừa nhập
            $employee = array_merge($employee, $data);
        }

        // Hiển thị View Edit
        require_once __DIR__ . '/../views/employees/edit.php';
    }

    /**
     * CHỨC NĂNG XÓA (DELETE)
     */
    public function delete($id) {
        if ($this->employeeModel->delete($id)) {
            $_SESSION['flash'] = 'Đã xóa nhân viên thành công!';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash'] = 'Không thể xóa nhân viên này.';
            $_SESSION['flash_type'] = 'danger';
        }
        header('Location: ' . url('employees'));
        exit;
    }

    /**
     * HÀM VALIDATE CHUNG (Dùng cho cả Create và Edit)
     */
    private function validate($data) {
        $errors = [];

        // 1. Validate Họ tên
        if (empty($data['full_name'])) {
            $errors['full_name'] = 'Họ tên là bắt buộc.';
        } elseif (mb_strlen($data['full_name']) < 3 || mb_strlen($data['full_name']) > 120) {
            $errors['full_name'] = 'Họ tên phải từ 3 đến 120 ký tự.';
        }

        // 2. Validate Email
        if (empty($data['email'])) {
            $errors['email'] = 'Email là bắt buộc.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Định dạng email không hợp lệ.';
        }

        // 3. Validate Chức vụ
        if (empty($data['position'])) {
            $errors['position'] = 'Vị trí công việc là bắt buộc.';
        }

        // 4. Validate Lương (Nếu nhập thì phải là số >= 0)
        if ($data['salary'] !== '') {
            if (!is_numeric($data['salary'])) {
                $errors['salary'] = 'Lương phải là số.';
            } elseif ((int)$data['salary'] < 0) {
                $errors['salary'] = 'Lương không được là số âm.';
            }
        }

        // 5. Validate Phone (Tuỳ chọn: Kiểm tra độ dài nếu cần)
        if (!empty($data['phone']) && !preg_match('/^[0-9]{9,15}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ (9-15 số).';
        }

        return $errors;
    }
}