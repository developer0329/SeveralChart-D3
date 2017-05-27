<?php
include_once("include/include_header_user.php");
?>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
    </div>
    <div class="col-sm-10 text-left"> 
      <br /><br /><br />
	  <div class="content_forecast">
<div class="panel panel-default">
<div class="panel-heading">Alerts</div>
<div class="panel-body">
<?php
if(isset($_GET['id']) && is_numeric($_GET['id']))
{
	$stmt = $pdo->prepare("select * from alert where forecast_id=?");
	$stmt->execute(array($_GET['id']));
	if($stmt->rowCount() > 0)
	{
		$alert_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table table-bordered">
    <tbody>
<?php
foreach($alert_rows as $alert)
{
	echo '<tr><td><a href="/alerts/'.$alert['alert_id'].'" target="_blank">Alert Id = '.$alert['alert_id'].' Creation Date = '.$alert['creation_date'].'</a></td></tr>';
}
?>
</tbody>
</table>
<?php
}
}
?>
</div>
</div>
</div>
    </div>
    <div class="col-sm-1 sidenav">
      </div>
    </div>
  </div>
</div>
<br />
<?php
include_once("include/include_footer.php");
?>