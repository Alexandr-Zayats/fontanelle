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
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES
(0,'РОДНИЧОК',0,'',NULL,NULL,'',5.50,1,0.00,'2021-03-06 15:14:31',1,'2021-03-06 15:14:31'),
(71,'Самаренко Светлана Генриевна',5,'ssamarenko@gmail.com','+38 (067) 703 80 44',NULL,NULL,5.00,1,500.00,'2021-03-07 08:40:41',1,'2021-03-08 18:01:18'),
(99,'Нефьедов В.О.',6,'w@w','+38 (066) 707 19 57',NULL,NULL,6.00,1,0.00,'2021-03-07 08:15:55',1,'2021-03-08 17:58:09'),
(150,'Шевченко Тамара Ильинична',8,'alexandr@zayats.org','+38 (050) 443 28 29',NULL,NULL,5.50,1,0.00,'2021-03-06 15:16:00',1,'2021-03-08 17:59:10'),
(169,'Беляева Татьяна Борисовна',9,'w@w','+38 (097) 638 19 72',NULL,NULL,13.00,1,600.00,'2021-03-07 08:33:44',1,'2021-03-08 18:00:28'),
(189,'Ткаченко Вадим Эдуардович',9,'w@w','+38 (067) 247 51 71',NULL,NULL,6.00,1,0.00,'2021-03-07 08:28:39',1,'2021-03-08 17:59:54'),
(231,'Грецкая Людмила Игоревна',11,'w@w','+38 (050) 982 24 19',NULL,NULL,6.00,1,0.00,'2021-03-07 09:28:30',1,'2021-03-08 18:00:11'),
(367,'Поливянный Виталий Петрович',15,'w@w','+38 (067) 263 18 94',NULL,NULL,6.00,1,0.00,'2021-03-07 09:22:29',1,'2021-03-08 18:00:44');
UNLOCK TABLES;
*/
--
-- --------------------------------------------------

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

DROP TABLE IF EXISTS `tariffs`;
CREATE TABLE IF NOT EXISTS `tariffs` (
  `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `day` decimal(4,2) NOT NULL,
  `night` decimal(4,2) NOT NULL,
  `water` decimal(4,2) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tariffs`
--
INSERT INTO `tariffs` (`day`, `night`, `water`) VALUES
(2.00, 1.00, 17.27),
(1.85, 0.90, 17.27),
(1.68*40.64,31.68*0.5*40.64,0);
-- -------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `cashierId` int(3) NOT NULL,
  `userId` int(3) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `sum` DECIMAL(15,2) NOT NULL,
  `dst` VARCHAR(255) NOT NULL DEFAULT "el"
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--
LOCK TABLES `payments` WRITE;
INSERT INTO `payments` (cashierId,userId,date,sum,dst) VALUES
(3,169,'2021-03-07 08:34:59',600.00,'fee'),
(3,71,'2021-03-07 08:43:45',500.00,'fee'),
(3,99,'2021-03-07 08:17:58',500.00,'el'),
(3,189,'2021-03-07 08:29:47',300.00,'el'),
(3,169,'2021-03-07 08:37:34',100.00,'el'),
(3,367,'2021-03-07 09:23:32',350.00,'el'),
(3,231,'2021-03-07 09:29:32',500.00,'el');
UNLOCK TABLES;
--
-- --------------------------------------------------

--
-- Table structure for table `counters`
--

-- DROP TABLE IF EXISTS `counters`;
CREATE TABLE IF NOT EXISTS `counters` (
  `id` int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userId` int(3) NOT NULL,
  `number` int(15) NOT NULL,
  `name` varchar(25) NOT NULL,
  `type` varchar(6) NOT NULL DEFAULT "el",
  `verDate` TIMESTAMP DEFAULT '2020-01-01',
  `info`  varchar(255) DEFAULT "электричество"
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
LOCK TABLES `counters` WRITE;
/*!40000 ALTER TABLE `counters` DISABLE KEYS */;
INSERT INTO `counters` (userId,number,name) VALUES
(0,11111111,'трансформатор'),
(150,11111111,'дом'),
(99,11111111,'дом'),
(189,11111111,'дом'),
(169,11111111,'дом'),
(71,11111111,'дом'),
(367,11111111,'дом'),
(231,11111111,'дом');
/*!40000 ALTER TABLE `counters` ENABLE KEYS */;
UNLOCK TABLES;
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

--
-- Dumping data for table `countValues`
--

/*
LOCK TABLES `countValues` WRITE;
INSERT INTO `countValues` (cId,tariffId,dPrevius,dCurrent,nPrevius,nCurrent,date) VALUES
(2,1,23300.00,23300.00,10520.00,10520.00,'2021-03-06 15:17:32'),
(3,1,2500.00,2500.00,0.00,0.00,'2021-03-07 08:17:15'),
(3,1,2500.00,2750.00,0.00,0.00,'2021-03-07 08:17:37'),
(4,1,44200.00,44200.00,0.00,0.00,'2021-03-07 08:29:07'),
(4,1,44200.00,44350.00,0.00,0.00,'2021-03-07 08:29:22'),
(5,1,3900.00,3900.00,0.00,0.00,'2021-03-07 08:36:58'),
(5,1,3900.00,3950.00,0.00,0.00,'2021-03-07 08:37:16'),
(7,1,1325.00,1325.00,0.00,0.00,'2021-03-07 09:22:55'),
(7,1,1325.00,1500.00,0.00,0.00,'2021-03-07 09:23:15'),
(8,1,9300.00,9300.00,0.00,0.00,'2021-03-07 09:28:57'),
(8,1,9300.00,9550.00,0.00,0.00,'2021-03-07 09:29:16');
UNLOCK TABLES;
*/

-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
