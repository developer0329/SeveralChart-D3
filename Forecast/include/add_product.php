<?php
if(isset($_POST['product_add_submit']) && !empty($_POST['product_add_submit']))
{
	include_once("../config/include_database.php");
	$product_name = trim($_POST['product_name']);
	$company_id = trim($_POST['select_company']);
	try{
	$stmt = $pdo->prepare("insert into product (product_id, product_name, company_id) values (?, ?, ?)");
	$stmt->execute(array('', $product_name, $company_id));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully added product";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding product";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in adding product";
	}
	header("Location: ../display_record.php?name=product&page=1");
}
else if(isset($_POST['product_edit_submit']) && !empty($_POST['product_edit_submit']))
{
	$product_id = trim($_POST['product_id']);
	header("Location: ../edit_product.php?id=".$product_id);
}
else if(isset($_POST['product_save_submit']) && !empty($_POST['product_save_submit']) && isset($_POST['product_id']))
{
	include_once("../config/include_database.php");
	$product_name = trim($_POST['product_name']);
	$company_id = trim($_POST['select_company']);
	$product_id = trim($_POST['product_id']);
	try{
	$stmt = $pdo->prepare("update product set product_name = ?, company_id = ? where product_id = ?");
	$stmt->execute(array($product_name, $company_id, $product_id));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully updated product";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating product";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in updating product";
	}
	header("Location: ../display_record.php?name=product&page=1");
}
else if(isset($_POST['product_delete_submit']) && !empty($_POST['product_delete_submit']) && isset($_POST['product_id']))
{
	include_once("../config/include_database.php");
	try{
	$stmt = $pdo->prepare("delete from product where product_id = ?");
	$stmt->execute(array(trim($_POST['product_id'])));
	if($stmt->rowCount() > 0)
	{
		session_start();
		$_SESSION["success_message"] = "Successfully deleted product";
	}
	else
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting product";
	}
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting product";
	}
	header("Location: ../display_record.php?name=product&page=1");
}
else if(isset($_POST['action']) && $_POST['action'] == "deleteProduct" && isset($_POST['selectValue']))
{
	include_once("../config/include_database.php");
	$product_array = $_POST['selectValue'];
	try{
	foreach($product_array as $product_id)
	{
		$stmt = $pdo->prepare("delete from product where product_id = ?");
		$stmt->execute(array($product_id));
	}
	session_start();
	$_SESSION["success_message"] = "Successfully deleted product";
	}
	catch(Exception $e)
	{
		session_start();
		$_SESSION["success_message"] = "Error in deleting product";
	}
	echo "success";
}
?>
