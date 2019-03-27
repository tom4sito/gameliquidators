<?php
function createProductList($dbConn, $platform, $productType, $docRoot){
	$sql = "SELECT * FROM products WHERE platform = '$platform' AND product_type = '$productType' ";
	$result = $dbConn->query($sql);

	$platform = str_replace(" ", "", $platform);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        echo "<div id='game container'>";
	        echo    "<div>";
	        echo        "id: {$row['id']} - name: {$row['title']} - {$row['platform']}";
	        echo        "<a href='{$docRoot}/products/{$platform}/{$productType}/show/?id={$row['id']}' > Ver </a>";
	                    if(isset($_SESSION['username'])){
	                        echo "<a href='{$docRoot}/admin/edit/?id={$row['id']}' > Editar </a>";
	                    }
	        echo    "</div>";
	        echo "</div>";
	    }
	} else {
	    echo "0 results";
	}
}

?>