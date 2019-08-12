<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get pipedrive settings 

$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipedrive_api_token'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipedrive_api_token = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipedrive_url'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipedrive_url = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_company_phone_number_hash'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_company_phone_number_hash = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_company_mail_pool_hash'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_company_mail_pool_hash = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_category_hash'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_category_hash = $row_value['value'];

$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_sub_category_hash'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_sub_category_hash = $row_value['value'];




$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_website_hash'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_website_hash = $row_value['value'];





$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_category'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_category = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipe_drive_sub_category'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipe_drive_sub_category = $row_value['value'];




// get all categories

$db_get_all_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_all_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_all_categories ->connect_error . ']');
}

$sql_get_all_categories = "SELECT * FROM main_categories";

$result_get_all_categories = $db_get_all_categories->query($sql_get_all_categories);
$result_get_all_categories_2 = $db_get_all_categories->query($sql_get_all_categories);

$db_get_all_categories->close();


// get all sub_categories

$db_get_all_sub_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_all_sub_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_all_sub_categories ->connect_error . ']');
}

$sql_get_all_sub_categories = "SELECT * FROM category_subcategory";


$result_get_all_sub_categories = $db_get_all_sub_categories->query($sql_get_all_sub_categories);

$db_get_all_sub_categories->close();



$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_no_mail = $row_value['value'];


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

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_subject'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_no_mail_subject = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_sent'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_sent = $row_value['value'];



$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_sent_text'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_sent_text = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_subject'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_subject = $row_value['value'];



$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_activity'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_activity = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_activity'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_activity_if_no_mail_activity = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_leads'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_leads = $row_value['value'];



$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='import_lead_stage'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$import_lead_stage = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='import_email_exist_stage'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$import_email_exist_stage = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='import_initial_mail_sent_stage'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$import_initial_mail_sent_stage = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_leads_title'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_leads_title = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='no_mail_due'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$no_mail_due = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_marketing_mail_follow_up = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity = $row_value['value'];



$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_subject'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_subject = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_text'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_text = $row_value['value'];


$db_get_various_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_various_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_various_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_due'";

$result_get_various_settings = $db_get_various_settings->query($sql_get_various_settings);

$row_value = $result_get_various_settings->fetch_assoc();

$db_get_various_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_due = $row_value['value'];



$url = "https://api.pipedrive.com/v1/activityTypes?api_token=" . $pipedrive_api_token;
 
 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_URL, $url);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 	curl_setopt($ch, CURLOPT_POST, false);
 	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
 	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 	
 	$output_acitivity_types = curl_exec($ch);
	curl_close($ch);
	
	$output_acitivity_types = json_decode($output_acitivity_types, 1);


//   /organizationFields/{id}


$url = "https://api.pipedrive.com/v1/organizationFields/" . $pipe_drive_category ."?api_token=" . $pipedrive_api_token;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$pipe_drive_category_json = curl_exec($ch);
curl_close($ch);
$pipe_drive_category_json = json_decode($pipe_drive_category_json, 1);

//print_r($pipe_drive_category_json);

// get pipedrive sub categories


$url = "https://api.pipedrive.com/v1/organizationFields/" . $pipe_drive_sub_category ."?api_token=" . $pipedrive_api_token;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$pipe_drive_sub_category_json = curl_exec($ch);
curl_close($ch);
$pipe_drive_sub_category_json = json_decode($pipe_drive_sub_category_json, 1);



$url = "https://api.pipedrive.com/v1/stages?api_token=" . $pipedrive_api_token;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$output = curl_exec($ch);
curl_close($ch);
$result_lead_stages = json_decode($output, 1);



include "menu.php";



// get organisation fields from pipedrive

$url = "https://api.pipedrive.com/v1/organizationFields?api_token=" . $pipedrive_api_token;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$output = curl_exec($ch);
curl_close($ch);
$output_category = json_decode($output, 1);







?>




