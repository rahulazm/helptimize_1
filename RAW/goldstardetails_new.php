<?php

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

session_start();

$userid = $_REQUEST["ownerid"];

$today = date("Y-m-d H:i:s"); 


 
  #########Bidder/Requestor All  rating
   $qstrChckr="SELECT * FROM checkr_verification WHERE user_id = '".$userid."'";
  $row=@reset($_sqlObj->query($qstrChckr)); 
   $chkrResp = $row['full_response'];
   $chkrResp=@json_decode($chkrResp);   //echo $chkrResp;
  $msgSexOff = ($chkrResp->sex_offender_search_id!="")?"PASSED":"";
  $msgTrrOff = ($chkrResp->global_watchlist_search_id!="")?"PASSED":"";
  $msgGlOff = ($chkrResp->terrorist_watchlist_search_id!="")?"PASSED":"";
  $msgSsn = ($chkrResp->ssn_trace_id!="")?"PASSED":"";
  
//echo "<label>$msgSsn</label><br><label>$msgSexOff</label><br><label>$msgTrrOff</label><br><label>$msgGlOff</label>";

$goldstarresp= '<div class="row">
					<div class="">                      
SSN verification - <span style="color:green">'.$msgSsn.'</span>
</div>
</div>
	<div class="row">
		<div class="">Sex offender verification - <span style="color:green">'.$msgSexOff.'</span>
		</div>
   </div>
   <div class="row">
	<div class="">Global watchlist verification - <span style="color:green">'.$msgGlOff.'</span>
	</div>
   </div>
   <div class="row">
	<div class="">National Criminal Database Search - <span style="color:green">'.$msgSsn.'</span>
	</div>
  </div>';
//$goldstarresp =  json_encode(array('goldstarresp' =>$goldstarresp));
?>