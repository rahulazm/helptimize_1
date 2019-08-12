<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$character_strip = $_POST["character_strip"];
$characters_add_in_front_phone_number = $_POST["characters_add_in_front_phone_number"];


$db_update_character_strip = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_character_strip->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_character_strip->connect_error . ']');
}

$sql_update_character_strip = "UPDATE admin_settings SET value='$character_strip' WHERE keyword='characters_remove_phone_number'"; 

$db_update_character_strip->query($sql_update_character_strip);
$db_update_character_strip->close();



$db_update_character_strip = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_character_strip->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_character_strip->connect_error . ']');
}

$sql_update_character_strip = "UPDATE admin_settings SET value='$characters_add_in_front_phone_number' WHERE keyword='characters_add_in_front_phone_number'"; 

$db_update_character_strip->query($sql_update_character_strip);
$db_update_character_strip->close();


echo "done";


?>