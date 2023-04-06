<?php
  namespace Phppot;
  use Phppot\DataSource;
  require_once __DIR__ . '/../includes/config.php';
  require_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();

  $result = $imageModel->deleteImageById($id);

  header("Location: " . $_SESSION['sourcePage']);

?>
