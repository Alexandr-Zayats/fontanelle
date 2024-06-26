<?php
  namespace Phppot;
  use Phppot\DataSource;

  class ImageModel {
    private $conn;
    function __construct() {
      require_once 'DataSource.php';
      $this->conn = new DataSource();
    }
    function getAllImages($userId, $type) {
      $query = "SELECT * FROM images WHERE userId=? and type=? ORDER BY id DESC";
      $paramType = 'is';
      $paramValue = array($userId, $type);
      $result = $this->conn->select($query, $paramType, $paramValue);
      return $result;
    }
    function getImageById($id) {
      $query = "SELECT * FROM images WHERE id=?";
      $paramType = 'i';
      $paramValue = array($id);
      $result = $this->conn->select($query, $paramType, $paramValue);
      return $result;
    }
    function insertImage($file, $target_file, $user, $type) {
      $insertId = 0;
      if (! empty($target_file)) {
        $query = "INSERT INTO images(name,image,userId,type) VALUES(?,?,?,?)";
        $paramType = 'ssis';
        $paramValue = array($file, $target_file, $user, $type);
        $insertId = $this->conn->insert($query, $paramType, $paramValue);
      }
      return $insertId;
    }
    function compressImage($sourceFile, $outputFile, $outputQuality) {
      $imageInfo = getimagesize($sourceFile);
      if ($imageInfo['mime'] == 'image/gif') {
        $imageLayer = imagecreatefromgif($sourceFile);
      } else if ($imageInfo['mime'] == 'image/jpeg') {
	$imageLayer = imagecreatefromjpeg($sourceFile);
      } else if ($imageInfo['mime'] == 'image/png') {
        $imageLayer = imagecreatefrompng($sourceFile);
      }
      $response = imagejpeg($imageLayer, $outputFile, $outputQuality);
      return $response;
    }
    function deleteImageById($id) {
      $query = "SELECT image FROM images WHERE id=?";
      $paramType = 'i';
      $paramValue = array($id);
      $result = $this->conn->select($query, $paramType, $paramValue);
      $image_name = $result[0]['image'];
      if(file_exists($image_name)){
	      $delete  = unlink($image_name);
      }
      $query = "DELETE FROM images WHERE id=?";
      $result = $this->conn->delete($query, $paramType, $paramValue);
      return $result;
    }
  }
?>
