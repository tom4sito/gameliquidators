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
	<!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"> -->
	<style type="text/css">
		/* main container */
		.main-container{
			max-width: 1360px;
			padding: 20px;
			margin-left: auto;
			margin-right: auto;
		}
		/* Formatting search box */
/*		.search-box{
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
		}*/
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
		/*----------sorting bar--------*/
		.sort-bar{
			margin: 10px 0px 30px 0px;
		}
		#sort-criteria {
		    border: #6c757d solid 1px;
		    background-color: #fff;
		    color: #545b62;
		}
		/*show hide filtes button*/
		.filters-on-off{
			margin-bottom: 30px;
		}
		.filters-on-off span {
		    cursor: pointer;
		}
		.filters-on-off span:hover{
			color: red;
		}
		.filters-on-off i {
		    /*width: 20px;*/
		    margin-left: 5px;
		}
		/*----filters-----------*/
		.filter-category h5 {
		    margin-bottom: 0px;
		    font-size: 16px;
		    color: #414141;
		    font-weight: 600;
		}
		.filter-container span {
		    font-size: 14px;
		    color: #4b4b4b;
		    font-weight: 100;
		    vertical-align: top;
		    padding-left:2px;
		}
		input.grab-filter {
		    -webkit-appearance: none;
		    background-color: #ddd;
		    border: 0.5px solid #9f9f9f;
		    /* box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05); */
		    padding: 8px;
		    border-radius: 3px;
		    display: inline-block;
		    position: relative;
		}
		input.grab-filter:active, input.grab-filter:checked:active{
			box-shadow: none;
			background-color: red;
		}
		input.grab-filter:checked {
			box-shadow: none;
			background-color: red;
			/*box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);*/
		}
		input.grab-filter:checked:after {
			content: '\2713';
			font-size: 12px;
			position: absolute;
			top: 0px;
			left: 2px;
			color: #FFF;
			border: none;
		}
		.filters-col {
		    margin-bottom: 40px;
		}

		/*-----------thumbnails*/
		.product-thumb{
			display: flex;
			flex-direction: column;
		    margin: 0px 10px 25px 10px;
			width: 210px;
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
		.product-thumb-img-wrapper a {
			color: #000;
			text-align: center;
		}
		.product-thumb-img-wrapper a:hover {
			text-decoration: none;
		}
		.product-thumb-img{
			width: 160px;
			margin: 0px auto 5px auto;
			display: block;
		}
		.product-thumb-content{
			/*text-align: center;*/
			padding: 5px 10px;
		}
		a{
			color: #000;
		}
		a:hover{
			text-decoration: none;
			color: red;
		}
		.product-thumb-title{
			font-size: 18px;
			font-weight: bold;
		}
		.product-thumb-platform{
		    font-size: 14px;
		}
		.product-thumb-platform span{
		    color: #0077EF;
		}
		.product-thumb-price{
		    font-size: 16px;
		}
		.product-thumb-price{
		    font-size: 14px;
		}
		.product-thumb-studio{
		    font-size: 14px;
		}
		#paginationid{
			padding-left: 100px;
			margin-bottom: 20px;
		}
		#paginationid a{
			color: #414141;
			font-size: 19px;
			font-weight: 600;
		}
		.pagination-pages a {
		    /*padding: 3px 1px 0px 3px;*/
		    border-radius: 3px;
		    height: 24px;
		    width: 22px;
		    display: inline-block;
		    text-align: center;
		    margin-left: 5px;
		}
		.selected-page{
			background-color: red;
			color: #fff !important;
		}
		.bold-text{
			font-weight: 600;
		}
		@media screen and (min-width: 768px){
			/*----hides filters button original min-width 577px -----*/
			.hide-filter-btn{
				display: none;
			}
			.display-off{
				display: block;
			}
		}
		@media screen and (max-width: 576px) {
			.form-control {
			    display: inline;/*fixes search bar block issue */
			}
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
			/*----displays filters button -----*/
			/*.hide-filter-btn{
				display: block;
			}
			.display-off{
				display: none;
			}*/
		}


