<?php
include "objects/image.php";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {


    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "Plik nie jest obrazem";
        $uploadOk = 0;
    }
}

if(isset($_POST["start"]) && isset($_POST["end"])){
  $dateStart = new DateTime($_POST["start"]);
  $dateEnd = new DateTime($_POST["end"]);
  if($dateEnd < $dateStart){
    $error = "Data zakończenia jest starsza od daty startu";
  }
}

// Check if file already exists
if (file_exists($target_file)) {
    $error = "Plik już istnieje";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "Plik jest za duży";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "png" ) {
    $error = "Zły format pliku";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $imageDb = new Image();
    $imageDb->saveImageToDb($_FILES["fileToUpload"]["name"],$_POST["start"],$_POST["end"]);
  } else {
    $error =  "Błąd podczas uploadowania pliku";
  }
// if everything is ok, try to upload file
}
?>

<?php
session_start();
require_once("objects/user.php");
if(!isset($_SESSION["zalogowany"])){
	header('Location: login.php');
}

?>
<html lang="pl" >
<head>
  <meta charset="UTF-8">
  <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Tablica informacyjna</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="index.php">Home </a></li>
        <li class="active"><a href="upload.php">Dodaj<span class="sr-only">(current)</span></a></li>
				<li><a href="list.php">Lista</a></li>
				<li><a href="schedule.php">Harmonogram</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Wyloguj</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php if(!empty($error)){
	echo "<div class='alert alert-danger' role='alert'> $error </div>";
  echo "<a href='upload.php'> Powrót do uploadu</a>";
  die();
}
?>

<div class='alert alert-success' role='alert'> Plik został dodany pomyślnie! </div>

<a href="upload.php"> Powrót do uploadu</a>

</body>

</html>
