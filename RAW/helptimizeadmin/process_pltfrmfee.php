<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

// get all pltfrmfee
$db_get_pltfrmfee = new mysqli("$host", "$username", "$password", "$db_name");
if($db_get_pltfrmfee ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pltfrmfee ->connect_error . ']');
}

//print_r($_POST);
if($_POST['action_type']=='add'){
	$sql = "INSERT INTO `platform_fee` (`platformfee_id`, `platformfee_name`, `platformfee_value`, `platformfee_status`) VALUES (NULL, '$_POST[name]', '$_POST[val]', '0')";
	$result = $db_get_pltfrmfee->query($sql);
	$db_get_pltfrmfee->close();
}

if($_POST['action_type']=='update'){
	echo $sql = "UPDATE `platform_fee` SET `platformfee_name`='$_POST[platformfee_name]', `platformfee_value`='$_POST[platformfee_val]',platformfee_status='$_POST[platformfee_status]' where platformfee_ID='$_POST[platformfee_id]'";
	$result = $db_get_pltfrmfee->query($sql);
	$db_get_pltfrmfee->close();
}

