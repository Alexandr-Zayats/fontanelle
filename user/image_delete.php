<?php
  namespace Phppot;
  use Phppot\DataSource;
  require_once __DIR__ . '/../includes/config.php';
  require_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();
  $id = $_GET['id'];
  $cid = $_GET['cid'];
  $uid = $_GET['uid'];

  $result = $imageModel->deleteImageById($id);
  echo "<script>window.location.href='counter-check.php?uid=$uid&cid=$cid&type=el'</script>";
?>
