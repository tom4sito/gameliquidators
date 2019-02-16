<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>main page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/all.min.css">

	

	<style type="text/css">
		body{
		    font-family: Arail, sans-serif;
		}
		/* Formatting search box */
		.search-box-reporte{
		    width: 300px;
		    position: relative;
		    display: inline-block;
		    font-size: 14px;
		}
		.search-box-reporte input[type="text"]{
		    height: 32px;
		    padding: 5px 10px;
		    border: 1px solid #CCCCCC;
		    font-size: 14px;
		}
		.result-reporte{
		    position: absolute;        
		    z-index: 999;
		    /*top: 100%;*/
		    left: 0;
		    background-color: #fff;
		}
		.search-box-reporte input[type="text"], .result-reporte{
		    width: 100%;
		    box-sizing: border-box;
		}
		/* Formatting result items */
		.result-reporte p{
		    margin: 0;
		    padding: 7px 10px;
		    border: 1px solid #CCCCCC;
		    border-top: none;
		    cursor: pointer;
		}
		.result-reporte p:hover{
		    background: #f2f2f2;
		}

		.delete-product {
		    color: #ee4338;
		    cursor: pointer;
		    font-size: 20px;
		}

		/*---------------------*/
		.search-box-float{
			overflow: hidden;
			padding-right: .5em;
		}
		#producttype{
			float: right;
		}

		.rep-prod-img img{
			width: 101px;
			height: 124px;
		}
		.prod-info{
			margin-bottom: 6px;
		}
		.prod-info input[type=number]{
			width: 35%;
		}
		/*-------status styling-----------*/
		.warning{
			/*background-color: red;*/
			border-color: red;
		}

		/*font awesome icons---------------*/
		.fa-trash {
		    margin-left: 6px;
		    vertical-align: 0px;
		}
	</style>
</head>
<body>
<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
$report_status = "";
$report_notes= "";
$report_date = "";
// $report_id_post = "";

if(isset($_POST['updatereport'])){
	require $db_connect;

	// array of added products in sale report
	$numberOfProducts = sizeof($_POST['product_id']);
	$product_counter = 0;

	checkEmptyFields($product_counter, $numberOfProducts);


	$notes = $_POST['notes'];
	$date = $_POST['datepicker'];
	$report_id_post = $_POST['reportid'];
	$status = $_POST['report-status'];
	// $sql = "INSERT INTO sale_report (status, notes, created_at) VALUES('pending', '$notes', '$date')";
	$sql_update_report = "UPDATE sale_report 
	SET status='$status', notes='$notes', created_at='$date'
	WHERE id=$report_id_post";

	if ($conn->query($sql_update_report) === TRUE) {
		// $last_id = $conn->insert_id;
	    echo "sale record updated successfully";

	    for ($x = $product_counter; $x < $numberOfProducts; $x++) {
	    	$qty = 0;
	    	$salePrice = 0;
	    	$condition = "";
	    	$productId = 0;
// ---------------------------------------------
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

	    	$product_sel_sql = "SELECT * FROM product_in_report 
	    	WHERE report_id = '$report_id_post' 
	    	AND product_id = '$productId' ";


	    	$result = mysqli_query($conn, $product_sel_sql);
	    	if(mysqli_num_rows($result) > 0){
	    		$prod_row = mysqli_fetch_assoc($result);
	    		$last_prod_id = $prod_row['id'];

	    		$prod_updt_sql = "UPDATE product_in_report 
	    		SET quantity = '$qty', product_condition = '$condition', sale_price = '$salePrice'
	    		WHERE id='$last_prod_id ' ";

	    		if(!mysqli_query($conn, $prod_updt_sql)){
	    			header("Location: ../?message=error on update");
	    			die();
	    		}
	    	}
	    	else{
	    		$prod_updt_sql = "INSERT INTO product_in_report
	    		(report_id, product_id, quantity, product_condition, sale_price)
	    		VALUES ($report_id_post, $productId, $qty, '$condition', $salePrice)";

	    		// echo $prod_updt_sql;
	    		if(!mysqli_query($conn, $prod_updt_sql)){
	    			header("Location: ../?message=error on product insert");
	    			die();
	    		}
	    	}
	    }

	    header("Location: ../?message=successful update");
	    die();


	} else {
	    echo "Error: " . $sql_update_report . "<br>" . $conn->error;
	}
}

