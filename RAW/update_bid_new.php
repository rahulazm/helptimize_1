<?php
$_configs = include("/etc/helptimize/conf.php");
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

$milestones = $_POST['milestones'];

$milestone_chunks = array_chunk($milestones,4);

$milestone_size = sizeof($milestone_chunks);


//echo sizeof($milestone_chunks);
//print_r($milestone_chunks);

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


    $str='update bids set create_datetime=now(), title="'.$_POST['title'].'", descr="'.$_POST['descr'].'", payType='.$payType[0]['id'].', payAmt='.$_POST['payAmt'].', rateperhour='.$rateperhour.', totalhours='.$totalhours.', advancePayment='.$_POST['advancePayment'].', dateTimeTo="'.$_POST['dateTimeTo'].'", dateTimeFrom="'.$_POST['dateTimeFrom'].'", timeFrom = "'.$_POST['timeFrom'].'", timeTo = "'.$_POST['timeTo'].'", categId='.$_POST['category'].', cancelFee='.$_POST['cancelfee'].', is18='.$is18.', ageApproved=0, status='.$status[0]['id'].', last_updated=now(), reviewedByRequest=0,set_schedule="'.$_POST['set_schedule'].'",schedule_note="'.$_POST['schedule_note'].'",schedule_amount='.$amount.' WHERE id='.$_POST['bid_id'].' AND srId='.$_POST['service_id'].' AND ownerId='.$_SESSION['id'].'';
	if($_sqlObj->query($str)){
	$id=$_sqlObj->lastId();
	
		################Insert Revised table for bid
	$Rev_str='update bids set create_datetime=now(), title="'.$_POST['title'].'", descr="'.$_POST['descr'].'", payType='.$payType[0]['id'].', payAmt='.$_POST['payAmt'].', rateperhour='.$rateperhour.', totalhours='.$totalhours.', advancePayment='.$_POST['advancePayment'].', dateTimeTo="'.$_POST['dateTimeTo'].'", dateTimeFrom="'.$_POST['dateTimeFrom'].'", timeFrom = "'.$_POST['timeFrom'].'", timeTo = "'.$_POST['timeTo'].'", categId='.$_POST['category'].', cancelFee='.$_POST['cancelfee'].', is18='.$is18.', ageApproved=0, status='.$status[0]['id'].', last_updated=now(), reviewedByRequest=0,set_schedule="'.$_POST['set_schedule'].'",schedule_note="'.$_POST['schedule_note'].'",schedule_amount='.$amount.' WHERE bidid='.$_POST['bid_id'].' AND srId='.$_POST['service_id'].' AND ownerId='.$_SESSION['id'].'';

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



		if($milestone_size > 0)
		{
		
		$ms=$_sqlObj->escapeArr($_POST['milestones']);
		
		
        $i = 0;
		while($i <= $milestone_size )
		{

				$rateperhour=0;$totalhours=0;
				if($_POST['payType'] == "hourly")
					{					
					$rateperhour=$rateperhours;
					$totalhours=$row["amount"];
					$row["amount"]=$rateperhour*$totalhours;
					}

			$msstr='update milestones set datetime=now(), due_datetime="'.$milestone_chunks[$i][1].'", name="'.$milestone_chunks[$i][0].'", descr="'.$milestone_chunks[$i][2].'", amountType="percent", amount="'.$milestone_chunks[$i][3].'", rateperhour="'.$rateperhour.'", totalhours="'.$totalhours.'" WHERE bid='.$_POST['bid_id'].'';
				if(!$_sqlObj->query($msstr)){
				$rtrn['error'][]=$_sqlObj->error();
				}
		################Insert Revised table for Milestone

			$Rev_msstr='update milestones set datetime=now(), due_datetime="'.$milestone_chunks[$i][1].'", name="'.$milestone_chunks[$i][0].'", descr="'.$milestone_chunks[$i][2].'", amountType="percent", amount="'.$milestone_chunks[$i][3].'", rateperhour="'.$rateperhour.'", totalhours="'.$totalhours.'" WHERE bid='.$_POST['bid_id'].'';
			$Qry=$_sqlObj->query($Rev_msstr);
			$row=next($ms);

			$i++;
			
			}

		}

		################Insert Revised table for Address -- End

		//$rtrn['status']=0;
		//$rtrn['msg']='bid creation incomplete.';
		if(!array_key_exists('error', $rtrn)){
		$rtrn['status']=1;
		$rtrn['msg']='bid successfully created';
		

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
	   // get corresponding user account_details
	   $qry='select * from view_serviceRequests where id='.$_POST['service_id'];	
	   $srArr=$_sqlObj->query($qry);
	  	
	   
			if($_SESSION['id'] == $srArr[0]['ownerId'])
			 $userid = $srArr[0]['srOwnerId'];
			else
			$userid = $srArr[0]['ownerId'];

		$Content="Agreement '".$srArr[0]['title']."' has been changed and awaiting your approval";
		$Content1="Agreement ".$srArr[0]['title']." has been changed and awaiting your approval";	  	
	  	$url='view_service_details.php?id='.$_POST['service_id'];		 
	  	
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $srId ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);	  
	
	 
	  

	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']

	//////After editing Bid call pusher notification to SR/Bid user --- End
		}
	$_SESSION['new_bid']=array();
	echo json_encode($rtrn);
	
	exit;	
	}

$rtrn['status']=0;
$rtrn['msg']='inserting bid failed.'.$_sqlObj->error();
echo json_encode($rtrn);
exit;
?>
