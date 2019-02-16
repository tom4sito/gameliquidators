<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>ver reportes de ventas</title>
	<!-- <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> -->
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/all.min.css">	

	<style type="text/css">
		#reports_container{
			margin-left: 20px;
		}

		.content-hidden{
			display: none;
		}

		.content-show{
			display: block;
		}

	</style>
</head>
<body>
<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

if(isset($_GET['reportid'])){
	$reportid = $_GET['reportid'];

	// $sql = 
}
else{
	echo "something went wrong";
}

function renderReportRows($connection, $numOfRows){
	$sql = "SELECT * FROM sale_report ORDER by created_at DESC LIMIT $numOfRows";

	$result = mysqli_query($connection, $sql);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)) {
			echo "<div class='row report-body report-row'>";
			echo 	"<div class='col-12'>";
			echo    	"<div class='row'>";
			echo			"<div class='col-md-6'>";
			echo 				"<span class='show-report-btn'>".$row['created_at']."</span>";
			echo 			"</div>";
			echo			"<div class='col-md-6'>";
			echo 				$row['status'];
			echo 			"</div>";
			echo 		"</div>";
			echo 	"</div>";
			echo 	"<div class='row report-content content-hidden' report-id='{$row['id']}'>";
			echo 	"</div>";
			echo "</div>";
		}
	} 
	else {
		echo "0 results";
	}
}

?>


<div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/navbar.php'; ?>
<h1>Editar Reporte de Ventas</h1>

<div class="main">
	<div class="c">
		<div class="row product-row">
			<div class="col-4 col-sm-4 col-md-4 col-lg-4">
				<img src="https://www.fifauteam.com/wp-content/uploads/2013/08/A276-151.jpg" width="135" height="180">
			</div>
			<div class="col-8 col-sm-8 col-md-8 col-lg-8">
				<h4>XBOX 360: FIFA 13</h4>
				<p>cantidad: <input type="number" name="qty"></p>
				<p>precio: <input type="text" name="price"></p>
				<select name='condition[]'>
					<option value='nuevo'>nuevo</option>
					<option value='usado'>usado</option>
				</select>
			</div>
			
		</div>
	</div>

</div>

</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/all.min.js"></script>
<!-- <script type="text/javascript" src="/gameliquidators/js/datepicker-es.js"></script> -->

</body>
</html>