<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$sub_category_id = $_GET['sub_category_id'];


$db_get_sub_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sub_category ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sub_category ->connect_error . ']');
}

$sql_get_sub_category  = "SELECT * FROM category_subcategory WHERE id='$sub_category_id'";

$result_get_sub_category = $db_get_sub_category->query($sql_get_sub_category);
$row = $result_get_sub_category->fetch_assoc();

$db_get_sub_category->close();

$sub_category_name = $row['name'];
$sub_category_description = $row['description'];
$id = $row['category_id'];


// select sub-category details



$db_get_sub_category_details = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sub_category_details ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sub_category_details ->connect_error . ']');
}

$sql_get_sub_category_details  = "SELECT * FROM category_details WHERE category_id='$sub_category_id'";

$result_get_sub_category_details = $db_get_sub_category_details->query($sql_get_sub_category_details);


$db_get_sub_category_details->close();



include "menu.php";

?>


<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-list fa-1x"></i> Sub-Category Management </h3>
	
	<br>
	
	<label>Sub-Category Name</label>
		<br>
		<input type="text" class="form-control" id="sub_category_name" name="sub_category_name" value="<?php echo $sub_category_name;?>">

	
		<br>
		
		<div class="form-group">
  			<label for="comment">Sub-Category Description</label>
  			<textarea class="form-control" rows="3" id="sub_category_description" name="sub_category_description"><?php echo $sub_category_description;?></textarea>
		</div>
		<?php
             	echo '<button class="btn btn-success update_sub_category" ><i class="fa fa-floppy-o fa-lg"></i> Update</button>';
        ?>
        
         <?php
             	echo '<button class="btn btn-danger delete_sub_category" ><i class="fa fa-trash fa-lg"></i> Delete Sub-Category</button>';
        ?>
        
        <hr>
		
		<label>Additional Inputs </label>
		<br>
		
				
		
		
			 <table>
		
		<?php
		
	    
			
		 while ($row = $result_get_sub_category_details->fetch_assoc()) {
		 
		 $add_info_id =  $row['id'];
		 
		 
		  $is_mandatory =  $row['mandatory'];
		  $field_type =  $row['field_type'];
		 
		 
		 
		 
		 
		 
	
		 
		 ?>
		 
		 <tr>
		 	<td width="350px">
		 	<div class="form-group">
		 	<label for="sel1">Text</label>
		 	<input type="text" readonly class="form-control" id="category_name" name="category_name" value="<?php echo $row['text'];?>">
		 	</div>
		 	</td>
		 	
		 	<td width="10px">
		 	</td>
		 	
		 	<td width="200px">
		 	
		 	<div class="form-group">
  <label for="sel1">Type</label>
  <select readonly class="form-control" id="sel1">
        
        <?php
        
        if($field_type == "checkbox"){
        ?>
        <option selected>Checkbox</option>
        
        <?php
        }else{
        ?>
        
         <option>Checkbox</option>
        
        <?php
        }
        
        
        ?>
        
        <?php
        
        if($field_type == "slider"){
        ?>
        <option selected>Slider</option>
        
        <?php
        }else{
        ?>
        
         <option>Slider</option>
        
        <?php
        }
        
        
        ?>
        
         <?php
        
        if($field_type == "textbox"){
        ?>
        <option selected>Textbox</option>
        
        <?php
        }else{
        ?>
        
         <option>Textbox</option>
        
        <?php
        }
        
        
        ?>
        
        
        <?php
        
        if($field_type == "textarea"){
        ?>
        <option selected>Textarea</option>
        
        <?php
        }else{
        ?>
        
         <option>Textarea</option>
        
        <?php
        }
        
        
        ?>
        
    
  </select>
</div>
		 	
		 	
	
		 	
		 	</td>
		 	<td width="10px">
		 	</td>
		 	
		 	<td>
		 	
		 	<div class="form-group" id="field_range" name="field_range"> 
		 	<label for="sel1">Field Range</label>
		 	<input type="text" readonly class="form-control" id="field_range" name="field_range" value="<?php echo $row['field_range'];?>">
		 	</div>
		 	
		 	</td>
		 	
		 	
		 	<td width="10px">
		 	</td>
		 	
		 	
		 	<td width="100px">
		 	<div class="form-group">
		 	<label for="sel1">Mandatory</label>
		 	
		 	<?php 
		 	
		 	if($is_mandatory == "1"){
		 	?>
		 	
		 	  <input  checked type="checkbox"  readonly name="mandatory" id="mandatory">
		 	<?php
		 	}else{
		 	?>
		 	<input  type="checkbox"  readonly name="mandatory" id="mandatory">
		 	<?php
		 	}
		 	
		 	?>
		 	
		 	</div>
		 	</td>
		 	
		 	
		 	<td>
		 	
		 	<?php
             	echo '<button additional_id="' . $add_info_id . '"  class="btn btn-default edit_additional_info" ><i class="fa  fa-pencil fa-lg"></i> Edit</button>';
             ?>
		 	</td>
		 	
		 	<td width="10px">
		 	</td>
		 	
		 	
		 	<td>
		 	
		 	<?php
             	echo '<button additional_id="' . $add_info_id . '"  class="btn btn-danger delete_additional_info" ><i class="fa fa-trash-o" fa-lg"></i> Delete</button>';
             ?>
		 	</td>
		 	

        
          </tr>	 
        	 
        <?php 	 
         } 	 
		
	
		?>
			 </table>
		
		
		<?php
             	echo '<button class="btn btn-success add_additional_info" ><i class="fa fa-plus fa-lg"></i> Add Inputs</button>';
        ?>
		
        
        <hr>
        
        
        
