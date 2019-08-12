<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$id = $_POST['additional_id'];


$db_get_sub_category_info = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sub_category_info ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sub_category_info ->connect_error . ']');
}

$sql_get_sub_category_info  = "SELECT * FROM category_details WHERE id='$id'";

$result_get_sub_category_info = $db_get_sub_category_info->query($sql_get_sub_category_info);
$row = $result_get_sub_category_info->fetch_assoc();

$db_get_sub_category_info->close();


$text = $row['text'];
$field_type = $row['field_type'];
$field_range = $row['field_range'];
$mandatory = $row['mandatory'];

echo $text . "|" . $field_type . "|" . $field_range . "|" . $mandatory;



?>