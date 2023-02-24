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
                            <h6 class="m-0 font-weight-bold text-primary">Должники</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th style="width: 3%; text-align:center" rowspan="2">#</th>
                                      <th style="width: 3%; text-align:center" rowspan="2">№</th>
                                      <th style="width: 14%; text-align:center" rowspan="2">Улица</th>
                                      <th style="width: 30%; text-align:center" rowspan="2">Владелец</th>
                                      <th style="width: 24%; text-align:center" colspan="3">Задолженность</th>
                                      <th style="width: 26%; text-align:center" colspan="2">Проверка счетчика</th>
                                    </tr>
                                      <th style="text-align:center">Елект</th>
                                      <th style="text-align:center">Вода</th>
                                      <th style="text-align:center">Членские</th>
                                      <th style="text-align:center">Елект</th>
                                      <th style="text-align:center">Вода</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th style="text-align:center">#</th>
                                      <th style="text-align:center">№</th>
                                      <th style="text-align:center">Улица</th>
                                      <th style="text-align:center">Владелец</th>
                                      <th style="text-align:center">Елект</th>
                                      <th style="text-align:center">Вода</th>
                                      <th style="text-align:center">Членские</th>
                                      <th style="text-align:center">Елект</th>
                                      <th style="text-align:center">Вода</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
<?php
  $query=mysqli_query($con,"call debtors()");
  $cnt=1;
  while ($result=mysqli_fetch_array($query)) {
?>
                                    <?php
                                      $phone="Номер телефона не указан";
                                      if (preg_match('/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone1'],  $matches )) {
                                        $phone="+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                      }
                                      if (preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches)) {
                                        $phone=$phone."; "."+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                      }
                                    ?>
                                    <tr>
                                      <td style="text-align:right" class="user"><?php printf('%d', $cnt);?></td>

                                      <td style="text-align:center" class="user">
                                        <a href="../user/info.php?uid=<?php echo $result['id'];?>">
                                          <?php printf('%d', $result['id']);?>
                                        </a>
                                      </td>

                                      <td style="text-align:left" class="user">
                                        <?php printf('%s',$result['street']);?>
                                      </td>

				                              <td style="text-align:left">
                                        <form method="post" action="../user/notice.php" class="user">
                                          <?php
                                          foreach ($result as $key => $value) { ?>
                                            <input type="hidden" name="userData[<?php echo $key; ?>]" value="<?php echo $value; ?>">
                                          <?php } ?>
                                          <button class="btn btn-primary btn-user btn-block">
                                            <?php printf('%s', $result['Name']);?>
                                          </button>
                                        </form>
				                              </td>
                                      <!--
				                              <td style="text-align:right">
                                        <?php //echo $result['info'];?>
                                      </td>
                                      -->
                                      <td style="text-align:right" class="user">
                                        <?php printf("%s", $result['el']);?>
                                      </td>
                                      <td style="text-align:right" class="user">
                                        <?php printf("%s", $result['wat']);?>
                                      </td>
                                      <td style="text-align:right" class="user">
                                        <?php printf("%s", $result['fee']);?>
                                      </td>
                                      <td style="text-align:right" class="user">
                                        <?php if(isset($result['verEl'])) { printf("%s", dateFormat($result['verEl'])); }?>
                                      </td>
                                      <td style="text-align:right" class="user">
                                        <?php if(isset($result['verWat'])) { printf("%s", dateFormat($result['verWat'])); }?>
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
