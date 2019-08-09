<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$name = $_POST['name'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];


$db_add_sub_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_add_sub_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_add_sub_category->connect_error . ']');
}


$sql_add_sub_category = "INSERT INTO category_subcategory (name,description,category_id) VALUES ('". $name ."','". $description ."','". $category_id ."')";

if(!$result_add_sub_category = $db_add_sub_category->query($sql_add_sub_category)){
    die('There was an error running the query [' . $db_add_sub_category->error . ']');
}

$db_add_sub_category->close();


$db_update_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_category->connect_error . ']');
}

$sql_update_category = "UPDATE main_categories SET sub_category='1' WHERE id='$category_id'"; 

$db_update_category->query($sql_update_category);
$db_update_category->close();


?>