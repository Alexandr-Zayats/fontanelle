<?php
  namespace Phppot;
  session_start();
  unset($_SESSION['subpage']);
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';
  unset($_SESSION['cid']);
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
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">СТ "РУЧЕЕК"</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Дачные участки</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th style="width: 3%; text-align:center" rowspan="2">#</th>
                                      <th style="width: 3%; text-align:center" rowspan="2">№</th>
                                      <th style="width: 8%; text-align:center" rowspan="2">Улица</th>
                                      <th style="width: 20%; text-align:center" rowspan="2">Владелец</th>
                                      <th style="width: 8%; text-align:center" rowspan="2">Статус</th>
				                              <th style="width: 20%; text-align:center" rowspan="2">Примечание</th>
                                      <th style="width: 22%; text-align:center" colspan="3">Баланс</th>
                                      <th style="width: 12%; text-align:center" rowspan="2">Последний платеж</th>
                                    </tr>
                                      <th style="text-align:center">Електр</th>
                                      <th style="text-align:center">Вода</th>
                                      <th style="text-align:center">Членские</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th style="text-align:center">#</th>
                                      <th style="text-align:center">№</th>
                                      <th style="text-align:center">Улица</th>
                                      <th style="text-align:center">Владелец</th>
                                      <th style="text-align:center">Статус</th>
				                              <th style="text-align:center">Примечание</th>
                                      <th style="text-align:center">Електр</th>
                                      <th style="text-align:center">Вода</th>
                                      <th style="text-align:center">Членские</th>
                                      <th style="text-align:center">Последний платеж</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
<?php
  $cnt=1;
  $query = $userModel->call('sp_allregisteredusers', '');
  foreach ($query as $result) {
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
                                      <td style="text-align:right">
                                          <?php echo $cnt?>
                                      </td>

                                      <td style="text-align:center">
                                        <form class="user" id="<?php printf('%d', $result['id'])?>"
                                          action="../user/" method="post"
                                        >
                                          <input type="hidden" name="uid" placeholder=""
                                            value="<?php printf('%d', $result['id'])?>"/
                                          >
                                          <div class="mb-sm-0" style="color:blue;cursor:pointer"
                                            onclick="submit(<?php printf('%d', $result['id'])?>)"
                                          >
                                            <?php printf('%s', $result['id'])?>
                                          </div>
                                        </form>
                                      </td>
                                      <td style="text-align:left">
                                          <?php echo $result['street'];?>
                                      </td>
				                              <td style="text-align:left">
                                        <?php formSubmit('uid', $result['id'], $result['Name'], '../user/')?>
				                              </td>
                                      <td style="text-align:left">
                                      <?php
                                        if($result['type'] == 1) {
                                          echo "Проживают";
                                        } elseif($result['type'] == 2) {
                                          echo "Дачники";
                                        }
                                      ?>
                                      </td>
				                              <td style="text-align:right">
                                        <?php echo $result['info']?>
                                      </td>
                                      <td style="text-align:right">
                                        <?php printf("%.2f", $result['el']);?>
                                      </td>
                                      <td style="text-align:right">
                                        <?php printf("%.2f", $result['wat']);?>
                                      </td>
                                      <td style="text-align:right">
                                        <?php printf("%.2f", $result['fee']);?>
                                      </td>
                                      <td style="text-align:right">
                                        <?php if(isset($result['lastPay']) && $result['lastPay'] != "") { echo dateFormat($result['lastPay']);}?>
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
<?php include_once('../includes/logout-modal.php');?>

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
