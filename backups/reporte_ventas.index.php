
<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';

if(isset($_POST['createreport'])){
	require $db_connect;

	$numberOfProducts = sizeof($_POST['product_id']);
	$product_counter = 0;

	checkEmptyFields($product_counter, $numberOfProducts);


	$notes = $_POST['notes'];
	$date = $_POST['datepicker'];
	$sql = "INSERT INTO sale_report (status, notes, created_at) VALUES('pending', '$notes', '$date')";

	if ($conn->query($sql) === TRUE) {
		$last_id = $conn->insert_id;
	    echo "New sale record created successfully";

	    for ($x = $product_counter; $x < $numberOfProducts; $x++) {
	    	$qty = 0;
	    	$salePrice = 0;
	    	$condition = "";
	    	$productId = 0;

	    	foreach ($_POST as $key => $value) {
	    		switch ($key) {
	    		    case "qty":
	    		        $qty = $value[$product_counter];
	    		        break;
	    		    case "price":
	    		        $salePrice = $value[$product_counter];
	    		        break;
	    		    case "condition":
	    		        $condition = $value[$product_counter];
	    		        break;
	    		    case "product_id":
	    		        $productId = $value[$product_counter];
	    		        break;
	    		}
	    	}
	    	$product_counter++;

	    	$prod_sql = "INSERT INTO product_in_report 
	    	(report_id, product_id, quantity, product_condition, sale_price)
	    	VALUES ($last_id, $productId, $qty, '{$condition}', $salePrice)";

	    	echo $prod_sql."<br>";

	    	if ($conn->query($prod_sql) === TRUE) {
	    		echo "created new product in report record";
	    	}

	    }

	    header("Location: ../");
	    die();


	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

function checkEmptyFields($product_counter, $numberOfProducts){
	for ($x = $product_counter; $x < $numberOfProducts; $x++){
		foreach ($_POST as $key => $value) {
			if(($key == "qty") && empty($value[$product_counter])){
				header("Location: ./?message=err-qty");
				die();
			}
			if(($key == "price") && empty($value[$product_counter])){
				header("Location: ./?message=err-price");
				die();
			}
		}
		$product_counter++;
	}
	if(empty($_POST['datepicker'])){
		header("Location: ./?message=err-datepicker");
		die();
	}
}
?>


<div>
	<?php include '../../includes/navbar.php'; ?>
	<h1>Crear Reporte de Ventas</h1>
	<h5>Encuentra el producto para agregar al reporte</h5>
	<div class="row">
		<div class="search-box col-12 col-md-6">

	<!-- 		<button class="btn btn-danger" id="producttype" class="">buscar</button>-->
			<select id="producttype" >
				<option>Videojuego</option>
				<option>consola</option>
				<option>accesorio</option>
			</select>
			<div class="search-box-float">

				<input class="search-box-float" cur_prod_id="" type="text" autocomplete="off" placeholder="Search country..." />
			</div>
			
			<div class="result" id="result"></div>
		</div>
		<div class="added-products-panel col-12 col-md-6">

			<h2>Productos Agregados</h2>
			<form method="post" action="" name="saleReportForm" id="saleReportForm">
				<div id="added-products">
					
				</div>
				<div class="report-sale-div">
					Total: <span class="total-sale">0</span>
				</div>
				<label>Fecha del Reporte</label>
				<input type="text" id="datepicker" name="datepicker" autocomplete="off">
				<span class=''></span><br>
				<label>Notas</label>
				<textarea rows="3" cols="30" name="notes" id="notes"></textarea>
				<br>
				<input type="submit" name="createreport" value="crear">
			</form>

		</div>
	</div>


</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/all.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/datepicker-es.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	// dynamic search by typing
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var producttype = $("#producttype").val();
        var resultDropdown = $("#result");
        console.log(producttype);
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal, type:producttype}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });

    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        var product_image = $(this).find("img")[0];
        var product_info =  $(this).find("p").prevObject;
        var product_name = $(product_info).attr('product_name');
        var product_platform = $(product_info).attr('platform');
        var product_id = $(product_info).attr('productid');

        var product_row = "<div class='row'>";
        product_row +=			"<div class='col-auto rep-prod-img'>";
        product_row +=				$(product_image).prop('outerHTML');
        product_row +=				"<br>";
        product_row +=				"<h4 class='delete-product'>remover <i class='fas fa-trash fa-xs'></i></h4>";
        product_row +=			"</div>";
        product_row +=			"<div class='col-auto'>";
        product_row +=				`<p class='prod-info' product_id="${product_id}" >`+product_platform +": " +product_name+"</p>";
        product_row +=				"<p class='prod-info'>Cantidad: <input type='number' maxlength='4' value='1' name='qty[]' class='qty' min='1'><span class=''></span></p>";
        product_row +=				"<p class='prod-info'>Precio: <input type='text' maxlength='8' name='price[]' class='price'> <span class=''></span> </p>";
        product_row +=				"<select name='condition[]'>";
        product_row +=				"<option value='usado'>usado</option>";
        product_row +=				"<option value='nuevo'>nuevo</option>";
        product_row +=				"</select>";
        product_row +=				`<input type='hidden' name='product_id[]' value="${product_id}">`;
        product_row +=			"</div>";
        product_row +=    "</div>";

        $("#added-products").append($(product_row));
        $(this).parent(".result").empty();
    });

});

// update total when price is entered
$('#added-products').on("keyup", "input.price", function(){
	addTotal();
});

// updates total when quantity is changed
$("#added-products").on('change','input.qty',function(){
	addTotal();
});

function addTotal(){
	// $('#added-products input.price').each(function(){
	$('#added-products').each(function(){
		var totalPoints = 0;
		$(this).find('input.price').each(function(){

			var priceParent = $(this).parent();
			// console.log(priceParent);

			var prodPrev = priceParent.siblings();
			currQty = $(prodPrev[1].children[0]).val(); 
			console.log("current quantity: " + currQty);

			// var currentPoints = parseInt($(this).val());
			var currentPoints = parseInt($(this).val()) * parseInt(currQty);
			if(!currentPoints){
				totalPoints += 0;
			}
			else{
				totalPoints += currentPoints; //<==== a catch  in here !! read below
			}
		});
		// alert(totalPoints);
		$(".total-sale").text(totalPoints);
	});
	// console.log(myprices);
}

$("#added-products").on("click", ".delete-product", function(){
	console.log($(this).closest(".row").remove());
	addTotal();
});

$( "#datepicker" ).datepicker($.datepicker.regional[ "es" ]);


$('#saleReportForm').on('submit', function(event){
	$('input[name^="qty"]').each(function() {
		if($(this).val() <= 0){
			event.preventDefault();
			console.log($(this).next().text("seleciona 1 o mas"));
			$(this).addClass("warning");
		}
	});
	$('input[name^="price"]').each(function() {
		if($(this).val() == ""){
			event.preventDefault();
			console.log($(this).next().text("olvidaste poner el precio"));
			$(this).addClass("warning");
		}
	});

	if($("#datepicker").val() == ""){
		event.preventDefault();
		console.log($("#datepicker").next().text("olvidaste poner la fecha"));
		$("#datepicker").addClass("warning");

	}
});
</script>

