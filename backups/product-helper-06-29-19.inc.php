<?php
function renderSeach($db, $platform, $productType, $limit){
	$result = searchBase($db, $platform, $productType, $limit);
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

			$tag_sql = "SELECT tag_name FROM tag t1 
			INNER JOIN product_tag t2 
			ON t1.tag_id = t2.tag_id 
			AND t2.product_id = {$value['id']}";

			$tag_result = mysqli_query($db, $tag_sql);
			if(mysqli_num_rows($tag_result) > 0){
				$tag_row = mysqli_fetch_assoc($tag_result);
				$productTag = $tag_row['tag_name'];
			}
			else{
				$productTag = "generico";
			}

			$product_html .= "<div class='product-thumb'>";
			// $product_html .= 	"<div class='product-thumb-body'>";
			// $product_html .=    	"<div class=''>";
			$product_html .=			"<div class='product-thumb-img-wrapper'>";
			$product_html .=				"<a href='show/?id={$value['id']}'>";
			$product_html .=					"<img class='product-thumb-img' src='{$productImg}'>";
			$product_html .=				"</a>";
			$product_html .=			"</div>";
			$product_html .=			"<div class='product-thumb-content'>";
			$product_html .=				"<a href='show/?id={$value['id']}'>";
			$product_html .=					"<div class='product-thumb-title'>{$value['title']}</div>";
			$product_html .=				"</a>";
			$product_html .=				"<div class='product-thumb-platform'>{$value['platform']} | {$productTag}</div>";
			$product_html .=				"<div class='product-thumb-price'>Usado: <span class='bold-text'> \${$value['price_used']}</span></div>";
			$product_html .=				"<div class='product-thumb-price'>Nuevo: <span class='bold-text'>  \${$value['price_new']}</span></div>";
			$product_html .=				"<div class='product-thumb-studio'>";
			// $product_html .=					"<span class='thumb-product-stock'>Fabricante: </span> ";
			$product_html .=					"Fabricante: <span class='bold-text'> {$value['studio']}</span>";
			$product_html .=				"</div>";
			$product_html .=			"</div>";
			// $product_html .=    	"</div>";
			// $product_html .= 	"</div>";
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

// returns html for product type filter
function renderProductTypeFilter($db, $platform, $productType, $column){
	$productTypeHtml = "";
	$result = searchBaseForFilter($db, $platform, $productType, $column);
	$productType = array();

	if(mysqli_num_rows($result) > 0){
		foreach ($result as $value) {
			// echo $key . ": ". $value['platform'] . "<br>";
			if (array_key_exists($value['product_type'], $productType)){
				$productType[$value['product_type']] += 1;
			}
			else{
				$productType[$value['product_type']] = 1;
			}
		}

		foreach ($productType as $key => $value) {
			$productTypeHtml .= "<div>";
			$productTypeHtml .= 	"<input type='checkbox' name='producttype|{$key}' value='{$value}' class='producttype-filter grab-filter' filter-name='{$key}'>";
			$productTypeHtml .= 	"<span> {$key} ({$value})</span>";
			$productTypeHtml .= "</div>";
		}

		return $productTypeHtml;
	}
}

// returns integer with quantity of products according to their condition
function renderConditionFilter($db, $platform, $productType, $column){
	$conditionHtml = "";
	$result = searchBaseForFilter($db, $platform, $productType, $column);
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
		$conditionHtml .= 	"<input type='checkbox' name='condition|{$conditionState}' filter-name='{$conditionState}' class='condition-filter grab-filter'>";
		$conditionHtml .=	"<span> {$conditionState} ({$condition})</span>";
		$conditionHtml .= "</div>";
	}
	return $conditionHtml;
}

// returns an array with all products prices
function getPriceArrForFilter($db, $platform, $productType, $priceType){
	$result = searchBaseForFilter($db, $platform, $productType, $priceType);
	$temp_array  = array();

	if(mysqli_num_rows($result) > 0){
		foreach($result as $value){
			array_push($temp_array, $value[$priceType]);
		}
	}
	return $temp_array;
}

function renderPriceFilter($db, $platform, $productType){
	$rangeHtml = "";
	$prevRange = 0;
	$currentRange = 0;

	$priceRangeArr = array();
	$fullPriceArr = getPriceArrForFilter($db, $platform, $productType, "price_new");
	if(count($fullPriceArr) > 0){
		$fullPriceArr = array_merge($fullPriceArr, getPriceArrForFilter($db, $platform, $productType, "price_used"));
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
				$rangeHtml .= 	"<input type='checkbox' name='pricerange|{$prevRange}|{$range}' value='{$range}' class='pricerange-filter grab-filter' filter-name='{$prevRange}-{$range}'>";
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

function renderStudioFilter($db, $platform, $productType, $column){
	$productStudioHtml = "";
	$result = searchBaseForFilter($db, $platform, $productType, $column);
	$productStudio = array();

	if(mysqli_num_rows($result) > 0){
		foreach ($result as $value) {
			// echo $key . ": ". $value['platform'] . "<br>";
			if (array_key_exists($value['studio'], $productStudio)){
				$productStudio[$value['studio']] += 1;
			}
			else{
				$productStudio[$value['studio']] = 1;
			}
		}

		foreach ($productStudio as $key => $value) {
			$productStudioHtml .= "<div>";
			$productStudioHtml .= 	"<input type='checkbox' name='studio|{$key}' value='{$value}' class='studio-filter grab-filter' filter-name='{$key}'>";
			$productStudioHtml .= 	"<span> {$key} ({$value})</span>";
			$productStudioHtml .= "</div>";
		}

		return $productStudioHtml;
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

function searchBase($db, $platform, $productType, $limit){
	$sql = "SELECT * FROM products WHERE platform = '{$platform}' AND product_type = '{$productType}' LIMIT {$limit} OFFSET 0";
	return mysqli_query($db, $sql);
}

function searchBaseForFilter($db, $platform, $productType, $column){
	$sql = "SELECT {$column} FROM products WHERE platform = '{$platform}' AND product_type = '{$productType}'";
	return mysqli_query($db, $sql);
}

function searchBaseGetProdCount($db, $platform, $productType, $column){
	$sql = "SELECT count({$column}) FROM products WHERE platform = '{$platform}' AND product_type = '{$productType}' ";
	$fetchCount =  mysqli_fetch_assoc(mysqli_query($db, $sql));
	return $fetchCount["count(id)"];
}

function genPagination($totalProducts, $prodsPerPage, $initialNextOffset){
	$numOfPages = ceil($totalProducts/$prodsPerPage);
	$selected = "";

	$paginationHtml = "";
	$paginationHtml .= "<a class='pagination-previous' href='#'><span>&laquo; Previo &nbsp;</span></a>";
	$paginationHtml .= "<div class='pagination-pages'>";
	for ($i = 1; $i <= $numOfPages; $i++ ){
		if((($i - 1) * $prodsPerPage) == 0){
			$selected = "selected-page";
		}
		$paginationHtml .= "<a href='#' class='selectpage {$selected}' pageoffset='" . ($i - 1) * $prodsPerPage . "'> " . $i . " </a>";
		$selected = "";
	}
	$paginationHtml .= "</div>";
	$paginationHtml .= "<a class='pagination-next selectpage' href='#' pageoffset='{$initialNextOffset}'><span> &nbsp; Siguiente &raquo;</span></a>";
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

// echo renderSeach($conn, "ps4", "Videojuego", PRODUCTS_PER_PAGE);

?>