<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-pied-piper-pp fa-1x"></i> Pipedrive Settings</h3>
   <br>
   
   
   
   <div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Setting</a></li>
    <li role="presentation"><a href="#mapping" aria-controls="mapping" role="tab" data-toggle="tab">Category Mapping</a></li>
    <li role="presentation"><a href="#sub_mapping" aria-controls="sub_mapping" role="tab" data-toggle="tab">Sub Category Mapping</a></li>
    <li role="presentation"><a href="#no_email" aria-controls="no_email" role="tab" data-toggle="tab">Activity no E-Mail</a></li>
    <li role="presentation"><a href="#import_mail" aria-controls="import_mail" role="tab" data-toggle="tab">Activity Initial E-Mail</a></li>
    <li role="presentation"><a href="#leads" aria-controls="leads" role="tab" data-toggle="tab">Deals</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general">
    
    <br>
    
    <div class="panel panel-default">
  			<div class="panel-body">
  			
  			<form id="pipedrive_settings">
  			<div class="row">
  			
				<div class="form-group col-lg-4">
				<label>API-Token</label>
				<input type="text" class="form-control" id="pipedrive_api_token" name="pipedrive_api_token" value="<?php echo $pipedrive_api_token;?>">
				
				
				</div>
				
		
			</div>
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Pipedrive URL</label>
				<input type="text" class="form-control" id="pipedrive_url" name="pipedrive_url" value="<?php echo $pipedrive_url;?>">
				
				
				</div>
			
			</div>
			
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Company Phone Number Hash</label>
				<input type="text" class="form-control" id="pipe_drive_company_phone_number_hash" name="pipe_drive_company_phone_number_hash" value="<?php echo $pipe_drive_company_phone_number_hash;?>">
				
				
				</div>
			
			</div>
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Company E-Mail Pool Hash</label>
				<input type="text" class="form-control" id="pipe_drive_company_mail_pool_hash" name="pipe_drive_company_mail_pool_hash" value="<?php echo $pipe_drive_company_mail_pool_hash;?>">
				
				
				</div>
			
			</div>
			
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Category Hash</label>
				<input type="text" class="form-control" id="pipe_drive_category_hash" name="pipe_drive_category_hash" value="<?php echo $pipe_drive_category_hash;?>">
				
				
				</div>
			
			</div>
			
			
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Sub Category Hash</label>
				<input type="text" class="form-control" id="pipe_drive_sub_category_hash" name="pipe_drive_sub_category_hash" value="<?php echo $pipe_drive_sub_category_hash;?>">
				
				
				</div>
			
			</div>
			
			
				<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Company Website Hash</label>
				<input type="text" class="form-control" id="pipe_drive_website_hash" name="pipe_drive_website_hash" value="<?php echo $pipe_drive_website_hash;?>">
				
				
				</div>
			
			</div>
			
		
			
			
			
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Select Category from Organisation Fields</label>
				<select class="form-control" id="category_organisation_field" name="category_organisation_field">
				
				<?php
				
				  foreach($output_category as $loop1){
				
				   print_r($loop1);
				  

	  				foreach($loop1 as $loop2){
	  
	    				if (array_key_exists("name",$loop2)){
	    				
	    				   $name = $loop2['name'];
	    				   $cat_id = $loop2['id'];
	    				   
	    				   
	    				   
	    				   
	    				   if($pipe_drive_category ==  $cat_id){
	    				     
	    				      echo "<option value='" . $cat_id  ."' selected>" . $name  ."</option>";
	    				   
	    				   }else{
	    				    
	    				     echo "<option value='" . $cat_id  ."'>" . $name  ."</option>";
	    				   
	    				   }
	    				   
	    				   
	    	
	
	    	    			
	    	    		}
	    	    	}
	    		}
				
				?>
				
				
				</select>
				
				
				</div>
			
			</div>
			
			<div class="row">
			
			<div class="form-group col-lg-4">
				<label>Select Sub-Category from Organisation Fields</label>
				<select class="form-control" id="sub_category_organisation_field" name="sub_category_organisation_field">
				
				<?php
				
				  foreach($output_category as $loop1){
				
				   print_r($loop1);
				  

	  				foreach($loop1 as $loop2){
	  
	    				if (array_key_exists("name",$loop2)){
	    				
	    				   $name = $loop2['name'];
	    				   $cat_id = $loop2['id'];
	    				   
	    				   if($pipe_drive_sub_category == $cat_id){
	    				   	echo "<option value='" . $cat_id  ."' selected>" . $name  ."</option>";
	    				   
	    				   }else{
	    				   
	    				   	echo "<option value='" . $cat_id  ."'>" . $name  ."</option>";
	    				   }
	    				   
	    				   
	    	
	
	    	    			
	    	    		}
	    	    	}
	    		}
				
				?>
				
				
				</select>
				
				
				</div>
			
			</div>
			
			
			
			
			
  			
  			
  			<button type="submit" class="btn btn-success" name="submit_edit"  id="submit_edit" >Save</button>
  			
	</form>
	
	     </div>
    </div>
    
    
    
    </div>
    <div role="tabpanel" class="tab-pane" id="mapping">
    
    
    <br>
    
      <table id="category_mapping_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>Helptimize Category</th>
                	<th>Pipedrive Category</th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>

    
        <?php
        
        $category_counter = 0;
        
    	while ($row = $result_get_all_categories->fetch_assoc()) {
    	
    	$category_counter = $category_counter + 1;
    	
    	
    	$id_category = $row['id'];
    	$id_category_pipedrive = $row['pipe_drive_category'];
    	
    	

    	
    	?>
    	   <tr>
    	   
    	   <?php
    	   
    	   if($id_category_pipedrive == "" OR $id_category_pipedrive == "0"){
    	   
    	      ?>
    	      <td bgcolor="#FF8800" style="width: 50px"><?=$row['name']?></td> 
    	   
    	   <?php
    	   }else{
    	   
    	   ?>
    	   
    	      <td style="width: 50px"><?=$row['name']?></td> 
    	   
    	   
    	   
    	   <?php
    	   }
    	   
    	   ?>
    	   
    	   <td>
    	   <select class="form-control" id="pipedrive_categories_<?php echo $category_counter;?>" name="pipedrive_categories_<?php echo $category_counter;?>">
    	   
    	   <?php
    	   
    	   if($id_category_pipedrive == "0" OR $id_category_pipedrive == ""){
    	   
    	      echo "<option value='" . $id_category . "|0'>Please select category...</option>";
    	   
    	   
    	   }
    	   
    	   
    	   foreach($pipe_drive_category_json as $loop1){
				
				
	  				foreach($loop1 as $loop2){
	  				
	  				 
	  				   foreach($loop2 as $loop3){
	  				   
	  				    print_r($loop3);
	  				    
	  				    $cat_id = $loop3['id'];
	  				    $cat_name = $loop3['label'];
	  				    
	  				    if($id_category_pipedrive  ==  $cat_id){
	  				    
	  				    	echo "<option value='" . $id_category . "|" . $cat_id  ."' selected>" . $cat_name  ."</option>";
	  				    }else{
	  				    
	  				        
	  				    
	  				        echo "<option value='" . $id_category . "|" . $cat_id  ."'>" . $cat_name  ."</option>";
	  				    
	  				    }

	  				   
	  				   }
	  				
	  				
	  				}
	  				
}

?>
    	   
    	   
    	   </select>
    	   
    	   </td>
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	  </tr>
    	
    	<?php
    	
    	
    	
    	}
    	
    	?>
    	
    	
        	  </tbody>
   		 </table>
   		 
   		 <button class="btn btn-success" type="button" onclick="update_categories()">Update Categories</button>
    
    
    
    
    </div>
  

 <div role="tabpanel" class="tab-pane" id="sub_mapping">
 
 
   
    <br>
    
      <table id="sub_category_mapping_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>Helptimize Sub Category</th>
                	<th>Pipedrive Sub Category</th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	
        	
        	$sub_category_counter = 0;
        
    	while ($row = $result_get_all_sub_categories->fetch_assoc()) {
    	
    	$sub_category_counter = $sub_category_counter + 1;
    	
    	
    	$id_category = $row['id'];
    	$id_category_pipedrive = $row['pipe_drive_category'];
    	
    	

    	
    	?>
    	   <tr>
    	   
    	   <?php
    	   
    	   if($id_category_pipedrive == "" OR $id_category_pipedrive == "0"){
    	   
    	      ?>
    	      <td bgcolor="#FF8800" style="width: 50px"><?=$row['name']?></td> 
    	   
    	   <?php
    	   }else{
    	   
    	   ?>
    	   
    	      <td style="width: 50px"><?=$row['name']?></td> 
    	   
    	   
    	   
    	   <?php
    	   }
    	   
    	   ?>
    	   
    	   <td>
    	   <select class="form-control" id="pipedrive_sub_categories_<?php echo $sub_category_counter;?>" name="pipedrive_sub_categories_<?php echo $sub_category_counter;?>">
    	   
    	   <?php
    	   
    	   if($id_category_pipedrive == "0" OR $id_category_pipedrive == ""){
    	   
    	      echo "<option value='" . $id_category . "|0'>Please select category...</option>";
    	   
    	   
    	   }
    	   
    	   
    	   foreach($pipe_drive_sub_category_json as $loop1){
				
				
	  				foreach($loop1 as $loop2){
	  				
	  				 
	  				   foreach($loop2 as $loop3){
	  				   
	  				    print_r($loop3);
	  				    
	  				    $cat_id = $loop3['id'];
	  				    $cat_name = $loop3['label'];
	  				    
	  				    if($id_category_pipedrive  ==  $cat_id){
	  				    
	  				    	echo "<option value='" . $id_category . "|" . $cat_id  ."' selected>" . $cat_name  ."</option>";
	  				    }else{
	  				    
	  				        
	  				    
	  				        echo "<option value='" . $id_category . "|" . $cat_id  ."'>" . $cat_name  ."</option>";
	  				    
	  				    }

	  				   
	  				   }
	  				
	  				
	  				}
	  				
}

?>
    	   
    	   
    	   </select>
    	   
    	   </td>
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	   
    	  </tr>
    	
    	<?php
    	
    	
    	
    	}
    	
    	?>
    	
    	
        	  </tbody>
   		 </table>
   		 
   		 <button class="btn btn-success" type="button" onclick="update_sub_categories()">Update Sub Categories</button>
  
  
  
  

  
  
  
  
  
  
  
  </div>  
  
  
  
  
   <div role="tabpanel" class="tab-pane" id="no_email">
   <br>
 
       	<label>Create Pipedrive Activity if no E-Mail in Lead</label>
		<br>
		<input  type="checkbox" name="create_activity_no_mail" id="create_activity_no_mail">
		
		<br>
		<br>
		
		<div class="form-group">
  <label>Activity type</label>
  <select class="form-control" id="create_pipedrive_activity_if_no_mail_activity" name="create_pipedrive_activity_if_no_mail_activity">
  <?php
  
  
  foreach($output_acitivity_types as $loop1){
  
    foreach($loop1 as $loop2){
    
    if($create_pipedrive_activity_if_no_mail_activity == $loop2['key_string']){
       echo "<option value='". $loop2['key_string'] . "'selected >" . $loop2['name'] . "</option>";
    
    }else{
    
      echo "<option value='". $loop2['key_string'] . "'>" . $loop2['name'] . "</option>";
    }
    
     

    
    }
  

  
  }
  
  
  
  ?>
  
    
  </select>
