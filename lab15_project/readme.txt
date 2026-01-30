

## Hướng dẫn upload lên hosting

1. **Chuẩn bị**
   - Đảm bảo dự án chạy ổn định trên localhost (XAMPP).
   - Tách file cấu hình cơ sở dữ liệu ra file riêng (config/db.php).
   - Xuất cơ sở dữ liệu từ phpMyAdmin thành file `db.sql`.
   - Nén toàn bộ thư mục dự án thành file `.zip`.

2. **Tạo cơ sở dữ liệu trên hosting**
   - Đăng nhập vào cPanel hoặc DirectAdmin của hosting.
   - Tạo cơ sở dữ liệu mới và một user với quyền truy cập đầy đủ.
   - Lưu lại thông tin Hostname, Database Name, Username, và Password.

3. **Upload source code lên hosting**
   - Đăng nhập vào File Manager trên hosting.
   - Upload file `.zip` của dự án vào thư mục `public_html` (hoặc thư mục tương đương).
   - Giải nén file `.zip`.

4. **Import cơ sở dữ liệu**
   - Đăng nhập vào phpMyAdmin trên hosting.
   - Chọn cơ sở dữ liệu vừa tạo và import file `db.sql`.

5. **Cập nhật cấu hình cơ sở dữ liệu**
   - Mở file `config/db.php` trên hosting.
   - Cập nhật các thông tin: Hostname, Database Name, Username, Password theo thông tin đã tạo ở bước 2.

6. **Kiểm tra và phân quyền**
   - Đảm bảo các thư mục `storage/logs` và `public/uploads` có quyền ghi (CHMOD 777).

7. **Kiểm thử**
   - Truy cập website trên trình duyệt.
   - Kiểm tra các chức năng chính: hiển thị danh sách sản phẩm, phân trang, thêm/sửa/xóa sản phẩm, upload ảnh.

8. **Backup**
   - Tải toàn bộ source code từ File Manager về máy tính (định kỳ hàng tuần).
   - Vào phpMyAdmin trên hosting -> Export cơ sở dữ liệu ra file `.sql` để dự phòng.