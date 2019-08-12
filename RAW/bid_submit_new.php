<?php

require_once('./common.inc.php');
require_once('./mysql_lib.php');
session_start();


error_log('========================>>>'.print_r($_POST,true));

if(!$_SESSION['id'])
{
	exit(1);
}


$is18=0;
$status='waiting for approval';
if($_SESSION['is18'])
{
	$status='submitted';
	$is18=1;
}

$_POST=$_sqlObj->escapeArr($_POST);

print_r($_POST);

/*$chkStr='select count(id) as num from bids where srId='.$_POST['service_id'].' and ownerId='.$_SESSION['id'].';';
$cnts=reset($_sqlObj->query($chkStr));
error_log(print_r($cnts, true));
	if($cnts['num']>0){
	$rtrn['status']=0;
	$rtrn['msg']='Bid already exists';
	echo json_encode($rtrn);
	exit;
	}*/


$_POST['advancePayment'] = 0;
if($_POST['cancelFee'] == "")
{
	$_POST['cancelFee'] = 0;
}
$rateperhour=0;$totalhours=0;
if($_POST['payType'] == "hourly")
{
	$rateperhour=$_POST['payAmt'];
	$rateperhours=$rateperhour;
	$totalhours=$_POST['totalhours'];
	$_POST['payAmt']=$rateperhour*$totalhours;
}

if($_POST['schedule_amount'] == '')
{
	$amount = $_POST['payAmt'];
}
else
{
	$amount = $_POST['schedule_amount'];	
}

$payType = $_sqlObj->query('select id from paytype where name="'.$_POST['payType'].'"');

