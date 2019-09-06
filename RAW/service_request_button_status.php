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
$buttonstatus = $_REQUEST["buttonstatus"];

$today = date("Y-m-d H:i:s"); 
$srArr=$_sqlObj->query('select * from view_serviceRequests where id='.$srid.';');

if( !($_SESSION['id']==$srArr[0]['ownerId']) ){
echo "You don't have permssion to view this service request.";exit;
}

$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


if($buttonstatus != "cancel") 
$sql_update_sr = "UPDATE serviceRequests SET buttonstatus='$buttonstatus',last_updated='$today' WHERE id='$srid'"; 
else
 $sql_update_sr = "UPDATE serviceRequests SET buttonstatus='$buttonstatus',last_updated='$today',cancel_penalty='5', status='14' WHERE id='$srid'"; 

if($buttonstatus == "cancel") 
{
$sql_update_status = "UPDATE bids SET buttonstatus='cancel' WHERE srId='$srid'";
$result_update_status = $_sqlObj->query($sql_update_status);
}


$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

  if($buttonstatus != "save") { //submit SR  or Cancel sr only push notification send
	//////After creating service request call pusher notification to other users --- Start
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
		$type="sr";

	   // get  Other user account_details		
		 $sql_get_account_details = "SELECT * FROM view_users WHERE  id  !='".$_SESSION['id']."'";
		$result_get_account_details = $_sqlObj->query($sql_get_account_details);	
			 $qry='select * from view_serviceRequests where id='.$srid;	
	 $srArr=$_sqlObj->query($qry);
		foreach ($result_get_account_details as $key => $value) {
			 $userid = $value['id'];

	 $today = date("Y-m-d H:i:s");  
	 if($buttonstatus == "submit") 
	  {
	  	$Content="New incoming request - '".$srArr[0]['title']."'";
	  	$Content1="New incoming request - ".$srArr[0]['title']."";
	  	$url="bid_interested.php?id=".$srid;
	  }
	  if($buttonstatus == "cancel") 
	  {
	  	$Content="Service request '".$srArr[0]['title']."' has been cancelled.";
	  	$Content1="Service request ".$srArr[0]['title']." has been cancelled.";
	  	$url="main.php";
	  }
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srid ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);

	  
	  

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']



}
	//////After creating service request call pusher notification to other users --- End
}
echo "success";
?>