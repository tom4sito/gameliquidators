<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// if(isset($_POST['basic-search-inp'])){
	// include '../includes/db_connect.php'; 
	// $searchInput = $_POST['basic-search-inp'];
	// $searchParams = array('ps3'=>'PS3', 'playstation 3'=>'PS3', 
	// 				'ps4'=>'PS4', 'playstation 4'=>'PS4',
	// 				'xbox 360'=>'XBOX 360', 'xbox one'=>'XBOX ONE',
	// 				'xbox 1'=>'XBOX ONE', 'nintendo switch' => 'Nintendo Switch');

	// foreach ($searchParams as $key => $value) {
	// 	if(strpos($searchInput, $key) !== false){
	// 		$searchInput = trim(str_replace($key, "", $searchInput));
	// 		$sql = "SELECT * FROM products 
	// 		WHERE platform = '$value'
	// 		AND title LIKE '{$searchInput}%' ";
	// 	}
	// }

	// if(!isset($sql)){
	// 	$sql = "SELECT * FROM products WHERE title LIKE '{$searchInput}%' ";
	// }	

	// echo $sql."<br>";
	// $result = mysqli_query($conn, $sql);
	// if(mysqli_num_rows($result) > 0){
	// 	foreach ($result as $key => $value) {
	// 		echo $value['platform'].": ".$value['title'] . " <br>";
	// 	}
	// }
	// else{
	// 	echo "no result or error";
	// }
// }

function renderSeach($db, $searchStr){
	$searchInput = $searchStr;
	$searchParams = array('ps3'=>'PS3', 'playstation 3'=>'PS3', 
					'ps4'=>'PS4', 'playstation 4'=>'PS4',
					'xbox 360'=>'XBOX 360', 'xbox one'=>'XBOX ONE',
					'xbox 1'=>'XBOX ONE', 'nintendo switch' => 'Nintendo Switch');

	foreach ($searchParams as $key => $value) {
		if(strpos($searchInput, $key) !== false){
			$searchInput = trim(str_replace($key, "", $searchInput));
			$sql = "SELECT * FROM products 
			WHERE platform = '$value'
			AND title LIKE '{$searchInput}%' ";
		}
	}

	if(!isset($sql)){
		$sql = "SELECT * FROM products WHERE title LIKE '{$searchInput}%' ";
	}	

	// echo $sql."<br>";
	$result = mysqli_query($db, $sql);
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
						WHERE product_id = {$value['id']}";

			$img_result = mysqli_query($db, $img_sql);
			if(mysqli_num_rows($img_result) > 0){
				$img_row = mysqli_fetch_assoc($img_result);
				$productImg = $urlImg . $img_row['image_name'];
			}
			else{
				$productImg = $urlImg . "no_thumb.png";
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
					<div>
						<input type="checkbox" name="platform-ps4" value="ps4">
						<span>ps4</span>
					</div>
					<div>
						<input type="checkbox" name="platform-ps3" value="ps3">
						<span>ps3</span>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-title">
						<h6>Estudio</h6>
					</div>
					<div>
						<input type="checkbox" name="platform-ps4" value="ps4">
						<span>Konami</span>
					</div>
					<div>
						<input type="checkbox" name="platform-ps3" value="ps3">
						<span>Activision</span>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-10 col-md-10 products-thumbs-col">
			<div class="row">
				<?php 
					if(isset($_POST['basic-search-inp'])){
						include '../includes/db_connect.php'; 
						renderSeach($conn, $_POST['basic-search-inp']);
					}
				?>
			</div>
		</div>
	</div>
</div>




<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
<!-- <div class="container-fluid">
	<div class="row product-row">
		<div class="col-lg-2 col-md-2">
			<form action="" method="get">
				<div class="filter-category">
					<div class="filter-category-title">
						<h6>Platform</h6>
					</div>
					<div>
						<input type="checkbox" name="platform-ps4" value="ps4">
						<span>ps4</span>
					</div>
					<div>
						<input type="checkbox" name="platform-ps3" value="ps3">
						<span>ps3</span>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-title">
						<h6>Estudio</h6>
					</div>
					<div>
						<input type="checkbox" name="platform-ps4" value="ps4">
						<span>Konami</span>
					</div>
					<div>
						<input type="checkbox" name="platform-ps3" value="ps3">
						<span>Activision</span>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-10 col-md-10">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									<span class="thumb-product-stock">disponible</span>
									|
									<span class="thumb-product-studio">Konami</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									disponible
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									disponible
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									disponible
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									disponible
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 product-thumb">
					<div class="product-thumb-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<img class="product-thumb-img" src="https://images-na.ssl-images-amazon.com/images/I/915dUNOufyL._AC_SX430_.jpg">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-5">
								<div class="product-thumb-title">
									Resident evil 2
								</div>
								<div>plataforma: <span>PS4</span></div>
								<div class="product-thumb-title">
									$35.000
								</div>
								<div>
									disponible
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

	</div>
</div> -->

</div>

<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript"></script>
</body>
</html>