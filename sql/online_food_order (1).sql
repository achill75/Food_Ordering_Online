-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 12:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_food_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CompanyCode` varchar(20) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL,
  `IsDeleted` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`, `CompanyCode`, `Status`, `IsDeleted`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`) VALUES
(14, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'QTT00', '2025-04-14 13:55:49', NULL, 0, 0, '', '2025-04-14 20:55:49', '', '2025-04-14 20:55:49'),
(15, 'gunn', '12345678', 'ahmadgubajbdj@gmail.com', 'QTT00', '2025-04-25 14:51:47', NULL, 0, 0, '', '2025-04-25 21:51:47', '', '2025-04-25 21:51:47'),
(16, 'gunawan', '25d55ad283aa400af464c76d713c07ad', 'asdr@gmail.com', 'QSTE52', '2025-04-25 14:57:36', NULL, 0, 0, '', '2025-04-25 21:57:36', '', '2025-04-25 21:57:36'),
(17, 'gunawan', '202cb962ac59075b964b07152d234b70', 'asd@gmail.com', 'QFE6ZM', '2025-05-05 09:40:31', NULL, 0, 0, '', '2025-05-05 16:40:31', '', '2025-05-05 16:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(222) NOT NULL,
  `codes` varchar(6) NOT NULL,
  `CompanyCode` varchar(20) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL,
  `IsDeleted` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_codes`
--

INSERT INTO `admin_codes` (`id`, `codes`, `CompanyCode`, `Status`, `IsDeleted`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`) VALUES
(2, 'QFE6ZM', NULL, 0, 0, '', '2025-04-14 14:36:32', '', '2025-04-14 14:36:32'),
(5, 'QSTE52', NULL, 0, 0, '', '2025-04-14 14:36:32', '', '2025-04-14 14:36:32'),
(7, 'QTT00', NULL, 0, 0, '', '2025-04-14 20:54:58', '', '2025-04-14 20:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL,
  `CompanyCode` varchar(20) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL,
  `IsDeleted` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`, `CompanyCode`, `Status`, `IsDeleted`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`) VALUES
(25, 50, 'Daging Sengkel Semarang', 'Daging yang lembut perpaduan bumbu yang ciri khas semarang', 90000.00, '67fd19b219518.jpg', NULL, 0, 0, '', '2025-04-14 21:20:34', 'admin', '2025-06-15 15:32:25'),
(26, 56, 'Nasi Goreng Spesial Mantap 2', 'Nasi Goreng yang di Masak Dengan Bumbum Resep Enak', 53000.00, '68059f76d44c8.jpg', NULL, 0, 0, '', '2025-04-21 08:29:26', 'admin', '2025-06-15 15:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `CompanyCode` varchar(20) DEFAULT NULL,
  `IsDeleted` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`, `CompanyCode`, `IsDeleted`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`) VALUES
(81, 58, 'in process', 'Sedang dimassak', '2025-04-25 16:46:50', NULL, 0, '', '2025-04-25 23:46:50', '', '2025-04-25 23:46:50'),
(82, 60, 'in process', 'Makanan Sedang di masak', '2025-05-05 12:43:48', NULL, 0, '', '2025-05-05 19:43:48', '', '2025-05-05 19:43:48'),
(83, 60, 'in process', 'sedang di masak', '2025-05-05 12:45:25', NULL, 0, '', '2025-05-05 19:45:25', '', '2025-05-05 19:45:25'),
(84, 60, 'in process', 'sedang dimasak', '2025-05-05 12:49:39', NULL, 0, '', '2025-05-05 19:49:39', '', '2025-05-05 19:49:39'),
(85, 61, 'in process', 'Sedang di masak', '2025-05-05 12:52:31', NULL, 0, '', '2025-05-05 19:52:31', '', '2025-05-05 19:52:31'),
(86, 62, 'in process', 'Sedang di masak', '2025-05-05 13:00:18', NULL, 0, '', '2025-05-05 20:00:18', '', '2025-05-05 20:00:18'),
(87, 63, 'in process', 'Sedang dimasak', '2025-05-05 13:00:41', NULL, 0, '', '2025-05-05 20:00:41', '', '2025-05-05 20:00:41'),
(88, 62, 'On Delivery', 'Sedang di antar', '2025-05-05 13:03:38', NULL, 0, '', '2025-05-05 20:03:38', '', '2025-05-05 20:03:38'),
(89, 62, 'closed', 'selesai', '2025-05-05 13:07:50', NULL, 0, '', '2025-05-05 20:07:50', '', '2025-05-05 20:07:50'),
(90, 63, 'On Delivery', 'd', '2025-05-05 13:08:17', NULL, 0, '', '2025-05-05 20:08:17', '', '2025-05-05 20:08:17'),
(91, 62, 'closed', 'done', '2025-06-01 08:47:22', NULL, 0, '', '2025-06-01 15:47:22', '', '2025-06-01 15:47:22'),
(92, 62, 'rejected', 'gagal', '2025-06-15 10:47:53', NULL, 0, '', '2025-06-15 17:47:53', '', '2025-06-15 17:47:53'),
(93, 62, 'in process', 'update', '2025-06-15 10:51:21', NULL, 0, '', '2025-06-15 17:51:21', '', '2025-06-15 17:51:21'),
(94, 62, 'in process', 'update', '2025-06-15 10:51:35', NULL, 0, '', '2025-06-15 17:51:35', '', '2025-06-15 17:51:35'),
(95, 62, 'in process', 'update', '2025-06-15 10:51:58', NULL, 0, '', '2025-06-15 17:51:58', '', '2025-06-15 17:51:58'),
(96, 62, 'On Delivery', '1', '2025-06-15 10:52:15', NULL, 0, '', '2025-06-15 17:52:15', '', '2025-06-15 17:52:15'),
(97, 62, 'closed', 'p', '2025-06-15 10:53:36', NULL, 0, '', '2025-06-15 17:53:36', '', '2025-06-15 17:53:36'),
(98, 62, 'rejected', '1', '2025-06-15 10:54:35', NULL, 0, '', '2025-06-15 17:54:35', '', '2025-06-15 17:54:35'),
(99, 62, 'rejected', '1', '2025-06-15 10:56:59', NULL, 0, '', '2025-06-15 17:56:59', '', '2025-06-15 17:56:59'),
(100, 62, 'in process', 'update terbaru', '2025-06-15 10:59:06', NULL, 0, '', '2025-06-15 17:59:06', '', '2025-06-15 17:59:06'),
(101, 62, 'closed', 'terbaru', '2025-06-15 11:01:55', NULL, 0, '', '2025-06-15 18:01:55', '', '2025-06-15 18:01:55'),
(102, 62, 'closed', 'terbaru', '2025-06-15 11:02:19', NULL, 0, '', '2025-06-15 18:02:19', '', '2025-06-15 18:02:19'),
(103, 62, 'closed', 'ue', '2025-06-15 11:02:39', NULL, 0, '', '2025-06-15 18:02:39', '', '2025-06-15 18:02:39'),
(104, 62, 'rejected', 'terbaru', '2025-06-15 11:04:16', NULL, 0, '', '2025-06-15 18:04:16', '', '2025-06-15 18:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CompanyCode` varchar(20) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL,
  `IsDeleted` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`, `CompanyCode`, `Status`, `IsDeleted`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`) VALUES
