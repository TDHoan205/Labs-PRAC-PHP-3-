CREATE DATABASE IF NOT EXISTS lab14_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab14_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dữ liệu mẫu để test phân trang (12 cái)
INSERT INTO products (name, price, image) VALUES 
('Laptop Dell XPS', 25000000, NULL), ('MacBook Air M1', 18000000, NULL), ('iPhone 15', 22000000, NULL),
('Samsung S24', 20000000, NULL), ('Tai nghe Sony', 5000000, NULL), ('Chuột Logitech', 1000000, NULL),
('Bàn phím cơ', 2000000, NULL), ('Màn hình LG', 8000000, NULL), ('Loa Marshall', 6000000, NULL),
('iPad Pro', 24000000, NULL), ('Apple Watch', 9000000, NULL), ('Webcam 4K', 3000000, NULL);