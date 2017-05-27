
<?php
  if( $_POST["forecastname"] ) {
$_SESSION['forecastname']  = $_POST["forecastname"] ;
  }
?>

<!DOCTYPE html>
<meta charset="utf-8">
<title>Symphony ALERT UI v2</title>
<head>

<script>
function KeyPress(e) {
      var evtobj = window.event? event : e
      if (evtobj.keyCode == 90 && evtobj.ctrlKey) addActualData();
      if (evtobj.keyCode == 75 && evtobj.ctrlKey) showTableD();
}
function showTableD() {
	document.getElementById("tabled").style.display="";
}

// setup capture for ctrl-z : load actuals and ctrl-k: show table of data points
document.onkeydown = KeyPress;

// POSTed vars for access by client
<?php
foreach ($_POST as $key => $value) {
	echo "var {$key} = \"{$value}\";\n";
}
?>


</script>
<script src="d3.v3.min.js"></script>
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

	<table style="border:0;width:95%;">
		<tr><td style="border:0;width:10%;text-align:left;"><img src="../img/alertsm.png"/>
			<td style="border:0;"><div class="page-header"><h1>Symphony ALERT <br><small style="font-size:12pt;">Continuous Prediction Conformity Monitoring and Automated Analytics for Life Sciences</small></h1></table>
				<div class="panel-heading">
	<span style="margin-top:0;"  class="btn btn-default btn-file">
	Upload Forecast
	<input type = "file" id = "uploader">
	</span><br/>
</div>

		<div class="col-lg-8">
			<div class="panel panel-default" >	
				<div class="panel-heading">
					<h4>Forecast Chart</h4>
					<p>
					<div id="chart"></div>
	<button onclick="saveForecast()">Forecast Complete</button>
				</div>
			</div>	
			<div class="panel panel-default" id="tabled" style="display:none;" >	
				<div class="panel-heading">
					<h4>Forecast Table</h4>
					<p>
					<div id="table"></div>
				</div>
			</div>	
	<script src="regression.js"></script>

</body>

<form name="frmNext" action="/alert/index.php" method="POST">
	<input type="hidden" name="points" value="" />
	<input type="hidden" name="formula" value="" />
	<input type="hidden" name="product" value="<?php echo $_POST["product"]; ?>" />
	<input type="hidden" name="p" value="" />
	<input type="hidden" name="forecastname" value="<?php echo $_SESSION['forecastname'];?>" />
</form>

