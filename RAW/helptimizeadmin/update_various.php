<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$crawl_mail = $_POST["crawl_mail"];
$delete_lead_after_import = $_POST["delete_lead_after_import"];
$initial_pipedrive_import_mail = $_POST["initial_mail"];



$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$crawl_mail' WHERE keyword='crawl_e_mail'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();




$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$delete_lead_after_import' WHERE keyword='delete_lead_after_import'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$initial_pipedrive_import_mail' WHERE keyword='initial_pipedrive_import_mail'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();







?>