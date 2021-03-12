<?php
//define('DB_SERVER','3.65.146.44');
define('DB_SERVER','localhost');
define('DB_USER','web');
define('DB_PASS' ,'webPassword');
define('DB_NAME', 'fontanelle');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

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
?>
