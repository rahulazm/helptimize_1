<?php
require_once("./common.inc.php"); 
require_once("/etc/helptimize/conf.php"); 
require_once("./mysql_lib.php"); 
require_once("./resize_image.php");
session_start();

	if($_SESSION['id']){

	//print_r($_POST);
	$_POST['sr_number']=$_sqlObj->escape($_POST['sr_number']);
	$_POST['name']=$_sqlObj->escape($_POST['name']);
	$_POST['description']=$_sqlObj->escape($_POST['description']);
	$_POST['address']=$_sqlObj->escape($_POST['address']);
	$_POST['longitude']=$_sqlObj->escape($_POST['longitude']);
	$_POST['latitude']=$_sqlObj->escape($_POST['latitude']);

	 $sql_insert_service_request_address = "INSERT INTO address ( userId, datetime,srId, title, descr, address, posLong, posLat) VALUES ( '".$_SESSION['id']."', now(), ".$_POST['sr_number'].",'".$_POST['name']."', '".$_POST['description']."', '".$_POST['address']."', '".$_POST['longitude']."', '".$_POST['latitude']."')";


	$qBool=$_sqlObj->query($sql_insert_service_request_address);

	$lId=$_sqlObj->lastId();


	echo $lId;
	}


?>
