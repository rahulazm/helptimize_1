<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
session_start();
$_configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

echo "<pre>";
print_r($_REQUEST);

$today = date("Y-m-d H:i:s");  

if($_SESSION['id']){
	$post=$_REQUEST;

	
		if(!is_array($post['bidDate'])){
		$post['bidDate']=dateFormat(nextAt(time()));
		}
		else{

		$dy=$post['bidDate']['days'];
		$hr=$post['bidDate']['hrs'];
		$post['bidDate']= dateFormat(time() + (3600 * $hr) + (86400 * $dy));
		}
			

		/*if(!array_key_exists('dateTimeFrom', $post) || !$post['dateTimeFrom']||$post['dateTimeBool']=='urgent'){			
		$post['dateTimeFrom']=dateFormat(strtotime($post['bidDate']));
		}*/
	

		if(!array_key_exists('reqstedBidId', $post)){
		$post['reqstedBidId']='null';
		}
		
	
		if($post['is18']==1){
		$post['guardApproval']=1;
		$post['status']='submitted';
		}
		else{
		$post['guardApproval']=0;
		$post['status']='waiting for approval';
		}


		foreach($post as $key=>$val){

			if(is_array($post[$key])){
				foreach($post[$key] as $i=>$v){
				$post[$key][$i]=$_sqlObj->escape($v);
				}
			}
			else{

				if(!$post[$key]){
				 $post[$key]="null";
				}
				else{
				$post[$key]=$_sqlObj->escape($val); //escapes string of null to actual null
				}

			}
		}

	        $sqlStr='insert into serviceRequests values(null, "'.$post['title'].'", "'.$post['descr'].'", "'.$post['summ'].'", (select id from status where status="'.$post['status'].'"), "'.$post['bidDate'].'", now(),now(), (select id from paytype where name="'.$post['payType'].'"), "'.$post['payAmt'].'", "'.$post['totalhours'].'", "'.$post['rateperhour'].'", "'.$post['dateTimeTo'].'", "'.$post['dateTimeFrom'].'", "'.$post['timeFrom'].'", "'.$post['timeTo'].'", '. $post['reqstedBidId'].', null, '.$post['category'].', '.$_SESSION['id'].', '.$post['is18'].', '.$post['guardApproval'].', "'.$post['externId'].'", 0, "", "'.$post['buttonstatus'].'", "'.$post['cancelfee'].'","'.$post['set_schedule'].'", "'.$post['schedule_note'].'", "'.$post['schedule_amount'].'");';

	 //echo($sqlStr);
	 $rtrn=$_sqlObj->query($sqlStr);
	 
	
	if(!$rtrn){
	error_log($_sqlObj->error());
	error_log($sqlStr);
	}

	error_log("user ".$_SESSION['id']." inserting into db: ".$sqlStr);
	
	$id=$_sqlObj->lastId();
	######Update resubmit SRId as a cancel
	if($post['current']=="cancel"){
		$sr_id=$post['sr_number'];		
		$sql_update_status = "UPDATE serviceRequests SET buttonstatus='cancel',last_updated='$today' WHERE id='$sr_id'"; 
		$result_update_status = $_sqlObj->query($sql_update_status);
		$sql_update_status = "UPDATE bids SET buttonstatus='cancel' WHERE srId='$sr_id'";
		$result_update_status = $_sqlObj->query($sql_update_status);

	}
	$key=1;
	foreach($post['imgs'] as $i => $v){
	$i=$_sqlObj->escape($i);
	$v=$_sqlObj->escape($v);	
	 $_sqlObj->query('update pics set srId='.$id.', orderNum="'.$key.'" where id="'.$v.'" and userId="'.$_SESSION['id'].'";');
	 $key++;
	}

	$_sqlObj->query('update pics set srId='.$id.' where srId is null and userId="'.$_SESSION['id'].'";');


//echo "INSERT INTO `address` (`id`, `datetime`, `userId`, `srId`, `bidId`, `personal`, `pob`, `orderNum`, `title`, `descr`, `address`, `posLong`, `posLat`, `country`, `notes`) VALUES (NULL, '$today', '$id', '$_SESSION[id]', NULL, NULL, NULL, NULL, NULL, NULL, '$post[addr]', NULL, NULL, NULL, NULL)";

/*$_sqlObj->query("INSERT INTO `address` (`id`, `datetime`, `userId`, `srId`, `bidId`, `personal`, `pob`, `orderNum`, `title`, `descr`, `address`, `posLong`, `posLat`, `country`, `notes`) VALUES (NULL, '$today','$_SESSION[id]','$id',  NULL, NULL, NULL, NULL, NULL, NULL, '$post[addr]', '$post[posLong]', '$post[posLat]', NULL, NULL)");*/

// set srId='.$id.', orderNum="'.$i.'" where id="'.$v.'" and userId="'.$_SESSION['id'].'";');

/*
error_log("====================>> adding addresses to sr: ".print_r($post['addr'], true));
	foreach($post['addr'] as $i => $v){
	$i=$_sqlObj->escape($i);
	$v=$_sqlObj->escape($v);
	 $_sqlObj->query('update address set srId='.$id.', orderNum="'.$i.'" where id="'.$v.'" and userId="'.$_SESSION['id'].'";');
	}
*/
	$_sqlObj->query('update address set srId='.$id.' where srId is null and userId="'.$_SESSION['id'].'";');

	if($post['buttonstatus'] == "submit") { //submit SR only push notification send
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

		$categstr="and categId LIKE '%,".$_POST['category'].",%' ";
		$str='select * from range_area where userId!='.$_SESSION['id'].' '.$categstr;
		$result_str = $_sqlObj->query($str);
		foreach ($result_str as $key => $value) {
	   /*// get  Other user account_details		
		 $sql_get_account_details = "SELECT * FROM view_users WHERE  id  !='".$_SESSION['id']."'";
		$result_get_account_details = $_sqlObj->query($sql_get_account_details);*/	
		
		
		$userid = $value['userId'];
		$Content="New incoming request -  '".$post['title']."'";
		$Content1="New incoming request -  ".$post['title']."";
	  $url="view_service_details.php?id=".$id;
	 $today = date("Y-m-d H:i:s");  
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $id ."','". $id ."','". $type ."','". $Content1 ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	$result_insert_message = $_sqlObj->query($sql_insert_message);

	  
	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']



}
	//////After creating service request call pusher notification to other users --- End
}

	$_SESSION['new_sr']=array();
	echo $id;	
	}
	

?>
