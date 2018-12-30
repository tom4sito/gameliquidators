<?php
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$product_id = $_GET['id'];

echo "product id: ".$product_id." <br>";
$sql = "DELETE FROM products where id='$product_id' ";

//delete product images query
$del_img_sql = "DELETE from images_table WHERE product_id='$product_id' ";

// selects img(s) query
$sel_img_sql = "SELECT * from images_table WHERE product_id='$product_id' ";

if($conn->query($sql) == TRUE){
	echo "product successfully deleted from product table.";

	$result = $conn->query($sel_img_sql);

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$path = $row['folder'].$row['image_name'];
			echo "path: ".$path." printed with path var<br>";
			if(!unlink($path)){
				echo "error deleting file: ".$path."<br>";
			}
			else{
				echo "success deleting img file from directory: ".$path."<br>";

				// deletes rows from image table
				if($conn->query($del_img_sql) == TRUE){
					echo "product image row(s) deleted from image table";
				}
				else{
					echo "ERROR: ".$del_img_sql."<br>".$conn->error;
				}
			}
		}
	}
	else{
		echo "0 results";
	}
}
else{
	echo "ERROR: ".$sql."<br>".$conn->error;
}






$conn->close();
?>