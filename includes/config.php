<?php
  
  //setlocale(LC_ALL, 'uk_UA.utf8');
  

  if (isset($_SESSION['adid'])) {
    $cashier = $_SESSION['adid'];
  }

  if (isset($_POST['uid'])) {
    $uid = $_POST['uid'];
  } elseif( isset($_GET['uid'])) {
    $uid = $_GET['uid'];
  } elseif (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
  } else {
    $uid = -1;
  }

  $_SESSION['uid'] = $uid;

  if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];
  } elseif (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
  } elseif (isset($_SESSION['cid'])) {
    $cid = $_SESSION['cid'];
  }
  $_SESSION['cid'] = $cid;

  if (isset($_POST['type'])) {
    $type = $_POST['type'];
  } elseif (isset($_GET['type'])) {
    $type = $_GET['type'];
  } elseif (isset($_SESSION['cType'])) {
    $type = $_SESSION['cType'];
  }
  $_SESSION['cType'] = $type;

  if (isset($_POST['toPay'])) {
    $toPay = $_POST['toPay'];
  } elseif( isset($_GET['toPay'])) {
    $toPay = $_GET['toPay'];
  } elseif (isset($_SESSION['toPay'])) {
    $toPay = $_SESSION['toPay'];
  }
  $_SESSION['toPay'] = $toPay;

  foreach ($_POST as $key => $value) {
    ${$key} = $value;
  }

  function dateFormat(String $dat) {
    $monthes = array(
      1 => 'Січня', 2 => 'Лютого', 3 => 'Березня', 4 => 'Квітня',
      5 => 'Травня', 6 => 'Червня', 7 => 'Липня', 8 => 'Серпня',
      9 => 'Вересня', 10 => 'Жовня', 11 => 'Лютого', 12 => 'Грудня'
    );

    $_date[] = strtolower(date("d",strtotime($dat)));
    $_date[] = $monthes[(date('n', strtotime($dat)))];
    $_date[] = strtolower(date("Y",strtotime($dat))) . "р.";
    $curDate = join(" ", $_date);

    return $curDate;
  }

  function dateDiffInDays($date1, $date2) 
  {
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);
  
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
  }
?>
