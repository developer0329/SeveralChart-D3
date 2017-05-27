
<?php
  if( $_POST["forecastname"] ) {
$_SESSION['forecastname']  = $_POST["forecastname"] ;
  }
?>


<div style="margin-left:20px;margin-right:20px;">
		<H4>Forecast: <small><?php echo $_SESSION["forecastname"]; ?> </small></H4>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Step 1:  Enter your forecast.</h1>
        </div>
        <div class="panel-body">
		
		<ol>
		
			<li>For each forecast input your target, min, and max data. Click "add forecast".
			<div class="panel-heading">
				Target:
				<input type="number" id="target" >
				Min:
				<input type="number" id="min" >
				Max:
				<input type="number" id="max" >
				<button onclick="addForecast()">Add Forecast</button>
				<button onclick="clearArray()">Clear All Points</button>
				<br/>
				<label class="control-label">OR Select File</label>
<input id="input-1" type="file" class="file">
				<div id="chartdiv" style="display:none;margin-top:20px;" class="panel panel-default" >	
					<div class="panel-heading">
						<center>Forecast</center>
						<div style="margin-top:5px;" id="chart"></div>
					</div>
				</div>				
			</div>

			
			<li>Once all the targets are added, click "Forecast Complete" to proceed to the next page.<br/>
			<button onclick="saveForecast()">Forecast Complete</button>
		</ol>
		
		</div>
    </div>
</div>

<form name="frmNext" action="<?php $_PHP_SELF ?>" method="POST">
	<input type="hidden" name="points" value="" />
	<input type="hidden" name="formula" value="" />
	<input type="hidden" name="p" value="" />
	<input type="hidden" name="forecastname" value="<?php echo $_SESSION['forecastname'];?>" />
</form>
