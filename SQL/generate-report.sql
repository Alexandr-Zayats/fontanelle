select st.name as Street, us.id as Build, us.Name, EmailId as EMAIL, PhoneNumber as Mobile, Size, BalanceEl, 
(select max(cV.dCurrent) from counters as count left join countValues as cV on cV.cId = count.id), BalanceWat, BalanceFee from users as us left join streets as st on us.StreetId = st.id;

select st.name as Street, us.id as Build, us.Name, EmailId as EMAIL, PhoneNumber as Mobile, Size,
BalanceEl,
  (select max(cV.dCurrent) from counters as count left join countValues as cV on cV.cId = count.id where count.type="el" AND count.userId=us.id) as ElectLastValueDay,
  (select max(cV.nCurrent) from counters as count left join countValues as cV on cV.cId = count.id where count.type="el" AND count.userId=us.id) as ElectLastValueNigth,
BalanceWat,
  (select max(cV.dCurrent) from counters as count left join countValues as cV on cV.cId = count.id where count.type="wat" AND count.userId=us.id) as WatLastValue,
BalanceFee from users as us left join streets as st on us.StreetId = st.id
INTO OUTFILE '/var/lib/mysql-files//users.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';
