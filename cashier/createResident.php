<?php
session_start();
//error_reporting(0);
//db Connection file
include('../includes/config.php');
//code for createuser
if (strlen($_SESSION['adid']==0) || $_SESSION['type']!="cashier") {
  header('location:logout.php');
} else {
  if(isset($_POST['createuser'])) {
    $id=intval($_POST['id']);
    $surName=$_POST['surName'];
    $name=$_POST['name'];
    $middlName=$_POST['middlName'] ?? '';
    $email=$_POST['email'] ?? '';
    $userName=$_POST['userName'] ?? '';
    $password=$_POST['password'] ?? '';
    $phone1=$_POST['phone1'];
    $phone2=$_POST['phone2'] ?? '';
    $isMember=1;
    $autoInfo=$_POST['autoInfo'] ?? '';
    $autoNum=$_POST['autoNum'] ?? '';
    mysqli_close($con);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    //echo "<script>alert('$id, $surName, $name, $middlName, $userName, $password, $email, $phone1, $phone2, $isMember, $autoInfo, $autoNum');</script>";
    $query=mysqli_query($con, "call updateResidentProfile($id, '$surName', '$name', '$middlName', '$userName', '$password', '$email', '$phone1', '$phone2', $isMember, '$autoInfo', '$autoNum')");
    if ($query) {
      echo "<script>alert('Новый дачник успешно зарегистрирован');</script>";
      echo "<script>window.location.href='residents.php'</script>";
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
  if (isset($_GET['uid'])) {
    $uid=$_GET['uid'];
  } else {
    $uid=-1;
  }
  echo $uid;
  $query=mysqli_query($con,"call residents($uid)");
  while ($result=mysqli_fetch_array($query)) {

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
                                <h1 class="h4 text-gray-900 mb-4">Регистрaция / правка Дачника!</h1>
                            </div>
                            <form class="user" name="createuser" method="post">
                                <input type="hidden" id="id" name="id"
                                  <?php
                                    echo "value=\"".$uid."\" ";
                                  ?>
                                >
                                <div class="formgroup row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="surName"
                                      name="surName" required="true"
                                      <?php
                                        if(isset($result['surName'])) {
                                          echo "value=\"".$result['surName']."\" ";
                                        } else {
                                          echo "placeholder=\"Фамилия\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="formgroup row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="name"
                                      name="name" required="true"
                                      <?php
                                        if(isset($result['name'])) {
                                          echo "value=\"".$result['name']."\" ";
                                        } else {
                                          echo "placeholder=\"Имя\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="formgroup row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="middlName"
                                      name="middlName"
                                      <?php
                                        if(isset($result['middlName'])) {
                                          echo "value=\"".$result['middlName']."\" ";
                                        } else {
                                          echo "placeholder=\"Отчество\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="formgroup row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="userNmae"
                                      name="userName"
                                      <?php
                                        if(isset($result['userName']) AND $result['userName'] != "") {
                                          echo "value=\"".$result['userName']."\" ";
                                        } else {
                                          echo "placeholder=\"Логин\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="formgroup row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="passwd"
                                      name="passwd"
                                      <?php
                                        if(isset($result['password'])) {
                                          echo "value=\"".$result['password']."\" ";
                                        } else {
                                          echo "placeholder=\"Пароль\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="tel" class="form-control form-control-user" id="phone1"
                                      name="phone1" required="true"
                                      pattern="+38 ([0-9]{3}) [0-9]{3}-[0-9]{2}-[0-9]{2}"
                                      <?php
                                        if(isset($result['phone1'])) {
                                          if (preg_match('/.*(\d{3})(\d{3})(\d{2})(\d{2})$/', $result['phone1'],  $matches)) {
                                            $phone="+38 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                          } else {
                                            $phone=$result['phone1'];
                                          }
                                          echo "value=\"".$phone."\" ";
                                        } else {
                                          echo "placeholder=\"+38 (067) 123-45-67\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="tel" class="form-control form-control-user" id="phone2"
                                      name="phone2"
                                      pattern="+38 ([0-9]{3}) [0-9]{3}-[0-9]{2}-[0-9]{2}"
                                      <?php
                                        if(isset($result['phone2']) AND $result['phone2'] != "") {
                                          if (preg_match('/.*(\d{3})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches)) {
                                            $phone="+38 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
                                          } else {
                                            $phone=$result['phone2'];
                                          }
                                          echo "value=\"".$phone."\" ";
                                        } else {
                                          echo "placeholder=\"+38 (067) 123-45-67\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="email"
                                      name="email"
                                      <?php
                                        if(isset($result['email']) AND $result['email'] != "") {
                                          echo "value=\"".$result['email']."\" ";
                                        } else {
                                          echo "placeholder=\"email@gmail.com\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="counterNum">Автомобиль:</label>
                                    <input type="text" class="form-control form-control-user" 
                                      id="autoInfo" name="autoInfo"
                                      <?php
                                        if (isset($result['autoInfo']) AND $result['autoInfo'] != "") {
                                          echo "value=\"".$result['autoInfo']."\" ";
                                        } else {
                                          echo "placeholder=\"Марка, модель, цвет\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="autoNum"
                                      name="autoNum"
                                      <?php
                                        if(isset($result['autoNum']) AND $result['autoNum'] != "") {
                                          echo "value=\"".$result['autoNum']."\" ";
                                        } else {
                                          echo "placeholder=\"AA1234BX\"";
                                        }
                                      ?>
                                    >
                                  </div>
                                </div>

                                <button type="submit" name="createuser" class="btn btn-primary btn-user btn-block">
                                  Сохранить
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
<?php } ?> 
</body>

</html>
