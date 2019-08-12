<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$session_id = $_POST['session_id'];
$id = $_POST['id'];

$today = date("Y-m-d H:i:s");    



$db_update_session = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_session->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_session->connect_error . ']');
}


$sql_update_session = "UPDATE admin_accounts SET session_id='$session_id',session_date='$today' WHERE id='$id'"; 
$db_update_session->query($sql_update_session);
$db_update_session->close();



?>