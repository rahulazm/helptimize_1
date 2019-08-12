<?php

session_start();


$session_id = $_SESSION["session_id"];

// remove session from database

$db_update_session = new mysqli('localhost', 'helptimize', '_*_HELPTIMIZE_$_&_1', 'helptimize');

if($db_update_session->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_session->connect_error . ']');
}


$sql_update_session = "UPDATE admin_accounts SET session_id='logout',session_date='0000-00-00' WHERE session_id='$session_id'"; 
$db_update_session->query($sql_update_session);
$db_update_session->close();


header("Location:index.php");
exit();



?>