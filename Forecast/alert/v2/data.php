<?php

	# generate sales data for product with ID product_id starting at start_date

	# db access
	include '../config/database.php';
	
	# get parameters from querystring
	$prod_id = $_GET['product_id'];
	$start_date = $_GET['start_date'];
	
	# generate and execute query
	$query = "SELECT observation_date, observed_value FROM alert.sales  WHERE observation_date > str_to_date('{$start_date}','mm-dd-yyyy') AND product_id = 1";
	$query = "SELECT observation_date, observed_value FROM alert.sales WHERE  product_id = {$prod_id};";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$num = $stmt->rowCount();
	$i = 0;
	
	# output resutls in JSON for consumption by ajax code in overlay script
	if($num>0){
		echo "{\"values\":[";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if ( $i > 0) {
				echo ",{$observed_value}";
			} else {
				echo "{$observed_value}";
			}
			$i = $i + 1;
		}
		echo "],\"flag\":false}";
	} 
?>
