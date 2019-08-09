<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$name = $_POST['name'];
$description = $_POST['description'];


$db_add_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_add_category->connect_errno > 0){
    die('Unable to connect to database [' . $db_add_category->connect_error . ']');
}


//echo $sql_add_category = "INSERT INTO categ ('name','desc') VALUES ('". $name ."','". $description ."')";
$sql_add_category = "INSERT INTO `categ` (`id`, `name`, `descr`, `parent_id`, `notes`, `status`) VALUES (NULL, \'$name\', \'$description\', NULL, NULL, \'0\')";
if(!$result_add_category = $db_add_category->query($sql_add_category)){
    die('There was an error running the query [' . $db_add_category->error . ']');
}

$db_add_category->close();



?>