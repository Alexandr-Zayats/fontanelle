<?php
define('DB_SERVER','localhost');
define('DB_USER','web');
define('DB_PASS' ,'webPassword');
define('DB_NAME', 'fontanelle');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

?>
