<?php
require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php'; // include Composer's autoloader

class weatherApi{
  //connection
  private $connection;
  private $db;
  private $collection;

  //fields
  private $city;
  private $key;


  function __construct() {
    $this->connection = new MongoDB\Client("mongodb://localhost:27017");
    $this->db = $this->connection->tablica_informacyjna;
    $this->collection = $this->db->weatherApi;
  }

  function saveEnteryToDb($key,$city){
    $document = array( "key" => $key,"city" => $city);

    $this->collection->deleteMany(array(),array('safe' => true));
    $result = $this->collection->insertOne($document);
    if($result->getInsertedCount() > 0)
      return true;
    else
      return false;
  }

  function getAllEntries(){
    $result = $this->collection->find();
    return $result;
  }

}
