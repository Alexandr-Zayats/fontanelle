<?php

  namespace Phppot;
  session_start();
  //error_reporting(0);

  include_once __DIR__ . '/../includes/config.php';
  require_once __DIR__ . '/../lib/UserModel.php';
  $userModel = new UserModel();

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
    <script src="../includes/scripts.js"> </script>

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
                          <h6 class="m-0 font-weight-bold text-primary">Дачники</h6>
                          <form action="createResident.php" method="post">
                            <input type="hidden" name="uid" id="uid" value="-1">
                            <input type="submit" value="Добавить" class="btn btn-primary btn-user btn-block"/>
                          </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th style="width: 3%; text-align:center">#</th>
                                      <th style="width: 3%; text-align:center">ID</th>
                                      <th style="width: 27%; text-align:center">ФИО</th>
                                      <th style="width: 6%; text-align:center">Логин</th>
                                      <th style="width: 14%; text-align:center">Телефон</th>
                                      <th style="width: 13%; text-align:center">Email</th>
				                              <th style="width: 19%; text-align:center">Автомобиль</th>
                                      <th style="width: 5%; text-align:center">Участки</th>
                                      <th style="width: 9%; text-align:center">Баланс</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th style="text-align:center">#</th>
                                      <th style="text-align:center">ID</th>
                                      <th style="text-align:center">ФИО</th>
                                      <th style="text-align:center">Логин</th>
                                      <th style="text-align:center">Телефон</th>
                                      <th style="text-align:center">Email</th>
                                      <th style="text-align:center">Автомобиль</th>
                                      <th style="text-align:center">Участки</th>
                                      <th style="text-align:center">Баланс</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
<?php
  $query = $userModel->call('residents', 0);
  $cnt=1;
  foreach ($query as $result) {
?>
                                    <tr>
                                      <td style="text-align:right"><?php printf('%d', $cnt);?></td>
                                      <td style="text-align:center">
                                        <?php printf('%d', $result['id']);?>
                                      </td>

                                      <td style="text-align:left">
                                        <form class="user" id="<?php printf('%d', $result['id'])?>" action="createResident.php" method="post">
                                          <input type="hidden" name="uid" placeholder="" value="<?php printf('%d', $result['id'])?>">
                                          <a class="nav-link" style="cursor:pointer" onclick="submit(<?php printf('%d', $result['id'])?>)">
                                            <i class="fas fa-fw fa-user"></i>
                                            <span><?php printf('%s', $result['resName'])?></span>
                                          </a>
                                        </form>
                                      </td>

                                      <td style="text-align:left">
                                          <?php printf('%s', $result['userName']);?>
                                      </td>

				                              <td style="text-align:right">
                                        <?php
                                          if (preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches)) {
                                              $phone="+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                          } else {
                                            $phone="";
                                          }
                                        ?>
                                        <a title="<?php printf('%s', $phone) ?>">
                                        <?php 
					                                if (preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone1'],  $matches)) {
    					                              printf('%s', trim("+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]", "\n"));
					                                } else {
					                                  printf('%s', "Телефон не указан");
					                                }
                                        ?>
                                        </a>
                                      </td>
                                      <td style="text-align:right">
                                        <?php printf('%s', $result['email']);?>
                                      </td>

				                              <td style="text-align:right">
                                        <?php printf('%s', $result['auto']);?>
                                      </td>

                                      <td style="text-align:right">
                                        <?php printf('%s', $result['plants']);?>
                                      </td>

                                      <td style="text-align:right">
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
