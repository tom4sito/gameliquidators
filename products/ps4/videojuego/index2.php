<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';
require $includes_dir.'product-helpers-2.php';

define("PRODUCTS_PER_PAGE", 4);
define("INITIAL_NEXT_OFFSET", 4);

// if(isset($_SESSION['username'])){
//     echo "session started username: ".$_SESSION['username'];
// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Basic Search</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<style type="text/css">
		/* main container */
		.main-container{
			max-width: 1360px;
			padding: 20px;
		}
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
			max-width: 250px;
			margin: 10px;
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
		.selected-page{
			color: red;
		}
		#paginationid{
			padding-left: 25px;
		}
		@media screen and (min-width: 577px){
			/*----hides filters button -----*/
			.hide-filter-btn{
				display: none;
			}
			.display-off{
				display: block;
			}
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
			/*----displays filters button -----*/
			.hide-filter-btn{
				display: block;
			}
			.display-off{
				display: none;
			}
		}


		span{
			font-size: 14px;
		}

		/*----------------flexbox---------------------------------*/
		.all-products-row{
			display: flex;
			/*max-width: 1360px;*/
		}
		.products-thumbs-col{
			flex: 1;
		}
		.basic-seach-cont{
			display: flex;
			flex-wrap: wrap;
			padding-left: 25px;
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
		}

	</style>
