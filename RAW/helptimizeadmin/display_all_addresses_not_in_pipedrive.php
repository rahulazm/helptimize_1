<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all leads not in pipedrive

$db_get_leads_not_in_pipedrive = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_leads_not_in_pipedrive ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_leads_not_in_pipedrive ->connect_error . ']');
}

$sql_get_leads_not_in_pipedrive = "SELECT * FROM potential_service_providers WHERE in_pipedrive ='0'";

$result_get_leads_not_in_pipedrive = $db_get_leads_not_in_pipedrive->query($sql_get_leads_not_in_pipedrive);

$db_get_leads_not_in_pipedrive->close();


include "menu.php";

?>


<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>


<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-address-card-o fa-1x"></i> Leads not in Pipedrive</h3>
<br>
<button class="btn btn-success" type="button" onclick="add_to_pipedrive()">Add Leads to Pipedrive</button>
<br>
<br>
<table id="leads_not_in_pipedrive"  name="leads_not_in_pipedrive" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>Name</th>
                	<th>Address</th>
                	<th>Phone Number</th>
                	<th>Modified Phone Number</th>
                	<th>E-Mail</th>
                	<th>Add to Pipedrive</th>
                	<th></th>
                </tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	
        	
        	$pipedrive_counter = 1;
        	 
        	 while ($row = $result_get_leads_not_in_pipedrive->fetch_assoc()) {
        	 
        	 $email_string = $row['emails'];
        	 $email_string = str_replace(",","<br>",$email_string);
        	 
        	 $phone_number = $row['formatted_phone_number'];
        	 
        	 $lead_id = $row['id'];
        	
        	 
        	
        	 
        	$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

			if($db_get_pipedrive_settings ->connect_errno > 0){
    			die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
			}

			$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='characters_remove_phone_number'";

			$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

			$row_value = $result_get_pipedrive_settings->fetch_assoc();

			$db_get_pipedrive_settings->close();

			$characters_remove_phone_number = $row_value['value'];
			
			
			$characters_remove_phone_number_array = explode("|", $characters_remove_phone_number);
			
			foreach ($characters_remove_phone_number_array as &$value) {
			
			
			$phone_number = str_replace($value,"",$phone_number);
			
			
			}
			
			
			// get phone number add in fron settings
			
			$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

			if($db_get_pipedrive_settings ->connect_errno > 0){
    			die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
			}

			$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='characters_add_in_front_phone_number'";

			$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

			$row_value = $result_get_pipedrive_settings->fetch_assoc();

			$db_get_pipedrive_settings->close();

			$characters_add_in_front_phone_number = $row_value['value'];
			
			
		    $phone_number =  $characters_add_in_front_phone_number . $phone_number;
			
			
	
        	 
        	 ?>
        	 
        	 <tr>
             		<td style="width: 150px"><?=$row['name']?></td> 
             		<td style="width: 150px"><?=$row['formatted_address']?></td> 
             		<td style="width: 150px"><?=$row['formatted_phone_number']?></td> 
             		<td style="width: 150px"><?php echo $phone_number;?> </td> 
             		<td style="width: 150px"><?php echo $email_string;?></td>
             		<td style="width: 50px" align="center">
             		<div class="checkbox">
  						<label><input checked="checked" id="pipe_<?php echo $pipedrive_counter;?>" name="pipe_<?php echo $pipedrive_counter;?>"  type="checkbox" value=""></label>
					</div>
         		
             		</td> 
             		
             		<td style="width: 50px">
             		<?php
             		       echo '<button lead_id="' . $lead_id . '"  class="btn btn-danger delete_lead" ><i class="fa fa-trash-o fa-lg"></i></button>';
             		 ?>       	 
             		        	 <input type="hidden" name="lead_id_<?php echo $pipedrive_counter;?>"  id="lead_id_<?php echo $pipedrive_counter;?>" value="<?php echo $row['id'];?>">
             		
             		</td>  
        	 
        	  </tr>
        	  

        	 
        	 
        	 <?php
        	 
        	
        	 
        	 $pipedrive_counter = $pipedrive_counter + 1;
        	 }
        	 
        	 
        	 
        	 ?>
        	 
        	 
        	 
        	 <input type="hidden" name="pipedrive_counter"  id="pipedrive_counter" value="<?php echo $pipedrive_counter;?>">
        	 
        	   </tbody>
   		 </table>
   		 
   		 
   		
   		 
</div>
</div>



<div id="spinner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		
            		<h4 class="modal-title" style="color:#000000";><center>Pipedrive</center></h4>
            	</div>
            		<div class="modal-body">
            		
            	<center>
            		
            		<div class="loader"></div>
            		<h3>Importing leads into Pipedrive....</h3>
            		
            	</center>

   		
            		</div>
            </div>
        </div>
    </div>
    

<script>

$(document).on("click", ".delete_lead", function(e) {
	
	var lead_id = ($(this).attr('lead_id'));
	
	swal({
  		title: "Are you sure?",
  		text: "You will not be able to recover this lead!",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#DD6B55",
  		confirmButtonText: "Yes, delete it!",
  		closeOnConfirm: false
		},
		function(){
		
		     var formData = {
        	'lead_id'     : lead_id
        		
        }
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "delete_lead.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
    	
    	 
    	  
    	  		swal({
  					title: "Deleted!",
  					text: "Your lead has been deleted",
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5cb85c",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
					},
					function(){
  						  location.reload();

					});

    	
    	}).responseText;
		

	   });

});


$(document).ready(function() {

var l_m = "Display _MENU_ records per page";
var search = "Search";
var display_nothing = "No Leads to display";
var info = "Showing page _PAGE_ of _PAGES_ ";
var display_first = "First";
var display_last = "First";
var next = "Next";
var previous = "Previous";
var no_records = "No records available";
var filtered = " (filtered from _MAX_ total records)";


    
    $('#leads_not_in_pipedrive').dataTable( {
    "paging": false,
    "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_nothing,
            "info": info,
            "paginate": {
        		"first":      display_first,
        		"last":       display_last,
       		    "next":       next,
                "previous":   previous
    },
            "infoEmpty": no_records,
            "infoFiltered": filtered
        }
    } );

});


function add_to_pipedrive(){



    var counter = "<?php echo $pipedrive_counter; ?>";
    
    counter = counter - 1;
    
    var leads_to_add = "";
    
    
    for (i = 1; i <= counter; i++) { 
    
        var add_to_pipedrive = $("#pipe_" + i).is(":checked");
        
        if(add_to_pipedrive == true){
        
        var lead_id = $("#lead_id_" + i).val();
        
        leads_to_add = leads_to_add + "|" + lead_id;
        
        
        
        

        
        }
    
      
       
    	 	
     }
    
    
    // send leads to Pipedrive
    
    leads_to_add = leads_to_add.substring(1);
    
    var leads_to_add_arr = leads_to_add.split('|');
    


   
    
    var formData = {
        	'leads_to_add'     : leads_to_add
        		
        }
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "insert_leads_into_pipedrive.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
    	
    	
    	  $('#spinner').modal('hide');
    	  
    	  	swal({
  title: "Success",
  text: "The leads are imported.",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#007E33",
  confirmButtonText: "OK",
  closeOnConfirm: false
},
function(){

	location.reload();

  
});


    	  
    	 
        				
    	}).responseText;
    	

    
        $('#spinner').modal({
 		 	backdrop: 'static',
  			keyboard: false
		});
        $('#spinner').modal('show');
    

}



</script>

