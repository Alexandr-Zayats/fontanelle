<?php
  namespace Phppot;
  session_start();
  //$_SESSION['redirect'] = true;
  $_SESSION['subpage'] = true;

  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/lib/ImageModel.php';
  $imageModel = new ImageModel();

  $imageModel->deleteImageById($imageId);
  header('location:' . destPage());

?>
