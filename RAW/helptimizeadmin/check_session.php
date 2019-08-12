<?php


$db_check_valid_session = new mysqli('localhost', 'root', '', 'helptimize_new');

if($db_check_valid_session ->connect_errno > 0){
    die('Unable to connect to database [' . $db_check_valid_session ->connect_error . ']');
}

$sql_check_valid_session = "SELECT id FROM admin_accounts WHERE session_id = '$session_id'";
$result_check_valid_session = $db_check_valid_session->query($sql_check_valid_session);
$row_cnt_session = $result_check_valid_session->num_rows;

$db_check_valid_session->close();





if($row_cnt_session > 0){


}else{

	header("Location:index.php");
	exit();
}


?>