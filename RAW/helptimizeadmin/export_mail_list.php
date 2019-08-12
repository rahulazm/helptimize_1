<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all e-mails

$db_get_mails = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_mails ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_mails ->connect_error . ']');
}

$sql_get_mails = "SELECT * FROM potential_service_providers";

$result_get_mails = $db_get_mails->query($sql_get_mails);

$db_get_mails->close();


while ($row = $result_get_mails->fetch_assoc()) {

	$emails = $row['emails'];
	
	$emails_arr = explode(",", $emails);
	
	foreach ($emails_arr as &$value) {
	
	    if($value != ""){
		echo $value;
		echo "<br>";
		}
	
    	
	}
	
	

	

}






?>