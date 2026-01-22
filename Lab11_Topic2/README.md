# LAB 11 - QUẢN LÝ NHÂN VIÊN

## Hướng dẫn cài đặt

### 1. Tạo Database
- Import file `database.sql` vào MySQL (sử dụng phpMyAdmin hoặc MySQL CLI):
  ```sql
  SOURCE path/to/database.sql;
  ```

### 2. Cấu hình Database
- Mở file `app/config/db.php` và chỉnh sửa thông tin:
  ```php
  $pdo = new PDO(
      'mysql:host=127.0.0.1;dbname=employees_db;charset=utf8mb4',
      'root', // Tên user MySQL
      '',     // Mật khẩu MySQL
      [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
      ]
  );
  ```

### 3. Chạy ứng dụng
- Đảm bảo XAMPP đã bật **Apache** và **MySQL**.
- Truy cập ứng dụng tại:
  ```
  http://localhost:8080/Labs/Lab11_Topic2/public/
  ```