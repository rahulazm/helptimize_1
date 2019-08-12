<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$create_pipedrive_activity_if_initial_marketing_mail_sent = $_POST["create_pipedrive_activity_if_initial_marketing_mail_sent"];
$create_pipedrive_activity_if_initial_marketing_mail_sent_text = $_POST["create_pipedrive_activity_if_initial_marketing_mail_sent_text"];
$create_pipedrive_activity_if_initial_marketing_mail_subject = $_POST["create_pipedrive_activity_if_initial_marketing_mail_subject"];
$create_pipedrive_activity_if_initial_marketing_mail_activity = $_POST["create_pipedrive_activity_if_initial_marketing_mail_activity"];

$create_pipedrive_marketing_mail_follow_up = $_POST["create_pipedrive_marketing_mail_follow_up"];
$create_pipedrive_marketing_mail_follow_up_activity = $_POST["create_pipedrive_marketing_mail_follow_up_activity"];
$create_pipedrive_marketing_mail_follow_up_activity_subject = $_POST["create_pipedrive_marketing_mail_follow_up_activity_subject"];
$create_pipedrive_marketing_mail_follow_up_activity_text = $_POST["create_pipedrive_marketing_mail_follow_up_activity_text"];
$create_pipedrive_marketing_mail_follow_up_activity_due = $_POST["create_pipedrive_marketing_mail_follow_up_activity_due"];


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_initial_marketing_mail_sent' WHERE keyword='create_pipedrive_activity_if_initial_marketing_mail_sent'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_initial_marketing_mail_sent_text' WHERE keyword='create_pipedrive_activity_if_initial_marketing_mail_sent_text'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_initial_marketing_mail_subject' WHERE keyword='create_pipedrive_activity_if_initial_marketing_mail_subject'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_activity_if_initial_marketing_mail_activity' WHERE keyword='create_pipedrive_activity_if_initial_marketing_mail_activity'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();

$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_marketing_mail_follow_up' WHERE keyword='create_pipedrive_marketing_mail_follow_up'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_marketing_mail_follow_up_activity' WHERE keyword='create_pipedrive_marketing_mail_follow_up_activity'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_marketing_mail_follow_up_activity_subject' WHERE keyword='create_pipedrive_marketing_mail_follow_up_activity_subject'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_marketing_mail_follow_up_activity_text' WHERE keyword='create_pipedrive_marketing_mail_follow_up_activity_text'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();


$db_update_crawl_mail = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_crawl_mail->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_crawl_mail->connect_error . ']');
}

$sql_update_crawl_mail = "UPDATE admin_settings SET value='$create_pipedrive_marketing_mail_follow_up_activity_due' WHERE keyword='create_pipedrive_marketing_mail_follow_up_activity_due'"; 

$db_update_crawl_mail->query($sql_update_crawl_mail);
$db_update_crawl_mail->close();



?>