<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] ."/objects/user.php");
if(!isset($_SESSION["zalogowany"])){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    if(isset($_POST["username"]) && isset($_POST["password"])){
					$db = new Database();
					$comparePassword = $db->getPassword($_POST["username"]);
					if(password_verify($_POST["password"],$comparePassword)){
						$_SESSION["zalogowany"] = $_POST["username"];
						header('Location: index.php');
					}else{
						$error="Niepoprawny login lub hasło";
					}
			}else{
				$error = "Nie podano wszystkich daych";
			}
	}
}
else{
	header('Location: index.php');
}

if(!empty($error)){
	echo "<div class='alert alert-danger' role='alert'> $error </div>";
}

?>

<html lang="pl" >
<head>
  <meta charset="UTF-8">
  <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="wrapper">
    <form class="form-signin" method="post" action="login.php">
      <h2 class="form-signin-heading">Logowanie</h2>
      <input type="text" class="form-control" name="username" placeholder="Login" required="" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="Hasło" required=""/>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
    </form>
  </div>
</body>

</html>
