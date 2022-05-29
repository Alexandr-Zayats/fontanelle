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

DROP PROCEDURE IF EXISTS fee_history;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fee_history` (`uid` INT(5))
BEGIN
  SELECT
    DATE_FORMAT(p.dstDate, '%Y') as date,
    SUM(sum) as paid,
    u.Size*100 as toPay,
    u.BalanceFee as balance 
  FROM payments p LEFT JOIN users u ON (u.id=p.userId)
  WHERE userId=uid AND dst='fee'
  GROUP BY DATE_FORMAT(p.dstDate, '%Y')
  ORDER BY dstDate DESC
  LIMIT 36;
END$$

DROP PROCEDURE IF EXISTS el_history;
CREATE DEFINER=`root`@`localhost` PROCEDURE `el_history` (`uid` INT(5), `cid` INT(5))
BEGIN
  DECLARE dNow DATE;
  DECLARE dEnd DATE;
  SET dNow = DATE(NOW());
  SET dEnd = DATE_SUB(NOW(), INTERVAL 36 MONTH);
  WHILE DATE(dNow) >= DATE(dEnd) DO
    SELECT
      SUM(p.sum) as paid,
      SUM(c.dPrev) as dPrev,
      SUM(c.dCur) as dCur,
      SUM(c.dDelta) as dDelta,
      SUM(c.nPrev) as nPrev,
      SUM(c.nCur) as nCur,
      SUM(c.nDelta) as nDelta,
      SUM(c.sum) as toPay,
      c.date
    FROM
      ( SELECT
        min(v.dPrevius) as dPrev,
        max(v.dCurrent) as dCur,
        max(v.dCurrent)-min(v.dPrevius) as dDelta,
        min(v.nPrevius) as nPrev,
        max(v.nCurrent) as nCur,
        max(v.nCurrent)-min(v.nPrevius) as nDelta,
        DATE_FORMAT(v.date, '%Y-%m') as date,
        (max(v.dCurrent)-min(v.dPrevius))*t.day+(max(v.nCurrent)-min(v.nPrevius))*t.night as sum
      FROM countValues v INNER JOIN tariffs t ON (v.tariffId=t.id)
      WHERE v.cId=cid
        AND v.dCurrent!=v.dPrevius
        AND  DATE_FORMAT(v.date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
      GROUP BY t.id ) as c, 
      ( SELECT
        SUM(SUM) as sum
      FROM payments p
      WHERE userId=uid
        AND dst="el"
        AND DATE_FORMAT(p.date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
      ) as p;
    SET dNow = DATE_SUB(dNow, INTERVAL 1 MONTH);
  END WHILE;
END$$

DROP PROCEDURE IF EXISTS wat_history;
CREATE DEFINER=`root`@`localhost` PROCEDURE `wat_history` (`uid` INT(5), `cid` INT(5))
BEGIN
  DECLARE dNow DATE;
  DECLARE dEnd DATE;
  SET dNow = DATE(NOW());
  SET dEnd = DATE_SUB(NOW(), INTERVAL 36 MONTH);
  WHILE DATE(dNow) >= DATE(dEnd) DO
    SELECT
      SUM(p.sum) as paid,
      SUM(c.dPrev) as dPrev,
      SUM(c.dCur) as dCur,
      SUM(c.dDelta) as dDelta,
      SUM(c.sum) as toPay,
      c.date
    FROM
      ( SELECT
        min(v.dPrevius) as dPrev,
        max(v.dCurrent) as dCur,
        max(v.dCurrent)-min(v.dPrevius) as dDelta,
        DATE_FORMAT(v.date, '%Y-%m') as date,
        (max(v.dCurrent)-min(v.dPrevius))*t.water as sum
      FROM countValues v INNER JOIN tariffs t ON (v.tariffId=t.id)
      WHERE v.cId=cid
        AND v.dCurrent!=v.dPrevius
        AND  DATE_FORMAT(v.date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
      GROUP BY t.id ) as c,
      ( SELECT
        SUM(SUM) as sum
      FROM payments p
      WHERE userId=uid
        AND dst="wat"
        AND DATE_FORMAT(p.date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
      ) as p;
    SET dNow = DATE_SUB(dNow, INTERVAL 1 MONTH);
  END WHILE;
END$$

DROP PROCEDURE IF EXISTS counterInfo;
CREATE DEFINER=`root`@`localhost` PROCEDURE `counterInfo` (`cId` INT(5))  BEGIN
SELECT * FROM counters c WHERE c.id=cId;
END$$

DROP PROCEDURE IF EXISTS userInfo;
CREATE DEFINER=`root`@`localhost` PROCEDURE `userInfo` (`uid` INT(5), `type` VARCHAR(10))  BEGIN
IF (type = 'el') THEN
  SELECT u.id as uId, u.Name as uName, u.TariffId as tariff, u.BalanceEl as balance, group_concat(c.Id ORDER BY c.verDate DESC separator ';') as cId FROM users u LEFT JOIN counters c ON c.userId=u.id WHERE c.type=type AND u.id=uid;
END IF;
IF (type = 'wat') THEN
  SELECT u.id as uId, u.Name as uName, u.TariffId as tariff, u.BalanceWat as balance, group_concat(c.Id ORDER BY c.verDate DESC separator ';') as cId FROM users u LEFT JOIN counters c ON c.userId=u.id WHERE c.type=type AND u.id=uid;
END IF;
IF (type = 'fee') THEN
  SELECT u.id as uId, u.Name as uName, u.TariffId as tariff, u.BalanceFee as balance, group_concat(c.Id ORDER BY c.verDate DESC separator ';') as cId FROM users u LEFT JOIN counters c ON c.userId=u.id WHERE c.type=type AND u.id=uid;
END IF;

END$$

DROP PROCEDURE IF EXISTS sp_counterBalance;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_counterBalance` (`start` TIMESTAMP, `stop` TIMESTAMP) BEGIN
SELECT c.type,
  SUM(IF(c.id>1, dCurrent-dPrevius, 0)) as elDay,
  SUM(IF(c.id>1, nCurrent-nPrevius, 0)) as elNight
