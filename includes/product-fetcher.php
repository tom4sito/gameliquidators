<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$json_str = file_get_contents('php://input'); //gets json data from POST AJAX
$decoded_data = json_decode($json_str, true);

// create SQL SELECT query ----------------------
$sql = "SELECT * FROM products WHERE ";
$sql_count = "SELECT count(id) FROM products WHERE ";
$slq_filter = "";

$sql .= "platform = '{$decoded_data['queries']['basic']}' AND product_type = 'videojuego' ";
$sql_count .= "platform = '{$decoded_data['queries']['basic']}' AND product_type = 'videojuego'";

// if(count($decoded_data['queries']['platform']) > 0){
// 	foreach ($decoded_data['queries']['platform'] as $key => $value) {
// 		if($key == 0){
// 			$sql .= "AND (platform = '{$value}' ";
// 			$sql_count .= "AND (platform = '{$value}' ";
// 		}
// 		else{
// 			$sql .= "OR platform = '{$value}' ";
// 			$sql_count .= "OR platform = '{$value}' ";
// 		}
// 	}
// 	$sql .= ") ";
// 	$sql_count .= ") ";
// }

if(count($decoded_data['queries']['pricerange']) > 0){
	foreach ($decoded_data['queries']['pricerange'] as $key => $value) {
		if($key == 0){
			$sql .= "AND ((price_new BETWEEN {$value[0]} AND {$value[1]} ";
			$sql .= "OR price_used BETWEEN {$value[0]} AND {$value[1]}) ";

			$sql_count .= "AND ((price_new BETWEEN {$value[0]} AND {$value[1]} ";
			$sql_count .= "OR price_used BETWEEN {$value[0]} AND {$value[1]}) ";
		}
		else{
			$sql .= "OR (price_new BETWEEN {$value[0]} AND {$value[1]} ";
			$sql .= "OR price_used BETWEEN {$value[0]} AND {$value[1]}) ";

			$sql_count .= "OR (price_new BETWEEN {$value[0]} AND {$value[1]} ";
			$sql_count .= "OR price_used BETWEEN {$value[0]} AND {$value[1]}) ";
		}
	}
	$sql .= ") ";
	$sql_count .= ") ";
}
if(count($decoded_data['queries']['condition']) > 0){
	foreach ($decoded_data['queries']['condition'] as $condition_value) {
		if(strpos($condition_value, "new") !== false){
			$sql .= "AND quantity_new > 0 ";
			$sql_count .= "AND quantity_new > 0 ";
		}
		if(strpos($condition_value, "used") !== false){
			$sql .= "AND quantity_used > 0 ";
			$sql_count .= "AND quantity_used > 0 ";
		}
	}
}
if(count($decoded_data['queries']['studio']) > 0){
	foreach ($decoded_data['queries']['studio'] as $key => $studio_value) {
		if($key == 0){
			$sql .= "AND (studio = '{$studio_value}' ";
			$sql_count .= "AND (studio = '{$studio_value}'";
		}
		else{
			$sql .= "OR studio = '{$studio_value}' ";
			$sql_count .= "OR studio = '{$studio_value}'";
		}
	}
	$sql .= ") ";
	$sql_count .= ") ";
}
$slq_filter = $sql;

if(isset($decoded_data["sort_by"]) and !empty($decoded_data["sort_by"])){
	$sql .= "ORDER BY {$decoded_data["sort_by"]} {$decoded_data["asc_desc"]} ";
}
$sql .= "LIMIT {$decoded_data["products_per_page"]} OFFSET {$decoded_data["pagination_offset"]}";

// end of SQL QUERY creation --------------------------

// $completeList["filters"] = $sql;
// $returnedHtml = json_encode($completeList);
// echo $returnedHtml;

renderSeach($conn, $sql, $slq_filter, $decoded_data);
mysqli_close($conn);

function renderSeach($db, $query, $query2, $decoded_data){
	$result = mysqli_query($db, $query);
	$result_filters = mysqli_query($db, $query2);

	$platform_count = array();
	$new_count = array();
	$used_count = array();
	$price_new_count = array();
	$price_used_count = array();

	if(mysqli_num_rows($result_filters) > 0){
		foreach ($result_filters as $value) {
			$platform_count[] = $value['platform'];
			$new_count[] = $value['quantity_new'];
			$used_count[] = $value['quantity_used'];
			$price_new_count[] = $value['price_new'];
			$price_used_count[] = $value['price_used'];
			$studio[] = $value['studio'];
		}
	}

	if(mysqli_num_rows($result) > 0){
		$completeList["products"] = array();
		// $completeList["filters"] = $baseQuery;

		foreach ($result as $key => $value) {
			// echo $value['platform'].": ".$value['title'] . " <br>";
			$isAvailable = "";
			$productImg = "";
			$urlImg = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/';

			if($value['quantity_new'] > 0 or $value['quantity_used'] > 0){
				$isAvailable = "disponible";
			}
			else{
				$isAvailable = "agotado";
			}
			// query to fetch product image
			$img_sql = "SELECT image_name FROM images_table
						WHERE product_id = {$value['id']}
						AND image_name LIKE '%_thumb1%' ";

			$img_result = mysqli_query($db, $img_sql);
			if(mysqli_num_rows($img_result) > 0){
				$img_row = mysqli_fetch_assoc($img_result);
				$productImg = $urlImg . $img_row['image_name'];
			}
			else{
				$productImg = $urlImg . "unavailable_thumb.jpg";
			}

			// array with all product info
			$tempProductArr = array("image"=>$productImg,
				"id"=>"{$value['id']}", 
				"title"=>"{$value['title']}", 
				"platform"=>"{$value['platform']}", 
				"price_new"=>"{$value['price_new']}",
				"price_used"=>"{$value['price_used']}",
				"is_available"=>$isAvailable,
				"studio"=>"{$value['studio']}",
				"qty_new"=>"{$value['quantity_new']}",
				"qty_used"=>"{$value['quantity_used']}"
			);

			// pushes single product array into full products list array
			$completeList["products"][] = $tempProductArr;

		}
		// $completeList["num_of_products"] = $num_of_products["count(id)"];
		$completeList["num_of_products"] = count($platform_count);
		$completeList["platform_count"] = $platform_count;
		$completeList["new_count"] = $new_count;
		$completeList["used_count"] = $used_count;
		$completeList["price_new_count"] = $price_new_count;
		$completeList["price_used_count"] = $price_used_count;
		$completeList["studio"] = $studio;
		$completeList["next_page"] = intval($decoded_data["pagination_offset"]) + intval($decoded_data["products_per_page"]);
		$completeList["prev_page"] = intval($decoded_data["pagination_offset"]) - intval($decoded_data["products_per_page"]);
		$completeList["current_page"] = intval($decoded_data["pagination_offset"]);

		$returnedHtml = json_encode($completeList);
		echo $returnedHtml;
	}
	else{
		// $completeList["products"][] = "no result or error";
		// $returnedHtml = json_encode($completeList);
		echo json_encode("{}");
	}
}	

?>