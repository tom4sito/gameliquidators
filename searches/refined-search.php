<?php 
session_start();
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;
$basic = $_POST['basic'];
$extra = $_POST['extra'];

echo $basic . " " . $extra;
?>