<?php
  namespace Phppot;
  session_start();
  $_SESSION['subpage'] = false;
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/lib/ImageModel.php';
  $imageModel = new ImageModel();

  // FILES upload
  function reArrayFiles( $arr ) {
    foreach( $arr as $key => $all ){
      foreach( $all as $i => $val ){
        $new[$i][$key] = $val;    
      }    
    }
    return $new;
  }
    
  $target_dir = "user/uploads/";
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  if ($_FILES['files']) {
    $file_ary = reArrayFiles($_FILES['files']);
    foreach ($file_ary as $file) {
      print_r($file);
      exit;
      //$target_file = $target_dir . date('Ymd') . '-' . basename($file['name']);
      $target_file = $target_dir . md5(basename($file['name']) . date('Y-m-d H:i:s:u')) . ".jpg";
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if (in_array($imageFileType, array('jpg', 'png', 'jpeg', 'gif'))) {
        $source = $file['tmp_name'];
        $response = $imageModel->compressImage($source, $target_file, 50);
        if (!empty($response)) {
          //print($file["name"] . ", $target_file, $imageOwner, $iType");
          //exit;
          $_SESSION['imageUploadedId'] = $imageModel->insertImage($file["name"], $target_file, $imageOwner, $iType);
          if (!empty($response)) {
            $response["type"] = "success";
            $response["message"] = "Upload Successfully";
            $result = $imageModel->getImageById($_SESSION['imageUploadedId']);
            echo "$$result[image]";
            exit;
          }
        } else {
          $response["type"] = "error";
          $response["message"] = "Unable to Upload:$response";
          echo "<script>alert('Произошла ошибка при сохранении файла.');</script>";
        }
      } else {
        echo "<script>alert('Допустимы только JPG, JPEG, PNG, GIF файлы.');</script>";
      }
    }
  }
  die;
?>
