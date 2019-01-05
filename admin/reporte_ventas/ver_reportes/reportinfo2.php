<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';

require $db_connect;

$reportId = $_GET["reportid"];

$sql = "SELECT * FROM product_in_report WHERE report_id = '$reportId' ";

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
	// echo "<div class='col-md-12'>";
	$total = 0;
	echo "<div class='row product-row'>";
	echo 	"<div class='col-md-3 col-lg-3'>producto</div>";
	echo 	"<div class='col-md-3 col-lg-3'>precio</div>";
	echo 	"<div class='col-md-2 col-lg-2'>condicion</div>";
	echo 	"<div class='col-md-2 col-lg-2'>cantidad</div>";
	echo 	"<div class='col-md-2 col-lg-2'>subtotal</div>";
	echo "</div>";
	while($row = mysqli_fetch_assoc($result)) {
		$prod_sql = "SELECT `title`, `platform` FROM products WHERE id = '{$row['product_id']}' ";
		$product_result = mysqli_query($conn, $prod_sql);

		$sql_image = "SELECT image_name 
		FROM images_table 
		WHERE product_id = '{$row['product_id']}' ";

		$result_img = mysqli_query($conn, $sql_image);

		$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/';

		if(mysqli_num_rows($result_img) > 0){
			$row_img = mysqli_fetch_assoc($result_img);
			$product_img = "<img src='$url{$row_img['image_name']}' width='57' height='71'>";
		}
		else{
			$product_img = "<img src='https://blog.springshare.com/wp-content/uploads/2010/02/nc-md.gif'  width='57' height='71'>";
		}

		if(mysqli_num_rows($product_result) > 0){
			$product_data = mysqli_fetch_assoc($product_result);
			$subtotal = intval($row["quantity"]) * intval($row["sale_price"]);
			$total += $subtotal;

			echo "<div class='row product-row'>";
			echo 	"<div class='col-md-3 col-lg-3 product-info'><p>".$product_data["title"]."</p>$product_img </div>";
			echo 	"<div class='col-md-3 col-lg-3 product-info'><p>".intval($row["sale_price"])."</p></div>";
			echo 	"<div class='col-md-2 col-lg-2 product-info'><p>".$row["product_condition"]."</p></div>";
			echo 	"<div class='col-md-2 col-lg-2 product-info'><p>".$row["quantity"]."</p></div>";
			echo 	"<div class='col-md-2 col-lg-2 product-info'><p>".$subtotal."</p></div>";
			echo "</div>";
		}
	}
	// echo "<div>";
	echo 	"<div class='row total-row'>";
	echo 		"<p>total: " .$total."</p>";
	echo 		"<p>";
	echo 			"<button id='approvalBtn' class='aproval-btn'>aprobar</button>";
	echo 			"<button id='approvalBtn' class='aproval-btn'>editar</button>";
	echo 		"</p>";
	echo 	"</div>";
	// echo "</div>";
}

// echo $reportId;
?>
