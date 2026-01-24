<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Employee.php';
class EmployeeController extends Controller {
    public function index() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $model = new Employee();
        $employees = $model->getAll($q);
        $this->render(__DIR__ . '/../Views/employees/index.php', [
            'employees' => $employees,
            'q' => $q
        ]);
    }
    public function create() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $position = trim($_POST['position'] ?? '');
            $salary = trim($_POST['salary'] ?? '');
            if ($full_name === '') {
                $errors['full_name'] = 'Họ tên không được để trống.';
            }
            if (!preg_match('/^0[0-9]{9,10}$/', $phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ.';
            }
            $model = new Employee();
            if ($model->existsPhone($phone)) {
                $errors['phone'] = 'Số điện thoại đã tồn tại.';
            }
            if ($position === '') {
                $errors['position'] = 'Vị trí không được để trống.';
            }
            if (!is_numeric($salary) || $salary < 0) {
                $errors['salary'] = 'Lương phải là số không âm.';
            }
            if (!$errors) {
                $model->insert([
                    'full_name' => $full_name,
                    'phone' => $phone,
                    'position' => $position,
                    'salary' => $salary,
                ]);
                header('Location: index.php?c=employee&a=index');
                exit;
            }
        }
        $this->render(__DIR__ . '/../Views/employees/create.php', [
            'errors' => $errors,
            'old' => $_POST ?? []
        ]);
    }
    public function edit() {
        $id = $_GET['id'] ?? null;
        $model = new Employee();
        $employee = $model->findById($id);
        if (!$employee) {
            echo "Nhân viên không tồn tại.";
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $position = trim($_POST['position'] ?? '');
            $salary = trim($_POST['salary'] ?? '');
            if ($full_name === '') {
                $errors['full_name'] = 'Họ tên không được để trống.';
            }
            if (!preg_match('/^0[0-9]{9,10}$/', $phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ.';
            }
            if ($model->existsPhone($phone, $id)) {
                $errors['phone'] = 'Số điện thoại đã tồn tại.';
            }
            if ($position === '') {
                $errors['position'] = 'Vị trí không được để trống.';
            }
            if (!is_numeric($salary) || $salary < 0) {
                $errors['salary'] = 'Lương phải là số không âm.';
            }
            if (!$errors) {
                $model->update($id, [
                    'full_name' => $full_name,
                    'phone' => $phone,
                    'position' => $position,
                    'salary' => $salary,
                ]);
                header('Location: index.php?c=employee&a=index');
                exit;
            }
        }
        $this->render(__DIR__ . '/../Views/employees/edit.php', [
            'employee' => $employee,
            'errors' => $errors,
            'old' => $_POST ?? $employee
        ]);
    }
    public function delete() {
        $id = $_GET['id'] ?? null;
        $model = new Employee();
        $employee = $model->findById($id);
        if (!$employee) {
            echo "Nhân viên không tồn tại.";
            exit;
        }
        if (isset($_POST['confirm'])) {
            $model->delete($id);
            header('Location: index.php?c=employee&a=index');
            exit;
        }
        $this->render(__DIR__ . '/../Views/employees/delete_confirm.php', [
            'employee' => $employee
        ]);
    }
}
