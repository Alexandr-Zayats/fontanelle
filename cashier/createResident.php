<?php
  namespace Phppot;
  session_start();
  $_SESSION['subpage'] = true;
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();

  $phone_regex = array("-", "(", ")", "+38", "+", "_", " ");
  $_SESSION['rId'] = $rId;

  if(isset($_POST['createuser'])) {
    $middlName = $middlName ?: '';
    $email = $email ?: '';
    $userName = $userName ?: '';
    $userPass = $userPass ?: '';
    $phone1 = intval(str_replace($phone_regex, '', $phone1));
    $phone2 = intval(str_replace($phone_regex, '', $phone2));
    $isMember = 1;
    $autoInfo = $autoInfo ?: '';
    $autoNum = $autoNum ?: '';
    //print("$rId,'$surName','$name','$middlName','$userName','$userPass','$email',$phone1,$phone2,$isMember,'$autoInfo','$autoNum'");
    //exit;

    $userModel->call('updateResidentProfile', "$rId, '$surName', '$name', '$middlName', '$userName', '$userPass', '$email', $phone1, $phone2, $isMember, '$autoInfo', '$autoNum'");

    header('location:' . destPage());
      /*
      if ($query) {
        echo "<script>alert('Новый дачник успешно зарегистрирован');</script>";
        echo "<script>window.location.href='residents.php'</script>";
      } else {
        echo "<script>alert('Что-то пошло не так!. Попробуйте еще раз.');</script>";
      }
    */
  }
  $query = $userModel->call('residents', $rId);
  $result = $query[0];
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
                                <h1 class="h4 text-gray-900 mb-4">Регистрaция / правка Дачника!</h1>
                            </div>
                            <form class="user" name="createuser" method="post">
                                <input type="hidden" id="rId" name="rId"
                                  <?php
                                    echo "value=\"".$rId."\" ";
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
                                    <input type="password" class="form-control form-control-user" id="userPass"
                                      name="userPass"
                                      <?php
                                        if(isset($result['password']) AND ($result['password'] != "")) {
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
                                        if(isset($result['phone1']) AND preg_match('/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone1'],  $matches)) {
                                          echo "value=\"+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]\"";
                                        } else {
                                          echo "placeholder=\"+380 (67) 123-45-67\"";
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
                                        if(isset($result['phone2']) AND preg_match('/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches)) {
                                          echo "value=\"+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]\"";
                                        } else {
                                          echo "placeholder=\"+380 (67) 123-45-67\"";
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
                                <div class="form-group row">
                                  <table width="100%">
                                  <?php
                                  unset($_SESSION['imageUploadedId']);
                                  $_SESSION['iType'] = 'passport';
                                  $_SESSION['imageOwner'] = $rId;
                                  $result = $imageModel->getAllImages($_SESSION['imageOwner'], $_SESSION['iType']);
                                  if (! empty($result)) {
                                    foreach ($result as $row) {
                                  ?>
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
                                  <?php
                                    }
                                  }
                                  ?>
                                  </table>
                                </div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#imageModal">
                                  <i class="btn btn-primary btn-user">Прикрепить документы</i>
                                </a>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal-->
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
