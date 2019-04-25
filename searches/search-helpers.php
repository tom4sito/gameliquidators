<?php
function renderSeach($db, $searchStr, $column){
	$result = searchBase($db, $searchStr, $column);
	if(mysqli_num_rows($result) > 0){
		$product_html = "";
		foreach ($result as $key => $value) {

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
		return $product_html;
	}
	else{
		return "no result or error";
	}
}	

function renderPlatformFilter($db, $searchStr, $column){
	$platformHtml = "";
	$result = searchBaseForFilter($db, $searchStr, $column);
	$platform = array();

	if(mysqli_num_rows($result) > 0){
		foreach ($result as $value) {
			// echo $key . ": ". $value['platform'] . "<br>";
			if (array_key_exists($value['platform'], $platform)){
				$platform[$value['platform']] += 1;
			}
			else{
				$platform[$value['platform']] = 1;
			}
		}

		foreach ($platform as $key => $value) {
			$platformHtml .= "<div>";
			$platformHtml .= 	"<input type='checkbox' name='platform|{$key}' value='{$value}' class='platform-filter grab-filter' filter-name='{$key}'>";
			$platformHtml .= 	"<span> {$key} ({$value})</span>";
			$platformHtml .= "</div>";
		}

		return $platformHtml;
	}
}

// returns integer with quantity of products according to their condition
function renderConditionFilter($db, $searchStr, $column){
	$conditionHtml = "";
	$result = searchBaseForFilter($db, $searchStr, $column);
	$condition = 0;
	$conditionState = "";

	if($column == "quantity_used"){
		$conditionState = "used";
	}
	else{
		$conditionState = "new";
	}

	if(mysqli_num_rows($result) > 0){
		foreach ($result as $value) {
			if($value[$column] > 0){
				$condition += 1;
			}
		}
		$conditionHtml .= "<div>";
		$conditionHtml .= 	"<input type='checkbox' name='condition|{$conditionState}' filter-name='{$conditionState}' class='platform-filter grab-filter'>";
		$conditionHtml .=	"<span> {$conditionState} ({$condition})";
		$conditionHtml .= "</div>";
	}
	return $conditionHtml;
}

// returns an array with all products prices
function getPriceArrForFilter($db, $searchStr, $column){
	$result = searchBaseForFilter($db, $searchStr, $column);
	$temp_array  = array();

	if(mysqli_num_rows($result) > 0){
		foreach($result as $value){
			array_push($temp_array, $value[$column]);
		}
	}
	return $temp_array;
}

function renderPriceFilter($db, $searchStr){
	$rangeHtml = "";
	$prevRange = 0;
	$currentRange = 0;

	$priceRangeArr = array();
	$fullPriceArr = getPriceArrForFilter($db, $searchStr, "price_new");
	if(count($fullPriceArr) > 0){
		$fullPriceArr = array_merge($fullPriceArr, getPriceArrForFilter($db, $searchStr, "price_used"));
		sort($fullPriceArr);

		$rangeMin = $fullPriceArr[0];
		$rangeMax = $fullPriceArr[sizeof($fullPriceArr) - 1]; 
		
		$ranges = createRangeForPrice($rangeMin, $rangeMax);

		foreach($ranges as $range){

			$priceCounter = 0;
			foreach ($fullPriceArr as $productPrice) {
				if(($productPrice > $prevRange) and ($productPrice <= $range)){
					$priceCounter += 1;
				}			
			}
			if($priceCounter > 0){
				// $rangeHtml .= "<div>{$prevRange} - {$range} ({$priceCounter})</div>";
				$rangeHtml .= "<div>";
				$rangeHtml .= 	"<input type='checkbox' name='pricerange|{$prevRange}|{$range}' value='{$range}' class='platform-filter grab-filter' filter-name='{$prevRange}-{$range}'>";
				$rangeHtml .= 	"<span> \${$prevRange} - \${$range} ({$priceCounter})</span>";
				$rangeHtml .= "</div>";

			}
			$prevRange = $range;
		}
		echo $rangeHtml;
	}
	else{
		echo "";
	}
}

// returns an array with price ranges
function createRangeForPrice($min, $max){
	$rangeArr = array();
	$diff = $max - $min;

	if($diff <= 100){
		$minFloored = floor($min / 10) * 10;
		$maxCeiled = ceil($max / 10) * 10;
		$pointer = $minFloored;
		array_push($rangeArr, 0);
		While((floor(($pointer / 10) * 10)) <= $maxCeiled){
			array_push($rangeArr, intval(floor(($pointer / 10) * 10)));
			$pointer += 10;
		}
	}
	elseif(($diff > 100 ) and ($diff <= 250)){
		$minFloored = floor($min / 100) * 100;
		$maxCeiled = ceil($max / 100) * 100;
		$pointer = $minFloored;
		array_push($rangeArr, 0);
		While($pointer < $maxCeiled){
			array_push($rangeArr, intval($pointer));
			$pointer += 50;
		}
	}
	elseif($diff > 250 ){
		$minFloored = floor($min / 100) * 100;
		$maxCeiled = ceil($max / 100) * 100;
		$pointer = $minFloored;
		array_push($rangeArr, 0);
		While((floor(($pointer / 100) * 100)) <= $maxCeiled){
			array_push($rangeArr, intval(floor(($pointer / 100) * 100)));
			$pointer += 100;
		}
	}

	return $rangeArr;
}

function searchBase($db, $searchStr, $column){
	$searchInput = $searchStr;
	$searchParams = array('ps3'=>'PS3', 'playstation 3'=>'PS3', 
					'ps4'=>'PS4', 'playstation 4'=>'PS4',
					'xbox 360'=>'XBOX 360', 'xbox one'=>'XBOX ONE',
					'xbox 1'=>'XBOX ONE', 'nintendo switch' => 'Nintendo Switch');

	foreach ($searchParams as $key => $value) {
		if(strpos($searchInput, $key) !== false){
			$searchInput = trim(str_replace($key, "", $searchInput));
			$sql = "SELECT {$column} FROM products 
			WHERE platform = '$value'
			AND title LIKE '{$searchInput}%' 
			LIMIT 10 OFFSET 0";
		}
	}

	if(!isset($sql)){
		$sql = "SELECT * FROM products WHERE title LIKE '{$searchInput}%' LIMIT 10 OFFSET 0";
	}	

	return mysqli_query($db, $sql);
}

function searchBaseForFilter($db, $searchStr, $column){
	$searchInput = $searchStr;
	$searchParams = array('ps3'=>'PS3', 'playstation 3'=>'PS3', 
					'ps4'=>'PS4', 'playstation 4'=>'PS4',
					'xbox 360'=>'XBOX 360', 'xbox one'=>'XBOX ONE',
					'xbox 1'=>'XBOX ONE', 'nintendo switch' => 'Nintendo Switch');

	foreach ($searchParams as $key => $value) {
		if(strpos($searchInput, $key) !== false){
			$searchInput = trim(str_replace($key, "", $searchInput));
			$sql = "SELECT {$column} FROM products 
			WHERE platform = '$value'
			AND title LIKE '{$searchInput}%' ";
		}
	}

	if(!isset($sql)){
		$sql = "SELECT * FROM products WHERE title LIKE '{$searchInput}%'";
	}	

	return mysqli_query($db, $sql);
}

function searchBaseGetProdCount($db, $searchStr, $column){
	$searchInput = $searchStr;
	$searchParams = array('ps3'=>'PS3', 'playstation 3'=>'PS3', 
					'ps4'=>'PS4', 'playstation 4'=>'PS4',
					'xbox 360'=>'XBOX 360', 'xbox one'=>'XBOX ONE',
					'xbox 1'=>'XBOX ONE', 'nintendo switch' => 'Nintendo Switch');

	foreach ($searchParams as $key => $value) {
		if(strpos($searchInput, $key) !== false){
			$searchInput = trim(str_replace($key, "", $searchInput));
			$sql = "SELECT count({$column}) FROM products 
			WHERE platform = '$value'
			AND title LIKE '{$searchInput}%' ";
		}
	}

	if(!isset($sql)){
		$sql = "SELECT count({$column}) FROM products WHERE title LIKE '{$searchInput}%' ";
	}	

	$fetchCount =  mysqli_fetch_assoc(mysqli_query($db, $sql));
	return $fetchCount["count(id)"];
}

function genPagination($totalProducts, $prodsPerPage){
	$numOfPages = ceil($totalProducts/$prodsPerPage);
	$paginationHtml = "";
	$paginationHtml .= "<a class='pagination-previous' href='#'><span>&laquo; Previo &nbsp;</span></a>";
	$paginationHtml .= "<div class='pagination-pages'>";
	for ($i = 1; $i <= $numOfPages; $i++ ){
		$paginationHtml .= "<a href='#' class='selectpage' pageoffset='" . ($i - 1) * 2 . "'> " . $i . " </a>";
	}
	$paginationHtml .= "</div>";
	$paginationHtml .= "<a class='pagination-next selectpage' href='#' pageoffset='2'><span> &nbsp; Siguiente &raquo;</span></a>";
	return $paginationHtml;
}


function ifGetVarIsSet($postInput){
	$returnedHtml = "";
	if(isset($postInput) && !empty($postInput)){
		$returnedHtml = $postInput;
	}
	else{
		$returnedHtml = "not-set";
	}
	return $returnedHtml;
}

?>