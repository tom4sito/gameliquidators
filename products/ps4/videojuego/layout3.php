<!DOCTYPE html>
<html>
<head>
	<title>layout</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<style type="text/css">
		body{
			font-family: titillium,Roboto,"Helvetica Neue",Arial;
		}
		.menu{
			display: grid;
			grid-template-columns: 150px auto;
			align-items: baseline;
		}
		.menu-item{
			font-size: 20px;
		}
		.menu-item a{
			text-decoration: none;
		}
		.hideable-items{
			display: grid;
			grid-template-columns: 115px 100px 100px auto auto;
			align-items: center;
		}
		.login-btn {
		    text-align: right;
		}
		.display-off{
			display: none;
		}

	@media screen and (max-width: 700px){
		.menu{
			grid-template-columns: auto;
		}
		.menu-item{
			grid-column: 1 / span 5; /* span value needs to change if item is added or removed to main menu */
		}
		/*------------------------------ slide-in and out ---------------------------------------*/
		.mobile-on{
			display: grid;
			grid-template-columns: auto;

			max-height: 700px;
			transition: max-height 1s;

			/*animation: slide-in 0.5s forwards;*/
			/*-webkit-animation: slide-in 0.5s forwards;*/
		}
		.mobile-off{
			/*display: none;*/
			display: grid;
			grid-template-columns: auto;

			max-height: 0px;
			transition: max-height 0.2s ease-out;
			overflow: hidden;

			/*animation: slide-out 0.5s forwards;*/
			/*-webkit-animation: slide-out 0.5s forwards;*/
		}
		@keyframes slide-in {
		    100% { transform: translateX(0%); }
		}

		@-webkit-keyframes slide-in {
		    100% { -webkit-transform: translateX(0%); }
		}
		    
		@keyframes slide-out {
		    0% { transform: translateX(0%); }
		    100% { transform: translateX(-120%); }
		}

		@-webkit-keyframes slide-out {
		    0% { -webkit-transform: translateX(0%); }
		    100% { -webkit-transform: translateX(-120%); }
		}

		.login-btn {
		    text-align: left;
		}
		/*.togg-icon-off::before {
			display: inline-block;
			float: right;
			font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0c9";
		}
		.togg-icon-on::before {
			display: inline-block;
			float: right;
			font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f00d";
		}*/
		.hideable-items{
			grid-column: 1 / span 5;
		}

		.submenu{
			background-color: #ccc;
			grid-area: 2 / 1 / 5 / 6; /* reorders the submenu for mobile third value needs to change if item is added to main menu */
			/*display: block;*/
		}

		/*---------------hamburger----------------------*/
		#nav-icon4 {
			float: right;
			width: 30px;
			height: 30px;
			position: relative;
			/*margin: 50px auto;*/
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			-webkit-transition: .5s ease-in-out;
			-moz-transition: .5s ease-in-out;
			-o-transition: .5s ease-in-out;
			transition: .5s ease-in-out;
			cursor: pointer;
		}
		#nav-icon4 span {
			display: block;
			position: absolute;
			height: 3px;
			width: 100%;
			background: #000;
			border-radius: 9px;
			opacity: 1;
			left: 0;
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			-webkit-transition: .25s ease-in-out;
			-moz-transition: .25s ease-in-out;
			-o-transition: .25s ease-in-out;
			transition: .25s ease-in-out;
		}
		#nav-icon4 {
		}

		#nav-icon4 span:nth-child(1) {
			top: 0px;
			-webkit-transform-origin: left center;
			-moz-transform-origin: left center;
			-o-transform-origin: left center;
			transform-origin: left center;
		}

		#nav-icon4 span:nth-child(2) {
			top: 8px;
			-webkit-transform-origin: left center;
			-moz-transform-origin: left center;
			-o-transform-origin: left center;
			transform-origin: left center;
		}

		#nav-icon4 span:nth-child(3) {
			top: 16px;
			-webkit-transform-origin: left center;
			-moz-transform-origin: left center;
			-o-transform-origin: left center;
			transform-origin: left center;
		}

		#nav-icon4.open span:nth-child(1) {
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			transform: rotate(45deg);
			top: -2px;
			left: 8px;
		}

		#nav-icon4.open span:nth-child(2) {
			width: 0%;
			opacity: 0;
		}

		#nav-icon4.open span:nth-child(3) {
			-webkit-transform: rotate(-45deg);
			-moz-transform: rotate(-45deg);
			-o-transform: rotate(-45deg);
			transform: rotate(-45deg);
			top: 19px;
			left: 8px;
		}
		/*-----------end hamburger-----------------------*/

	}

	/* -----------searchbar -------------------*/
	form#searchform {
	    padding-top: 3px;
	}
	.search-div{
	    background-color: #fff;
	    border-radius: 10px;
	    border-style: solid;
	    border-width: 1px;
	    border-color: #ccc;
	    width: 210px;
	}
	.search-box{
	    font-size: 16px !important;
	    border-style: none;
	    border-width: 1px;
	    width: 170px !important;
	    border-radius: 10px;
	    font-family: titillium,Roboto,"Helvetica Neue",Arial;
	    font-weight: 100;
	    padding-left: 10px;
	    padding-top: 0px;
	    padding-bottom: 0px;
	    margin-right: 6px;
	}
	.search-box::placeholder{
	    color: #aaa;
	}
	.basic-search-btn{
	    border: none;
	    cursor: pointer;
	    padding-right: 0px;
	    padding-top: 5px;
	}
	.basic-search-btn .fa-search{
	    color: #aaa;
	    font-size: 16px;
	}
	.basic-search-btn .fa-search:hover{
	    color: red;
	}
	.form-control{
	    height: 32px !important;
	}
	/* -----------searchbar ---------------------------*/

	.drop-down-grab span::after {
		font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0da";
		padding-left: 5px;
	}

	</style>
