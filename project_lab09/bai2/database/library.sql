CREATE DATABASE IF NOT EXISTS library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library;



-- Bảng Sách
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(120) NOT NULL,
    category VARCHAR(80) NULL,
    quantity INT NOT NULL DEFAULT 1 CHECK (quantity >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Độc giả
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



INSERT INTO books (isbn, title, author, category, quantity) VALUES
('ISBN001', 'Lập trình PHP Cơ bản', 'Nguyễn Văn A', 'Công nghệ thông tin', 15),
('ISBN002', 'Cơ sở dữ liệu MySQL', 'Trần Thị B', 'Công nghệ thông tin', 10),
('ISBN003', 'Toán rời rạc', 'Lê Văn C', 'Toán học', 20),
('ISBN004', 'Nhập môn Trí tuệ nhân tạo', 'Phạm Thị D', 'Công nghệ thông tin', 8),
('ISBN005', 'Lập trình Java Nâng cao', 'Hoàng Văn E', 'Công nghệ thông tin', 12);

INSERT INTO members (member_code, full_name, email, phone) VALUES
('DG001', 'Nguyễn Văn X', 'x@example.com', '0123456789'),
('DG002', 'Trần Thị Y', 'y@example.com', '0987654321'),
('DG003', 'Lê Văn Z', 'z@example.com', '0111222333'),
('DG004', 'Phạm Thị K', 'k@example.com', '0999888777'),
('DG005', 'Hoàng Văn M', 'm@example.com', '0888777666');