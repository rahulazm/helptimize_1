<?php
error_reporting(E_ALL);
$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$category_id = $_POST['category_id'];
print_r($configs);

$db_delete_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_category->connect_error . ']');
}

echo $sql_delete_catgeory = "UPDATE categ SET status='1' where id ='" . $category_id . "'"; 
echo $db_delete_category->query($sql_delete_catgeory);
$db_delete_category->close();
exit();

/**
$db_delete_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_category->connect_error . ']');
}

$sql_delete_catgeory = "DELETE FROM category_subcategory where category_id ='" . $category_id . "'"; 
$db_delete_category->query($sql_delete_catgeory);
$db_delete_category->close();


$db_delete_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_delete_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_delete_category->connect_error . ']');
}

$sql_delete_catgeory = "DELETE FROM category_details where main_category ='" . $category_id . "'"; 
$db_delete_category->query($sql_delete_catgeory);
$db_delete_category->close();
**/


?>