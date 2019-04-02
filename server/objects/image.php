<?php
require $_SERVER["DOCUMENT_ROOT"] . '/tablica/vendor/autoload.php'; // include Composer's autoloader

class Image{
  //connection
  private $connection;
  private $db;
  private $collection;

  //fields
  private $name;
  private $start;
  private $end;

  function __construct() {
    $this->connection = new MongoDB\Client("mongodb://localhost:27017");
    $this->db = $this->connection->tablica_informacyjna;
    $this->collection = $this->db->images;
  }

  function saveImageToDb($name,$start,$end){
    $document = array( "name" => $name, "start" => $start,"end" => $end );
    $this->collection->insertOne($document);
  }

  function getAllImages(){
      $result = $this->collection->find();
      return $result;
  }

}
