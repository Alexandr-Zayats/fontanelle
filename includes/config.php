<?php
  
  //setlocale(LC_ALL, 'uk_UA.utf8');
  
  //echo strftime("%A %e %B %Y", mktime(0, 0, 0, 12, 22, 1978));

  //define('DB_SERVER','3.65.146.44');
  define('DB_SERVER','localhost');
  define('DB_USER','web');
  define('DB_PASS' ,'webPassword12$');
  define('DB_NAME', 'fontanelle');

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
  /*$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASS);
  $mysqli->select_db(DB_NAME);*/

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  /* change character set to utf8
  if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
  } else {
    printf("Current character set: %s\n", $mysqli->character_set_name());
  }
  //mysqli->close();
  */

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
