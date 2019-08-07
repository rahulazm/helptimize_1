<?php

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

session_start();
$usertype = $_REQUEST["usertype"];
$userid = $_REQUEST["ownerid"];
$type = $_REQUEST["type"];
$today = date("Y-m-d H:i:s"); 

#########Bidder/Requestor Gold rating
   $qstr="select * from checkr_verification where user_id = '".$userid."' order by id desc";
  $document=$_sqlObj->query($qstr);
   $count_doc_bidder=count($document);
  if($count_doc_bidder>0) $gold_rating_bidder='<a href="javascript:void()" class="gold_star_click1" data-userid="'.$userid.'  "><img src="img/goldstar.jpg" width="25px"></a>';
   #########Bidder/Requestor Silver rating
  $qstr="select * from verifyDocs where userId = '".$userid."' order by id desc";
  $document=$_sqlObj->query($qstr);
  $count_doc_bidder=count($document);
  if($count_doc_bidder>0) $silver_rating='<a href="javascript:void()" class="silver_star_click1" data-userid="'.$userid.'  "><img src="img/silverstar.jpg" width="25px"></a>';
  #########Bidder/Requestor Blue star rating
   $sql_rating = "SELECT AVG(rating) AS rating FROM ratings WHERE toUserId='".$userid."' ";
   $rating=$_sqlObj->query($sql_rating);   
   $bluestar_Percentage=round((($rating[0]['rating']*100)/5),2);
   //if($type == "seller")
     $sql_rating = "SELECT * FROM view_serviceRequests WHERE bidderId='".$userid."' or ownerId='".$userid."' ";
  // else
  // $sql_rating = "SELECT * FROM view_serviceRequests WHERE ownerId='".$userid."' ";
 
    $rating=$_sqlObj->query($sql_rating); 
    $count_rating_bidder=count($rating); 
    if($count_rating_bidder>5 && $bluestar_Percentage>80) 
    	$bluestar_rating='<img src="img/bluestar.png" width="25px">'; 

    /*$disp='<label for="requesterBox">Username:</label><label class="SRRequesterName" for="requesterBoxB">
                                '.$usertype.' </label><br><label for="requesterBox">
                                Star Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">'.
                                $bluestar_Percentage
                                .'%</label><br>
                                <label for="requesterBox">
                                Diamond Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                <input type="checkbox" id="requesterBoxB" class="checkHideShow" style="display: none;"> 
                                </input>'.$silver_rating.$bluestar_rating.$gold_rating_bidder.'
                                </label>';
echo $disp;
*/
?>