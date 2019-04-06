<?php
session_start();
require_once("objects/user.php");
require_once("objects/ScheduleEntry.php");

if(!isset($_SESSION["zalogowany"])){
	header('Location: login.php');
}

$entryDb = new scheduleEntry();
$entries = $entryDb->getAllEntries();

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
        <li><a href="upload.php">Dodaj</a></li>
				<li class="active"><a href="list.php">Lista<span class="sr-only">(current)</span></a></li>
				<li><a href="schedule.php">Harmonogram</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Wyloguj</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nazwa</th>
			<th scope="col">Typ</th>
      <th scope="col">Czas startu</th>
      <th scope="col">Czas zakończenia</th>
			<th scope="col">Czas wyświetlania</th>
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
        echo "<tr>
              <th scope='row'>$i</th>
              <td>$name</td>
							<td>$type</td>
              <td>$start</td>
              <td>$end</td>
							<td>$duration</td>
            </tr> ";
            $i++;
    }
    ?>
  </tbody>
</table>

</body>

</html>