</head>
<body>
	<nav>
		<div class="menu" id="nav-menu">
			<div class="menu-item logo" target-drop-id="menu-drop">
				<span>Gameliquidators</span>
				  <div id="nav-icon4">
					<span></span>
					<span></span>
					<span></span>
				  </div>
				<!-- <span class="show-hide-togg togg-icon-off" ></span> -->
			</div>
			<div class="hideable-items mobile-off">
				<div class="menu-item drop-down-grab drop-down-products hide-mobile"><span><a href="#">Products</a></span></div>
				<div class="menu-item hide-mobile"><span><a href="">Contact</a></span></div>
				<div class="menu-item hide-mobile"><span><a href="">Buscar</a></span></div>

				<div class='menu-item search-div'>
					<form id='searchform' class='form-inline my-2 my-lg-0' method='get' action='{$doc_root}/searches/basic-search.php'>
						<input type='search' name='basic-search-inp' class='form-control search-box' autocomplete='off' placeholder='Buscar'>
						<button class='basic-search-btn'><i class='fas fa-search'></i></button>
					</form>
					<div class='result' id='result'></div>
				</div>

				<div class="menu-item login-btn hide-mobile"><span><a href=""> Ingresar</a></span></div>
				<div class="submenu display-off" id="product-menu-drop">
					<div class="submenu-col">
						<div class="submenu-item" target-drop-id="ps4-drop">
							<span>PS4</span>
							<div class="submenu-item-drop display-off" id="ps4-drop">
								<div><a href="#">Consolas</a></div>
								<div class="submenu-item" target-drop-id="ps4-games-drop">
									<a href="#">Video Juegos</a>
									<div class="submenu-item-drop display-off" id="ps4-games-drop">
										<div><a href="#">Accion</a></div>
										<div><a href="#">Deportes</a></div>
										<div><a href="#">Aventura</a></div>
									</div>
								</div>
								<div><a href="#">Accesorios</a></div>
							</div>
						</div>
						<div class="submenu-item">
							<span>XBOX</span>
						</div>
						<div class="submenu-item">
							<span>Nintendo</span>
						</div>
					</div>
					<div class="submenu-col">
						<div class="submenu-item">
							<span>Laptop</span>
						</div>
						<div class="submenu-item">
							<span>Cellphone</span>
						</div>
						<div class="submenu-item">
							<span>Accessories</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<h2>this is only a test</h2>

	<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$(".submenu-item").on("click", function(event){
				event.stopPropagation();
				if(!$(this).hasClass("active-drop")){
					$(this).addClass("active-drop");
					drop_div_id = "#" + $(this).attr("target-drop-id");
					$(drop_div_id).removeClass("display-off");
				}else{
					$(this).removeClass("active-drop");
					drop_div_id = "#" + $(this).attr("target-drop-id");
					$(drop_div_id).addClass("display-off");
				}
			});

			$(".drop-down-products").on("click", function(){
				console.log("hamburger hit");
				$("#product-menu-drop").removeClass("display-off").addClass("show-submenu");
				if(!$(this).hasClass("active-drop")){
					$(this).addClass("active-drop");
					$("#product-menu-drop").removeClass("display-off").addClass("show-submenu");
				}else{
					$(this).removeClass("active-drop");
					$("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
				}
			});

			$(".show-hide-togg").on("click", function(){
				if(!$(this).hasClass("active-mobile")){
					$(this).addClass("active-mobile");
					$(this).removeClass("togg-icon-off").addClass("togg-icon-on");
					$(".hideable-items").addClass("mobile-on").removeClass("mobile-off");
				}else{
					$(this).removeClass("active-mobile");
					$(this).removeClass("togg-icon-on").addClass("togg-icon-off");
					$(".hideable-items").addClass("mobile-off").removeClass("mobile-on");
					// $("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
					// $(".active-drop").removeClass("active-drop");
					// $(".submenu-item-drop").addClass("display-off");
				}
			});

			// Hamburger ###################
			$('#nav-icon4').click(function(){
				if(!$(this).hasClass("active-mobile")){
					$(this).toggleClass('open');
					$(this).addClass("active-mobile");
					$(".hideable-items").addClass("mobile-on").removeClass("mobile-off");
				}
				else{
					$(this).toggleClass('open');
					$(this).removeClass("active-mobile");
					$(".hideable-items").addClass("mobile-off").removeClass("mobile-on");
					// $(".show-mobile").addClass("hide-mobile").removeClass("show-mobile");
					// $("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
					// $(".active-drop").removeClass("active-drop");
					// $(".submenu-item-drop").addClass("display-off");

				}
			});
		});
	</script>
</body>
</html>