</div>
	
		
		
		
		
		
		
		
		<label>Activity Subject if no E-Mail in Lead</label>
		<br>
		<input type="text" class="form-control" id="create_pipedrive_activity_if_no_mail_subject" name="create_pipedrive_activity_if_no_mail_subject" value="<?php echo $create_pipedrive_activity_if_no_mail_subject;?>">
	
	
	
	
	
		<br>
		
		<div class="form-group">
  			<label for="comment">Pipedrive activity text if no E-Mail in lead</label>
  			<textarea class="form-control" rows="3" id="create_activity_no_mail_text" name="create_activity_no_mail_text"><?php echo $create_pipedrive_activity_if_no_mail_text;?></textarea>
		</div>
		
		
		<div class="form-group">
    		<label>Activity due x-days after import</label>
    		<input id="no_mail_due" type="text" value="<?php echo $no_mail_due;?>" name="no_mail_due">
     	</div>
		
		
		 <button class="btn btn-success" type="button" onclick="update_pipedrive_no_mail()">Update No Mail Activity</button>

   
   </div>
   
   
   

   <div role="tabpanel" class="tab-pane" id="import_mail">
   
   
   <br>

<label>Create Pipedrive Activity if initial Marketing E-Mail sent</label>
	<br>
	<input  type="checkbox" name="create_pipedrive_activity_if_initial_marketing_mail_sent" id="create_pipedrive_activity_if_initial_marketing_mail_sent"></td><td>
	<br><br>
	
	
	
		<div class="form-group">
  <label>Activity type</label>
  <select class="form-control" id="create_pipedrive_activity_if_initial_marketing_mail_activity" name="create_pipedrive_activity_if_initial_marketing_mail_activity">
  <?php
  
  
  foreach($output_acitivity_types as $loop1){
  
    foreach($loop1 as $loop2){
    
    if($create_pipedrive_activity_if_initial_marketing_mail_activity == $loop2['key_string']){
       echo "<option value='". $loop2['key_string'] . "'selected >" . $loop2['name'] . "</option>";
    
    }else{
    
      echo "<option value='". $loop2['key_string'] . "'>" . $loop2['name'] . "</option>";
    }
    
     

    
    }
  

  
  }
  
  
  
  ?>
  
    
  </select>
