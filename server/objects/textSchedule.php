<?php
require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php'; // include Composer's autoloader

class TextSchedule{
  //connection
  private $connection;
  private $db;
  private $collection;

  //fields
  private $text;
  private $start;
  private $end;

  function __construct() {
    $this->connection = new MongoDB\Client("mongodb://localhost:27017");
    $this->db = $this->connection->tablica_informacyjna;
    $this->collection = $this->db->textSchedule;
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

  function saveEnteryToDb($text,$start,$end){
    $document = array( "text" => $text,"start" => $start,"end" => $end );
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

  function getEntriesByDate($date){
      $rangeQuery = array('start' => array( '$lte' => $date),'end' => array( '$gte' => $date));
      $result = $this->collection->find($rangeQuery);
      return $result;
  }

}
