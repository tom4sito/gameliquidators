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
            <a href="">PS4</a><span class="nav-tree-carret"> / </span>
            <a href="">Videojuegos</a><span class="nav-tree-carret"> / </span>
            <a href="">Deportes</a><span class="nav-tree-carret"> / </span>
            <a href="">FIFA 19</a>
        </div>        
    </div>
    <div class="product-main-container row">
        <div class="col-lg-6 col-md-6 col-sm-6 product-left-container">
            <div class="row product-main-img">
                <div class="col-lg-12 col-md-12 product-img">
                    <img src="/images/ps4_fifa19_1.jpg">
                </div>
            </div>
            <div class="row product-thumbs-cont">
                <div class="col-lg-4 col-md-4 col-sm-4 col-4 product-thumb">
                    <img src="/images/ps4_fifa19_thumb1.jpg">
                    <!-- <div class="product-thumb-hr"></div> -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-4 product-thumb ">
                    <img src="/images/ps4_fifa19_thumb3.jpg">
                    <!-- <div class="product-thumb-hr"></div> -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-4 product-thumb product-thumb-sel ">
                    <img src="/images/ps4_fifa19_thumb2.jpg">
                    <!-- <div class="product-thumb-sel"></div> -->
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 product-right-container">
            <div class="row container product-right-col">
                <div class="col-lg-12 col-md-12">
                    <div class="product-title">
                        <span class="product-platform-head">(Play Station 4)</span> Call of Duty Black Ops 5
                    </div>
                    <div><span class="product-maker">Fabricante:</span> Electronic Arts</div>
                    <div><span class="product-genre">Generos:</span> Deportes, futbol, fifa</div>
                    <!-- <hr> -->
                    <div class="row stock-row">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 price-new-col">
                            <div class="price-in-div">
                                <h2 class="al-ri">Nuevo</h2>
                                <div class="al-ri">$120.000.000</div>
                                <h4 class="al-ri">2 disponibles</h4>
                            </div>

                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 price-old-col">
                            <div class="price-in-div">
                                <h2 class="al-ri">Usado</h2>
                                <div class="al-ri">$90.000</div>
                                <h4 class="al-ri">agotado</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row delivery-container">
                        <div class="col-lg-12 col-md-12 delivery-biz-col">
                            <div class="business-info">
                                <div>Envio Gratis a Cualquier Parte de Bogota</div>
                                <div>Envio a cualquier otra parte de colombia solo $5.000</div>
                            </div>
                            <div class="business-info">
                                <div>Contactanos para acordar el metodo de pago y envio.</div>
                                <div>Nuetro numero de contacto: 310-648-7741</div>
                                <div>Nuestro email: gameliquidators@outlook.com</div>
                            </div>
                        </div>
                    </div>

                    <!-- <hr> -->

                    <!-- <div>Nuevo: $120.000 - 2 Disponibles</div> -->
                    <!-- <div>Usado: $90.000 - Agotado</div> -->
                    <!-- <div>$120.000</div> -->
                    <!-- <div>Generos: Futbol, Deportes</div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row description-container">
        <div class="col-lg-12 col-md-12">
            <div class="description-header-div">
                <h3>Descripcion</h3>
            </div>
            <div class="description-txt-div">
             Destiny 2 es una secuela directa del videojuego de acción en primera persona de Bungie distribuido por Activision. La historia de este episodio amplía el universo de fantasía de la entrega original del 2014 al situar su propuesta shooter tras el ataque a la última ciudad de la Tierra a manos de Ghaul, el comandante de la Legión Roja de los cabal. La Vanguardia, formada por el cazador exo Cayde-6, la hechicera humana Ikora Rey y el titán insomne Zavala, pretende reunir a los guardianes para luchar contra la Oscuridad y recuperar al Viajero y su hogar tras caer la Torre y buena parte del esquema que conocíamos. Después de ser el elemento argumental uno de los puntos más criticados del Destiny original de 2014, en el estudio americano no quieren dormirse en los laureles y buscan que, en esta ocasión, la fuerte presencia de cinemáticas y un hilo de guion mucho más trabajado sean elementos que le doten de fortaleza y de interés a un shooter que, por lo demás, tiene impecables mecánicas para los tiroteos. 
        </div>
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