-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2021 at 07:02 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fontanelle`
--

DELIMITER $$

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

-- DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `PhoneNumber` varchar(255) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--
/*
INSERT INTO `admin` (`Name`, `AdminEmail`, `PhoneNumber`, `UserName`, `Password`) VALUES
('Александр Заяц', 'alexandr@zayats.org', '+380504432829', 'admin', 'f925916e2754e5e03f75dd58a5733251');
*/
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

-- DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) NOT NULL PRIMARY KEY,
  `Name` varchar(150) NOT NULL,
  `StreetId` int(3) NOT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(255) DEFAULT NULL,
  `UserName` varchar(150) DEFAULT NULL,
  `UserPassword` varchar(255) DEFAULT NULL,
  `Size` decimal(5,2) NOT NULL DEFAULT '5.50',
  `TariffId` int(3) NOT NULL DEFAULT 1,
  `Balans` decimal(15,2) NOT NULL DEFAULT '0.00',
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `IsActive` int(1) DEFAULT 1,
  `LastUpdationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*
INSERT INTO `users` (`id`, `Name`, `EmailId`, `UserPassword`, `IsActive`) VALUES
(0, 'РОДНИЧОК', '', '', 1);
-- (2, 'Amit Yadav', 'amity@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 1),
*/

--
-- Table structure for table `cashier`
--

-- DROP TABLE IF EXISTS `cashier`;
CREATE TABLE IF NOT EXISTS `cashier` (
  `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` varchar(150) DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(255) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserPassword` varchar(255) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cashier`
--

/*
INSERT INTO `cashier` (`Name`, `EmailId`, `PhoneNumber`, `UserName`, `UserPassword`) VALUES
('Александр Заяц', 'alexandr@zayats.org', '+380504432829', 'alex', 'f925916e2754e5e03f75dd58a5733251'),
('Елена', '', '', 'elena', 'f925916e2754e5e03f75dd58a5733251'),
('Алиса', '', '', 'alisa', 'f925916e2754e5e03f75dd58a5733251');
*/
-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

DROP TABLE IF EXISTS `streets`;
CREATE TABLE IF NOT EXISTS `streets` (
  `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `streets`
--

INSERT INTO `streets` (`name`) VALUES
('Музейная'),
('Садовая'),
('пер. Садовый'),
('Ромашковая'),
('Родниковая'),
('Озерная'),
('Вишневая'),
('Яблунева'),
('Виноградная'),
('Полиграфистов'),
('Полевая'),
('Лесная'),
('Нова'),
('Центральная'),
('пер. Центральный');

-- --------------------------------------------------------

--
-- Table structure for table `tariffs`
--

-- DROP TABLE IF EXISTS `tariffs`;
CREATE TABLE IF NOT EXISTS `tariffs` (
  `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `day` decimal(4,2) NOT NULL,
  `night` decimal(4,2) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tariffs`
--
/*
INSERT INTO `tariffs` (`day`, `night`) VALUES
(2.00, 1.00),
(1.85, 0.90);
*/
-- -------------------------------------------------------

--
-- Table structure for table `payments`
--

-- DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `cashierId` int(3) NOT NULL,
  `userId` int(3) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `sum` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `few`
--

-- DROP TABLE IF EXISTS `fee`;
CREATE TABLE IF NOT EXISTS `fee` (
  `cashierId` int(3) NOT NULL,
  `userId` int(3) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `sum` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `income`
--

-- DROP TABLE IF EXISTS `income`;
CREATE TABLE IF NOT EXISTS `income` (
  `cashierId` int(3) NOT NULL,
  `userId` int(3) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `sum` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `counters`
--

-- DROP TABLE IF EXISTS `counters`;
CREATE TABLE IF NOT EXISTS `counters` (
  `id` int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userId` int(3) NOT NULL,
  `number` int(15) NOT NULL,
  `name` varchar(25) NOT NULL,
  `info`  varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `counters`
--
/*
INSERT INTO `counters` (`userId`, `number`, `name`) VALUES
(0, 11111111, 'трансформатор');
*/
-- -------------------------------------------------------

--
-- Table structure for table `countValues`
--

-- DROP TABLE IF EXISTS `countValues`;
CREATE TABLE IF NOT EXISTS `countValues` (
  `cId` int(5) NOT NULL,
  `tariffId` int(3) NOT NULL,
  `dPrevius` decimal(8,2) DEFAULT NULL,
  `dCurrent` decimal(8,2) DEFAULT NULL,
  `nPrevius` decimal(8,2) DEFAULT NULL,
  `nCurrent` decimal(8,2) DEFAULT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
