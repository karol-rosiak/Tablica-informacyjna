<?php
require $_SERVER["DOCUMENT_ROOT"] . '/tablica/vendor/autoload.php'; // include Composer's autoloader

class ScheduleEntry{
  //connection
  private $connection;
  private $db;
  private $collection;

  //fields
  private $name;
  private $type;
  private $duration;
  private $start;
  private $end;

  function __construct() {
    $this->connection = new MongoDB\Client("mongodb://localhost:27017");
    $this->db = $this->connection->tablica_informacyjna;
    $this->collection = $this->db->schedule;
  }

  function checkDate(){
    if(isset($_POST["start"]) && isset($_POST["end"])){
      $dateStart = new DateTime($_POST["start"]);
      $dateEnd = new DateTime($_POST["end"]);
      if($dateEnd < $dateStart){
        return false;
      }
    }
    return true;
  }

  function saveEnteryToDb($name,$type,$duration, $start,$end){
    $document = array( "name" => $name,"type" => $type, "duration" => $duration, "start" => $start,"end" => $end );
    $this->collection->insertOne($document);
  }

  function getAllEntries(){
      $result = $this->collection->find();
      return $result;
  }

}
