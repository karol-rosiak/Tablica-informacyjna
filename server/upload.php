<?php
session_start();
require_once("objects/user.php");
require_once("objects/file.php");
require_once("objects/scheduleEntry.php");

if(!isset($_SESSION["zalogowany"])){
	header('Location: login.php');
}

if(isset($_POST["submit"])) {
	$entry = new ScheduleEntry();
	$error = null;
	if(!$entry->checkDate()){
		$error = "Data zakończenia jest wcześniejsza od daty startu";
	}else{
		if(!empty($_FILES["fileToUpload"]["tmp_name"])){
			$file = new File();
			if($file->saveFile()){
					if(!$entry->saveEnteryToDb($file->getName(),$_POST["type"],$_POST["duration"], $_POST["start"],$_POST["end"])){
					 $error = "Bład podczas dodawania do harmonogramu";
				 }
			}
			else{
				$error = $file->getError();
			}
		}
		else{
				if(!empty($_POST["link"]))$name = $_POST["link"];
				if(!empty($_POST["webcam"]))$name = $_POST["webcam"];
			 if(!$entry->saveEnteryToDb($name,$_POST["type"],$_POST["duration"], $_POST["start"],$_POST["end"])){
				$error = "Bład podczas dodawania do harmonogramu";
			 }
		}
	}
}
?>

<html lang="pl" >
<head>
  <meta charset="UTF-8">
  <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
  <link rel="stylesheet" href="css/login.css">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script>

		function showAndHide() {
		  var x = document.getElementById("dataType");
			var selected = x.options[x.selectedIndex].value;

			var files = document.getElementById("file");
			var urls = document.getElementById("link");
			var webcams = document.getElementById("webcam");

			if(selected === "image" || selected == "video" || selected === "html"){
				files.style.display = "block";
				urls.style.display = "none";
				webcams.style.display = "none";
			}

			if(selected == "link"){
				files.style.display = "none";
				urls.style.display = "block";
				webcams.style.display = "none";
			}

			if(selected == "webcam"){
				files.style.display = "none";
				urls.style.display = "none";
				webcams.style.display = "block";
			}
}
	</script>
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

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li>
				<li class="dropdown active">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dodaj<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="upload.php">Media</a></li>
							<li><a href="addText.php">Tekst</a></li>
						</ul>
				</li>
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Lista<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="list.php">Mediów</a></li>
							<li><a href="listText.php">Tekstów</a></li>
						</ul>
				</li>
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Harmonogram<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="schedule.php">Mediów</a></li>
							<li><a href="scheduleText.php">Tekstów</a></li>
						</ul>
				</li>
				<li><a href="weather.php" >Pogoda</a></li>
				<li><a href="current.php">Podgląd</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
	</nav>

<?php
if(isset($_POST["submit"])){
	if(!empty($error)){
		echo "<div class='alert alert-danger' role='alert'> $error </div>";
	}
	else{
		echo "<div class='alert alert-success' role='alert'> Dodano do harmonogramu! </div>";
	}
}
 ?>
 <div class="input-group mb-2 mr-sm-2 mb-sm-2" style="margin-left:10px;">
	<form action="upload.php" method="post" enctype="multipart/form-data">

		<div id="file">
		  <p class="h6">Wybierz plik do uploadu</p>
	    	<input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" /></br>
		</div>

		<div id="link" style="display:none;">
			<p class="h6">Podaj link do strony</p>
					<input type="text" class="form-control" name="link" id=linkBox" /></br></br>
		</div>

		<div id="webcam" style="display:none;">
			<p class="h6">Podaj nazwę kamery</p>
				<input type="text" class="form-control" name="webcam" id="webcamBox" /></br></br>
		</div>

			<p class="h6">Typ danych</p>
				<select name = "type" id="dataType" class="form-control" onchange="showAndHide()">
					<option value="image" selected>Obraz</option>
					<option value="video">Wideo</option>
					<option value="html">Plik html</option>
					<option value="link">Link do strony</option>
					<option value="webcam">Obraz z kamery</option>
				</select>
			</br></br>
			<p class="h6">Data startu</p>
				<input type="date" class="form-control" name="start"></br></br>
			<p class="h6">Data zakończenia</p>
				<input type="date" class="form-control" name="end"></br></br>
			<p class="h6">Czas wyświetlania</p>
				<input type="number" class="form-control" name="duration"></br></br>
	    <input type="submit" value="Zapisz" name="submit">
	</form>
</div>

</body>

</html>
