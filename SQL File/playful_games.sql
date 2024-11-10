-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th7 09, 2024 lúc 04:07 AM
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
-- Cơ sở dữ liệu: `playful_games`
--

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
(34, 'Keo Co', 'Outdoor Game'),
(35, 'da bong 11 nguoi', 'Kids Game'),
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
(10, 'Minh Bi Tong', '90 Ho Nuoc Street', 'dfgdfgbghfgfdgs', 'minh.nb.2462@aptechlearning.edu.vn'),
(11, 'Minh Bi Tong', 'Hai Duong', '099999999', 'minhbitong@gmail.com'),
(12, 'minh', 'China', '0123456', 'binhminh27022005@gmail.com'),
(13, 'Minh Tật', 'Nhà Thổ', '900046457', 'minh.dq.2415@aptechlearning.edu.vn'),
(14, 'Duy Dị Dạng', 'Nhà Thổ', '0934324353', 'nguyendinhduy2692005@gmail.com'),
(15, 'minhbitong', 'sdfsdfas', '098454543', 'minhbitong@gmail.com'),
(16, 'Minh Bi Tong', 'Nhà Thổ', '900046457', 'minhbitong@gmail.com'),
(17, 'Nguyễn Minh', 'France', '900046457', 'minhbitong@gmail.com');

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
  `id_category` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `games`
--

INSERT INTO `games` (`id`, `name`, `instructions`, `video_url`, `materials`, `time_required`, `document_url`, `id_category`, `image`) VALUES
(25, 'Cau Ca', 'slhsdfohsf hfshf asdfds', '668bb43f35333-Tập tành Canva.mp4', 'fsafsf sertertbtew', 2024, NULL, 34, 'uploads/mywebsite-paint.png'),
(26, 'Minh Bi Tong', 'cv df vcxv gfgdfgag', '668a446083c61-WIN_20231003_17_11_35_Pro.mp4', 'fdgdrbgdfgsdg', 2024, '668a4460849a3-testconvertgptmd.docx', 35, NULL),
(28, 'Nha ma', 'afsfsa fsfasdfsfsfsfsf', '668a4a8677995-WIN_20231003_17_11_35_Pro.mp4', 'asdfsdfsafsdf', 2024, '668a4a86784a7-testconvertgptmd.docx', 35, NULL),
(30, 'Duoi hinh bat chu', 'game duoi hinh bat chu co the choi duoc nhieu nguoi', '668c166396c35-Tập tành Canva.mp4', 'hinh anh, dao cu ', 2024, NULL, 34, 'uploads/vẽ vời.png'),
(36, 'Tro choi dien tu', 'Day la tro choi de gay nghien, khong phu hop voi tre em duoi 12 tuoi', '668c147ae5b3d-Tập tành Canva.mp4', 'May choi game, sac, bo dieu khien', 50, '668c147ae6e85-testconvertgptmd.docx', 36, 'uploads/668c147ae8625-mywebsite-paint.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `game_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(2, 'da bong', 'bong da that tot cho suc khoe', 43.000000, 34.000000, 'SVD My Dinh', 'uploads/384116801_6701198899916983_2362850623486892471_n.png'),
(3, 'Co ca ngua', 'fghsg  adfdfdsfa\r\nfsafdvfvf', 43.000000, 34.000000, 'cung thieu nhi', 'uploads/keo4.jpg'),
(4, 'Danh tran gia', 'jkmgnyt', 24.000000, 34.000000, 'ha dong', 'uploads/368403953_842970830708303_1168937975420616107_n.jpg'),
(5, 'Ho boi', 'safdsfsafsdf', 65.000000, 56.000000, 'Ho boi', 'uploads/371473173_1392318331492570_3394874281653212680_n.jpg'),
(6, 'fsafasdf', 'cbcbcvb', 76.000000, 54.000000, 'fgdfg', 'uploads/368403953_842970830708303_1168937975420616107_n.jpg'),
(7, 'gdsg', 'gdsgdg', 76.000000, 54.000000, 'fgdfg', 'uploads/384116801_6701198899916983_2362850623486892471_n.png'),
(9, 'gdgdgfdg', 'fghfghfssg', 76.000000, 89.000000, 'gdgdsg', 'uploads/vẽ vời.png'),
(10, 'ggcxvx', 'xvxvxcv', 545.000000, 76.000000, '35ghfgh dg', 'uploads/mywebsite-paint.png'),
(11, 'Khong Cam Xuc', 'lad;flhf fdfj\r\nfsdfsd;fldfldfhlsdf', 76.000000, 22.000000, 'falflsfdh', 'uploads/vẽ vời.png');

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
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`);

--
-- Chỉ mục cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itineraries_ibfk_1` (`location_id`),
  ADD KEY `itineraries_ibfk_2` (`game_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD CONSTRAINT `itineraries_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itineraries_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
