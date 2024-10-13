-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th5 29, 2024 lúc 08:46 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tpts_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pricing`
--

CREATE TABLE `pricing` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `game_id` varchar(5) NOT NULL,
  `adult_price` float NOT NULL,
  `child_price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `pricing`
--

INSERT INTO `pricing` (`id`, `name`, `game_id`, `adult_price`, `child_price`, `date_created`) VALUES
(1, 'Entrance', '0', 5, 5, '2020-11-30 09:27:45'),
(2, 'game All U Can', 'all', 115, 65, '2020-11-30 09:29:14'),
(3, 'game Ticket', '1', 50, 30, '2020-11-30 09:30:44'),
(4, 'game Ticket', '2', 50, 30, '2020-11-30 09:31:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `games`
--

CREATE TABLE `games` (
  `id` int(30) NOT NULL,
  `game` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `games`
--

INSERT INTO `games` (`id`, `game`, `description`, `date_created`) VALUES
(1, 'game 4', 'Khu biển cả', '2020-11-30 09:03:47'),
(2, 'game 2', 'Khu sa mạc', '2020-11-30 09:04:16'),
(3, 'game 3', 'Khu núi cao', '2024-05-25 16:08:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Hệ thống quản lý vé công viên giải trí', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_items`
--

CREATE TABLE `ticket_items` (
  `id` int(30) NOT NULL,
  `ticket_no` varchar(50) NOT NULL,
  `game_id` varchar(5) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Adult,2=Child',
  `ticket_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_items`
--

INSERT INTO `ticket_items` (`id`, `ticket_no`, `game_id`, `type`, `ticket_id`, `date_created`) VALUES
(24, '464281140265', 'all', 2, 1, '2020-11-30 11:13:40'),
(25, '923853725245', 'all', 2, 1, '2020-11-30 11:13:40'),
(26, '745910660254', 'all', 2, 1, '2020-11-30 11:13:40'),
(27, '112398007983', '0', 2, 2, '2020-11-30 11:14:57'),
(28, '694424283587', '0', 2, 2, '2020-11-30 11:14:57'),
(29, '881923647970', '0', 2, 2, '2020-11-30 11:14:57'),
(30, '295200337001', '0', 2, 2, '2020-11-30 11:14:57'),
(31, '634386703173', '0', 2, 2, '2020-11-30 11:14:57'),
(32, '288052419703', '0', 2, 2, '2020-11-30 11:14:57'),
(33, '717927139551', '0', 2, 2, '2020-11-30 11:14:57'),
(34, '338361442836', '0', 2, 2, '2020-11-30 11:14:57'),
(35, '118710645494', '0', 2, 2, '2020-11-30 11:14:57'),
(36, '764495422944', '0', 2, 2, '2020-11-30 11:14:57'),
(37, '189977891424', '0', 2, 2, '2020-11-30 11:14:57'),
(38, '409072780821', '0', 2, 2, '2020-11-30 11:14:57'),
(39, '311889863954', '0', 2, 2, '2020-11-30 11:14:57'),
(40, '107156954800', '0', 2, 2, '2020-11-30 11:14:57'),
(41, '484347209065', '0', 2, 2, '2020-11-30 11:14:57'),
(42, '638469245972', '0', 2, 2, '2020-11-30 11:14:57'),
(43, '884095884722', '0', 2, 2, '2020-11-30 11:14:57'),
(44, '305644172130', '0', 2, 2, '2020-11-30 11:14:57'),
(45, '122929510520', '0', 2, 2, '2020-11-30 11:14:57'),
(46, '553555894924', '0', 2, 2, '2020-11-30 11:14:57'),
(49, '855647843645', 'all', 1, 3, '2020-11-30 13:03:55'),
(50, '524460479419', 'all', 1, 3, '2020-11-30 13:03:55'),
(51, '275259836175', 'all', 2, 3, '2020-11-30 13:03:55'),
(52, '992703329385', '1', 1, 4, '2024-05-25 00:09:51'),
(53, '224775841833', '1', 2, 4, '2024-05-25 00:09:51'),
(54, '389451154076', '0', 1, 5, '2024-05-25 02:03:15'),
(55, '988097387323', '0', 1, 5, '2024-05-25 02:03:15'),
(56, '907460040062', '0', 1, 5, '2024-05-25 02:03:15'),
(57, '090627528717', '0', 1, 5, '2024-05-25 02:03:15'),
(58, '017277299176', '0', 1, 5, '2024-05-25 02:03:15'),
(59, '606849741214', '0', 1, 5, '2024-05-25 02:03:15'),
(60, '202384704342', '0', 1, 5, '2024-05-25 02:03:15'),
(61, '677698133819', '0', 1, 5, '2024-05-25 02:03:15'),
(62, '488568156107', '0', 1, 5, '2024-05-25 02:03:15'),
(63, '200796607352', '0', 1, 5, '2024-05-25 02:03:15'),
(64, '408605943311', '0', 2, 5, '2024-05-25 02:03:15'),
(65, '400202373911', '0', 2, 5, '2024-05-25 02:03:15'),
(66, '887782563103', '0', 2, 5, '2024-05-25 02:03:15'),
(67, '156582052938', '0', 2, 5, '2024-05-25 02:03:15'),
(68, '471095503443', '0', 2, 5, '2024-05-25 02:03:15'),
(69, '208103310715', '0', 2, 5, '2024-05-25 02:03:15'),
(70, '709699613271', '0', 2, 5, '2024-05-25 02:03:15'),
(71, '755848914311', '0', 2, 5, '2024-05-25 02:03:15'),
(72, '177540748558', '0', 2, 5, '2024-05-25 02:03:15'),
(73, '711500652007', '0', 2, 5, '2024-05-25 02:03:16'),
(74, '789492417130', '1', 1, 6, '2024-05-25 02:09:43'),
(75, '133415043200', '1', 1, 6, '2024-05-25 02:09:44'),
(76, '486815683974', '1', 2, 6, '2024-05-25 02:09:44'),
(77, '691271821155', '1', 2, 6, '2024-05-25 02:09:44'),
(78, '931347361012', '0', 1, 7, '2024-05-25 02:10:21'),
(79, '952876696557', '0', 1, 7, '2024-05-25 02:10:21'),
(80, '606254016670', '0', 2, 7, '2024-05-25 02:10:21'),
(81, '552638784668', '0', 2, 7, '2024-05-25 02:10:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_list`
--

CREATE TABLE `ticket_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `no_adult` int(11) NOT NULL,
  `no_child` int(11) NOT NULL,
  `adult_price` float NOT NULL,
  `child_price` float NOT NULL,
  `pricing_id` int(30) NOT NULL,
  `amount` float NOT NULL,
  `tendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_list`
--

INSERT INTO `ticket_list` (`id`, `name`, `no_adult`, `no_child`, `adult_price`, `child_price`, `pricing_id`, `amount`, `tendered`, `date_created`) VALUES
(4, 'Lo Duong', 1, 1, 150, 130, 3, 280, 280, '2024-05-25 00:09:50'),
(5, 'Adam', 10, 10, 50000, 30000, 1, 0, 800000, '2024-05-25 02:03:14'),
(6, 'Duong', 2, 2, 50, 30, 3, 160, 160, '2024-05-25 02:09:43'),
(7, 'Eva', 2, 2, 10, 5, 1, 30, 50, '2024-05-25 02:10:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, '2020-11-26 10:57:04'),
(2, 'John', 'Smith', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 2, '2020-11-30 12:00:11'),
(3, 'Duong', 'Lo Van', '123@gmail.com', '5c82043bf77a49d41231a49251f7c6ef', 2, '2024-05-25 02:11:08');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ticket_items`
--
ALTER TABLE `ticket_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ticket_list`
--
ALTER TABLE `ticket_list`
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
-- AUTO_INCREMENT cho bảng `pricing`
--
ALTER TABLE `pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `games`
--
ALTER TABLE `games`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `ticket_items`
--
ALTER TABLE `ticket_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `ticket_list`
--
ALTER TABLE `ticket_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
