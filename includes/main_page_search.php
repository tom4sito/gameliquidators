<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;
 
if(isset($_REQUEST["term"])){
    // Set parameters
    $param_term = '%'.$_REQUEST["term"].'%';
    // $param_product = $_REQUEST["type"];

    $sql = "SELECT * FROM products 
    WHERE title LIKE ? LIMIT 10";

    
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
                    $url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/';
                    // $url = "http://localhost/images/";
                    if(mysqli_num_rows($result_img) > 0){
                        while ($row_img = mysqli_fetch_assoc($result_img)) {
                            // if(empty($row_img['image_name'])){
                            //     echo "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>{$row['platform']}: {$row['title']}";
                            //     echo "<img src='https://blog.springshare.com/wp-content/uploads/2010/02/nc-md.gif'  width='100' height='100'>";
                            //     echo "</p>"; 
                            // }
                            echo "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>";
                            echo "<img src='$url{$row_img['image_name']}' width='57' height='71' class='img-float'>";
                            echo "<span class='no-wrap'>{$row['platform']}: {$row['title']}</span></p>"; 
                        }
                    }
                    else{
                        // echo "<p productid='{$row['id']}'> {$row['platform']}: {$row['title']}</p>";
                            echo "<p productid='{$row['id']}' platform='{$row['platform']}' product_name='{$row['title']}'>";
                            echo "<img src='{$url}unavailable_thumb.jpg'  width='57' height='71' class='img-float'>";
                            echo "<span class='no-wrap'>{$row['platform']}: {$row['title']}</span></p>"; 

                    }

                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($conn);
?>
