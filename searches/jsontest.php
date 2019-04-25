<?php

$completeList["products"] = array();
$completeList["filters"] = "platform|ps4";

// $completeList["products"][] = array('image'=>'fifa19.jpg', 'platform'=>'ps4', 'price'=>65);
// $completeList["products"][] = array('image'=>'halo_3.jpg', 'platform'=>'xbox', 'price'=>50);

for ($i=0; $i < 4; $i++) { 
	for ($i=0; $i < 6; $i++) { 
		$tempArr = array('image'=>'game$i', 'platform'=>'ps4$i', 'price'=>$i * 4);
		$completeList["products"][] = $tempArr;
	}
}



$encodedProduct = json_encode($completeList);

 var_dump($encodedProduct);

?>