<?php
require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php'; // include Composer's autoloader

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
    $result = $this->collection->insertOne($document);
    if($result->getInsertedCount() > 0)
      return true;
    else
      return false;
  }

  function getEntriesByDate($date){
      $rangeQuery = array('start' => array( '$lte' => $date),'end' => array( '$gte' => $date));
      $result = $this->collection->find($rangeQuery);
      return $result;
  }

  function getById($id){
    $result = $this->collection->findOne((array('_id' => new MongoDB\BSON\ObjectId($id))));
    return $result;
  }

  function getAllEntries(){
    $result = $this->collection->find();
    return $result;
  }

  function deleteEntry($id){
    return $this->collection->deleteOne(array('_id' => new MongoDB\BSON\ObjectId($id)));
  }

}
