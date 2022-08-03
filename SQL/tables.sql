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
SET GLOBAL event_scheduler = ON;
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

CREATE EVENT rentAccrual
  ON SCHEDULE EVERY 1 Year
  STARTS '2023-01-01 00:00:00'
  DO
  update users set BalanceFee=BalanceFee-Size*(select fee from tariffs where id=users.TariffId);
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

DROP TABLE IF EXISTS `users`;
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
  `BalanceEl` decimal(15,2) NOT NULL DEFAULT '0.00',
  `BalanceFee` decimal(15,2) NOT NULL DEFAULT '0.00',
  `BalanceWat` decimal(15,2) NOT NULL DEFAULT '0.00',
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `IsActive` int(1) DEFAULT 1,
  `Info` varchar(250),
  `LastUpdationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `Name`, `StreetId`, `EmailId`, `PhoneNumber`, `UserName`, `UserPassword`, `Size`, `TariffId`, `BalanceEl`, `RegDate`, `IsActive`, `LastUpdationDate`) VALUES
(0,'РОДНИЧОК',0,'alexandr@zayats.org',NULL,'admin','0192023a7bbd73250516f069df18b500',0.00,3,-70635.66,'2021-03-06 15:14:31',1,'2021-03-06 15:14:31'),
(2,'Трипольская Олена Олександровна',1,'hj@jmail.com','096 817 53 13',NULL,NULL,9.61,1,0.00,'2021-03-14 09:27:16',1,'2021-03-29 14:12:26'),
(6,'Козачук В.В',1,'w@w','067',NULL,NULL,4.85,1,-485.00,'2021-03-27 20:09:35',1,'2021-03-27 20:09:35'),
(7,'Макельський Олександр Васильевич',1,'prepressprint@gmail.com','0638517051',NULL,NULL,5.50,1,250.00,'2021-03-14 09:54:47',1,'2021-03-14 09:54:47'),
(19,'Даниленко М.М',2,'w@w','067',NULL,NULL,5.78,1,-578.00,'2021-03-27 19:50:21',1,'2021-03-27 19:50:21'),
(42,'Минакова Анна Вениаминовна',4,'anna@gtp3.kiev.ua','0503315107',NULL,NULL,4.92,1,-492.00,'2021-03-28 17:14:31',1,'2021-03-28 17:14:31'),
(46,'Козинцева Раиса А.',4,'creditline.bdd@gmail.com','0957800816',NULL,NULL,4.97,1,-497.00,'2021-03-28 16:36:40',1,'2021-03-28 16:36:40'),
(47,'Бобровицкая Лидия Степановна',4,'w@w','0975492981',NULL,NULL,4.87,1,-487.00,'2021-03-28 13:53:23',1,'2021-03-28 13:53:23'),
(52,'Картузов Валерий Васильевич',4,'my.kartuz@gmail.com','0971939624',NULL,NULL,4.78,1,-478.00,'2021-03-28 17:29:09',1,'2021-03-28 17:29:09'),
(56,'Линникова  Анна Владимировна',4,'w@w','0676868313',NULL,NULL,5.06,1,-506.00,'2021-03-28 17:25:38',1,'2021-03-28 17:25:38'),
(57,'Минакова Анна Вениаминовна',4,'anna@gtp3.kiev.ua','0503315107',NULL,NULL,4.90,1,-490.00,'2021-03-28 17:11:43',1,'2021-03-28 17:11:43'),
(67,'Зуева Людмила Юрьевна',5,'merired2205@ukr.net','0677356904',NULL,NULL,5.21,1,-521.00,'2021-03-28 17:22:39',1,'2021-03-28 17:22:39'),
(68,'Минакова Анна Вениаминовна',5,'anna@gtp3.kiev.ua','0503315107',NULL,NULL,5.31,1,-531.00,'2021-03-28 17:18:20',1,'2021-03-28 17:18:20'),
(70,'Вязьмитинов Егор Николаевич',5,'w@w','067',NULL,NULL,5.20,1,0.00,'2021-03-27 20:29:17',1,'2021-03-27 20:29:17'),
(71,'Самаренко Светлана Генриевна',5,'ssamarenko@gmail.com','+38 (067) 703 80 44',NULL,NULL,5.52,1,0.00,'2021-03-07 08:40:41',1,'2021-03-13 16:57:54'),
(72,'Борисова Елена Павловна',5,'lyaskovskiy29@gmail.com','0660937870',NULL,NULL,5.29,1,-529.00,'2021-03-28 13:28:50',1,'2021-03-28 13:28:50'),
(81,'Григоренко Руслан Анатольевич',5,'W@w','0504422801',NULL,NULL,16.42,1,-1630.00,'2021-03-27 08:51:48',1,'2021-03-27 08:51:48'),
(99,'Нефьедов В.О.',6,'w@w','+38 (066) 707 19 57',NULL,NULL,6.00,1,-600.00,'2021-03-07 08:15:55',1,'2021-03-12 16:11:28'),
(105,'Черныш Валентина Павловна',6,'w@w','0970249674',NULL,NULL,4.78,1,-478.00,'2021-03-28 06:54:35',1,'2021-03-28 06:54:35'),
(115,'Ткаченко Н.Н',7,'hheLg@ukr.net','0734205003',NULL,NULL,10.18,1,-1018.00,'2021-03-28 14:03:15',1,'2021-03-28 14:03:15'),
(124,'Бирюкова Елена Дмитриевна',7,'w@w','0679441613',NULL,NULL,7.91,1,-791.00,'2021-03-27 20:19:41',1,'2021-03-27 20:19:41'),
(139,'Руденко Олег Васильевич',8,'w@w','067',NULL,NULL,3.13,1,-313.00,'2021-03-27 20:16:11',1,'2021-03-27 20:16:11'),
(150,'Шевченко Тамара Ильинична',8,'alexandr@zayats.org','+38 (050) 443 28 29',NULL,NULL,5.36,1,-536.00,'2021-03-06 15:16:00',1,'2021-03-12 16:11:39'),
(151,'Бурлака Юрий Г.',8,'w@w','0672675202',NULL,NULL,7.06,1,-706.00,'2021-03-27 20:13:01',1,'2021-03-27 20:13:01'),
(154,'Полищук В.И.',8,'w@w','+380501111111',NULL,NULL,5.50,1,-50.00,'2021-03-15 16:29:32',1,'2021-03-15 16:29:32'),
(161,'Ременюк Галина Александровна',9,'galinagalo4ka56@gmail.com','0964858869',NULL,NULL,5.13,1,-513.00,'2021-03-28 13:57:58',1,'2021-03-28 13:57:58'),
(162,'Ткач Алиса Игоревна',9,'alisa.tkach49@gmail.ru','0935846821',NULL,NULL,5.28,1,-528.00,'2021-03-27 20:22:54',1,'2021-03-27 20:22:54'),
(164,'Жарова Лариса Борисовна',9,'zharov1886@gmail.com','0634624949',NULL,NULL,5.60,1,-560.00,'2021-03-28 16:31:34',1,'2021-03-28 16:31:34'),
(167,'Королькова Елена Якимна',9,'tetiana.korolkova419@gmail.com','0636590654',NULL,NULL,4.98,1,-498.00,'2021-03-28 13:35:11',1,'2021-03-28 13:35:11'),
(168,'Пряха Александр Борисович',9,'pryakhaa@gmail.com','0677804046',NULL,NULL,5.17,1,-517.00,'2021-03-28 13:43:50',1,'2021-03-28 13:43:50'),
(169,'Беляева Татьяна Борисовна',9,'w@w','+38 (097) 638 19 72',NULL,NULL,13.06,1,-770.00,'2021-03-07 08:33:44',1,'2021-03-13 17:00:07'),
(181,'Масленко Юрий Пилипович',9,'w@w','067',NULL,NULL,4.90,1,0.00,'2021-03-27 20:05:40',1,'2021-03-27 20:05:40'),
(185,'Сичов Александр Егорович',9,'w@w','0989473893',NULL,NULL,10.31,1,-1031.00,'2021-03-28 14:10:37',1,'2021-03-28 14:10:37'),
(188,'Мусатов Сергей Александрович',9,'w@w','067',NULL,NULL,5.03,1,0.00,'2021-03-28 13:39:02',1,'2021-03-28 13:39:02'),
(189,'Ткаченко Вадим Эдуардович',9,'w@w','+38 (067) 247 51 71',NULL,NULL,5.26,1,0.00,'2021-03-07 08:28:39',1,'2021-03-13 17:05:48'),
(190,'Ермакова Юлианна Г.',9,'yulianayer@gmail.com','0678391810',NULL,NULL,5.23,1,0.00,'2021-04-04 07:03:47',1,'2021-04-04 07:03:47'),
(205,'Махмуд Лика',10,'AS@gmail.ua','0504699543',NULL,NULL,7.77,1,0.00,'2021-03-14 08:44:14',1,'2021-03-15 16:13:30'),
(209,'Шленчак В.В',10,'w@w','0964889279',NULL,NULL,10.43,1,-1043.00,'2021-03-28 17:06:58',1,'2021-03-28 17:06:58'),
(215,'Бохонський Иван Данилович',10,'w@w','067',NULL,NULL,10.15,1,-765.00,'2021-03-27 19:58:01',1,'2021-03-27 19:58:01'),
(220,'Крицький Евгений Анатольевич',11,'jeko@ua.FM','0675050542',NULL,NULL,10.58,1,0.00,'2021-03-14 08:34:57',1,'2021-03-14 08:39:17'),
(226,'Половинки Володимир Степанович',11,'Vpolovynko@gmail.com','0672322564',NULL,NULL,10.39,1,374.00,'2021-03-27 08:19:31',1,'2021-03-27 08:19:31'),
(229,'Вирко Виктория Владимировна',11,'w@w','0675052251',NULL,NULL,4.91,1,-241.00,'2021-04-04 07:40:57',1,'2021-04-04 07:40:57'),
(231,'Грецкая Людмила Игоревна',11,'vlboiko150@gmail.com','+38 (050) 982 24 19',NULL,NULL,5.77,1,0.00,'2021-03-07 09:28:30',1,'2021-03-14 08:16:59'),
(233,'Кравченко И.В.',11,'w@w','0972146814',NULL,NULL,5.50,1,-550.00,'2021-03-28 06:49:15',1,'2021-03-28 06:49:15'),
(247,'Николаенко А.Ю',12,'Juliakrasnova999@gmail.com','0504461744',NULL,NULL,5.44,1,-544.00,'2021-03-28 17:02:56',1,'2021-03-28 17:02:56'),
(248,'Николаенко А.Ю',12,'Juliakrasnova999@gmail.com','0504461744',NULL,NULL,5.77,1,-577.00,'2021-03-28 16:48:35',1,'2021-03-28 16:48:35'),
(253,'Фещенко Катерина Ивановна',12,'w@w','067',NULL,NULL,10.96,1,-1096.00,'2021-03-27 19:53:57',1,'2021-03-27 19:53:57'),
(255,'Бугар Алла Васильевна',12,'W@w','067',NULL,NULL,4.93,1,-493.00,'2021-03-27 08:25:06',1,'2021-03-27 08:25:06'),
(263,'Проминь',13,'W@w','067',NULL,NULL,5.50,1,-550.00,'2021-03-27 08:31:38',1,'2021-03-27 08:31:38'),
(277,'Николаенко А.Ю',12,'Juliakrasnova999@gmail.com','0504461744',NULL,NULL,7.66,1,-766.00,'2021-03-28 16:44:54',1,'2021-03-28 16:44:54'),
(284,'Менська Ганна Михайловна',13,'w@w','0971921969',NULL,NULL,10.20,1,-1020.00,'2021-03-28 13:24:23',1,'2021-03-28 13:24:23'),
(285,'Довгомеля Ирина Владимировна',13,'w@w','067',NULL,NULL,4.75,1,-475.00,'2021-03-27 20:02:28',1,'2021-03-27 20:02:28'),
(340,'Давидов О.М.',14,'w@w','067',NULL,NULL,5.50,1,-550.00,'2021-03-28 06:45:06',1,'2021-03-28 06:45:06'),
(356,'Рудис Татьяна Васильевна',14,'ZGR@jmail.com','0503862090',NULL,NULL,5.48,1,-348.00,'2021-03-14 09:23:40',1,'2021-03-29 14:14:10'),
(367,'Поливянный Виталий Петрович',15,'w@w','+38 (067) 263 18 94',NULL,NULL,11.82,1,-1182.00,'2021-03-07 09:22:29',1,'2021-03-13 17:01:52'),
(368,'Дичко Богдан Петрович',14,'w@w','067',NULL,NULL,4.99,1,-499.00,'2021-03-27 19:46:54',1,'2021-03-27 19:46:54'),
(370,'Дроботун Василь Володимирович',14,'W@w','067',NULL,NULL,10.59,1,-1059.00,'2021-03-27 08:37:36',1,'2021-03-27 08:37:36'),
(386,'Калюта Г.Б.',1,'opal-k@ukr.net','0985287831',NULL,NULL,8.26,1,-826.00,'2021-03-28 13:18:23',1,'2021-03-28 13:18:23'),
(399,'Пряха Александр Борисович',3,'w@w','0677804046',NULL,NULL,7.96,1,-796.00,'2021-03-28 13:48:11',1,'2021-03-28 13:48:11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


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
  `fee` decimal(5,2) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tariffs`
