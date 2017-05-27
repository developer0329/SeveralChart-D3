
<?php
# get db connection
include 'config/database.php';
$forecast_id = $_GET['id'];
?>

<form action="" method="POST">
<script src="d3.v3.min.js"></script>
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

	<table style="border:0;width:95%;">
		<tr><td style="border:0;width:10%;text-align:left;"><img src="img/alertsm.png"/>
			<td style="border:0;"><div class="page-header"><h1>Symphony ALERT <br><small style="font-size:12pt;">Continuous Prediction Conformity Monitoring and Automated Analytics for Life Sciences</small></h1></table>
				<div class="panel-heading">


<div style="margin-right:20px;margin-left:20px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Automated Analyst Settings</h1>
        </div>
        <div class="panel-body">
<script>
<?php
	echo "\nvar forecast_id = {$forecast_id};\n";
?>
function rm() {
	if (confirm('Are you sure you want to remove this forecast and its alerts?')) {
		location.href = "remove_forecast.php?id=" + forecast_id;
	}
}
</script>

<p>Settings:</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Element</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>

	<?php
	$query = "SELECT * FROM alert.forecasts WHERE id = {$forecast_id};";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num>0){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo "<tr><td>Name:<td>{$forecastname}";
			echo "<tr><td>Points:<td>{$points}";
			echo "<tr><td>Created:<td>{$created}";
			echo "<tr><td>Product:<td>{$productname}";
		}
	} else {
		echo "System error.  There are no forecasts matching the id. Please advise support.  Sorry for the trouble!";		
	}
	?>  
	
    </tbody>
  </table>
		<p><input class="btn btn-primary" value="Remove" type="button" onclick="rm()" /></p>
		
    </div>
</p>		
		</div>
		</div>

	</div>

</form>
