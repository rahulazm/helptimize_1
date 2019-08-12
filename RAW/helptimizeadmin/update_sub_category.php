<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$category_id = $_POST['category_id'];
$description = $_POST['description'];
$name = $_POST['name'];


$db_update_sub_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sub_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sub_category->connect_error . ']');
}

$sql_update_sub_category = "UPDATE category_subcategory SET name='$name',description='$description' WHERE id='$category_id'"; 

$db_update_sub_category->query($sql_update_sub_category);
$db_update_sub_category->close();


echo $category_id;


?>