<?php
session_start();
require_once("objects/user.php");
require_once("objects/textSchedule.php");

if(!isset($_SESSION["zalogowany"])){
	header('Location: login.php');
}

$entryDb = new textSchedule();

if(!isset($_GET["date"])){
	$date = $dateToday = date("Y-m-d");
}else{
	$date = $_GET["date"];
}

$entries = $entryDb->getEntriesByDate($date);

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
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Lista<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="list.php">Mediów</a></li>
							<li><a href="listText.php">Tekstów</a></li>
						</ul>
				</li>
				<li class="dropdown active">
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

	<center>
		<form method="get" action"schedule.php">
			<input type="date" name="date" value=<?=$date?> />
			<input type="submit" value="Pokaż" />
		</form>
	</center>

	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Tekst</th>
	      <th scope="col">Czas startu</th>
	      <th scope="col">Czas zakończenia</th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php
	    $i=1;
	    foreach($entries as $document) {
	      $text = $document["text"];
				$start = $document["start"];
	      $end = $document["end"];
	        echo "<tr>
	              <th scope='row'>$i</th>
	              <td>$text</td>
	              <td>$start</td>
	              <td>$end</td>
	            </tr> ";
	            $i++;
	    }
	    ?>
	  </tbody>
	</table>

</body>

</html>
