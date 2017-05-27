
<?php
  if( $_POST["forecastname"] ) {
$_SESSION['forecastname']  = $_POST["forecastname"] ;
  }
?>

<!DOCTYPE html>
<meta charset="utf-8">
<title>Symphony ALERT UI v2</title>
<head>

<script src="d3.v3.min.js"></script>
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

	<table style="border:0;width:95%;">
		<tr><td style="border:0;width:10%;text-align:left;"><img src="../img/alertsm.png"/>
			<td style="border:0;"><div class="page-header"><h1>Symphony ALERT <br><small style="font-size:12pt;">Continuous Prediction Conformity Monitoring and Automated Analytics for Life Sciences</small></h1></table>
<div class="panel-heading">
					<H4>Forecast: <small><?php echo $_SESSION["forecastname"]; ?> </small></H4>
					</div>
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-4">
			<div class="panel panel-default" >
				<div class="panel-heading">
					<h4>Add Forecast Manually</h4>
					Expected:
					<input class="form-control" type="number" id="expected" >
					<p>
					Min:
					<input class="form-control" type="number" id="min" >
					<p>
					Max:
					<input class="form-control" type="number" id="max" >
					<p>
					<button  class="btn btn-success" onclick="addForecastByPoint()">Add Forecast</button>
					<button class="btn btn-danger" onclick="clearForecastArray()">Clear All Points</button>
				</div>
			</div>	
		
			<div class="panel panel-default" >	
				<div class="panel-heading">
					<h4>Add Forecast By File</h4>
					<span class="btn btn-default btn-file">
						Upload File
						<input type = "file" id = "uploader">
					</span>
					<button class="btn btn-danger" onclick="clearForecastArray()">Clear All Points</button>
				</div>
			</div>
		
			<div class="panel panel-default" >	
				<div class="panel-heading">
					<h4>Load Actual Data</h4>
					<button  class="btn btn-success" onclick = "addActualData()">Actual Data</button>
					<button class="btn btn-danger" onclick = "clearActualArray()">Clear Actual Data</button>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default" >	
				<div class="panel-heading">
					<h4>Forecast Chart</h4>
					<p>
					<div id="chart"></div>
				</div>
			</div>	
		Once all the targets are added, click "Forecast Complete" to proceed to the next page.<br/>
			<button onclick="saveForecast()">Forecast Complete</button>
			<div class="panel panel-default" >	
				<div class="panel-heading">
					<h4>Forecast Table</h4>
					<p>
					<div id="table"></div>
				</div>
			</div>	
		</div>
	</div>
	<script src="regression.js"></script>

</body>

<form name="frmNext" action="/alert/index.php" method="POST">
	<input type="hidden" name="points" value="" />
	<input type="hidden" name="formula" value="" />
	<input type="hidden" name="p" value="" />
	<input type="hidden" name="forecastname" value="<?php echo $_SESSION['forecastname'];?>" />
</form>

