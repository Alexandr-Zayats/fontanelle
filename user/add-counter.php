<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
$uid=$_GET['uid'];
$type=$_GET['type'];
$cashier=$_SESSION['adid'];
if (strlen($_SESSION['adid']==0) || $_SESSION['type']!="cashier") {
  header('location:logout.php');
} else {
  if(isset($_POST['payment'])) {
    $number=$_POST['number'];
    $name=$_POST['name'];
    $type=$_POST['type'];
    $info=$_POST['info'];
    $dCurrent=$_POST['dCurrent'];
    $nCurrent=$_POST['nCurrent'];
    mysqli_close($con);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    //echo "<script>alert('$uid $number $name $info');</script>";
    $query=mysqli_query($con,"call sp_addCounter('$uid','$number', '$name', '$info', '$type', $dCurrent, $nCurrent)");
    if ($query) {
      echo "<script>alert('Счетчик добавлен');</script>";
      echo "<script>window.location.href='info.php?uid=$uid'</script>";
    } else {
      echo "<script>alert('Что-то пошло не так!. Попробуйте еще раз.');</script>";
    }
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

    <title>РУЧЕЕК (кассир)</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h5 style="color:blue">СТ "РУЧЕЕК"</h5>
                                <h1 class="h4 text-gray-900 mb-4">Добавление счетчика</h1>
                            </div>
                            <form class="user" name="payment" method="post">
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="uid">Участок:</label>
                                  <input type="number" class="form-control form-control-user" id="uid" name="uid" value="<?php echo $uid ?>" readonly>
                                </div>
                              </div>
                              <!--
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <input type="radio" id="el" name="type" value="el" required>
                                  <label for="el">электричество</label><br>
                                  <input type="radio" id="wat" name="type" value="wat">
                                  <label for="wat">вода</label><br>
                                </div>
                              </div>
                              -->
                              <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="uid">Серийный номер:</label>
                                  <input type="number" class="form-control form-control-user" value="1111111111" id="number" name="number" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="uid">Имя:</label>
                                  <input type="text" class="form-control form-control-user" id="name" name="name" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="uid">Описание:</label>
                                  <input type="text" class="form-control form-control-user" id="info" name="info" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="dCurrent">Первичные показания (день):</label>
                                  <input type="number" class="form-control form-control-user" id="dCurrent"
                                  value="0" name="dCurrent" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="nCurrent">Первичные показания (ночь):</label>
                                  <input type="number" class="form-control form-control-user" id="nCurrent" value="0" name="nCurrent" required="true">
                                </div>
                              </div>
                              <button type="submit" name="payment" class="btn btn-primary btn-user btn-block">
                                Добавить
                              </button>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
