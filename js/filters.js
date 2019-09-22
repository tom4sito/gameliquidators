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
	if($(".filters-col").hasClass("filter-display-off")){
		$(".filters-col").removeClass("filter-display-off");
		// $(this).text("Ocultar Filtros");
		$(this).empty().append("<span>Ocultar Filtros <i class='fas fa-sliders-h'></i></span>");
	}else{
		$(".filters-col").addClass("filter-display-off");
		// $(this).text("Ver Filtros");
		$(this).empty().append("<span>Ver Filtros <i class='fas fa-sliders-h'></i></span>");
	}
});


// $(window).resize(function(){
// 	if(window.innerWidth <= 576){
// 		$(".filters-col").addClass("filter-display-off");
// 	}
// 	else{
// 		$(".filters-col").removeClass("filter-display-off");
// 	}
// });

// if(window.matchMedia('screen and (max-width: 576px)').matches){
// 	console.log("java screen!!!");
// 	$(".filters-col").addClass("filter-display-off");
// }

//sets this va with the results from basic query
// basicQueryCopy = $.ajax({
// 	url: "/gameliquidators/includes/product-fetcher.php",
// 	method:"POST",
// 	dataType:"json",
// 	async: false,
// 	contentType:"application/json; charset=utf-8",
// 	data: JSON.stringify(filterParameters),
// 	success:function(data){
// 		return data;
// 	},
// 	error: function (request, status, error) {
// 	    alert(error);
// 	}
// }).responseText;

//stores json from original basic query
// basicQueryJson = JSON.parse(basicQueryCopy);
// console.log(basicQueryJson);

// -----------------------------when filter is checked---------------->
$(document).on("change", ".grab-filter", function(){
	filterType = $(this).attr("filter-type");
	filterClass = $(this).prop("classList")[0];

	checkedCheckboxes = $("."+filterClass+":checked").length;
	
	// START OF FILTER-TYPE CHECKBOX EVALUATIONS #######################################################
	if(filterType == "platform"){
		platformArr = filterParameters["queries"]["platform"];
		if(!platformArr.includes($(this).val())){
			platformArr.push($(this).val());
			filterParameters["pagination_offset"] = 0;
		}
		else{
			platformArr.splice(platformArr.indexOf($(this).val()), 1);
			filterParameters["pagination_offset"] = 0;
		}
		if(checkedCheckboxes <= 0){
			// $("#platformFilterContainer").empty().prepend(platformfilterUpdt(basicQueryJson.platform_count, []));
		}	
	}
	else if(filterType == "price"){
		pricerangeArr = filterParameters["queries"]["pricerange"];
		rangePair = [$(this).attr("min"), $(this).attr("max"), $(this).attr("qty")];
		arrMatchCounter = 0;

		// push range pair into pricerangeArr if it is empty
		if(pricerangeArr.length <= 0){
			pricerangeArr.push(rangePair);
			filterParameters["pagination_offset"] = 0; 
		}
		else{
			// checks if range pair is not already in the priceRangeArr
			pricerangeArr.forEach(function(ele, index, object){
				if((ele[0] == rangePair[0]) && (ele[1] == rangePair[1])){
					arrMatchCounter += 1;
					object.splice(index, 1);//removes rangepair from pricerangeArr if it is already in it
				}
			});

			if(arrMatchCounter < 1){
				pricerangeArr.push(rangePair);
			}
			filterParameters["pagination_offset"] = 0;//dont remember what this is for
		}
		if(checkedCheckboxes <= 0){
			ajaxZeroBoxChecked(filterParameters, PRODUCTS_PER_PAGE);
			return;
		}
	}
	else if(filterType == "condition"){
		conditionArr = filterParameters["queries"]["condition"];
		conditionType = $(this).attr("condition");
		conditionQty = $(this).attr("qty");
		rangePair = [conditionType, conditionQty];
		arrMatchCounter = 0;

		if(conditionArr.length <= 0){
			conditionArr.push(rangePair);
			filterParameters["pagination_offset"] = 0; 
		}
		else{
			// checks if range pair is not already in the priceRangeArr
			conditionArr.forEach(function(ele, index, object){
				if((ele[0] == rangePair[0])){
					arrMatchCounter += 1;
					object.splice(index, 1);//removes rangepair from pricerangeArr if it is already in it
				}
			});

			if(arrMatchCounter < 1){
				conditionArr.push(rangePair);
			}
			filterParameters["pagination_offset"] = 0;//dont remember what this is for

		}
		if(checkedCheckboxes <= 0){
			ajaxZeroBoxChecked(filterParameters, PRODUCTS_PER_PAGE);
			return;
		}
	}
	else if(filterType == "producttype"){
		producttypeArr = filterParameters["queries"]["producttype"];
		productType = $(this).val();
		if(!producttypeArr.includes(productType)){
			producttypeArr.push(productType);
			filterParameters["pagination_offset"] = 0;
		}
		else{
			producttypeArr.splice(producttypeArr.indexOf(productType), 1);
			filterParameters["pagination_offset"] = 0;
		}
		if(checkedCheckboxes <= 0){
			// $("#producttypeFilterContainer").empty().prepend(renderProductTypeFilter(basicQueryJson.producttype_count, []));
		}
	}
	else if(filterType == "studio"){
		studioArr = filterParameters["queries"]["studio"];
		productStudio = $(this).attr("name");
		studioQty = $(this).attr("qty");
		studioSet = [productStudio, studioQty];

		if(!studioArr.includes(productStudio)){
			studioArr.push(productStudio);
			filterParameters["pagination_offset"] = 0;
		}
		else{
			studioArr.splice(studioArr.indexOf(productStudio), 1);
			filterParameters["pagination_offset"] = 0;
		}
		if(checkedCheckboxes <= 0){
			ajaxZeroBoxChecked(filterParameters, PRODUCTS_PER_PAGE);
			return;
		}
	}
	// END OF FILTER-TYPE CHECKBOX EVALUATIONS #######################################################


	$.ajax({
		url: "/gameliquidators/includes/product-fetcher.php",
		method:"POST",
		dataType:"json",
		contentType:"application/json; charset=utf-8",
		data: JSON.stringify(filterParameters),
		success:function(data){
			console.log(data);
			$(".basic-search-cont").empty();
			$(".basic-search-cont").prepend(genFilterProductsHtml(data));

			$(".pagination").empty();
			$(".pagination").prepend(genPagination(data, PRODUCTS_PER_PAGE));
			
			if(filterType != "price"){
				$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count, filterParameters.queries.pricerange));
			}
			if(filterType != "condition"){
				$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count, filterParameters.queries));
			}
			if(filterType != "studio"){
				$("#studioFilterContainer").empty().prepend(renderStudioFilter(data.studio, filterParameters.queries.studio));
			}
		},
		error: function (request, status, error) {
		    alert(error);
		}
	});
});

