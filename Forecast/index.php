<?php
$login_flag = true;
session_start();
if(!isset($_SESSION['user_login']))
{
	if(isset($_POST['email_address']) && isset($_POST['password']))
	{
		include "config/include_database.php";
		$email_address = trim($_POST['email_address']);
		$password = trim($_POST['password']);
		$stmt = $pdo->prepare("select * from user where email_address=? and password=?");
		$stmt->execute(array($email_address, $password));
		if($stmt->rowCount() == 1)
		{
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['user_login'] = $res['person_id'];
			$login_flag = false;
		}
		else
		{
			$_SESSION['error_message'] = "Email address and Password do not match.";
		}
	}
}
else
{
	$login_flag = false;
}
if($login_flag)
{
	include_once("include/include_header.php");
}
else
{
	include_once("include/include_header_user.php");
}
?>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
    </div>
    <div class="col-sm-10 text-left"> 
      <br /><br /><br />
	  <?php
	  if($login_flag)
	  {
		  session_start();
		  if(isset($_SESSION['error_message']) && !empty($_SESSION['error_message']))
		  {
		  ?>
	  <div class="alert alert-danger">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php
	  echo $_SESSION['error_message'];
	  unset($_SESSION['error_message']);
	  ?>
	  </div>
	  <?php
	  }
	  ?>
	  <div class="card">
	  <form role="form" action="" method="post">
	  <h2>Please sign in</h2>
	  <div class="form-group">
	  <input type="email" class="form-control input-lg" name ="email_address" id="email_address" placeholder="Email address" required="required">
	  </div>
	  <div class="form-group">
	  <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Password" required="required">
	  </div><div class="checkbox">
	  <label><input type="checkbox"> Remember me</label>
	  </div>
	  <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
	  <br /><br />
	  </form>
	  </div>
	  <?php
	  }
	  else
	  {
		  include_once("include/include_forecast_display.php");
	  }
	  ?>
    </div>
    <div class="col-sm-1 sidenav">
      </div>
    </div>
  </div>
</div>
<br />
<?php
include_once("include/include_footer.php");
?>