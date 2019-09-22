<!DOCTYPE html>
<html>
<head>
	<title>layout</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<style type="text/css">
	.menu{
		display: grid;
		grid-template-columns: 150px 100px 100px 100px auto;
	}
	.login-btn {
	    text-align: right;
	}
	.submenu{
		grid-column: 1 / span 5; /* span value needs to change if item is added or removed to main menu */
		background-color: antiquewhite;
		display: flex;
	}
	.submenu-item-drop {
	    padding-left: 10px;
	}
	.display-off{
		display: none;
	}
	@media screen and (max-width: 700px){
		.menu{
			grid-template-columns: auto auto auto auto auto;
		}
		.submenu{
			background-color: #ccc;
			grid-area: 3 / 1 / 5 / 6; /* reorders the submenu for mobile third value needs to change if item is added to main menu */
			/*display: block;*/
		}
		.show-submenu{
			display: block;
		}
		.menu-item{
			grid-column: 1 / span 5; /* span value needs to change if item is added or removed to main menu */
		}
		.login-btn {
		    text-align: left;
		}
		.togg-icon-off::before {
			display: inline-block;
			float: right;
			font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0c9";
		}
		.togg-icon-on::before {
			display: inline-block;
			float: right;
			font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f00d";
		}
		.hide-mobile{
			/*display: none;*/
			display: grid;
			opacity: 0; 
			height: 0px;
		}
		.show-mobile{
			/*display: block;*/
			display: grid;
			opacity: 1;
			height: auto;
			transition: opacity 1s;
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
			height: 4px;
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
			top: 10px;
			-webkit-transform-origin: left center;
			-moz-transform-origin: left center;
			-o-transform-origin: left center;
			transform-origin: left center;
		}

		#nav-icon4 span:nth-child(3) {
			top: 20px;
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
			top: -3px;
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


	</style>
</head>
<body>
	<nav>
		<div class="menu" id="nav-menu">
			<div class="menu-item logo" target-drop-id="menu-drop"><span>Gameliquidators</span>
				  <div id="nav-icon4">
					<span></span>
					<span></span>
					<span></span>
				  </div>
				<!-- <span class="show-hide-togg togg-icon-off" ></span> -->
			</div>
			<div class="menu-item drop-down-products hide-mobile"><span>Products</span></div>
			<div class="menu-item hide-mobile"><span>Contact</span></div>
			<div class="menu-item hide-mobile"><span>Buscar</span></div>
			<div class="menu-item login-btn hide-mobile"><span>Ingresar</span></div>
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
	</nav>
	<h1>hello there</h1>

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
					$(".hide-mobile").addClass("show-mobile").removeClass("hide-mobile");
				}else{
					$(this).removeClass("active-mobile");
					$(this).removeClass("togg-icon-on").addClass("togg-icon-off");
					$(".show-mobile").addClass("hide-mobile").removeClass("show-mobile");
					$("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
					$(".active-drop").removeClass("active-drop");
					$(".submenu-item-drop").addClass("display-off");
				}
			});

			// Hamburger ###################
			$(document).ready(function(){
				$('#nav-icon4').click(function(){
					if(!$(this).hasClass("active-mobile")){
						$(this).toggleClass('open');
						$(this).addClass("active-mobile");
						$(".hide-mobile").addClass("show-mobile").removeClass("hide-mobile");
					}
					else{
						$(this).toggleClass('open');
						$(this).removeClass("active-mobile")
						$(".show-mobile").addClass("hide-mobile").removeClass("show-mobile");
						$("#product-menu-drop").removeClass("show-submenu").addClass("display-off");
						$(".active-drop").removeClass("active-drop");
						$(".submenu-item-drop").addClass("display-off");

					}

				});
			});
		});
	</script>
</body>
</html>