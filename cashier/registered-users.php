<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['adid']==0 || $_SESSION['type']!="cashier") ) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>РУЧЕЕК (кассир)</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">СТ "РУЧЕЕК"</h1>
            

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Список участков</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th style="width: 3%; text-align:center">#</th>
                                      <th style="width: 3%; text-align:center">№</th>
                                      <th style="width: 30%; text-align:center">ФИО</th>
				                              <th style="width: 15%; text-align:center">Телефон</th>
				                              <th style="width: 39%; text-align:center">Примечание</th>
                                      <th style="width: 8%; text-align:center">Баланс</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th style="text-align:center">#</th>
                                      <th style="text-align:center">№</th>
                                      <th style="text-align:center">ФИО</th>
				                              <th style="text-align:center">Телефон</th>
				                              <th style="width: 32%; text-align:center">Примечание</th>
                                      <th style="text-align:center">Баланс</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
<?php
  $query=mysqli_query($con,"call sp_allregisteredusers()");
  $cnt=1;
  while ($result=mysqli_fetch_array($query)) {
?>
                                    <tr>
                                      <td style="text-align:right"><?php echo $cnt;?></td>
                                      <td style="text-align:center">
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
                                        <?php echo $result['id'];?></td>
                                      <td style="text-align:left">
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
                                        <?php echo $result['Name'];?></td>
				      <td style="text-align:right">
					<table>
					<tr><td>
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
					<?php
					  if( preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone1'],  $matches ) )
					  {
    					    echo "+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
					  } else {
					    echo $result['phone1'];
					  }
					?></td></tr>
					<?php if($result['phone2'] != "") { ?>
					<tr><td>
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
                                        <?php
                                          if( preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches ) )
                                          {
                                            echo "+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                          } else {
                                            echo $result['phone2'];
                                          }
					?></td></tr>
					<?php } ?>
					</table>
				      </td>
				      <td style="text-align:right">
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
                                        <?php echo $result['info'];?></td>
                                      <td style="text-align:right">
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>"</a>
                                        <?php printf("%.2f", $result['balance']);?></td>
                                    </td>
                                    </tr>
<?php $cnt++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
   <?php include_once('includes/footer.php');?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
<?php include_once('includes/logout-modal.php');?>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>
</html>
<?php } ?>
