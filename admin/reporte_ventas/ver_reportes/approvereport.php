<?php
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;
$reportId = $_POST['data']['reportid'];

$sqlProductsInReport = "SELECT product_id, product_condition, quantity 
FROM `product_in_report` 
WHERE report_id = {$reportId}";

$resultProducts = mysqli_query($conn, $sqlProductsInReport);

if(mysqli_num_rows($resultProducts) > 0){
	// echo "productos en el reporte fueron extraidos";
	$sql = "UPDATE sale_report 
	SET status='aprobado' 
	WHERE id={$reportId}";

	if (mysqli_query($conn, $sql)) {
	    // echo "el reporte ha sido aprobado";
	    while($row = $resultProducts->fetch_assoc()){
	    	// echo $row['product_id'].": ".$row['product_condition']."<br>";
	    	$productConditionQty = "";
	    	if($row['product_condition'] == "nuevo"){
	    		$productConditionQty = "quantity_new";
	    	}
	    	else{
	    		$productConditionQty = "quantity_used";
	    	}
	    	$sqlDecreaseProd = "UPDATE products
	    	SET $productConditionQty = $productConditionQty - {$row['quantity']} 
	    	WHERE id={$row['product_id']}";

	    	if (mysqli_query($conn, $sqlDecreaseProd)){
	    		echo "product {$row['product_id']} was decreased";
	    	}
	    	else{
	    		echo "product could not be taken out of inventory";
	    	}
	    }
	    // $sqlDecreaseProd = "";

	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}
}
else{
	echo "error al seleccionar productos del reporte";
}



mysqli_close($conn);
?>