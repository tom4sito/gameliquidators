<?php
$config = parse_ini_file("/Applications/XAMPP/xamppfiles/htdocs/db.ini");

// Create connection
$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
	// echo "connected to db successfully";
}


?>