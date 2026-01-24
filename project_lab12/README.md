# Quản lý nhân viên - MVC PHP

## Hướng dẫn chạy

1. **Cài đặt XAMPP/Laragon/WAMP** và tạo database `project_lab12`.
2. Import file `database.sql` vào MySQL.
3. Chỉnh sửa file `config/database.php` nếu cần (user/password).
4. Đặt project vào thư mục `htdocs` (XAMPP) hoặc tương ứng.
5. Truy cập trình duyệt: 
   - Danh sách: `http://localhost/Labs/project_lab12/public/index.php?c=employee&a=index`
   - Thêm mới: `http://localhost/Labs/project_lab12/public/index.php?c=employee&a=create`
   - Sửa: `http://localhost/Labs/project_lab12/public/index.php?c=employee&a=edit&id=<id>`
   - Xóa: `http://localhost/Labs/project_lab12/public/index.php?c=employee&a=delete&id=<id>`

## Cấu trúc thư mục
```
PROJECT_LAB12/
├─ public/
│   └─ index.php
├─ core/
│   ├─ Router.php
│   ├─ Controller.php
│   └─ Database.php
├─ app/
│   ├─ Controllers/
│   │   └─ EmployeeController.php
│   ├─ Models/
│   │   └─ Employee.php
│   └─ Views/
│       └─ employees/
│           ├─ index.php
│           ├─ create.php
│           ├─ edit.php
│           └─ delete_confirm.php
├─ config/
│   └─ database.php
└─ database.sql
```

## Tính năng
- Danh sách + tìm kiếm nhân viên
- Thêm, sửa, xóa nhân viên
- Validate dữ liệu, kiểm tra trùng SĐT
- Giao diện Bootstrap chuyên nghiệp
- Bảo mật: PDO, escape dữ liệu

## Liên hệ hỗ trợ
- Email: your@email.com
