<?php
  namespace Phppot;
  session_start();
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';

  if(isset($_POST['addvalues'])) {

    $latest=mysqli_fetch_assoc(mysqli_query($con,"call sp_getLastCounterValues($counter)"));
    if($latest[nightLast] > $nCurrent || $latest[dayLast] > $dCurrent) {
      echo "<script>alert('Введеные показания ниже предыдущих!');</script>";
    } else {
      $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
      // echo "<script>alert('uid=$uid counter=$counter latesD=$latest[dayLast] currentD=$dCurrent latestN=$latest[nightLast] currentN=$nCurrent');</script>";
      $query=mysqli_query($con,"call sp_addCounterValues($uid,$counter,'$latest[dayLast]','$dCurrent','$latest[nightLast]','$nCurrent')");
      if ($query) {
        echo "<script>alert('Показания успешно занесены');</script>";
        echo "<script>window.location.href='registered-users.php'</script>";
        header("Location: " . $_SESSION['sourcePage']);
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

<?php
  $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
  $counters=mysqli_query($con,"call sp_counterList($uid)");
?>

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
                                <h1 class="h4 text-gray-900 mb-4">Внести показаний счетчика</h1>
                            </div>
                            <form class="user" name="addvalues" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                      <label for="uid">Участок:</label>
                                      <input type="number" class="form-control form-control-user" id="uid" name="uid"
                                        value="<?php echo $uid ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="counter">Счетчик: </label>
                                        <select id="counter" name="counter">
                                          <?php
                                          while ($counter=mysqli_fetch_array($counters)) {
                                            echo "<option value=".$counter['id'].">".$counter['name']."</option>";
                                          }
                                          ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="dCurrent">День:</label>
                                        <input type="number" class="form-control form-control-user" id="dCurrent"
                                        value="<?php
  if(is_numeric($latest['dayLast']) && isset($latest['dayLast'])) {
    echo $latest['dayLast'];
  } else {
    echo '0';
  }
?>"
                                        name="dCurrent" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="nCurrent">Ночь:</label>
                                        <input type="number" class="form-control form-control-user" id="nCurrent"
                                        value="<?php
  if(is_numeric($latest[nightLast])) {
    echo $latest[nightLast];
  } else {
    echo 0;
  }
?>"
                                          name="nCurrent" required="false">
                                    </div>
                                </div>
                                <button type="submit" name="addvalues" class="btn btn-primary btn-user btn-block">
                                    Внести
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
