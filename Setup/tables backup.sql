-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 08:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notice_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminId` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminId`, `Username`, `Password`, `Email`) VALUES
(1, 'a', '$2y$10$dVLdsS840BimKqkqQYi/..m.6qs86FFJV0s2Q2XFeBvlSeM5aVFXK', 'admin@gmail.com'),
(2, 'aa', '$2y$10$PhlCoPfqsyQI7iZ5zDoGZucclRH8Y/8MT/qrnmRZreY1lm0MJkTMW', ''),
(6, 'as', '$2y$10$3zPUZvz5gEJt4g/ZxNfu9.zYRZO00FLazGxdECQPAPPsrhhqWms2e', 'admian@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `admin_id`, `login_time`, `logout_time`) VALUES
(1, 1, '2024-10-21 09:50:54', '2024-10-21 09:50:59'),
(2, 1, '2024-10-21 10:02:28', '2024-10-21 10:02:30'),
(3, 1, '2024-10-21 10:56:10', '2024-10-21 12:48:10'),
(4, 1, '2024-10-21 12:48:14', '2024-10-21 13:20:34'),
(5, 1, '2024-10-21 16:28:48', '2024-10-21 16:44:40'),
(6, 1, '2024-10-21 17:49:51', '2024-10-21 17:51:55'),
(7, 1, '2024-10-21 17:53:01', '2024-10-21 18:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `NoticeId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `FilePath` varchar(255) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `Tags` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`NoticeId`, `Title`, `Description`, `FilePath`, `Category`, `Tags`, `CreatedAt`, `AdminId`) VALUES
(2, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(3, '1', '2', '6716335772850.png', NULL, NULL, '2024-10-21 10:56:23', 1),
(4, 'a', 'c', '67163378a1cda.jpg', NULL, NULL, '2024-10-21 10:56:56', 1),
(5, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(6, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(7, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(8, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(9, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(10, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(11, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(12, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(13, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(14, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(15, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(16, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(17, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(18, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(19, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(20, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(21, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(22, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(23, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(24, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(25, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1),
(26, 'Demo', 'Demo Desc', '6716204b4dc36.png', NULL, NULL, '2024-10-21 09:35:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notice_tags`
--

CREATE TABLE `notice_tags` (
  `NoticeId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notice_tags`
--

INSERT INTO `notice_tags` (`NoticeId`, `TagId`) VALUES
(2, 10),
(3, 10),
(4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `TagId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`TagId`, `Name`) VALUES
(10, 'For All Students'),
(1, 'Semester 1'),
(2, 'Semester 2'),
(3, 'Semester 3'),
(4, 'Semester 4'),
(5, 'Semester 5'),
(6, 'Semester 6'),
(7, 'Semester 7'),
(8, 'Semester 8'),
(9, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `LogId` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`LogId`, `user_id`, `login_time`, `logout_time`) VALUES
(1, 1, '2024-10-21 15:32:36', NULL),
(2, 1, '2024-10-21 15:32:41', NULL),
(3, 1, '2024-10-21 15:33:00', NULL),
(4, 1, '2024-10-21 15:33:30', NULL),
(5, 1, '2024-10-21 15:34:54', NULL),
(6, 1, '2024-10-21 15:35:54', NULL),
(7, 1, '2024-10-21 15:37:09', NULL),
(8, 1, '2024-10-21 15:38:22', NULL),
(9, 1, '2024-10-21 15:40:59', NULL),
(10, 1, '2024-10-21 15:41:48', NULL),
(11, 1, '2024-10-21 15:42:23', NULL),
(12, 1, '2024-10-21 15:50:06', NULL),
(13, 1, '2024-10-21 15:55:13', NULL),
(14, 1, '2024-10-21 15:56:36', NULL),
(15, 1, '2024-10-21 15:56:59', NULL),
(16, 1, '2024-10-21 15:58:41', NULL),
(17, 1, '2024-10-21 16:04:41', NULL),
(18, 1, '2024-10-21 16:06:19', NULL),
(19, 1, '2024-10-21 16:08:03', NULL),
(20, 1, '2024-10-21 16:11:58', '2024-10-21 16:11:59'),
(21, 1, '2024-10-21 16:23:31', '2024-10-21 16:23:32'),
(22, 1, '2024-10-21 16:26:40', '2024-10-21 16:26:46'),
(23, 1, '2024-10-21 16:26:52', '2024-10-21 16:26:53'),
(24, 1, '2024-10-21 16:27:58', '2024-10-21 16:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Password`, `Email`) VALUES
(1, 'a', '$2y$10$RB4m1LRVkP9QWhcwW4yW8uR6101UIFlOk8ifvBvCvzm2CSanje6dK', 'anilrathod852005@gmail.com'),
(2, 'aa', '$2y$10$/auT3dYCvLEmn6kzRrVLEeX54cdy2tXk1wyfJy0LNELSwUD00uO0.', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminId`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`NoticeId`),
  ADD KEY `AdminId` (`AdminId`);

--
-- Indexes for table `notice_tags`
--
ALTER TABLE `notice_tags`
  ADD PRIMARY KEY (`NoticeId`,`TagId`),
  ADD KEY `TagId` (`TagId`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`TagId`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`LogId`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `NoticeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `TagId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `LogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`AdminId`);

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`AdminId`) REFERENCES `admins` (`AdminId`);

--
-- Constraints for table `notice_tags`
--
ALTER TABLE `notice_tags`
  ADD CONSTRAINT `notice_tags_ibfk_1` FOREIGN KEY (`NoticeId`) REFERENCES `notices` (`NoticeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `notice_tags_ibfk_2` FOREIGN KEY (`TagId`) REFERENCES `tags` (`TagId`) ON DELETE CASCADE;

--
-- Constraints for table `userlog`
--
ALTER TABLE `userlog`
  ADD CONSTRAINT `userlog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
