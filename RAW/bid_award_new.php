<?php

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

session_start();
$today = date("Y-m-d H:i:s"); 
	if(!$_SESSION['id']){
        $rtrn['status']=0;
        $rtrn['msg']='Not logged in.';
        echo json_encode($rtrn);

	exit;
	}

	if( !array_key_exists('srId', $_GET) || !array_key_exists('bidId', $_GET) ){
        $rtrn['status']=0;
        $rtrn['msg']='Required params empty.';
        echo json_encode($rtrn);
	exit;
	}

	$post=$_sqlObj->escapeArr($_POST);
	$get=$_sqlObj->escapeArr($_GET);



	$sqlStr='
	select * from serviceRequests where id='.$get['srId'].' and ownerId='.$_SESSION['id'].';
	';

	$sr=$_sqlObj->query($sqlStr);
	
	

	$cnt=count($sr);

	if($cnt<1 || $sr[0]['bidAwardId'] ){
	$sr['status']=0;
        $sr['msg']='Service request already has an awarded bid.';
        echo json_encode($sr);
	exit;
	}
	
	$sqlStr='update serviceRequests set last_updated="'.$today.'",bidAwardId='.$get['bidId'].', status=(select id from status where status=\'awarded\') where id='.$get['srId'].' and ownerId='.$_SESSION['id'];
	$sqlbk=$_sqlObj->query($sqlStr);
		if(!$sqlbk){
		$rtrn['status']=0;
		$rtrn['msg']='mysql update error: '.$_sqlObj->error();
		echo json_encode($rtrn);
		exit;
		}

	$sqlStr='update bids set last_updated="'.$today.'",status=(select id from status where status=\'awarded\') where srId=(select id from serviceRequests where ownerId='.$_SESSION['id'].' and id='.$get['srId'].') and id='.$get['bidId'].';';

error_log('=============================+>>>>>>>>>>>>>>>>>>>>>>'.print_r($sqlStr, true));

	$sqlbk=$_sqlObj->query($sqlStr);
		if(!$sqlbk){
		$rtrn['status']=0;
		$rtrn['msg']='mysql update error: '.$_sqlObj->error();
		echo json_encode($rtrn);
		exit;
		}

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
		$type="award";
	   // get  Other user account_details		
		$qry='select * from view_serviceRequests where id='.$get['srId'];	
	    $srArr=$_sqlObj->query($qry);
	  	$username=$srArr[0]['bidderUsername'];
	 	
		 $sql_get_account_details = "SELECT * FROM view_users WHERE  id  !='".$_SESSION['id']."'";
		$result_get_account_details = $_sqlObj->query($sql_get_account_details);	
		
		foreach ($result_get_account_details as $key => $value) {
			 $userid = $value['id'];
			  $url="work_bid.php?id=".$get['bidId'];
	 $today = date("Y-m-d H:i:s");  
	   $Content='"'.$sr[0]['title'].'" awarded to '.$username;
	 $sql_insert_message = "INSERT INTO message_list (message_id,sr_id,message_type,message_title,date_time,read_status,user_id,receiver_id,url) VALUES ('". $get['bidId'] ."','". $get['bidId'] ."','". $type ."','". $Content ."','". $today ."','0','". $_SESSION['id'] ."','". $userid ."','". $url ."')";
	 $result_insert_message = $_sqlObj->query($sql_insert_message);

	 $sql_update_sr = "UPDATE bids SET last_updated='$today' WHERE id='".$get['bidId']."'"; 
	 $result_update_sr  = $_sqlObj->query($sql_update_sr);

	
	 
	  $data['message'] = $Content . "|" . $type. "|" . $url;
	  $pusher->trigger('pop_up_message',$userid, $data);//$value['externId']



}
	//////After creating service request call pusher notification to other users --- End
$rtrn['status']=1;
$rtrn['msg']='SR: '.$sr[0]['bidAwardId'].' awarded to bid: '.$get['bidId'];
echo json_encode($rtrn);
error_log('=============================+>>>>>>>>>>>>>>>>>>>>>>'.print_r($rtrn, true));
exit;
?>