</div>
	
	
	
	
	
	
	
		<label>Activity Subject initial Marketing E-Mail</label>
		<br>
		<input type="text" class="form-control" id="create_pipedrive_activity_if_initial_marketing_mail_subject" name="create_pipedrive_activity_if_initial_marketing_mail_subject" value="<?php echo $create_pipedrive_activity_if_initial_marketing_mail_subject;?>">

		
		<br>
		
		<div class="form-group">
  <label for="comment">Pipedrive activity text if initial Marketing E-Mail sent</label>
  <textarea class="form-control" rows="3" id="create_pipedrive_activity_if_initial_marketing_mail_sent_text" name="create_pipedrive_activity_if_initial_marketing_mail_sent_text"><?php echo $create_pipedrive_activity_if_initial_marketing_mail_sent_text;?></textarea>
</div>

<hr>


<label>Create Pipedrive Activity Follow-Up</label>
	<br>
	<input  type="checkbox" name="create_pipedrive_marketing_mail_follow_up" id="create_pipedrive_marketing_mail_follow_up">
	<br><br>
	
	
	<div class="form-group">
  <label>Activity type</label>
  <select class="form-control" id="create_pipedrive_marketing_mail_follow_up_activity" name="create_pipedrive_marketing_mail_follow_up_activity">
  <?php
  
  
  foreach($output_acitivity_types as $loop1){
  
    foreach($loop1 as $loop2){
    
    if($create_pipedrive_marketing_mail_follow_up_activity == $loop2['key_string']){
       echo "<option value='". $loop2['key_string'] . "'selected >" . $loop2['name'] . "</option>";
    
    }else{
    
      echo "<option value='". $loop2['key_string'] . "'>" . $loop2['name'] . "</option>";
    }
    
     

    
    }
  

  
  }
  
  ?>
  
    
  </select>
  </div>
  
  
  <label>Create Pipedrive Activity Follow-Up Subject</label>
		<br>
		<input type="text" class="form-control" id="create_pipedrive_marketing_mail_follow_up_activity_subject" name="create_pipedrive_marketing_mail_follow_up_activity_subject" value="<?php echo $create_pipedrive_marketing_mail_follow_up_activity_subject;?>">

		
		<br>
		
		<div class="form-group">
  <label for="comment">Create Pipedrive Activity Follow-Up Text</label>
  <textarea class="form-control" rows="3" id="create_pipedrive_marketing_mail_follow_up_activity_text" name="create_pipedrive_marketing_mail_follow_up_activity_text"><?php echo $create_pipedrive_marketing_mail_follow_up_activity_text;?></textarea>