function renderSaleReport($connection, $report_id){
	$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/';
	$samplevar = "good bye";

	$sql_report_info = "SELECT * FROM sale_report WHERE id = $report_id";
	// echo $sql_report_info;
	$result_report_info = mysqli_query($connection, $sql_report_info);
	if(mysqli_num_rows($result_report_info) > 0){
		$row_report_info = mysqli_fetch_assoc($result_report_info);
		global $report_date, $report_status, $report_notes;
		$report_date = $row_report_info["created_at"];
		$report_status = $row_report_info["status"];
		$report_notes = $row_report_info["notes"];
	}

	$sql = "SELECT * FROM product_in_report 
	WHERE report_id =  $report_id";

	$result = mysqli_query($connection, $sql);

	if(mysqli_num_rows($result) > 0){
		foreach ($result as $key => $product) {
			// echo "<p> {$value['product_condition']} </p>";
			$product_id = $product['product_id'];

			$product_sql = "SELECT products.title, products.platform, images_table.image_name 
			FROM products LEFT JOIN images_table 
			ON products.id=images_table.product_id WHERE products.id = $product_id";

			// echo $product_sql;
			// die();

			$result_product = mysqli_query($connection, $product_sql);

			if(mysqli_num_rows($result_product) > 0){
				foreach ($result_product as $key => $value) {
					$product_platform = $value['platform'];
					$product_title = $value['title'];
					$product_price = $product['sale_price'];
					$product_qty = $product['quantity'];

					if($product['product_condition'] == 'usado'){
						$product_conditions = "<option value='usado' selected='selected'>usado</option>";
						$product_conditions .= "<option value='nuevo'>nuevo</option>";
					}
					else{
						$product_conditions = "<option value='usado'>usado</option>";
						$product_conditions .= "<option value='nuevo' selected='selected'>nuevo</option>";
					}

					if(is_null($value['image_name'])){
						$image_src = $url . "empty.gif";
					}
					else{
						$image_src = $url . $value['image_name'];
					}
					echo "<div class='row'>";
					echo 	"<div class='col-auto rep-prod-img'>";
					echo 		"<img src='$image_src' width='57' height='71'> <br>";
					echo 		"<h4 class='delete-product'>remover <i class='fas fa-trash fa-xs'></i></h4>";
					echo 	"</div>";
					echo 	"<div class='col-auto'>";
					echo 		"<p class='prod-info' product_id='$product_id'>{$product_platform}: $product_title</p>";
					echo 		"<p class='prod-info'>Cantidad: <input type='number' maxlength='4' value='$product_qty' ";
					echo 		"name='qty[]' class='qty' min='1'><span class=''></span></p>";
					echo 		"<p class='prod-info'>Precio: <input type='text' maxlength='8' name='price[]' ";
					echo 		"class='price' value='$product_price'><span class=''></span></p> ";
					echo 		"<select name='condition[]'>";
					echo 			"$product_conditions";
					echo 		"</select>";
					echo 		"<input type='hidden' name='product_id[]' value='{$product_id}'>";
					echo 	"</div>";
					echo "</div>";
				}
			}

		}
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
	<?php include '../../../../includes/navbar.php'; ?>
	<h1>Crear Reporte de Ventas</h1>
	<h5>Encuentra el producto para agregar al reporte</h5>
	<div class="row">
		<div class="search-box-reporte col-12 col-md-6">

	<!-- 		<button class="btn btn-danger" id="producttype" class="">buscar</button>-->
			<select id="producttype" >
				<option>Videojuego</option>
				<option>consola</option>
				<option>accesorio</option>
			</select>
			<div class="search-box-float">

				<input class="search-box-float" cur_prod_id="" type="text" autocomplete="off" placeholder="Search country..." />
			</div>
			
			<div class="result-reporte" id="result-reporte"></div>
		</div>
		<div class="added-products-panel col-12 col-md-6">

			<h2>Productos Agregados</h2>
			<form method="post" action="" name="saleReportForm" id="saleReportForm">
				<div id="added-products">
					<?php
					if(isset($_GET['reportid'])){
						require $db_connect;
						$reportid = $_GET['reportid'];
						renderSaleReport($conn, $reportid);
					}
					
					?>
				</div>
				<div class="report-sale-div">
					Total: <span class="total-sale">0</span>
				</div>
				<label>Fecha del Reporte</label>
				<input type="text" id="datepicker" name="datepicker" autocomplete="off" value="<?php echo $report_date; ?>">
				<span class=''></span><br>

				<label>Estatus del reporte</label>
				<select id="reporstatus" name="report-status">
					<?php
					if($report_status == "pendiente"){
						echo "<option selected='selected' value='pendiente'>pendiente</option>";
						echo "<option value='aprobado'>aprobado</option>";
					}
					else{
						echo "<option value='pendiente'>pendiente</option>";
						echo "<option selected='selected' value='aprobado'>aprobado</option>";
					}
					?>
				</select><br>

				<label>Notas:</label>
				<textarea rows="3" cols="30" name="notes" id="notes"><?php echo $report_notes; ?></textarea>
				<br>
				<input type="hidden" name="reportid" value="<?php echo $reportid; ?>">
				<input type="submit" name="updatereport" value="actualizar">
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
	// adds the total as soon as page is loaded
	addTotal();
	// dynamic search by typing
    $('.search-box-reporte input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var producttype = $("#producttype").val();
        var resultDropdown = $("#result-reporte");
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
    $(document).on("click", ".result-reporte p", function(){
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
        $(this).parent(".result-reporte").empty();
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

</body>
</html>