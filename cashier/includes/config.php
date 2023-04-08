<?php
  $allowedUser = array('cashier', 'admin');
  if (!in_array($_SESSION['loginType'], $allowedUser)) {
  //if (false) {
    header('location:../logout.php');
  }
?>
