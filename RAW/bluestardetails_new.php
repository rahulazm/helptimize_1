<?php
session_start();

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];
$userid = $_REQUEST["userid"];
$today = date("Y-m-d H:i:s"); 


#########Bidder/Requestor All  rating
$sql_rating = "SELECT * FROM ratings WHERE toUserId='".$userid."' ";
$rating=$_sqlObj->query($sql_rating); 
$dispBlue="";  
$row=reset($rating);
    while($row)
    {
      $srArr=reset($_sqlObj->query('select * from view_serviceRequests where id='.$row["srId"].';'));
    
      $dispBlue.='<div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
           '.$srArr["title"].'
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
           '.$row["rating"].'
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            Lorem Ipsum '.$row["comment"].'
        </div>
     </div>';
     $row=next($rating);
    }
     
echo json_encode($dispBlue);

?>