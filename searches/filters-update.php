<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$json_str = file_get_contents('php://input'); //gets json data from POST AJAX
$decoded_data = json_decode($json_str, true);

// create SQL SELECT query ----------------------
$sql = "SELECT * FROM products WHERE ";
$sql_count = "SELECT count(id) FROM products WHERE ";

$sql .= "title LIKE '{$decoded_data['queries']['basic']}%' ";
$sql_count .= "title LIKE '{$decoded_data['queries']['basic']}%' ";



$returnedHtml = json_encode("{'sql':{$sql}}");
echo $returnedHtml; 
?>