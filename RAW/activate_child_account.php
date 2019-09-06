<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$db_activate_account = new mysqli("$host", "$username", "$password", "$db_name");

if($db_activate_account->connect_errno > 0){
    die('Unable to connect to database [' . $db_activate_account->connect_error . ']');
}

$sql_activate_account = "UPDATE `users` SET `status` = '1' WHERE `users`.`id` = ".$_GET['childId'].";";

if(!$result_activate_account = $db_activate_account->query($sql_activate_account)){
    die('There was an error running the query [' . $db_activate_account->error . ']');
}else{
	echo "1";
}