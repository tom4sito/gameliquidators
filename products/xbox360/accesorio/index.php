<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';

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

createProductList($conn, 'xbox 360', 'accesorio', $doc_root);
$conn->close();

?>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript">
</script>
</body>
</html>