<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT']; 
$includes_dir = $doc_root.'/gameliquidators/includes/';
require $includes_dir.'db_connect.php';
require $includes_dir.'product_template.php';

if(isset($_SESSION['username'])){
    // echo "session started username: ".$_SESSION['username'];
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>main page</title>
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/gameliquidators/css/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/gameliquidators/css/slick/slick-theme.css"/>
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
    <div class="prods-suggest-container">
      <div>your content</div>
      <div>your content</div>
      <div>your content</div>
    </div>
</div>
<?php include($includes_dir."footer.php"); ?>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<script type="text/javascript" src="/gameliquidators/js/slick/slick.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<script type="text/javascript">
$(document).ready(function(){
    $('.your-class').slick({
        setting-name: setting-value
    });
});
</script>
</body>
</html>