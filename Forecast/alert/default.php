<?php
# this is the first page displayed -- shows my forecasts and alerts 

# get db connection
include 'config/database.php';
?>

<div style="margin-right:20px;margin-left:20px;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">My Forecasts</h1>
        </div>
        <div class="panel-body">
<script>
function openForecast(i) {
	location.href = "view_forecast.php?id=" + i;
}
function dos(a) {
	if ( a != "" ) {
		// open url to view forecast
		
	} else {
		document.forms[0].submit();
	}
}

</script>
<div class="list-group">
  <a href="javascript:dos('');" class="list-group-item"> + Create new forecast</a>  
  <?php
	$query = "SELECT * FROM alert.forecasts";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num>0){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo "<a href=\"javascript:openForecast('{$id}')\" class=\"list-group-item\">{$forecastname} ({$productname})</a>";
		}
	} 
  ?>  
</div>
		<form action="<?php $_PHP_SELF ?>" method="POST">
		<input type="hidden" name="p" value="start" />
		</form>
		</div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">My Alerts</h1>
        </div>
        <div class="panel-body">

<div class="list-group">
<?php
$query = "select ft.fid id, f.forecastname name, ft.tot total from forecasts f,( select forecast_id fid, count(*) tot from alerts group by forecast_id ) ft;";
$stmt = $con->prepare($query);
$stmt->execute();
$num = $stmt->rowCount();
if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo "<a target=\"_blank\" href=\"view_alerts.php?id={$id}\" class=\"list-group-item\">View alerts for {$name} ({$total} alerts)</a>";
	}
} 
?>
</div>

	</div>

</div>
