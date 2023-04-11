<?php
  namespace Phppot;
  session_start();
  //$_SESSION['subpage'] = true;
  //include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/lib/ImageModel.php';
  $imageModel = new ImageModel();

  $result = $imageModel->getImageById(104);
  print_r($result);
?>
