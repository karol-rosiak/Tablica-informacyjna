<?php
session_start();
require_once("objects/user.php");
require_once("objects/scheduleEntry.php");
require_once("objects/file.php");
if(!isset($_SESSION["zalogowany"])){
	header('Location: login.php');
}

$entryDb = new scheduleEntry();

if(isset($_POST["delete"])){
	$error = "";
	$entry = $entryDb->getById($_POST["delete"]);

	if($entry["type"] == "image" || $entry["type"] == "video" || $entry["type"] == "html"){
		$file = new File();
		if($file->fileExists($entry["name"])){
			if($file->deleteFile($entry["name"])){
					if(!$entryDb->deleteEntry($_POST["delete"])){
						$error = "Błąd poczas próby usunięcia wpisu z bazy danych";
					}
			}else{
				$error = "Błąd podczas próby usunięcia pliku z dysku";
			}
		}else{
			$error = "Błąd. Plik nie istnieje";
			$entryDb->deleteEntry($_POST["delete"]);
		}
	}else{
		if(!$entryDb->deleteEntry($_POST["delete"])){
			$error = "Błąd poczas próby usunięcia wpisu z bazy danych";
		}
	}
}

$entries = $entryDb->getAllEntries();
?>

<html lang="pl" >
<head>
  <meta charset="UTF-8">
  <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
  <link rel="stylesheet" href="css/login.css">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


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
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dodaj<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="upload.php">Media</a></li>
							<li><a href="addText.php">Tekst</a></li>
						</ul>
				</li>
				<li class="dropdown active">
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
	if(isset($_POST["delete"])){
		if(!empty($error)){
			echo "<div class='alert alert-danger' role='alert'> $error </div>";
		}
		else{
			echo "<div class='alert alert-success' role='alert'> Usunięto pomyślnie! </div>";
		}
	}
	 ?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nazwa</th>
			<th scope="col">Typ</th>
      <th scope="col">Czas startu</th>
      <th scope="col">Czas zakończenia</th>
			<th scope="col">Czas wyświetlania</th>
			<th scope="col">Usuń</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i=1;
    foreach($entries as $document) {
      $name = $document["name"];
			$type = $document["type"];
			$start = $document["start"];
      $end = $document["end"];
			$duration = $document["duration"];
			$id = $document["_id"];
        echo "<tr>
              <th scope='row'>$i</th>
              <td>$name</td>
							<td>$type</td>
              <td>$start</td>
              <td>$end</td>
							<td>$duration</td>
							<td>
							<form action='list.php' method='post'>
								<button type='submit' name='delete' class='close' aria-label='Close' value='$id'>
  								<span aria-hidden='true'>&times;</span>
								</button>
							</form>
							</td>
						</tr> ";
            $i++;
    }
    ?>
  </tbody>
</table>

</body>

</html>
