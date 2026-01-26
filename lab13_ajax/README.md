# Lab 13 - Live Search + Ajax (JSON API)


Mục đích
- Demo Live Search (jQuery + Ajax) và Ajax Delete (xóa mềm) không reload trang.

Chuẩn bị
- Sử dụng XAMPP/Laragon (Apache + PHP + MySQL).
- Đặt project vào webroot, ví dụ: c:/xampp/htdocs/Labs/lab13_ajax
- Import `db.sql` (tạo database `lab13_ajax` và bảng `products`).
- Nếu cần, chỉnh kết nối database trong `config/db.php`.

Routes chính
- Trang chính: [index.php](index.php)
- Search (GET): `api/products/search.php?q=...` → JSON `{success,message,data}`
- Delete (POST): `api/products/delete.php` (body form-encoded `id=...`) → JSON `{success,message,data}`

Ghi chú kỹ thuật
- Dùng PDO + Prepared Statements (ngăn SQL injection).
- Xóa mềm: `is_deleted=1` (hàm `softDelete` trong `models/ProductModel.php`).
- API trả JSON nhất quán: `success` (bool), `message` (string), `data` (array|null).

Kiểm thử nhanh
1. Mở `http://localhost/Labs/lab13_ajax/index.php` và thử gõ tìm kiếm.
2. Dùng curl / Postman để gọi API Delete:
```bash
curl -X POST "http://localhost/Labs/lab13_ajax/api/products/delete.php" -d "id=5"
```
3. Kiểm tra `is_deleted` trong DB sau khi xóa.

Tài liệu thêm
- File: `db.sql`, `models/ProductModel.php`, `public/js/app.js`, `api/products/*.php`.

Hãy chụp ảnh Network (DevTools) cho 2 request: search trả JSON và delete trả JSON khi nộp bài.

