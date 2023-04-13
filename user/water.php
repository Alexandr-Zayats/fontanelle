<?php
  namespace Phppot;
  session_start();
  $_SESSION['cType'] = 'wat';
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';

  unset($cid);
  if(isset($_GET['cid'])) {
    $cid = $_GET['cid'];
  }
  $_SESSION['cType'] = 'wat';

  $query = $userModel->call('userInfo', $uid . ", 'wat'");
  $user = $query[0];
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
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 font-weight-bold text-primary">Абонентская книжка: вода</h1>
              <div class="flex-row align-items-left justify-content-between">
                <?php if ($_SESSION['loginType'] == 'admin') { ?>
                  <a href="add-counter.php?cType=el">
                    Cчетчики (добавить):
                  </a>
                <?php } else { ?>
                  <a class="btn btn-primary btn-user">Cчетчики:</a>
                <?php }?>
                <select id="cid" name="cid"
                  onchange="window.location = this.options[this.selectedIndex].value"
                  class="btn btn-primary btn-user"
                >
                  <?php foreach ( explode(";", $user['cId']) as &$c ) {
                    $sql = $userModel->call('counterInfo', "$c");
                    foreach ($sql as $counter) {
                      if (!isset($cid)) { $cid=$counter['id']; }
                        if ($counter['id'] == $cid) {
                          echo "<option value=index.php?cid=".$counter['id']." selected>".$counter['name']."</option>";
                          $_SESSION['cid'] = $cid;
                        } else {
                          echo "<option value=index.php?cid=".$counter['id'].">".$counter['name']."</option>";
                        }
                      }
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                          style="display:flex; flex-direction: row; justify-content: center; align-items: center"
                        >
                        <?php if(in_array($_SESSION['loginType'], $allowedUser)) {?>
                          <form action="water.php" method="post">
                            <label for="uid">Участок № </label>
                            <input type="text" name="uid" id="uid" value="<?php echo $uid?>"
                              maxlength="3" size="3" pattern="[0-9]+"
                            >
                            <input type="submit"value="Перейти" class="btn btn-primary btn-user">
                          </form>
                        <?php
                        } else {
                          echo "Участок № ".$user['uId'];
                        } ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <a href="edit-user-profile.php?uid=<?php echo $uid;?>">
                            <?php echo $user['uName'] ?>
                          </a>
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
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="text-align:center">Дата</th>
                          <th style="text-align:center">Предыдущие</th>
                          <th style="text-align:center">Текущие</th>
                          <th style="text-align:center">Разница</th>
                          <th style="text-align:center">К оплате</th>
                          <th style="text-align:center">Оплочено</th>
                        </tr>
                      </thead>

                      <tbody>
<?php
  $cnt=1;
  $date_of_start = date('Y-m-d');
  $date_of_end = date("Y-m-d", strtotime("-60 month", strtotime(date('Y-m-d'))));
  if($cid > 0) {
    while (strtotime($date_of_start) >= strtotime($date_of_end)) {
      $query = $userModel->call('wat_history', $uid . ", " . $cid . ", " . "'$date_of_start'");
      foreach  ($query as $countValues ) {
        if ( ! is_null($countValues['dCur']) || ! is_null($countValues['paid']) ) {
?>
                        <tr>
                          <td style="text-align:right"><?php echo $countValues['date'] ?></td>
                          <td style="text-align:right"><?php echo $countValues['dPrev'];?></td>
                          <td style="text-align:right"><?php echo $countValues['dCur'];?></td>
                          <td style="text-align:right"><?php echo $countValues['dDelta'];?></td>
                          <td style="text-align:right"><?php printf("%.2f", $countValues['toPay']);?></td>
                          <td style="text-align:right"><?php echo $countValues['paid'];?></td>
                        </tr>
 <?php
        }
      }
      $cnt++;
      $date_of_start = date ("Y-m-d", strtotime("-1 month", strtotime($date_of_start)));
    }
  }
?>
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
  <!-- Logout Modal-->
  <?php include_once('../includes/logout-modal.php')?>
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>
    
</body>
</html>
