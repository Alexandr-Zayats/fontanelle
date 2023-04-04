<?php
namespace Phppot;
use Phppot\DataSource;

class ImageModel
{
  private $conn;
  function __construct() {
    require_once 'DataSource.php';
    $this->conn = new DataSource();
  }
  function getAllImages($userId) {
    $query = "SELECT * FROM images WHERE userId=?";
    $paramType = 'i';
    $paramValue = array($userId);
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
  function insertImage($file, $target_file, $user) {
    $insertId = 0;
    if (! empty($target_file)) {
      $query = "INSERT INTO images(name,image,userId) VALUES(?,?,?)";
      $paramType = 'ssi';
      $paramValue = array($file, $target_file, $user);
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
}
?>
