<?php
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

session_start();
if($_POST['service']=='bids'){
	
	$bdrdetails=$_sqlObj->query("SELECT bids.id,bids.title,bids.ownerid,bids.shortlist, bids.summ,bids.descr,bids.payType,bids.payAmt,bids.dateTimeTo,bids.dateTimeFrom, bids.create_dateTime,users.username,users.firstName,users.midName ,categ.name,bids.categId,paytype.name as paytype , view_bids.status as bidstatus FROM `bids`, users,categ,paytype,view_bids WHERE bids.`srId` = '$_POST[srid]' and users.id=bids.ownerId and bids.ownerId='$_POST[ownerid]' and bids.bidstatus != 'cancel' and bids.categId=categ.id and paytype.id=bids.payType and view_bids.id = bids.id");
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


	#########MILESTONES
	//require_once("view_bid_new.php?id=".$_POST[srid]);
	//require_once("work_bid_new.php?id=".$bdrdetails[0]['id']);
	//$bdrdetails[0]['milestones']=$inOffTmpl;


	echo json_encode($bdrdetails[0]);
	exit();
}
?>