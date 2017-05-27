<?php
$host = "localhost";
$db_name = "sale_forecast";
$username = "root";
$password = "";
$pdo = new PDO('mysql:host='.$host.';dbname='.$db_name.';charset=utf8', $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));	
?>
