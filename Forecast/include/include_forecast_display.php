<div class="content_forecast">
 <?php
  session_start();
  if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message']))
  {
  ?>
  <div class="alert alert-info">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php
  echo $_SESSION['success_message'];
  unset($_SESSION['success_message']);
  ?>
  </div>
  <?php
  }
  ?>
<div class="panel panel-default">
<div class="panel-heading">My Forecasts</div>
<div class="panel-body">
<table class="table table-bordered">
    <tbody>
      <tr>
        <td><a href="create_forecast.php"><span class="glyphicon glyphicon-plus"></span> Create new forecast</a></td>
      </tr>
<?php
$alert = array();
$person_id = $_SESSION['user_login'];
include("config/include_database.php");
$stmt = $pdo->prepare("select * from product where company_id=(select company_id from user where person_id=?)");
$stmt->execute(array($person_id));
$product_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($product_rows as $product)
{
	$stmt = $pdo->prepare("select * from forecast where product_id=? order by modification_date desc");
	$stmt->execute(array($product['product_id']));
	$forecast_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($forecast_rows as $forecast)
	{
		$stmt = $pdo->prepare("select count(*) as number from alert where forecast_id=?");
		$stmt->execute(array($forecast['forecast_id']));
		$alert_number = $stmt->fetch(PDO::FETCH_ASSOC);
		if($alert_number['number'] > 0)
		{
			array_push($alert, [$alert_number['number'], $forecast['forecast_id'], $forecast['forecast_name'], $product['product_name']]);
		}
		echo '<tr><td><a href="edit_forecast.php?id='.$forecast['forecast_id'].'">Forecast('.$forecast['forecast_name'].') for Product('.$product['product_name'].')</a></td></tr>';
	}
}
?>
</tbody>
</table>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">My Alerts</div>
<div class="panel-body">
<table class="table table-bordered">
    <tbody>
<?php
foreach($alert as $row)
{
	echo '<tr><td><a href="view_alert.php?id='.$row[1].'" target="_blank">View alerts for Forecast('.$row[2].') for Product('.$row[3].')('.$row[0].' alerts)</a></td></tr>';
}
?>
</tbody>
  </table>
</div>
</div>
</div>