<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../includes/db_connect.php';
include 'search-helpers.php';

if(isset($_GET['basic-search-inp']) && !empty($_GET['basic-search-inp'])){
	$postInput = $_GET['basic-search-inp'];
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
			<div id="data-store" basic-query="<?php echo ifGetVarIsSet($postInput); ?>"></div>
			<form action="" method="get">
				<div class="filter-category">
					<div class="filter-category-title">
						<h6>Platform</h6>
					</div>
					<div class="filterContainer" id="platformFilterContainer">
						<?php 
						if(isset($postInput) && !empty($postInput)){
							echo renderPlatformFilter($conn, $postInput, "platform"); 
						}
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-price">
						<h6>Price</h6>
					</div>
					<div class="filterContainer" id="priceFilterContainer">
						<?php 
						if(isset($postInput) && !empty($postInput)){
							echo renderPriceFilter($conn, $postInput);
						}
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h6>Condition</h6>
					</div>
					<div class="filterContainer">
						<?php
						if(isset($postInput) && !empty($postInput)){ 
							echo renderConditionFilter($conn, $postInput, "quantity_new");
							echo renderConditionFilter($conn, $postInput, "quantity_used");
						}
						?>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-10 col-md-10 products-thumbs-col">
			<div class="row basic-seach-cont" search-term="<?php echo $postInput ?>" >
				<?php 
				if(isset($postInput) && !empty($postInput)){
					echo renderSeach($conn, $postInput, "*");
					echo "<br>";
				}
				?>
			</div>
			<div class="pagination" id="paginationid">
				<?php
				if(isset($postInput) && !empty($postInput)){
					$numOfProducts = searchBaseGetProdCount($conn, $postInput, "id");
					echo genPagination($numOfProducts, 2); 
				} 
				?>
			</div>
		</div>
	</div>
</div>

<?php mysqli_close($conn); ?>
</div>

<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript">
	filterParameters = {
		"queries": {
			"basic": $("#data-store").attr("basic-query"),
			"platform": [],
			"pricerange": [],
			"condition": [],
			"studio": "",
		},
		"pagination_offset": 0
	};

	filterParametersCopy = {};

	$(document).on("change", ".grab-filter", function(){
		console.log("you click grabfilter!!!!!");
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
		// console.log(filterParameters);

		// console.log(extra);
		$.ajax({
			url: "refined-search3.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			// data: '{"basic":"'+ basic + '", "extra": "' + extra + '"}',
			success:function(data){
				// console.log(genFilterProductsHtml(data));
				// console.log(JSON.stringify(data));
				// console.log(data.products);
				console.log(data);
				$(".basic-seach-cont").empty();
				$(".basic-seach-cont").prepend(genFilterProductsHtml(data));
				$(".pagination").empty();
				$(".pagination").prepend(genPagination(data['num_of_products']));
				if(extra[0] != "platform"){
					$("#platformFilterContainer").empty().prepend(platformfilterUpdt(data.platform_count, filterParameters.queries.platform));
				}
				if(extra[0] != "pricerange"){
					$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count));
				}

				// filterUpdate = renderPriceFilter(data.price_new_count, data.price_used_count);
				// platformfilterUpdt(data);
				// $("#data-store").data("title-query", data.filters);
				// console.log($("#data-store").data("title-query"));
			},
			error: function (request, status, error) {
			    alert(error);
			}
		});

		console.log(filterParameters);


	});

	$(document).on("click", ".selectpage", function(){
		// console.log(filterParameters["pagination_offset"]);
		filterParameters["pagination_offset"] = $(this).attr("pageoffset");
		$.ajax({
			url: "refined-search3.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			success:function(data){
				console.log(data);
				$( ".basic-seach-cont" ).empty();
				$( ".basic-seach-cont" ).prepend(genFilterProductsHtml(data));
				$( ".pagination" ).empty();
				$( ".pagination" ).prepend(genPagination(data['num_of_products']));
				$("#platformFilterContainer").empty().prepend(platformfilterUpdt(data.platform_count, filterParameters.queries.platform));
				// $("#data-store").data("title-query", data.filters);
				// console.log($("#data-store").data("title-query"));
			},
			error: function (request, status, error) {
			    alert(error);
			}
		});
		console.log(filterParameters);
	});

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

	function genPagination(totalProducts){
		numOfPages = Math.ceil(totalProducts/2);
		paginationHtml = "";
		paginationHtml += "<a class='pagination-previous' href=''><span>&laquo; Previo &nbsp;</span></a>";
		paginationHtml += "<div class='pagination-pages'>";
		for (var i = 1; i <= numOfPages; i++ ){
			paginationHtml += "<a href='#' class='selectpage' pageoffset='" + (i - 1) * 2 + "'> " + i + " </a>";
		}
		paginationHtml += "</div>";
		paginationHtml += "<a class='pagination-next' href=''><span> &nbsp; Siguiente &raquo;</span></a>";
		return paginationHtml;
	}

	function platformfilterUpdt(platformCount, queryObj){
		platformHTML = "";
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
		        platformHTML += "</div>"
		    }
		}
		return platformHTML;
	}

	function renderPriceFilter(newPriceArr, usedPriceArr){
		rangeHtml = "";
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
					if((realPrice >= range[0]) && (realPrice < range[1])){
						priceHitCounter += 1;
					}
				});
				if(priceHitCounter > 0){
					rangeHtml += "<div>";
					rangeHtml += 	`<input type='checkbox' name='pricerange|${range[0]}|${range[1]}' value='${range[1]}' class='platform-filter grab-filter' filter-name='${range[0]}-${range[1]}'>`;
					rangeHtml += 	`<span> \$ ${range[0]} - \$ ${range[1]} (${priceHitCounter})</span>`;
					rangeHtml += "</div>";
				}
			});
			return rangeHtml;
			// console.log("min: " + rangeMin);
			// console.log(ranges);
			// console.log(rangeMin + " - " + rangeMax);
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


</script>
</body>
</html>