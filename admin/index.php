<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$includes_dir = $doc_root.'/gameliquidators/includes/'; 
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
	<div><p><a href="<? echo $doc_root."/admin/create.php" ?>">Create</a></p></div>
	<div><p><a href="<? echo $doc_root."/admin/edit.php" ?>">Edit</a></p></div>
	<div><p><a href="">Delete</a></p></div>
	<?php echo $doc_root ?>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
</body>
</html>