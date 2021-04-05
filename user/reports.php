<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['adid']==0 || $_SESSION['type']!="cashier") ) {
  header('location:logout.php');
} else {
  if(isset($_POST['report'])) {
    $start=$_POST['start'];
    $stop=$_POST['stop'];
  } else {
    $start="2021-03-01";
    $stop=date("Y-m-d");
  }
  //echo "<script>alert('$start  $stop');</script>";
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

                <!-- B.egin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">СТ "РУЧЕЕК"</h1>
            

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form class="date" name="report" method="post">
                            <h6 class="m-0 font-weight-bold text-primary">Отчет за период
                              <label for="start"> с </label>
                              <input type="date" id="start" name="start" min="2021-03-01" value="<?php echo $start;?>">
                              <label for="stop"> по </label>
                              <input type="date" id="stop" name="stop" value="<?php echo $stop;?>">
                              <button type="submit" name="report">
                                Сформировать
                              </button>
                            </h6>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th style="text-align:center">Участок</th>
                                      <th style="text-align:center">ФИО</th>
                                      <th style="text-align:center">Баланс</th>
                                      <th style="text-align:center">КВт (день)</th>
                                      <th style="text-align:center">КВт (ночь)</th>
                                      <th style="text-align:center">Сумма (элек)</th>
                                      <th style="text-align:center">Дата поверки</th>
                                      <th style="text-align:center">Кубов</th>
                                      <th style="text-align:center">Сумма (вода)</th>
                                      <th style="text-align:center">Дата поверки</th>
                                      <th style="text-align:center">Членские</th>
                                      <th style="text-align:center">Вступительные</th>
                                      <th style="text-align:center">Телефон</th>
                                      <th style="text-align:center">Email</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th style="text-align:center">Участок</th>
                                      <th style="text-align:center">ФИО</th>
                                      <th style="text-align:center">Баланс</th>
                                      <th style="text-align:center">КВт (день)</th>
                                      <th style="text-align:center">КВт (ночь)</th>
                                      <th style="text-align:center">Сумма (элек)</th>
                                      <th style="text-align:center">Дата поверки</th>
                                      <th style="text-align:center">Кубов</th>
                                      <th style="text-align:center">Сумма (вода)</th>
                                      <th style="text-align:center">Дата поверки</th>
                                      <th style="text-align:center">Членские</th>
                                      <th style="text-align:center">Вступительные</th>
                                      <th style="text-align:center">Телефон</th>
                                      <th style="text-align:center">Email</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
<?php
  //$mysqli->close();
  //$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
  //echo "<script>alert('$start  $stop');</script>";
  $query=mysqli_query($con,"call sp_totalReport('$start', '$stop')");
  $balans=0; $kDay=0; $kNight=0; $sumEl=0; $kWater=0; $sumWat=0; $sumFee=0; $sumInc=0;
  while ($result=mysqli_fetch_array($query)) {
    if ( $result['id'] == 0 OR (
      $result['kDay'] == 0 and
      $result['kNight'] == 0 and
      $result['sumEl'] == 0 and
      $result['kWater'] == 0 and
      $result['sumWat'] == 0 and
      $result['sumFee'] == 0 and
      $result['sumInc'] == 0
    )) { continue; }
?>
                                    <tr>
                                      <td style="text-align:center"><?php echo $result['id'];?></td>
                                      <td style="text-align:left"><?php echo $result['name'];?></td>
                                      <td style="text-align:right"><?php echo $result['balans']; $balans+=$result['balans'];?></td>
                                      <td style="text-align:right"><?php echo $result['kDay']; $kDay+=$result['kDay'];?></td>
                                      <td style="text-align:right"><?php echo $result['kNight']; $kNight+=$result['kNight'];?></td>
                                      <td style="text-align:right"><?php echo $result['sumEl']; $sumEl+=$result['sumEl'];?></td>
                                      <td style="text-align:center"><?php echo $result['elVerDate'];?></td>
                                      <td style="text-align:right"><?php echo $result['kWater']; $kWater+=$result['kWater'];?></td>
                                      <td style="text-align:right"><?php echo $result['sumWat']; $sumWat+=$result['sumWat'];?></td>
                                      <td style="text-align:center"><?php echo $result['watVerDate'];?></td>
                                      <td style="text-align:right"><?php echo $result['sumFee']; $sumFee+=$result['sumFee'];?></td>
                                      <td style="text-align:right"><?php echo $result['sumInc']; $sumInc+=$result['sumInc'];?></td>
                                      <td style="text-align:right"><?php echo $result['phone'];?></td>
                                      <td style="text-align:center"><?php echo $result['email'];?></td>
                                    </tr>
<?php } ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td style="text-align:center"></td>
                                      <td style="text-align:right"><b>Итого:</b></td>
                                      <td style="text-align:right"><b><?php echo number_format($balans, 2, '.', ' ');?></b></td>
                                      <td style="text-align:right"><b><?php echo number_format($kDay, 2, '.', ' ');?></b></td>
                                      <td style="text-align:right"><b><?php echo number_format($kNight, 2, '.', ' ');?></b></td> 
                                      <td style="text-align:right"><b><?php echo number_format($sumEl, 2, '.', ' ');?></b></td>
                                      <td style="text-align:center"></td>
                                      <td style="text-align:right"><b><?php echo number_format($kWater, 2, '.', ' ');?></b></td>
                                      <td style="text-align:right"><b><?php echo number_format($sumWat, 2, '.', ' ');?></b></td>
                                      <td style="text-align:center"></td>
                                      <td style="text-align:right"><b><?php echo number_format($sumFee, 2, '.', ' ');?></b></td>
                                      <td style="text-align:right"><b><?php echo number_format($sumInc, 2, '.', ' ');?></b></td>
                                      <td style="text-align:right"></td>
                                      <td style="text-align:center"></td>
                                    </tr>
                                  </tfoot>
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
