<!DOCTYPE html>
<html>
<head>
	<title>filter sandbox</title>
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/gameliquidators/css/styles.css">
</head>
<body>
	<div class="col-lg-2 col-md-2 filters-col">
		<div id="data-store" basic-query="fifa"></div>
		<form action="" method="get">
			<div class="filter-category">
				<div class="filter-category-title">
					<h6>Platform</h6>
				</div>
				<div class="filterContainer" id="platformFilterContainer">
					<div>
						<input type='checkbox' name='platform|PS4' value='3' class='platform-filter grab-filter' filter-name='PS4'><span> PS4 (3)</span>
					</div>
					<div>
						<input type='checkbox' name='platform|PS3' value='1' class='platform-filter grab-filter' filter-name='PS3'><span> PS3 (1)</span>
					</div>
					<div>
						<input type='checkbox' name='platform|XBOX ONE' value='1' class='platform-filter grab-filter' filter-name='XBOX ONE'><span> XBOX ONE (1)</span>
					</div>					
				</div>
			</div>
			<hr>
			<div class="filter-category">
				<div class="filter-category-price">
					<h6>Price</h6>
				</div>
				<div class="filterContainer" id="priceFilterContainer">
					<div>
						<input type='checkbox' name='pricerange|0|100' value='100' class='platform-filter grab-filter' filter-name='0-100'><span> $0 - $100 (4)</span>
					</div>
					<div>
						<input type='checkbox' name='pricerange|100|200' value='200' class='platform-filter grab-filter' filter-name='100-200'><span> $100 - $200 (3)</span>
					</div>
					<div>
						<input type='checkbox' name='pricerange|200|300' value='300' class='platform-filter grab-filter' filter-name='200-300'><span> $200 - $300 (1)</span>
					</div>
					<div>
						<input type='checkbox' name='pricerange|300|400' value='400' class='platform-filter grab-filter' filter-name='300-400'><span> $300 - $400 (1)</span>
					</div>
					<div>
						<input type='checkbox' name='pricerange|500|600' value='600' class='platform-filter grab-filter' filter-name='500-600'><span> $500 - $600 (1)</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="filter-category">
				<div class="filter-category-condition">
					<h6>Condition</h6>
				</div>
				<div class="filterContainer">
					<div>
						<input type='checkbox' name='condition|new' filter-name='new' class='platform-filter grab-filter'>
						<span> new (4)</span>
					</div>
					<div>
						<input type='checkbox' name='condition|used' filter-name='used' class='platform-filter grab-filter'><span> used (1)</span>
					</div>
				</div>
			</div>
		</form>
	</div>
<script type="text/javascript" src="/gameliquidators/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/gameliquidators/js/bootstrap.min.js"></script>
</body>
</html>