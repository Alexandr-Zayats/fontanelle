<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['adid']==0) || $_SESSION['type']!="cashier") {
  header('location:logout.php');
  } else {

  if(isset($_POST['update'])) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $size=$_POST['size'];
    $uid=$_GET['uid'];

    //$updatetTime = date( 'd-m-Y h:i:s A', time () );
    $query=mysqli_query($con,"call sp_userupdateprofile('$uid','$name','$email','$phone','$size')"); 
    echo "<script>alert('Профайл участка успешно обновлен');</script>";  
    echo "<script>window.location.href='registered-users.php'</script>";
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
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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

                    <!-- Topbar Navbar -->
  <?php include_once('includes/topbar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
<?php 
$uid=$_GET['uid'];
$query=mysqli_query($con,"call sp_userprofile($uid)");

mysqli_close($con);
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$counters=mysqli_query($con,"call sp_counterList($uid)");

while ($result=mysqli_fetch_array($query)) {

?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800"><?php echo $result['Name'];?> | Изменить данные</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Default Card Example -->
                            <div class="card mb-4">
                              <div class="card-header">
                                 Дата регистрации: <?php echo $result['RegDate'];?>
                              </div>
                              <div class="card-body">
                              <form method="post">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                                  role="grid" aria-describedby="dataTable_info" style="width: 100%;">              
                                  <tr>
                                    <th>Участок</th>
                                    <td>
                                      <input type="number" class="form-control form-control-user" id="id" value="<?php echo $result['id'];?>" name="id" readonly="true">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Размер участка (соток)</th>
                                    <td>
                                      <input type="number" min="0.50" max="100.00" step="0.50" class="form-control form-control-user" id="size" value="<?php echo $result['Size'];?>" name="size" required="true">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>ФИО</th>
                                    <td>
                                      <input type="text" class="form-control form-control-user" id="name" value="<?php echo $result['Name'];?>" name="name" required="true">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Телефон</th>
                                    <td>
                                      <input type="tel" class="form-control form-control-user" id="phone" value="<?php echo $result['PhoneNumber'];?>" name="phone" required="false">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Email</th>
                                    <td>
                                      <input type="email" class="form-control form-control-user" id="email" value="<?php echo $result['EmailId'];?>" name="email" required="false">
                                    </td>
                                  </tr>
                                  <tr><th>Счетчики</th>
                                    <td>
                                      <a href="add-counter.php?uid=<?php echo $result['id'];?>">Добавть счетчик</a>
                                    <td>
                                  </tr>
                                  <?php while ($counter=mysqli_fetch_array($counters)) { ?>
                                  <tr>
                                    <th style="text-align:center"><?php echo "Имя: [ ".$counter['name']." ] "; ?></th>
                                    <td><?php echo "Номер: [ ".$counter['number']." ] "; ?></td>
                                  </tr>
                                  <?php } ?>
                                  <tr>
                                    <th>Последние изменения </th>
                                    <td><?php echo $result['LastUpdationDate'];?></td>
                                  </tr>
                                  <tr>
                                    <th>Статус</th>
                                    <td>
                                      <input type="text" class="form-control form-control-user" id="fname" value="
                                        <?php  $accountstatus=$result['IsActive'];
                                          if($accountstatus==1): echo "Active"; else: echo "Blocked"; endif;
                                        ?>" name="fname" required="true">
                                    </td>
                                  </tr>
                                </table>
                                <button type="submit" name="update" class="btn btn-primary btn-user btn-block">
                                  Сохранить
                                </button>
                            </form>
                                </div>
                            </div>
<?php } ?>

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
</body>
</html>
<?php } ?>
