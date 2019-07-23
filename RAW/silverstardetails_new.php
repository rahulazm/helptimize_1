<?php

$configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

session_start();

$userid = $_REQUEST["userid"];

$today = date("Y-m-d H:i:s"); 


 
  #########Bidder/Requestor All  rating
 $qstr="select * from verifyDocs where userId = '".$userid."' order by id desc";
  $document=$_sqlObj->query($qstr);
  $count_doc=count($document);
   $j=0;
$disp='<table style="border:1px solid #bcbcbc;margin:auto" width="90%" cellpadding="2"><tr style="border-bottom:solid #bcbcbc 1px;font-weight:bold;"><td style="padding:10px;">#</td><td>Name</td><td>View</td></tr>';
$row=reset($document);
    while($row)
    {      
  $j++;

    $disp.='<tr style="border-bottom:solid #bcbcbc 1px"><td style="padding:10px;">'.$j.'</td><td style="padding:10px;">'.$row["document_number"].'</td><td style="padding:10px;"><a href="'.imgPath2Url($row['document_identfication']).'" target="_blank">view</a></td></tr>';
    $row=next($document);
     }
     $disp.='</table>';
echo $disp;

?>