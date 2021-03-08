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
--
-- Procedures
--

DROP PROCEDURE IF EXISTS sp_addMoney;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addMoney` (`cashier` INT(3),  `uid` INT(3), `sum` decimal(8,2), `dst` VARCHAR(15))  BEGIN
update users set Balans=(Balans + sum) WHERE id=uid;
IF ( dst="fee" ) THEN
  insert into fee (cashierId, userId, sum) values (cashier, uid, sum);
END IF;
IF ( dst="el" ) THEN
  insert into payments (cashierId, userId, sum) values (cashier, uid, sum);
END IF;
IF ( dst="income" ) THEN
  insert into income (cashierId, userId, sum) values (cashier, uid, sum);
END IF;
END$$

DROP PROCEDURE IF EXISTS sp_addCounterValues;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCounterValues` (`uid` INT(3), `cuid` INT(5), dPrevius decimal(8,2), dCurrent decimal(8,2), nPrevius decimal(8,2), nCurrent decimal(8,2))  BEGIN
IF ( (select dPrevius FROM countValues WHERE cId=cuid AND dPrevius is NOT NULL ORDER BY date DESC LIMIT 1) > 0 ) THEN
  update users set Balans=(Balans - (SELECT day FROM tariffs WHERE id=users.tariffId) * ( dCurrent - dPrevius )) WHERE id=uid;
END IF;
IF ( (select nPrevius FROM countValues WHERE cId=cuid AND dPrevius is NOT NULL ORDER BY date DESC LIMIT 1) > 0 ) THEN
  update users set Balans=(Balans - (SELECT night FROM tariffs WHERE id=users.tariffId) * ( nCurrent - nPrevius )) WHERE id=uid;
END IF;
insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent) values (cuid, (SELECT TariffId FROM users WHERE id=uid), dPrevius, dCurrent, nPrevius, nCurrent);
END$$

DROP PROCEDURE IF EXISTS sp_getLastCounterValues;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getLastCounterValues` (`uid` INT(5))  BEGIN
select dCurrent as dayLast, nCurrent as nightLast from countValues where cId=uid ORDER BY date DESC LIMIT 0,1;
END$$

DROP PROCEDURE IF EXISTS sp_getTariffId;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getTariffId` (`uid` INT(5))  BEGIN
select TariffId from users where id=uid limit 1;
END$$

DROP PROCEDURE IF EXISTS sp_counterList;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_counterList` (`uid` INT(5))  BEGIN
select * from counters where userId=uid AND id>0;
END$$

DROP PROCEDURE IF EXISTS sp_streetList;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_streetList` ()  BEGIN
select * from streets;
END$$

