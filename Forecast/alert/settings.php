
<form action="add_forecast.php" method="POST">

<div style="margin-right:20px;margin-left:20px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Automated Analyst Settings</h1>
        </div>
        <div class="panel-body">
<p>

<div class="form-group">
  <label for="sel1">Frequency of Analysis:</label>
  <select class="form-control" id="sel1">
    <option>More than once a day</option>
    <option>Daily</option>
    <option>Weekly</option>
    <option>Monthly</option>
    <option>Quarterly</option>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Delivery Method:</label>
  <select class="form-control" id="sel1">
    <option>Send a link to dashboard via e-mail</option>
    <option>Send a link to dashboard via SMS</option>
    <option>Send the report as e-mail</option>
    <option>Push data to staging table for access by other applications</option>
  </select>
</div>


<p>Please review the data listed below:</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Element</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>

<?php
while (list ($key, $val) = each ($_SESSION)) { 
	echo "<tr><td>$key<td>$val"; 
} 
foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
	echo "<input type=\"hidden\" value='" . $value . "' name=\"" . $key . "\"/>";
        echo "</td>";
        echo "</tr>";
}
?>
    </tbody>
  </table>

<script>
function add_forecast() {
	
	document.forms[0].submit();
}
</script>
		
		<input type="hidden" name="p" value="confirmInsert"/>		
    </div>
</p>		

		</div>
		<p><input class="btn btn-primary" value="Confirm and Start" type="submit"/></p>

		</div>

	</div>

</form>
