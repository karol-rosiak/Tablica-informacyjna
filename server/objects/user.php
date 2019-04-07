<?php
require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php'; // include Composer's autoloader

class Database{
  //connection
  private $connection;
  private $db;
  private $collection;

  //fields
  private $login;
  private $password;

  function __construct() {
    $this->connection = new MongoDB\Client("mongodb://localhost:27017");
    $this->db = $this->connection->tablica_informacyjna;
    $this->collection = $this->db->users;
  }

  function getPassword($login){

      $result = $this->collection->findOne(array('user' => $login), array('password'));
      return $result["password"];
  }

}
