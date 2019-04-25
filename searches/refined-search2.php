<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$json_str = file_get_contents('php://input'); //gets json data from POST AJAX
$decoded_data = json_decode($json_str, true);

$basic = $decoded_data['basic'];
$extra = $decoded_data['extra'];
$newBaseQuery = $basic . "~" . $extra;

// create SQL SELECT query ----------------------
$sql = "SELECT * FROM products WHERE ";

$basicArr = explode("~", $basic);
$extraArr = explode("|", $extra);

foreach ($basicArr as $value) {
	$filterArr = explode("|", $value);

	if(strpos($filterArr[0], 'basic!') !== false){
		if(strpos($sql, 'AND') !== false){
			$sql .= "AND title LIKE '{$filterArr[1]}%' ";
		}
		else{
			$sql .= "title LIKE '{$filterArr[1]}%' ";
		}

	}
	if(strpos($filterArr[0], 'platform') !== false){
		if(strpos($sql, 'AND') !== false){
			$sql .= "AND title LIKE '{$filterArr[1]}%' ";
		}
		else{
			$sql .= "title LIKE '{$filterArr[1]}%' ";
		}
		
	}
}

if($extraArr[0] == 'platform'){
	$sql .= "AND platform = '{$extraArr[1]}' ";
}
if($extraArr[0] == 'pricerange'){
	$sql .= "AND (price_new BETWEEN {$extraArr[1]} AND {$extraArr[2]} ";
	$sql .= "OR price_used BETWEEN {$extraArr[1]} AND {$extraArr[2]}) ";
}
// end of SQL QUERY creation --------------------------

$completeList["filters"] = $sql;
$returnedHtml = json_encode($completeList);
echo $returnedHtml;

// renderSeach($conn, $sql, $newBaseQuery);
// mysqli_close($conn);

// function renderSeach($db, $query, $baseQuery){
// 	$result = mysqli_query($db, $query);
// 	if(mysqli_num_rows($result) > 0){
// 		$completeList["products"] = array();
// 		$completeList["filters"] = $baseQuery;

// 		foreach ($result as $key => $value) {
// 			// echo $value['platform'].": ".$value['title'] . " <br>";
// 			$isAvailable = "";
// 			$productImg = "";
// 			$urlImg = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/';

// 			if($value['quantity_new'] > 0 or $value['quantity_used'] > 0){
// 				$isAvailable = "disponible";
// 			}
// 			else{
// 				$isAvailable = "agotado";
// 			}
// 			// query to fetch product image
// 			$img_sql = "SELECT image_name FROM images_table
// 						WHERE product_id = {$value['id']}
// 						AND image_name LIKE '%_thumb1%' ";

// 			$img_result = mysqli_query($db, $img_sql);
// 			if(mysqli_num_rows($img_result) > 0){
// 				$img_row = mysqli_fetch_assoc($img_result);
// 				$productImg = $urlImg . $img_row['image_name'];
// 			}
// 			else{
// 				$productImg = $urlImg . "unavailable_thumb.jpg";
// 			}

// 			// array with all product info
// 			$tempProductArr = array("image"=>$productImg, 
// 				"title"=>"{$value['title']}", 
// 				"platform"=>"{$value['platform']}", 
// 				"price_new"=>"{$value['price_new']}",
// 				"price_used"=>"{$value['price_used']}",
// 				"is_available"=>$isAvailable,
// 				"studio"=>"{$value['studio']}");

// 			// pushes single product array into full products list array
// 			$completeList["products"][] = $tempProductArr;

// 		}
// 		$returnedHtml = json_encode($completeList);
// 		echo $returnedHtml;
// 	}
// 	else{
// 		$completeList["products"][] = "no result or error";
// 		$returnedHtml = json_encode($completeList);
// 		echo $returnedHtml;
// 	}
// }	

?>