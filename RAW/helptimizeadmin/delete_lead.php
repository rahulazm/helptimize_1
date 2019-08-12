<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$lead_id = $_POST["lead_id"];


$db_delete_lead = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_lead->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_lead->connect_error . ']');
}

$sql_delete_lead = "DELETE FROM potential_service_providers where id ='" . $lead_id . "'"; 
$db_delete_lead->query($sql_delete_lead);
$db_delete_lead->close();


?>