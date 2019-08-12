<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$leads_to_add = $_POST["leads_to_add"];

require('mailin.php');


$echo = "";


// get pipedriver settings

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

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_no_mail = $row_value['value'];




$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_text'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_no_mail_text = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='delete_lead_after_import'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$delete_lead_after_import = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='initial_pipedrive_import_mail'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$initial_pipedrive_import_mail = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_sent'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_sent = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_sent_text'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_sent_text = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_subject'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_subject = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_initial_marketing_mail_activity'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_initial_marketing_mail_activity = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_activity'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_no_mail_activity = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_activity_if_no_mail_subject'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_activity_if_no_mail_subject = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_leads_title'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_leads_title = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_leads'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_leads = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='import_lead_stage'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$import_lead_stage = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='import_email_exist_stage'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$import_email_exist_stage = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='import_initial_mail_sent_stage'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$import_initial_mail_sent_stage = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='no_mail_due'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$no_mail_due = $row_value['value'];



$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_marketing_mail_follow_up = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_subject'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_subject = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_text'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_text = $row_value['value'];


$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='create_pipedrive_marketing_mail_follow_up_activity_due'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$create_pipedrive_marketing_mail_follow_up_activity_due = $row_value['value'];



$leads_to_add_array = explode("|", $leads_to_add);


$counter = 0;