--
INSERT INTO `tariffs` (`day`, `night`, `water`, `fee`) VALUES
(2.00, 1.00, 26.0, 100),
(1.85, 0.90, 17.27, 100),
(1.68*40.64, 1.68*0.5*40.64, 0, 0);
-- -------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `cashierId` int(3) NOT NULL,
  `userId` int(3) NOT NULL,
  `type` BOOLEAN DEFAULT False,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sum` decimal(15,2) NOT NULL,
  `tId` int(3) NOT NULL DEFAULT '1',
  `dst` varchar(10) NOT NULL DEFAULT 'el',
  `dstDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--
LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` (`cashierId`, `userId`, `date`, `sum`, `dst`) VALUES
(3,169,'2021-03-07 08:34:59',600.00,'fee'),
(3,71,'2021-03-07 08:43:45',500.00,'fee'),
(3,99,'2021-03-07 08:17:58',500.00,'el'),
(3,189,'2021-03-07 08:29:47',300.00,'el'),
(3,169,'2021-03-07 08:37:34',100.00,'el'),
(3,367,'2021-03-07 09:23:32',350.00,'el'),
(3,231,'2021-03-07 09:29:32',500.00,'el'),
(3,220,'2021-03-14 08:38:41',1058.00,'fee'),
(3,356,'2021-03-14 09:24:06',200.00,'fee'),
(3,2,'2021-03-14 09:27:46',961.00,'fee'),
(3,189,'2021-03-14 09:40:07',400.00,'el'),
(3,7,'2021-03-14 09:55:04',800.00,'el'),
(1,205,'2021-03-15 16:15:50',426.00,'el'),
(1,205,'2021-03-15 16:16:02',89.00,'el'),
(1,205,'2021-03-15 16:16:40',1554.00,'fee'),
(1,154,'2021-03-15 16:29:49',500.00,'fee'),
(1,231,'2021-03-15 16:33:38',577.00,'fee'),
(3,226,'2021-03-27 08:20:19',374.00,'el'),
(3,226,'2021-03-27 08:20:58',1039.00,'fee'),
(3,255,'2021-03-27 08:26:19',100.00,'el'),
(3,263,'2021-03-27 08:33:17',3640.00,'el'),
(3,370,'2021-03-27 08:39:37',270.00,'el'),
(3,81,'2021-03-27 08:55:39',4194.00,'el'),
(3,368,'2021-03-27 19:48:03',500.00,'el'),
(3,19,'2021-03-27 19:51:03',28.00,'el'),
(3,253,'2021-03-27 19:54:39',300.00,'el'),
(3,215,'2021-03-27 19:58:42',150.00,'el'),
(3,285,'2021-03-27 20:03:13',200.00,'el'),
(3,181,'2021-03-27 20:06:30',400.00,'el'),
(3,7,'2021-03-27 20:07:35',500.00,'el'),
(3,6,'2021-03-27 20:10:23',2000.00,'el'),
(3,151,'2021-03-27 20:13:54',1000.00,'el'),
(3,139,'2021-03-27 20:16:54',260.00,'el'),
(3,124,'2021-03-27 20:20:40',4714.00,'el'),
(3,162,'2021-03-27 20:24:13',890.00,'el'),
(3,215,'2021-03-27 20:25:49',250.00,'fee'),
(3,181,'2021-03-27 20:26:14',490.00,'fee'),
(3,70,'2021-03-27 20:29:42',520.00,'fee'),
(1,340,'2021-03-28 06:47:14',232.00,'el'),
(1,105,'2021-03-28 06:55:10',500.00,'el'),
(1,150,'2021-03-28 07:56:25',4600.00,'el'),
(3,233,'2021-03-28 13:12:25',2689.00,'el'),
(3,386,'2021-03-28 13:19:04',700.00,'el'),
(3,284,'2021-03-28 13:25:07',606.00,'el'),
(3,72,'2021-03-28 13:29:28',20.00,'el'),
(3,72,'2021-03-28 13:30:15',104.00,'el'),
(3,167,'2021-03-28 13:35:56',400.00,'el'),
(3,188,'2021-03-28 13:39:44',26.00,'el'),
(3,188,'2021-03-28 13:40:10',503.00,'fee'),
(3,168,'2021-03-28 13:44:35',800.00,'el'),
(3,399,'2021-03-28 13:50:14',200.00,'el'),
(3,47,'2021-03-28 13:54:09',200.00,'el'),
(3,161,'2021-03-28 13:58:40',600.00,'el'),
(3,115,'2021-03-28 14:04:55',2266.00,'el'),
(3,185,'2021-03-28 14:11:32',200.00,'el'),
(3,164,'2021-03-28 16:32:13',1600.00,'el'),
(3,46,'2021-03-28 16:37:16',240.00,'el'),
(3,277,'2021-03-28 16:46:24',2846.00,'el'),
(3,248,'2021-03-28 16:49:53',2004.00,'el'),
(3,247,'2021-03-28 17:04:24',4729.00,'el'),
(3,209,'2021-03-28 17:07:45',250.00,'el'),
(3,57,'2021-03-28 17:12:47',600.00,'el'),
(3,42,'2021-03-28 17:15:04',100.00,'el'),
(3,68,'2021-03-28 17:19:16',300.00,'el'),
(3,67,'2021-03-28 17:23:16',400.00,'el'),
(3,56,'2021-03-28 17:26:15',800.00,'el'),
(3,52,'2021-03-28 17:29:58',1052.00,'el'),
(1,2,'2021-03-29 14:12:51',212.00,'el'),
(1,356,'2021-03-29 14:14:41',500.00,'el'),
(3,190,'2021-04-04 07:04:30',18.00,'el'),
(3,190,'2021-04-04 07:05:38',523.00,'fee'),
(3,99,'2021-04-04 07:16:12',600.00,'el'),
(3,189,'2021-04-04 07:37:43',400.00,'el'),
(3,229,'2021-04-04 07:41:35',100.00,'el'),
(3,229,'2021-04-04 07:41:57',250.00,'fee'),
(3,189,'2021-04-04 07:44:41',526.00,'fee');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
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
  `date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `type` varchar(6) NOT NULL DEFAULT "el"
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
