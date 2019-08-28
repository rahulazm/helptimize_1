<?php

session_start();
require_once('./common.inc.php');
require_once('./mysql_lib.php');
require_once("./en.lang.inc.php");

$configs=$_configs;

// load all addresses for this SR

//$db_get_sr_addresses = new mysqli("$host", "$username", "$password", "$db_name");

$db_check_username = new mysqli($_configs["host"], $_configs["username"], $_configs["password"], $_configs["db_name"]);

if($db_check_username ->connect_errno > 0){
    die('Unable to connect to database [' . $db_check_username ->connect_error . ']');
}


if(!empty($_POST["username"])) {
$sql_check_username = "SELECT * FROM users WHERE username='" . $_POST["username"] . "'";
  $check_username = $db_check_username->query($sql_check_username);	
  $user_count = $check_username->num_rows;
  if($user_count>0) {
      echo "<span class='status-available'>Thankyou for providing your parent/guardian username!</span>";
  }else{
      echo "<span class='status-not-available'>Sorry! The username you provided doesn't exist!</span>";
  }
}
?>
