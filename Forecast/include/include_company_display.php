<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#table_company").tablesorter();
    } 
);
</script>
<h3>Company Records</h3>
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
  <div class="company_form">
  <form class="form-inline" role="form" action="include/add_record.php" method="post">
  <div class="form-group col-sm-6">
    <label for="company_name_add">Company Name:</label>
    <input type="text" class="form-control" style="width: 70%;" name="company_name_add" id="company_name_add" required="required">
  </div>
  <button type="submit" class="btn btn-primary btn-sm">
   <span class="glyphicon glyphicon-plus"></span>Add Company
  </button>
  <?php
  if(!empty($records))
  {
  ?>
  <button type="button" class="btn btn-danger btn-sm" onclick="delete_company();">
   <span class="glyphicon glyphicon-remove"></span>Delete Selected
  </button>
  <?php
  }
  ?>
</form>
  </div>
  <?php
  if(!empty($records))
  {
	  echo '<script type="text/javascript">
	        function show_save(id)
			{
				var val = $("#company_name_hidden_"+id).val();
				$("#edit_"+id).css("display", "none");
				$("#save_"+id).css("display", "inline");
				$("#cancel_"+id).css("display", "inline");
				$("#company_div_"+id).html("<input type=\"text\" class=\"form-control\" name=\"company_name_update\" id=\"company_name_\" +id value=\""+val+"\" required=\"required\">");
            }

			function show_edit(id)
			{
				$("#save_"+id).css("display", "none");
				$("#cancel_"+id).css("display", "none");
				$("#edit_"+id).css("display", "inline");
				$("#company_div_"+id).html($("#company_name_hidden_"+id).val());
            }

			function select_all(checked)
			{
				for(i = 0; i < $("input[name=\"company_check[]\"]").length; i++)
	            {
					$("input[name=\"company_check[]\"]")[i].checked = checked;
                }
			}

			function select_check(checked)
			{
				if(checked == false)
	            {
					$("input[name=\"company_all\"]")[0].checked = checked;
                }
			}

			function delete_company()
			{
				var companyArray = $("input[name=\"company_check[]\"]:checked");
				if(companyArray.length == 0)
				{
					alert("Select company(ies) to delete");
					return false;
				}
				if(confirm("Are you sure you want to delete the selected company(ies)?"))
				{
					var selectValue = new Array();
					for(i=0; i<companyArray.length; i++)
	                {
						selectValue.push(companyArray[i].value);
                    }
					$.post("include/add_record.php", {action: "deleteCompany", selectValue: selectValue}, function(data) {
						if(data == "success")
						{
							window.location = "display_record.php?name=company&page=1";
						}
					});
				}
			}
			</script>';
  ?>
  <table id="table_company" class="table table-bordered table-condensed tablesorter">
  <thead>
      <tr>
	    <th class="sorter-false">
		 <label><input type="checkbox" name="company_all" value="all" onclick="select_all(this.checked);"></label>
		 </th>
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
		<label><input type="checkbox" name="company_check[]" value="<?php echo $records[$count]['company_id']; ?>" onclick="select_check(this.checked);"></label>
	   </td>
	   <td class="col-sm-8">
	   <form action="include/add_record.php" method="post">
	   <div id="company_div_<?php echo $records[$count]['company_id']; ?>">
	   <?php echo $records[$count]['company_name']; ?>
	   </div>
	   <input type="hidden" class="form-control" name="company_id" value="<?php echo $records[$count]['company_id']; ?>">
	   <input type="hidden" class="form-control" name="company_name_hidden" id="company_name_hidden_<?php echo $records[$count]['company_id']; ?>" value="<?php echo $records[$count]['company_name']; ?>"></td>
	   <td>
	    <button type="button" class="btn btn-primary btn-sm" id="edit_<?php echo $records[$count]['company_id']; ?>" onclick="show_save('<?php echo $records[$count]['company_id']; ?>');">
		 <span class="glyphicon glyphicon-edit"></span>Edit
		</button>
		<button type="submit" class="btn btn-primary btn-sm" id="save_<?php echo $records[$count]['company_id']; ?>" style="display: none;" name="company_save_submit" value="company_save_submit">
		 <span class="glyphicon glyphicon-edit"></span>Save
		</button>
		<button type="button" class="btn btn-primary btn-sm" id="cancel_<?php echo $records[$count]['company_id']; ?>" style="display: none;" onclick="show_edit('<?php echo $records[$count]['company_id']; ?>');">
		 <span class="glyphicon glyphicon-edit"></span>Cancel
		</button>
		<button type="submit" class="btn btn-danger btn-sm" name="company_delete_submit" value="company_delete_submit">
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
	echo '<li '.$active.'><a href="?name=company&page='.($i/20+1).'">'.($i/20+1).'</a></li>';
}
echo '</ul>';
  }
  ?>