<?php
  namespace Phppot;
  session_start();
  $_SESSION['redirect'] = true;

  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/lib/ImageModel.php';
  $imageModel = new ImageModel();

  $imageModel->deleteImageById($imageId);
  header('location:' . destPage());

?>
