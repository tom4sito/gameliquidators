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
		.aproval-btn, .edit-btn{
			cursor: pointer;
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
			echo 		"<div class='products-container report-show content-hidden' report-id='{$row['id']}' report-status='{$row['status']}'>";
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
		</div>
	</div>
</div>

</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/all.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/datepicker-es.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>

<script type="text/javascript">
var lastOpenReport = "";
$('.show-report-btn').on('click', function(e){

	$(lastOpenReport).empty();
	$(lastOpenReport).toggleClass('content-hidden');
	var currentReportContent = $(this).parent().parent().siblings().closest('.products-container');
	console.log(currentReportContent);
	$report_id = currentReportContent.attr('report-id');
	$report_status = currentReportContent.attr('report-status');
	// console.log($report_status);
	currentReportContent.toggleClass('content-hidden');
	lastOpenReport = currentReportContent;

	// console.log(currentReportContent.attr('report-id'));
	getReportInfo($report_id , $report_status, currentReportContent);
});

$(document).on('click', '.aproval-btn', function(e){
	var reportid = $(this).attr('prod-id');
	var singleReport = $(this);

	// console.log(reportid);
	approveReport(reportid, singleReport);
});

function getReportInfo(report_id, report_status ,returned_obj){
	$.ajax({
		url: "reportinfo2.php",
		method:"POST",
		// method:"GET",
		// data: "reportid=" + report_id,
		data: {'reportid': report_id, 'reportstatus': report_status},
		dataType:"text",
		success:function(data){
			// console.log(data);
			console.log("ajax successful");
			$(returned_obj).append(data);
		}
	});
}

function approveReport(report_id, reportToAprov){
	var reportid = {"reportid": report_id};
	// console.log(reportToAprov);
	$.ajax({
		url: "approvereport.php",
		method:"POST",
		data: {'data': reportid},
		dataType:"text",
		success:function(data){
			console.log(data);
			console.log("ajax successful: approved report...");
			console.log(reportToAprov);
			$(reportToAprov).remove();
		}
	});
}


</script>
</body>
</html>