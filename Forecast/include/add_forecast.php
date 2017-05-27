<?php
if(isset($_POST['forecast_add_submit']) && !empty($_POST['forecast_add_submit']))
{
	include_once("../config/include_database.php");
	$forecast_name = trim($_POST['forecast_name']);
	$product_id = trim($_POST['select_product']);
	$forecast_points = trim($_POST['forecast_points']);
	try{
	$stmt = $pdo->prepare("insert into forecast (forecast_id, forecast_name, product_id, forecast_points, creation_date, modification_date) values (?, ?, ?, ?, ?, ?)");
	$stmt->execute(array('', $forecast_name, $product_id, $forecast_points, date('Y:m:d H:i:s'), date('Y:m:d H:i:s')));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully added forecast";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding forecast";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding forecast";
	}
	header("Location: ../index.php");
}
else if(isset($_POST['forecast_save_submit']) && !empty($_POST['forecast_save_submit']) && is_numeric($_POST['forecast_id']))
{
	include_once("../config/include_database.php");
	$forecast_name = trim($_POST['forecast_name']);
	$product_id = trim($_POST['select_product']);
	$forecast_points = trim($_POST['forecast_points']);
	$forecast_id = trim($_POST['forecast_id']);
	try{
	$stmt = $pdo->prepare("update forecast set forecast_name = ?, product_id = ?, forecast_points = ?, modification_date = ? where forecast_id = ?");
	$stmt->execute(array($forecast_name, $product_id, $forecast_points, date('Y:m:d H:i:s'), $forecast_id));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully updated forecast";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating forecast";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating forecast";
	}
	header("Location: ../index.php");
}
else if(isset($_POST['delete_button']) && (trim($_POST['delete_button']) == "delete_button") && is_numeric($_POST['forecast_id']))
{
	include_once("../config/include_database.php");
	try{
	$stmt = $pdo->prepare("delete from forecast where forecast_id = ?");
	$stmt->execute(array(trim($_POST['forecast_id'])));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully deleted forecast";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting forecast";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting forecast";
	}
	header("Location: ../index.php");
}
?>
