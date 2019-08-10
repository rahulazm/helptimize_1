<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

// get all pltfrmfee
$db_get_pltfrmfee = new mysqli("$host", "$username", "$password", "$db_name");
if($db_get_pltfrmfee ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pltfrmfee ->connect_error . ']');
}
$sql_get_pltfrmfee  = "SELECT * FROM platform_fee";
$result_get_pltfrmfee = $db_get_pltfrmfee->query($sql_get_pltfrmfee);
$db_get_pltfrmfee->close();

include "menu.php";
?>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-list fa-1x"></i> Platform fee Management </h3>
	
	<br>
	
	<table id="main_catgeories"  name="main_catgeories" class="table table-striped table-bordered" cellspacing="0" width="100%">
    	<thead>
        	<tr>
            	<th>Name</th>
            	<th>Value</th>
            	<th>Status</th>
            	<th></th>
            </tr>
    	</thead>
        <tbody>
        <?php
         	 while ($row = $result_get_pltfrmfee->fetch_assoc()) {
        	  	$platformfee_id	= $row['platformfee_id'];
            	$status = ($row['platformfee_status']==0)?"Active":"Inactive";
        	 ?>
        	 
        	    <tr>
        	 	  <td style="width: 220px"><?=$row['platformfee_name']?></td> 
             	<td style="width: 400px"><?=$row['platformfee_value']?></td> 
              <td style="width: 200px"><?=$status?></td> 
             	<td>
             	
             	<?php
             	echo '<button pltfrmfee_id="' . $platformfee_id . '"  class="btn btn-default edit_pltfrmfee" ><i class="fa  fa-pencil fa-lg"></i> Edit</button>';
             	?>
             	
             	</td> 
             	</tr>
        	 <?php
        	 }
        	 
        	 ?>
        	 </tbody>
   		 </table>
       
            <button class="btn btn-success add_platfrmfee"><i class="fa fa-plus fa-lg"></i> Add Platform fees</button>
       
	</div>
</div>

<div id="modal_add_platfrmfee" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center>Add Platform fee</center></h4>
            	</div>
            		<div class="modal-body">
            		           		
            		<div class="form-group">
		 	<label for="sel1">Name</label>
		 	<input type="text" class="form-control" id="new_pltfrmfee_name" name="new_pltfrmfee_name" value="">
		 	</div>
		 	
		 	<div class="form-group">
        <label for="comment">Percentage Value:</label>
        <input type="text" class="form-control" id="new_pltfrmfee_val" name="new_pltfrmfee_val" value="">
      </div>


	<center>
	 	<table>
			<tr>
			 <td><button class="btn btn-default" onclick="$('#modal_add_platfrmfee').modal('hide');">Close</button></td><td width="10px"></td><td><button class="btn btn-success" onclick="new_pltfrmfee_add()">Save</button></td><td width="10px"></td>
			
			</tr>
	    </table>
	</center>
   </div>
  </div>
 </div>
 </div>

<script type="text/javascript">
$(document).on("click", ".add_platfrmfee", function(e) {
  
   $('#modal_add_platfrmfee').modal('show');
   
});

function new_pltfrmfee_add(){

   	var name = $('#new_pltfrmfee_name').val();
  	var val = $('#new_pltfrmfee_val').val();
  	if(name=='' || val==''){
      alert("Please provide full details");
      return;
    }
  	
  	var formData = {
        	'name' : name,
        	'val'  : val,
        	'action_type':"add"
        	
	}
	
	var feedback = $.ajax({
    			type: "POST",
    			url: "process_pltfrmfee.php",
    		    data: formData,
    		    async: true,

    			
    	}).complete(function(result){
        	//alert(result.responseText);
        				
    	}).responseText;
  	
  	
  	swal({
  			title: "Success",
  			text: "The platform fee was added",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			location.href = "pltfrm_settings.php";
 		});
 }

 $(document).on("click", ".edit_pltfrmfee", function(e) {
	var pltfrmfee_id = ($(this).attr('pltfrmfee_id'));
	location.href = "pltfrmfee_edit.php?pltfrmfee_id=" + pltfrmfee_id;
	
});
 </script>

