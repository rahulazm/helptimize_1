<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$category_string = $_POST["category_string"];

$category_string_array = explode("-", $category_string);


foreach ($category_string_array as &$value) {
    
    $category_details_array = explode("|", $value);
    
    $helptimize_category = $category_details_array[0];
    $pipedrive_category = $category_details_array[1];
    
    
    $db_update_category = new mysqli("$host", "$username", "$password", "$db_name");

	if($db_update_category->connect_errno > 0){
    	die('Unable to connect to database [' . $db_update_category->connect_error . ']');
	}

	$sql_update_category = "UPDATE category_subcategory SET pipe_drive_category='$pipedrive_category' WHERE id='$helptimize_category'"; 

	$db_update_category->query($sql_update_category);
	$db_update_category->close();
    
}



echo $sql_update_category;



?>