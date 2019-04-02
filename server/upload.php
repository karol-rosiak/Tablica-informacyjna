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
 <div class="input-group mb-2 mr-sm-2 mb-sm-2" style="margin-left:10px;">
	<form action="upload_file.php" method="post" enctype="multipart/form-data">
	    <p class="h6">Wybierz plik do uploadu</p>
	    	<input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload"></br>
			<p class="h6">Data startu</p>
				<input type="date" class="form-control" name="start"></br></br>
			<p class="h6">Data zakończenia</p>
				<input type="date" class="form-control" name="end"></br></br>

	    <input type="submit" value="Zapisz obraz" name="submit">
	</form>
</div>



</body>

</html>