DROP PROCEDURE IF EXISTS sp_totalPayment;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_totalPayment` ()  BEGIN
select SUM(IF(DATE_FORMAT(payments.date, '%Y%m%d')=DATE_FORMAT(CURDATE(), '%Y%m%d'), payments.sum, 0 )) as eDailySum,
SUM(IF(DATE_FORMAT(payments.date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m'), payments.sum, 0)) as eMonthlySum
from payments;
END$$

DROP PROCEDURE IF EXISTS sp_totalPaymentStaf;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_totalPaymentStaf` ()  BEGIN
select SUM(IF(DATE_FORMAT(fee.date, '%Y%m%d')=DATE_FORMAT(CURDATE(), '%Y%m%d'), fee.sum, 0 )) as aDailySum,
SUM(IF(DATE_FORMAT(fee.date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m'), fee.sum, 0)) as aMonthlySum
from fee;
END$$

DROP PROCEDURE IF EXISTS sp_cashierchangepwd;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashierchangepwd` (`newpwd` VARCHAR(120), `uid` INT(5), `name` VARCHAR(200), email VARCHAR(200), phone VARCHAR(120))  BEGIN
update cashier set UserPassword=newpwd,LastUpdationDate=current_timestamp(),Name=name,PhoneNumber=phone,EmailId=email WHERE id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_cashiercurrentpwdvalidate;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashiercurrentpwdvalidate` (`currentpwd` VARCHAR(120), `uid` INT(5))  BEGIN
select id from cashier where id=uid and UserPassword=currentpwd;
END$$

DROP PROCEDURE IF EXISTS sp_cashierlogin;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashierlogin` (IN `username` VARCHAR(200), IN `cashierpwd` VARCHAR(200))  BEGIN
select Name,id,UserName from cashier where UserName=username and UserPassword=cashierpwd;
END$$

DROP PROCEDURE IF EXISTS sp_cashierpasswordrecovery;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashierpasswordrecovery` (`uname` VARCHAR(120), `cashieremail` VARCHAR(200), `newpwd` VARCHAR(150), `ldtime` VARCHAR(120))  BEGIN
update cashier set Password=newpwd,updationDate=ldtime  where  UserName=uname and AdminEmail=cashieremail;
END$$

DROP PROCEDURE IF EXISTS sp_cashierprofile;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashierprofile` (`cashierid` INT(5))  BEGIN
select * from cashier where id=cashierid;
END$$

DROP PROCEDURE IF EXISTS sp_cashierpwdrecoveryvalidation;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cashierpwdrecoveryvalidation` (`uname` VARCHAR(120), `cashieremail` VARCHAR(150))  BEGIN
select id from cashier where UserName=uname and AdminEmail=cashieremail;
END$$

-- -------------------------------------------

DROP PROCEDURE IF EXISTS sp_adminchangepwd;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminchangepwd` (`newpwd` VARCHAR(120), `ldtime` VARCHAR(120), `uid` INT(5))  BEGIN
update admin set Password=newpwd,updationDate=ldtime where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_admincurrentpwdvalidate;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_admincurrentpwdvalidate` (`currentpwd` VARCHAR(120), `uid` INT(5))  BEGIN
select id from admin where id=uid and Password=currentpwd;
END$$

DROP PROCEDURE IF EXISTS sp_admindashboard;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_admindashboard` ()  BEGIN
select count(id) as totalusers,
COUNT(IF((date(RegDate)=CURDATE()),0,NULL)) as todayreguser,
COUNT(IF((date(RegDate)=CURDATE()-1),0,NULL)) as yesterdayreguser,
COUNT(IF((date(RegDate) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()),0,NULL)) as lastsevendaysreguser,
COUNT(IF((date(RegDate) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()),0,NULL)) as lastthirtydaysreguser
from users;
END$$

DROP PROCEDURE IF EXISTS sp_adminlogin;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminlogin` (IN `username` VARCHAR(200), IN `adminpwd` VARCHAR(200))  BEGIN
select Name,id,UserName	from admin where UserName=username and Password=adminpwd;
END$$

DROP PROCEDURE IF EXISTS sp_adminpasswordrecovery;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminpasswordrecovery` (`uname` VARCHAR(120), `adminemail` VARCHAR(200), `newpwd` VARCHAR(150), `ldtime` VARCHAR(120))  BEGIN
update admin set Password=newpwd,updationDate=ldtime  where  UserName=uname and AdminEmail=adminemail;
END$$

DROP PROCEDURE IF EXISTS sp_adminprofile;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminprofile` (`adminid` INT(5))  BEGIN
select * from admin where id=adminid;
END$$

DROP PROCEDURE IF EXISTS sp_adminpwdrecoveryvalidation;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adminpwdrecoveryvalidation` (`uname` VARCHAR(120), `adminemail` VARCHAR(150))  BEGIN
select id from admin where UserName=uname and AdminEmail=adminemail;
END$$

DROP PROCEDURE IF EXISTS sp_allregisteredusers;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_allregisteredusers` ()  BEGIN
select * from users where id > 0;
END$$

DROP PROCEDURE IF EXISTS sp_checkemailavailabilty;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checkemailavailabilty` (`emalid` VARCHAR(150))  BEGIN
select EmailId from users where EmailId=emalid;
END$$

DROP PROCEDURE IF EXISTS sp_checkidavailabilty;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checkidavailabilty` (`uid` int(5))  BEGIN
select * from users where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_recent15payments;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_recent15payments` ()  BEGIN
select payments.sum as sum,
users.id as id,
users.name as name,
users.Balans as credit,
users.IsActive,
users.LastUpdationDate
FROM payments LEFT JOIN users ON (payments.userId=users.id) ORDER BY payments.date DESC LIMIT 15;
END$$

DROP PROCEDURE IF EXISTS sp_addCounter;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCounter` (`uid` int(3), serial decimal(15), `name` VARCHAR(120), `info` VARCHAR(250)) BEGIN
insert into counters (userId, number, name, info) values (uid,serial,name,info);
insert into countValues (cId, tariffId, dCurrent, nCurrent) values ((SELECT id FROM counters WHERE userId=uid LIMIT 0,1), (SELECT TariffId FROM users WHERE id=uid LIMIT 0,1), 0, 0);
END$$

DROP PROCEDURE IF EXISTS sp_registration;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registration` (`uid` int(3), `name` VARCHAR(120), `street` int(3), `phone` VARCHAR(120), `size` VARCHAR(20), `counterNum` DECIMAL(20), `counterName` VARCHAR(120), `counterInfo` VARCHAR(250), `dCurrent` DECIMAL(8,2), `nCurrent` DECIMAL(8,2)) BEGIN
insert into users (id,Name,Size,StreetId,PhoneNumber) values (uid,name,size,street,phone);
insert into counters (userId, number, name, info) values (uid,counterNum,counterName,counterInfo);
insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent) values ((SELECT id FROM counters WHERE userId=uid LIMIT 0,1), (SELECT TariffId FROM users WHERE id=uid LIMIT 0,1), 0, dCurrent, 0, nCurrent);
END$$

DROP PROCEDURE IF EXISTS sp_signup;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_signup` (`name` VARCHAR(120), `emalid` VARCHAR(200), `inputpwd` VARCHAR(200), `isactve` INT(1))  BEGIN
insert into users(Name,EmailId,UserPassword,IsActive) value(name,emalid,inputpwd,isactve);
END$$

DROP PROCEDURE IF EXISTS sp_userchangepwd;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userchangepwd` (`newpwd` VARCHAR(120), `ldtime` VARCHAR(120), `uid` INT(5))  BEGIN
update users set UserPassword=newpwd,LastUpdationDate=ldtime where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_usercurrentpwdvalidate;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usercurrentpwdvalidate` (`currentpwd` VARCHAR(120), `uid` INT(5))  BEGIN
select id from users where id=uid and UserPassword=currentpwd;
END$$

DROP PROCEDURE IF EXISTS sp_userdeletion;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userdeletion` (`uid` INT(5))  BEGIN
delete from users where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_useremailupdation;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_useremailupdation` (`newemail` VARCHAR(120), `ldtime` VARCHAR(120), `uid` INT(5))  BEGIN
update users set EmailId=newemail,LastUpdationDate=ldtime where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_userlogin;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userlogin` (IN `uemailid` VARCHAR(200), IN `userpwd` VARCHAR(200))  BEGIN
select Name,id from users where EmailId=uemailid and UserPassword=userpwd;
END$$

DROP PROCEDURE IF EXISTS sp_userpasswordrecovery;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userpasswordrecovery` (`name` VARCHAR(120), `useremailid` VARCHAR(200), `newpwd` VARCHAR(150), `ldtime` VARCHAR(120))  BEGIN
update users set UserPassword=newpwd,LastUpdationDate=ldtime  where Name=name and EmailId=useremailid;
END$$

DROP PROCEDURE IF EXISTS sp_userprofile;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userprofile` (`uid` INT(5))  BEGIN
select * from users where id=uid;
END$$

DROP PROCEDURE IF EXISTS sp_userpwdrecoveryvalidation;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userpwdrecoveryvalidation` (`name` VARCHAR(120), `useremail` VARCHAR(150))  BEGIN
select id from users where Name=name and EmailId=useremail;
END$$

DROP PROCEDURE IF EXISTS sp_userupdateprofile;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userupdateprofile` (`uid` INT(5), `name` VARCHAR(120), `email` VARCHAR(120), `phone` VARCHAR(30), size INT(10))  BEGIN
update users set Name=name, LastUpdationDate=current_timestamp(), EmailId=email, PhoneNumber=phone, Size=size WHERE id=uid;
END$$

DELIMITER ;
