<?php
session_start();
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");



	if( !$_SESSION['id']){

	echo "not logged in";
	return 1;
	}

	if( !$_POST['id']){
	echo "No id supplied. Do nothing.";
	return 1;
	}


$str='select url from view_pics where id="'.$_sqlObj->escape($_POST['id']).'" and userId="'.$_SESSION['id'].'";';
$imgPath=$_sqlObj->query($str);
	if(count($imgPath)>1){
	error_log("CUSTOM ERROR: MORE THAN 1 picture found for \"".$str."\"! This should never be the case!");
	}
$imgPath=$imgPath[0]["url"];

$sql_delete_picture = "DELETE FROM pics where userId='" . $_SESSION['id'] . "' and id='".$_POST['id']."'"; 

echo "Removing from DB: ".$_sqlObj->query($sql_delete_picture);
if(file_exists($imgPath)){
echo "Removing file: ".unlink($imgPath);
}

?>
