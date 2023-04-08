<?php
  namespace Phppot;
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/includes/config.php';
  require_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();

  $result = $imageModel->deleteImageById($imageId);
  header("Location: " . $_SESSION['sourcePage']);

?>
