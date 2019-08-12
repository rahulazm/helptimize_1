<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$category_id = $_POST['category_id'];
$text = $_POST['text'];
$field_type = $_POST['field_type'];
$field_range = $_POST['field_range'];
$mandatory = $_POST['mandatory'];
$main_category = $_POST['main_category'];


$db_insert_additional_category_info = new mysqli("$host", "$username", "$password", "$db_name");

if($db_insert_additional_category_info->connect_errno > 0){
    die('Unable to connect to database [' . $db_insert_additional_category_info->connect_error . ']');
}


$sql_insert_additional_category_info = "INSERT INTO category_details (category_id,text,field_type,field_range,mandatory,main_category) VALUES ('". $category_id ."','". $text ."','". $field_type ."','". $field_range ."','". $mandatory ."','". $main_category ."')";

if(!$result_insert_additional_category_info = $db_insert_additional_category_info->query($sql_insert_additional_category_info)){
    die('There was an error running the query [' . $db_insert_additional_category_info->error . ']');
}

$db_insert_additional_category_info->close();


?>