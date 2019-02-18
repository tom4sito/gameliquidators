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
	<style type="text/css">
        .product-left-container{;
            max-width: 500px;
            /*margin-left: auto;*/
            /*margin-right: auto;*/
            /*background-color: blue;*/
        }
        .product-right-container{
            max-width: 650px;
            padding-right: 0px;
        /*background-color: red;*/
        }
        .product-img {
            padding-left: 25%;
        }
        .product-img img{
            width: 320px;
            height: 420px;
        }
        .product-thumb{
            max-width: 200px;
        }
        .product-thumb img{
            width: 60px;
            height: 85px;

        }
        .product-right-col{
            font-size: 20px;
        }
        .product-title{
            font-size: 30px;
        }
        .product-platform-head{
            color: blue;
            font-weight: bold;
        }
        .product-maker{
            color: #000;
            font-weight: bold;
        }
        @media only screen and (max-width: 920px) {
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
                width: 60px;
                height: 85px;
            }
        }

        @media only screen and (max-width: 762px) {
            .product-left-container{;
                /*max-width: 500px;*/
                margin-left: auto;
                margin-right: auto;
                /*background-color: blue;*/
            }
        }

    </style>
</head>
<body>
<div class="super-container">
<?php include($includes_dir."navbar.php"); ?>
<div class="main">
    <div class="product-main-container row">
        <div class="col-lg-6 col-md-6 col-sm-6 product-left-container">
            <div class="row product-main-img">
                <div class="col-lg-12 col-md-12 product-img">
                    <img src="/images/ps4_fifa19_l.jpg">
                </div>
            </div>
            <div class="row product-thumbs-cont">
                <div class="col-lg-4 col-md-4 col-sm-4 product-thumb">
                    <img src="/images/ps4_fifa19_l.jpg">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 product-thumb">
                    <img src="/images/ps4_fifa19_l.jpg">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 product-thumb">
                    <img src="/images/ps4_fifa19_l.jpg">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 product-right-container">
            <div class="row container product-right-col">
                <div class="col-lg-12 col-md-12">
                    <div class="product-title">
                        <span class="product-platform-head">Play Station 4:</span> FIFA 19
                    </div>
                    <div><span class="product-maker">Fabricante:</span> Electronic Arts</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/basic-search.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<script type="text/javascript">
</script>
</body>
</html>