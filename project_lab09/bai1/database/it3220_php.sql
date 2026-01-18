CREATE DATABASE IF NOT EXISTS it3220_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE it3220_php;

-- Bảng Sinh viên
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Dữ liệu mẫu (5 bản ghi mỗi bảng)
INSERT INTO students (code, full_name, email, dob) VALUES
('SV001', 'Nguyễn Văn An', 'an@example.com', '2000-01-01'),
('SV002', 'Trần Thị Bình', 'binh@example.com', '2000-02-02'),
('SV003', 'Lê Văn Cường', 'cuong@example.com', '2000-03-03'),
('SV004', 'Phạm Thị Dung', 'dung@example.com', '2000-04-04'),
('SV005', 'Hoàng Văn Em', 'em@example.com', '2000-05-05');

