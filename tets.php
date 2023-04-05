<?php
  
  $date_of_end = date('Y-m-d');
  $date_of_start = date("Y-m-d", strtotime("-60 month", strtotime(date('Y-m-d'))));

  while (strtotime($date_of_start) <= strtotime($date_of_end)) {
    echo "$date_of_start" . "\n";
    $date_of_start = date ("Y-m-d", strtotime("+1 month", strtotime($date_of_start)));
}
?>