</head>
<body>
<div>
<?php include($includes_dir."navbar.php"); ?>
</div>
<!-- <div class="sort-bar">
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
</div> -->
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
	<div class="filters-on-off hide-filter-btn">Ver Filtros</div>
	<div class="all-products-row">
		<div class="filters-col display-off">
			<div id="data-store" basic-query=""></div>
			<form action="" method="get">

				<div class="filter-category">
					<div class="filter-category-price">
						<h6>Precio</h6>
					</div>
					<div class="filterContainer" id="priceFilterContainer">
						<?php echo renderPriceFilter($conn, "ps4", "Videojuego"); ?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h6>Condicion</h6>
					</div>
					<div class="filterContainer" id="conditionFilterContainer">
						<?php
						echo renderConditionFilter($conn, "ps4", "Videojuego", "quantity_new");
						echo renderConditionFilter($conn, "ps4", "Videojuego", "quantity_used");
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-studio">
						<h6>Fabricante</h6>
					</div>
					<div class="filterContainer" id="studioFilterContainer">
						<?php echo renderStudioFilter($conn, "ps4", "Videojuego", "studio"); ?>
					</div>
				</div>
			</form>
		</div>
		<div class="products-thumbs-col">
			<div class="basic-seach-cont" search-term="" >
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
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript">
	const PRODUCTS_PER_PAGE = 4;
	filterParameters = {
		"queries": {
			"basic": "ps4",
			"platform": [],
			"pricerange": [],
			"condition": [],
			"studio": [],
			"producttype":[]
		},
		"pagination_offset": 0,
		"products_per_page": PRODUCTS_PER_PAGE,
		"order_by": "",
		"asc_desc": ""
	};

	//show hide filters
	$(".filters-on-off").on("click", function(){
		if($(".filters-col").hasClass("display-off")){
			$(".filters-col").removeClass("display-off");
			$(this).text("Esconder Filtros");
		}else{
			$(".filters-col").addClass("display-off");
			$(this).text("Ver Filtros");
		}
	});

	
	// $(window).resize(function(){
	// 	if(window.innerWidth <= 576){
	// 		$(".filters-col").addClass("display-off");
	// 	}
	// 	else{
	// 		$(".filters-col").removeClass("display-off");
	// 	}
	// });

	// if(window.matchMedia('screen and (max-width: 576px)').matches){
	// 	console.log("java screen!!!");
	// 	$(".filters-col").addClass("display-off");
	// }

	//sets this va with the results from basic query
	basicQueryCopy = $.ajax({
		url: "/gameliquidators/includes/product-fetcher.php",
		method:"POST",
		dataType:"json",
		async: false,
		contentType:"application/json; charset=utf-8",
		data: JSON.stringify(filterParameters),
		success:function(data){
			return data;
		},
		error: function (request, status, error) {
		    alert(error);
		}
	}).responseText;

	//stores json from original basic query
	basicQueryJson = JSON.parse(basicQueryCopy);
	console.log(basicQueryJson);

	// -----------------------------when filter is checked---------------->
	$(document).on("change", ".grab-filter", function(){
		console.log("you click grabfilter!!!!!");
		filterClass = $(this).prop("classList")[0];
		filterCategory = filterClass.split("-")[0];

		checkedCheckboxes = $("."+filterClass+":checked").length;

		// if no checkbox on filter category is checked reset to original result
		if(checkedCheckboxes <= 0){
			if(filterCategory == "platform"){
				$("#platformFilterContainer").empty().prepend(platformfilterUpdt(basicQueryJson.platform_count, []));
			}
			if(filterCategory == "pricerange"){
				$("#priceFilterContainer").empty().prepend(renderPriceFilter(basicQueryJson.price_new_count, basicQueryJson.price_used_count));
			}
			if(filterCategory == "condition"){
				$("#conditionFilterContainer").empty().prepend(renderConditionFilter(basicQueryJson.new_count, basicQueryJson.used_count));
			}
			if(filterCategory == "producttype"){
				$("#producttypeFilterContainer").empty().prepend(renderProductTypeFilter(basicQueryJson.producttype_count, []));
			}
			if(filterCategory == "studio"){
				$("#studioFilterContainer").empty().prepend(renderStudioFilter(basicQueryJson.studio, []));
				// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!CONTINUE HERE!!!!!!!!!!!!!
			}		
		}

		extra = $(this).attr('name').split("|");

		if(extra[0].includes("platform")){
			platformArr = filterParameters["queries"]["platform"];
			if(!platformArr.includes(extra[1])){
				platformArr.push(extra[1]);
				filterParameters["pagination_offset"] = 0;
			}
			else{
				platformArr.splice(platformArr.indexOf(extra[1]), 1);
				filterParameters["pagination_offset"] = 0;
			}	
		}
		else if(extra[0].includes("pricerange")){
			pricerangeArr = filterParameters["queries"]["pricerange"];
			rangePair = [extra[1], extra[2]];
			arrMatchCounter = 0;

			if(pricerangeArr.length == 0){
				pricerangeArr.push(rangePair);
				filterParameters["pagination_offset"] = 0;
			}
			else{
				pricerangeArr.forEach(function(ele, index, object){
					if((ele[0] == rangePair[0]) && (ele[1] == rangePair[1])){
						arrMatchCounter += 1;
						object.splice(index, 1);
					}
				});

				if(arrMatchCounter < 1){
					pricerangeArr.push(rangePair);
				}
				filterParameters["pagination_offset"] = 0;
			}
		}
		else if(extra[0].includes("condition")){
			conditionArr = filterParameters["queries"]["condition"]; 
			if(!conditionArr.includes(extra[1])){
				conditionArr.push(extra[1]);
				filterParameters["pagination_offset"] = 0;
			}
			else{
				conditionArr.splice(conditionArr.indexOf(extra[1]), 1);
				filterParameters["pagination_offset"] = 0;
			}
		}
		else if(extra[0].includes("producttype")){
			producttypeArr = filterParameters["queries"]["producttype"];
			if(!producttypeArr.includes(extra[1])){
				producttypeArr.push(extra[1]);
				filterParameters["pagination_offset"] = 0;
			}
			else{
				producttypeArr.splice(producttypeArr.indexOf(extra[1]), 1);
				filterParameters["pagination_offset"] = 0;
			}
		}
		else if(extra[0].includes("studio")){
			studioArr = filterParameters["queries"]["studio"];
			if(!studioArr.includes(extra[1])){
				studioArr.push(extra[1]);
				filterParameters["pagination_offset"] = 0;
			}
		}

		if(checkedCheckboxes <= 0){
			console.log("no checks");
			filterParameters["queries"][filterCategory] = [];
		}
		$.ajax({
			url: "/gameliquidators/includes/product-fetcher.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			success:function(data){
				console.log(data);
				// console.log(data.price_new_count);
				// console.log(data.price_used_count);
				$(".basic-seach-cont").empty();
				$(".basic-seach-cont").prepend(genFilterProductsHtml(data));

				$(".pagination").empty();
				$(".pagination").prepend(genPagination(data, PRODUCTS_PER_PAGE));
				// if(extra[0] != "platform"){
				// 	$("#platformFilterContainer").empty().prepend(platformfilterUpdt(data.platform_count, filterParameters.queries.platform));
				// }
				if(extra[0] != "pricerange"){
					$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count));
				}
				if(extra[0] != "condition"){
					console.log("condition new: ");
					$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count, filterParameters.queries.condition));
				}
				if(extra[0] != "studio"){
					console.log("sudio: ");
					$("#studioFilterContainer").empty().prepend(renderStudioFilter(data.studio, filterParameters.queries.studio));
				}
				// if(extra[0] != "producttype"){
				// 	console.log("product type: ");
				// 	$("#producttypeFilterContainer").empty().prepend(renderProductTypeFilter(data.producttype_count, filterParameters.queries.producttype));
				// }
			},
			error: function (request, status, error) {
			    alert(error);
			}
		});

		console.log(filterParameters);


	});

	$(document).on("click", ".selectpage", function(){
		filterParameters["pagination_offset"] = $(this).attr("pageoffset");
		$.ajax({
			url: "/gameliquidators/includes/product-fetcher.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			success:function(data){
				console.log(data);
				$( ".basic-seach-cont" ).empty();
				$( ".basic-seach-cont" ).prepend(genFilterProductsHtml(data));
				$( ".pagination" ).empty();
				$( ".pagination" ).prepend(genPagination(data, PRODUCTS_PER_PAGE));
				// $("#platformFilterContainer").empty().prepend(platformfilterUpdt(data.platform_count, filterParameters.queries.platform));
				// $("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count));
				// $("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count));
				// $("#producttypeFilterContainer").empty().prepend(renderProductTypeFilter(data.producttype_count, filterParameters.queries.producttype));

				// $("#data-store").data("title-query", data.filters);
				// console.log($("#data-store").data("title-query"));
			},
			error: function (request, status, error) {
			    alert(error);
			}
		});
		console.log(filterParameters);
	});

	// sort by selected dropdown menu criteria
	$(document).on("change", "#sort-criteria", function(){
		sortBy = $(this).val();
		if(sortBy == "title-lth"){
			filterParameters["sort_by"] = "title";
			filterParameters["asc_desc"] = "ASC";
		}
		else if(sortBy == "title-htl"){
			filterParameters["sort_by"] = "title";
			filterParameters["asc_desc"] = "DESC";
		}
		else if(sortBy == "year-lth"){
			filterParameters["sort_by"] = "release_year";
			filterParameters["asc_desc"] = "ASC";
		}
		else if(sortBy == "year-htl"){
			filterParameters["sort_by"] = "release_year";
			filterParameters["asc_desc"] = "DESC";
		}
		else if(sortBy == "price-new-lth"){
			filterParameters["sort_by"] = "price_new";
			filterParameters["asc_desc"] = "ASC";
		}
		else if(sortBy == "price-new-htl"){
			filterParameters["sort_by"] = "price_new";
			filterParameters["asc_desc"] = "DESC";
		}
		else if(sortBy == "price-used-lth"){
			filterParameters["sort_by"] = "price_used";
			filterParameters["asc_desc"] = "ASC";
		}
		else if(sortBy == "price-used-htl"){
			filterParameters["sort_by"] = "price_used";
			filterParameters["asc_desc"] = "DESC";
		} 

		$.ajax({
			url: "/gameliquidators/includes/product-fetcher.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			success:function(data){
				console.log(data);
				$(".basic-seach-cont").empty();
				$(".basic-seach-cont").prepend(genFilterProductsHtml(data));
			},
			error: function (request, status, error) {
			    alert(error);
			}
		});
	})

	function genFilterProductsHtml(jsonProducts){
		product_html = "";
		if (typeof jsonProducts.products === "undefined"){
			return "ningun producto disponible!!!";
		}

		jsonProducts.products.forEach(function(productsData){
			product_html += "<div class='col-lg-3 col-md-4 col-sm-6 col-12 product-thumb'>";
			product_html += 	"<div class='product-thumb-body'>";
			product_html +=    	"<div class='row'>";
			product_html +=			"<div class='col-lg-12 col-md-12 col-sm-12 col-5'>";
			product_html +=				"<img class='product-thumb-img' src='" + productsData.image + "'>";
			product_html +=			"</div>";
			product_html +=			"<div class='col-lg-12 col-md-12 col-sm-12 col-5'>";
			product_html +=				"<div class='product-thumb-title'>" + productsData.title + "</div>";
			product_html +=				"<div>plataforma: <span>" + productsData.platform + "</span></div>";
			product_html +=				"<div class='product-thumb-price'>" + productsData.price_used + "</div>";
			product_html +=				"<div class='product-thumb-price'>" + productsData.price_new + "</div>";
			product_html +=				"<div>";
			product_html +=					"<span class='thumb-product-stock'>" + productsData.is_available + "</span> | ";
			product_html +=					"<span class='thumb-product-studio'>" + productsData.studio + "</span>";
			product_html +=				"</div>";
			product_html +=			"</div>";
			product_html +=    	"</div>";
			product_html += 	"</div>";
			product_html += "</div>";
		});

		return product_html;
	}

	function platformfilterUpdt(platformCount, queryObj){
		platformHTML = "";
		if(platformCount == undefined){
			return platformHTML;
		}
		var platformObj = {};
		platformCount.forEach(function(platform){
			if(platform in platformObj){
				platformObj[platform] += 1;
			}
			else{
				platformObj[platform] = 1;
			}
		});

		for (var key in platformObj) {
			checked = "";
			if(queryObj.includes(key)){
				checked = "checked";
			}
		    if (platformObj.hasOwnProperty(key)) {
		        platformHTML += "<div>";
		        platformHTML += 	"<input type='checkbox' name='platform|" + key + "' value='" + platformObj[key] + "'class='platform-filter grab-filter' filter-name='" + key + "' " + checked + ">";
		        platformHTML += 	"<span> "+ key +" (" + platformObj[key] + ")</span>";
		        platformHTML += "</div>";
		    }
		}
		return platformHTML;
	}

	function renderPriceFilter(newPriceArr, usedPriceArr){
		rangeHtml = "";
		if(newPriceArr == undefined){
			return rangeHtml;
		}
		prevRange = 0;
		currentRange = 0;

		fullPriceRangeArrStr = newPriceArr.concat(usedPriceArr);
		fullPriceRangeArr = fullPriceRangeArrStr.map(function (x) { 
		  return parseInt(x, 10); 
		});

		if(fullPriceRangeArr.length > 0){
			fullPriceRangeArr = fullPriceRangeArrStr.sort((a, b) => a - b);
			rangeMin = fullPriceRangeArr[0];
			rangeMax = fullPriceRangeArr[fullPriceRangeArr.length - 1];
			ranges = createRangeArr(rangeMin, rangeMax);

			ranges.ranges.forEach(function(range){
				priceHitCounter = 0;
				fullPriceRangeArr.forEach(function(realPrice){
					realPrice = parseInt(realPrice);
					if((realPrice > range[0]) && (realPrice <= range[1])){
						priceHitCounter += 1;
					}
				});
				if(priceHitCounter > 0){
					rangeHtml += "<div>";
					rangeHtml += 	`<input type='checkbox' name='pricerange|${range[0]}|${range[1]}' value='${range[1]}' class='pricerange-filter grab-filter' filter-name='${range[0]}-${range[1]}'>`;
					rangeHtml += 	`<span> \$ ${range[0]} - \$ ${range[1]} (${priceHitCounter})</span>`;
					rangeHtml += "</div>";
				}
			});
			return rangeHtml;
		}
	}

	function createRangeArr(min, max){
		rangeObj = {"ranges":[]};
		diff = max - min;

		if(diff <= 100){
			if(max < 100){
				minFloored = Math.floor(min / 10) * 10;
				maxCeiled = Math.ceil(max / 10) * 10;
				pointer = minFloored;
				current = 0;
				while(Math.floor((pointer / 10) * 10) <= maxCeiled){
					rangeObj["ranges"].push([current, pointer]);
					current = Math.floor((pointer / 10) * 10);
					pointer += 10;
				}
			}

		}
		else if((diff > 100 ) && (diff <= 250)){
			maxCeiled = Math.ceil(max / 100) * 100;
			pointer = 50;
			current = 0
			while(pointer < maxCeiled){
				rangeObj["ranges"].push([current, pointer]);
				current = pointer;
				pointer += 50;
			}
		}
		else if(diff > 250 ){
			minFloored = Math.floor(min / 100) * 100;
			maxCeiled = Math.ceil(max / 100) * 100;
			pointer = 100;
			current = 0;
			while(pointer <= maxCeiled){
				rangeObj["ranges"].push([current, pointer]);
				current = pointer;
				pointer += 100;
			}
		}
		return rangeObj;
	}

	function renderConditionFilter(newGameArr, usedGameArr){
		$conditionHtml = "";
		if(newGameArr == undefined){
			return "";
		}
		var conditionObj = {}
		newCounter = 0;
		usedCounter = 0;

		newGameArr.forEach(function(e){
			if(e > 0){
				newCounter ++;
			}
		});
		usedGameArr.forEach(function(e){
			if(e > 0){
				usedCounter ++;
			}
		});

		if(newCounter > 0){
			$conditionHtml += "<div>";
			$conditionHtml +=	"<input type='checkbox' name='condition|new' filter-name='new' class='condition-filter grab-filter'>";
			$conditionHtml +=	"<span> New ("+newCounter+")</span>"
			$conditionHtml += "</div>";
		}
		if(usedCounter > 0){
			$conditionHtml += "<div>";
			$conditionHtml +=	"<input type='checkbox' name='condition|used' filter-name='used' class='condition-filter grab-filter'>";
			$conditionHtml +=	"<span> Used ("+usedCounter+")</span>"
			$conditionHtml += "</div>";
		}
		return $conditionHtml;

	}
	function renderProductTypeFilter(productTypeCount, queryObj){
		productTypeHTML = "";
		if(productTypeCount == undefined){
			return productTypeHTML;
		}
		var productTypeObj = {};
		productTypeCount.forEach(function(productType){
			if(productType in productTypeObj){
				productTypeObj[productType] += 1;
			}
			else{
				productTypeObj[productType] = 1;
			}
		});

		for (var key in productTypeObj) {
			checked = "";
			if(queryObj.includes(key)){
				checked = "checked";
			}
			if(productTypeObj.hasOwnProperty(key)) {
				productTypeHTML += "<div>";
				// productTypeHTML += 	"<input type='checkbox' name='producttype|" + key + "' value='" + productTypeObj[key] + "'class='producttype-filter grab-filter' filter-name='" + key + "' >";
				productTypeHTML += 	"<input type='checkbox' name='producttype|" + key + "' value='" + productTypeObj[key] + "'class='producttype-filter grab-filter' filter-name='" + key + "' " + checked + ">";
				productTypeHTML += 	"<span> "+ key +" (" + productTypeObj[key] + ")</span>";
				productTypeHTML += "</div>"
		    }
		}
		return productTypeHTML;
	}

	function renderStudioFilter(studioCount, queryObj){
		productStudioHtml = "";

		if(studioCount == undefined){
			return productStudioHtml;
		}
		var studioObj = {};
		studioCount.forEach(function(studio){
			if(studio in studioObj){
				studioObj[studio] += 1;
			}
			else{
				studioObj[studio] = 1;
			}
		});

		for (var key in studioObj) {
			checked = "";
			if(queryObj.includes(key)){
				checked = "checked";
			}
		    if(studioObj.hasOwnProperty(key)) {
		        productStudioHtml += "<div>";
		        productStudioHtml += 	"<input type='checkbox' name='studio|" + key + "' value='" + studioObj[key] + "'class='studio-filter grab-filter' filter-name='" + key + "' " + checked + ">";
		        productStudioHtml += 	"<span> "+ key +" (" + studioObj[key] + ")</span>";
		        productStudioHtml += "</div>";
		    }
		}
		return productStudioHtml;
	}

	function genPagination(pageObj, productsPerPage){
		paginationHtml = "";
		if(pageObj['num_of_products'] == undefined){
			return "";
		}

		numOfPages = Math.ceil(pageObj['num_of_products']/productsPerPage);
		console.log("genPagination numofpages: "+ numOfPages);
		if(numOfPages <= 1){
			return "";
		}
		lastOffSet = (numOfPages - 1) * productsPerPage;

		previousPage = pageObj['prev_page'] >= 0 ? pageObj['prev_page'] : 0;
		nextPage = pageObj['next_page'] >= lastOffSet ? lastOffSet : pageObj['next_page'];
		currentPage = pageObj['current_page'];
		console.log(currentPage);
		selected = "";


		paginationHtml += "<a href='#' class='selectpage pagination-previous' pageoffset='" +previousPage+ "'><span>&laquo; Previo &nbsp;</span></a>";
		paginationHtml += "<div class='pagination-pages'>";
		for (var i = 1; i <= numOfPages; i++ ){
			if(((i - 1) * productsPerPage) == currentPage){
				selected = " selected-page";
			}
			paginationHtml += "<a href='#' class='selectpage "+selected+"' pageoffset='" + (i - 1) * productsPerPage + "'> " + i + " </a>";
			selected = "";
		}
		paginationHtml += "</div>";
		paginationHtml += "<a href='#' class='selectpage pagination-next' pageoffset='" +nextPage+ "'><span> &nbsp; Siguiente &raquo;</span></a>";
		console.log("nextpage: " + nextPage)
		return paginationHtml;
	}
</script>
</body>
</html>


