<?php
function productExists($dbConn, $productId){
    $sql = "SELECT title FROM products WHERE id = $productId";
    $result = mysqli_query($dbConn, $sql);
    if(!(mysqli_num_rows($result) > 0)){
        header("Location: /gameliquidators");
    }
}

function createNavTree($dbConn, $productId, $root){
    $htmlNavTree = "";
    $sql = "SELECT p.title, p.platform, p.product_type, t.tag_name 
    FROM products as p 
    INNER JOIN product_tag as pt 
    ON p.id = pt.product_id 
    INNER JOIN tag as t 
    ON t.tag_id = pt.tag_id
    WHERE p.id = {$productId}";

    // echo $sql;

    $result = mysqli_query($dbConn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $row['platform'] = str_replace(" ", "", $row['platform']);
        $htmlNavTree .= "<a href='{$root}/products/{$row['platform']}' class='nav-tag'>{$row['platform']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href='{$root}/products/{$row['platform']}/{$row['product_type']}' class='nav-tag'>{$row['product_type']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href='{$root}/products/{$row['platform']}/{$row['product_type']}/{$row['tag_name']}' class='nav-tag'>{$row['tag_name']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href=''>{$row['title']}</a>";
        echo $htmlNavTree;
    }
    else{
        $sql = "SELECT title, platform, product_type
        FROM products WHERE id = {$productId}";

        $result = mysqli_query($dbConn, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
                    $row['platform'] = str_replace(" ", "", $row['platform']);
            $htmlNavTree .= "<a href='{$root}/products/{$row['platform']}' class='nav-tag'>{$row['platform']}</a><span class='nav-tree-carret'> / </span>";
            $htmlNavTree .= "<a href='{$root}/products/{$row['platform']}/{$row['product_type']}' class='nav-tag'>{$row['product_type']}</a><span class='nav-tree-carret'> / </span>";
            $htmlNavTree .= "<a href=''>{$row['title']}</a>";
            echo $htmlNavTree;
        }
    }
}

function createLeftContainer($dbConn, $productId){
    $htmlLeftContainer = "";
    $htmlMainImg = "";
    $htmlThumb1 = "";
    $htmlThumb2 = "";
    $htmlThumb3 = "";

    $sql = "SELECT * FROM images_table WHERE product_id = $productId";

    $result = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($result) > 0){
        foreach ($result as $value) {
            if(strpos($value['image_name'], '_1.') !== false){
                $htmlMainImg = $value['image_name'];
            }
            if(strpos($value['image_name'], 'thumb1') !== false){
                $htmlThumb1 = $value['image_name'];
            }
            if(strpos($value['image_name'], 'thumb2') !== false){
                $htmlThumb2 = $value['image_name'];
            }
            if(strpos($value['image_name'], 'thumb3') !== false){
                $htmlThumb3 = $value['image_name'];
            }
        }
    }

    if(empty($htmlMainImg)){$htmlMainImg = "unavailable_main.jpg";}
    if(empty($htmlThumb1)){$htmlThumb1 = "unavailable_thumb.jpg";}
    if(empty($htmlThumb2)){$htmlThumb2 = "unavailable_thumb.jpg";}
    if(empty($htmlThumb3)){$htmlThumb3 = "unavailable_thumb.jpg";}

    $htmlLeftContainer .= "<div class='row product-main-img'>";
    $htmlLeftContainer .=   "<div class='col-lg-12 col-md-12 product-img'>";
    $htmlLeftContainer .=       "<img src='/images/{$htmlMainImg}'>";
    $htmlLeftContainer .=   "</div>";
    $htmlLeftContainer .= "</div>";
    $htmlLeftContainer .= "<div class='row product-thumbs-cont'>";
    $htmlLeftContainer .=   "<div class='col-lg-4 col-md-4 col-sm-4 col-4 product-thumb product-thumb-sel'>";
    $htmlLeftContainer .=       "<img src='/images/{$htmlThumb1}'>";
    $htmlLeftContainer .=   "</div>";
    $htmlLeftContainer .=   "<div class='col-lg-4 col-md-4 col-sm-4 col-4 product-thumb'>";
    $htmlLeftContainer .=       "<img src='/images/{$htmlThumb2}'>";
    $htmlLeftContainer .=   "</div>";
    $htmlLeftContainer .=   "<div class='col-lg-4 col-md-4 col-sm-4 col-4 product-thumb'>";
    $htmlLeftContainer .=       "<img src='/images/{$htmlThumb3}'>";
    $htmlLeftContainer .=   "</div>";
    $htmlLeftContainer .= "</div>";

    echo $htmlLeftContainer;

}

