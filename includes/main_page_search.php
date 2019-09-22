<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

$root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . "/gameliquidators/";
 
if(isset($_REQUEST["term"])){
    $live_product["products"] = array();
    // Set parameters
    $param_term = '%'.$_REQUEST["term"].'%';
    // $param_product = $_REQUEST["type"];

    $sql = "SELECT * FROM products 
    WHERE title LIKE ? LIMIT 6";

    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $sql_image = "SELECT image_name 
                    FROM images_table 
                    WHERE product_id = '{$row['id']}' 
                    AND image_name LIKE '%_thumb1%' ";

                    // echo $sql_image;
                    $result_img = mysqli_query($conn, $sql_image);
                    $product_url = $root_url . $row['product_url'] . "/?id=" . $row['id'];
                    // $url = "http://localhost/images/";
                    if(mysqli_num_rows($result_img) > 0){
                        while ($row_img = mysqli_fetch_assoc($result_img)) {
                            $temp_live_product = array("id"=>$row['id'],
                                "platform"=>$row['platform'],
                                "product_name"=>$row['title'],
                                "product_type"=>$row['product_type'],
                                "product_url"=>$product_url,
                                "product_image"=>$row_img['image_name']);
                            // echo "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>";
                            // echo "<a href='http://www.n4g.com' class='live-product'>";
                            // echo "<img src='$url{$row_img['image_name']}' width='57' height='71' class='img-float'>";
                            // echo "<span class='no-wrap'>{$row['platform']}: {$row['title']}</span></a></p>"; 
                        }
                    }
                    else{
                        $temp_live_product = array("id"=>$row['id'],
                            "platform"=>$row['platform'],
                            "product_name"=>$row['title'],
                            "product_type"=>$row['product_type'],
                            "product_url"=>$product_url,
                            "product_image"=>"unavailable_thumb.jpg");
                            // echo "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>";
                            // echo "<img src='{$url}unavailable_thumb.jpg'  width='57' height='71' class='img-float'>";
                            // echo "<span class='no-wrap'>{$row['platform']}: {$row['title']}</span></p>"; 

                    }
                    $live_product["products"][] = $temp_live_product;
                    $live_product["result"] = True;
                    $live_product["error"] = False;
                }
            } else{
                // echo "<p>No matches found</p>";
                $live_product["result"] = False;
            }
        } else{
            // echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
            $live_product["error"] = True;
        }
        $returnedJson = json_encode($live_product);
        echo $returnedJson;
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($conn);
?>
