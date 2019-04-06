<?php
include "objects/filEntry.php";

class File{
  //$_FILES and $_POST are super globals so they dont need to be passed as paramters
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $target_file_name =  basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $error = "";
  $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  $imageType = array("jpg","jpeg","png","gif","bmp");
  $videoType = array("wmv","mp4","flv");
  $htmlType = array("html","xhtml");

  private function checkFileExtension(){
    switch($_POST["type"]){
      case "image":
        if(in_array($filetype,$imageType)) return true;
        else $uploadOk = 0;
      break;
      case "video":
        if(in_array($filetype,$videoType)) return true;
        else $uploadOk = 0;
      break;
      case "html":
        if(in_array($filetype,$htmlType)) return true;
          else $uploadOk = 0;
      break;
      default:
          $uploadOk = 0;
      break;
    }
    if($uploadOk == 0){
      $error = "Zły format pliku";
    }
  }

  private function checkIfExists(){
    if (file_exists($target_file)) {
        $error = "Plik już istnieje";
        $uploadOk = 0;
    }
  }

  function saveFile(){
    checkFileExtension();
    checkIfExists();

    if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          return true;
      } else {
        $error =  "Błąd podczas uploadowania pliku";
        return false;
      }
  }
  else{
    return false;
  }

  function getName(){
    return $this->$target_file_name;
  }

  function getError(){
    return $this->error;
  }

}
