<?php
require_once('./common.inc.php');
require_once('./mysql_lib.php');
session_start();

if(!$_SESSION['id']){
exit(1);
}

if(count($_POST)<=0){
exit(1);
}

$_POST['lat'];
$_POST['lng'];
$_POST['rngLat'];
$_POST['rngLng'];
$_POST['categId'];

error_log("================>>>>".print_r($_POST,true));

$_POST=$_sqlObj->escapeArr($_POST);

$earthRads=3962; //radius of earth in miles.


// takes in miles via num
//returns lat (degrees, not radians)
//1 lat degree = 69miles/111km
function mileToLat($num){
global $earthRads;
	if($num>= ($earthRads * pi() / 2)){
	return 0; //at this point, you're searching past an entire hemisphere. return 0
	}
$lat=69;
return abs($num) / $lat; //doesn't matter if number of miles are negative. we just care about distances
}

/*----------------------------
pre: none
post: none
takes num in miles and lat (in degrees, not radians) returns lng (degrees, not radians)

1° longitude = cosine (latitude) * length of degree (miles) at equator. <-- got this from googling. [un]surprisingly, it's wrong.

--------here's what I got from math, trig and perfect sphere (good enough for our purposes)---------------- 
R = radius of earth
a = latitudal degree in radians

length of curve of longitude =  ((longitude * pi)/180) * R * cos(a)
** if R is in miles, so is the final length**

to convert miles to degree:

(miles * 180)/(R * pi * cos(a)) = degree
--------------------------*/
function mileToLng($num, $lat){
global $earthRads;
	if($num>= ($earthRads * pi())){
	return 0; //at this point, you're searching more than the entire earth. return 0; 
	}

$up=$num * 180;
$latRads=abs($lat) * pi() / 180;
$down=$earthRads * pi() * cos($latRads);
return $up / $down;
}
//-------------- all this below needs to be rewritten to allow for different types of helpers. It'll do for now-----------------

$lat['mid']=$_POST['lat'];
$lat['rng']=mileToLat($_POST['rngLat']);
$lat['min']=$lat['mid']-$lat['rng'];
$lat['max']=$lat['mid']+$lat['rng'];

$lng['mid']=$_POST['lng'];
$lng['rng']=mileToLng($_POST['rngLng'], $_POST['lat']);
$lng['min']=$lng['mid']-$lng['rng'];
$lng['max']=$lng['mid']+$lng['rng'];

if(is_numeric($_POST['categId']) && $_POST['categId']>0){

//$categstr='and categId='.$_POST['categId'].' ';
$categstr="and categId LIKE '%,".$_POST['categId'].",%' ";
}

$str='select * from range_area where userId!='.$_SESSION['id'].' '.$categstr;//.' '.$categstr.'and lat>='.$lat['min'].' and lat<='.$lat['max'].' and lng>='.$lng['min'].' and lng<='.$lng['max'].';';


error_log('findHelperNear.php==============>> lat: '.$lat['mid'].', lng: '.$lng['mid'].', latrng: '.$lat['rng'].', lngrng: '.$lng['rng']);
error_log('findHelperNear.php==============>> id: '.$_SESSION['id'].', sqlstr: '.$str);

$addrs=$_sqlObj->query($str);
if(!$addrs){
error_log('findHelperNear.php==============>> sql error: '.$_sqlObj->error());
error_log('findHelperNear.php==============>> sql error: '.$str);
}

echo json_encode($addrs);

?>
