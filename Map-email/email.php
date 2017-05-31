<?php
	
	session_start();
	
	if(isset($_GET['data']) )
	{
		$_SESSION["data"] = $_GET['data'];
		echo "1";
	}	
	else
	{
		
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Download Repair Market Information</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<div class="container two-page-container">
			<div class="row">
				<div class="col-sm-2">
					<img src="image/3d-doughnut.png" class="two-page">
					<div>3d doughnut</div>
				</div>
				<div class="col-sm-2">
					<img src="image/3d-pie.png" class="two-page">
					<div>3d pie</div>
				</div>
				<div class="col-sm-2">
					<img src="image/3d-pyramid.png" class="two-page">
					<div>3d pyramid</div>
				</div>
				<div class="col-sm-2">
					<img src="image/3d-torus.png" class="two-page">
					<div>3d torus</div>
				</div>
				<div class="col-sm-2">
					<img src="image/area.png" class="two-page">
					<div>area</div>
				</div>
				<div class="col-sm-2">
					<img src="image/area-spline.png" class="two-page">
					<div>area spline</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<img src="image/area-stacked-full.png" class="two-page">
					<div>area stacked full</div>
				</div>
				<div class="col-sm-2">
					<img src="image/area-stacked.png" class="two-page">
					<div>area stacked</div>
				</div>
				<div class="col-sm-2">
					<img src="image/area-stacked-spline-full.png" class="two-page">
					<div>area stacked spline full</div>
				</div>
				<div class="col-sm-2">
					<img src="image/area-stacked-spline.png" class="two-page">
					<div>area stacked spline</div>
				</div>
				<div class="col-sm-2">
					<img src="image/bar.png" class="two-page">
					<div>bar</div>
				</div>
				<div class="col-sm-2">
					<img src="image/bar-range.png" class="two-page">
					<div>bar range</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<img src="image/bar-stacked-full.png" class="two-page">
					<div>bar stacked full</div>
				</div>
				<div class="col-sm-2">
					<img src="image/bar-stacked.png" class="two-page">
					<div>bar stacked</div>
				</div>
				<div class="col-sm-2">
					<img src="image/bar-stacked-sidebyside.png" class="two-page">
					<div>bar stacked side by side</div>
				</div>
				<div class="col-sm-2">
					<img src="image/bubble.png" class="two-page">
					<div>bubble</div>
				</div>
				<div class="col-sm-2">
					<img src="image/doughnut.png" class="two-page">
					<div>doughnut</div>
				</div>
				<div class="col-sm-2">
					<img src="image/financial-candle.png" class="two-page">
					<div>financial candle</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<img src="image/financial-high-low.png" class="two-page">
					<div>financial high low</div>
				</div>
				<div class="col-sm-2">
					<img src="image/funnel.png" class="two-page">
					<div>funnel</div>
				</div>
				<div class="col-sm-2">
					<img src="image/gantt.png" class="two-page">
					<div>gantt</div>
				</div>
				<div class="col-sm-2">
					<img src="image/line-fast.png" class="two-page">
					<div>line fast</div>
				</div>
				<div class="col-sm-2">
					<img src="image/line.png" class="two-page">
					<div>line</div>
				</div>
				<div class="col-sm-2">
					<img src="image/pie.png" class="two-page">
					<div>pie</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<img src="image/point.png" class="two-page">
					<div>point</div>
				</div>
				<div class="col-sm-2">
					<img src="image/pyramid.png" class="two-page">
					<div>pyramid</div>
				</div>
				<div class="col-sm-2">
					<img src="image/scatter-line.png" class="two-page">
					<div>scatter line</div>
				</div>
				<div class="col-sm-2">
					<img src="image/spline.png" class="two-page">
					<div>spline</div>
				</div>
				<div class="col-sm-2">
					<img src="image/step-line.png" class="two-page">
					<div>step line</div>
				</div>
				<div class="col-sm-2">
				</div>
			</div>
			<div class="overlay">
				<div class="row" style="padding-top:90px;">
				
					<div class="col-sm-4 col-sm-offset-4">
						<p id="emailSendBtn" data-toggle="modal" data-target="#emailSendModal">
							Click here to download all your info about auto repair market for free!
						</p>
					</div>
				</div>
			</div>
			
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="emailSendModal" role="dialog">
			<div class="modal-dialog">			
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-body">
						<p>Where should we send your download link?</p>
						<form role="form">
							<div class="form-group">
								<input type="text" id="myemail" placeholder="Enter email">
								<button type="button" id = "sendBtn" class="btn" data-dismiss="modal">SEND ME!</button>
							</div>							
						</form>
					</div>
				</div>			  
			</div>
		</div>
	</body>
	<script>
		$("#sendBtn").click(function(){
			var targetEmail = $("#myemail").val();
			
			$.get("send.php", {email: targetEmail }, function(result){
				alert(result);
			});
			
		});
		$('#myemail').keypress(function (e) {
			var key = e.which;
			if(key == 13)  // the enter key code
			{
				$('#sendBtn').click();
				return false;  
			}
		});   
	</script>
</html>
<?php

	}
	?>