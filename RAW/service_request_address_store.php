<?php
require_once("/etc/helptimize/conf.php");
require_once('./common.inc.php');
require_once('./mysql_lib.php');
session_start();

if(!$_SESSION['id'] || !$_POST || count($_POST)<=0 ){
exit(1);
}

$configs = $_configs;
$host = $configs["host"];
$db_name = $configs["db_name"];

//$addrId = $_sqlObj->escape($_POST['address_id']);

//get address
/*
mysql> describe address;
+----------+------------------+------+-----+---------+----------------+
| Field    | Type             | Null | Key | Default | Extra          |
+----------+------------------+------+-----+---------+----------------+
| id       | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| datetime | datetime         | YES  |     | NULL    |                |
| userId   | int(10) unsigned | YES  | MUL | NULL    |                |
| srId     | int(10) unsigned | YES  | MUL | NULL    |                |
| bidId    | int(10) unsigned | YES  | MUL | NULL    |                |
| personal | varchar(255)     | YES  |     | NULL    |                |
| orderNum | int(10) unsigned | YES  |     | NULL    |                |
| title    | varchar(255)     | YES  |     | NULL    |                |
| descr    | text             | YES  |     | NULL    |                |
| address  | varchar(255)     | YES  |     | NULL    |                |
| posLong  | decimal(18,15)   | YES  |     | NULL    |                |
| posLat   | decimal(18,15)   | YES  |     | NULL    |                |
| country  | varchar(255)     | YES  |     | NULL    |                |
| notes    | mediumtext       | YES  |     | NULL    |                |
+----------+------------------+------+-----+---------+----------------+
14 rows in set (0.00 sec)
*/
$sql_insert_accounts_addresses = 'INSERT INTO address values(\'\', now(), '.$_SESSION['id'].', null, null, null, null, null, \''.$_sqlObj->escape($_POST['name']).'\', \''.$_sqlObj->escape($_POST['description']).'\', \''.$_sqlObj->escape($_POST['address']).'\', \''.$_sqlObj->escape($_POST['posLong']).'\', \''.$_sqlObj->escape($_POST['posLat']).'\', null, null)';

	if($_sqlObj->query($sql_insert_accounts_addresses)){
	alert("yes");
	$rtrn['status']=0; 
	$rtrn['msg']=$_sqlObj->lastId();
	echo json_encode($rtrn);
	exit(0);
	}

$rtrn['status']=1; 
$rtrn['error']=$_sqlObj->error();
echo json_encode($rtrn);
exit(1);
?>