/*		span{
			font-size: 14px;
		}*/

		/*----------------flexbox---------------------------------*/
		.all-products-row{
			display: flex;
			/*max-width: 1360px;*/
		}
		.products-thumbs-col{
			flex: 1;
		}
		.basic-search-cont{
			display: flex;
			flex-wrap: wrap;
			padding-left: 100px;
		}

		@media screen and (min-width: 1380px){
			.filters-col{
			}
			.products-thumbs-col{
				flex: 1;
			}
		}
		@media screen and (max-width: 1050px){
			.products-thumbs-col{
				flex: 1;
			}
		}
		@media screen and (max-width: 768px){
			.all-products-row{
				flex-direction: column;
			}
			.basic-search-cont {
			    padding-left: 0px;
			}
			.hide-filter-btn{
				display: block;
			    /*margin: 20px;*/
			}
			.display-off{
				display: none;
			}
		}
		@media screen and (max-width: 515px){
			.product-thumb {
			    flex-direction: inherit;
			    width: 360px;
    		    margin-left: 0px;
			}
			.product-thumb-img {
				width: 120px;
			}
			#paginationid {
			    padding-left: 0px;
			}
			.search-div {
				width: 280px;
			}
			.search-box {
				width: 230px !important;
			}
			.basic-search-btn {
			     border: none !important;
			     padding-right: 5px;
			}
			.filter-container span {
			    font-size: 16px;
			    font-weight: 400;
			}
		}



			.menu{
				display: grid;
				grid-template-columns: 150px auto;
			}
			.hideable-items{
				display: grid;
				grid-template-columns: 100px 100px 100px 100px auto;
			}
			.login-btn {
			    text-align: right;
			}
			.display-off{
				display: none;
			}

		@media screen and (max-width: 700px){
			.menu{
				grid-template-columns: auto;
			}
			.menu-item{
				grid-column: 1 / span 5; /* span value needs to change if item is added or removed to main menu */
			}
			/*------------------------------ slide-in and out ---------------------------------------*/
			.mobile-on{
				display: grid;
				grid-template-columns: auto;

				max-height: 700px;
				transition: max-height 1s;

				/*animation: slide-in 0.5s forwards;*/
				/*-webkit-animation: slide-in 0.5s forwards;*/
			}
			.mobile-off{
				/*display: none;*/
				display: grid;
				grid-template-columns: auto;

				max-height: 0px;
				transition: max-height 0.2s ease-out;
				overflow: hidden;

				/*animation: slide-out 0.5s forwards;*/
				/*-webkit-animation: slide-out 0.5s forwards;*/
			}
			@keyframes slide-in {
			    100% { transform: translateX(0%); }
			}

			@-webkit-keyframes slide-in {
			    100% { -webkit-transform: translateX(0%); }
			}
			    
			@keyframes slide-out {
			    0% { transform: translateX(0%); }
			    100% { transform: translateX(-120%); }
			}

			@-webkit-keyframes slide-out {
			    0% { -webkit-transform: translateX(0%); }
			    100% { -webkit-transform: translateX(-120%); }
			}

			.login-btn {
			    text-align: left;
			}
			.togg-icon-off::before {
				display: inline-block;
				float: right;
				font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0c9";
			}
			.togg-icon-on::before {
				display: inline-block;
				float: right;
				font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f00d";
			}
			.hideable-items{
				grid-column: 1 / span 5;
			}

			.submenu{
				background-color: #ccc;
				grid-area: 2 / 1 / 5 / 6; /* reorders the submenu for mobile third value needs to change if item is added to main menu */
				/*display: block;*/
			}

			/*---------------hamburger----------------------*/
			#nav-icon4 {
				float: right;
				width: 30px;
				height: 30px;
				position: relative;
				/*margin: 50px auto;*/
				-webkit-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				transform: rotate(0deg);
				-webkit-transition: .5s ease-in-out;
				-moz-transition: .5s ease-in-out;
				-o-transition: .5s ease-in-out;
				transition: .5s ease-in-out;
				cursor: pointer;
			}
			#nav-icon4 span {
				display: block;
				position: absolute;
				height: 3px;
				width: 100%;
				background: #000;
				border-radius: 9px;
				opacity: 1;
				left: 0;
				-webkit-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				transform: rotate(0deg);
				-webkit-transition: .25s ease-in-out;
				-moz-transition: .25s ease-in-out;
				-o-transition: .25s ease-in-out;
				transition: .25s ease-in-out;
			}
			#nav-icon4 {
			}

			#nav-icon4 span:nth-child(1) {
				top: 0px;
				-webkit-transform-origin: left center;
				-moz-transform-origin: left center;
				-o-transform-origin: left center;
				transform-origin: left center;
			}

			#nav-icon4 span:nth-child(2) {
				top: 8px;
				-webkit-transform-origin: left center;
				-moz-transform-origin: left center;
				-o-transform-origin: left center;
				transform-origin: left center;
			}

			#nav-icon4 span:nth-child(3) {
				top: 16px;
				-webkit-transform-origin: left center;
				-moz-transform-origin: left center;
				-o-transform-origin: left center;
				transform-origin: left center;
			}

			#nav-icon4.open span:nth-child(1) {
				-webkit-transform: rotate(45deg);
				-moz-transform: rotate(45deg);
				-o-transform: rotate(45deg);
				transform: rotate(45deg);
				top: -2px;
				left: 8px;
			}

			#nav-icon4.open span:nth-child(2) {
				width: 0%;
				opacity: 0;
			}

			#nav-icon4.open span:nth-child(3) {
				-webkit-transform: rotate(-45deg);
				-moz-transform: rotate(-45deg);
				-o-transform: rotate(-45deg);
				transform: rotate(-45deg);
				top: 19px;
				left: 8px;
			}
			/*-----------end hamburger-----------------------*/

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
	<div id="filter-tag-bar" >
		
	</div>
	<div class="filters-on-off hide-filter-btn"><span>Ver Filtros <i class="fas fa-sliders-h"></i></span></div>
	<div class="all-products-row">
		<div class="filters-col display-off">
			<div id="data-store" basic-query=""></div>
			<form action="" method="get">

				<div class="filter-category">
					<div class="filter-category-price">
						<h5>Precio</h5>
					</div>
					<div class="filter-container" id="priceFilterContainer">
						<?php echo renderPriceFilter($conn, "ps4", "Videojuego"); ?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h5>Condicion</h5>
					</div>
					<div class="filter-container" id="conditionFilterContainer">
						<?php
						echo renderConditionFilter($conn, "ps4", "Videojuego", "quantity_new");
						echo renderConditionFilter($conn, "ps4", "Videojuego", "quantity_used");
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-studio">
						<h5>Fabricante</h5>
					</div>
					<div class="filter-container" id="studioFilterContainer">
						<?php echo renderStudioFilter($conn, "ps4", "Videojuego", "studio"); ?>
					</div>
				</div>
			</form>
		</div>
		<div class="products-thumbs-col">
			<div class="basic-search-cont" search-term="" >
				<?php 
					echo renderSeach($conn, "ps4", "Videojuego", PRODUCTS_PER_PAGE);
					echo "<br>";
				?>
			</div>
			<div class="pagination" id="paginationid">
				<?php
					$numOfProducts = searchBaseGetProdCount($conn, "ps4", "Videojuego", "id");
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

