<?php
include_once("include/include_header.php");
?>  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
    </div>
    <div class="col-sm-10 text-left"> 
      <br /><br /><br />
	  <div class="content_forecast">
	  <?php
	  include("config/include_database.php");
	  $stmt = $pdo->prepare("select * from company order by company_name asc");
	  $stmt->execute();
	  if($stmt->rowCount() > 0)
	  {
		  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  ?>
	  <form class="form-horizontal" role="form" action="include/add_product.php" method="post">
	  <h2>Create new product</h2>
	  <div class="form-group">
	  <label class="control-label col-sm-2" for="product_name">Product Name:</label>
	  <div class="col-sm-4">
	  <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" required="required">
	  </div>
	  </div>
	  <div class="form-group">
	  <label class="control-label col-sm-2" for="select_company">Select Company:</label>
	  <div class="col-sm-4">
	  <select class="form-control" name="select_company" id="select_company">
	  <?php
	  foreach($rows as $company)
	  {
		  echo '<option value="'.$company['company_id'].'">'.$company['company_name'].'</option>';
	  }
	  ?>
	  </select>
	  </div>
	  </div>
	  <div style="text-align: center;">
	  <button type="submit" class="btn btn-primary" name="product_add_submit" value="product_add_submit">Save</button>
	  <a href="display_record.php?name=product&page=1" class="btn btn-primary">Cancel
	  </a>
	  </div>
	  </form>
	  <?php
	  }
	  else
	  {
		  echo 'There are no companies. First create a company. <a href="display_record.php?name=product&page=1" class="btn btn-primary">Cancel
	      </a>';
	  }
	  ?>
	  </div>
    </div>
    <div class="col-sm-1 sidenav">
      </div>
    </div>
  </div>
</div>
<br />
</body>
</html>