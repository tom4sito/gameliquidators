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
			if (array_key_exists($value['platform'], $platform)){
				$platform[$value['platform']] += 1;
			}
			else{
				$platform[$value['platform']] = 1;
			}
		}

		foreach ($platform as $key => $value) {
			$platformHtml .= "<div>";
			$platformHtml .= 	"<input type='checkbox' name='platform-{$key}' value='{$value}' class='platform-filter grab-filter' filter-name='{$key}' filter-type='platform'>";
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
			$productTypeHtml .= 	"<input type='checkbox' name='producttype|{$key}' value='{$value}' class='producttype-filter grab-filter' filter-name='{$key}' filter-type='producttype'>";
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
		$conditionHtml .= 	"<input type='checkbox' name='condition-{$conditionState}' filter-name='{$conditionState}' class='condition-filter grab-filter' condition='{$conditionState}' filter-type='condition' qty='{$condition}'>";
		$conditionHtml .=	"<span> {$conditionState} ({$condition})</span>";
		$conditionHtml .= "</div>";
	}
	return $conditionHtml;
}
// START OF PRICE FILTER CODE -------------------------------------
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
		getRanges($fullPriceArr);
	}
	else{
		echo "";
	}
}
function getRanges($productPrices){
	$arr_zero_fiftho = array(); 
	$arr_fiftho_hundtho = array(); 
	$arr_hundtho_twohundtho = array(); 
	$arr_twohundtho_fivehundtho = array(); 
	$arr_fivehundtho_onemill = array(); 
	$arr_onemill_twomill = array(); 
	$arr_twomill_fivemill = array(); 
	$arr_fivemill_tenmill = array(); 
	foreach ($productPrices as $value) {
		if($value > 0 AND $value < 50000){
			$arr_zero_fiftho[] = $value;
		}
		elseif($value >= 50000 AND $value < 100000) {
			$arr_fiftho_hundtho[] = $value;
		}
		elseif ($value >= 100000 AND $value < 200000) {
			$arr_hundtho_twohundtho[] = $value;
		}
		elseif ($value >= 200000 AND $value < 500000) {
			$arr_twohundtho_fivehundtho[] = $value;
		}
		elseif ($value >= 500000 AND $value < 1000000) {
			$arr_fivehundtho_onemill[] = $value;
		}
		elseif ($value >= 1000000 AND $value < 2000000) {
			$arr_onemill_twomill[] = $value;
		}
		elseif ($value >= 2000000 AND $value < 5000000) {
			$arr_twomill_fivemill[] = $value;
		}
		elseif ($value >= 5000000 AND $value < 10000000) {
			$arr_fivemill_tenmill[] = $value;
		}
	}

	$priceFilterHtml = "";
	if(!empty($arr_zero_fiftho)){
		$allRanges = rangeMaker($arr_zero_fiftho, 0, 10000, 50000, 10000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_fiftho_hundtho)){
		$allRanges = rangeMaker($arr_fiftho_hundtho, 50000, 75000, 100000, 25000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_hundtho_twohundtho)){
		$allRanges = rangeMaker($arr_hundtho_twohundtho, 100000, 150000, 200000, 50000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_twohundtho_fivehundtho)){
		$allRanges = rangeMaker($arr_twohundtho_fivehundtho, 200000, 300000, 500000, 100000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_fivehundtho_onemill)){
		$allRanges = rangeMaker($arr_fivehundtho_onemill, 500000, 750000, 1000000, 250000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_onemill_twomill)){
		$allRanges = rangeMaker($arr_onemill_twomill, 1000000, 1250000, 2000000, 250000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_twomill_fivemill)){
		$allRanges = rangeMaker($arr_twomill_fivemill, 2000000, 3000000, 5000000, 1000000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_fivemill_tenmill)){
		$allRanges = rangeMaker($arr_fivemill_tenmill, 5000000, 7500000, 10000000, 2500000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	echo $priceFilterHtml;
}

function rangeMaker($rangeArray, $trackerStart, $rangeStart, $rangeEnd, $rangeIncrement){
	$mainRangeArr = array();
	for ($i= $rangeStart; $i <= $rangeEnd; $i += $rangeIncrement) {
		$subArray = array();
		$subArray["qty"] = 0;
		$subArray["start"] = $trackerStart;
		$subArray["end"] = $i; 
		foreach ($rangeArray as $value) {
			if($value >= $trackerStart AND $value < $i){
				$subArray["qty"] += 1;
			}
		}
		$trackerStart = $i;
		if($subArray["qty"] > 0){
			$mainRangeArr[] = $subArray;
		}
	}
	return $mainRangeArr;
}

function writeRangeCheckbox($rangeArr){
	$rangeHtml = "";
	foreach($rangeArr as $range){
		$rangeHtml .= "<div>";
		$rangeHtml .= 	"<input type='checkbox' name='pricerange-{$range["start"]}-{$range["end"]}' qty='{$range["qty"]}' class='pricerange-filter grab-filter' min='{$range["start"]}' max='{$range["end"]}' filter-type='price'>";
		$rangeHtml .= 	"<span> \${$range["start"]} - \${$range["end"]} ({$range["qty"]})</span>";
		$rangeHtml .= "</div>";
	}
	return $rangeHtml;
}
// END OF PRICE FILTER CODE -------------------------------------
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
			$productStudioHtml .= 	"<input type='checkbox' name='{$key}' value='{$value}' class='studio-filter grab-filter' filter-type='studio' qty='{$value}'>";
			$productStudioHtml .= 	"<span> {$key} ({$value})</span>";
			$productStudioHtml .= "</div>";
		}

		return $productStudioHtml;
	}
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