-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 04, 2024 lúc 10:01 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ftp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tracking`
--

INSERT INTO `tracking` (`id`, `action`, `path`, `file`, `pic`, `client`, `remark`, `date`) VALUES
(1, 'Delete Selected', 'C:/xampp/htdocs//ftp/Data/lantran', 'QR LABEL.xlsx', 'admin', '192.168.0.81', '', '2023-10-24 14:39:13'),

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dept` varchar(5) NOT NULL,
  `path` varchar(255) NOT NULL,
  `readonly` int(11) NOT NULL DEFAULT 1,
  `isAdmin` int(1) NOT NULL DEFAULT 0,
  `lang` varchar(5) NOT NULL DEFAULT 'en',
  `errorReport` varchar(10) NOT NULL DEFAULT 'false',
  `hiddenFile` varchar(10) NOT NULL DEFAULT 'false',
  `hidePerm` varchar(10) NOT NULL DEFAULT 'false',
  `theme` varchar(10) NOT NULL DEFAULT 'light',
  `guest` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `create_pic` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `dept`, `path`, `readonly`, `isAdmin`, `lang`, `errorReport`, `hiddenFile`, `hidePerm`, `theme`, `guest`, `create_date`, `create_pic`) VALUES
(1, 'admin', '$2y$10$JeUo9sQhenarXQplMnH8UeKgEueGHb9oPV9LyMrWNlXX9n1B8.4mS', '', '', 0, 1, 'en', 'false', 'false', 'false', 'light', '', '2023-10-30 16:44:48', NULL),
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
