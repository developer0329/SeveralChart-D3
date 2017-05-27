<!DOCTYPE HTML>
<html>
    <head>
        <title>Forecasts</title>
  
    </head>

<body>
<!-- just a header label -->
<h1>Forecasts</h1>
 
<?php
// include database connection
include 'config/database.php';
 
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// if it was redirected from delete.php
if($action=='deleted'){
    echo "<div>Record was deleted.</div>";
}
 
// select all data
$query = "SELECT * FROM alert.forecasts";
$stmt = $con->prepare($query);
$stmt->execute();
 
// this is how to get number of rows returned
$num = $stmt->rowCount();
 
// link to create record form
echo "<div>";
    echo "<a href='create.php'>Create New Record</a>";
echo "</div>";
 
//check if more than 0 record found
if($num>0){
 
    echo "<table>";//start table
     
        //creating our table heading
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Description</th>";
            echo "<th>Created</th>";
            echo "<th>Modified/th>";
        echo "</tr>";
         
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['firstname'] to
            // just $firstname only
            extract($row);
             
            // creating new table row per record
            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$forecastname}</td>";
                echo "<td>{$created}</td>";
                echo "<td>{$modified}</td>";
                echo "<td>";
                    // we will use this links on next part of this post
                    echo "<a href='update.php?id={$id}'>Edit</a>";
                    echo " / ";
                    // we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_user({$id});'>Delete</a>";
                echo "</td>";
            echo "</tr>";
        }
     
    // end table
    echo "</table>";
     
}
 
// if no records found
else{
    echo "<div>No records found.</div>";
}
?>
</body>
</html>
