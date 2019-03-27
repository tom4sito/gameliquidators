<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';

if(isset($_SESSION['username'])){
    // echo "session started username: ".$_SESSION['username'];
}

// $product_id = $_GET["id"];
// echo $platform;
// $sql = "SELECT * FROM products WHERE id = '$product_id' ";
// $result = $conn->query($sql);


// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         echo "<div id='game container'>";
//         echo    "<div>";
//         echo        "id: {$row['id']} - name: {$row['title']} - {$row['platform']}";
//         echo        "<a href='{$doc_root}/products/show/?id={$row['id']}' > Ver </a>";
//                     if(isset($_SESSION['username'])){
//                     // echo "<a href='{$doc_root}/admin/edit.php?id={$row['id']}' > Edit </a>";
//                         echo "<a href='{$doc_root}/admin/edit/?id={$row['id']}' > Editar </a>";
//                     }
//         echo    "</div>";
//         echo "</div>";
//     }
// } else {
//     echo "0 results";
// }


// $conn->close();

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

    $result = mysqli_query($dbConn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $htmlNavTree .= "<a href='{$root}' class='nav-tag'>{$row['platform']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href='' class='nav-tag'>{$row['product_type']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href='' class='nav-tag'>{$row['tag_name']}</a><span class='nav-tree-carret'> / </span>";
        $htmlNavTree .= "<a href=''>{$row['title']}</a>";
        echo $htmlNavTree;
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

    $htmlRightContainer .= "<div class='product-title'>";
    $htmlRightContainer .=      "<span class='product-platform-head'>({$product_platform})</span> $product_title";
    $htmlRightContainer .= "</div>";
    $htmlRightContainer .= "<div><span class='product-maker'>Fabricante: </span>$product_maker</div>";
    $htmlRightContainer .= "<div><span class='product-genre'>Generos:</span> Deportes, futbol</div>";
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

productExists($conn, $_GET['id']);
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>main page</title>
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
    <style type="text/css">
        .nav-tree-container{
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 1%;
        }
        .nav-tree a{
            color: #545b62;
            text-decoration: none;
            background-color: transparent;
        }
        .nav-tree a:hover{
            color: red;
            text-decoration: none;
            background-color: transparent;
        }
        .product-left-container{;
            max-width: 500px;
            padding-left: 10%;
            /*margin-left: auto;*/
            /*margin-right: auto;*/
            /*background-color: blue;*/
        }
        .product-right-container{
            max-width: 650px;
            padding-right: 0px;
        /*background-color: red;*/
        }
        .product-main-img{
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
        }
        .product-thumbs-cont {
            margin-left: auto;
            margin-right: auto;
        }
/*        .product-img {
            width: 320px;
            height: 420px;
        }*/
        .product-img img{
            width: 320px;
            height: 420px;
        }
        .product-thumb{
            max-width: 115px;
        }
        .product-thumb img{
            width: 100%;
            /*height: 90px;*/

        }
        .product-thumb{
            border-bottom-style: solid;
            border-bottom-color: #bbb;
            border-bottom-width: 2px;
            padding-bottom: 8px;
        }
        .product-thumb-sel{
            border-bottom-style: solid;
            border-bottom-color: red;
            border-bottom-width: 3px;
            padding-bottom: 8px;
        }
        .product-right-col{
            font-size: 20px;
        }
        .product-title{
            font-size: 30px;
        }
        .product-platform-head{
            font-weight: bold;
        }
        .product-maker{
            color: #000;
            font-weight: bold;
        }
        @media only screen and (max-width: 920px) {
/*            .product-img {
                width: 230px;
                height: 300px;
            }*/
            .product-thumb{
                max-width: 85px;
            }
            .product-img img{
               width: 230px;
               height: 300px;
            }
            .product-left-container{
                max-width: 350px;
            }
            .product-right-container{
                margin-right: 0px;
            }
            .product-title{
                font-size: 18px;
            }
            .product-thumb img{
                width: 100%;
                /*height: 90%;*/
            }
        }

        @media only screen and (max-width: 762px) {
            .product-left-container{;
                /*max-width: 500px;*/
                margin-left: auto;
                margin-right: auto;
                /*background-color: blue;*/
            }
            .product-right-container{;
                /*max-width: 500px;*/
                /*margin-left: auto;
                margin-right: auto;*/
                /*background-color: blue;*/
                /*flex: 0 0 70%;*/
            }

        }
        @media only screen and (max-width: 662px) {
            .product-thumb img{
                width: 100%;
                /*height: 90%;*/
            }
        }

        @media screen and (min-width:576px) and (max-width:657px) {
            .product-right-container{;
                flex: 0 0 100%;
            }
        }

        .stock-row{
            margin-top: 20px;
            border-top-color: #bbbbbb;
            border-top-style: solid;
            border-top-width: 1px;
            border-bottom-style: solid;
            border-bottom-width: 1px;
            border-bottom-color: #bbb;
            margin-bottom: 40px;
        }

        .price-new-col, .price-old-col{
            min-width: 148px;
            padding-right: 0px;
            /*max-width: 180px;*/
        }

        .al-ri{
            text-align: center;
        }

        .delivery-info{
            font-size: 18px;
            font-weight: 100;
        }
        .business-info{
            font-size: 18px;
            font-weight: 100;
        }

        /*----------------------------------------*/
        .description-container{
            max-width: 1150px;
            margin-top: 20px;
            margin-left: 2%;
            margin-right: 5%;
        }

    </style>
</head>
<body>
<div class="super-container">
<?php include($includes_dir."navbar.php"); ?>
<div class="main">
    <div class="row container-fluid nav-tree-container">
        <div class="col-12 nav-tree d-none d-sm-block">
            <?php createNavTree($conn, $_GET['id'], $doc_root) ?>
        </div>        
    </div>
    <div class="product-main-container row">
        <div class="col-lg-6 col-md-6 col-sm-6 product-left-container">
            <?php createLeftContainer($conn, $_GET['id']); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 product-right-container">
            <div class="row container product-right-col">
                <div class="col-lg-12 col-md-12">
                    <?php createRightContainer($conn, $_GET['id']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row description-container">
        <div class="col-lg-12 col-md-12">
            <div class="description-header-div">
                <h3>Descripcion</h3>
            </div>
            <div class="description-txt-div"><?php createDescription($conn, $_GET['id']); ?></div>
        </div>
    </div>
</div>
<?php include($includes_dir."footer.php"); ?>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<script type="text/javascript">
</script>
</body>
</html>