FROM countValues v LEFT JOIN counters c ON (c.id=v.cId)
WHERE
  DATE_FORMAT(v.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
  DATE_FORMAT(v.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d')
GROUP BY c.type;
END$$

DROP PROCEDURE IF EXISTS sp_balance;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_balance` (`start` TIMESTAMP, `stop` TIMESTAMP) BEGIN
SELECT
  count.dK,
  count.nK,
  count.tdK,
  count.tnK,
  count.toPay,
  count.toSpend,
  count.kInWater,
  count.kOutWater,
  pay.pEl,
  pay.pWater,
  pay.pFee,
  pay.pIncome,
  pay.pOther
FROM
  (
    SELECT
      SUM(IF(v.cId>5 AND v.type="el", (v.dCurrent - v.dPrevius), 0)) as dK,
      SUM(IF(v.cId>5 AND v.type="el", (v.nCurrent - v.nPrevius), 0)) as nK,
      SUM(IF(v.cId=1, (v.dCurrent - v.dPrevius), 0))*40.64 as tdK,
      SUM(IF(v.cId=1, (v.nCurrent - v.nPrevius), 0))*40.64 as tnK,
      SUM(IF(v.cId=2, (v.dCurrent - v.dPrevius), 0)) as kOutWater,
      SUM(IF(v.cId>5 AND v.type="wat", (v.dCurrent - v.dPrevius), 0)) as kInWater,
      SUM(IF(v.cId>5 AND v.type="el", (v.dCurrent - v.dPrevius), 0))*t.day+SUM(IF(v.cId>1, (v.nCurrent - v.nPrevius), 0))*t.night as toPay,
      SUM(IF(v.cId=1, (v.dCurrent - v.dPrevius), 0))*68.28+SUM(IF(v.cId=1, (v.nCurrent - v.nPrevius), 0))*34.14 as toSpend
    FROM countValues v LEFT JOIN tariffs t ON (t.id=v.tariffId)
    WHERE
      DATE_FORMAT(v.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
      DATE_FORMAT(v.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d') ) as count,
  (
    SELECT
      SUM(IF(dst="el", sum, 0)) as pEl,
      SUM(IF(dst="wat", sum, 0)) as pWater,
      SUM(IF(dst="fee", sum, 0)) as pFee,
      SUM(IF(dst="inc", sum, 0)) as pIncome,
      SUM(IF(dst="other", sum, 0)) as pOther
    FROM payments
    WHERE
      DATE_FORMAT(date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
      DATE_FORMAT(date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d') ) as pay;
END$$

DROP PROCEDURE IF EXISTS sp_totalReport;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_totalReport` (`start` TIMESTAMP, `stop` TIMESTAMP) BEGIN
SELECT u.id as id, u.name as name, (u.BalanceEl+u.BalanceWat+u.BalanceFee) as balance, u.PhoneNumber as phone, u.EmailId as email,
(SELECT DATE_FORMAT(verDate, '%Y-%m-%d') as verDate FROM counters
  WHERE userId=u.id AND type="el"
  ORDER BY verDate LIMIT 0,1) as elVerDate,
(SELECT DATE_FORMAT(verDate,  '%Y-%m-%d') as verDate FROM counters
  WHERE userId=u.id AND type="wat"
  ORDER BY verDate LIMIT 0,1) as watVerDate,
(SELECT SUM(v.dCurrent - v.dPrevius) FROM countValues v
  LEFT JOIN counters c ON (c.id=v.cId)
  WHERE
    DATE_FORMAT(v.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
    DATE_FORMAT(v.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d') AND
    c.userId=u.id AND
    c.type='el'
  GROUP BY u.id) as kDay,
(SELECT SUM(v.nCurrent - v.nPrevius) FROM countValues v
  LEFT JOIN counters c ON (c.id=v.cId)
  WHERE
    DATE_FORMAT(v.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
    DATE_FORMAT(v.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d') AND
    c.userId=u.id AND
    c.type='el'
  GROUP BY u.id) as kNight,
(SELECT SUM(v.dCurrent - v.dPrevius) FROM countValues v
  LEFT JOIN counters c ON (c.id=v.cId)
  WHERE
    DATE_FORMAT(v.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d') AND
    DATE_FORMAT(v.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d') AND
    c.userId=u.id AND
    c.type='wat'
  GROUP BY u.id) as kWater,
SUM(
  IF(dst='el'
    AND DATE_FORMAT(p.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d')
    AND DATE_FORMAT(p.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d'),
    p.sum, 0)) as sumEl,
SUM(
  IF(dst='wat'
    AND DATE_FORMAT(p.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d')
    AND DATE_FORMAT(p.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d'),
    p.sum, 0)) as sumWat,
SUM(
  IF(dst='fee'
    AND DATE_FORMAT(p.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d')
    AND DATE_FORMAT(p.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d'),
    p.sum, 0)) as sumFee,
SUM(
  IF(dst='inc'
    AND DATE_FORMAT(p.date, '%Y%m%d') >= DATE_FORMAT(start, '%Y%m%d')
    AND DATE_FORMAT(p.date, '%Y%m%d') <= DATE_FORMAT(stop, '%Y%m%d'),
    p.sum, 0)) as sumInc
FROM users u
  LEFT JOIN payments p ON (p.userId=u.id)
GROUP BY u.id ORDER BY u.id;
END$$

DROP PROCEDURE IF EXISTS sp_addMoney;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addMoney` (`cashier` INT(3),  `uid` INT(3), `sum` decimal(8,2), `dst` VARCHAR(15), `dat` DATE, `bank` BOOLEAN )
BEGIN
  DECLARE payDate DATE;
  DECLARE firstPAY DATE;
  DECLARE YEAR_INT INT(100);
  IF ( dat = '2000-01-01' ) THEN
    SET payDate = DATE(NOW());
  ELSE
    SET payDate = DATE(dat);
  END IF;

  IF ( payDate BETWEEN DATE("1970-01-01") AND DATE("2020-12-31") ) THEN
    SET firstPAY = (SELECT DATE(min(dstDate)) FROM payments WHERE userId=uid);
    IF firstPAY is NULL THEN
      SET firstPAY = DATE(NOW());
    END IF;
    SELECT Size INTO @SIZE FROM users WHERE id=uid;
    SET YEAR_INT = (SELECT TIMESTAMPDIFF( YEAR, payDate, firstPAY ));
    IF ( payDate BETWEEN DATE("1970-01-01") AND firstPAY ) THEN
      IF ( dst = 'fee' ) THEN
        update users set BalanceFee=(BalanceFee - YEAR_INT*SIZE*100) WHERE id=uid;
      END IF;
    END IF;
  END IF;

  IF (dst = 'el') THEN
    update users set BalanceEl=(BalanceEl + sum) WHERE id=uid;
  END IF;
  IF (dst = 'wat') THEN
    update users set BalanceWat=(BalanceWat + sum) WHERE id=uid;
  END IF;
  IF (dst = 'fee') THEN
    update users set BalanceFee=(BalanceFee + sum) WHERE id=uid;
  END IF;

  INSERT INTO payments (cashierId, userId, type, sum, dst, dstDate) VALUES (cashier, uid, bank, sum, dst, payDate);
END$$

DROP PROCEDURE IF EXISTS sp_addCounterValues;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCounterValues` (`uid` INT(3), `cuid` INT(5), dayP decimal(8,2), dayC decimal(8,2), nightP decimal(8,2), nightC decimal(8,2)) BEGIN
IF ( (SELECT type FROM counters WHERE id=cuid) = "el" ) THEN
  IF ( (select count(dPrevius) FROM countValues WHERE cId=cuid AND dPrevius is NOT NULL) > 0 ) THEN
    update users set BalanceEl=(BalanceEl - (SELECT day FROM tariffs WHERE id=users.tariffId) * ( dayC - dayP )) WHERE id=uid;
  END IF;
  IF ( (select count(nPrevius) FROM countValues WHERE cId=cuid AND nPrevius is NOT NULL) > 0 ) THEN
    update users set BalanceEl=(BalanceEl - (SELECT night FROM tariffs WHERE id=users.tariffId) * ( nightC - nightP )) WHERE id=uid;
  END IF;
  insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent, type)
	values (cuid, (SELECT TariffId FROM users WHERE id=uid), dayP, dayC, nightP, nightC, (SELECT type FROM counters WHERE id=cuid));
ELSE
  IF ( (select count(dPrevius) FROM countValues WHERE cId=cuid AND dPrevius is NOT NULL) > 0 ) THEN
    update users set BalanceWat=(BalanceWat - (SELECT water FROM tariffs WHERE id=users.tariffId) * ( dayC - dayP )) WHERE id=uid;
    insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent, type)
	values (cuid, (SELECT TariffId FROM users WHERE id=uid), dayP, dayC, nightP, nightC, (SELECT type FROM counters WHERE id=cuid));
  END IF;
END IF;
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
select SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND dst='el', sum, 0 )) as el,
SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND dst='wat' , sum, 0)) as wat,
SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND dst='fee', sum, 0 )) as fee,
SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND ( dst='inc' OR dst='other' ), sum, 0)) as inc,
SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND type=true, sum, 0 )) as bank,
SUM(IF(DATE_FORMAT(date, '%Y%m')=DATE_FORMAT(CURDATE(), '%Y%m') AND type=false, sum, 0 )) as cash
from payments;
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

DROP PROCEDURE IF EXISTS sp_recent30payments;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_recent30payments` ()  BEGIN
select p.sum,
u.id as id,
u.name as name,
p.date
FROM payments p LEFT JOIN users u ON (p.userId=u.id) ORDER BY p.date DESC LIMIT 30;
END$$

DROP PROCEDURE IF EXISTS sp_addCounter;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCounter` (`uid` int(3), serial decimal(15), `name` VARCHAR(120), `info` VARCHAR(250), `type` VARCHAR(6), `dCurrent` DECIMAL(8,2), `nCurrent` DECIMAL(8,2)) BEGIN
insert into counters (userId, number, name, info, type) values (uid,serial,name,info,type);
insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent, type)
  values (
    (SELECT id FROM counters WHERE userId=uid ORDER BY id DESC LIMIT 0,1),
    (SELECT TariffId FROM users WHERE id=uid LIMIT 0,1),
    dCurrent, dCurrent, nCurrent, nCurrent,
    (SELECT type FROM counters WHERE userId=uid ORDER BY id DESC LIMIT 0,1)
  );
END$$

DROP PROCEDURE IF EXISTS sp_registration;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registration` (`uid` int(3), `name` VARCHAR(120), `street` int(3), `phone` VARCHAR(120), `size` VARCHAR(20), `counterNum` DECIMAL(20), `counterName` VARCHAR(120), `counterInfo` VARCHAR(250), `dCurrent` DECIMAL(8,2), `nCurrent` DECIMAL(8,2), `email` VARCHAR(200)) BEGIN
insert into users (id,Name,Size,StreetId,PhoneNumber,EmailId,BalanceFee) values (uid,name,size,street,phone,email,0-Size*100);
insert into counters (userId, number, name, info) values (uid,counterNum,counterName,counterInfo);
insert into countValues (cId, tariffId, dPrevius, dCurrent, nPrevius, nCurrent, type)
  values (
    (SELECT id FROM counters WHERE userId=uid LIMIT 0,1),
    (SELECT TariffId FROM users WHERE id=uid LIMIT 0,1),
    dCurrent, dCurrent, nCurrent, nCurrent,
    (SELECT type FROM counters WHERE userId=uid LIMIT 0,1)
  );
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userupdateprofile` (`uid` INT(5), `name` VARCHAR(120), `email` VARCHAR(120), `phone` VARCHAR(30), size DECIMAL(15,2))  BEGIN
update users set Name=name, LastUpdationDate=current_timestamp(), EmailId=email, PhoneNumber=phone, Size=size WHERE id=uid;
END$$

DELIMITER ;
