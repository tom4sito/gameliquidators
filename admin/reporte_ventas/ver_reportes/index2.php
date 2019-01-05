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
		.report-row{
			border-bottom-style: solid;
			border-bottom-color: #ccc;
			border-bottom-width: 1px;
		}

		.show-report-btn{
			cursor: pointer;
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

function renderReportRows2($connection, $numOfRows){
	$sql = "SELECT * FROM sale_report ORDER by created_at DESC LIMIT $numOfRows";

	$result = mysqli_query($connection, $sql);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)) {
			echo "<div class='row'>";
			echo 	"<div class='col-md-12 col-lg-12 report-row'>";
			echo    	"<div class='row fecha'>";
			echo			"<div class='col-6 col-sm-6 col-md-6 col-lg-6'>";
			echo 				"<span class='show-report-btn'>".$row['created_at']."</span>";
			echo 			"</div>";
			echo			"<div class='col-6 col-sm-6 col-md-6 col-lg-6'>";
			echo 				$row['status'];
			echo 			"</div>";
			echo 		"</div>";
			echo 		"<div class='products-container report-show content-hidden' report-id='{$row['id']}'>";
			echo 		"</div>";
			echo 	"</div>";
			echo "</div>";
		}
	} 
	else {
		echo "0 results";
	}
}

function rendeReportInfo($connection, $reportId){
	$reportInfoSql = "SELECT * ";
}

?>


<div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/navbar.php'; ?>
<h1>Ver Reportes de Ventas</h1>

<div class="main">
	<div class="reports-main-container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="row">
					<div class="col-md-6 col-lg-6">fecha</div>
					<div class="col-md-6 col-lg-6">estatus</div>
				</div>
			</div>
		</div>
		<div class="report-content">
			<?php renderReportRows2($conn, 5); ?>
<!-- 			<div class="row">
				<div class="col-md-12 col-lg-12 report-row">
					<div class="row fecha">
						<div class="col-md-6 col-lg-6">2018-05-12</div>
						<div class="col-md-6 col-lg-6">pendiente</div>
					</div>
					<div class="products-container report-show content-hidden">
						<div class="row product-row">
							<div class="col-md-3 col-lg-3">crash Bandicoot</div>
							<div class="col-md-3 col-lg-3">120000</div>
							<div class="col-md-3 col-lg-3">nuevo</div>
							<div class="col-md-3 col-lg-3">cantidad</div>
						</div>
						<div class="row product-row">
							<div class="col-md-3 col-lg-3">Spiderman</div>
							<div class="col-md-3 col-lg-3">150000</div>
							<div class="col-md-3 col-lg-3">nuevo</div>
							<div class="col-md-3 col-lg-3">cantidad</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12 report-row">
					<div class="row fecha">
						<div class="col-md-6 col-lg-6">2018-05-12</div>
						<div class="col-md-6 col-lg-6">pendiente</div>
					</div>
					<div class="products-container report-show content-hidden">
						<div class="row product-row">
							<div class="col-md-3 col-lg-3">crash Bandicoot</div>
							<div class="col-md-3 col-lg-3">120000</div>
							<div class="col-md-3 col-lg-3">nuevo</div>
							<div class="col-md-3 col-lg-3">cantidad</div>
						</div>
						<div class="row product-row">
							<div class="col-md-3 col-lg-3">Spiderman</div>
							<div class="col-md-3 col-lg-3">150000</div>
							<div class="col-md-3 col-lg-3">nuevo</div>
							<div class="col-md-3 col-lg-3">cantidad</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>

</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/all.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/datepicker-es.js"></script>

<script type="text/javascript">
var lastOpenReport = "";
$('.show-report-btn').on('click', function(e){

	$(lastOpenReport).empty();
	$(lastOpenReport).toggleClass('content-hidden');
	var currentReportContent = $(this).parent().parent().siblings().closest('.products-container');
	console.log(currentReportContent);
	$report_id = currentReportContent.attr('report-id');
	console.log(currentReportContent.toggleClass('content-hidden'));
	lastOpenReport = currentReportContent;

	// console.log(currentReportContent.attr('report-id'));
	getReportInfo($report_id , currentReportContent);
});

function getReportInfo(report_id, returned_obj){
	$.ajax({
		url: "reportinfo2.php",
		method:"GET",
		data: "reportid=" + report_id,
		dataType:"text",
		success:function(data){
			console.log(data);
			console.log("ajax successful");
			$(returned_obj).append(data);
		}
	});
}


</script>
</body>
</html>