<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$place_id = $_POST["place_id"];

$db_get_place = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_place ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_place ->connect_error . ']');
}

$sql_get_place = "SELECT * FROM potential_service_providers WHERE place_id='$place_id'";

$result_get_place = $db_get_place->query($sql_get_place);
$row_cnt = $result_get_place->num_rows;

$db_get_place->close();

echo $row_cnt;


?>