<?php
  namespace Phppot;
  use Phppot\DataSource;

  class UserModel
  {
    private $conn;
    function __construct() {
      require_once 'DataSource.php';
      $this->conn = new DataSource();
    }
    function call($function, $params = "") {
      $query = "call " . $function . "(" . $params . ")";
      $paramType = '';
      $paramValue = array();
      $result = $this->conn->select($query, $paramType, $paramValue);
      return $result;
    }
    function select($query, $param) {
      $paramType = 'i';
      $paramValue = array($param);
      $result = $this->conn->select($query, $paramType, $paramValue);
      return $result;
    }
  }
?>
