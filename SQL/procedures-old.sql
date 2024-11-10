
DROP PROCEDURE IF EXISTS el_history;
CREATE DEFINER=`root`@`localhost` PROCEDURE `el_history` (`uid` INT(5), `cid` INT(5), `dNow` DATE)
BEGIN
  SELECT
    payment.sum as paid,
    SUM(c.dPrev) as dPrev,
    c.dCur as dCur,
    c.dDelta as dDelta,
    c.nPrev as nPrev,
    c.nCur as nCur,
    c.nDelta as nDelta,
    c.sum as toPay,
    COALESCE(payment.date, c.date, DATE_FORMAT(dNow, '%Y-%m-%d')) as date
  FROM
    ( SELECT
      min(v.dPrevius) as dPrev,
      max(v.dCurrent) as dCur,
      max(v.dCurrent)-min(v.dPrevius) as dDelta,
      min(v.nPrevius) as nPrev,
      max(v.nCurrent) as nCur,
      max(v.nCurrent)-min(v.nPrevius) as nDelta,
      DATE_FORMAT(v.date, '%Y-%m-%d') as date,
      (max(v.dCurrent)-min(v.dPrevius))*t.day+(max(v.nCurrent)-min(v.nPrevius))*t.night as sum
    FROM countValues v INNER JOIN tariffs t ON (v.tariffId=t.id)
    WHERE v.cId=cid
      AND ( v.dCurrent!=v.dPrevius OR v.nCurrent!=v.nPrevius )
      AND  DATE_FORMAT(v.date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
    GROUP BY t.id ) as c,
    ( SELECT
      SUM(sum) as sum,
      DATE_FORMAT(date, '%Y-%m-%d') as date
    FROM payments
    WHERE userId=uid
      AND dst="el"
      AND DATE_FORMAT(date, '%Y-%m')=DATE_FORMAT(dNow, '%Y-%m')
    ) as payment;
END$$

