<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$auth_header = 'api-key:D4KIm2NdRE9PkU7h';
$content_header = "Content-Type:application/json";

$data = array( "type"=>"template",
        "status"=>"temp_active",
        "page"=>1,
        "page_limit"=>10
      );

$url = "https://api.sendinblue.com/v2.0/campaign/detailsv2";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header,$content_header));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET' );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$sendinblue_array = json_decode( $output, true );




// check if we need to crawl mails


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='crawl_e_mail'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$crawl_e_mail = $row_value['value'];



// check if create_pipedrive_activity_if_no_mail


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_no_mail = $row_value['value'];


// check if create_pipedrive_activity_if_no_mail text


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_text'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_no_mail_text = $row_value['value'];




$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='delete_lead_after_import'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$delete_lead_after_import = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='initial_pipedrive_import_mail'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$initial_pipedrive_import_mail = $row_value['value'];




include "menu.php";

?>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-cogs fa-1x"></i> Various Settings</h3>
   <br>

<form id="various_settings">

	<label>Crawl E-Mail Addresses</label>
	<br>
	<input  type="checkbox" name="crawl_mail" id="crawl_mail"></td><td>
	
		<br>
		<br>
		
    <label>Mark lead as imported when imported in Pipedrive</label>
	<br>
	<input  type="checkbox" name="imported" id="imported"></td><td>
	
		<br>
		<br>
		
	

<div class="form-group">
  <label for="sel1">Initial E-Mail Template (if a template is selected mail will be sent during pipedrive import)</label>
  <select class="form-control" id="initial_mail" name="initial_mail">
  
  <?php
  
  echo "<option value='0'>Please select a template.....</option>";
  
  foreach($sendinblue_array as $loop1){

	foreach($loop1 as $loop2){
	
	    foreach($loop2 as $loop3){
	    
	    	$template_id = $loop3['id'];
	        $campaign_name = $loop3['campaign_name'];
	        
	        if($initial_pipedrive_import_mail == $template_id){
	        	echo "<option selected value='" . $template_id ."'>". $campaign_name . "</option>";
	        }else{
	        	echo "<option value='" . $template_id ."'>". $campaign_name . "</option>";
	        }
	        
	    	
	   }

	}

  }
  
?>
 </select>
 
	




    
 
</div>
	
	<button type="submit" class="btn btn-success" name="submit_edit"  id="submit_edit" >Save</button>

</form>


</div>
</div>


<script>


 $("[name='crawl_mail']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	
	

$("[name='imported']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	
	

	
	


 $('#various_settings').formValidation({
        framework: 'bootstrap'
        
        
    }).on('success.form.fv', function(e) {
            // Prevent form submission
            
            e.preventDefault();
            
            var crawl_mail = $('#crawl_mail').bootstrapSwitch('state');
            
            
            var delete_lead_after_import = $('#imported').bootstrapSwitch('state');
            
           
            
            if(delete_lead_after_import == true){
     			delete_lead_after_import = 1;
     		}else{
     			delete_lead_after_import = 0;
     		}
            
            if(crawl_mail == true){
     			crawl_mail = 1;
     		}else{
     			crawl_mail = 0;
     		}
     		
     		
     		var initial_mail = $('#initial_mail').val();
     		
     
            
            var formData = {
        	'crawl_mail'     : crawl_mail,
        	'delete_lead_after_import'     : delete_lead_after_import,
        	'initial_mail'     : initial_mail
        	

             }
    
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_various.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	swal({
  title: "Success",
  text: "The various settings are updated.",
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
    
      
    
$( document ).ready(function() {

    var fixrate = "<?php echo $crawl_e_mail; ?>";
    
    

     
     var imported = "<?php echo $delete_lead_after_import; ?>";
     
     
     
     
     
     if(imported == 1){
      
      $('input[name="imported"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="imported"]').bootstrapSwitch('state', false, false);
      
    	
    }
     
    
    
    if(fixrate == 1){
      
      $('input[name="crawl_mail"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="crawl_mail"]').bootstrapSwitch('state', false, false);
      
    	
    }
    
    

   
    
});    




	
    
    
	
</script>
