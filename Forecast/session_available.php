<?php
session_start();
if(!isset($_SESSION['user_login']) || !is_numeric($_SESSION['user_login']))
{
	header("Location: index.php");
	exit();
}
?>