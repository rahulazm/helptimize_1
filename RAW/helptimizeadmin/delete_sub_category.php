<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$id = $_POST['sub_category_id'];

$db_delete_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_category->connect_error . ']');
}

$sql_delete_catgeory = "DELETE FROM category_subcategory where id ='" . $id . "'"; 
$db_delete_category->query($sql_delete_catgeory);
$db_delete_category->close();


$db_delete_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_category->connect_error . ']');
}

$sql_delete_catgeory = "DELETE FROM category_details WHERE category_id ='" . $id . "'"; 
$db_delete_category->query($sql_delete_catgeory);
$db_delete_category->close();



?>