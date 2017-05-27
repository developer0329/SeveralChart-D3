<?php
if(isset($_POST['user_add_submit']) && !empty($_POST['user_add_submit']))
{
	include_once("../config/include_database.php");
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email_address = trim($_POST['email_address']);
	$company_id = trim($_POST['select_company']);
	$password = trim($_POST['password']);
	try{
	$stmt = $pdo->prepare("insert into user (person_id, firstname, lastname, email_address, company_id, password) values (?, ?, ?, ?, ?, ?)");
	$stmt->execute(array('', $firstname, $lastname, $email_address, $company_id, $password));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully added user";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding user";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding user";
	}
	header("Location: ../display_record.php?name=user&page=1");
}
else if(isset($_POST['user_edit_submit']) && !empty($_POST['user_edit_submit']))
{
	$user_id = trim($_POST['user_id']);
	header("Location: ../edit_user.php?id=".$user_id);
}
else if(isset($_POST['user_save_submit']) && !empty($_POST['user_save_submit']) && isset($_POST['user_id']))
{
	include_once("../config/include_database.php");
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email_address = trim($_POST['email_address']);
	$company_id = trim($_POST['select_company']);
	$password = trim($_POST['password']);
	$person_id = trim($_POST['user_id']);
	try{
	$stmt = $pdo->prepare("update user set firstname = ?, lastname = ?, email_address = ?, company_id = ?, password = ? where person_id = ?");
	$stmt->execute(array($firstname, $lastname, $email_address, $company_id, $password, $person_id));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully updated user";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating user";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating user";
	}
	header("Location: ../display_record.php?name=user&page=1");
}
else if(isset($_POST['user_delete_submit']) && !empty($_POST['user_delete_submit']) && isset($_POST['user_id']))
{
	include_once("../config/include_database.php");
	try{
	$stmt = $pdo->prepare("delete from user where person_id = ?");
	$stmt->execute(array(trim($_POST['user_id'])));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully deleted user";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting user";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting user";
	}
	header("Location: ../display_record.php?name=user&page=1");
}
else if(isset($_POST['action']) && $_POST['action'] == "deleteUser" && isset($_POST['selectValue']))
{
	include_once("../config/include_database.php");
	$user_array = $_POST['selectValue'];
	try{
	foreach($user_array as $person_id)
	{
		$stmt = $pdo->prepare("delete from user where person_id = ?");
		$stmt->execute(array($person_id));
	}
	session_start();
	$_SESSION["success_message"] = "Successfully deleted user";
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting user";
	}
	echo "success";
}
?>
