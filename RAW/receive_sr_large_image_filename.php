<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$id = $_POST['id'];


$db_get_all_sr_images = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_all_sr_images ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_all_sr_images ->connect_error . ']');
}

$sql_get_all_sr_images = "SELECT * FROM pics WHERE id= '$id'";

$result_get_all_sr_images = $db_get_all_sr_images->query($sql_get_all_sr_images);

$row = $result_get_all_sr_images->fetch_assoc();

$db_get_all_sr_images->close();

$image_link = $row['url'];
$image_title = $row['title'];
$image_date_time = $row['datetime'];

echo $image_link . "|" . $image_title . "|" . $image_date_time;


?>