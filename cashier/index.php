<?php
  namespace Phppot;
  session_start();
  unset($_SESSION['subpage']);
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();
 
  $query = $userModel->call('sp_totalPayment', '');
  $result = $query[0];
  if(isset($vrf) and isset($pId)) {
    $userModel->call('uprovePayment', "$pId, $vrf");
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

  <title>РУЧЕЕК (кассир)</title>
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet"
  >
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <script src="../includes/scripts.js"> </script>
  <script src="../includes/scripts-img.js"></script>
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Платежи</h1>
          </div>
          <!-- Content Row -->
		      <div class="row">
			      <div class="col-xl-2 col-md-4 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
					            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
						            Касса: <p style="color:red; display:inline; font-size:14px"> <?php echo $result['cash'];?> </p>
                      </div>
					            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
						            Банк: <p style="color:red; display:inline; font-size:14px"><?php echo $result['bank'];?> </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Электричество
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $result['el'];?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Вода
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $result['wat'];?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Членские взносы
                      </div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php echo $result['fee'];?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Вступительные взносы
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $result['inc'];?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Content Row -->
          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Последние платежи</h6>
                </div>
                <!-- Card Body -->
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
                        <th style="width: 3%; text-align:center">Проверен</th>
                        <th style="width: 17%; text-align:center">Чек</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $query = $userModel->call('sp_recent30payments', '');
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
                          if ($result['dst'] == 'el') {echo "Электричество"; }
                          elseif ($result['dst'] == "wat") { echo "Вода"; }
                          elseif ($result['dst'] == "fee") { echo "Членские"; }
                          elseif ($result['dst'] == "inc") { echo "Вступительный"; }
                          else { echo "Прочее"; }
                        ?></td>
					              <?php if($result['type']): ?>
					                <td style="text-align:right; background-color:powderblue;"><?php echo $result['sum']; ?></td>
					              <?php else: ?>
					                <td style="text-align:right"><?php echo $result['sum']; ?></td>
					              <?php endif ?>
                        <td style="text-align:right"><?php echo $result['date']; ?></td>
                        <td align='center'>
                          <?php
                            $approvers = array('admin');
                            if($result['verified'] == 1) { echo "Да"; }
                            else {
                              if (in_array($_SESSION['loginType'], $approvers)) {?>
                                <form class='user' id='<?php echo $result['pId']?>' action='' method='post'>
                                  <input type='hidden' name='vrf' value='1'>
                                  <input type='hidden' name='pId' value="<?php echo $result['pId']?>">
                                  <a class='nav-link' style='cursor:pointer' onclick='submit(<?php echo $result['pId']?>)'>
                                    <span>НЕТ</span>
                                  </a>
                                </form>
                                <?php
                              } else {
                                echo "НЕТ";
                              }
                            }
                          ?>
                        </td>
                        <td>
                          <?php
                            $result = $imageModel->getImageById($result['chck']);
                            if (! empty($result)) {
                              foreach ($result as $row) {
                            ?>
                              <a href=""
                                onClick="myWindow('../<?php echo $row["image"]?>', '<?php echo $row["image"]?>', 600, 600); return false;"
                              > <img src="../<?php echo $row['image']?>" width="100" border="0"/> </a>
                            <?php }}?>
                        </td>
                      </tr>
                    <?php $cnt++; }?>
                    </tbody>
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
  <?php include_once('../includes/logout-modal.php');?>
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
