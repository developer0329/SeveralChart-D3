<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Forecast Alert System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Sales Forecast Alert System</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
		<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Manage
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="display_record.php?name=user&page=1">Users</a></li>
		  <li><a href="display_record.php?name=company&page=1">Companies</a></li>
		  <li><a href="display_record.php?name=product&page=1">Products</a></li>
        </ul>
		</li>
      </ul>
	  <?php
	  include_once("session_available.php");
	  $person_id = $_SESSION['user_login'];
	  if($person_id)
	  {
		  include "config/include_database.php";
		  $stmt = $pdo->prepare("select * from user where person_id=?");
		  $stmt->execute(array($person_id));
		  if($stmt->rowCount() == 1)
		  {
			$res = $stmt->fetch(PDO::FETCH_ASSOC);	
			echo '<span style="float: right; margin-right: 10px;"><h4>Welcome '.$res['firstname'].' '.$res['lastname'].'&nbsp;&nbsp;';
		  }
	  }
	  ?>
	<a href="logout.php">Logout</a></span>
    </div>
  </div>
</nav>