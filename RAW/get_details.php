<?php
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

session_start();
if($_POST['service']=='bids'){
	
	$bdrdetails=$_sqlObj->query("SELECT bids.id,bids.title,bids.ownerId,bids.shortlist, bids.summ,bids.descr,bids.payType,bids.payAmt,bids.dateTimeTo,bids.dateTimeFrom, bids.create_dateTime,users.username,users.firstName,users.midName ,categ.name,bids.categId,paytype.name as paytype , view_bids.status as status, view_bids.srOwnerId as srOwnerId FROM `bids`, users,categ,paytype,view_bids WHERE bids.`srId` = '$_POST[srid]' and users.id=bids.ownerId and bids.ownerId='$_POST[ownerid]' and bids.bidstatus != 'cancel' and bids.categId=categ.id and paytype.id=bids.payType and view_bids.id = bids.id");

	$bdrAddress = $_sqlObj->query("SELECT * from address where srId = '$_POST[srid]' or (bidId = NULL or bidId = '$bdrdetails[0][id]')");
	$rowBdrAddress=@reset($bdrAddress);

	$bdrdetails[0]['address'] = "";
	while($rowBdrAddress) {
		$bdrdetails[0]['address'] .= "<p><i class='fas fa-map-marker-alt'></i>&nbsp;".$rowBdrAddress['address']."<span>";
		$rowBdrAddress=next($bdrAddress);
	}
	$dateFrom = date("jS M Y-h:i A",strtotime($bdrdetails[0]['dateTimeTo']));
	//echo $dateFrom;
	$dateTo = date("jS M Y-h:i A",strtotime($bdrdetails[0]['dateTimeFrom']));

	$dateFromArr = explode("-", $dateFrom);
	$timeFrm = $dateFromArr[1];
	$dtFrm = $dateFromArr[0];
	$bdrdetails[0]['loggedin_user_id'] = $_SESSION['id'];
	$bdrdetails[0]['timeFrm']=$timeFrm;
	$bdrdetails[0]['dtFrm']=$dtFrm;

	$dateToArr = explode("-", $dateTo);
	$timeTo = $dateToArr[1];
	$dtTo = $dateToArr[0];
	$bdrdetails[0]['timeTo']=$timeTo;
	$bdrdetails[0]['dtTo']=$dtTo;
	
	#########Bidder/Requestor Gold rating
	require_once("userdetails_new.php");
	$bdrdetails[0]['bluestar_Percentage']=$bluestar_Percentage."%";
	$bdrdetails[0]['diamondrtng']=$silver_rating.$bluestar_rating.$gold_rating_bidder;

	#########BLUE STAR rating details
	require_once("bluestardetails_new.php");
	//echo $dispBlue;
	$bdrdetails[0]['bluedetls']=$dispBlue;

	#########SILVER STAR rating details
	require_once("silverstardetails_new.php");
	//echo $dispSilver;
	$bdrdetails[0]['silverdetls']=$dispSilver;


	#########GOLD STAR rating details
	require_once("goldstardetails_new.php");
	$bdrdetails[0]['goldstarresp']=$goldstarresp;


	######### Payment calculation

		$sql_get_saved_bids = "SELECT * FROM bidPayments WHERE bidid='".$bdrdetails[0]['id']."' AND status='18' AND usertype='seller' order by id desc limit 1 ";
        $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
        $bdrdetails[0]['request_amnt']=$result_get_saved_bids[0]['payAmt'];
        if($bdrdetails[0]['request_amnt'] < $bdrdetails[0]['payAmt']){
        	$bdrdetails[0]['amnt_type'] = 'Partial Amount';
        }else{
        	$bdrdetails[0]['amnt_type'] = 'Full Amount';
        }

	######### Request Payment calculation
		$sql_get_saved_bids = "SELECT SUM(payAmt) AS paidamt FROM bidpayments WHERE bidid='".$bdrdetails[0]['id']."' AND status='19' AND usertype='buyer'";
        $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
        $bdrdetails[0]['paid_amnt']= $result_get_saved_bids[0]['paidamt'];


	#########MILESTONES
	//require_once("view_bid_new.php?id=".$_POST[srid]);
	//require_once("work_bid_new.php?id=".$bdrdetails[0]['id']);
	//$bdrdetails[0]['milestones']=$inOffTmpl;


	echo json_encode($bdrdetails[0]);
	exit();
}
?>