// move to next or previous page pagination event -----------------------------
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
			$( ".basic-search-cont" ).empty();
			$( ".basic-search-cont" ).prepend(genFilterProductsHtml(data));
			$( ".pagination" ).empty();
			$( ".pagination" ).prepend(genPagination(data, PRODUCTS_PER_PAGE));
		},
		error: function (request, status, error) {
		    alert(error);
		}
	});
	console.log(filterParameters);
});

// sort by selected dropdown menu criteria -----------------------------
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
			$(".basic-search-cont").empty();
			$(".basic-search-cont").prepend(genFilterProductsHtml(data));
		},
		error: function (request, status, error) {
		    alert(error);
		}
	});
})


// FILTER RENDERING FUNCTIONS START HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function genFilterProductsHtml(jsonProducts){
	product_html = "";
	if (typeof jsonProducts.products === "undefined"){
		return "ningun producto disponible!!!";
	}

	jsonProducts.products.forEach(function(productsData){
		product_html += "<div class='product-thumb'>";
		product_html +=			"<div class='product-thumb-img-wrapper'>";
		product_html +=				`<a href='show/?id=${productsData.id}'>`;
		product_html +=					`<img class='product-thumb-img' src='${productsData.image}'>`;
		product_html +=				"</a>";
		product_html +=			"</div>";
		product_html +=			"<div class='product-thumb-content'>";
		product_html +=				`<a href='show/?id=${productsData.id}'>`;
		product_html +=					`<div class='product-thumb-title'>${productsData.title}</div>`;
		product_html +=				"</a>";
		product_html +=				`<div class='product-thumb-platform'><span>${productsData.platform}</span> | ${productsData.tag}</div>`;
		product_html +=				`<div class='product-thumb-price'><span class='bold-text'>Usado:</span> $${productsData.price_used }</div>`;
		product_html +=				`<div class='product-thumb-price'><span class='bold-text'>Nuevo:</span>  $${productsData.price_new}</div>`;
		product_html +=				"<div class='product-thumb-studio'>";
		product_html +=					`<span class='bold-text'>Fabricante:</span>  ${productsData.studio}`;
		product_html +=				"</div>";
		product_html +=			"</div>";
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
	        platformHTML += 	`<input type='checkbox' name='platform-${key}' value='${platformObj[key]}' class='platform-filter grab-filter' filter-name='${key}' filter-type='platform' ${checked}>`;
	        platformHTML += 	`<span> ${key} (${platformObj[key]})</span>`;
	        platformHTML += "</div>";
	    }
	}
	return platformHTML;
}

