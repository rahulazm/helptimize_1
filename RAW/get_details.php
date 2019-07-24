<?php
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

session_start();
if($_POST['service']=='bids'){
	
	$bdrdetails=$_sqlObj->query("SELECT bids.title,bids.ownerid , bids.summ,bids.descr,bids.payType,bids.payAmt,bids.dateTimeTo,bids.dateTimeFrom, bids.create_dateTime,users.username,users.firstName,users.midName ,categ.name,bids.categId,paytype.name as paytype FROM `bids`, users,categ,paytype WHERE bids.`srId` = '$_POST[srid]' and users.id=bids.ownerId and bids.ownerId='$_POST[ownerid]' and bids.categId=categ.id and paytype.id=bids.payType");
	$dateFrom = date("d/m/y H:i:s A",strtotime($bdrdetails[0]['dateTimeTo']));
	//echo $dateFrom;
	$dateTo = date("d/m/y H:i:s A",strtotime($bdrdetails[0]['dateTimeFrom']));

	$dateFromArr = explode(" ", $dateFrom);
	$timeFrm = $dateFromArr[1];
	$dtFrm = $dateFromArr[0];
	$bdrdetails[0]['timeFrm']=$timeFrm;
	$bdrdetails[0]['dtFrm']=$dtFrm;

	$dateToArr = explode(" ", $dateTo);
	$timeTo = $dateToArr[1];
	$dtTo = $dateToArr[0];
	$bdrdetails[0]['timeTo']=$timeTo;
	$bdrdetails[0]['dtTo']=$dtTo;
	
	#########Bidder/Requestor Gold rating
	require_once("userdetails_new.php");
	$bdrdetails[0]['bluestar_Percentage']=$bluestar_Percentage;
	$bdrdetails[0]['diamondrtng']=$silver_rating.$bluestar_rating.$gold_rating_bidder;

	#########BLUE STAR rating details
	require_once("bluestardetails_new.php");
	//echo $dispBlue;
	$bdrdetails[0]['bluedetls']=$dispBlue;

	#########GOLD STAR rating details
	require_once("goldstardetails_new.php");
	$bdrdetails[0]['goldstarresp']=$goldstarresp;


	echo json_encode($bdrdetails[0]);
	exit();
}
?>