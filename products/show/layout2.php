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
    .main-img-box{
        border-style: solid;
        border-width: 1px;
        width: 270px;
        height: 270px;
    }


    .main-img-box img{
        width: 350px;
        height: 420px;
    }

/*    .prod-left-col{
        padding-left: 5%;
    }*/
    .main-cols-container{
        padding-left: 5%;
    }
    @media only screen and (min-width: 1020px) {
        .main-img-box{
            border-style: solid;
            border-width: 1px;
            width: 438px;
            height: 438px;
        }
        .prod-left-col{
            padding-left: 15%;
        }
    }
    @media (max-width:1019px) and (min-width:750px) {
        .prod-left-col{
            padding-left: 10%;
            background-color: yellow;
        }
        .main-img-box img{
            width: 220px;
            height: 270px;
        }
    }​
    </style>
</head>
<body>
<div class="super-container">
<?php include($includes_dir."navbar.php"); ?>
<div class="main">
    <div class="row main-cols-container container-fluid">
       <div class="col-lg-6 col-md-6 col-sm-6 prod-left-col">
           <div class="row">
               <div class="col-auto main-img-box">
                   <img src="/images/ps4_fifa19_l.jpg">
               </div>
           </div>
           <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 thumb-box"></div>
               <div class="col-lg-4 col-md-4 col-sm-4 thumb-box""></div>
               <div class="col-lg-4 col-md-4 col-sm-4 thumb-box""></div>
           </div>
       </div>

       <div class="col-lg-6 col-md-6 col-sm-6 prod-right-col">
           <div class="row">
               <div class="col-lg-12 col-md-12 col-md-12 product-info-txt">
                   <div class="product-title">
                       Play Station 4 : FIFA 19 World Cup
                   </div>
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