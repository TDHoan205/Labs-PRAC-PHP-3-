<?php
class EmployeeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Lấy danh sách nhân viên (có tìm kiếm)
     */
    public function getAll($keyword = '') {
        try {
            if (!empty($keyword)) {
                // SỬA LỖI HY093: Dùng 2 tham số riêng biệt cho 2 vị trí so sánh
                $sql = "SELECT * FROM employees 
                        WHERE full_name LIKE :kw_name 
                        OR email LIKE :kw_email 
                        ORDER BY id DESC";
                
                $stmt = $this->pdo->prepare($sql);
                
                // Bind dữ liệu cho cả 2 tham số
                $stmt->execute([
                    ':kw_name'  => "%$keyword%",
                    ':kw_email' => "%$keyword%"
                ]);
            } else {
                // Nếu không tìm kiếm thì lấy hết
                $sql = "SELECT * FROM employees ORDER BY id DESC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Hiện lỗi chi tiết nếu có vấn đề khác
            die("Lỗi SQL: " . $e->getMessage());
        }
    }

    /**
     * Lấy 1 nhân viên theo ID
     */
    public function find($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
             die("Lỗi lấy thông tin: " . $e->getMessage());
        }
    }

    /**
     * Thêm mới
     */
    public function create($data) {
        try {
            $sql = "INSERT INTO employees (full_name, email, phone, position, salary, status) 
                    VALUES (:full_name, :email, :phone, :position, :salary, :status)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':full_name' => $data['full_name'],
                ':email'     => $data['email'],
                ':phone'     => $data['phone'],
                ':position'  => $data['position'],
                ':salary'    => $data['salary'],
                ':status'    => $data['status']
            ]);
        } catch (PDOException $e) {
            die("Lỗi thêm mới: " . $e->getMessage());
        }
    }

    /**
     * Cập nhật
     */
    public function update($id, $data) {
        try {
            $sql = "UPDATE employees 
                    SET full_name = :full_name, 
                        email = :email, 
                        phone = :phone, 
                        position = :position, 
                        salary = :salary, 
                        status = :status 
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            
            // Thêm ID vào mảng data
            $data['id'] = $id;
            
            return $stmt->execute([
                ':full_name' => $data['full_name'],
                ':email'     => $data['email'],
                ':phone'     => $data['phone'],
                ':position'  => $data['position'],
                ':salary'    => $data['salary'],
                ':status'    => $data['status'],
                ':id'        => $id
            ]);
        } catch (PDOException $e) {
            die("Lỗi cập nhật: " . $e->getMessage());
        }
    }

    /**
     * Xóa
     */
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            die("Lỗi xóa: " . $e->getMessage());
        }
    }

    /**
     * Kiểm tra email tồn tại
     */
    public function emailExists($email, $excludeId = null) {
        try {
            $sql = "SELECT COUNT(*) FROM employees WHERE email = :email";
            $params = [':email' => $email];
            
            if ($excludeId) {
                $sql .= " AND id != :id";
                $params[':id'] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}