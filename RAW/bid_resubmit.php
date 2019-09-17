<?php

require_once('./common.inc.php');
require_once('./mysql_lib.php');
session_start();


error_log('========================>>>'.print_r($_POST,true));

if(!$_SESSION['id']){
exit(1);
}

$bidArr_owner=reset($_sqlObj->query('select * from view_bids where id='.$_POST['id'].';'));



$_POST=$_sqlObj->escapeArr($_POST);

$chkStr='select count(id) as num from view_bids where srId='.$_POST['srId'].' and ownerId='.$_SESSION['id'].';';
$cnts=reset($_sqlObj->query($chkStr));

##########Check Total bid in Review bid table
$qstr=($_sqlObj->query('
select count(id) as totbid from bids_revision where bidid='.$_POST['id']));
$total_count= $qstr[0]["totbid"]+1;

$bidArr=reset($_sqlObj->query('select * from bids where id='.$_POST['id'].';'));
$srId=$bidArr['srId'];	

/*if(!array_key_exists($_POST['payType']) || !$_POST['payType']){
$_POST['payType']='hourly';
}*/

$_POST['advancePayment'] = 0;
if($_POST['cancelFee'] == ""){
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
$dateTimeFrom=$_POST['date_from_value'].' '.$_POST['time_from_value'];
$dateTimeTo=$_POST['date_to_value'].' '.$_POST['time_to_value'];

 ################Insert Revised table for bid
	    $Rev_str='insert into bids_revision(bidid,refno,srId, ownerId, create_datetime, title, descr, payType, payAmt, rateperhour, totalhours, advancePayment, dateTimeFrom, dateTimeTo, categId, cancelFee, is18, ageApproved, status, last_updated, reviewedByRequest,set_schedule,schedule_note,schedule_amount) values('.$_POST['id'].',"'.$total_count.'",'.$_POST['srId'].', '.$_SESSION['id'].', now(), "'.$bidArr['title'].'", "'.$_POST['service_description'].'", (select id from paytype where name="'.$_POST['payType'].'"), "'.$_POST['payAmt'].'", "'.$rateperhour.'", "'.$totalhours.'", "'.$_POST['advancePayment'].'", "'.$dateTimeFrom.'", "'.$dateTimeTo.'", "'.$bidArr['categId'].'", "'.$bidArr['cancelFee'].'", '.$bidArr['is18'].', 0, "'.$bidArr['status'].'", now(), 0, "'.$_POST['set_schedule'].'", "'.$_POST['schedule_note'].'", "'.$_POST['schedule_amount'].'");';
	//$Qry=$_sqlObj->query($Rev_str);
	//$refid=$_sqlObj->lastId();
	if($_sqlObj->query($Rev_str)){
	$refid=$_sqlObj->lastId();
	$id=$_POST['id'];
	//$srId=$_POST['srId'];
	$rtrn="";
	$today = date("Y-m-d H:i:s"); 
		$Upd_str='update pics_revision set refid='.$refid.' where srId='.$_POST['srId'].' and userId='.$_SESSION['id'].' and refno='.$total_count.' and bidId='.$id.';';
		$Qry=$_sqlObj->query($Upd_str);

		$Upd_str='update address_revision set refid='.$refid.' where srId='.$_POST['srId'].' and userId='.$_SESSION['id'].' and refno='.$total_count.' and bidId='.$id.';';
		$Qry=$_sqlObj->query($Upd_str);
		if($_SESSION['id']==$bidArr_owner['srOwnerId']) 
			$statususer="buyer";
		else $statususer="seller";
		
		 
		unset($_SESSION['review_add']);
		if(count($_POST['milestones'])>0){
		$ms=$_sqlObj->escapeArr($_POST['milestones']);
		
		$row=reset($ms);
			while($row){
				if($_POST['payType'] == "hourly")
					{					
					$rateperhour=$rateperhours;
					$totalhours=$row["amount"];
					$row["amount"]=$rateperhour*$totalhours;
					}
			 $msstr='insert into milestones_revision(refid,refno, datetime, bidId, due_datetime, name, descr, amountType, amount, notes, rateperhour, totalhours) values('.$refid.',"'.$total_count.'", now(), '.$id.', "'.$row["due_datetime"].'", "'.$row["name"].'", "'.$row["descr"].'", "percent", "'.$row["amount"].'", "", "'.$rateperhour.'", "'.$totalhours.'");';
				if(!$_sqlObj->query($msstr)){
				$rtrn['error'][]=$_sqlObj->error();
				}
			$row=next($ms);
			}
		}
		if($bidArr_owner['status'] == "submitted" || $bidArr_owner['status'] == "waiting for approval")###if submitted directly update bid table
		{
			 $str='update bids set   descr="'.$_POST['service_description'].'", payType = (select id from paytype where name="'.$_POST['payType'].'"), payAmt ="'.$_POST['payAmt'].'", rateperhour="'.$rateperhour.'", totalhours="'.$totalhours.'", advancePayment= "'.$_POST['advancePayment'].'", dateTimeTo="'.$dateTimeTo.'", dateTimeFrom ="'.$dateTimeFrom.'", set_schedule="'.$_POST['set_schedule'].'", schedule_note ="'.$_POST['schedule_note'].'", schedule_amount ="'.$_POST['schedule_amount'].'", last_updated = now() where id='.$_POST['id'];
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
		}
		else 
		{
			 $sql_update_sr = "UPDATE bids SET statususer='$statususer',bidstatus='editbid',last_updated='$today' WHERE id='$id'";
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
		$type="editbid";

	   
			if($statususer == "seller")
			 $userid = $bidArr_owner['srOwnerId'];
			else
			$userid = $bidArr_owner['ownerId'];

		$Content="Agreement '".$bidArr['title']."' has been changed and awaiting your approval";
		$Content1="Agreement ".$bidArr['title']." has been changed and awaiting your approval";	  	
	  	$url='editbid_preview.php?id='.$id;	 
	  	
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srId ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);	  
	
	 
	  

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']

	//////After editing Bid call pusher notification to SR/Bid user --- End
		}
	
		$rtrn['status']=0;
		$rtrn['msg']='bid updation incomplete.';
		if(!array_key_exists('error', $rtrn)){
		$rtrn['status']=1;
		$rtrn['msg']='bid successfully Updated';
		}
	$_SESSION['new_bid']=array();
	//header('Location: main.php');
	//exit;	
	}

//$rtrn['status']=0;
//$rtrn['msg']='updating bid failed.'.$_sqlObj->error();
	//header('Location: main.php');
//exit;
	echo "success";
?>
