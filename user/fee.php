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
  $query=mysqli_query($con,"call userInfo($uid, 'fee')");
  while ($user=mysqli_fetch_assoc($query)) {
?>

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
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">ЧЛЕНСКИЕ ВЗНОСЫ</h1>
            </div>

            <div class="row">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          <?php echo "Участок № ".$user['uId'] ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php echo $user['uName'] ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Баланс
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php echo $user['balance']; $toPay=$user['balance'] ?> грн.
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  <!-- row -->

            <div class="row">
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <table width="100%">
                      <tr>
                        <td>
                          <form action="user-payment.php">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                            <input type="hidden" id="type" name="type" value="fee">
                            <input type="hidden" id="toPay" name="toPay" value="<?php echo $toPay ?>">
                            <input type="submit" value="Членские" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </td>
                        <td>
                          <form action="user-payment.php">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                            <input type="hidden" id="type" name="type" value="inc">
                            <input type="submit" value="Вступительные" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </td>
                        <td>
                          <form action="user-payment.php">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                            <input type="hidden" id="type" name="type" value="other">
                            <input type="submit" value="Прочие" class="btn btn-primary btn-user btn-block" />
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="text-align:center">Год</th>
                          <th style="text-align:center">Начисленно</th>
                          <th style="text-align:center">Оплоченно</th>
                          <th style="text-align:center">Долг</th>
                        </tr>
                      </thead>

                      <tbody>
<?php
  //$query->close();
  $con->next_result();
  $sql=mysqli_query($con,"call fee_history($uid)");
  $cnt=1;
  while ($fee=mysqli_fetch_array($sql))
{ ?>

                              <tr>
                                <td style="text-align:right"><?php echo $fee['date'] ?></td>
                                <td style="text-align:right"><?php echo $fee['toPay'] ?></td>
                                <td style="text-align:right"><?php echo $fee['paid'] ?></td>
                                <td style="text-align:right"><?php printf("%.2f", $fee['paid']-$fee['toPay']) ?></td>
                              </tr>
 <?php $cnt++; } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- container-fluid -->
        </div> <!-- content -->
      </div> <!-- content-wrapper -->
    </div> <!-- wraper -->
</body>
</html>
<?php } ?>
