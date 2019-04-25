<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;
$basic = $_POST['basic'];
$extra = $_POST['extra'];

$sql = "SELECT * FROM products WHERE ";

$basicArr = explode("~", $basic);
$extraArr = explode("-", $extra);

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
}

if($extraArr[0] == 'platform'){
	$sql .= "AND platform = '{$extraArr[1]}' ";
}
if($extraArr[0] == 'pricerange'){
	$sql .= "AND (price_new BETWEEN {$extraArr[1]} AND {$extraArr[2]} ";
	$sql .= "OR price_used BETWEEN {$extraArr[1]} AND {$extraArr[2]}) ";
}

// echo $sql;

renderSeach($conn, $sql);
mysqli_close($conn);


function renderSeach($db, $query){
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) > 0){
		$product_html = "";
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

			$product_html .= "<div class='col-lg-3 col-md-4 col-sm-6 col-12 product-thumb'>";
			$product_html .= 	"<div class='product-thumb-body'>";
			$product_html .=    	"<div class='row'>";
			$product_html .=			"<div class='col-lg-12 col-md-12 col-sm-12 col-5'>";
			$product_html .=				"<img class='product-thumb-img' src='{$productImg}'>";
			$product_html .=			"</div>";
			$product_html .=			"<div class='col-lg-12 col-md-12 col-sm-12 col-5'>";
			$product_html .=				"<div class='product-thumb-title'>{$value['title']}</div>";
			$product_html .=				"<div>plataforma: <span>{$value['platform']}</span></div>";
			$product_html .=				"<div class='product-thumb-price'>{$value['price_used']}</div>";
			$product_html .=				"<div class='product-thumb-price'>{$value['price_new']}</div>";
			$product_html .=				"<div>";
			$product_html .=					"<span class='thumb-product-stock'>{$isAvailable}</span> | ";
			$product_html .=					"<span class='thumb-product-studio'>{$value['studio']}</span>";
			$product_html .=				"</div>";
			$product_html .=			"</div>";
			$product_html .=    	"</div>";
			$product_html .= 	"</div>";
			$product_html .= "</div>";

		}
		echo $product_html;
	}
	else{
		echo "no result or error";
	}
}	

// echo $sql;

// $sql = "";

// echo $basic . " " . $extra;
?>