<?php

  namespace Phppot;
  session_start();
  //error_reporting(0);

  include_once __DIR__ . '/../includes/config.php';
  require_once __DIR__ . '/../lib/UserModel.php';
  $userModel = new UserModel();

  $uid=0;

  if (strlen($_SESSION['adid'] == 0) || $_SESSION['type'] != "cashier") {
    header('location:logout.php');
  } else {
    if(isset($_POST['payment'])) {
      header("Location: " . $_SESSION['sourcePage']);
    }
    if(isset($_POST['report'])) {
      $start=$_POST['start'];
      $stop=$_POST['stop'];
    } else {
      $start=date('Y-m-01');
      $stop=date("Y-m-d");
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
                  <h1 class="h4 text-gray-900 mb-4">Баланс</h1>
                </div>

                <div class="card-header py-3">
                  <form class="date" name="report" method="post">
                    <h6 class="m-0 font-weight-bold text-primary">Период
                      <label for="start"> с </label>
                      <input type="date" id="start" name="start" min="2021-03-01" value="<?php echo $start;?>">
                      <label for="stop"> по </label>
                      <input type="date" id="stop" name="stop" value="<?php echo $stop;?>">
                      <button type="submit" name="report"  class="btn btn-primary btn-user btn-block">
                        Сформировать
                      </button>
                    </h6>
                  </form>
                </div>

                <form class="user" name="payment" method="post">
                  <button type="submit" name="payment" class="btn btn-primary btn-user btn-block">
                    Закрыть
                  </button>
                </form>

                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <td></td>
                        <td style="text-align:center">Приход</td>
                        <td style="text-align:center">Расход</td>
                        <td style="text-align:center">Баланс</td>
                      </tr>
                    </thead>
                    <tbody>
<?php
  // $stop=date("Y-m-d");
  $query = $userModel->call('sp_balance', "'$start','$stop'");
  $income=0; $outcome=0;
  foreach ($query as $result) {
?>
                      <tr>
                        <td style="text-align:center">Электричество КВт (день)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['dK']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['tdK']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['dK']-$result['tdK']) ?></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Электричество КВт (ночь)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['nK']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['tnK']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['nK']-$result['tnK']) ?></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Электричество (грн)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pEl']); echo " из "; printf("%.2f", $result['toPay']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['toSpend']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pEl']-$result['toSpend']) ?></td>
                      </tr>
                       <tr>
                        <td style="text-align:center">Вода (кубы)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['kInWater']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['kOutWater']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['kInWater']-$result['kOutWater']) ?></td>
                      </tr>
                       <tr>
                        <td style="text-align:center">Вода (грн)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pWater']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['sWater']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pWater']-$result['sWater']) ?></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Членские взносы (грн)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pFee']) ?></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Вступительные взносы (грн)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pIncome']) ?></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Прочие (грн)</td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pOther']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['tpOther']) ?></td>
                        <td style="text-align:right"><?php printf("%.2f", $result['pOther']-$result['tpOther']) ?></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <td style="text-align:right"><b>Итого (грн):</b></td>
                      <td style="text-align:right"><b><?php $income=($result['pEl'] + $result['pFee'] + $result['pIncome'] + $result['pOther'] +  $result['pWater']); printf("%.2f", $income) ?></b></td>
                      <td style="text-align:right"><b><?php $outcome=($result['toSpend']+$result['tpOther']+$result['sWater']); printf("%.2f", $outcome) ?></b></td>
                      <td style="text-align:right"><b><?php printf("%.2f", $income-$outcome) ?></b></td>
                      </tr>
                    </tfoot>
<?php } ?>
                  </table>
                </div>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div

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
