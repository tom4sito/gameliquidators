<?php
// session_start();
$doc_root = '/gameliquidators'; 
?>
<div class="menu">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo $doc_root ?>"><img src="/gameliquidators/images/gameliquidators-logo.jpg" width="180px"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Productos
				</a>
				<div class="dropdown-menu mega-menu" aria-labelledby="navbarDropdown">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<ul>
								<li><b>PS4</b></li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=videojuego&platform=ps4">Juegos</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=consola&platform=ps4">Consolas</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=accesorio&platform=ps4">Accesorios</a>
								</li>
							</ul>
							<hr>
							<ul>
								<li><b>PS3</b></li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=videojuego&platform=ps3">Juegos</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=consola&platform=ps3">Consolas</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=accessorio&platform=ps3">Accesorios</a>
								</li>
							</ul>
							<hr class="mega-menu-hr" style="display: none">
						</div>
						<div class="col-lg-4 col-md-4">
							<ul>
								<li><b>XBOX ONE</b></li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=videojuego&platform=xbox%20one">Juegos</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=consola&platform=xbox%20one">Consolas</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=accessorio&platform=xbox%20one">Accesorios</a>
								</li>
							</ul>
							<hr>
							<ul>
								<li><b>XBOX 360</b></li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=videojuego&platform=xbox%20360">Juegos</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=consola&platform=xbox%20360">Consolas</a>
								</li>
								<li>
									<a class="" href="<?php echo $doc_root ?>/products?type=accessorio&platform=xbox%20360">Accesorios</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  PS3
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=videojuego&platform=ps3">Juegos</a>
					<!-- <div class="dropdown-divider"></div> -->
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=consola&platform=ps3">Consolas</a>
					<!-- <div class="dropdown-divider"></div> -->
					<a class="dropdown-item" href="<?php echo $doc_root ?>/products?type=accessorio&platform=ps3">Accesorios</a>

				</div>
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
				echo 	"<form id='searchform' class='form-inline my-2 my-lg-0' method='post' action='{$doc_root}/searches/basic-search.php'>";
				echo 		"<input class='form-control mr-sm-2 search-box' type='search' placeholder='busqueda rapida' aria-label='Search' name='basic-search-inp' autocomplete='off'>";
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
				echo 	"<form id='searchform' class='form-inline my-2 my-lg-0' method='post' action='{$doc_root}/searches/basic-search.php'>";
				echo 		"<input class='form-control mr-sm-2 search-box' type='search' placeholder='busqueda rapida' aria-label='Search' name='basic-search-inp' autocomplete='off'>";
				echo 	"<input id='search-button' type='submit' value=''>";
				// echo 		"<button class='btn btn-outline-danger my-2 my-sm-0' type='submit'>buscar</button>";
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