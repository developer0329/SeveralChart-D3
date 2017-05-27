<?php
include_once("include/include_header.php");
?>
<script src="js/jquery.tablesorter.js"></script>
<div class="container-fluid text-center">    
 <div class="row content">
  <div class="col-sm-1 sidenav">
  </div>
  <div class="col-sm-10 text-left"> 
  <br /><br /><br />
  <div class="content_forecast">
<?php
include_once("include/read_record.php");
$record_name = "company";
if(isset($_GET['name']) && !empty($_GET['name']))
{
	$record_name = trim($_GET['name']);
}
$page = 1;
if(isset($_GET['page']) && is_numeric($_GET['page']))
{
	$page = trim($_GET['page']);
}
if($record_name == "company")
{
  $records = fetch_record($record_name, "company_name", ($page - 1)*20);
  $number_result = fetch_count($record_name);
  $number = $number_result['number'];
  include_once("include/include_company_display.php");
}
else if($record_name == "user")
{
  $records = fetch_record($record_name, "firstname", ($page - 1)*20);
  $number_result = fetch_count($record_name);
  $number = $number_result['number'];
  include_once("include/include_user_display.php");
}
else if($record_name == "product")
{
  $records = fetch_record($record_name, "product_name", ($page - 1)*20);
  $number_result = fetch_count($record_name);
  $number = $number_result['number'];
  include_once("include/include_product_display.php");
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
<?php
include_once("include/include_footer.php");
?>