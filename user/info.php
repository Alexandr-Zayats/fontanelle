<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
$cashier=$_SESSION['adid'];
if (strlen($_SESSION['adid'] == 0 || ($_SESSION['type'] != "cashier" && $_SESSION['type'] != "regularUser")) ) {
//if (false) {
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
  // $uid=397;
  $con->next_result();
  $query=mysqli_query($con,"call userInfo($uid, 'el')");
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
              <h1 class="h3 mb-0 text-gray-800">Электричество</h1>
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
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <table width="100%">
                      <tr>
                        <td><h6 class="m-0 font-weight-bold text-primary">Абонентская книжка. </h6></td>
			<td style="text-align:right">
			<?php if ($cashier == 1) { ?>
			  <a href="add-counter.php?uid=<?php echo $uid;?>&type=el" class="btn btn-primary btn-user btn-block">Cчетчики (добавить):</a>
			<?php } else { ?>
			  <a class="btn btn-primary btn-user btn-block">Cчетчики:</a>
			<?php }?>
                        </td>
                        <td style="text-align:left">
                          <!--<h6 class="m-0 font-weight-bold text-primary"> -->
                          <!-- <div class="form-group row"> -->
                            <!-- <div class="col-sm-6 mb-3 mb-sm-0"> -->
                              <!-- <label for="counter">Счетчики: </label> -->
                              <select id="counter" name="counter" 
                                onchange="window.location = this.options[this.selectedIndex].value" 
                                class="btn btn-primary btn-user btn-block"
                              >
                                <?php foreach ( explode(";", $user['cId']) as &$cId ) {
                                  // $query->close();
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
                                }?>
                              </select>
                            <!-- </div> -->
                          <!-- </h6> -->
                        </td>
                        <td style="text-align:right">
                          <form action="user-counter.php">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                            <input type="hidden" id="cid" name="cid" value="<?php echo $cid ?>">
                            <input type="hidden" id="type" name="type" value="el">
                            <input type="submit" value="Внести показания" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </td>
                        <td style="text-align:right">
                          <form action="user-payment.php">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>">
                            <input type="hidden" id="type" name="type" value="el">
                            <input type="hidden" id="toPay" name="toPay" value="<?php echo $toPay ?>">
                            <input type="submit" value="Оплата" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <div class="table-responsive">
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
  $con->next_result();
  $cnt=1;
  if (mysqli_multi_query($con, "call el_history($uid, $cid)")) {
    do {
      if ($result = mysqli_store_result($con)) {
        while ($countValues = mysqli_fetch_array($result)) {
          if ( ! is_null($countValues['dCur']) || ! is_null($countValues['nCur']) || ! is_null($countValues['paid']) ) { ?>
                        <tr>
                          <td style="text-align:right"><?php echo $countValues['date'] ?></td>
                          <td style="text-align:right"><?php echo $countValues['dPrev'] ?: '--';?></td>
                          <td style="text-align:right"><?php echo $countValues['dCur'] ?: '--';?></td>
                          <td style="text-align:right"><?php echo $countValues['dDelta'] ?: '0.00';?></td>
                          <td style="text-align:right"><?php echo $countValues['nPrev'] ?: '--';?></td>
                          <td style="text-align:right"><?php echo $countValues['nCur'] ?: '--';?></td>
                          <td style="text-align:right"><?php echo $countValues['nDelta'] ?: '0.00';?></td>
                          <td style="text-align:right"><?php printf("%.2f", $countValues['toPay']) ?: '0.00';?></td>
                          <td style="text-align:right"><?php echo $countValues['paid'];?></td>
                        </tr>
 <?php    }
        } 
        mysqli_free_result($result);
        $cnt++;
      }
    } while (mysqli_next_result($con));
  } ?>
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
