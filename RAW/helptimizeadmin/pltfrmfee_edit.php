<?php
//error_reporting(E_ALL);
$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];
$pltfrmfee_id = $_GET['pltfrmfee_id'];

//

$db_get = new mysqli("$host", "$username", "$password", "$db_name");
if($db_get ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get ->connect_error . ']');
}

$sql_get  = "SELECT * FROM platform_fee WHERE platformfee_id='$pltfrmfee_id'";

$result_get = $db_get->query($sql_get);
$row = $result_get->fetch_assoc();
$db_get->close();
include "menu.php";

?>

<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-10">
  
  <h3> <i class="fa fa-list fa-1x"></i> Platform fee Management </h3>
  
  <br>
  
  <label>Platform Name</label>
    <br>
    <input type="text" class="form-control" id="platformfee_name" name="platformfee_name" value="<?php echo $row['platformfee_name'];?>">
    <br>
    
    <div class="form-group">
        <label for="comment">Platform Value</label>
        <input type="text" class="form-control" id="platformfee_val" name="platformfee_val" value="<?php echo $row['platformfee_value'];?>">
    </div>
    <div class="form-group">
        <label for="comment">Platform Status</label><br>
        <input type="radio" id="platformfee_status" name="platformfee_status" value="0" <?php if($row['platformfee_status']=='0') echo "checked";?>> Active<br>
  		<input type="radio" id="platformfee_status" name="platformfee_status" value="1" <?php if($row['platformfee_status']=='1') echo "checked";?>> Inctive<br>
    </div>
    
    <?php
              echo '<button class="btn btn-success update_pltfrmfee" ><i class="fa fa-floppy-o fa-lg"></i> Update</button>';
        ?>
        
        
        <?php
              echo '<button class="btn btn-danger delete_pltfrmfee" ><i class="fa fa-trash fa-lg"></i> Delete</button>';
        ?>
   </div>
   </div>     
 
<script type="text/javascript">

 $(document).on("click", ".update_pltfrmfee", function(e) {

   var platformfee_id = "<?php echo $row['platformfee_id'];?>";
   var platformfee_name = $('#platformfee_name').val();
   var platformfee_val = $('#platformfee_val').val();
   var platformfee_status = document.querySelector('input[name="platformfee_status"]:checked').value;
 
   //alert(platformfee_status);
   //return;

   if(platformfee_val=='' || platformfee_name==''){
   	alert("Please fill all details");
   	return false;
   }
   
   var formData = {
	'platformfee_id'       :platformfee_id,
	'platformfee_name'     :platformfee_name,
	'platformfee_val'      :platformfee_val,
	'platformfee_status'   :platformfee_status,
	'action_type'		   :"update"
    
	}
    		
    var feedback = $.ajax({
    	type: "POST",
    	url: "process_pltfrmfee.php",
    	data: formData,
    	async: false,
    			
    	}).complete(function(result){
        	 //alert(result.responseText);			
        }).responseText;
        
         swal({
  			title: "Success",
  			text: "The Platform details was updated",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5CB85C",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			location.href = "pltfrm_settings.php";
 		});
 });
</script>
