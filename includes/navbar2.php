<?php
// session_start();
$doc_root = '/gameliquidators'; 
?>
<div class="menu">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo $doc_root ?>"><img src="/images/gameliquidators-logo.png" width="180px"></a>

		<button id="hamburger-btn" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<!-- <span class="navbar-toggler-icon"></span> -->
		<div id="nav-icon4">
			<span></span>
			<span></span>
			<span></span>
		</div>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  PRODUCTOS
				</a>
				<div class="dropdown-menu mega-menu" aria-labelledby="navbarDropdown">
					<div class="submenu" id="product-menu-drop">
						<div class="submenu-col">
							<h4>VIDEOJUEGOS</h4>
							<div class="submenu-item" target-drop-id="ps4-drop">
								<span class="drop-name">PS4</span>
								<div class="submenu-item-drop display-off" id="ps4-drop">
									<div class="submenu-item"><a href="#">Consolas</a></div>
									<div class="submenu-item" target-drop-id="ps4-games-drop">
										<a href="<?php echo $doc_root ?>/products/ps4/videojuego">Video Juegos</a>
										<div class="submenu-item-drop display-off" id="ps4-games-drop">
											<div><a href="<?php echo $doc_root ?>/products/ps4/videojuego/accion">Accion</a></div>
											<div><a href="<?php echo $doc_root ?>/products/ps4/videojuego/deportes">Deportes</a></div>
											<div><a href="<?php echo $doc_root ?>/products/ps4/videojuego/aventura">Aventura</a></div>
										</div>
									</div>
									<div class="submenu-item"><a href="#">Accesorios</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="ps3-drop">
								<span class="drop-name">PS3</span>
								<div class="submenu-item-drop display-off" id="ps3-drop">
									<div class="submenu-item" ><a href="<?php echo $doc_root ?>/products/ps3/consolas">Consolas</a></div>
									<div class="submenu-item" ><a href="<?php echo $doc_root ?>/products/ps3/videojuego">Video Juegos</a></div>
									<div class="submenu-item" ><a href="<?php echo $doc_root ?>/products/ps3/accesorios">Accesorios</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="xboxone-drop">
								<span class="drop-name">XBOX ONE</span>
								<div class="submenu-item-drop display-off" id="xboxone-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xboxone/consolas">Consolas</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xboxone/videojuego">Video Juegos</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xboxone/accesorios">Accesorios</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="xbox360-drop">
								<span class="drop-name">XBOX 360</span>
								<div class="submenu-item-drop display-off" id="xbox360-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xbox360/consolas">Consolas</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xbox360/videojuego">Video Juegos</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/xbox360/accesorios">Accesorios</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="nintendoswitch-drop">
								<span class="drop-name">NINTENDO SWITCH</span>
								<div class="submenu-item-drop display-off" id="nintendoswitch-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/nintendoswitch/consolas">Consolas</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/nintendoswitch/videojuego">Video Juegos</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/nintendoswitch/accesorios">Accesorios</a></div>
								</div>
							</div>
						</div>
						<div class="submenu-col">
							<h4>COMPUTADORES</h4>
							<div class="submenu-item">
								<div><a href="<?php echo $doc_root ?>/products/computadores/laptops">Laptops</a></div>
							</div>
							<div class="submenu-item">
								<div><a href="<?php echo $doc_root ?>/products/computadores/desktops">Desktops</a></div>
							</div>
							<div class="submenu-item" target-drop-id="compu-acces-drop">
								<span class="drop-name">ACCESORIOS</span>
								<div class="submenu-item-drop display-off" id="compu-acces-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/accesorios/mouse">Mouse</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/accesorios/teclados">Teclado</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/memusb">Memorias USB</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="compu-comp-drop">
								<span class="drop-name">COMPONENTES</span>
								<div class="submenu-item-drop display-off" id="compu-comp-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/discosduros">Discos Duros</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/componentes">Memoria RAM</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/componentes">CPUs</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/componentes">Tarjetas De Video</a></div>
								</div>
							</div>
						</div>
						<div class="submenu-col">
							<h4>CELULARES</h4>
							<div class="submenu-item" target-drop-id="apple-cell-drop">
								<span class="drop-name">APPLE</span>
								<div class="submenu-item-drop display-off" id="apple-cell-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/celulares/apple/smartphones">Celulares y Smartphones</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/apple/accesorios">Accesorios</a></div>
								</div>
							</div>
							<div class="submenu-item" target-drop-id="android-cell-drop">
								<span class="drop-name">ANDROID</span>
								<div class="submenu-item-drop display-off" id="android-cell-drop">
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/celulares/android/smartphones">Celulares y Smartphones</a></div>
									<div class="submenu-item"><a href="<?php echo $doc_root ?>/products/computadores/android/accesorios">Accesorios</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  NOTICIAS
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=videojuego&platform=ps3">Juegos</a>
					<!-- <div class="dropdown-divider"></div> -->
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=consola&platform=ps3">Consolas</a>
					<!-- <div class="dropdown-divider"></div> -->
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=accessorio&platform=ps3">Accesorios</a>

				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" role="button" >
				  CONTACTANOS
				</a>
			</li>
			<?php
			if(isset($_SESSION['username'])){
				echo "<li class='nav-item dropdown'>";
				echo 	"<a class='nav-link dropdown-toggle' href='' id='navbarDropdown'";
				echo 	"role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >";
				echo    "Herramientas</a>";
				echo 	"<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
				echo 		"<a class='dropdown-item' href='{$doc_root}/admin/create'>";
				echo 		"crear producto";
				echo 		"</a>";
				echo 		"<a class='dropdown-item' href='{$doc_root}/admin/reporte_ventas'>";
				echo 		"Reporte de Ventas";
				echo 		"</a>";
				echo 		"<a class='dropdown-item' href='{$doc_root}/admin/reporte_ventas/ver_reportes'>";
				echo 		"Ver Reportes";
				echo 		"</a>";
				echo 	"</div>";
				echo "</li>";

				echo "<li class='nav-item search-box-container'>";
				echo 	"<form id='searchform' class='form-inline my-2 my-lg-0' method='get' action='{$doc_root}/searches/basic-search.php'>";
				echo 		"<input class='form-control search-box' type='search' placeholder='busqueda rapida' aria-label='Search' name='basic-search-inp' autocomplete='off'>";
				echo 	"<input id='search-button' type='submit' value=''>";
				// echo 		"<button class='btn btn-outline-danger my-2 my-sm-0' type='submit'>buscar</button>";
				echo 	"</form>";
				echo 	"<div class='result' id='result'></div>";
				echo "</li>";

				// echo "<li class='nav-item'>";
				// echo 	"<a class='nav-link disabled' href='{$doc_root}/logout'>logout</a>";
				// echo "</li>";
			}

			if(!isset($_SESSION['username'])){
				echo "<li class='nav-item'>";
				echo 	"<form id='searchform' class='form-inline my-2 my-lg-0' method='get' action='{$doc_root}/searches/basic-search.php'>";
				echo 		"<div class='search-div'>";
				echo 			"<input type='search' name='basic-search-inp' class='form-control search-box' autocomplete='off' placeholder='Buscar'>";
				echo 			"<button class='basic-search-btn live-product'><i class='fas fa-search'></i></button>";
				echo 		"</div>";
				echo 	"</form>";
				echo 	"<div class='result' id='result'></div>";
				echo "</li>";



				// echo "<li class='nav-item'>";
				// echo 	"<a class='nav-link disabled' href='{$doc_root}/login'>login</a>";
				// echo "</li>";
			}
			?>
		</ul>
		<?php
			if(isset($_SESSION['username'])){
				echo "<ul class='navbar-nav'>";
				echo 	"<li class='nav-item'>";
				echo 		"<a class='nav-link disabled' href='{$doc_root}/logout'>logout</a>";
				echo 	"</li>";
				echo "</ul>";
			}
			if(!isset($_SESSION['username'])){
				echo "<ul class='navbar-nav'>";
				echo 	"<li class='nav-item'>";
				echo 		"<a class='nav-link disabled' href='{$doc_root}/login'>login</a>";
				echo 	"</li>";
				echo "</ul>";
			}
		?>


		</div>
	</nav>
</div>