function renderPriceFilter(newPriceArr, usedPriceArr, priceRangeObj){
	console.log("priceArrangeObj from renderPriceFilter: ", priceRangeObj);
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
		return getRanges(fullPriceRangeArr, priceRangeObj);
	}

}

function getRanges(productPrices, priceRangeObj){
	arr_zero_fiftho = []; 
	arr_fiftho_hundtho = []; 
	arr_hundtho_twohundtho = []; 
	arr_twohundtho_fivehundtho = []; 
	arr_fivehundtho_onemill = []; 
	arr_onemill_twomill = []; 
	arr_twomill_fivemill = []; 
	arr_fivemill_tenmill = [];

	productPrices.forEach(function(price){
		if(price > 0 && price < 50000){
			arr_zero_fiftho.push(price);
		}
		else if(price >= 50000 && price < 100000){
			arr_fiftho_hundtho.push(price);
		}
		else if(price >= 100000 && price < 200000){
			arr_hundtho_twohundtho.push(price);
		}
		else if(price >= 200000 && price < 500000){
			arr_twohundtho_fivehundtho.push(price);
		}
		else if(price >= 500000 && price < 1000000){
			arr_fivehundtho_onemill.push(price);
		}
		else if(price >= 1000000 && price < 2000000){
			arr_onemill_twomill.push(price);
		}
		else if(price >= 2000000 && price < 5000000){
			arr_twomill_fivemill.push(price);
		}
		else if(price >= 5000000 && price < 10000000){
			arr_fivemill_tenmill.push(price);
		}
	});

	allRanges = [];
	priceFilterHtml = "";

	if(arr_zero_fiftho.length){
		momentRange = rangeMaker(arr_zero_fiftho, 0, 10000, 50000, 10000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_fiftho_hundtho.length){
		momentRange = rangeMaker(arr_fiftho_hundtho, 50000, 75000, 100000, 25000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_hundtho_twohundtho.length){
		momentRange = rangeMaker(arr_hundtho_twohundtho, 100000, 150000, 200000, 50000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_twohundtho_fivehundtho.length){
		momentRange = rangeMaker(arr_twohundtho_fivehundtho, 200000, 300000, 500000, 100000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_fivehundtho_onemill.length){
		momentRange = rangeMaker(arr_fivehundtho_onemill, 500000, 750000, 1000000, 250000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_onemill_twomill.length){
		momentRange = rangeMaker(arr_onemill_twomill, 1000000, 1250000, 2000000, 250000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_twomill_fivemill.length){
		momentRange = rangeMaker(arr_twomill_fivemill, 2000000, 3000000, 5000000, 1000000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}
	if(arr_fivemill_tenmill.length){
		momentRange = rangeMaker(arr_fivemill_tenmill, 5000000, 7500000, 10000000, 2500000);
		momentRange.forEach(function(e){
			allRanges.push(e);
		});
	}

	console.log("priceRangeObj from get ranges: ", priceRangeObj);
	tempArr = sortArray(allRanges, priceRangeObj);
	priceFilterHtml += writeRangeCheckbox(tempArr, priceRangeObj);

	return priceFilterHtml;
}

function rangeMaker(rangeArray, trackerStart, rangeStart, rangeEnd, rangeIncrement){
	mainRangeArr = [];
	for (var i = rangeStart; i <= rangeEnd; i += rangeIncrement) {
		subArray = [];
		subArray["qty"] = 0;
		subArray["start"] = trackerStart;
		subArray["end"] = i;

		rangeArray.forEach(function(value){
			if(value >= trackerStart && value < i){
				subArray["qty"] += 1;
			}
		});

		trackerStart = i;
		if(subArray["qty"] > 0){
			mainRangeArr.push(subArray);
		}
	}
	return mainRangeArr;
}

function writeRangeCheckbox(rangeArr, priceRangeObj){
	rangeHtml = "";

	if (!(rangeArr === undefined || rangeArr.length == 0)){
		rangeArr.forEach(function(range){
			start = decimalSeparator(range['start']);
			end = decimalSeparator(range['end']);
			checkedBool = range["checked"];
			checked = "";

			if(checkedBool){
				checked = "checked";
			}

			rangeHtml += "<div>";
			rangeHtml += 	`<input type='checkbox' name='pricerange-${range['start']}-${range['end']}' value='${range['start']}' class='pricerange-filter grab-filter' min='${range['start']}' max='${range['end']}' filter-type='price' ${checked} qty='${range['qty']}'>`;
			rangeHtml += 	`<span> \$${start} - \$${end} (${range['qty']})</span>`;
			rangeHtml += "</div>";
			checked = "";

		});
	}
	return rangeHtml;
}

function sortArray(inpArr, priceRangeObj){
    newArr = [];
    inpArr.forEach(function(e){
        newArr.push([parseInt(e["start"], 10), parseInt(e["end"], 10), e["qty"].toString()]);
    });
    console.log("priceRangeObj: ", priceRangeObj);

    if(priceRangeObj != undefined){ //prevents error when all checkboxes are cleared
    	priceRangeObj.forEach(function(e){
    		console.log("e: ", e);
    		newArr.push([parseInt(e[0], 10), parseInt(e[1], 10), e[2].toString()]);
    	});
    }

    var uniques = [];
    var itemsFound = {};

    for(var i = 0, l = newArr.length; i < l; i++) {
        var stringified = newArr[i][0];
        if(itemsFound[stringified]) { continue; }

        start = newArr[i][0];
        end = newArr[i][1];
        qty = newArr[i][2];
        checked = false;

        subArray = [];
        subArray["checked"] = checked;
		subArray["start"] = start;
		subArray["end"] = end;
		subArray["qty"] = qty;

        uniques.push(subArray);
        itemsFound[stringified] = true;
    }

    if(priceRangeObj != undefined){ //prevents error when all checkboxes are cleared
    	uniques.forEach(function(e){
    	    priceRangeObj.forEach(function(f){
    	        if(e["start"] == f[0] && e["end"] == f[1])
    	        {
    	            e["checked"] = true;
    	        }
    	    })
    	});
    }

    uniques.sort(sortFunction);
    return uniques;
}

function sortFunction(a, b) {
    if (a["start"] === b["start"]) {
        return 0;
    }
    else {
        return (a["start"] < b["start"]) ? -1 : 1;
    }
}


// ---------------END PRICE RANGE FILTER ----------------------------------

function renderConditionFilter(newGameArr, usedGameArr, filterControl){
	conditionHtml = "";
	newCounter = 0;
	usedCounter = 0;

	isNewChecked = false;
	isUsedChecked = false;

	if(filterControl.condition.length > 0){
		filterControl.condition.forEach(function(e){
			if(e[0] == "nuevo"){
				isNewChecked = true;
				
			}
			if(e[0] == "usado"){
				isUsedChecked = true;

			}
		});
	}

	checkNew = "";
	checkUsed = "";

	usedDisabled = "";
	newDisabled = "";


	if(newGameArr == undefined && usedGameArr == undefined){
		return "";
	}

	console.log("newGameArr: ", newGameArr);
	newGameArr.forEach(function(e){
		if(e > 0){
			newCounter ++;
		}
	});

	console.log("usedGameArr: ", usedGameArr);
	usedGameArr.forEach(function(e){
		if(e > 0){
			usedCounter ++;
		}
	});
	// if(usedCounter == 0){
	// 	newDisabled = "disabled";
	// }
	// if(newCounter == 0){
	// 	usedDisabled = "disabled";
	// }
	if(isNewChecked){
		checkNew = "checked";
	}
	if(isUsedChecked){
		checkUsed = "checked";
	}
	console.log("newCounter: ", newCounter);
	if(newCounter > 0){
		conditionHtml += "<div>";
		conditionHtml +=	`<input type='checkbox' name='condition-new' filter-name='new' class='condition-filter grab-filter ${newDisabled}' condition='nuevo' filter-type='condition' qty='${newCounter}' ${newDisabled} ${checkNew} >`;
		conditionHtml +=	"<span> Nuevo ("+newCounter+")</span>"
		conditionHtml += "</div>";
	}
	console.log("usedCounter: ", usedCounter);
	if(usedCounter > 0){
		conditionHtml += "<div>";
		conditionHtml +=	`<input type='checkbox' name='condition-used' filter-name='used' class='condition-filter grab-filter ${usedDisabled}' condition='usado' filter-type='condition' qty='${usedCounter}' ${usedDisabled} ${checkUsed} >`;
		conditionHtml +=	"<span> Usado ("+usedCounter+")</span>"
		conditionHtml += "</div>";
	}
	return conditionHtml;

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
			productTypeHTML += 	`<input type='checkbox' name='producttype-${key}' value='${productTypeObj[key]}' class='producttype-filter grab-filter' filter-name='${key}' filter-type='producttype' qty='${productTypeObj[key]}' ${checked}>`;
			productTypeHTML += 	`<span>${key} (${productTypeObj[key]})</span>`;
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

	studioObjKeys = Object.keys(studioObj);
	queryObj.forEach(function(e){
		if(!studioObjKeys.includes(e)){
			studioObj[e] = 0;
		};
	});

	for (var key in studioObj) {
		checked = "";
		if(queryObj.includes(key)){
			checked = "checked";
		}
	    if(studioObj.hasOwnProperty(key)) {
	        productStudioHtml += "<div>";
	        productStudioHtml += 	`<input type='checkbox' name='${key}' value='${studioObj[key]}' class='studio-filter grab-filter' filter-type='studio' qty='${studioObj[key]}' ${checked}>`;
	        productStudioHtml += 	"<span> "+ key +" (" + studioObj[key] + ")</span>";
	        productStudioHtml += "</div>";
	    }
	}
	return productStudioHtml;
}
// FILTER RENDERING FUNCTIONS END HERE !!!!!!!!!!!!!!!!!!!!!------------------------

// AUXILIARY FUNCTIONS START HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// function to render pagination
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
	selected = "";


	paginationHtml += `<a href='#' class='selectpage pagination-previous' pageoffset='${previousPage}'><i class='fas fa-caret-left'></i> Previo &nbsp;</a>`;
	paginationHtml += "<div class='pagination-pages'>";
	for (var i = 1; i <= numOfPages; i++ ){
		pageOffset = (i - 1) * productsPerPage;

		if(pageOffset == currentPage){
			selected = " selected-page";
		}
		paginationHtml += `<a href='#' class='selectpage ${selected}' pageoffset='${pageOffset}'> ${i} </a>`;
		selected = "";
	}
	paginationHtml += "</div>";
	paginationHtml += `<a href='#' class='selectpage pagination-next' pageoffset='${nextPage}'>&nbsp; Siguiente <i class='fas fa-caret-right'></i></a>`;
	return paginationHtml;
}

function decimalSeparator(x) {
return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	// return x.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function ajaxZeroBoxChecked(filterParams, productsPerPage){
	$.ajax({
		url: "/gameliquidators/includes/product-fetcher.php",
		method:"POST",
		dataType:"json",
		contentType:"application/json; charset=utf-8",
		data: JSON.stringify(filterParams),
		success:function(data){
			console.log(data);
			$(".basic-search-cont").empty();
			$(".basic-search-cont").prepend(genFilterProductsHtml(data));

			$(".pagination").empty();
			$(".pagination").prepend(genPagination(data, productsPerPage));

			$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count, filterParameters.queries.pricerange));

			$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count, filterParameters.queries));

			$("#studioFilterContainer").empty().prepend(renderStudioFilter(data.studio, filterParameters.queries.studio));

			// if(filterType == "studio"){
			// 	if(filterType != "price"){
			// 		$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count, filterParameters.queries.pricerange));
			// 	}
			// 	if(filterType != "condition"){
			// 		$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count, filterParameters.queries));
			// 	}

			// 	$("#studioFilterContainer").empty().prepend(renderStudioFilter(data.studio, filterParameters.queries.studio));
			// }
			// if(filterType == "condition"){
			// 	$("#priceFilterContainer").empty().prepend(renderPriceFilter(data.price_new_count, data.price_used_count, filterParameters.queries.pricerange));

			// 	$("#conditionFilterContainer").empty().prepend(renderConditionFilter(data.new_count, data.used_count, filterParameters.queries));

			// 	$("#studioFilterContainer").empty().prepend(renderStudioFilter(data.studio, filterParameters.queries.studio));
			// }

		},
		error: function (request, status, error) {
		    alert(error);
		}
	});
}