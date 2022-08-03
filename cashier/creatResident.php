<?php
//db Connection file
include('../includes/config.php');
//code for createuser
if(isset($_POST['createuser'])) {
  $id=intval($_POST['id']);
  $street=$_POST['street'];
  $name=$_POST['name'];
  $phone=$_POST['phone'];
  $email=$_POST['email'];
  $size=$_POST['size'];
  $counterNum=$_POST['counterNum'];
  $counterName=$_POST['counterName'];
  $counterInfo=$_POST['counterInfo'];
  $dCurrent=$_POST['dCurrent'];
  $nCurrent=$_POST['nCurrent'];
  $result=count(mysqli_fetch_array(mysqli_query($con,"call sp_checkidavailabilty($id)")));
  if($result>0){
    echo "<script>alert('Участок уже заерегистрирован!');</script>";
  } else {
    mysqli_close($con);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    //echo "<script>alert('$id $name $street $phone $size $counterNum $counterName $counterInfo $dCurrent $nCurrent $email');</script>";
    $query=mysqli_query($con, "call sp_registration($id, '$name', $street, '$phone', '$size', '$counterNum', '$counterName', '$counterInfo', '$dCurrent', '$nCurrent', '$email')");
    if ($query) {
      echo "<script>alert('Новый садовый участок успешно добавлен');</script>";
      echo "<script>window.location.href='registered-users.php'</script>";
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
  mysqli_close($con);
  $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
  $streets=mysqli_query($con,"call sp_streetList()");
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
                                <h1 class="h4 text-gray-900 mb-4">Добавление нового садового хозяйства!</h1>
                            </div>
                            <form class="user" name="createuser" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" class="form-control form-control-user" id="id"
                                        placeholder="Номер участка" name="id" min="1" max="500" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="street">Улица: </label>
                                        <select id="street" name="street">
                                          <?php
                                          while ($street=mysqli_fetch_array($streets)) {
                                            echo "<option value=".$street['id'].">".$street['name']."</option>";
                                          }
                                          ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="size">Размер участка (сотки):</label>
                                        <input type="number" min="0.50" max="100.00" step="0.01" class="form-control form-control-user"
                                        value="5.50" id="size" name="size" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="name"
                                        placeholder="ФИО" name="name" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="tel" class="form-control form-control-user" id="phone"
                                    placeholder="+38 (067) 234 34 56" name="phone" required="true"
                                    pattern="+380 ([0-9]{2}) [0-9]{3} [0-9]{2} [0-9]{2}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="email"
                                     required="true" name="email" placeholder="Email">
                                  </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="counterNum">Серийный номер:</label>
                                  <input type="number" class="form-control form-control-user" 
                                  id="counterNum" name="counterNum" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="counterName">Счетчик (имя):</label>
                                  <input type="text" class="form-control form-control-user" id="counterName"
                                  value="Дом" name="counterName" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="counterInfo">Описание счетчика:</label>
                                  <input type="text" class="form-control form-control-user"
                                  id="counterInfo" name="counterInfo" required="false"
                                  value="основной счетчик">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="dCurrent">Первичные показания (день):</label>
                                  <input type="number" class="form-control form-control-user" id="dCurrent" name="dCurrent" required="true">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="nCurrent">Первичные показания (ночь):</label>
                                  <input type="number" class="form-control form-control-user" id="nCurrent" name="nCurrent" required="true">
                                </div>
                              </div>
                              <button type="submit" name="createuser" class="btn btn-primary btn-user btn-block">
                                Зарегистрировать
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
