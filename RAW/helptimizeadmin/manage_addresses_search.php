<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all categories

$db_get_service_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_service_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_service_categories ->connect_error . ']');
}

$sql_get_service_categories = "SELECT * FROM main_categories";

$result_get_service_categories = $db_get_service_categories->query($sql_get_service_categories);

$db_get_service_categories->close();



// get all sub_categories

$db_get_sub_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sub_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sub_categories ->connect_error . ']');
}

$sql_get_sub_categories = "SELECT * FROM category_subcategory";

$result_get_sub_categories = $db_get_sub_categories->query($sql_get_sub_categories);

$db_get_sub_categories->close();

include "menu.php";

?>


<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-address-card-o fa-1x"></i> Select Lead Addresses</h3>
		<br>
		
		
		<div class="panel panel-default">
  			<div class="panel-body">
  				<label>Select all leads which are not in Pipedrive yet</label>
  				
  				<form method="post" action="display_all_addresses_not_in_pipedrive.php" id="display_all_addresses_not_in_pipedrive" name="display_call_report">
  				<button type="submit" class="btn btn-success" name="submit_all"  id="submit_all" >Search</button>
       		</form>
  			</div>
		</div>

<div class="panel panel-default">
  			<div class="panel-body">
  			<label>Select specific leads which are not in Pipedrive yet</label>
	<div class="row">
		
			<form method="post" action="report_call_quality_display.php" id="display_call_report" name="display_call_report">

			<div class="form-group col-lg-4">
            	<label>Category</label>
           
           		<select class="form-control" id="project_category" name="project_category">
    				<?php
    				echo "<option value='nothing'>Please select a category.....</option>";
    				while ($row = $result_get_service_categories->fetch_assoc()) {
    		
    		    		if($category == $row['id']){
				
							echo "<option value=" . $row ['id'] . " selected='selected'>" . $row ['name'] . "</option>";
				
						}else{
							echo "<option value=" . $row ['id'] . ">" . $row ['name'] . "</option>";
				
						}
			
			
					}
 					?>
    			</select>
       		 </div>
		
		
		
			<div class="form-group col-lg-4">
           		<label>Sub Category</label>
            	<select class="form-control" id="sub_project_category" name="sub_project_category">
    
    			<select>
       		</div>	
       		
       		
			</div>
			<button type="submit" class="btn btn-success" name="submit_edit"  id="submit_edit" >Search</button>
       		</form>
  	</div>
	</div>	
	
</div>


<script>

$("#project_category").change(function() {

     $("#sub_project_category option").remove();

	 var category_id = $("#project_category").val();
	 
	  var formData = {
        'category_id'     : category_id,
    
    	}
    	
    	  var sub_category = $.ajax({
    			type: "POST",
    			url: "check_if_sub_category.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	if(sub_category != "no_sub"){
    
    	
    	    sub_category_Html = "";
    		
    		var obj = jQuery.parseJSON(sub_category);
    	
    		$.each(obj, function(key,value){    
    		
    		  	var id = value.id;
    		  	var category_id = value.id;
    		  	var sub_category_name = value.name;
    		  	
    		  	
    		  	$('#sub_project_category').append($('<option>', { 
        			value: value.id,
       				 text : value.name 
    			}));
    		  	
    		  	

    		
    		});
    		
    		
    	}


});

</script>



