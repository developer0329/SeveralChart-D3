<?php
include_once("include/include_header_user.php");
?>
<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-1 sidenav"></div>
		<div class="col-sm-10 text-left"><br/><br/><br/>
		<div class="content_forecast">
		<?php
			if(isset($_GET['id']) && is_numeric($_GET['id']))
			{
				$forecast_id = trim($_GET['id']);
				$stmt = $pdo->prepare("select * from forecast where forecast_id = ?");
				$stmt->execute(array($forecast_id));
				if($stmt->rowCount() > 0)
				{
					$forecast_row = $stmt->fetch(PDO::FETCH_ASSOC);
					$stmt = $pdo->prepare("select * from product where company_id=(select company_id from user where person_id=?)");
					$stmt->execute(array($person_id));
					if($stmt->rowCount() > 0)
					{
						$product_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		?>
			<form class="form-horizontal" role="form" name="frmNext" action="include/add_forecast.php" method="post">
				<h2>Edit forecast</h2>
				<div class="form-group">
					<label class="control-label col-sm-2" for="forecast_name">Forecast name:</label>
					<div class="col-sm-6"> 
						<input type="text" class="form-control" name="forecast_name" id="forecast_name" value="<?php echo $forecast_row['forecast_name']; ?>" placeholder="Forecast name" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="select_product">Select Product:</label>
					<div class="col-sm-6">
						<select class="form-control" name="select_product" id="select_product" onchange="setProduct();">
						<?php
							foreach($product_rows as $product)
							{
								$selected = '';
								if($forecast_row['product_id'] == $product['product_id'])
									$selected = 'selected="selected"';
								echo '<option value="'.$product['product_id'].'" '.$selected.'>'.$product['product_name'].'</option>';
							}
						?>
						</select>
					</div>
				</div>
				<input type="hidden" name="forecast_points" id="forecast_points" value="<?php echo $forecast_row['forecast_points']; ?>">
				<input type="hidden" name="forecast_id" id="forecast_id" value="<?php echo $forecast_id; ?>">
				<div class="form-group">
					<div class="col-sm-2 btn btn-default btn-file">Upload Forecast
						<input type = "file" id = "uploader">
					</div>
					<div class="col-sm-8">
						<div class="panel panel-default" >	
							<div class="panel-heading">
								<h4 id="edit-chart-title">Forecast Chart</h4>
								<p><div id="chart"></div></p>
							</div>
						</div>
						<div class="panel panel-default" id="tabled" style="display:none;" >	
							<div class="panel-heading">
								<h4>Forecast Table</h4>
								<div id="table"></div>
							</div>
						</div>
					</div>
				</div>

				<div style="text-align: center;">
					<button type="submit" class="btn btn-primary" name="forecast_save_submit" value="forecast_save_submit" onclick="saveForecast();">Save</button>
					<a href="index.php" class="btn btn-primary">Cancel</a>
					<input type="hidden" name="delete_button" value="">
					<button type="button" class="btn btn-danger" name="forecast_delete_submit" value="forecast_delete_submit" onclick="delete_forecast();">
						<span class="glyphicon glyphicon-remove"></span>Delete
					</button>
				</div>
			</form>

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
	  
	  function setProduct() 
	  { 
		  product = $("#select_product").val();
	  }

	  function delete_forecast()
	  {
		  if(confirm("Are you sure you want to delete the forecast?"))
		  {
			  var f = document.forms['frmNext'];
			  f.delete_button.value = "delete_button";
			  f.submit();
		  }
	  }
	  </script>
	  <script src="js/d3.v3.min.js"></script>
	  <script src="js/regression.js"></script>
	  <script>
		$(document).ready(function() 
		{
			setYLabel();
			//setXLabel();
			
			product = $("#select_product").val();
			<?php
			  $json = $forecast_row['forecast_points'];
		      if($json)
		      {
				  $json = str_replace("target", "expected", $json);
				  echo "data = ".$json.";";
			  }
			?>
			if(data.length > 0)
			{
			  create_table(data);
			  render();
			}
		});
	  </script>
	  <?php
	  }
	  }
	  }
	  ?>
	  </div>
    </div>
    <div class="col-sm-1 sidenav">
      </div>
    </div>
  </div>
</div>
<br />
</body>
</html>