(50, 13, 'Lara Djonggrang', 'lara.djonggrang@gmail.com', '08856456732', 'Lara-Djonggrang.com', '10am', '7pm', 'every-day', ' Makan di Lara Djonggrang rasanya seperti ada di dalam rumah antik dan museum sekaligus. ', '67d7f664deb5d.jpg', '2025-03-17 10:16:04', NULL, 0, 0, '', '2025-04-14 14:50:56', '', '2025-04-14 14:50:56'),
(56, 13, 'Bunga Rampai', 'bungarampai@gmail.com', '08922407444', 'Bungan-Rampai.com', '8am', '7pm', 'mon-sat', 'Jl.Bsd Selatan No.24 Jakarta Selatan', '68059e4174e06.png', '2025-04-21 01:24:17', NULL, 0, 0, '', '2025-04-21 08:24:17', '', '2025-04-21 08:24:17'),
(57, 17, 'Harum Manis', 'harum.manis@gmail.com', '0878862842', 'harum.manis.com', '8am', '7pm', 'mon-sat', 'Jl. Pahlawan Blok.A9 Prov.Tanggerang', '6806356d87ba8.jpg', '2025-04-21 12:09:17', NULL, 0, 0, '', '2025-04-21 19:09:17', '', '2025-04-21 19:09:17'),
(58, 0, 'Kembang Goela 3', 'kembanggoelo@gmail.com', '087439435267', 'kembang.goelo.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', '  Jl. Jend. Sudirman No.Kav. 47-48 Kota Jakarta Selatan  ', '683477e1eddef.jpg', '2025-05-26 14:17:05', NULL, 0, 0, '', '2025-04-21 19:12:19', 'admin', '2025-05-26 21:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CompanyCode` varchar(20) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `IsDelet` tinyint(4) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdateBy` varchar(32) NOT NULL,
  `LastUpdateDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`, `CompanyCode`, `Status`, `IsDelet`, `CreatedBy`, `CreatedDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
(12, 'Gourmet', '2025-03-17 10:12:32', '', 0, 0, '', '2025-04-25 21:17:34', '', '2025-04-25 21:17:34'),
(13, 'Specialty', '2025-03-17 10:12:09', '', 0, 0, '', '2025-04-25 21:17:34', '', '2025-04-25 21:17:34'),
(17, 'Etnis', '2025-03-17 10:11:48', '', 0, 0, '', '2025-04-25 21:17:34', '', '2025-04-25 21:17:34'),
(20, 'Drinking good', '2025-04-25 17:11:30', '', 0, 0, '', '2025-04-25 22:10:53', 'gunawan', '2025-04-26 00:11:30'),
(21, 'makanan ringan 2', '2025-05-05 09:41:14', '', 0, 0, 'gunawan', '2025-04-25 23:29:25', 'gunawan', '2025-05-05 16:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gross_amount` int(11) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `transaction_status` varchar(50) DEFAULT NULL,
  `snap_token` varchar(100) DEFAULT NULL,
  `full_response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `user_id`, `gross_amount`, `payment_type`, `transaction_time`, `transaction_status`, `snap_token`, `full_response`) VALUES
(1, 'FOOD-1749976475', 37, 53000, 'pending', '2025-06-15 15:34:36', 'pending', '59d33936-e809-4218-94a7-cc62026e4661', NULL),
(2, 'FOOD-1749976826', 37, 53000, 'pending', '2025-06-15 15:40:27', 'pending', 'ff236672-77ec-4d71-a7cb-030d5e62f26d', NULL),
(3, 'FOOD-1749977781', 37, 53000, 'pending', '2025-06-15 15:56:22', 'pending', '90795031-9ec4-4f8b-90b7-2390ac3d96f8', NULL),
(4, 'FOOD-1750212049', 37, 53000, 'pending', '2025-06-18 09:00:51', 'pending', '0c57ad81-9744-4dca-b123-c38900ff155d', NULL),
(5, 'FOOD-1750212052', 37, 53000, 'pending', '2025-06-18 09:00:52', 'pending', 'ead07871-1087-45ea-8cdf-fafa5a4c9882', NULL),
(6, 'FOOD-1750212053', 37, 53000, 'pending', '2025-06-18 09:00:53', 'pending', 'f3cd2045-0981-43b6-911c-f8a9bde92225', NULL),
(7, 'FOOD-1750212074', 37, 53000, 'pending', '2025-06-18 09:01:14', 'pending', '212bd556-d240-4211-be41-aa561c1e5c7f', NULL),
(8, 'FOOD-1750213140', 37, 53000, 'pending', '2025-06-18 09:19:01', 'pending', '317abfdc-0306-47e6-8901-b65300694986', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `oauth_id` varchar(255) DEFAULT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CompanyCode` varchar(20) NOT NULL,
  `StatusIs` tinyint(20) NOT NULL,
  `IsDelet` tinyint(20) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdatedBy` varchar(32) NOT NULL,
  `LastUpdateDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `oauth_id`, `phone`, `password`, `address`, `status`, `date`, `CompanyCode`, `StatusIs`, `IsDelet`, `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdateDate`) VALUES
