<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$myusername = $_POST['username'];
$mypassword = $_POST['password'];


$mypassword = encrypt_decrypt('encrypt', $mypassword);


$db_get_check_login = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_check_login ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_check_login ->connect_error . ']');
}

$sql_check_login = "SELECT id FROM admin_accounts WHERE username = '$myusername' AND password = '$mypassword' LIMIT 1";


$result_check_login = $db_get_check_login->query($sql_check_login);
$row = $result_check_login->fetch_assoc();


$db_get_check_login->close();

echo $row['id'];


?>