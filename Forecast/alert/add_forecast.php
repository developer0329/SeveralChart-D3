<!DOCTYPE HTML>

<?php
// include database connection
include 'config/database.php';

echo "<h2>Debugging info</h2><table><tr><td><td>";
$points = $_POST['points'];


foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "<input type=\"hidden\" value='" . $value . "' name=\"" . $key . "\"/>";
        echo "</td>";
        echo "</tr>";
}

  
$query = "INSERT INTO alert.forecasts (frequency,delivery,productname,productid, forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (0,1,'" . $_POST['product'] . "'," . $_POST['product'][0] . ",'" . $_POST['forecastname'] . "','','" . $points . "','',1,5, NOW(),NOW());";

//insert
$stmt = $con->prepare($query);
$stmt->execute();
$query = "commit;";
$stmt = $con->prepare($query);
$stmt->execute(); 

echo "<script>alert('Added!');location.href='/alert/';</script>";

?>

