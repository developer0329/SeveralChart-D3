<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#table_user").tablesorter();
    } 
);
</script>
<h3>User Records</h3>
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
  <a href="create_user.php" class="btn btn-primary btn-sm">
   <span class="glyphicon glyphicon-plus"></span>Add User
  </a>
  <?php
  if(!empty($records))
  {
	   echo '<button type="button" class="btn btn-danger btn-sm" onclick="delete_user();">
	   <span class="glyphicon glyphicon-remove"></span>Delete Selected
	   </button>';
	  echo '<script type="text/javascript">
			function select_all(checked)
			{
				for(i = 0; i < $("input[name=\"user_check[]\"]").length; i++)
	            {
					$("input[name=\"user_check[]\"]")[i].checked = checked;
                }
			}

			function select_check(checked)
			{
				if(checked == false)
	            {
					$("input[name=\"user_all\"]")[0].checked = checked;
                }
			}

			function delete_user()
			{
				var userArray = $("input[name=\"user_check[]\"]:checked");
				if(userArray.length == 0)
				{
					alert("Select user(s) to delete");
					return false;
				}
				if(confirm("Are you sure you want to delete the selected user(s)?"))
				{
					var selectValue = new Array();
					for(i=0; i<userArray.length; i++)
	                {
						selectValue.push(userArray[i].value);
                    }
					$.post("include/add_user.php", {action: "deleteUser", selectValue: selectValue}, function(data) {
						if(data == "success")
						{
							window.location = "display_record.php?name=user&page=1";
						}
					});
				}
			}
			</script>';
  ?>
  <table  id="table_user" class="table table-bordered table-condensed tablesorter">
  <thead>
      <tr>
	    <th class="sorter-false">
		 <label><input type="checkbox" name="user_all" value="all" onclick="select_all(this.checked);"></label>
		 </th>
        <th>Firstname</th>
        <th>Lastname</th>
		<th>Email Address</th>
        <th>Company Name</th>
		<th>Password</th>
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
		<label><input type="checkbox" name="user_check[]" value="<?php echo $records[$count]['person_id']; ?>" onclick="select_check(this.checked);"></label>
	   </td>
	   <td>
	   <?php echo $records[$count]['firstname']; ?>
	   </td>
	   <td>
	   <?php echo $records[$count]['lastname']; ?>
	   </td>
	   <td>
	   <?php echo $records[$count]['email_address']; ?>
	   </td>
	   <td>
	   <?php echo fetch_company_name($records[$count]['company_id']); ?>
	   </td>
	   <td>
	   <?php echo $records[$count]['password']; ?>
	   </td>
	   <td>
	   <form action="include/add_user.php" method="post">
	    <input type="hidden" class="form-control" name="user_id" value="<?php echo $records[$count]['person_id']; ?>">
	    <button type="submit" class="btn btn-primary btn-sm" name="user_edit_submit" value="user_edit_submit">
		 <span class="glyphicon glyphicon-edit"></span>Edit
		</button>
		<button type="submit" class="btn btn-danger btn-sm" name="user_delete_submit" value="user_delete_submit">
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
	echo '<li '.$active.'><a href="?name=user&page='.($i/20+1).'">'.($i/20+1).'</a></li>';
}
echo '</ul>';
  }
  ?>