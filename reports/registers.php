<?php
  namespace Phppot;
  session_start();
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';

  /*
  if(isset($_GET['week'])) {
    $week = $_GET['week'];
    $year = $_GET['year'];
  }
  */
  if(!isset($week)) {
    $week=date('W')-1;
  }
  if(!isset($year)) {
    $year=date('Y');
  }
  //echo "<script>alert('$year  $week');</script>";
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
			                  <table width="100%">
			                    <tr>
			                        <h6 class="m-0 font-weight-bold text-primary">
			                        <td align=center>
			                          <label for="year"> Год </label>
			                        </td>
                              <td>
                                <select id="year" name="year" class="btn btn-primary btn-user btn-block"
                                  onchange="window.location = this.options[this.selectedIndex].value">
                                <?php
                                  $curYear = $year;
                                  $startYear = date('Y');
                                  $lastYear = '2021';
                                  for ( $i = $startYear; $i >= $lastYear; $i-- ) {
                                    if ( $i == $curYear ) {
                                      echo "<option value=registers.php?week=".$week."&year=".$i." selected>".$i."</option>";
                                    } else {
                                      echo "<option value=registers.php?week=".$week.".&year=".$i.">".$i."</option>";
                                    }
                                  }
                                ?>
			                          </select>
			                        </td>
			                        <td align=center>
			                          <label for="week">Ведомость №: </label>
                              </td>
                              <td>
                                <select id="week" name="week" class="btn btn-primary btn-user btn-block"
                                  onchange="window.location = this.options[this.selectedIndex].value">
			                          <?php
				                          $curWeek = $week;
                                  $startWeek = 53;
                                  $lastWeek = 1;
                                  for ( $i = $startWeek; $i >= $lastWeek; $i-- ) {
                                    if ( $i == $curWeek ) { 
                                      echo "<option value=registers.php?year=".$year."&week=".$i." selected>".$i."</option>";
                                    } else {
                                      echo "<option value=registers.php?year=".$year."&week=".$i.">".$i."</option>";
                                    }
                                  }
                                ?>
			                          </select>
                              </td>
                              <td>
                                <form action="printRegisters.php" method="post">
                                  <input type="hidden" id="pYear" name="pYear" value="<?php echo $year ?>">
                                  <input type="hidden" id="pWeek" name="pWeek" value="<?php echo $week ?>">
                                  <input type="submit" value="Печать" class="btn btn-primary btn-user btn-block"/>
                                </form>
                              </td>
                            </h6>
			                    </tr>
		                    </table>
		                  </div>

	  <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
	      <div class="card shadow mb-4">
		<div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <td style="width: 2%; text-align:right">#</td>
                        <th style="width: 3%; text-align:center">Участок</th>
                        <th style="width: 30%; text-align:center">ФИО</th>
                        <th style="width: 15%; text-align:center">Назначение</th>
                        <th style="width: 10%; text-align:center">Сумма</th>
                        <th style="width: 20%; text-align:center">Время проводки</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $_SESSION['iType'] = 'check';
                      $_SESSION['imageOwner'] = -1;
		                  $query = $userModel->call('vedomost', "$year, $week");
		                  $sumEl=0; $sumWat=0; $sumFee=0; $sumInc=0; $sumOthers;
                      $cnt=1;
		                  foreach ($query as $result) {
		                ?>
		                  <tr>
                        <td style="text-align:center"><?php echo $cnt;?></td>
                        <td style="text-align:right">
                          <form action="../user/" method="post">
                            <input type="hidden" id="uid" name="uid"
                              id="<?php echo $result['id']?>"
                              value="<?php echo $result['id']?>"
                            >
                            <input type="submit" value="<?php echo $result['id']?>" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </td>
                        <td>
                          <?php formSubmit('uid', $result['rId'], $result['name'], 'createResident.php')?>
                        </td>
                        <td style="text-align:right"><?php
                          if ($result['dst'] == 'el') {echo "Электричество"; $sumEl+=$result['sum']; }
                          elseif ($result['dst'] == "wat") { echo "Вода";  $sumWat+=$result['sum'];}
                          elseif ($result['dst'] == "fee") { echo "Членские"; $sumFee+=$result['sum'];}
                          elseif ($result['dst'] == "inc") { echo "Вступительный"; $sumInc+=$result['sum'];}
                          else { echo "Прочее"; $sumOthers+=$result['sum'];}
                        ?></td>
                        <?php if($result['type']): ?>
                        <td style="text-align:right; background-color:powderblue;"><?php echo $result['sum']; ?></td>
                        <?php else: ?>
                        <td style="text-align:right"><?php echo $result['sum']; ?></td>
                        <?php endif ?>
			                  <td style="text-align:right"><?php echo $result['date']; ?></td>
                      </tr>
                    <?php $cnt++; }?>
		    </tbody>
		  </table>
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		    <tfoot>
		      <tr>
			      <td style="text-align:right"><b><?php echo "Итого:";?></b></td>
            <td style="text-align:right"><b><?php echo "Електричество: " . number_format($sumEl, 2, '.', ' ');?></b></td>
            <td style="text-align:right"><b><?php echo "Вода: " . number_format($sumWat, 2, '.', ' ');?></b></td>
            <td style="text-align:right"><b><?php echo "Членские: " . number_format($sumFee, 2, '.', ' ');?></b></td>
            <td style="text-align:right"><b><?php echo "Вступительный: " . number_format($sumInc, 2, '.', ' ');?></b></td>
            <td style="text-align:right"><b><?php echo "Прочие: " . number_format($sumOthers, 2, '.', ' ');?></b></td>
			      <td style="text-align:right"><b><?php echo "Сумма: " . number_format($sumEl+$sumWat+$sumFee+$sumInc+$sumOthers, 2, '.', ' ');?></b></td>
		      </tr>
                    </tfoot>
                  </table>
                </div>
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
    </div>
      <!-- Scroll to Top Button -->
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <?php include_once('../includes/logout-modal.php')?>
  <!-- image Modal-->
  <?php include_once('../includes/image-modal.php')?>
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
