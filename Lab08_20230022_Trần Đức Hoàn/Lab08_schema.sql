-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 15, 2026 lúc 06:38 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_thu_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` > 0),
  `published_year` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL CHECK (`stock` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`book_id`, `title`, `category_id`, `publisher_id`, `price`, `published_year`, `stock`) VALUES
(1, 'Clean Code', 1, 3, 15.50, 2008, 10),
(2, 'Design Patterns', 1, 3, 18.00, 1994, 5),
(3, 'Dế mèn phiêu lưu ký', 4, 1, 5.00, 2010, 20),
(4, 'Lập trình PHP', 1, 2, 12.00, 2021, 7),
(5, 'Kinh tế vi mô', 2, 2, 9.50, 2018, 6),
(6, 'SQL Cơ bản', 1, 2, 11.00, 2020, 8),
(7, 'Harry Potter', 3, 1, 8.00, 2005, 12),
(8, 'Tiếng Anh A1', 5, 2, 6.50, 2019, 9),
(9, 'Python cơ bản', 1, 3, 14.00, 2022, 10),
(10, 'Marketing 101', 2, 2, 10.00, 2017, 4),
(11, 'Cấu trúc dữ liệu', 1, 2, 13.00, 2020, 6),
(12, 'Thiết kế Web', 1, 3, 12.50, 2021, 5),
(13, 'Văn học Việt Nam', 3, 1, 7.50, 2015, 8),
(14, 'Toán rời rạc', 1, 2, 11.50, 2019, 7),
(15, 'Tiếng Anh B1', 5, 2, 7.00, 2020, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'CNTT'),
(2, 'Kinh tế'),
(5, 'Ngoại ngữ'),
(4, 'Thiếu nhi'),
(3, 'Văn học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('BORROWED','RETURNED') DEFAULT 'BORROWED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loans`
--

INSERT INTO `loans` (`loan_id`, `member_id`, `loan_date`, `due_date`, `status`) VALUES
(2, 2, '2024-09-20', '2024-09-30', 'RETURNED'),
(3, 3, '2024-10-05', '2024-10-15', 'BORROWED'),
(4, 4, '2024-09-01', '2024-09-10', 'RETURNED'),
(5, 5, '2024-10-03', '2024-10-13', 'BORROWED'),
(7, 6, '2024-10-02', '2024-10-12', 'BORROWED'),
(8, 7, '2024-10-06', '2024-10-16', 'BORROWED'),
(9, 8, '2024-09-25', '2024-10-05', 'RETURNED'),
(10, 3, '2024-10-08', '2024-10-18', 'BORROWED'),
(11, 2, '2024-10-01', '2024-10-11', 'BORROWED'),
(12, 4, '2024-09-15', '2024-09-25', 'RETURNED'),
(14, 2, '2024-01-10', '2024-01-24', 'BORROWED'),
(16, 2, '2024-01-10', '2024-01-24', 'BORROWED');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loan_items`
--

CREATE TABLE `loan_items` (
  `loan_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL CHECK (`qty` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loan_items`
--

INSERT INTO `loan_items` (`loan_id`, `book_id`, `qty`) VALUES
(3, 3, 2),
(3, 4, 1),
(3, 14, 1),
(5, 5, 1),
(5, 6, 2),
(5, 15, 1),
(7, 7, 1),
(7, 8, 1),
(8, 9, 2),
(10, 10, 1),
(11, 11, 1),
(11, 12, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `members`
--

INSERT INTO `members` (`member_id`, `full_name`, `phone`, `created_at`) VALUES
(2, 'Trần Văn B', '0902222222', '2026-01-15 23:53:49'),
(3, 'Lê Thị C', '0903333333', '2026-01-15 23:53:49'),
(4, 'Phạm Văn D', '0904444444', '2026-01-15 23:53:49'),
(5, 'Hoàng Thị E', '0905555555', '2026-01-15 23:53:49'),
(6, 'Đỗ Văn F', '0906666666', '2026-01-15 23:53:49'),
(7, 'Bùi Thị G', '0907777777', '2026-01-15 23:53:49'),
(8, 'Vũ Văn H', '0908888888', '2026-01-15 23:53:49'),
(11, 'Test', '0909999999', '2026-01-15 23:58:33'),
(14, 'Nguyễn Văn A', '0901234567', '2026-01-16 00:01:15'),
(15, 'Trần Thị B', '0908889999', '2026-01-16 00:01:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `name`) VALUES
(2, 'NXB Giáo Dục'),
(1, 'NXB Trẻ'),
(3, 'OReilly');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `loans_ibfk_1` (`member_id`),
  ADD KEY `idx_loans_status_due` (`status`,`due_date`);

--
-- Chỉ mục cho bảng `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`loan_id`,`book_id`),
  ADD KEY `idx_loan_items_book` (`book_id`);

--
-- Chỉ mục cho bảng `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Chỉ mục cho bảng `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`publisher_id`);

--
-- Các ràng buộc cho bảng `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`loan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
