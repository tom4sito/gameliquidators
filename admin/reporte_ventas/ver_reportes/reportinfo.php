<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';

require $db_connect;

$reportId = $_GET["reportid"];

$sql = "SELECT * FROM product_in_report WHERE report_id = '$reportId' ";

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
	// echo "<div class='col-md-12'>";
	while($row = mysqli_fetch_assoc($result)) {
		$prod_sql = "SELECT `title`, `platform` FROM products WHERE id = '{$row['product_id']}' ";
		$product_result = mysqli_query($conn, $prod_sql);
		if(mysqli_num_rows($product_result) > 0){
			$product_data = mysqli_fetch_assoc($product_result);
			echo "<div class='row'>";
			echo 	"<div class='col-md-6'>".$product_data["title"]."</div>";
			echo 	"<div class='col-md-4'>".$row["sale_price"]."</div>";
			echo 	"<div class='col-md-2'>".$row["product_condition"]."</div>";
			echo "</div>";
		}
	}
	// echo "</div>";
}

// echo $reportId;
?>