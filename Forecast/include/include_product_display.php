<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#table_product").tablesorter();
    } 
);
</script>
<h3>Product Records</h3>
  <?php
  session_start();
  if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message']))
  {
  ?>
  <div class="alert alert-info">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php
  echo $_SESSION['success_message'];
  unset($_SESSION['success_message']);
  ?>
  </div>
  <?php
  }
  ?>
  <a href="create_product.php" class="btn btn-primary btn-sm">
   <span class="glyphicon glyphicon-plus"></span>Add Product
  </a>
  <?php
  if(!empty($records))
  {
	   echo '<button type="button" class="btn btn-danger btn-sm" onclick="delete_product();">
	   <span class="glyphicon glyphicon-remove"></span>Delete Selected
	   </button>';
	  echo '<script type="text/javascript">
			function select_all(checked)
			{
				for(i = 0; i < $("input[name=\"product_check[]\"]").length; i++)
	            {
					$("input[name=\"product_check[]\"]")[i].checked = checked;
                }
			}

			function select_check(checked)
			{
				if(checked == false)
	            {
					$("input[name=\"product_all\"]")[0].checked = checked;
                }
			}

			function delete_product()
			{
				var productArray = $("input[name=\"product_check[]\"]:checked");
				if(productArray.length == 0)
				{
					alert("Select product(s) to delete");
					return false;
				}
				if(confirm("Are you sure you want to delete the selected product(s)?"))
				{
					var selectValue = new Array();
					for(i=0; i<productArray.length; i++)
	                {
						selectValue.push(productArray[i].value);
                    }
					$.post("include/add_product.php", {action: "deleteProduct", selectValue: selectValue}, function(data) {
						if(data == "success")
						{
							window.location = "display_record.php?name=product&page=1";
						}
					});
				}
			}
			</script>';
  ?>
  <table  id="table_product" class="table table-bordered table-condensed tablesorter">
  <thead>
      <tr>
	    <th class="sorter-false">
		 <label><input type="checkbox" name="product_all" value="all" onclick="select_all(this.checked);"></label>
		 </th>
        <th>Product Name</th>
        <th>Company Name</th>
        <th>Action</th>
	  </tr>
   </thead>
   <tbody>
	  <?php
	  for($count = 0; $count < count($records); $count ++)
	  {
	  ?>
	  <tr>
	   <td>
		<label><input type="checkbox" name="product_check[]" value="<?php echo $records[$count]['product_id']; ?>" onclick="select_check(this.checked);"></label>
	   </td>
	   <td>
	   <?php echo $records[$count]['product_name']; ?>
	   </td>
	   <td>
	   <?php echo fetch_company_name($records[$count]['company_id']); ?>
	   </td>
	   <td>
	   <form action="include/add_product.php" method="post">
	    <input type="hidden" class="form-control" name="product_id" value="<?php echo $records[$count]['product_id']; ?>">
	    <button type="submit" class="btn btn-primary btn-sm" name="product_edit_submit" value="product_edit_submit">
		 <span class="glyphicon glyphicon-edit"></span>Edit
		</button>
		<button type="submit" class="btn btn-danger btn-sm" name="product_delete_submit" value="product_delete_submit">
		 <span class="glyphicon glyphicon-remove"></span>Delete
		</button>
		</form>
	   </td>
	  </tr>
	  <?php
	  }
	  ?>
  </tbody>
  </table>
  <?php
   echo '<ul class="pagination">';
for($i = 0; $i < $number; $i = $i + 20)
{
	$active = '';
	if($page == $i/20+1)
	{
		$active = 'class="active"';
	}
	echo '<li '.$active.'><a href="?name=product&page='.($i/20+1).'">'.($i/20+1).'</a></li>';
}
echo '</ul>';
  }
  ?>