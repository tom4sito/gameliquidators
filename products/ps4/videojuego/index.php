<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';
require $includes_dir.'product-helpers.php';

if(isset($_SESSION['username'])){
    echo "session started username: ".$_SESSION['username'];
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>main page</title>
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<style type="text/css"></style>
</head>
<body>
<div>
<?php 
include($includes_dir."navbar.php");
include($includes_dir."products_list_template.php");
?>

<div class="container-fluid">
	<div class="row all-products-row">
		<div class="col-lg-2 col-md-2 filters-col">
			<div id="data-store" basic-query="ps4"></div>
			<form action="" method="get">
				<div class="filter-category">
					<div class="filter-category-price">
						<h6>Price</h6>
					</div>
					<div class="filterContainer" id="priceFilterContainer">
						<?php 
							echo renderPriceFilter($conn, "ps4", "videojuego");
						?>
					</div>
				</div>
				<hr>
				<div class="filter-category">
					<div class="filter-category-condition">
						<h6>Condition</h6>
					</div>
					<div class="filterContainer" id="conditionFilterContainer">
						<?php
							echo renderConditionFilter($conn, "ps4", "quantity_new", "videojuego");
							echo renderConditionFilter($conn, "ps4", "quantity_used", "videojuego");
						?>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-10 col-md-10 products-thumbs-col">
			<div class="row product-fetch-row">
				<?php
				echo renderProducts($conn, 'platform', 'ps4', 'product_type', 'videojuego');
				$conn->close();
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

	//sets this va with the results from basic query
	basicQueryCopy = $.ajax({
		url: "/gameliquidators/includes/product-fetcher.php",
		method:"POST",
		dataType:"json",
		async: false,
		contentType:"application/json; charset=utf-8",
		data: JSON.stringify(filterParameters),
		success:function(data){
			console.log(data);
			return data;
		},
		error: function (request, status, error) {
		    alert(error);
		}
	}).responseText;

	//stores json from original basic query
	basicQueryJson = JSON.parse(basicQueryCopy);

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
				$(".product-fetch-row").empty();
				$(".product-fetch-row").prepend(genFilterProductsHtml(data));
				$(".pagination").empty();
				$(".pagination").prepend(genPagination(data['num_of_products']));
				if(extra[0] != "platform"){
					$("#platformFilterContainer").empty().prepend(platformfilterUpdt(data.platform_count, filterParameters.queries.basic));
				}
				if(extra[0] != "pricerange"){
					$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count));
				}
				if(extra[0] != "condition"){
					console.log("condition new: ");
					$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count));
				}
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
			url: "/gameliquidators/includes/product-fetcher.php",
			method:"POST",
			dataType:"json",
			contentType:"application/json; charset=utf-8",
			data: JSON.stringify(filterParameters),
			success:function(data){
				console.log("data from productfetcher");
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

		$conditionHtml += "<div>";
		$conditionHtml +=	"<input type='checkbox' name='condition|new' filter-name='new' class='condition-filter grab-filter'>";
		$conditionHtml +=	"<span> New ("+newCounter+")</span>"
		$conditionHtml += "</div>";
		$conditionHtml += "<div>";
		$conditionHtml +=	"<input type='checkbox' name='condition|used' filter-name='used' class='condition-filter grab-filter'>";
		$conditionHtml +=	"<span> Used ("+usedCounter+")</span>"
		$conditionHtml += "</div>";

		return $conditionHtml;

	}
</script>
</body>
</html>