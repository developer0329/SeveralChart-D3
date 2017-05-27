
<?php
# get db connection
include 'config/database.php';
?>

<script>
function update_product() {
	var product_id = document.getElementById("product").options[document.getElementById("product").selectedIndex].value;

}
</script>

<form action="/alert/v2/index.php" method="POST">

<div style="margin-right:20px;margin-left:20px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Set up your forecast</h1>
        </div>
        <div class="panel-body">
<p>
		<input type="hidden" name="p" value="points"/>
		
        <input class="form-control" type="text" name="forecastname" id="forecastname" placeholder="Forecast Name"">

      <label for="product">Select product:</label>
<?php
	$query = "SELECT * FROM alert.products;";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num>0){
		echo "<select onchange=\"update_product();\" name=\"product\" class=\"form-control\" id=\"product\">";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			echo "<option value=\"{$product_id}.{$product_name}\">{$product_name}</option>";
		}
		echo "</select>";
	} else {
		echo "System error.  There are no products available. Please advise support.  Sorry for the trouble!";		
	}
	?>   
    </div>
</p>		

		</div>
		<p><input class="btn btn-primary" value="Next" type="submit"/></p>

		</div>

	</div>

</form>
