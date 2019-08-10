<?php

$configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


session_start();
$bidder_id = $_REQUEST["bidid"];
$today = date("Y-m-d H:i:s"); 


// udpate status for bidder and client

$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


$sql_update_sr = "UPDATE bids SET shortlist='yes',last_updated='$today' WHERE id='$bidder_id'"; 

$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


$sql_update_sr = "UPDATE serviceRequests SET status='$status',last_updated='$today' WHERE bidAwardId='$bidder_id'"; 

$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

//////After creating Bid call pusher notification to corresponding user --- Start
	/*require __DIR__ . '/vendor/autoload.php';
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
		$type="shortlist";
	   // get corresponding user account_details

	 $qry='select * from view_bids where id='.$bidder_id;	
	 $bidArr=$_sqlObj->query($qry);	
	 $userid = $bidArr[0]['ownerId'];	  	
	 $srId = $bidArr[0]['srId'];
	 $qry='select * from view_serviceRequests where id='.$srId;	
	 $srArr=$_sqlObj->query($qry);
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id) VALUES ('". $bidder_id ."','". $srId ."','". $type ."','". $srArr[0]['title'] ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."')";
	  $result_insert_message = $_sqlObj->query($sql_insert_message);
	  $Content="Add to Shortlist Alert : ".$srArr[0]['title'];
	  $data['message'] = $Content . "|" . $type;
	  $pusher->trigger('pop_up_message',$userid, $data);*///bidArr[0]['ownerExternId']
	//////After creating service request call pusher notification to other users --- End

echo "success";

?>