-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Dec 15, 2023 at 01:52 PM
-- Server version: 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdev_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `listId` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(9999) NOT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `boardId` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User Reference` (`userId`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `List Reference` (`listId`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Board Reference` (`boardId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `User Reference` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `List Reference` FOREIGN KEY (`listId`) REFERENCES `lists` (`id`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `Board Reference` FOREIGN KEY (`boardId`) REFERENCES `boards` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
