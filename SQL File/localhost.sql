-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th7 07, 2024 lúc 07:10 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `abc`
--
CREATE DATABASE IF NOT EXISTS `abc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `abc`;
--
-- Cơ sở dữ liệu: `playful_games`
--
CREATE DATABASE IF NOT EXISTS `playful_games` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `playful_games`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `type`) VALUES
(18, 'Sunrise', 'Indoor Game'),
(23, 'Site Furnishings', 'Indoor Game'),
(24, 'Marlite Panels', 'Outdoor Game'),
(25, 'Construction Clean and Final Clean', 'Male Game '),
(26, 'Casework', 'Female Game'),
(34, 'Keo Co', 'Outdoor Game'),
(35, 'da bong', 'Indoor Game'),
(36, 'Nhay day', 'Indoor Game'),
(38, 'Kids Game', 'Kids Game');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `contact`
--

INSERT INTO `contact` (`id`, `name`, `address`, `phone`, `email`) VALUES
(1, 'Desirae', '346 Dwight Road', '426-913-5743', 'dbenardet0@wikispaces.com'),
(2, 'Dominica', '8 Texas Circle', '163-506-6348', 'drodenborch1@taobao.com'),
(8, 'Minhsfsfs', 'street Park', '099999999999', 'minh@gmail.com'),
(9, 'minh', 'asfsdfasf', '09999999', 'minhD@gmail.com'),
(10, 'Minh Bi Tong', '90 Ho Nuoc Street', 'dfgdfgbghfgfdgs', 'minh.nb.2462@aptechlearning.edu.vn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `instructions` text,
  `video_url` varchar(255) DEFAULT NULL,
  `materials` text,
  `time_required` int DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `id_category` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `games`
--

INSERT INTO `games` (`id`, `name`, `instructions`, `video_url`, `materials`, `time_required`, `document_url`, `id_category`) VALUES
(3, 'Overhold', NULL, 'http://dummyimage.com/133x100.png/dddddd/000000', NULL, 1, 'http://dummyimage.com/138x100.png/dddddd/000000', 18),
(5, 'Fixflex', NULL, 'http://dummyimage.com/148x100.png/5fa2dd/ffffff', NULL, 3, 'http://dummyimage.com/129x100.png/dddddd/000000', 23),
(9, 'Latlux', NULL, 'http://dummyimage.com/180x100.png/ff4444/ffffff', NULL, 7, 'http://dummyimage.com/162x100.png/ff4444/ffffff', 24),
(10, 'Domainer', 'tdgdfgdsg', '66858341e27bd-WIN_20231003_17_11_35_Pro.mp4', 'dgdg', 2024, '66858341e31fe-testconvertgptmd.docx', 25),
(11, 'Viva', NULL, 'http://dummyimage.com/150x100.png/cc0000/ffffff', NULL, 9, 'http://dummyimage.com/232x100.png/cc0000/ffffff', 26),
(12, 'Bigtax', NULL, 'http://dummyimage.com/116x100.png/cc0000/ffffff', NULL, 10, 'http://dummyimage.com/124x100.png/5fa2dd/ffffff', 24),
(21, 'Minh', 'safsfsa', '6685784f49ed0-Tập tành Canva.mp4', 'dfasd', 2024, '6685784f4b0e1-testconvertgptmd.docx', 26),
(23, 'fdsafdsf', 'gdgfdaf', '668626e81c7c3-WIN_20231003_17_11_35_Pro.mp4', 'fdgdgdgdfsdf', 2024, '668626e81dde1-testconvertgptmd.docx', 24);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `itineraries`
--

CREATE TABLE `itineraries` (
  `id` int NOT NULL,
  `location_id` int DEFAULT NULL,
  `game_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `itineraries`
--

INSERT INTO `itineraries` (`id`, `location_id`, `game_id`, `name`, `description`) VALUES
(1, 1, 3, 'Xuyen Viet', 'jhgljmbh;'),
(2, 5, 3, 'Di tim kho bau', 'Kho bau ngoai bien cua ba Truong My Lan');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `geolocation` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `location`
--

INSERT INTO `location` (`id`, `name`, `description`, `latitude`, `longitude`, `geolocation`, `avatar`) VALUES
(1, 'Keo', 'Khong an thi het', 24.000000, 67.000000, 'ha dong', 'uploads/banhtaco.jpeg'),
(2, 'da bong', 'bong da that tot cho suc khoe', 43.000000, 34.000000, 'SVD My Dinh', 'uploads/384116801_6701198899916983_2362850623486892471_n.png'),
(3, 'Co ca ngua', 'fghsg  adfdfdsfa\r\nfsafdvfvf', 43.000000, 34.000000, 'cung thieu nhi', 'uploads/keo4.jpg'),
(4, 'Danh tran gia', 'jkmgnyt', 24.000000, 34.000000, 'ha dong', 'uploads/368403953_842970830708303_1168937975420616107_n.jpg'),
(5, 'Ho boi', 'safdsfsafsdf', 65.000000, 56.000000, 'Ho boi', 'uploads/371473173_1392318331492570_3394874281653212680_n.jpg'),
(6, 'fsafasdf', 'cbcbcvb', 76.000000, 54.000000, 'fgdfg', 'uploads/368403953_842970830708303_1168937975420616107_n.jpg'),
(7, 'gdsg', 'gdsgdg', 76.000000, 54.000000, 'fgdfg', 'uploads/384116801_6701198899916983_2362850623486892471_n.png'),
(8, 'zczczc', 'mnmnmnmn', 76.000000, 89.000000, 'fgdfg', 'uploads/384116801_6701198899916983_2362850623486892471_n.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `role`) VALUES
(1, 'john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
(2, 'admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin'),
(3, 'john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
(4, 'admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin'),
(5, 'john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
(6, 'admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin'),
(7, 'john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
(8, 'admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin'),
(9, 'john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
(10, 'admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin'),
(11, 'dgdfg', 'dgsdg', 'gsfgd', 'gdgd', NULL),
(12, 'minh', '111', '111@gmail.com', '111', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`id_category`);

--
-- Chỉ mục cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Chỉ mục cho bảng `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD CONSTRAINT `itineraries_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `itineraries_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
