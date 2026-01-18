# Bài 2: Quản lý Thư viện

## URL Truy cập
- Trang chủ: `http://localhost:8080/Labs/project_lab09/bai2/public/?c=book&a=index`
- Quản lý Độc giả: `http://localhost:8080/Labs/project_lab09/bai2/public/?c=member&a=index`

## Cấu hình Database
- Host: `localhost`
- Database Name: `it3220_library`
- Username: `root`
- Password: *(trống nếu dùng XAMPP mặc định)*
- Charset: `utf8mb4`

## Cách Import SQL
1. Mở phpMyAdmin tại `http://localhost:8080/phpmyadmin`.
2. Tạo database mới với tên `library`.
3. Import file SQL: `database/library.sql`.
4. Kiểm tra các bảng `books`, `members`, `borrows` đã được tạo thành công.