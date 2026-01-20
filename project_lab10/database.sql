CREATE DATABASE IF NOT EXISTS lab10_sales CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab10_sales;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    sku VARCHAR(50) UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120),
    phone VARCHAR(20)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date DATE NOT NULL,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

CREATE TABLE order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(order_id, product_id),
    FOREIGN KEY(order_id) REFERENCES orders(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
);

-- Dữ liệu mẫu
INSERT INTO customers (full_name, email, phone) VALUES 
('Nguyễn Văn A', 'nguyena@test.com', '0901234567'),
('Trần Thị B', 'tranb@test.com', '0912345678');

INSERT INTO products (name, sku, price, stock) VALUES 
('Laptop Dell Vostro', 'DELL01', 15000000, 10),
('Chuột Logitech', 'LOGI02', 250000, 50),
('Bàn Phím Cơ', 'KEY03', 1200000, 20);