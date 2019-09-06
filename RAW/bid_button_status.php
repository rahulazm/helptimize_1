<?php

$configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];
session_start();

$srid = $_REQUEST['srid'];
$bidid = $_REQUEST['bidid'];
$penalty = $_REQUEST['penalty'];
$buttonstatus = $_REQUEST["buttonstatus"];
$statususer = $_REQUEST["statususer"];


$today = date("Y-m-d H:i:s"); 
$srArr=$_sqlObj->query('select * from view_bids where id='.$bidid.';');


if( $_SESSION['id']!=$srArr[0]['ownerId'] && $_SESSION['id']!=$srArr[0]['srOwnerId']){
echo "You don't have permssion to view this bid.";
exit;
}

$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


if($penalty != "yes") 
$sql_update_sr = "UPDATE bids SET statususer='$statususer',bidstatus='$buttonstatus',last_updated='$today', status = '14' WHERE id='$bidid'"; 
else
 $sql_update_sr = "UPDATE bids SET statususer='$statususer',bidstatus='$buttonstatus',last_updated='$today',cancel_penalty='5', status = '14' WHERE id='$bidid'"; 

 $sql_update_status = "UPDATE serviceRequests SET bidAwardId = NULL,status = '7',last_updated='$today' WHERE id='$srid'";
$result_update_status = $_sqlObj->query($sql_update_status);



$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

  
	//////After cancelling Bid call pusher notification to SR User --- Start
	require __DIR__ . '/vendor/autoload.php';
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
		$type="bidcancel";

	   
			if($statususer == "seller")
			 $userid = $srArr[0]['srOwnerId'];
			else
				$userid = $srArr[0]['ownerId'];

			 if($buttonstatus == "cancel") 
	  {
	  	$Content="Bid '".$srArr[0]['sr_title']."' has been cancelled.";
	  	if($_SESSION['id']==$bidArr['ownerId']) 
	  	$Content="Bid '".$srArr[0]['sr_title']."' has been withdrawn.";
	  	$Content1="Bid ".$srArr[0]['sr_title']." has been withdrawn.";	
	  	$url="main.php";
	  }
	  

	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srid ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);

	  
	
	 

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']

	//////After cancelling Bid call pusher notification to other users --- End

echo "success";
?>