foreach ($leads_to_add_array as &$value) {

   // get lead details form database
   
   $db_get_lead = new mysqli("$host", "$username", "$password", "$db_name");

	$sql_get_lead = "SELECT * FROM potential_service_providers WHERE id='$value'";

	if($db_get_lead ->connect_errno > 0){
    	die('Unable to connect to database [' . $db_get_lead ->connect_error . ']');
	}

	$result_get_lead = $db_get_lead->query($sql_get_lead);
	$row_lead = $result_get_lead->fetch_assoc();
	$db_get_lead->close();
	
	
	$name = $row_lead['name'];
	$address = $row_lead['formatted_address'];
	$mail = $row_lead['emails'];
	
	$phone_number = $row_lead['formatted_phone_number'];
	
	$helptimize_category = $row_lead['category'];
	$helptimize_sub_category = $row_lead['sub_category'];
	$pipedrive_user = $row_lead['pipedrive_user'];
	$website = $row_lead['website'];
	$lead_id = $row_lead['id'];
	
	
	
	// get pipedrive category / sub_category
	
	$db_get_pipedrive_categories = new mysqli("$host", "$username", "$password", "$db_name");

	if($db_get_pipedrive_categories ->connect_errno > 0){
    	die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
	}

	$sql_get_pipedrive_categories = "SELECT pipe_drive_category FROM main_categories WHERE id ='$helptimize_category'";

 	$result_get_pipedrive_categories = $db_get_pipedrive_categories->query($sql_get_pipedrive_categories);

	$row_value = $result_get_pipedrive_categories->fetch_assoc();

	$db_get_pipedrive_categories->close();
	
	$pipe_drive_category = $row_value['pipe_drive_category'];
	
	
	
	$db_get_pipedrive_sub_categories = new mysqli("$host", "$username", "$password", "$db_name");

	if($db_get_pipedrive_sub_categories ->connect_errno > 0){
    	die('Unable to connect to database [' . $db_get_pipedrive_sub_categories ->connect_error . ']');
	}

	$sql_get_pipedrive_sub_categories = "SELECT pipe_drive_category FROM category_subcategory WHERE id ='$helptimize_sub_category'";

 	$result_get_pipedrive_sub_categories = $db_get_pipedrive_sub_categories->query($sql_get_pipedrive_sub_categories);

	$row_value = $result_get_pipedrive_sub_categories->fetch_assoc();

	$db_get_pipedrive_sub_categories->close();
	
	$pipe_drive_sub_category = $row_value['pipe_drive_category'];
	
	
	
        	 
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
			
			
		    $phone =  $characters_add_in_front_phone_number . $phone_number;

	
			$organization = array(
 					'name' => $name,	
 					$pipe_drive_company_phone_number_hash => $phone,
 					$pipe_drive_company_mail_pool_hash => $mail,
 					$pipe_drive_category_hash => $pipe_drive_category,
 					$pipe_drive_sub_category_hash => $pipe_drive_sub_category,
					'address' => $address,
					'owner_id' => $pipedrive_user,
					$pipe_drive_website_hash => $website
		
				);
				
	$url = "https://api.pipedrive.com/v1/organizations?api_token=" . $pipedrive_api_token;
				

				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
     			curl_setopt($ch, CURLOPT_POSTFIELDS, $organization);
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);
	
	$counter = $counter + 1;		
	
	
	// flag lead as imported	
	
	$db_update_lead = new mysqli("$host", "$username", "$password", "$db_name");

	if($db_update_lead->connect_errno > 0){
    	die('Unable to connect to database [' . $db_update_lead->connect_error . ']');
	}


    if($delete_lead_after_import == 1){
    	$sql_update_lead = "UPDATE potential_service_providers SET in_pipedrive='1' WHERE id='$lead_id'"; 
    }else{
    	$sql_update_lead = "UPDATE potential_service_providers SET in_pipedrive='0' WHERE id='$lead_id'"; 
    }


	$db_update_lead->query($sql_update_lead);
	$db_update_lead->close();
	
	// create the deal 
	
	$deal_id = "";
	
	if($create_pipedrive_leads == 1){
	
		$url = "https://api.pipedrive.com/v1/searchResults?term=". $address . "&item_type=organization&start=0&limit=1&api_token=" . $pipedrive_api_token;
 
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

		$result = json_decode($output, 1);
			
		$org_id =  $result['data'][0]['id'];
		
		$stage_id = "" ;
		
		
		if($mail == ""){
		
		  $stage_id = $import_lead_stage;
				
		}
		
		if($mail != "" AND $initial_pipedrive_import_mail > 0){
		
		  $stage_id = $import_initial_mail_sent_stage;
				
		}
		
		if($mail != "" AND $initial_pipedrive_import_mail == 0){
		
		  $stage_id = $import_email_exist_stage;
				
		}
		

	
		$deal = array(
 			'title' => $create_pipedrive_leads_title,
 			'org_id' =>   $org_id,
 			'user_id' => $pipedrive_user,
 			'stage_id' =>  $stage_id
 					
		);
		
		
		$url = "https://api.pipedrive.com/v1/deals?api_token=" . $pipedrive_api_token;
				
		$ch = curl_init();
 		curl_setopt($ch, CURLOPT_URL, $url);
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 		curl_setopt($ch, CURLOPT_POST, true);
 
 		curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
 		$output = curl_exec($ch);
 		$info = curl_getinfo($ch);
 		curl_close($ch);
 		
 		
 		$result = json_decode($output, 1);
			
		$deal_id =  $result['data']['id'];
 		
 		
	
	}
	
	
	
	
	// check if we need to send out initial marketing mail 
	
	if($mail != ""){
	
	   if($initial_pipedrive_import_mail > 0){
	   
	   		$mailin = new Mailin("https://api.sendinblue.com/v2.0","D4KIm2NdRE9PkU7h");
    		$data = array( "id" => $initial_pipedrive_import_mail,
      			"to" => "daniel@fonreach.com",
      			"replyto" => "daniel@helptimize.com"
      
    		);
 
    		$test  = $mailin->send_transactional_template($data);
    		
    		
    		if($create_pipedrive_activity_if_initial_marketing_mail_sent == 1){
    		

    			// create activity that initial marketing e-mail was sent
    		
    			$url = "https://api.pipedrive.com/v1/searchResults?term=". $address . "&item_type=organization&start=0&limit=1&api_token=" . $pipedrive_api_token;
 
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

				$result = json_decode($output, 1);
			
				$org_id =  $result['data'][0]['id'];
				
				$activity = array(
 					'subject' => $create_pipedrive_activity_if_initial_marketing_mail_subject,
 					'type' => $create_pipedrive_activity_if_initial_marketing_mail_activity,
 					'done' => 1,
 					'org_id' =>   $org_id,
 					'user_id' => $pipedrive_user,
 					'note' =>   $create_pipedrive_activity_if_initial_marketing_mail_sent_text,
 					'deal_id' =>   $deal_id
 					
				);
					
				$url = "https://api.pipedrive.com/v1/activities?api_token=" . $pipedrive_api_token;
				
				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
 
 				curl_setopt($ch, CURLOPT_POSTFIELDS, $activity);
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);
 				
 				
 				if($create_pipedrive_marketing_mail_follow_up == 1){
 				
 				
 					$url = "https://api.pipedrive.com/v1/searchResults?term=". $address . "&item_type=organization&start=0&limit=1&api_token=" . $pipedrive_api_token;
 
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

					$result = json_decode($output, 1);
			
					$org_id =  $result['data'][0]['id'];
					
					$startDate = time();
	    			$marketing_mail_follow_up_activity_due = "+" . $create_pipedrive_marketing_mail_follow_up_activity_due . "day";
					$marketing_mail_follow_up_activity_due =  date('Y-m-d', strtotime($marketing_mail_follow_up_activity_due, $startDate));
				
					$activity = array(
 						'subject' => $create_pipedrive_marketing_mail_follow_up_activity_subject,
 						'type' => $create_pipedrive_marketing_mail_follow_up_activity,
 						'org_id' =>   $org_id,
 						'user_id' => $pipedrive_user,
 						'note' =>   $create_pipedrive_marketing_mail_follow_up_activity_text,
 						'due_date' =>   $marketing_mail_follow_up_activity_due,
 						'deal_id' =>  $deal_id
 					
				);
					
				$url = "https://api.pipedrive.com/v1/activities?api_token=" . $pipedrive_api_token;
				
				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
 
 				curl_setopt($ch, CURLOPT_POSTFIELDS, $activity);
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);

			
				}
				
				
			}
			
			
			
			
			
    		
    	
	   
	   }
	
	
	}
	
	
	// check if we need to cretea no e-mail activity
	
	
	if($mail == ""){
	
	        // check if activity needs to be created
	        
	    if($create_pipedrive_activity_if_no_mail == "1"){
	        
	    
			$url = "https://api.pipedrive.com/v1/searchResults?term=". $address . "&item_type=organization&start=0&limit=1&api_token=" . $pipedrive_api_token;
 

 
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

			$result = json_decode($output, 1);
			
			$org_id =  $result['data'][0]['id'];
			
			$echo = $org_id;
			    	
	    	
	    	$today = date("d-m-Y H:i:s");   
	    	
	    	$startDate = time();
	    	$no_mail_due_date = "+" . $no_mail_due . "day";
			$no_mail_due_date =  date('Y-m-d', strtotime($no_mail_due_date, $startDate));
	    	
	    	$activity = array(
 					'subject' => $create_pipedrive_activity_if_no_mail_subject,
 					'type' => $create_pipedrive_activity_if_no_mail_activity,
 					'org_id' =>   $org_id,
 					'user_id' => $pipedrive_user,
 					'note' =>   $create_pipedrive_activity_if_no_mail_text,
 					'due_date' =>   $no_mail_due_date,
 					'deal_id' =>   $deal_id
 					
 					
				);
					
				$url = "https://api.pipedrive.com/v1/activities?api_token=" . $pipedrive_api_token;
				
				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
 
 				curl_setopt($ch, CURLOPT_POSTFIELDS, $activity);
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);

		}	
	}
	
	
	
	
	
	
	
	
	

}


echo $echo;


?>