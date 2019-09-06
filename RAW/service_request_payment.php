<?php

$configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];
session_start();
$amounttype = $_REQUEST["amount_type"];
$bidder_id = $_REQUEST["bidid"];
$amount = $_REQUEST["amount"];
$userid = $_SESSION['id'];
$mid = $_REQUEST["mid"];
if($amount=="")
$amount=0.00;
$count=1;

$today = date("Y-m-d H:i:s"); 

$db_insert_payment = new mysqli("$host", "$username", "$password", "$db_name");

if($db_insert_payment->connect_errno > 0){
    die('Unable to connect to database [' . $db_insert_payment->connect_error . ']');
}

if($mid==0) ///Check if milestone payment or not
{
	 $sql_insert_payment = "INSERT INTO bidPayments (datetime,payAmt,bidId,amounttype,status,userid,usertype) VALUES ('". $today ."','". $amount ."','". $bidder_id ."','". $amounttype ."','18','". $userid ."','seller')";
	 $Qry=$_sqlObj->query($sql_insert_payment); 
	}
else
{
		####Check if one or more milestone payment
	if (strpos($mid, ',') !== false) {
   		$myArray = explode(',', $mid);
   		$count=count($myArray);
   		foreach($myArray as $key)
	{
		$milestones=$_sqlObj->query('select * from milestones where id='.$key.';');
		 $sql_insert_payment = "INSERT INTO bidPayments (datetime,payAmt,bidId,amounttype,status,userid,usertype,milestoneId) VALUES ('". $today ."','". $milestones[0]['amount'] ."','". $bidder_id ."','". $amounttype ."','18','". $userid ."','seller','". $key ."')";
		$Qry=$_sqlObj->query($sql_insert_payment); 
	}
	}
	else
	{
		$key=$mid;
		$milestones=$_sqlObj->query('select * from milestones where id='.$key.';');
	 $sql_insert_payment = "INSERT INTO bidPayments (datetime,payAmt,bidId,amounttype,status,userid,usertype,milestoneId) VALUES ('". $today ."','". $milestones[0]['amount'] ."','". $bidder_id ."','". $amounttype ."','18','". $userid ."','seller','". $mid ."')";
	$Qry=$_sqlObj->query($sql_insert_payment); 
	}
}



echo "success";

// udpate status for bidder and client


$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


$sql_update_sr = "UPDATE bids SET status='18',last_updated='$today' WHERE id='$bidder_id'"; 

$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

$db_update_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_update_sr->connect_errno > 0){
    die('Unable to connect to database [' . $db_update_sr->connect_error . ']');
}


$sql_update_sr = "UPDATE serviceRequests SET status='18',last_updated='$today' WHERE bidAwardId='$bidder_id'"; //,last_updated='$today'

$db_update_sr->query($sql_update_sr);
$db_update_sr->close();

  //////After Payment request call pusher notification to corresponding user --- Start
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
	 $type="paymentrequest";

	 if($amounttype =="1") $atype="Full"; else $atype="Partial";
	 // get corresponding user account_details
	 $qry='select * from view_bids where id='.$bidder_id;	
	 $bidArr=$_sqlObj->query($qry);	
	 $userid = $bidArr[0]['srOwnerId'];	  	
	 $srId = $bidArr[0]['srId'];
	 $qry='select * from view_serviceRequests where id='.$srId;	
	 $srArr=$_sqlObj->query($qry);
	 $today = date("Y-m-d H:i:s");  

	 $url="view_service_details.php?id=".$srId;
	  if($mid==0) 
	  {
	  $Content=$atype." Payment is requested for '".$srArr[0]['title']."'";
	  $Content1=$atype." Payment is requested for ".$srArr[0]['title']."";
	}
	  else
	  {
	  	$milestones=$_sqlObj->query('select * from milestones where id='.$key.';');
	  	 $Content=" Payment requested for milestone '".$count."' of '".$srArr[0]['title']."'";
	  	 $Content1=" Payment requested for milestone ".$count." of ".$srArr[0]['title']."";
	  }
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $bidder_id ."','". $srId ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	  $result_insert_message = $_sqlObj->query($sql_insert_message);
	  
	 

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//bidArr[0]['ownerExternId']
	//////After Payment request request call pusher notification to other users --- End

?>