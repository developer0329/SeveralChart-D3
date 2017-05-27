<?php
include_once("include/include_header_user.php");
?>
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
	var product = "";
	
	$(document).ready(function() 
	{ 
		product = $("#select_product").val();
	});

	function setProduct() 
	{ 
		product = $("#select_product").val();
	}
</script>

<script src="js/d3.v3.min.js"></script>

<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-1 sidenav">
		</div>
		<div class="col-sm-10 text-left"> 
			<br/><br /><br />
			<div class="content_forecast">
				<?php
					$stmt = $pdo->prepare("select * from product where company_id=(select company_id from user where person_id=?)");
					$stmt->execute(array($person_id));
					if($stmt->rowCount() > 0)
					{
						$product_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				?>
				
				<form class="form-horizontal" role="form" name="frmNext" action="include/add_forecast.php" method="post"  onsubmit="saveForecast();">
					<h2>Create new forecast</h2>
					<div class="form-group">
						<label class="control-label col-sm-2" for="forecast_name">Forecast name:</label>
						<div class="col-sm-6"> 
							<input type="text" class="form-control" name="forecast_name" id="forecast_name" placeholder="Forecast name" required="required">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="select_product">Select Product:</label>
						<div class="col-sm-6">
							<select class="form-control" name="select_product" id="select_product" onchange="setProduct();">
								<?php
								foreach($product_rows as $product)
								{
									echo '<option value="'.$product['product_id'].'">'.$product['product_name'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<input type="hidden" name="forecast_points" id="points" value="">

					<div class="form-group">
						<div class="col-sm-2 btn btn-default btn-file">Upload Forecast
							<input type = "file" id = "uploader">
						</div>
						<div class="col-sm-8">
							<div class="panel panel-default" >	
								<div class="panel-heading">
									<h4 id="new-chart-title">Forecast Chart</h4>
									<p><div id="chart"></div></p>
								</div>
							</div>
							<div class="panel panel-default" id="tabled" style="display:none;" >	
								<div class="panel-heading">
									<h4>Forecast Table</h4>
									<p>
									<div id="table"></div>
								</div>
							</div>
						</div>
					</div>
					<div style="text-align: center;">
						<button type="submit" class="btn btn-primary" name="forecast_add_submit" value="forecast_add_submit">Save</button>
						<a href="index.php" class="btn btn-primary">Cancel</a>
					</div>
				</form>
				
				<script src="js/regression.js"></script>
				<?php
				}
				else
				{
					echo 'There are no products of your company. When the products are there, you will be able to create a forecast. <a href="index.php" class="btn btn-primary">Cancel</a>';
				}
				?>
	 
			</div>
		</div>
		<div class="col-sm-1 sidenav"></div>
	</div>
</div>
<br/>
<script>
$(document).ready(function() 
{
	setTitle();
});
</script>
</body>
</html>
