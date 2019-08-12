<?php
//error_reporting(E_ALL);

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$id = $_POST['category_id'];
$name = $_POST['category_name'];
$description = $_POST['category_decription'];
$status=$_POST['category_status'];

$db_update_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_category->connect_error . ']');
}

$sql_update_category = "UPDATE categ SET name='$name',descr='$description',status='$status' WHERE id='$id'"; 
$db_update_category->query($sql_update_category);
$db_update_category->close();

exit;

?>