-- ==============================
-- LAB 08 - SCHEMA
-- ==============================

DROP DATABASE IF EXISTS ql_thu_vien;
CREATE DATABASE ql_thu_vien
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ql_thu_vien;

-- ===== categories =====
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- ===== publishers =====
CREATE TABLE publishers (
    publisher_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- ===== books =====
CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category_id INT,
    publisher_id INT,
    price DECIMAL(10,2) NOT NULL CHECK (price > 0),
    published_year INT,
    stock INT NOT NULL CHECK (stock >= 0),
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    FOREIGN KEY (publisher_id) REFERENCES publishers(publisher_id)
);

-- ===== members =====
CREATE TABLE members (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ===== loans =====
CREATE TABLE loans (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('BORROWED','RETURNED') DEFAULT 'BORROWED',
    FOREIGN KEY (member_id) REFERENCES members(member_id)
        ON DELETE RESTRICT
);

-- ===== loan_items =====
CREATE TABLE loan_items (
    loan_id INT,
    book_id INT,
    qty INT NOT NULL CHECK (qty > 0),
    PRIMARY KEY (loan_id, book_id),
    FOREIGN KEY (loan_id) REFERENCES loans(loan_id)
        ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);

-- ==============================
-- INSERT DATA
-- ==============================

INSERT INTO categories(name) VALUES
('CNTT'),('Kinh tế'),('Văn học'),('Thiếu nhi'),('Ngoại ngữ');

INSERT INTO publishers(name) VALUES
('NXB Trẻ'),('NXB Giáo Dục'),('OReilly');

INSERT INTO books(title,category_id,publisher_id,price,published_year,stock) VALUES
('Clean Code',1,3,15.5,2008,10),
('Design Patterns',1,3,18.0,1994,5),
('Dế mèn phiêu lưu ký',4,1,5.0,2010,20),
('Lập trình PHP',1,2,12.0,2021,7),
('Kinh tế vi mô',2,2,9.5,2018,6),
('SQL Cơ bản',1,2,11.0,2020,8),
('Harry Potter',3,1,8.0,2005,12),
('Tiếng Anh A1',5,2,6.5,2019,9),
('Python cơ bản',1,3,14.0,2022,10),
('Marketing 101',2,2,10.0,2017,4),
('Cấu trúc dữ liệu',1,2,13.0,2020,6),
('Thiết kế Web',1,3,12.5,2021,5),
('Văn học Việt Nam',3,1,7.5,2015,8),
('Toán rời rạc',1,2,11.5,2019,7),
('Tiếng Anh B1',5,2,7.0,2020,10);

INSERT INTO members(full_name,phone) VALUES
('Nguyễn Văn A','0901111111'),
('Trần Văn B','0902222222'),
('Lê Thị C','0903333333'),
('Phạm Văn D','0904444444'),
('Hoàng Thị E','0905555555'),
('Đỗ Văn F','0906666666'),
('Bùi Thị G','0907777777'),
('Vũ Văn H','0908888888');

INSERT INTO loans(member_id,loan_date,due_date,status) VALUES
(1,'2024-10-01','2024-10-10','BORROWED'),
(2,'2024-09-20','2024-09-30','RETURNED'),
(3,'2024-10-05','2024-10-15','BORROWED'),
(4,'2024-09-01','2024-09-10','RETURNED'),
(5,'2024-10-03','2024-10-13','BORROWED'),
(1,'2024-09-05','2024-09-15','RETURNED'),
(6,'2024-10-02','2024-10-12','BORROWED'),
(7,'2024-10-06','2024-10-16','BORROWED'),
(8,'2024-09-25','2024-10-05','RETURNED'),
(3,'2024-10-08','2024-10-18','BORROWED'),
(2,'2024-10-01','2024-10-11','BORROWED'),
(4,'2024-09-15','2024-09-25','RETURNED');

INSERT INTO loan_items VALUES
(1,1,1),(1,2,1),
(3,3,2),(3,4,1),
(5,5,1),(5,6,2),
(7,7,1),(7,8,1),
(8,9,2),(10,10,1),
(11,11,1),(11,12,1),
(1,13,1),(3,14,1),
(5,15,1);



-- Phone trùng
INSERT INTO members(full_name,phone)
VALUES ('Test','0901111111');

-- Stock âm
INSERT INTO books(title,price,stock)
VALUES ('Sai stock',10,-1);

-- qty = 0
INSERT INTO loan_items VALUES (1,1,0);


USE ql_thu_vien;

-- Q1: Danh sách sách + danh mục + NXB
SELECT b.book_id, b.title, c.name AS category_name,
       p.name AS publisher_name, b.price, b.stock
FROM books b
JOIN categories c ON b.category_id = c.category_id
JOIN publishers p ON b.publisher_id = p.publisher_id;

-- Q2: Số sách theo danh mục (kể cả danh mục chưa có sách)
SELECT c.name, COUNT(b.book_id) AS total_books
FROM categories c
LEFT JOIN books b ON c.category_id = b.category_id
GROUP BY c.category_id;

-- Q3: Danh sách phiếu mượn
SELECT l.loan_id, m.full_name, l.loan_date, l.due_date, l.status
FROM loans l
JOIN members m ON l.member_id = m.member_id;

-- Q4: Sách đang được mượn
SELECT m.full_name, b.title, li.qty, l.due_date
FROM loans l
JOIN members m ON l.member_id = m.member_id
JOIN loan_items li ON l.loan_id = li.loan_id
JOIN books b ON li.book_id = b.book_id
WHERE l.status = 'BORROWED';

-- Q5: Top 5 sách được mượn nhiều nhất
SELECT b.title, SUM(li.qty) AS total_qty
FROM loan_items li
JOIN books b ON li.book_id = b.book_id
GROUP BY b.book_id
ORDER BY total_qty DESC
LIMIT 5;

-- Q6: Số lần mượn theo thành viên
SELECT m.full_name, COUNT(DISTINCT l.loan_id) AS total_loans
FROM members m
LEFT JOIN loans l ON m.member_id = l.member_id
GROUP BY m.member_id;

-- Q7: Sách chưa từng được mượn
SELECT b.title
FROM books b
LEFT JOIN loan_items li ON b.book_id = li.book_id
WHERE li.book_id IS NULL;

-- Q8: Phiếu mượn quá hạn
SELECT l.loan_id, m.full_name, l.due_date,
       DATEDIFF(CURDATE(), l.due_date) AS overdue_days
FROM loans l
JOIN members m ON l.member_id = m.member_id
WHERE l.status = 'BORROWED'
  AND l.due_date < CURDATE();

-- Q9: Tổng qty theo danh mục (>=5)
SELECT c.name, SUM(li.qty) AS total_qty
FROM loan_items li
JOIN books b ON li.book_id = b.book_id
JOIN categories c ON b.category_id = c.category_id
GROUP BY c.category_id
HAVING total_qty >= 5;

-- Q10: Thành viên mượn >=3 phiếu trong 30 ngày gần nhất
SELECT m.full_name, COUNT(l.loan_id) AS total_loans
FROM members m
JOIN loans l ON m.member_id = l.member_id
WHERE l.loan_date >= CURDATE() - INTERVAL 30 DAY
GROUP BY m.member_id
HAVING total_loans >= 3;

--	13 Chọn truy vấn để tối ưu
--Q4 – Danh sách các sách đang được mượn
SELECT m.full_name, b.title, li.qty, l.due_date
FROM loans l
JOIN members m ON l.member_id = m.member_id
JOIN loan_items li ON l.loan_id = li.loan_id
JOIN books b ON li.book_id = b.book_id
WHERE l.status = 'BORROWED';

EXPLAIN
SELECT m.full_name, b.title, li.qty, l.due_date
FROM loans l
JOIN members m ON l.member_id = m.member_id
JOIN loan_items li ON l.loan_id = li.loan_id
JOIN books b ON li.book_id = b.book_id
WHERE l.status = 'BORROWED';


CREATE INDEX idx_loans_status_due
ON loans(status, due_date);

CREATE INDEX idx_loan_items_book
ON loan_items(book_id);


EXPLAIN
SELECT m.full_name, b.title, li.qty, l.due_date
FROM loans l
JOIN members m ON l.member_id = m.member_id
JOIN loan_items li ON l.loan_id = li.loan_id
JOIN books b ON li.book_id = b.book_id
WHERE l.status = 'BORROWED';


--Q8 – Danh sách phiếu mượn quá hạn
SELECT l.loan_id, m.full_name, l.due_date,
DATEDIFF(CURDATE(), l.due_date) AS overdue_days
FROM loans l
JOIN members m ON l.member_id = m.member_id
WHERE l.status = 'BORROWED'
AND l.due_date < CURDATE();

--14 EXPLAIN TRƯỚC INDEX (Q8)
EXPLAIN
SELECT l.loan_id, m.full_name, l.due_date,
DATEDIFF(CURDATE(), l.due_date) AS overdue_days
FROM loans l
JOIN members m ON l.member_id = m.member_id
WHERE l.status = 'BORROWED'
AND l.due_date < CURDATE();


--15 Tạo INDEX & EXPLAIN LẠI (Q8)
-- Đã tạo ở Q4
CREATE INDEX idx_loans_status_due
ON loans(status, due_date);
EXPLAIN
SELECT l.loan_id, m.full_name, l.due_date,
DATEDIFF(CURDATE(), l.due_date) AS overdue_days
FROM loans l
JOIN members m ON l.member_id = m.member_id
WHERE l.status = 'BORROWED'
AND l.due_date < CURDATE();
 