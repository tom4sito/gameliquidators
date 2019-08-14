<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
	<title>test price array</title>
</head>
<body>
<?php
$productPricesArr = array(25000, 28000, 45000, 55000, 60000, 120000, 155000, 199000, 250000, 300000, 350000, 550000);

function getRanges($productPrices){
	$arr_zero_fiftho = array(); 
	$arr_fiftho_hundtho = array(); 
	$arr_hundtho_twohundtho = array(); 
	$arr_twohundtho_fivehundtho = array(); 
	$arr_fivehundtho_onemill = array(); 
	$arr_onemill_twomill = array(); 
	$arr_twomill_fivemill = array(); 
	$arr_fivemill_tenmill = array(); 
	foreach ($productPrices as $value) {
		if($value > 0 AND $value < 50000){
			$arr_zero_fiftho[] = $value;
		}
		elseif($value >= 50000 AND $value < 100000) {
			$arr_fiftho_hundtho[] = $value;
		}
		elseif ($value >= 100000 AND $value < 200000) {
			$arr_hundtho_twohundtho[] = $value;
		}
		elseif ($value >= 200000 AND $value < 500000) {
			$arr_twohundtho_fivehundtho[] = $value;
		}
		elseif ($value >= 500000 AND $value < 1000000) {
			$arr_fivehundtho_onemill[] = $value;
		}
		elseif ($value >= 1000000 AND $value < 2000000) {
			$arr_onemill_twomill[] = $value;
		}
		elseif ($value >= 2000000 AND $value < 5000000) {
			$arr_twomill_fivemill[] = $value;
		}
		elseif ($value >= 5000000 AND $value < 10000000) {
			$arr_fivemill_tenmill[] = $value;
		}
	}

	$priceFilterHtml = "";
	if(!empty($arr_zero_fiftho)){
		$allRanges = rangeMaker($arr_zero_fiftho, 0, 10000, 50000, 10000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_fiftho_hundtho)){
		$allRanges = rangeMaker($arr_fiftho_hundtho, 50000, 75000, 100000, 25000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_hundtho_twohundtho)){
		$allRanges = rangeMaker($arr_hundtho_twohundtho, 100000, 150000, 200000, 50000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_twohundtho_fivehundtho)){
		$allRanges = rangeMaker($arr_twohundtho_fivehundtho, 200000, 300000, 500000, 100000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_fivehundtho_onemill)){
		$allRanges = rangeMaker($arr_fivehundtho_onemill, 500000, 750000, 1000000, 250000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_onemill_twomill)){
		$allRanges = rangeMaker($arr_onemill_twomill, 1000000, 1250000, 2000000, 250000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_twomill_fivemill)){
		$allRanges = rangeMaker($arr_onemill_twomill, 2000000, 3000000, 5000000, 1000000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	if(!empty($arr_twomill_fivemill)){
		$allRanges = rangeMaker($arr_onemill_twomill, 5000000, 7500000, 10000000, 2500000);
		$priceFilterHtml .= writeRangeCheckbox($allRanges);
	}
	echo $priceFilterHtml;
}

function rangeMaker($rangeArray, $trackerStart, $rangeStart, $rangeEnd, $rangeIncrement){
	$mainRangeArr = array();
	for ($i= $rangeStart; $i <= $rangeEnd; $i += $rangeIncrement) {
		$subArray = array();
		$subArray["qty"] = 0;
		$subArray["start"] = $trackerStart;
		$subArray["end"] = $i; 
		foreach ($rangeArray as $value) {
			if($value >= $trackerStart AND $value < $i){
				$subArray["qty"] += 1;
			}
		}
		$trackerStart = $i;
		if($subArray["qty"] > 0){
			$mainRangeArr[] = $subArray;
		}
	}
	return $mainRangeArr;
}

function writeRangeCheckbox($rangeArr){
	$rangeHtml = "";
	foreach($rangeArr as $range){
		$rangeHtml .= "<div>";
		$rangeHtml .= 	"<input type='checkbox' name='pricerange|{$range["start"]}|{$range["end"]}' value='{$range["start"]}' class='pricerange-filter grab-filter' filter-name='{$range["start"]}-{$range["end"]}'>";
		$rangeHtml .= 	"<span> \${$range["start"]} - \${$range["end"]} ({$range["qty"]})</span>";
		$rangeHtml .= "</div>";
	}
	return $rangeHtml;
}

getRanges($productPricesArr);
?>
</body>
</html>