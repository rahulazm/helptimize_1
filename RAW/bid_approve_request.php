<?php

$configs = include("/etc/helptimize/conf.php");
require_once('./common.inc.php');
require_once('./mysql_lib.php');
session_start();


error_log('========================>>>'.print_r($_POST,true));

if(!$_SESSION['id']){
exit(1);
}

$refid = $_REQUEST['refid'];
$bidid = $_REQUEST['bidid'];
$bidArr_owner=reset($_sqlObj->query('select * from view_bids where id='.$bidid.';'));
$srId=$bidArr_owner['srId'];
$today = date("Y-m-d H:i:s"); 
$id=$bidid;
	
		if($_SESSION['id']==$bidArr_owner['srOwnerId']) 
			$statususer="buyer";
		else $statususer="seller";
		
$bidInfo=reset($_sqlObj->query('select * from bids_revision where bidid='.$id.' and id = '.$refid));		 
			###############Update bids table
			$str='update bids set   descr="'.$bidInfo['descr'].'", payType = "'.$bidInfo['payType'].'", payAmt ="'.$bidInfo['payAmt'].'", dateTimeTo="'.$bidInfo['dateTimeTo'].'", dateTimeFrom ="'.$bidInfo['dateTimeFrom'].'", last_updated = now() where id='.$bidid;
			$_sqlObj->query($str);
			#########Delete all datas from address,pics,milestone table
			$sql_delete_picture = "DELETE FROM pics where srId='".$srId."' and bidId='".$id."'";
			$Qry=$_sqlObj->query($sql_delete_picture); 
			$sql_delete_picture = "DELETE FROM address where srId='".$srId."' and bidId='".$id."'";
			$Qry=$_sqlObj->query($sql_delete_picture); 
			$sql_delete_picture = "DELETE FROM milestones where bidId='".$id."'";
			$Qry=$_sqlObj->query($sql_delete_picture);  
			################Insert Original  table for pics -- Start		
			$Rev_picstr='INSERT INTO pics (datetime, userId, srId, orderNum, url, title, safeRate, notes,bidId)
				SELECT datetime, userId, srId, orderNum, url, title, safeRate, notes,bidId FROM pics_revision
				WHERE refid='.$refid.' and srId='.$srId.' and bidId='.$id;
			$Qry=$_sqlObj->query($Rev_picstr);	
	 		################Insert Original  table for Address -- Start			
			 $Rev_picstr='INSERT INTO address ( userId, datetime, title, descr, address, posLong, posLat,srId,bidId)
				SELECT  userId, datetime, title, descr, address, posLong, posLat,srId,bidId FROM address_revision
				WHERE refid='.$refid.' and srId='.$srId.' and bidId='.$id;
			$Qry=$_sqlObj->query($Rev_picstr);
			################Insert Original  table for milestons -- Start		
			$Rev_picstr='INSERT INTO milestones (datetime, bidId, due_datetime, name, descr, amountType, amount, notes, rateperhour, totalhours)
				SELECT datetime, bidId, due_datetime, name, descr, amountType, amount, notes, rateperhour, totalhours FROM milestones_revision
				WHERE refid='.$refid.' and bidId='.$id;
			$Qry=$_sqlObj->query($Rev_picstr);				
		
			$sql_update_sr = "UPDATE bids SET statususer='$statususer',bidstatus='approved',last_updated='$today' WHERE id='$id'";
			$Qry=$_sqlObj->query($sql_update_sr);
			//////After editing Bid call pusher notification to SR/Bid User --- Start
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
		

	   
			if($statususer == "seller")
			{
			 $userid = $bidArr_owner['srOwnerId'];
			 $type="approvebid";
			 $url='view_service_details.php?id='.$srId;	 
			}
			else
			{
			$userid = $bidArr_owner['ownerId'];
			$type="approvebidbuyer";
			if($bidArr_owner['status'] == "submitted" || $bidArr_owner['status'] == "waiting for approval" || $bidArr_owner['status'] == "awarded")
			$url='view_service_details.php?id='.$srId;	
			else	 
			$url='view_service_details.php?id='.$srId;	 
			}
	$Content="Changes on Agreement '".$bidArr_owner['title']."' has been approved.";
	$Content1="Changes on Agreement ".$bidArr_owner['title']." has been approved.";	
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srId ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);	  
	
	 
	   	
	  	//$url="main.php";	 

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']

	//////After editing Bid call pusher notification to SR/Bid user --- End
		
	
		
	echo "success";
?>
