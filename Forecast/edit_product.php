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
	  if(isset($_GET['id']) && is_numeric($_GET['id']))
	  {
		  $product_id = trim($_GET['id']);
	  include("config/include_database.php");
	  $stmt = $pdo->prepare("select * from product where product_id = ?");
	  $stmt->execute(array($product_id));
	  if($stmt->rowCount() > 0)
	  {
		  $product_row = $stmt->fetch(PDO::FETCH_ASSOC);
		  $stmt = $pdo->prepare("select * from company order by company_name asc");
		  $stmt->execute();
		  if($stmt->rowCount() > 0)
		  {
			  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  ?>
	  <form class="form-horizontal" role="form" action="include/add_product.php" method="post">
	  <h2>Edit product</h2>
	  <div class="form-group">
	  <label class="control-label col-sm-2" for="product_name">Product Name:</label>
	  <div class="col-sm-4">
	  <input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $product_row['product_name']; ?>" placeholder="Product Name" required="required">
	  </div>
	  </div>
	  <div class="form-group">
	  <label class="control-label col-sm-2" for="select_company">Select Company:</label>
	  <div class="col-sm-4">
	  <select class="form-control" name="select_company" id="select_company">
	  <?php
	  foreach($rows as $company)
	  {
		  $selected = '';
		  if($product_row['company_id'] == $company['company_id'])
			  $selected = 'selected="selected"';
		  echo '<option value="'.$company['company_id'].'" '.$selected.'>'.$company['company_name'].'</option>';
	  }
	  ?>
	  </select>
	  </div>
	  </div>
	  <input type="hidden" class="form-control" name="product_id" value="<?php echo $product_id; ?>">
	  <div style="text-align: center;">
	  <button type="submit" class="btn btn-primary" name="product_save_submit" value="product_save_submit">Save</button>
	  <a href="display_record.php?name=product&page=1" class="btn btn-primary">Cancel
	  </a>
	  </div>
	  </form>
	  <?php
	  }
	  }
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
