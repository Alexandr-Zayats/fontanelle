<?php

  namespace Phppot;
  session_start();
  //error_reporting(0);
 
  include_once __DIR__ . '/../includes/config.php'; 
  // require_once __DIR__ . '/../lib/UserModel.php';
  // $userModel = new UserModel();

  if (strlen($_SESSION['adid'] == 0 || $_SESSION['type'] != "cashier") ) {
  //if (false) {
    header('location:../cashier/logout.php');
/*  } else {
    $query = $userModel->call('userInfo', $uid . ", 'el'");
    $user = $query[0];
*/
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>РУЧЕЕК</title>

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="../includes/scripts.js"> </script> 

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      <?php include_once('includes/sidebar.php');?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <?php include_once('includes/topbar.php');?>
          <!-- End of Topbar -->
          <div class="container-fluid">

          </div> <!-- container-fluid -->
        </div> <!-- content -->
      </div> <!-- content-wrapper -->
    </div> <!-- wraper -->
</body>
</html>