function createRightContainer($dbConn, $productId){
    $htmlRightContainer = "";

    $product_title = "";
    $product_platform = "";
    $product_maker = "";
    $price_new = "";
    $price_used = "";
    $qty_new = "";
    $qty_used = "";

    $sql = "SELECT title, platform, studio, price_new, 
    price_used, quantity_new, quantity_used
    FROM products WHERE id = $productId";

    $result = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $product_title = $row['title'];
        $product_platform = $row['platform'];
        $product_maker = $row['studio'];
        $price_new = $row['price_new'];
        $price_used = $row['price_used'];
        $qty_new = $row['quantity_new'];
        $qty_used = $row['quantity_used'];

        if($qty_new == 0){ 
            $qty_new = "agotado"; 
        }
        else if($qty_new == 1) {
            $qty_new = $qty_new . " disponible"; 
        }
        else {
            $qty_new = $qty_new . " disponibles";
        }
        if($qty_used == 0){ 
            $qty_used = "agotado"; 
        }
        else if($qty_used == 1){
            $qty_used = $qty_used . " disponible";
        }
        else{
            $qty_used = $qty_used . " disponibles";
        }
    }

    $tag_sql = "SELECT tag_name FROM tag t1 
    INNER JOIN product_tag t2 
    ON t1.tag_id = t2.tag_id 
    AND t2.product_id = {$productId}";

    $tag = mysqli_query($dbConn, $tag_sql);
    $tag_name = mysqli_fetch_assoc($tag);



    $htmlRightContainer .= "<div class='product-title'>";
    $htmlRightContainer .=      "<span class='product-platform-head'>({$product_platform})</span> $product_title";
    $htmlRightContainer .= "</div>";
    $htmlRightContainer .= "<div><span class='product-maker'>Fabricante: </span>$product_maker</div>";
    $htmlRightContainer .= "<div><span class='product-genre'>Generos:</span> {$tag_name['tag_name']}</div>";
    $htmlRightContainer .= "<div class='row stock-row'>";
    $htmlRightContainer .=      "<div class='col-6 col-sm-6 col-md-6 col-lg-6 price-new-col'>";
    $htmlRightContainer .=          "<div class='price-in-div'>";
    $htmlRightContainer .=              "<h2 class='al-ri'>Nuevo</h2>";
    $htmlRightContainer .=              "<div class='al-ri'>\${$price_new}</div>";
    $htmlRightContainer .=              "<h4 class='al-ri'>$qty_new</h4>";
    $htmlRightContainer .=          "</div>";
    $htmlRightContainer .=      "</div>";
    $htmlRightContainer .=      "<div class='col-6 col-sm-6 col-md-6 col-lg-6 price-old-col'>";
    $htmlRightContainer .=          "<div class='price-in-div'>";
    $htmlRightContainer .=              "<h2 class='al-ri'>Usado</h2>";
    $htmlRightContainer .=              "<div class='al-ri'>\${$price_used}</div>";
    $htmlRightContainer .=              "<h4 class='al-ri'>$qty_used</h4>";
    $htmlRightContainer .=          "</div>";
    $htmlRightContainer .=      "</div>";
    $htmlRightContainer .= "</div>";
    $htmlRightContainer .= "<div class='row delivery-container'>";
    $htmlRightContainer .=     "<div class='col-lg-12 col-md-12 delivery-biz-col'>";
    $htmlRightContainer .=         "<div class='business-info'>";
    $htmlRightContainer .=             "<div>Envio Gratis a Cualquier Parte de Bogota</div>";
    $htmlRightContainer .=             "<div>Envio a cualquier otra parte de colombia solo $5.000</div>";
    $htmlRightContainer .=         "</div>";
    $htmlRightContainer .=         "<div class='business-info'>";
    $htmlRightContainer .=             "<div>Contactanos para acordar el metodo de pago y envio.</div>";
    $htmlRightContainer .=             "<div>Nuetro numero de contacto: 310-648-7741</div>";
    $htmlRightContainer .=             "<div>Nuestro email: gameliquidators@outlook.com</div>";
    $htmlRightContainer .=         "</div>";
    $htmlRightContainer .=     "</div>";
    $htmlRightContainer .= "</div>";

    echo $htmlRightContainer;

}

