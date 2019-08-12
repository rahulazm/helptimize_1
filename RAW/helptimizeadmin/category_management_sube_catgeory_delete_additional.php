<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$additional_id = $_POST['additional_id'];

$db_delete_additional_info = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_additional_info->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_additional_info->connect_error . ']');
}

$sql_delete_additional_info = "DELETE FROM category_details where id ='" . $additional_id . "'"; 
$db_delete_additional_info->query($sql_delete_additional_info);
$db_delete_additional_info->close();

?>