$status =  $_sqlObj->query('select id from status where status="submitted"');
	

    $str='insert into bids(srId, ownerId, create_datetime, title, descr, payType, payAmt, rateperhour, totalhours, advancePayment, dateTimeTo, dateTimeFrom, categId, cancelFee, is18, ageApproved, status, last_updated, reviewedByRequest,set_schedule,schedule_note,schedule_amount) values('.$_POST['service_id'].', '.$_SESSION['id'].', now(), "'.$_POST['title'].'", "'.$_POST['descr'].'", '.$payType[0]['id'].', "'.$_POST['payAmt'].'", "'.$rateperhour.'", "'.$totalhours.'", "'.$_POST['advancePayment'].'", "'.$_POST['dateTimeTo'].'", "'.$_POST['dateTimeFrom'].'", '.$_POST['category'].', "'.$_POST['cancelFee'].'", '.$is18.', 0, '.$status[0]['id'].', now(), 0, "'.$_POST['set_schedule'].'", "'.$_POST['schedule_note'].'", "'.$amount.'");';
	if($_sqlObj->query($str)){
	$id=$_sqlObj->lastId();
	
		################Insert Revised table for bid
	$Rev_str='insert into bids_revision(bidid,refno,srId, ownerId, create_datetime, title, descr, payType, payAmt, rateperhour, totalhours, advancePayment, dateTimeTo, dateTimeFrom, categId, cancelFee, is18, ageApproved, status, last_updated, reviewedByRequest,set_schedule,schedule_note,schedule_amount) values('.$id.',"1",'.$_POST['service_id'].', '.$_SESSION['id'].', now(), "'.$_POST['title'].'", "'.$_POST['descr'].'", '.$payType[0]['id'].', "'.$_POST['payAmt'].'", "'.$rateperhour.'", "'.$totalhours.'", "'.$_POST['advancePayment'].'", "'.$_POST['dateTimeTo'].'", "'.$_POST['dateTimeFrom'].'",'.$_POST['category'].', "'.$_POST['cancelFee'].'", '.$is18.', 0, '.$status[0]['id'].', now(), 0, "'.$_POST['set_schedule'].'", "'.$_POST['schedule_note'].'", "'.$amount.'");';
	$Qry=$_sqlObj->query($Rev_str);
	$refid=$_sqlObj->lastId();

	$rtrn="";
		if(count($_POST['pics'])>0){
		$str='update pics set bidId='.$id.' where srId='.$_POST['service_id'].' and userId='.$_SESSION['id'].';';
			################Insert Revised table for Pics
			if(!$_sqlObj->query($str)){
			$rtrn['error'][]=$_sqlObj->error();
			}
			 $Rev_picstr='INSERT INTO pics_revision (datetime, userId, srId, orderNum, url, title, safeRate, notes,bidId)
				SELECT datetime, userId, srId, orderNum, url, title, safeRate, notes,bidId FROM pics
				WHERE srId='.$_POST['service_id'].' and userId='.$_SESSION['id'].' and bidId='.$id;
			$Qry=$_sqlObj->query($Rev_picstr);
			$Upd_str='update pics_revision set refno="1",refid='.$refid.' where srId='.$_POST['service_id'].' and userId='.$_SESSION['id'].' and bidId='.$id.';';
			$Qry=$_sqlObj->query($Upd_str);
		}

		###########Update address with current bidid - April 10
		 $_sqlObj->query('update address set bidId='.$id.' where srId="'.$_POST['service_id'].'" and userId="'.$_SESSION['id'].'";');
		 ################Insert Revised table for Address -- Start			
			 $Rev_picstr='INSERT INTO address_revision ( userId, datetime, title, descr, address, posLong, posLat,srId,bidId)
				SELECT  userId, datetime, title, descr, address, posLong, posLat,srId,bidId FROM address
				WHERE srId='.$_POST['service_id'].' and userId='.$_SESSION['id'].' and bidId='.$id;
			$Qry=$_sqlObj->query($Rev_picstr);
			$Upd_str='update address_revision set refno="1",refid='.$refid.' where srId='.$_POST['service_id'].' and userId='.$_SESSION['id'].' and bidId='.$id.';';
			$Qry=$_sqlObj->query($Upd_str);
		################Insert Revised table for Address -- End

		if(count($_POST['milestones'])>0){
		$ms=$_sqlObj->escapeArr($_POST['milestones']);
		
		$row=reset($ms);
			while($row){
				$rateperhour=0;$totalhours=0;
				if($_POST['payType'] == "hourly")
					{					
					$rateperhour=$rateperhours;
					$totalhours=$row["amount"];
					$row["amount"]=$rateperhour*$totalhours;
					}
			$msstr='insert into milestones( datetime, bidId, due_datetime, name, descr, amountType, amount, notes, rateperhour, totalhours) values( now(), '.$id.', "'.$row["due_datetime"].'", "'.$row["name"].'", "'.$row["descr"].'", "percent", "'.$row["amount"].'", "", "'.$rateperhour.'", "'.$totalhours.'");';
				if(!$_sqlObj->query($msstr)){
				$rtrn['error'][]=$_sqlObj->error();
				}
		################Insert Revised table for Milestone
			 $Rev_msstr='insert into milestones_revision(refid,refno, datetime, bidId, due_datetime, name, descr, amountType, amount, notes, rateperhour, totalhours) values('.$refid.',"1", now(), '.$id.', "'.$row["due_datetime"].'", "'.$row["name"].'", "'.$row["descr"].'", "percent", "'.$row["amount"].'", "", "'.$rateperhour.'", "'.$totalhours.'");';
			$Qry=$_sqlObj->query($Rev_msstr);
			$row=next($ms);
			}
		}
	
		//$rtrn['status']=0;
		//$rtrn['msg']='bid creation incomplete.';
		/*if(!array_key_exists('error', $rtrn)){
		$rtrn['status']=1;
		$rtrn['msg']='bid successfully created';
		//////After creating Bid call pusher notification to corresponding user --- Start
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
		$type="newbid";
	   // get corresponding user account_details
	   $qry='select * from view_serviceRequests where id='.$_POST['service_id'];	
	   $srArr=$_sqlObj->query($qry);
	  	
	 $userid = $srArr[0]['ownerId'];
	 $url="view_bid.php?id=".$id;
	 $Content="New incoming bid for - '".$srArr[0]['title']."'";
	 $Content1="New incoming bid for - ".$srArr[0]['title']."";
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $_POST['service_id'] ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	 $result_insert_message = $_sqlObj->query($sql_insert_message);
	 
	
	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$srArr[0]['ownerExternId']
	//////After creating service request call pusher notification to other users --- End
		}*/
	$_SESSION['new_bid']=array();
	echo json_encode($rtrn);
	
	exit;	
	}

$rtrn['status']=0;
$rtrn['msg']='inserting bid failed.'.$_sqlObj->error();
echo json_encode($rtrn);
exit;
?>