function createDescription($dbConn, $productId){
    $htmlDescription = "";

    $sql = "SELECT description FROM products WHERE id = $productId";

    $result = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($result) > 0){
        $description =  mysqli_fetch_assoc($result);
        $htmlDescription = $description['description'];
    }
    else{
        $htmlDescription = "Descripcion no disponible en este momento.";
    }

    echo $htmlDescription;
}

function suggestionsSlide($dbConn, $productId, $platform){
    $htmlProdSuggest = "";

    $sql_tag  = "SELECT t.tag_name 
    FROM tag as t
    INNER JOIN product_tag as pt
    ON pt.tag_id = t.tag_id
    WHERE pt.product_id = {$productId}";

    $resulTag = mysqli_query($dbConn, $sql_tag);
    $rowTag =  mysqli_fetch_assoc($resulTag);
    $productTag = $rowTag['tag_name'];
    if(empty($productTag)){
        $productTag = "generic";
    }


    // $sql = "SELECT * FROM `products` WHERE title LIKE '%fifa%' LIMIT 5";
    $sql = "SELECT p.title, p.id FROM products as p 
    INNER JOIN product_tag as pt 
    ON p.id = pt.product_id 
    INNER JOIN tag as t 
    ON pt.tag_id = t.tag_id 
    WHERE t.tag_name = '{$productTag}' ";
    $result = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($result) > 0){
        foreach ($result as $value) {
            $sqlImg = "SELECT * FROM images_table WHERE product_id = {$value['id']} ";
            $resultImg = mysqli_query($dbConn, $sqlImg);
            $rowImg =  mysqli_fetch_assoc($resultImg);
            $suggestedImg = $rowImg['image_name'];
            if(empty($suggestedImg)){
               $suggestedImg = "unavailable_thumb.jpg";
            }
            // $htmlProdSuggest .= $value['title'] . "<br>";
            $htmlProdSuggest .= "<div>";
            $htmlProdSuggest .=     "<div>";
            $htmlProdSuggest .=         "<img src='/images/{$suggestedImg}' width='120px' > ";
            $htmlProdSuggest .=     "</div>";
            $htmlProdSuggest .=     "<div class='suggested-prod-title'>";
            $htmlProdSuggest .=         $value['title'];
            $htmlProdSuggest .=     "</div>";
            $htmlProdSuggest .= "</div>";
        }
    }
    else{
        $sql = "SELECT title, id FROM products 
        WHERE platform = '{$platform}' 
        ORDER BY RAND() 
        LIMIT 4";
        $result = mysqli_query($dbConn, $sql);

        if(mysqli_num_rows($result) > 0){
            foreach ($result as $value) {
                $sqlImg = "SELECT * FROM images_table WHERE product_id = {$value['id']} ";
                $resultImg = mysqli_query($dbConn, $sqlImg);
                $rowImg =  mysqli_fetch_assoc($resultImg);
                $suggestedImg = $rowImg['image_name'];
                if(empty($suggestedImg)){
                   $suggestedImg = "unavailable_thumb.jpg";
                }
                // $htmlProdSuggest .= $value['title'] . "<br>";
                $htmlProdSuggest .= "<div>";
                $htmlProdSuggest .=     "<div>";
                $htmlProdSuggest .=         "<img src='/images/{$suggestedImg}' width='120px' > ";
                $htmlProdSuggest .=     "</div>";
                $htmlProdSuggest .=     "<div class='suggested-prod-title'>";
                $htmlProdSuggest .=         $value['title'];
                $htmlProdSuggest .=     "</div>";
                $htmlProdSuggest .= "</div>";
            }
        }
        // $htmlProdSuggest = "no suggestions!!!!";
    }

    echo $htmlProdSuggest;
}

productExists($conn, $_GET['id']);
?>