(37, 'nisa99', 'nisa', 'latansa', 'c.nisalatansa@gmail.com', NULL, '087887094161', 'd0f0b62308f7f394068f27e71d1f8b61', 'jl.gemalapik', 1, '2025-03-09 03:21:06', '', 0, 0, '', '2025-04-25 21:22:21', '', '2025-04-25 21:22:21'),
(38, 'gunawan3', 'Ahmad', 'Gunawan', 'ahmadgunawan22022000@gmail.com', NULL, '081808530029', 'bd5c6fd7d3172d4591c283c1dc3ae9e2', 'Cikarang Selatan', 1, '2025-05-05 12:33:29', '', 0, 0, '', '2025-04-25 21:22:21', '', '2025-05-05 19:33:29'),
(41, 'user', 'Ahmad', 'Gunawan', 'ahmadgunawan@gmail.com', NULL, '081808530029', '25d55ad283aa400af464c76d713c07ad', 'Cikarang Selatan', 1, '2025-05-05 09:11:38', '', 0, 0, '', '2025-05-05 16:11:38', '', '2025-05-05 16:11:38'),
(42, 'choiriyatun nisa latansa', '', '', 'choiriyatunnisal@gmail.com', '117140348698307055904', '', '', '', 1, '2025-06-15 03:03:39', '', 0, 0, '', '2025-05-30 09:47:09', '', '2025-06-15 10:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CompanyCode` varchar(20) NOT NULL,
  `StatusIs` tinyint(50) NOT NULL,
  `IsDelet` tinyint(50) NOT NULL,
  `CreatedBy` varchar(32) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LastUpdateBy` varchar(32) NOT NULL,
  `LastUpdateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`, `CompanyCode`, `StatusIs`, `IsDelet`, `CreatedBy`, `CreatedDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
(62, 41, 'Bebek Bumbu Hitam', 1, 68.00, 'rejected', '2025-06-15 11:04:16', '', 0, 0, '', '2025-05-05 19:59:39', '', '2025-06-15 18:04:16'),
(63, 41, 'Daging Sengkel Semarang', 1, 90.00, 'On Delivery', '2025-05-05 13:08:17', '', 0, 0, '', '2025-05-05 19:59:39', '', '2025-05-05 20:08:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `admin_codes`
--
ALTER TABLE `admin_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
