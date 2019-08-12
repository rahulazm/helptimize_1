<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$name = $_POST["name"];
$formatted_address = $_POST["formatted_address"];
$formatted_phone_number = $_POST["formatted_phone_number"];
$place_id = $_POST["place_id"];
$website = $_POST["website"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$category = $_POST["category"];
$sub_category = $_POST["sub_category"];

$pipedrive_user = $_POST["pipedrive_user"];


// get mail crawl settings

$db_get_mail_crawl_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_mail_crawl_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_mail_crawl_settings ->connect_error . ']');
}

$sql_get_mail_crawl_settings = "SELECT value FROM admin_settings WHERE keyword ='crawl_e_mail'";

$result_get_mail_crawl_settings = $db_get_mail_crawl_settings->query($sql_get_mail_crawl_settings);

$row_value = $result_get_mail_crawl_settings->fetch_assoc();

$db_get_mail_crawl_settings->close();

$crawl_e_mail = $row_value['value'];

$mail_string = "";

if($crawl_e_mail == "1"){
	
	$website_for_email_search = str_replace('http://www.', '',$website);
	$website_for_email_search = str_replace('http://', '', $website_for_email_search );
	$website_for_email_search = str_replace('https://', '', $website_for_email_search );
	$website_for_email_search = str_replace('/', '', $website_for_email_search );

	$url = "https://api.hunter.io/v2/domain-search?domain=" . $website_for_email_search . "&api_key=aeaafedd1d4c07f029147f89a92d175dff01cf0d";
 
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

	$counter = 0;
				
	$mail_count = $result['meta']['results'];

	if( $mail_count != 0){

		while ($counter <  $mail_count) {
			$mail = $result['data']['emails'][$counter]['value'];
	
			$mail_string = $mail_string . $mail . ",";
			$counter = $counter + 1;
  
		}
	}


	$mail_string = rtrim($mail_string, ',');
	
}


$db_insert_service_provider = new mysqli("$host", "$username", "$password", "$db_name");

if($db_insert_service_provider->connect_errno > 0){
    die('Unable to connect to database [' . $db_insert_service_provider->connect_error . ']');
}


$sql_insert_service_provider = "INSERT INTO potential_service_providers (name,formatted_address,formatted_phone_number,place_id,website,latitude,longitude,emails,category,sub_category,pipedrive_user) VALUES ('". $name ."','". $formatted_address ."','". $formatted_phone_number ."','". $place_id ."','". $website ."','". $latitude ."','". $longitude ."','". $mail_string ."','". $category ."','". $sub_category ."','". $pipedrive_user ."')";

if(!$result_insert_service_provider = $db_insert_service_provider->query($sql_insert_service_provider)){
    die('There was an error running the query [' . $db_insert_service_provider->error . ']');
}

$db_insert_service_provider->close();


?>