CREATE DATABASE employees_db;

USE employees_db;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20),
    position VARCHAR(80) NOT NULL,
    salary INT,
    status TINYINT(1) DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);

INSERT INTO employees (full_name, email, phone, position, salary, status, created_at, updated_at) VALUES
('John Doe', 'john.doe@example.com', '1234567890', 'Manager', 50000, 1, NOW(), NOW()),
('Jane Smith', 'jane.smith@example.com', '0987654321', 'Developer', 40000, 1, NOW(), NOW()),
('Alice Johnson', 'alice.johnson@example.com', '1122334455', 'Designer', 35000, 1, NOW(), NOW()),
('Bob Brown', 'bob.brown@example.com', '6677889900', 'Tester', 30000, 1, NOW(), NOW()),
('Charlie White', 'charlie.white@example.com', '4455667788', 'Support', 25000, 1, NOW(), NOW());