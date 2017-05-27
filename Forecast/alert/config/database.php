<?php
$host = "localhost";
$db_name = "alert";
$username = "admin";
$username = "root";
$password = "Sba5rtb!";
$password = "wesvefaj";
$password = "root" ;

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
	
}
 
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>
