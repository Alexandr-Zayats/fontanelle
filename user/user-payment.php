<?php
  namespace Phppot;
  session_start();
  $_SESSION['subpage'] = true;
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();

  if ($_SESSION['toPay'] < 0) {
    $toPay = $_SESSION['toPay']*(0-1);
  } else {
    $toPay="0.00";
  }

  if(isset($_POST['payment'])) {
    if (isset($_POST['year'])) {
      $year = $_POST['year']."-01-01";
    } else {
      $year = "2000-01-01";
    }
    if (isset($_POST['bank'])) {
      $bank = "TRUE";
      $verf = "FALSE";
    } else {
      $bank = "FALSE";
      $verf = "TRUE";
    }
    if(isset( $_SESSION['imageUploadedId'])) {
      $chck = $_SESSION['imageUploadedId'];
      unset($_SESSION['imageUploadedId']);
    } else {
      $chck = 0;
    }
    //print($_SESSION['id'] . ", $uid, '$sum', '$cType', '$year', $bank, $chck, $verf");
    //exit;
    $userModel->call('sp_addMoney', $_SESSION['id'] . ", $uid, '$sum', '$cType', '$year', $bank, $chck, $verf");
    header('location:' . destPage());
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
    <script src="../includes/scripts-img.js"></script>
    <script src="../includes/scripts.js"></script>
    <script src="../includes/scripts-img.js"></script>
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
                                  if ( $cType == "el" ) {
                                    echo "Оплата электроенергии";
                                  } elseif ( $cType == "wat" )  {
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
                                <?php if ( $cType == "fee" ) { ?>
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
                                <button type="submit" name="payment" class="btn btn-primary btn-user btn-block">
                                  Оплатить
                                </button>
                            </form>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?php
                                    $_SESSION['iType'] = 'check';
                                    $_SESSION['imageOwner'] = $uid;
                                    if(isset($_SESSION['imageUploadedId'])) {
                                      $result = $imageModel->getImageById($_SESSION['imageUploadedId']);
                                      unset($_SESSION['imageUploadedId']);
                                      if (! empty($result)) {
                                        foreach ($result as $row) {
                                    ?>
                                    <table>
                                    <tr>
                                      <td>
                                        <a href=""
                                          onClick="myWindow('../<?php echo $row["image"]?>', '<?php echo $row["image"]?>', 600, 600); return false;"
                                        > <img src="../<?php echo $row['image']?>" width="100" border="0"/> </a>
                                      </td>
                                      <td>
                                        <?php formSubmit('imageId', $row['id'], 'Удалить', $_SERVER['HTTP_ORIGIN'] .'/image_delete.php')?>
                                      </td>
                                    </tr>
                                    </table>
                                    <?php
                                        }
                                      }
                                    }?>
                                  </div>
                                </div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#imageModal">
                                  <!--<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>-->
                                  <i class="btn btn-primary btn-user">Прикрепить чек</i>
                                </a>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- image Modal-->
    <?php include_once('../includes/image-modal.php')?>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>
</html>