</div>



<div class="form-group">
    		<label>Activity due in x-days</label>
    		<input id="create_pipedrive_marketing_mail_follow_up_activity_due" type="text" value="<?php echo $create_pipedrive_marketing_mail_follow_up_activity_due;?>" name="create_pipedrive_marketing_mail_follow_up_activity_due">
     	</div>
	
	
	<br>




 <button class="btn btn-success" type="button" onclick="update_pipedrive_initial()">Update Initial Mail Activity</button>
   
   	<br>
   

   
   </div>
   
  
  
<div role="tabpanel" class="tab-pane" id="leads">


 <br>
 
       	<label>Create Pipedrive Deals</label>
		<br>
		<input  type="checkbox" name="create_pipedrive_leads" id="create_pipedrive_leads">
		<br>
		<br>
		<label>Deal Title</label>
		<input type="text" class="form-control" id="create_pipedrive_leads_title" name="create_pipedrive_leads_title" value="<?php echo $create_pipedrive_leads_title;?>">
	
		

		<div class="form-group">
    <label>Import Stage</label>
    <select class="form-control" id="import_lead_stage" name="import_lead_stage">
    
      <?php
       				
       				foreach($result_lead_stages as $item) { 
   						$i = 0;
    
    					foreach($item as $user){
    					
    					    if($user['id'] == $import_lead_stage){
    					    	echo "<option selected value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    					    
    					    }else{
    					    	echo "<option value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    					    
    					    }
    					
    					    

		 				}
					}
       				
       				
       				?>
    

    <select>
    </div>
    
    
    <div class="form-group">
    <label>E-Mail Exist</label>
    <select class="form-control" id="import_email_exist_stage" name="import_email_exist_stage">
    
      <?php
       				
       				foreach($result_lead_stages as $item) { 
   						$i = 0;
    
    					foreach($item as $user){
    					
    						 if($user['id'] == $import_email_exist_stage){
    						 	echo "<option selected value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    						 }else{
    						 	echo "<option value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    						 }
    					
    					    

		 				}
					}
       				
       				
       				?>
    
    
    
    <select>
    </div>


    <div class="form-group">
    <label>Initial Mail sent</label>
    <select class="form-control" id="import_initial_mail_sent_stage" name="import_initial_mail_sent_stage">
    
      <?php
       				
       				foreach($result_lead_stages as $item) { 
   						$i = 0;
    
    					foreach($item as $user){
    						 if($user['id'] == $import_initial_mail_sent_stage){
    						 	echo "<option selected value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    						 }else{
    						 
    						 echo "<option value='" . $user['id']   . "'>" . $user['name']  . "</option>";
    						 }
    					
    					    

		 				}
					}
       				
       				
       				?>
    
    
    
    <select>
    </div>
    
     <button class="btn btn-success" type="button" onclick="update_pipedrive_leads()">Update Leads</button>



</div>
   
   
   
   
   
   </div>
   
</div>


<script>


$("input[name='no_mail_due']").TouchSpin({
                min: 1,
                max: 300,
                step:1,
                decimals:0,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '<i class="fa fa-clock-o"></i>'
            });
            
            
   
   $("input[name='create_pipedrive_marketing_mail_follow_up_activity_due']").TouchSpin({
                min: 1,
                max: 300,
                step:1,
                decimals:0,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '<i class="fa fa-clock-o"></i>'
            });
                     


 $("[name='create_activity_no_mail']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	
	
 $("[name='create_pipedrive_activity_if_initial_marketing_mail_sent']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	
 $("[name='create_pipedrive_leads']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	

 $("[name='create_pipedrive_marketing_mail_follow_up']").bootstrapSwitch({
	size: 'small',
	onText: 'Yes',
	offText: 'No',
	//state: state1

	})
	
	
	
	

function update_pipedrive_leads(){

		var create_pipedrive_leads = $('#create_pipedrive_leads').bootstrapSwitch('state');
		var import_lead_stage = $('#import_lead_stage').val();
		var import_email_exist_stage = $('#import_email_exist_stage').val();
		var import_initial_mail_sent_stage = $('#import_initial_mail_sent_stage').val();
		var create_pipedrive_leads_title = $('#create_pipedrive_leads_title').val();
		
		
		
		
		if(create_pipedrive_leads == true){
    		create_pipedrive_leads = 1;
     	}else{
     		create_pipedrive_leads = 0;	
     	}
     	
     	var formData = {
        	'create_pipedrive_leads'     : create_pipedrive_leads,
        	'import_lead_stage'     : import_lead_stage,
        	'import_email_exist_stage'     : import_email_exist_stage,
        	'import_initial_mail_sent_stage'     : import_initial_mail_sent_stage,
        	'create_pipedrive_leads_title'     : create_pipedrive_leads_title

             }
             
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_leads.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	swal({
  			title: "Success",
  			text: "The settings are updated.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#007E33",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
			},
			function(){
				location.reload();

			});
     
     	
     	




}	
	
	
	
	
function update_pipedrive_initial(){


	var create_pipedrive_activity_if_initial_marketing_mail_sent = $('#create_pipedrive_activity_if_initial_marketing_mail_sent').bootstrapSwitch('state');
	var create_pipedrive_activity_if_initial_marketing_mail_sent_text = $('#create_pipedrive_activity_if_initial_marketing_mail_sent_text').val();
	var create_pipedrive_activity_if_initial_marketing_mail_subject = $('#create_pipedrive_activity_if_initial_marketing_mail_subject').val();
	var create_pipedrive_activity_if_initial_marketing_mail_activity = $('#create_pipedrive_activity_if_initial_marketing_mail_activity').val();
	
	var create_pipedrive_marketing_mail_follow_up = $('#create_pipedrive_marketing_mail_follow_up').bootstrapSwitch('state');
	var create_pipedrive_marketing_mail_follow_up_activity = $('#create_pipedrive_marketing_mail_follow_up_activity').val();
	var create_pipedrive_marketing_mail_follow_up_activity_subject = $('#create_pipedrive_marketing_mail_follow_up_activity_subject').val();
	var create_pipedrive_marketing_mail_follow_up_activity_text = $('#create_pipedrive_marketing_mail_follow_up_activity_text').val();
	var create_pipedrive_marketing_mail_follow_up_activity_due = $('#create_pipedrive_marketing_mail_follow_up_activity_due').val();
	
	
	
	if(create_pipedrive_activity_if_initial_marketing_mail_sent == true){
    	create_pipedrive_activity_if_initial_marketing_mail_sent = 1;
     }else{
     	create_pipedrive_activity_if_initial_marketing_mail_sent = 0;
     }
     
     if(create_pipedrive_marketing_mail_follow_up == true){
    	create_pipedrive_marketing_mail_follow_up = 1;
     }else{
     	create_pipedrive_marketing_mail_follow_up = 0;
     }
     
     
      var formData = {
        	'create_pipedrive_activity_if_initial_marketing_mail_sent'     : create_pipedrive_activity_if_initial_marketing_mail_sent,
        	'create_pipedrive_activity_if_initial_marketing_mail_sent_text'     : create_pipedrive_activity_if_initial_marketing_mail_sent_text,
        	'create_pipedrive_activity_if_initial_marketing_mail_subject'     : create_pipedrive_activity_if_initial_marketing_mail_subject,
        	'create_pipedrive_activity_if_initial_marketing_mail_activity'     : create_pipedrive_activity_if_initial_marketing_mail_activity,
        	'create_pipedrive_marketing_mail_follow_up'     : create_pipedrive_marketing_mail_follow_up,
        	'create_pipedrive_marketing_mail_follow_up_activity'     : create_pipedrive_marketing_mail_follow_up_activity,
        	'create_pipedrive_marketing_mail_follow_up_activity_subject'     : create_pipedrive_marketing_mail_follow_up_activity_subject,
        	'create_pipedrive_marketing_mail_follow_up_activity_text'     : create_pipedrive_marketing_mail_follow_up_activity_text,
        	'create_pipedrive_marketing_mail_follow_up_activity_due'     : create_pipedrive_marketing_mail_follow_up_activity_due

             }
    
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_activity_initial_mail.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	swal({
  			title: "Success",
  			text: "The settings are updated.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#007E33",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
			},
			function(){
				location.reload();

			});
     


}	
	
function update_pipedrive_no_mail(){

	var create_pipedrive_activity_if_no_mail = $('#create_activity_no_mail').bootstrapSwitch('state');
	
	var create_pipedrive_activity_if_no_mail_text = $('#create_activity_no_mail_text').val();
	var create_pipedrive_activity_if_no_mail_subject = $('#create_pipedrive_activity_if_no_mail_subject').val();
	var create_pipedrive_activity_if_no_mail_activity = $('#create_pipedrive_activity_if_no_mail_activity').val();
	
	
	var no_mail_due = $('#no_mail_due').val();

	
	if(create_pipedrive_activity_if_no_mail == true){
    	create_pipedrive_activity_if_no_mail = 1;
     }else{
     	create_pipedrive_activity_if_no_mail = 0;
     }
     
      var formData = {
        	'create_pipedrive_activity_if_no_mail'     : create_pipedrive_activity_if_no_mail,
        	'create_pipedrive_activity_if_no_mail_text'     : create_pipedrive_activity_if_no_mail_text,
        	'create_pipedrive_activity_if_no_mail_subject'     : create_pipedrive_activity_if_no_mail_subject,
        	'create_pipedrive_activity_if_no_mail_activity'     : create_pipedrive_activity_if_no_mail_activity,
        	'no_mail_due'     : no_mail_due

             }
    
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_activity_if_no_mail.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	swal({
  			title: "Success",
  			text: "The settings are updated.",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#007E33",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
			},
			function(){
				location.reload();

			});
     


}



function update_sub_categories(){


var category_counter = "<?php echo $sub_category_counter; ?>";
  
  var category_string = "";
  
   for (i = 1; i <= category_counter; i++) { 
   
     var category_value = $("#pipedrive_sub_categories_" + i).val();
     
     category_string = category_string + category_value + "-";

   
   }
   
   
   category_string= category_string.substring(0, category_string.length-1);
   
    var formData = {
        	'category_string'     : category_string
        		
        }
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_sub_category_mapping.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	swal({
  title: "Success",
  text: "The sub categories are updated.",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#007E33",
  confirmButtonText: "OK",
  closeOnConfirm: false
},
function(){

	location.reload();

  
});
   

   


}



function update_categories(){
 
  var category_counter = "<?php echo $category_counter; ?>";
  
  var category_string = "";
  
   for (i = 1; i <= category_counter; i++) { 
   
     var category_value = $("#pipedrive_categories_" + i).val();
     
     category_string = category_string + category_value + "-";

   
   }
   
   
   category_string= category_string.substring(0, category_string.length-1);
   
   
    var formData = {
        	'category_string'     : category_string
        		
        }
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_category_mapping.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	swal({
  title: "Success",
  text: "The categories are updated.",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#007E33",
  confirmButtonText: "OK",
  closeOnConfirm: false
},
function(){

	location.reload();

  
});
 
 
       
   



}



$(document).ready(function() {

var create_pipedrive_marketing_mail_follow_up = "<?php echo $create_pipedrive_marketing_mail_follow_up; ?>";
if(create_pipedrive_marketing_mail_follow_up == 1){
      
      $('input[name="create_pipedrive_marketing_mail_follow_up"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="create_pipedrive_marketing_mail_follow_up"]').bootstrapSwitch('state', false, false);
      
    	
    }




var create_pipedrive_leads = "<?php echo $create_pipedrive_leads; ?>";
if(create_pipedrive_leads == 1){
      
      $('input[name="create_pipedrive_leads"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="create_pipedrive_leads"]').bootstrapSwitch('state', false, false);
      
    	
    }



var create_pipedrive_activity_if_no_mail = "<?php echo $create_pipedrive_activity_if_no_mail; ?>";
if(create_pipedrive_activity_if_no_mail == 1){
      
      $('input[name="create_activity_no_mail"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="create_activity_no_mail"]').bootstrapSwitch('state', false, false);
      
    	
    }
    
    
var create_pipedrive_activity_if_initial_marketing_mail_sent = "<?php echo $create_pipedrive_activity_if_initial_marketing_mail_sent; ?>";
if(create_pipedrive_activity_if_initial_marketing_mail_sent == 1){
      
      $('input[name="create_pipedrive_activity_if_initial_marketing_mail_sent"]').bootstrapSwitch('state', true, true);
    	
    }else{
    
      $('input[name="create_pipedrive_activity_if_initial_marketing_mail_sent"]').bootstrapSwitch('state', false, false);
      
    	
    }


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


    
    $('#category_mapping_list').dataTable( {
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







    $('#pipedrive_settings').formValidation({
        framework: 'bootstrap',
        
        fields: {
            pipedrive_api_token: {
                validators: {
                    notEmpty: {
                        message: 'The api token is required'
                    }
                    
                }
            },
            pipedrive_url: {
                validators: {
                    notEmpty: {
                        message: 'The pipedrive URL is required'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();
            
            var pipedrive_api_token = $("#pipedrive_api_token").val();
            var pipedrive_url = $("#pipedrive_url").val();
            var pipe_drive_company_phone_number_hash = $("#pipe_drive_company_phone_number_hash").val();
            var pipe_drive_company_mail_pool_hash = $("#pipe_drive_company_mail_pool_hash").val();
            var pipe_drive_category_hash = $("#pipe_drive_category_hash").val();
            var pipe_drive_sub_category_hash = $("#pipe_drive_sub_category_hash").val();
            var category_organisation_field = $("#category_organisation_field").val();
            var sub_category_organisation_field = $("#sub_category_organisation_field").val();
			var pipe_drive_website_hash = $("#pipe_drive_website_hash").val()
        
            
            var formData = {
        		'pipedrive_api_token'     : pipedrive_api_token,
        		'pipedrive_url'     : pipedrive_url,
        		'pipe_drive_company_phone_number_hash'     : pipe_drive_company_phone_number_hash,
        		'pipe_drive_company_mail_pool_hash'     : pipe_drive_company_mail_pool_hash,
        		'pipe_drive_category_hash'     : pipe_drive_category_hash,
        		'pipe_drive_sub_category_hash'     : pipe_drive_sub_category_hash,
        		'pipe_drive_category'     : category_organisation_field,
        		'pipe_drive_sub_category'     : sub_category_organisation_field,
        		'pipe_drive_website_hash'     : pipe_drive_website_hash
    
    		}
    	
    	  var pipedrive_update = $.ajax({
    			type: "POST",
    			url: "update_pipedrive_settings.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	swal({
  title: "Success",
  text: "The Pipedrive settings are updated.",
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
   

