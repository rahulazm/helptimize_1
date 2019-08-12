<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$create_pipedrive_activity_if_no_mail = $_POST["create_pipedrive_activity_if_no_mail"];
$create_pipedrive_activity_if_no_mail_text = $_POST["create_pipedrive_activity_if_no_mail_text"];
$create_pipedrive_activity_if_no_mail_subject = $_POST["create_pipedrive_activity_if_no_mail_subject"];
$create_pipedrive_activity_if_no_mail_activity = $_POST["create_pipedrive_activity_if_no_mail_activity"];
$no_mail_due = $_POST["no_mail_due"];


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_no_mail' WHERE keyword='create_pipedrive_activity_if_no_mail'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_no_mail_text' WHERE keyword='create_pipedrive_activity_if_no_mail_text'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_no_mail_subject' WHERE keyword='create_pipedrive_activity_if_no_mail_subject'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_no_mail_activity' WHERE keyword='create_pipedrive_activity_if_no_mail_activity'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$no_mail_due' WHERE keyword='no_mail_due'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();



?>