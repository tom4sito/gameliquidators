<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>ver reportes de ventas</title>
	<!-- <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> -->
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/all.min.css">	

	<style type="text/css">
		#reports_container{
			margin-left: 20px;
		}
		.report-row{
			border-bottom-style: solid;
			border-bottom-color: #ccc;
			border-bottom-width: 1px;
		}

		.show-report-btn{
			cursor: pointer;
		}

		.content-hidden{
			display: none;
		}

		.content-show{
			display: block;
		}

		.report-show{
			/*display: none;*/
			/*cursor: pointer;*/
		}

		.fecha{
			/*display: none;*/
			cursor: pointer;
		}
	</style>
</head>
<body>


<div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/gameliquidators/includes/navbar.php'; ?>
	<div class="main">
		<div class="virtual-container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="row">
						<div class="col-md-6 col-lg-6">fecha</div>
						<div class="col-md-6 col-lg-6">estatus</div>
					</div>
				</div>
			</div>
			<div class="report-content">
				<div class="row">
					<div class="col-md-12 col-lg-12 report-row">
						<div class="row fecha">
							<div class="col-md-6 col-lg-6">2018-05-12</div>
							<div class="col-md-6 col-lg-6">pendiente</div>
						</div>
						<div class="products-container report-show content-hidden">
							<div class="row product-row">
								<div class="col-md-3 col-lg-3">crash Bandicoot</div>
								<div class="col-md-3 col-lg-3">120000</div>
								<div class="col-md-2 col-lg-2">nuevo</div>
								<div class="col-md-2 col-lg-2">3</div>
								<div class="col-md-2 col-lg-2">subtotal</div>
							</div>
							<div class="row product-row">
								<div class="col-md-3 col-lg-3">Spiderman</div>
								<div class="col-md-3 col-lg-3">150000</div>
								<div class="col-md-2 col-lg-2">nuevo</div>
								<div class="col-md-2 col-lg-2">3</div>
								<div class="col-md-2 col-lg-2">subtotal</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-lg-12 report-row">
						<div class="row fecha">
							<div class="col-md-6 col-lg-6">2018-05-12</div>
							<div class="col-md-6 col-lg-6">pendiente</div>
						</div>
						<div class="products-container report-show content-hidden">
							<div class="row product-row">
								<div class="col-md-3 col-lg-3">crash Bandicoot</div>
								<div class="col-md-3 col-lg-3">120000</div>
								<div class="col-md-3 col-lg-3">nuevo</div>
								<div class="col-md-3 col-lg-3">cantidad</div>
							</div>
							<div class="row product-row">
								<div class="col-md-3 col-lg-3">Spiderman</div>
								<div class="col-md-3 col-lg-3">150000</div>
								<div class="col-md-3 col-lg-3">nuevo</div>
								<div class="col-md-3 col-lg-3">cantidad</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/all.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/datepicker-es.js"></script>

<script type="text/javascript">
	$(".fecha").on('click', function(){
		$('.report-show').toggleClass('content-hidden');
	});
</script>
</body>
</html>




