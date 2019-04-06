<?php
include "objects/scheduleEntry.php";

class File{
  //$_FILES and $_POST are super globals so they dont need to be passed as paramters
  private $target_dir = "uploads/";
  private $target_file;
  private $target_file_name;
  private $uploadOk = 1;
  private $error = "";
  private $fileType;

  private $imageType = array("jpg","jpeg","png","gif","bmp");
  private $videoType = array("wmv","mp4","flv");
  private $htmlType = array("html","xhtml");

  function __construct(){
	$this->target_file = $this->target_dir . basename($_FILES["fileToUpload"]["name"]);
	$this->target_file_name = basename($_FILES["fileToUpload"]["name"]);
	$this->fileType = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
  }

  private function checkFileExtension(){
    switch($_POST["type"]){
      case "image":
        if(in_array($this->fileType,$this->imageType)) return true;
        else $this->uploadOk = 0;
      break;
      case "video":
        if(in_array($this->fileType,$this->videoType)) return true;
        else $uploadOk = 0;
      break;
      case "html":
        if(in_array($this->fileType,$this->htmlType)) return true;
          else $this->uploadOk = 0;
      break;
      default:
          $this->uploadOk = 0;
      break;
    }
    if($this->uploadOk == 0){
      $this->error = "Zły format pliku";
    }
  }

  private function checkIfExists(){
    if (file_exists($this->target_file)) {
        $this->error = "Plik już istnieje";
        $this->uploadOk = 0;
    }
  }

  function saveFile(){
    $this->checkFileExtension();
    $this->checkIfExists();

    if ($this->uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->target_file)) {
          return true;
      } else {
        $this->error =  "Błąd podczas uploadowania pliku";
        return false;
      }
  }
  else{
    return false;
  }
 }

  function getName(){
    return $this->target_file_name;
  }

  function getError(){
    return $this->error;
  }

}
