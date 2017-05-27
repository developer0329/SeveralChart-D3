
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

<script>
<?php
	echo "\nvar forecast_id = " . $forecast_id . ";\n";

$query = "select * from alert.forecasts where forecast_id=" . $forecast_id . ";";
$stmt = $con->prepare($query);
$stmt->execute();	
?>
function rm() {
	if (confirm('Are you sure you want to remove this alert?')) {
		//location.href = "remove_forecast.php?id=" + forecast_id;
	}
}
</script>

  <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Alerts</h1>
        </div>
        <div class="panel-body">

<div class="list-group">
<?php
$query = "select * from alert.alerts where forecast_id=" . $forecast_id . ";";
$stmt = $con->prepare($query);
$stmt->execute();
$num = $stmt->rowCount();
if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo "<a target=\"_blank\" href=\"report.pdf\" class=\"list-group-item\">";
		echo "{$observation_date} - {$observed_value} {$hilo} range {$min}-{$max}";
		echo "</a>";
	}
} else {
	echo "No Alerts!";
}
?>
</div>

	
</div>

</form>
