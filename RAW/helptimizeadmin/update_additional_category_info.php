<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$id = $_POST['id'];
$text = $_POST['text'];
$field_type = $_POST['field_type'];
$field_range = $_POST['field_range'];
$mandatory = $_POST['mandatory'];


$db_update_sub_category_info = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sub_category_info->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sub_category_info->connect_error . ']');
}

$sql_update_sub_category_info = "UPDATE category_details SET text='$text',field_type='$field_type',field_range='$field_range',mandatory='$mandatory' WHERE id='$id'"; 

$db_update_sub_category_info->query($sql_update_sub_category_info);
$db_update_sub_category_info->close();


echo "done";



?>