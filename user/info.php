<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['adid'] == 0 || ($_SESSION['type'] != "cashier" && $_SESSION['type'] != "regularUser")) ) {
  header('location:logout.php');
} else {
  $uid=$_GET['uid'];
  if(isset($_GET['cid'])) {
    $cid=$_GET['cid'];
  } else {
    $cid=0;
  }
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

</head>

<?php
  $query=mysqli_query($con,"call el_userInfo($uid)");
  while ($user=mysqli_fetch_assoc($query)) {
?>

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
                    <h1 class="h3 mb-2 text-gray-800">ЭЛЕКТРИЧЕСТВО</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <table width="100%">
                            <tr>
                              <td><h6 class="m-0 font-weight-bold text-primary"><?php echo "Участок №".$user['uId'].". ".$user['uName']; ?></h6></td>
                              <td></td>
                              <td>
                                <form action="user-counter.php">
                                  <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                                  <input type="hidden" id="cid" name="cid" value="<?php echo $cid ?>">
                                  <input type="submit" value="Внести показания" />
                                </form>
                              </td>
                            </tr>
                            <tr>
                              <td style="text-align:right">
                                <a href="add-counter.php?uid=<?php echo $uid;?>&type=el">Cчетчики (добавить):</a>
                              </td>
                              <td style="text-align:left">
                                <h6 class="m-0 font-weight-bold text-primary">
                                <!-- <div class="form-group row"> -->
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <!-- <label for="counter">Счетчики: </label> -->
                                  <select id="counter" name="counter" class="form-control" onchange="window.location = this.options[this.selectedIndex].value">
                                    <?php
                                      foreach ( explode(";", $user['cId']) as &$cId ) {
                                        $query->close();
                                        $con->next_result();
                                        $sql=mysqli_query($con,"call counterInfo($cId)");
                                        while ($counter=mysqli_fetch_array($sql)) {
                                          if ($cid==0) { $cid=$counter['id']; }
                                          if ($counter['id'] == $cid) {
                                            echo "<option value=info.php?cid=".$cId."&uid=".$uid." selected>".$counter['name']."</option>";
                                          } else {
                                            echo "<option value=info.php?cid=".$cId."&uid=".$uid.">".$counter['name']."</option>";
                                          }
                                        }
                                      }
                                    ?>
                                  </select>
                                </div>
                                </h6>
                              </td>
                              <td>
                                <form action="user-payment.php">
                                  <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                                  <input type="hidden" id="dst" name="dst" value="el">
                                  <input type="submit" value="Оплата" />
                                </form>
                              </td>
                            </tr>
                          </table>
                        </div>

                        <!-- Card Body -->
                        <!-- <div class="table-responsive"> -->
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th rowspan="2" style="text-align:center">Дата</th>
                                <th colspan="3" style="text-align:center">День</th>
                                <th colspan="3" style="text-align:center">Ночь</th>
                                <th rowspan="2" style="text-align:center">К оплате</th>
                                <th rowspan="2" style="text-align:center">Оплочено</th>
                              </tr>
                              <tr>
                                <th style="text-align:center">Предыдущие</th>
                                <th style="text-align:center">Текущие</th>
                                <th style="text-align:center">Разница</th>
                                <th style="text-align:center">Предыдущие</th>
                                <th style="text-align:center">Текущие</th>
                                <th style="text-align:center">Разница</th>
                              </tr>
                            </thead>
                            <tbody>
<?php
  $query->close();
  $con->next_result();
  $sql=mysqli_query($con,"call el_history($uid, $cid)");
  $cnt=1;
  while ($countValues=mysqli_fetch_array($sql))
{ ?>

                              <tr>
                                <td style="text-align:right"><?php echo $countValues['date'] ?></td>
                                <td style="text-align:right"><?php echo $countValues['dPrev'];?></td>
                                <td style="text-align:right"><?php echo $countValues['dCur'];?></td>
                                <td style="text-align:right"><?php echo $countValues['dDelta'];?></td>
                                <td style="text-align:right"><?php echo $countValues['nPrev'];?></td>
                                <td style="text-align:right"><?php echo $countValues['nCur'];?></td>
                                <td style="text-align:right"><?php echo $countValues['nDelta'];?></td>
                                <td style="text-align:right"><?php printf("%.2f", $countValues['toPay']);?></td>
                                <td style="text-align:right"><?php echo $countValues['paid'];?></td>
                              </tr>
 <?php $cnt++; } ?>
                            </tbody>
                          </table>
                        <!-- </div> -->
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
