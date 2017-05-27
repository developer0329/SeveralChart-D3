<?php
$page_name = htmlspecialchars($_POST["p"])
?>
<!DOCTYPE html>

<meta charset="utf-8">
<title>NYU-Symphony ALERT</title>
<head>

<script src="js/d3.v3.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<table style="width:95%;"><tr><td style="width:10%;text-align:left;"><img src="img/alertsm.png"/>
	<td><div class="page-header"><h1>Symphony ALERT <br><small style="font-size:12pt;">Continuous Prediction Conformity Monitoring and Automated Analytics for Life Sciences</small></h1></table>
<?php 
if($page_name=="start") {
	include("start.php"); 
} elseif ( $page_name == "points") {
	include("points.php"); 
} elseif ( $page_name == "settings") {
	include("settings.php"); 
} else {
	session_start();
	include("default.php"); 	
}
?>
	<script src="js/regression.js"></script>
</body>