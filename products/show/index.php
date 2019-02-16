<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';

if(isset($_SESSION['username'])){
    // echo "session started username: ".$_SESSION['username'];
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
$product_id = $_GET["id"];
// echo $platform;
$sql = "SELECT * FROM products WHERE id = '$product_id' ";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div id='game container'>";
        echo    "<div>";
        echo        "id: {$row['id']} - name: {$row['title']} - {$row['platform']}";
        echo        "<a href='{$doc_root}/products/show/?id={$row['id']}' > Ver </a>";
                    if(isset($_SESSION['username'])){
                    // echo "<a href='{$doc_root}/admin/edit.php?id={$row['id']}' > Edit </a>";
                        echo "<a href='{$doc_root}/admin/edit/?id={$row['id']}' > Editar </a>";
                    }
        echo    "</div>";
        echo "</div>";
    }
} else {
    echo "0 results";
}


$conn->close();

?>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<script type="text/javascript">
</script>
</body>
</html>