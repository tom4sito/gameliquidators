<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../includes/db_connect.php';

function renderPlatformFilter($db, $searchStr, $column){
	$platformHtml = "";
	$result = searchBase($db, $searchStr, $column);
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
			$platformHtml .= 	"<input type='checkbox' name='platform-{$key}' value='{$value}' class='platform-filter'>";
			$platformHtml .= 	"<span> {$key} ({$value})</span>";
			$platformHtml .= "</div>";
		}

		return $platformHtml;
	}
}

// returns integer with quantity of prodducts according to gheir condition
function renderConditionFilter($db, $searchStr, $column){
	$conditionHtml = "";
	$result = searchBase($db, $searchStr, $column);
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
		$conditionHtml .= 	"<input type='checkbox' name='condition-filter' value='30'>";
		$conditionHtml .=	"<span> {$conditionState} ({$condition})";
		$conditionHtml .= "</div>";
	}
	return $conditionHtml;
}

// returns an array with all products prices
function getPriceArrForFilter($db, $searchStr, $column){
	$result = searchBase($db, $searchStr, $column);
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
	$fullPriceArr = array_merge($fullPriceArr, getPriceArrForFilter($db, $searchStr, "price_used"));
	sort($fullPriceArr);

	$rangeMin = $fullPriceArr[0];
	$rangeMax = $fullPriceArr[sizeof($fullPriceArr) - 1]; 
	
	$ranges = createRangeForPrice($rangeMin, $rangeMax);

	// var_dump($fullPriceArr);
	// echo "<br>";
	// var_dump($ranges);

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
			$rangeHtml .= 	"<input type='checkbox' name='pricerange-30-40' value='{$range}'>";
			$rangeHtml .= 	"<span> \${$prevRange} - \${$range} ({$priceCounter})</span>";
			$rangeHtml .= "</div>";

		}
		$prevRange = $range;
	}
	echo $rangeHtml;
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
			AND title LIKE '{$searchInput}%' ";
		}
	}

	if(!isset($sql)){
		$sql = "SELECT * FROM products WHERE title LIKE '{$searchInput}%' ";
	}	

	return mysqli_query($db, $sql);
}


function renderSeach($db, $searchStr, $column){
	$result = searchBase($db, $searchStr, $column);
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
			// echo $productImg."<br>";

			$product_html .= "<div class='col-lg-3 col-md-4 col-sm-6 col-12 product-thumb'>";
			$product_html .= 	"<div class='product-thumb-body'>";
			$product_html .=    	"<div class='row'>";
			$product_html .=			"<div class='col-lg-12 col-md-12 col-sm-12 col-5'>";
			$product_html .=				"<img class='product-thumb-img' src='{$productImg}'>";
			// $product_html .=				"images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg'>";
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Basic Search</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<style type="text/css">
		/* Formatting search box */
		.search-box{
		    width: 300px;
		    position: relative;
		    display: inline-block;
		    font-size: 14px;
		    margin-right: 2px !important;
		}
		.search-box input[type="text"]{
		    height: 32px;
		    padding: 5px 10px;
		    border: 1px solid #CCCCCC;
		    font-size: 14px;
		}
		.result{
		    position: absolute;        
		    z-index: 1;
		    /*top: 100%;*/
		    /*left: 0;*/
		    background-color: #fff;
		}
		.search-box input[type="text"], .result{
		    width: 100%;
		    box-sizing: border-box;
		}
		/* Formatting result items */
		.result p{
		    margin: 0;
		    padding: 7px 10px;
		    border: 1px solid #CCCCCC;
		    border-top: none;
		    cursor: pointer;
		    width: 300px;
		    height: 80px;
		}
		.result p:hover{
		    background: #f2f2f2;
		}
		.img-float{
			float: left;
		}
		.no-wrap{
			display: block;
		}

		/*-----------thumbnails*/
		.product-thumb{
			margin-bottom: 10px;
		}

		.product-thumb-body{
			/*background-color: #ccc;*/
/*			width: 240px;
			height: 300px;*/
			height: 300px;
			width: 205px;
			/*border-style: solid;*/
			border-width: 1px;
			/*box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);*/
			cursor: pointer;
		}
		.product-thumb-body:hover{
			/*background-color: #ccc;*/
/*			width: 240px;
			height: 300px;*/
			height: 300px;
			width: 205px;
			/*border-style: solid;*/
			border-radius: 5px;
			border-width: 1px;
			box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 20px 0 rgba(0, 0, 0, 0.19);
		}
		.product-thumb-img{
			/*height: 160px;*/
			/*width: 125px;*/
			/*height: 60%;*/
			width: 140px;
			margin: auto;
			display: block;
		}
		.product-thumb-title{
			/*text-align: center;*/
			font-size: 12px;
			font-weight: bold;
		}

		@media screen and (max-width: 576px) {
			.product-thumb-body{
				/*background-color: #ccc;*/
	/*			width: 240px;
				height: 300px;*/
				height: 200px;
				width: 400px;
				/*border-style: solid;*/
				border-width: 1px;
				/*box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);*/
				cursor: pointer;
			}
			.product-thumb-body:hover{
				/*background-color: #ccc;*/
	/*			width: 240px;
				height: 300px;*/
				height: 200px;
				width: 400px;
				/*border-style: solid;*/
				border-radius: 5px;
				border-width: 1px;
				box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 20px 0 rgba(0, 0, 0, 0.19);
			}
			.product-thumb-img{
				/*height: 160px;*/
				/*width: 125px;*/
				/*height: 60%;*/
				width: 140px;
				margin-left: 5px;
				margin-right: 5px;
				display: block;
			}
		}
	</style>
</head>
<body>
<div>
<?php include '../includes/navbar.php'; ?>
</div>
<div class="main-container">

<div class="container-fluid">
	<div class="row all-products-row">
		<div class="col-lg-2 col-md-2 filters-col">
			<form action="" method="get">
				<div class="filter-category">
					<div class="filter-category-title">
						<h6>Platform</h6>
					</div>
					<?php echo renderPlatformFilter($conn, $_POST['basic-search-inp'], "platform"); ?>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-price">
						<h6>Price</h6>
					</div>
					<?php echo renderPriceFilter($conn, $_POST['basic-search-inp']); ?>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h6>Condition</h6>
					</div>
					<?php 
						echo renderConditionFilter($conn, $_POST['basic-search-inp'], "quantity_new");
						echo renderConditionFilter($conn, $_POST['basic-search-inp'], "quantity_used");
					?>
				</div>
			</form>
		</div>
		<div class="col-lg-10 col-md-10 products-thumbs-col">
			<div class="row basic-seach-cont" search-term="<?php echo $_POST['basic-search-inp'] ?>" >
				<?php 
					if(isset($_POST['basic-search-inp'])){
						// include '../includes/db_connect.php'; 
						renderSeach($conn, $_POST['basic-search-inp'], "*");
						// renderFilters($conn, $_POST['basic-search-inp']);
						// var_dump(renderPlatformFilter($conn, $_POST['basic-search-inp'], "platform"));
						// echo renderConditionFilter($conn, $_POST['basic-search-inp'], "quantity_new");
						echo "<br>";
						// echo renderConditionFilter($conn, $_POST['basic-search-inp'], "quantity_used");

					}
				?>
			</div>
		</div>
	</div>
</div>





</div>

<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript">
	var selectedFilter = $('.platform-filter').on('change', function(){
		console.log( $( this ).val() );
		$( ".basic-seach-cont" ).empty();
	});
</script>
</body>
</html>