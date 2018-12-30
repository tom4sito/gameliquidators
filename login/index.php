<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';

if(isset($_POST['login'])){
	if(isset(($_POST['username'])) && !empty($_POST['username'])){
		$username = $_POST['username'];
	}
	if(isset(($_POST['pass'])) && !empty($_POST['pass'])){
		$pass = $_POST['pass'];
	}

	$sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$pass' ";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		// var_dump($result);
		$row = mysqli_fetch_assoc($result);
		$_SESSION['userid'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['usertype'] = $row['usertype'];
	}
	else{
		echo "0 results";
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>main page</title>
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<style type="text/css"></style>
</head>
<body>
<div>
<?php include($includes_dir."navbar.php"); ?>
<form action="" method="post">
	<label>usuario</label>
	<input type="text" name="username">

	<label>password</label>
	<input type="password" name="pass">

	<input type="submit" name="login" value="ingresar">
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<script type="text/javascript">
</script>
</body>
</html>