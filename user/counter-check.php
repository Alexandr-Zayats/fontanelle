<?php
  namespace Phppot;

  session_start();
  error_reporting(0);
  include_once __DIR__ . '/../includes/config.php';
  require_once __DIR__ . '/../lib/ImageModel.php';
  require_once __DIR__ . '/../lib/UserModel.php';

  $imageModel = new ImageModel();
  $userModel = new UserModel();

  //$dCurrent=0;
  //$nCurrent=0;

  //$cashier=$_SESSION['adid'];
  if (strlen($_SESSION['adid']==0) || $_SESSION['type']!="cashier") {
    header('location:logout.php');
  } else {
    $query = $userModel->call('sp_getLastCounterValues', $cid);
    $latest = $query[0];

    // FILES upload
    if(isset($_POST['upload'])) {
      function reArrayFiles( $arr ){
        foreach( $arr as $key => $all ){
          foreach( $all as $i => $val ){
            $new[$i][$key] = $val;    
          }    
        }
        return $new;
      }
    
      $target_dir = "uploads/" . $uid . "/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }

      if ($_FILES['fileToUpload']) {
        $file_ary = reArrayFiles($_FILES['fileToUpload']);
        foreach ($file_ary as $file) {
          $target_file = $target_dir . date('Ymd') . '-' . basename($file['name']);
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          $check = getimagesize($file["tmp_name"]);
          $imageModel = new ImageModel();
          if($check !== false) {
            // Check if file already exists
            //if (!file_exists($target_file)) {
              // Check file size
              //if ($file['size'] < 500000) {
                // Allow certain file formats
                if (in_array($imageFileType, array('jpg', 'png', 'jpeg', 'gif'))) {
                  $source = $file['tmp_name'];
                  $response = $imageModel->compressImage($source, $target_file, 50);
                  if (!empty($response)) {
                    $id = $imageModel->insertImage($file["name"], $target_file, $uid);
                    //print($id);
                    //exit;
                    if (!empty($response)) {
                      $response["type"] = "success";
                      $response["message"] = "Upload Successfully";
                      $result = $imageModel->getImageById($id);
                    }
                  } else {
                    $response["type"] = "error";
                    $response["message"] = "Unable to Upload:$response";
                  /*
                  }                
                  $image = imagecreatefromjpeg($file['tmp_name']);  
                  unlink("image.jpg");
                  imagejpeg($image,"image.jpg",50);
                  if (move_uploaded_file("image.jpg", $target_file)) {
                  //if (move_uploaded_file($file['tmp_name'], $target_file)) {
                    $msg = "Файл ". htmlspecialchars( basename( $file['name'])). " сохранен.";
                    echo "<script>alert('" . $msg . "');</script>";
                  } else {
                  */
                    echo "<script>alert('Произошла ошибка при сохранении файла.');</script>";
                  }
                } else {
                  echo "<script>alert('Допустимы только JPG, JPEG, PNG, GIF файлы.');</script>";
                }
              //} else {
              //  echo "<script>alert('Файл " . $file['name'] . " слишком большой.');</script>";
              //}
            //} else {
            //  echo "<script>alert('Файл " . $file['name'] . " уже существует.');</script>";
            //}
          } else {
          echo "<script>alert('Файл " . $file['name'] . " не является изображением.');</script>";
        }
      }
    }
    echo "<script>window.location.href='counter-check.php?uid=$uid&cid=$cid&type=el'</script>";
  }
  // ------- END of FILES upload

  if(isset($_POST['submit'])) {

    $dayLast = $latest['dayLast'];
    $nightLast = $latest['nightLast'];

    //if($nightLast > $nCurrent || $dayLast > $dCurrent) {
      //echo "<script>alert('$nightLast; $nCurrent; $dayLast; $dCurrent');</script>";
      // echo "<script>alert('Введеные показания ниже предыдущих!');</script>";
    //} else {
     
    /*
    echo $cid . ", '$counterNum', '$cname', '$counterInfo', '$location'" . "\n\n";
    echo "|| \n";
    echo $uid .",". $cid . ", '$dayLast', '$dCurrent', '$nightLast', '$nCurrent'";
    exit;
    */
    
    $query = $userModel->call('sp_updateCounter', $cid . ",'$counterNum','$cname','$counterInfo','$location'");
    $query = $userModel->call('sp_addCounterValues', $uid .",". $cid . ",'$dayLast','$dCurrent','$nightLast','$nCurrent'");

    if ( $type == "el" ) {
      header("location:info.php");
    } else {
      header("location:'water.php");
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
    <link href="../css/images.css" rel="stylesheet" type="text/css" />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <script type="text/javascript">
      function myWindow(i,t,wid,hei) {
        var day= new Date();
        var id = day.getTime();
        //Full screen
        /*
        var w = (window.width); 
        var h = (window.height);
        */
        
        // You can also use the original image height and width as
        var w = wid+55;
        var h = hei+25;
        var params = 'width='+(w-5)+',height='+(h-5)+',scrollbars,resizable';

        var message='<html><head><title>'+i+'</title></head><body><h3 aligh="center">'+
        '<div align="center"><img src="'+i+'" border="0" alt="'+t+'" width="'+wid+'"><br>\
        '+
        '<hr width="100&#37;" size="1"><form><input type="button" onclick="javascript:window.close();" value="ЗАКРЫТЬ"><br>\
        '+
        '<hr width="100%" size="1"></form></div></body></html>\
        ';
        
        var mywin = open('',id,params);
        mywin.document.write(message);
        mywin.document.close();
      }
    </script>

</head>
<?php
  $query = $userModel->select('SELECT name, number, info, verDate, location FROM counters WHERE id=?', $cid);
  $counter = $query[0];
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
                                <h1 class="h4 text-gray-900 mb-4">Текущие показаний</h1>
                            </div>
                            <form class="user" name="submit" method="post" enctype="multipart/form-data" id="image">
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="uid">Участок:</label>
                                    <input type="number" class="form-control form-control-user" id="uid" name="uid"
                                      value="<?php echo $uid ?>" readonly>
                                  </div>
                                </div>
<!--
                                <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                                <input type="hidden" id="cid" name="cid" value="<?php echo $cid ?>">
-->
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="cname">Счетчик:</label>
                                    <input type="text" class="form-control form-control-user" id="cname" name="cname"
                                      value="<?php echo $counter['name'] ?>">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="location">Место установки</label>
                                    <select id="location" name="location" class="btn btn-primary btn-user btn-block">
                                    <?php
                                      $places = ['внутри', 'фасад', 'столб'];
                                      foreach($places as $place) {
                                        if ($counter['location'] == $place) {
                                          echo "<option value='" . $place . "' selected>" . $place . "</option>";
                                        } else {
                                          echo "<option value='" . $place . "'>" . $place . "</option>";
                                        }
                                      }
                                    ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="date">Последняя поверка:</label>
                                    <input type="text" class="form-control form-control-user" id="date" name="date"
                                      value="<?php echo  $counter['verDate'] ?>" readonly>
                                  </div>
                                </div>
                                
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="counterNum">Номер счетчика/пломбы</label>
                                    <input type="number" class="form-control form-control-user"
                                      id="counterNum" name="counterNum"
                                      value="<?php echo $counter['number'] ?>"
                                      required="true">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="counterInfo">Описание счетчика:</label>
                                    <input type="text" class="form-control form-control-user"
                                      id="counterInfo" name="counterInfo"
                                      value="<?php echo $counter['info'] ?>"
                                    >
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="dCurrent"><?php 
                                      if ( $type == "el" ) { echo "Показания: день";} 
                                      else { echo "Текущие показания:"; } ?>
                                    </label>
                                    <input type="number" step="0.01" class="form-control form-control-user" id="dCurrent"
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

                                <?php if ( $type == "el" AND  $latest['nightLast'] != 0 ) { ?>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="nCurrent">Показания: ночь</label>
                                    <input type="number" step="0.01" class="form-control form-control-user" id="nCurrent"
                                      value="<?php
                                        if(is_numeric($latest['nightLast'])) {
                                          echo $latest['nightLast'];
                                        } else {
                                          echo 0;
                                        }
                                      ?>"
                                      name="nCurrent" required="false">
                                  </div>
                                </div>
                                <?php } else {?>
                                    <input type="hidden" id="nCurrent" name="nCurrent" value=0>
                                <?php } ?>
                                <!--
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Фото счетчика</label>
                                    <input type="file" name="fileToUpload[]"
                                      multiple="multiple"
                                      accept=".jpg, .jpeg, .png, .gif">
                                  </div>
                                </div>
                                -->
                                <div class="form-group row">
		                              <table width="100%">
			                            <tr>
				                            <th width="80%" align="center">Фото счетчика</th>
				                            <th></th>
			                            </tr>
                                  <?php
                                  $result = $imageModel->getAllImages($uid);
                                  if (! empty($result)) {
                                    foreach ($result as $row) {
                                  ?>
                                  <tr>
                                    <td>
                                      <a href="" 
                                        onClick="myWindow('<?php echo $row["image"]?>', '<?php echo $row["image"]?>', 600, 600); return false;"
                                      > <img src="<?php echo $row['image']?>" width="100" border="0"/> </a>
                                    </td>
				                            <td>
                                      <!--<a href="update.php?id=<?php echo $row['id']; ?>" class="btn-action">Edit</a>-->
                                      <a href="image_delete.php?id=<?php echo $row['id']?>&uid=<?php echo $uid?>&cid=<?php echo $cid?>"
                                        class="btn-action">Удалить</a>
                                    </td>
                                  </tr>
                                  <?php
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td>
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="file"
                                          name="fileToUpload[]" id="fileUpload"
                                          multiple="multiple"
                                          accept=".jpg, .jpeg, .png, .gif"
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  </table>
	                              </div>
                                <button type="submit" name="upload" class="btn btn-primary btn-user btn-block">
                                  Добавить файлы
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                  Проверен
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