<div id="modal_add_additional_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center>Add Additional Fields</center></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div class="form-group">
		 	<label for="sel1">Text</label>
		 	<input type="text" class="form-control" id="add_info_text" name="add_info_text" value="<?php echo $row['text'];?>">
		 	</div>
		 	
		 	<div class="form-group">
  <label for="sel1">Type</label>
  <select  class="form-control" id="add_info_type" name="add_info_type">
    <option value="checkbox">Checkbox</option>
    <option value="slider">Slider</option>
    <option value="textbox">Textbox</option>
    <option value="textarea">Textarea</option>
  </select>
</div>


<div class="form-group" id="field_range" name="field_range"> 
		 	<label for="sel1">Field Range</label>
		 	<input type="text"  class="form-control" id="add_info_range" name="add_info_range" value="">
		 	</div>
		
		 	
<div class="form-group">
		 	<label for="sel1">Mandatory</label>
		 	<br>
		 	<input  type="checkbox"name="add_info_range_mandatory" id="add_info_range_mandatory">
		 	</div>
		 	
		 	
		 	<center>
		 	<table>
            			<tr>
            			 <td><button class="btn btn-default" onclick="add_info_close()">Close</button></td><td width="10px"></td><td><button class="btn btn-success" onclick="add_info_add()">Save</button></td><td width="10px"></td>
            			
            			</tr>
            		
            		
            		</table>
		 	</center>
		 	
		 	
            		
            
            		
            		</div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
 <div id="modal_edit_additional_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center>Edit Additional Fields</center></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div class="form-group">
		 	<label for="sel1">Text</label>
		 	<input type="text" class="form-control" id="edit_info_text" name="edit_info_text" value="">
		 	</div>
		 	
		 	<div class="form-group">
  <label for="sel1">Type</label>
  <select  class="form-control" id="edit_info_type" name="edit_info_type">
    <option value="checkbox">Checkbox</option>
    <option value="slider">Slider</option>
    <option value="textbox">Textbox</option>
    <option value="textarea">Textarea</option>
  </select>
</div>


<div class="form-group" id="edit_field_range_visible" name="edit_field_range_visible"> 
		 	<label for="sel1">Field Range</label>
		 	<input type="text"  class="form-control" id="edit_info_range" name="edit_info_range" value="">
		 	</div>
		
		 	
<div class="form-group">
		 	<label for="sel1">Mandatory</label>
		 	<br>
		 	<input  type="checkbox"name="edit_info_range_mandatory" id="edit_info_range_mandatory">
		 	</div>
		 	
		 	
		 	<input type="hidden" name="id_additional_info" id="id_additional_info"  value="">
		 	
		 	<center>
		 	<table>
            			<tr>
            			 <td><button class="btn btn-default" onclick="edit_info_close()">Close</button></td><td width="10px"></td><td><button class="btn btn-success" onclick="edit_info_udpate()">Update</button></td><td width="10px"></td>
            			
            			</tr>
            		
            		
            		</table>
		 	</center>
		 	
		 	
            		
            
            		
            		</div>
            </div>
        </div>
    </div>   
    
        
        
<script>

$("[name='mandatory']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
});


$("[name='add_info_range_mandatory']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
});


$("[name='edit_info_range_mandatory']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
});


$(document).on("click", ".delete_sub_category", function(e) {


    var sub_category_id = "<?php echo $sub_category_id;?>";
    
    
    swal({
  			title: "Warning",
  			text: "Are you sure you want to delete this sub category?",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: "#d9534f",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			
 			 var formData = {
			'sub_category_id'     : sub_category_id
	
    		}
    		
    	
    		var feedback = $.ajax({
    			type: "POST",
    			url: "delete_sub_category.php",
    			data: formData,
    		
    			async: true,
    			
    			}).complete(function(){
    			
    			
    			     swal({
  			title: "Success",
  			text: "The sub-category was deleted",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5CB85C",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			
 			location.href = "category_management_main_list.php";
 			
 			
		});     	
    			
    				
        				
        		}).responseText;
 			
		});
		

    
    
});


function edit_info_close(){
   
   $('#modal_edit_additional_info').modal('hide');
   
};


function add_info_close(){
   
   $('#modal_add_additional_info').modal('hide');
   
};


