<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get number settings 

$db_get_number_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_number_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_number_settings ->connect_error . ']');
}

$sql_get_number_settings = "SELECT value FROM admin_settings WHERE keyword ='characters_remove_phone_number'";

$result_get_number_settings = $db_get_number_settings->query($sql_get_number_settings);

$row_value = $result_get_number_settings->fetch_assoc();

$db_get_number_settings->close();

$characters_remove_phone_number = $row_value['value'];


$db_get_number_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_number_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_number_settings ->connect_error . ']');
}

$sql_get_number_settings = "SELECT value FROM admin_settings WHERE keyword ='characters_add_in_front_phone_number'";

$result_get_number_settings = $db_get_number_settings->query($sql_get_number_settings);

$row_value = $result_get_number_settings->fetch_assoc();

$db_get_number_settings->close();

$characters_add_in_front_phone_number = $row_value['value'];

include "menu.php";


?>



<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-phone-square fa-1x"></i> Phone Number Settings</h3>
	
	
	<form id="number_settings">
  			<div class="row">
  			
				<div class="form-group col-lg-4">
				<label>Characters to remove (separated by | )</label>
				<input type="text" class="form-control" id="character_strip" name="character_strip" value="<?php echo $characters_remove_phone_number;?>">
				
				
				</div>
				




			</div>
			
			<div class="row">
  			
				<div class="form-group col-lg-4">
				<label>Characters to add in front of number)</label>
				<input type="text" class="form-control" id="characters_add_in_front_phone_number" name="characters_add_in_front_phone_number" value="<?php echo $characters_add_in_front_phone_number;?>">
				
				
				</div>
				




			</div>
			
			
			

		<button type="submit" class="btn btn-success" name="submit_edit"  id="submit_edit" >Save</button>	
	</form>
	
	
	</div>
</div>



<script>
$(document).ready(function() {
    $('#number_settings').formValidation({
        framework: 'bootstrap',
        
        fields: {
            character_strip: {
                validators: {
                    notEmpty: {
                        message: 'Please enter characters to cut'
                    }
                    
                }
            }
        }
    }).on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();
            
            var character_strip = $("#character_strip").val();
            var characters_add_in_front_phone_number = $("#characters_add_in_front_phone_number").val();
            
            
    
            
            var formData = {
        		'character_strip'     : character_strip,
        		'characters_add_in_front_phone_number'     : characters_add_in_front_phone_number
    
    		}
    	
    	  var pipedrive_update = $.ajax({
    			type: "POST",
    			url: "update_phone_number_settings.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	swal({
  title: "Success",
  text: "The phone number settings are updated.",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#007E33",
  confirmButtonText: "OK",
  closeOnConfirm: false
},
function(){

	location.reload();

  
});
    	

           
        });
});
</script>