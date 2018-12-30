<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$skuid = $_POST['skuid'];
$product_type = $_POST['product_type'];
$title = $_POST['product_title'];
$quantity_new = $_POST['qty_new'];
$quantity_used = $_POST['qty_used'];
$platform = $_POST['product_platform'];
$studio = $_POST['studio'];
$description = $_POST['description'];
// $product_condition = $_POST['product_condition'];
$price_new = $_POST['price_new'];
$price_used = $_POST['price_used'];
// $purchase_price = $_POST['purchase_price'];

// echo $skuid, $product_type, $title, $quantity, $platform, $studio, $description, $product_condition, $price_new, $price_used;
$upload_image=$_FILES["myimage"][ "name" ];

$sql = "INSERT INTO products (skuid, product_type, title, quantity_new, quantity_used, platform, studio, description, price_new, price_used) VALUES ('$skuid', '$product_type', '$title', '$quantity_new', '$quantity_used', '$platform', '$studio', '$description', '$price_new', '$price_used')";

if ($conn->query($sql) === TRUE) {
    echo "New product record created successfully: image name: ".$upload_image;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$folder = "/Applications/XAMPP/htdocs/images/";

move_uploaded_file($_FILES["myimage"]["tmp_name"], "$folder".$_FILES["myimage"]["name"]);

$product_id = $conn->insert_id;
$insert_path="INSERT INTO images_table (product_id, folder, image_name) VALUES('$product_id', '$folder', '$upload_image')";

 // echo $conn->insert_id;
if ($conn->query($insert_path) === TRUE) {
    echo "New image record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// echo "Connected successfully";
?>