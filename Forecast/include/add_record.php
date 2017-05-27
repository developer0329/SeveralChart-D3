<?php
if(isset($_POST['company_name_add']) && !empty($_POST['company_name_add']))
{
	include_once("../config/include_database.php");
	$company_name = trim($_POST['company_name_add']);
	try{
	$stmt = $pdo->prepare("insert into company (company_id, company_name) values (?, ?)");
	$stmt->execute(array('', $company_name));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully added company";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding company";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding company";
	}
	header("Location: ../display_record.php?name=company&page=1");
}
else if(isset($_POST['company_save_submit']) && isset($_POST['company_name_update']) && !empty($_POST['company_name_update']) && isset($_POST['company_id']))
{
	include_once("../config/include_database.php");
	$company_name = trim($_POST['company_name_update']);
	$company_id = trim($_POST['company_id']);
	try{
	$stmt = $pdo->prepare("update company set company_name = ? where company_id = ?");
	$stmt->execute(array($company_name, $company_id));
	session_start();
	$_SESSION["success_message"] = "Successfully updated company";
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating company";
	}
	header("Location: ../display_record.php?name=company&page=1");
}
else if(isset($_POST['company_delete_submit']) && isset($_POST['company_id']))
{
	include_once("../config/include_database.php");
	$company_id = trim($_POST['company_id']);
	try{
	$stmt = $pdo->prepare("delete from company where company_id = ?");
	$stmt->execute(array($company_id));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully deleted company";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting company";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting company";
	}
	header("Location: ../display_record.php?name=company&page=1");
}
else if(isset($_POST['action']) && $_POST['action'] == "deleteCompany" && isset($_POST['selectValue']))
{
	include_once("../config/include_database.php");
	$company_array = $_POST['selectValue'];
	try{
	foreach($company_array as $company_id)
	{
		$stmt = $pdo->prepare("delete from company where company_id = ?");
		$stmt->execute(array($company_id));
	}
	session_start();
	$_SESSION["success_message"] = "Successfully deleted company";
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting company";
	}
	echo "success";
}
?>
