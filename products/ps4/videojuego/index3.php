<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';
require $includes_dir.'product-helpers-3.php';

define("PRODUCTS_PER_PAGE", 4);
define("INITIAL_NEXT_OFFSET", 4);
define("PRODUCT_PLATFORM", "ps4");
define("PRODUCT_TYPE", "Videojuego");

// if(isset($_SESSION['username'])){
//     echo "session started username: ".$_SESSION['username'];
// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Playstation 4</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/fontawesome59/css/all.min.css">
	<style type="text/css">
		/* main container */
		.main-container{
			max-width: 1360px;
			padding: 20px;
			margin-left: auto;
			margin-right: auto;
		}
	</style>
</head>
<body>
<div>
<?php include($includes_dir."navbar2.php"); ?>
</div>
<div class="main-container">
	<div class="sort-bar">
		Ordenar Por: 
		<select name="sort-criteria" id="sort-criteria">
			<option value="" selected disabled hidden>Escoge Criterio de Orden</option>
			<option value="title-lth">Titulo: A-Z</option>
			<option value="title-htl">Titulo: Z-A</option>
			<option value="year-lth">Año: Menor a Mayor</option>
			<option value="year-htl">Año: Mayor a Menor </option>
			<option value="price-new-lth">Precio Nuevo: Menor a Mayor</option>
			<option value="price-new-htl">Precio Nuevo: Mayor a Menor</option>
			<option value="price-used-lth">Precio Usado: Menor a Mayor</option>
			<option value="price-used-htl">Precio Usado: Mayor a Menor</option>
		</select>
	</div>
	<div id="filter-tag-bar" ></div>
	<div class="filters-on-off hide-filter-btn"><span>Ver Filtros <i class="fas fa-sliders-h"></i></span></div>
	<div class="all-products-row">
		<div class="filters-col filter-display-off">
			<div id="data-store" basic-query=""></div>
			<form action="" method="get">
				<div class="filter-category">
					<div class="filter-category-price">
						<h5>Precio</h5>
					</div>
					<div class="filter-container" id="priceFilterContainer">
						<?php echo renderPriceFilter($conn, PRODUCT_PLATFORM, PRODUCT_TYPE); ?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h5>Condicion</h5>
					</div>
					<div class="filter-container" id="conditionFilterContainer">
						<?php
						echo renderConditionFilter($conn, PRODUCT_PLATFORM, PRODUCT_TYPE, "quantity_new");
						echo renderConditionFilter($conn, PRODUCT_PLATFORM, PRODUCT_TYPE, "quantity_used");
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-studio">
						<h5>Fabricante</h5>
					</div>
					<div class="filter-container" id="studioFilterContainer">
						<?php echo renderStudioFilter($conn, PRODUCT_PLATFORM, PRODUCT_TYPE, "studio"); ?>
					</div>
				</div>
			</form>
		</div>
		<div class="products-thumbs-col">
			<div class="basic-search-cont" search-term="" >
				<?php 
					echo renderSeach($conn, PRODUCT_PLATFORM, PRODUCT_TYPE, PRODUCTS_PER_PAGE);
					echo "<br>";
				?>
			</div>
			<div class="pagination" id="paginationid">
				<?php
					$numOfProducts = searchBaseGetProdCount($conn, PRODUCT_PLATFORM, PRODUCT_TYPE, "id");
					echo genPagination($numOfProducts, PRODUCTS_PER_PAGE, INITIAL_NEXT_OFFSET); 
				?>
			</div>
		</div>
	</div>

<?php mysqli_close($conn); ?>
</div>

<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/fontawesome.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript" src="/gameliquidators/js/filters.js"></script>
</body>
</html>


