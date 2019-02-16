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
			// echo	"<div class='col-md-2'>";
			// echo 		$row['id'];
			// echo	"</div>";
			echo	"<div class='col-md-6'>";
			echo 		"<span class='show-report-btn'>".$row['created_at']."</span>";
			echo 	"</div>";
			echo	"<div class='col-md-6'>";
			echo 		$row['status'];
			echo 	"</div>";
			echo 	"<div class='report-content content-hidden' report-id='{$row['id']}'>";
			echo 	"</div>";
			echo "</div>";
		}
	} 
	else {
		echo "0 results";
	}
}

function renderReportInfo($connection){

}
?>


<div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/navbar.php'; ?>
<h1>Ver Reportes de Ventas</h1>

<div id="reports_container">
	<div class="row report-head report-row">
		<div class="col-md-2">
			ID
		</div>
		<div class="col-md-5">
			Fecha
		</div>
		<div class="col-md-5">
			Status
		</div>
	</div>

	<?php renderReportRows($conn, 5); ?>
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
	$(this).parent().siblings().closest('.report-content').toggleClass('content-hidden');
	lastOpenReport = $(this).parent().siblings().closest('.report-content');
	// console.log($(this).parent().siblings().closest('.report-content').attr('report-id'));
	getReportInfo($(this).parent().siblings().closest('.report-content').attr('report-id'), $(this).parent().siblings().closest('.report-content'));
});

function getReportInfo(report_id, returned_obj){
	$.ajax({
		url: "reportinfo.php",
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