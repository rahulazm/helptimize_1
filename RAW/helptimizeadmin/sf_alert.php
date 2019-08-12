<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all sr

 
$db_get_sr = new mysqli("$host", "$username", "$password", "$db_name");


if($db_get_sr ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sr ->connect_error . ']');
}


$sql_get_sr  = "SELECT
  b.srId,
  s.title,
  s.descr,
  s.create_dateTime
from
  bids as b,
  serviceRequests as s
where
  b.srId = s.id
  AND s.create_dateTime < (date_add(now(), interval -1 HOUR))
group by
  b.srId
HAVING(count(*)) < 2";
//echo $sql_get_sr;
$result_get_sr = $db_get_sr->query($sql_get_sr);



while($row=$result_get_sr->fetch_assoc()){
	$continue=true;
	$sql= "select srID,status from sf_alerts where srID=".$row['srId'];
	$result = @$db_get_sr->query($sql);
 if(isset($result)){	
	$row_sr = $result->fetch_assoc();
   if($row_sr['status']=='f'){
   	//exit();
   	$continue=false;
   }
}
   
//print_r($row);
//exit;  
if($continue==true) {	
   	$to='rahulazm@gmail.com';
   	$subject = 'Alert';
   	$message='<p>Below Service request has no bid from last 1 hour </p>
   	<p>Service Request ID:'.$row['srID'].'</p><p>Service request Title:'.$row['title'].'</p><p>
   	Service request details :'.$row['descr'].'</p>';
   	// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <webmaster@example.com>' . "\r\n";
		$headers .= 'Cc: myboss@example.com' . "\r\n";
		mail($to,$subject,$message,$headers);
		$now=date("Y-m-d H:i:s");
		$sql_alert1="INSERT INTO `sf_alerts` (`id`, `srID`, `firtst_sent_on`, `status`, `sec_sent_on`) VALUES (NULL, '".$row['srId']."','".$now."', 'f', NULL);";
		$result_alrt1 = $db_get_sr->query($sql_alert1);	
	}	
																							   
   
}
echo "Finished";
$db_get_sr->close();






?>