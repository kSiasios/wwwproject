-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2021 at 12:31 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `projectdb`
--
-- --------------------------------------------------------
--
-- Table structure for table `comments`
--
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `commentValue` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
--
-- Table structure for table `prousers`
--
CREATE TABLE `prousers` (
  `proID` int(11) NOT NULL,
  `proLvl` varchar(128) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
--
-- Table structure for table `userfav`
--
CREATE TABLE `userfav` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `favuid` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `usersID` int(11) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUID` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersIsAdmin` int(1) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
--
-- Table structure for table `usersimg`
--
CREATE TABLE `usersimg` (
  `imgID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
-- Indexes for dumped tables
--
--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
ADD PRIMARY KEY (`id`),
  ADD KEY `FK_commenterID` (`uid`);
--
-- Indexes for table `prousers`
--
ALTER TABLE `prousers`
ADD PRIMARY KEY (`proID`),
  ADD KEY `FK_usersID` (`uID`);
--
-- Indexes for table `userfav`
--
ALTER TABLE `userfav`
ADD PRIMARY KEY (`id`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`usersID`);
--
-- Indexes for table `usersimg`
--
ALTER TABLE `usersimg`
ADD PRIMARY KEY (`imgID`),
  ADD KEY `FK_userID` (`userID`);
--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 41;
--
-- AUTO_INCREMENT for table `prousers`
--
ALTER TABLE `prousers`
MODIFY `proID` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 401;
--
-- AUTO_INCREMENT for table `userfav`
--
ALTER TABLE `userfav`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `usersID` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 490;
--
-- AUTO_INCREMENT for table `usersimg`
--
ALTER TABLE `usersimg`
MODIFY `imgID` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 496;
--
-- Constraints for dumped tables
--
--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `FK_commenterID` FOREIGN KEY (`uid`) REFERENCES `users` (`usersID`);
--
-- Constraints for table `prousers`
--
ALTER TABLE `prousers`
ADD CONSTRAINT `FK_usersID` FOREIGN KEY (`uID`) REFERENCES `users` (`usersID`);
--
-- Constraints for table `userfav`
--
ALTER TABLE `userfav`
ADD CONSTRAINT `FK_User` FOREIGN KEY (`uid`) REFERENCES `users` (`usersID`);
--
-- Constraints for table `usersimg`
--
ALTER TABLE `usersimg`
ADD CONSTRAINT `FK_userID` FOREIGN KEY (`userID`) REFERENCES `users` (`usersID`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;