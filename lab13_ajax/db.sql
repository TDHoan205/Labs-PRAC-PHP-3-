CREATE DATABASE IF NOT EXISTS lab13_ajax CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab13_ajax;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0, -- Cột quan trọng cho Xóa mềm
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (code, name, price) VALUES
('P001', 'Laptop Dell XPS 13', 25000000),
('P002', 'MacBook Air M1', 19500000),
('P003', 'Chuột Logitech G102', 450000),
('P004', 'Bàn phím Keychron K2', 1800000),
('P005', 'iPhone 15 Pro Max', 32000000);
 
-- Thêm dữ liệu mẫu để đủ >=10 bản ghi
INSERT INTO products (code, name, price) VALUES
('P006', 'Samsung Galaxy S23', 16000000),
('P007', 'Tai nghe Sony WH-1000XM4', 5500000),
('P008', 'Màn hình LG 27 inch', 4200000),
('P009', 'Ổ cứng SSD 1TB', 2200000),
('P010', 'Camera Webcam Logitech C920', 1500000);