$(document).on("click", ".update_sub_category", function(e) {
	
	
	var name = $('#sub_category_name').val();
 	var description = $('#sub_category_description').val();
 	var category_id = "<?php echo $sub_category_id;?>";
 	
 	var formData = {
        	'name'     : name,
        	'description'     : description,
        	'category_id'     : category_id,
	}
	
	
	 var feedback = $.ajax({
    			type: "POST",
    			url: "update_sub_category.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	

    	
    	swal({
  			title: "Success",
  			text: "The sub-category information was updated.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 		
	
 			location.href = "category_management_sub_edit.php?sub_category_id=" + category_id;
 			

		});
    	
    	
    	
    	
	
	
 	
 



});



function edit_info_udpate(){

  
  var id_additional_info = $('#id_additional_info').val();
  
   var category_id = "<?php echo $sub_category_id;?>";
  
  var edit_info_text = $('#edit_info_text').val();
  var edit_info_type = $('#edit_info_type').val();
  var edit_info_range = $('#edit_info_range').val();
  var edit_info_range_mandatory = $('#edit_info_range_mandatory').bootstrapSwitch('state');
  
    if(edit_info_range_mandatory == true){
    		edit_info_range_mandatory = 1;
     	}else{
     		edit_info_range_mandatory = 0;	
  }
  
  
  var formData = {
        	'id'     : id_additional_info,
        	'text'     : edit_info_text,
        	'field_type'     : edit_info_type,
        	'field_range'     : edit_info_range,
        	'mandatory'     : edit_info_range_mandatory

  }
  
  var feedback = $.ajax({
    			type: "POST",
    			url: "update_additional_category_info.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	 swal({
  			title: "Success",
  			text: "The additional input fields where updated.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			$('#modal_edit_additional_info').modal('hide');
 			
 			location.href = "category_management_sub_edit.php?sub_category_id=" + category_id;
 			
 			
		});
  

 



}


function add_info_add(){
   
  var add_info_text = $('#add_info_text').val();
  var add_info_type = $('#add_info_type').val();
  var add_info_range = $('#add_info_range').val();
  var add_info_range_mandatory = $('#add_info_range_mandatory').bootstrapSwitch('state');
  var main_category = "<?php echo $id;?>";
  
  var category_id = "<?php echo $sub_category_id;?>";
  
 
  
  if(add_info_range_mandatory == true){
    		add_info_range_mandatory = 1;
     	}else{
     		add_info_range_mandatory = 0;	
  }
  
  var formData = {
        	'category_id'     : category_id,
        	'text'     : add_info_text,
        	'field_type'     : add_info_type,
        	'field_range'     : add_info_range,
        	'mandatory'     : add_info_range_mandatory,
        	'main_category'     : main_category

  }
  
  var feedback = $.ajax({
    			type: "POST",
    			url: "add_additional_category_info.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	 
    	 
    	 swal({
  			title: "Success",
  			text: "The additional input fields where saved.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			$('#modal_add_additional_info').modal('hide');
 			
 			location.href = "category_management_sub_edit.php?sub_category_id=" + category_id;
 			
 			
		});
    	 

   
};




        


$(document).on("click", ".edit_additional_info", function(e) {

    var additional_id = ($(this).attr('additional_id'));
    
    
 	var formData = {
			'additional_id'     : additional_id
	
	}
    		
    	
   	 var feedback = $.ajax({
    			type: "POST",
    			url: "get_additional_category_info_details.php",
    			data: formData,
    		
    			async: false,
    			
    			}).complete(function(){
        				
        		}).responseText;
        		
    var res = feedback.split("|");
    
    var text =  res[0];
    var type =  res[1];
    var field_range =  res[2];
    var mandatory = res[3];
    
    
    
    $('#id_additional_info').val(additional_id);
    
    $('#edit_info_text').val(text);
    $('#edit_info_type').val(type);
    $('#edit_info_range').val(field_range);

    
	if(mandatory == 1){
      
      $('input[name="edit_info_range_mandatory"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="edit_info_range_mandatory"]').bootstrapSwitch('state', false, false);
      
    	
    }
    


	$('#modal_edit_additional_info').modal('show');


});
	
	
$(document).on("click", ".add_additional_info", function(e) {
 	
 	$('#modal_add_additional_info').modal('show');
 	


});
	
	
	

$(document).on("click", ".delete_additional_info", function(e) {
	
	var additional_id = ($(this).attr('additional_id'));
	var category_id = "<?php echo $sub_category_id;?>";
	
	 swal({
  			title: "Warning",
  			text: "Are you sure you like to delete this entry?",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: "#d9534f",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			
 			
 			var formData = {
				'additional_id'     : additional_id
	
			}
    		
    	
   			 var feedback = $.ajax({
    			type: "POST",
    			url: "category_management_sube_catgeory_delete_additional.php",
    			data: formData,
    		
    			async: false,
    			
    			}).complete(function(){
        				
        		}).responseText;
        		
        		
        		location.href = "category_management_sub_edit.php?sub_category_id=" + category_id;
	
 			
		});
	
});
	
	
	
	
	
</script>
