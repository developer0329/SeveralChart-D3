<?php
# get db connection
include 'config/database.php';
$forecast_id = $_GET['id'];

# drop alerts related to this forecast
$query = "DELETE FROM forecasts WHERE id = {$forecast_id};";
$stmt = $con->prepare($query);
$stmt->execute();

# drop the forecast
$query = "DELETE FROM forecasts WHERE id = {$forecast_id};";
$stmt = $con->prepare($query);
$stmt->execute();
	
?>
<script>
	alert( "Removed!");
	location.href = "/alert/";
</script>