<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$db_connect = $doc_root.'/gameliquidators/includes/db_connect.php';
require $db_connect;

$skuid = $_POST['skuid'];
$product_type = $_POST['product_type'];
$title = $_POST['product_title'];
$quantity_new = $_POST['qty_new'];
$quantity_used = $_POST['qty_used'];
$platform = $_POST['product_platform'];
$studio = $_POST['studio'];
$description = $_POST['description'];
$product_condition = $_POST['product_condition'];
$price_new = $_POST['price_new'];
$price_used = $_POST['price_used'];
$product_id = $_POST['product_id'];
echo "id del producto: ".$product_id;

$sql = "UPDATE products SET skuid='$skuid', product_type='$product_type', title='$title',
quantity_new ='$quantity_new', quantity_used ='$quantity_used', platform='$platform', studio='$studio', description='$description',
product_condition='$product_condition', price_new='$price_new', price_used='$price_used' WHERE 
id=$product_id ";

if($conn->query($sql) === TRUE) {
	echo "product updated successfully";
}
else {
	echo "Error: ". $sql . "<br>" . $conn->error;
}

$conn->close();
?>