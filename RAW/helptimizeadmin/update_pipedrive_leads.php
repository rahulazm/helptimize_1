<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$create_pipedrive_leads = $_POST["create_pipedrive_leads"];
$import_lead_stage = $_POST["import_lead_stage"];
$import_email_exist_stage = $_POST["import_email_exist_stage"];
$import_initial_mail_sent_stage = $_POST["import_initial_mail_sent_stage"];
$create_pipedrive_leads_title = $_POST["create_pipedrive_leads_title"];

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_leads' WHERE keyword='create_pipedrive_leads'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$import_lead_stage' WHERE keyword='import_lead_stage'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$import_email_exist_stage' WHERE keyword='import_email_exist_stage'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$import_initial_mail_sent_stage' WHERE keyword='import_initial_mail_sent_stage'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_leads_title' WHERE keyword='create_pipedrive_leads_title'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();




?>