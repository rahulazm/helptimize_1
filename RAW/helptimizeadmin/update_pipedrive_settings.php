<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$pipedrive_api_token = $_POST["pipedrive_api_token"];
$pipedrive_url = $_POST["pipedrive_url"];
$pipe_drive_company_phone_number_hash = $_POST["pipe_drive_company_phone_number_hash"];
$pipe_drive_company_mail_pool_hash = $_POST["pipe_drive_company_mail_pool_hash"];
$pipe_drive_category_hash = $_POST["pipe_drive_category_hash"];
$pipe_drive_sub_category_hash = $_POST["pipe_drive_sub_category_hash"];
$pipe_drive_website_hash = $_POST["pipe_drive_website_hash"];


$pipe_drive_category = $_POST["pipe_drive_category"];
$pipe_drive_sub_category = $_POST["pipe_drive_sub_category"];


$db_update_api_token = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_api_token->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_api_token->connect_error . ']');
}

$sql_update_api_token = "UPDATE admin_settings SET value='$pipedrive_api_token' WHERE keyword='pipedrive_api_token'"; 

$db_update_api_token->query($sql_update_api_token);
$db_update_api_token->close();



$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipedrive_url' WHERE keyword='pipedrive_url'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();



$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_company_phone_number_hash' WHERE keyword='pipe_drive_company_phone_number_hash'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_company_mail_pool_hash' WHERE keyword='pipe_drive_company_mail_pool_hash'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_category_hash' WHERE keyword='pipe_drive_category_hash'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_sub_category_hash' WHERE keyword='pipe_drive_sub_category_hash'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();

$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_category' WHERE keyword='pipe_drive_category'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_sub_category' WHERE keyword='pipe_drive_sub_category'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


$db_update_url = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_url->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_url->connect_error . ']');
}

$sql_update_url = "UPDATE admin_settings SET value='$pipe_drive_website_hash' WHERE keyword='pipe_drive_website_hash'"; 

$db_update_url->query($sql_update_url);
$db_update_url->close();


echo "done";


?>