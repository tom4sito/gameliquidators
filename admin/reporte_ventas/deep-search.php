<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$db_connect = $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/db_connect.php';
require $db_connect;

// $link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
// if($link === false){
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE title LIKE ? LIMIT 3";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%'.$_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $sql_image = "SELECT image_name 
                    FROM images_table 
                    WHERE product_id = '{$row['id']}' ";

                    // echo $sql_image;
                    $result_img = mysqli_query($conn, $sql_image);
                    $url = "http://localhost/images/";
                    if(mysqli_num_rows($result_img) > 0){
                        while ($row_img = mysqli_fetch_assoc($result_img)) {
                            echo "<p productid='{$row['id']}'> {$row['title']} => {$row['platform']}";
                            echo "<img src='$url{$row_img['image_name']}'  width='100' height='100'>";
                            echo "</p>"; 
                        }
                    }
                    else{
                        echo "<p productid='{$row['id']}'> {$row['title']} => {$row['platform']}</p>";
                    }

                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($conn);
?>