<script type="text/javascript">
	$(function() {
		$(".submenu-item").on("click", function(event){
			event.stopPropagation();
			if(!$(this).hasClass("active-drop")){
				$(this).addClass("active-drop");
				drop_div_id = "#" + $(this).attr("target-drop-id");
				$(drop_div_id).removeClass("display-off");
			}else{
				$(this).removeClass("active-drop");
				drop_div_id = "#" + $(this).attr("target-drop-id");
				$(drop_div_id).addClass("display-off");
			}
		});

		$(".drop-down-products").on("click", function(){
			console.log("hamburger hit");
			$("#product-menu-drop").removeClass("display-off").addClass("show-submenu");
			if(!$(this).hasClass("active-drop")){
				$(this).addClass("active-drop");
				$("#product-menu-drop").removeClass("display-off").addClass("show-submenu");
			}else{
				$(this).removeClass("active-drop");
				$("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
			}
		});

		$(".show-hide-togg").on("click", function(){
			if(!$(this).hasClass("active-mobile")){
				$(this).addClass("active-mobile");
				$(this).removeClass("togg-icon-off").addClass("togg-icon-on");
				$(".hideable-items").addClass("mobile-on").removeClass("mobile-off");
			}else{
				$(this).removeClass("active-mobile");
				$(this).removeClass("togg-icon-on").addClass("togg-icon-off");
				$(".hideable-items").addClass("mobile-off").removeClass("mobile-on");
				// $("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
				// $(".active-drop").removeClass("active-drop");
				// $(".submenu-item-drop").addClass("display-off");
			}
		});

		// Hamburger ###################
		$('#nav-icon4').click(function(){
			if(!$(this).hasClass("active-mobile")){
				$(this).toggleClass('open');
				$(this).addClass("active-mobile");
				$(".hideable-items").addClass("mobile-on").removeClass("mobile-off");
			}
			else{
				$(this).toggleClass('open');
				$(this).removeClass("active-mobile");
				$(".hideable-items").addClass("mobile-off").removeClass("mobile-on");
				// $(".show-mobile").addClass("hide-mobile").removeClass("show-mobile");
				// $("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
				// $(".active-drop").removeClass("active-drop");
				// $(".submenu-item-drop").addClass("display-off");

			}
		});
	});
</script>
</body>
</html>


