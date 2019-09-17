<?php
session_start();
$_configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");
require_once __DIR__ . '/vendor/autoload.php';
	
	$options = array(
	    'cluster' => $_configs["push_cluster"],
	    'useTLS' => true
	  );

	$pusher = new Pusher\Pusher(
	    $_configs["push_app_key"],
	    $_configs["push_app_secret"],
	    $_configs["push_app_id"],
	    $options
	  );
	
	$type="invoice";
    $userid = $_POST['userId'];
	$Content="New incoming invoice";
	$Content1="New incoming invoice -  ".$_POST['inv']."";
	$url=$_configs['site_url'].$_POST['inv'];
	$srid=$_POST['srid'];
	$userid = $_POST['userid'];
	$id= $_POST['srid'];
	$today = date("Y-m-d H:i:s");  

	$sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srid ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);
	$data['message'] = $Content . "|" . $type. "|" . $url;
	$pusher->trigger('pop_up_message',$userid, $data);//$value['externId']


?>
	