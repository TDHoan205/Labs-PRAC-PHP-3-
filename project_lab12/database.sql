CREATE DATABASE IF NOT EXISTS project_lab12 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE project_lab12;
-- Tạo bảng employees
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    position VARCHAR(80) NOT NULL,
    salary INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO employees(full_name, phone, position, salary) VALUES
('Nguyen Van A', '0909000111', 'Cashier', 7000000),
('Tran Thi B', '0909000222', 'Sales', 8000000),
('Le Thi C', '0909000333', 'Manager', 12000000),
('Pham Van D', '0909000444', 'Warehouse', 6500000),
('Nguyen Thi E', '0909000555', 'Accountant', 9000000),
('Tran Van F', '0909000666', 'Security', 6000000),
('Bui Thi G', '0909000777', 'HR', 9500000),
('Do Van H', '0909000888', 'IT Support', 10000000),
('Hoang Thi I', '0909000999', 'Marketing', 8500000),
('Pham Van K', '0909000123', 'Sales', 8200000),
('Nguyen Van L', '0909000456', 'Cashier', 7100000),
('Le Thi M', '0909000789', 'Manager', 12500000),
('Tran Van N', '0909000112', 'Warehouse', 6700000),
('Bui Thi O', '0909000223', 'Accountant', 9100000),
('Do Van P', '0909000334', 'Security', 6200000),
('Hoang Thi Q', '0909000445', 'HR', 9700000),
('Pham Van R', '0909000556', 'IT Support', 10200000),
('Nguyen Thi S', '0909000667', 'Marketing', 8700000);
