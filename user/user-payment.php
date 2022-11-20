<?php
session_start();
//error_reporting(0);
include('../includes/config.php');

$uid=$_GET['uid'];
$type=$_GET['type'];
$toPay=$_GET['toPay'];

if ($toPay < 0) {
  $toPay = $toPay*(0-1);
} else {
  $toPay="0.00";
}

$cashier=$_SESSION['adid'];
if (strlen($_SESSION['adid']==0) || $_SESSION['type']!="cashier") {
  header('location:logout.php');
} else {
  if(isset($_POST['payment'])) {
    $sum = $_POST['sum'];
    $fee = $_POST['type'];
    $type = $_POST['type'];

    if (isset($_POST['year'])) {
      $year = $_POST['year']."-01-01";
    } else {
      $year = "2000-01-01";
    }
    if (isset($_POST['bank'])) {
      $bank = "TRUE";
    } else {
      $bank = "FALSE";
    }

    mysqli_close($con);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    // echo "<script>alert('$cashier $uid $sum $fee $bank');</script>";
    $query=mysqli_query($con,"call sp_addMoney($cashier, $uid, '$sum', '$fee', '$year', $bank)");

    if ($query) {
      echo "<script>alert('Счет успешно пополнен');</script>";
      if ( $type == "el" ) {
        echo "<script>window.location.href='info.php?uid=$uid'</script>";
      } elseif ( $type == "wat" )  {
        echo "<script>window.location.href='water.php?uid=$uid'</script>";
      } else {
        echo "<script>window.location.href='fee.php?uid=$uid'</script>";
      }
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
                                <h1 class="h4 text-gray-900 mb-4"><?php
                                  if ( $type == "el" ) {
                                    echo "Оплата электроенергии";
                                  } elseif ( $type == "wat" )  {
                                    echo "Оплата за воду";
                                  } else {
                                    echo "Членские взносы";
                                  }
                                ?></h1>
                            </div>
                            <form class="user" name="payment" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                      <label for="uid">Участок:</label>
                                      <input type="number" class="form-control form-control-user" id="uid" name="uid" value="<?php echo $uid ?>" readonly>
                                    </div>
                                </div>
                                <?php if ( $type == "fee" ) { ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                      <select id="year" name="year" class="btn btn-primary btn-user btn-block">
                                        <?php
                                        $curYear = date("Y");
                                        $startYear = $curYear + 1;
                                        $lastYear = $curYear - 15;
                                        for ( $year = $startYear; $year >= $lastYear; $year-- ) {
                                          if ( $year == $curYear ) {
                                            echo "<option value=".$year." selected>".$year."</option>";
                                          } else {
                                            echo "<option value=".$year.">".$year."</option>";
                                          }
                                        }
                                        ?>
                                      </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" min="0.10" max="50000.00" step="0.01"
                                          class="form-control form-control-user" id="sum" name="sum" required="true"
					  value="<?php echo $toPay ?>">
				    </div>
				    <div class="col-sm-6 mb-3 mb-sm-0">
					<input type="checkbox" id="bank" name="bank">
      					  <label for="bank">  На счет</label>
                                    </div>
                                </div>
                                <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                                <!-- 
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="radio" id="type" name="type" value="el" required>
                                    <label for="fee">электричество</label><br>
                                    <input type="radio" id="type" name="type" value="wat">
                                    <label for="wat">вода</label><br>
                                    <input type="radio" id="type" name="type" value="fee">
                                    <label for="fee">членские взносы</label><br>
                                    <input type="radio" id="type" name="type" value="inc">
                                    <label for="income">вступительный взнос</label>
                                  </div>
                                </div>
                                -->
                                <button type="submit" name="payment" class="btn btn-primary btn-user btn-block">
                                  Оплатить
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
