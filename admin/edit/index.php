<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: /gameliquidators");
}
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$includes_dir = $doc_root.'/gameliquidators/includes/';
$db_connect = $doc_root.'/gameliquidators/includes/db_connect.php';
require $db_connect;

if(isset($_GET['id'])){
	$game_id = $_GET['id'];
}
else{
	header("Location: /gameliquidators");
}

$sql = "SELECT `skuid`, `product_type`, `title`, `quantity_new`, `quantity_used`,`platform`, `studio`, `description`, 
`product_condition`, `price_new`, `price_used` FROM `products` WHERE id='$game_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
}
else {
    echo "0 results";
}

$conn->close();
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
	<?php include($includes_dir."navbar.php"); ?>
	<div>
		<form action="../controllers/editproduct.php" method="POST" enctype="multipart/form-data">
			<div id="product_type_div">
				<label>Typo de producto:</label>
				<select id="product_type" name="product_type">
					<option>Videojuego</option>
					<option>Consola</option>
					<option>Accessorio</option>
				</select>
			</div>
			<div id="console_mac_id" class="no-display test-class">
				<label>direccion MAC:</label>
				<input type="text" name="console_mac" placeholder="entra la direccion mac">
			</div>

			<div id="qty_new_div">
				<label>Cantidad Nuevo: </label>
				<input type="text" name="qty_new"  placeholder="entra la cantidad" id="qty_new">
			</div>
			<div id="qty_used_div">
				<label>Cantidad Nuevo: </label>
				<input type="text" name="qty_used"  placeholder="entra la cantidad" id="qty_used">
			</div>

			<div id="title_div">
				<label>Titulo: </label>
				<input type="text" name="product_title"  placeholder="entra el titulo del producto" id="product_title">
			</div>

			<div id="platform_div">
				<label>Plataforma: </label>
				<select type="text" name="product_platform" id="product_platform">
					<option>PS4</option>
					<option>XBOX ONE</option>
					<option>PS3</option>
					<option>XBOX 360</option>
					<option>Nintendo Wii</option>
					<option>Nintendo Switch</option>
				</select>
			</div>

			<div id="studio_div">
				<label>Estudio: </label>
				<input type="text" name="studio"  placeholder="entra el estudio" id="studio">
			</div>

<!-- 			<div id="condition_div">
				<label>Condicion: </label>
				<input type="text" id="product_condition" placeholder="entra el precio nuevo" name="product_condition"><br>
			</div> -->

			<div id="description_div">
				<label>Descripcion: </label>
				<textarea type="text" name="description"  placeholder="entra el estudio" id="description">
				</textarea>
			</div>

			<div id="price_new_div">
				<label>Precio Nuevo: </label>
				<input type="text" id="price_new" placeholder="entra el precio nuevo" name="price_new"><br>
			</div>

			<div id="price_used_div">
				<label>Precio Usado: </label>
				<input type="text" id="price_used" placeholder="entra el precio usado" name="price_used"><br>
			</div>
			<div id="sku_div">
				<label>SKUID</label>
				<input type="text" name="skuid" id="skuid">
			</div>
			 <input type="hidden" id="product_id" name="product_id" value="<?php echo $game_id ?>">


			<!-- <input type="file" name="myimage"> -->

			<input type="submit" value="crear">

		</form>
		
	</div>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>

<script type="text/javascript">
$('#product_type').change(function() {
	var product_type = $('#product_type').val();
	if(product_type == 'Consola')
	{
		$('#console_mac_id').removeClass('no-display');

	}
	else {
		$('#console_mac_id').addClass('no-display');
	}
});

$('document').ready(function() {
	
	$('#product_type').val("<?php echo $row['product_type'] ?>");
	$('#qty_new').val("<?php echo $row['quantity_new'] ?>");
	$('#qty_used').val("<?php echo $row['quantity_used'] ?>");
	$('#product_title').val("<?php echo $row['title'] ?>");
	$('#product_platform').val("<?php echo $row['platform'] ?>");
	//$('#studio').val("<?php //echo $row['studio'] ?>");
	$('#product_condition').val("<?php echo $row['product_condition'] ?>");
	$('#description').val("<?php echo $row['description'] ?>");
	$('#price_new').val("<?php echo $row['price_new'] ?>");
	$('#price_used').val("<?php echo $row['price_used'] ?>");
	$('#skuid').val("<?php echo $row['skuid'] ?>");
});

</script>
</body>
</html>