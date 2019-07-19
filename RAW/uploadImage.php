<?php
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");
use \Eventviva\ImageResize;



session_start();


/*-------------------------
pre: $_FILES, type match array (from $_configs)
post: none
reads through $_FILEs and checks the info to see whether or not the
file should be let through. returns bool true if okay. array with errors if false
array(1) {
  ["file"]=>
  array(5) {
    ["name"]=>
    array(2) {
      [0]=>
      string(18) "1502701652679.webm"
      [1]=>
      string(18) "1502451215710.webm"
    }
    ["type"]=>
    array(2) {
      [0]=>
      string(10) "video/webm"
      [1]=>
      string(10) "video/webm"
    }
    ["tmp_name"]=>
    array(2) {
      [0]=>
      string(14) "/tmp/php36PEnA"
      [1]=>
      string(14) "/tmp/phpwTlCtF"
    }
    ["error"]=>
    array(2) {
      [0]=>
      int(0)
      [1]=>
      int(0)
    }
    ["size"]=>
    array(2) {
      [0]=>
      int(3004531)
      [1]=>
      int(2869002)
*

-------------------------*/
function imgChecks($typeArr){
	if(!is_array($typeArr)){
	$rtrn['status']=1;
	$rtrn['msg']='array to check against was not supplied';
	return $rtrn;
	}
global $_configs;
$files=reset($_FILES);
$inputname=key($_FILES);
$types=$files['type'];
$rtrn=array();
	foreach($types as $key => $val){
		//make sure it's of an approved type
     if($val == "")$val="image/jpg";
		if(!array_key_exists(strtolower($val), $typeArr)){

		$rtrn[$key]['status']=1;
		$rtrn[$key]['msg']='File "'.$_FILES[$inputname]['name'][$key].'" not a type that\'s approved for upload. ['.$val.']';
		}
		if($_FILES[$inputname]['size'][$key]>=$_configs['upload_size_limit']){
                $rtrn[$key]['status']=1;
                $rtrn[$key]['msg']='File "'.$_FILES[$inputname]['name'][$key].'" not a size that\'s approved for upload. ['.$_FILES[$inputname]['size'][$key].' out of '.$_configs['upload_size_limit'].'] over by '.($_FILES[$inputname]['size'][$key]-$_configs['upload_size_limit']) ;
		}
	} 

	if(count($rtrn)<1){
	return true;
	}

return $rtrn;
}

// upload file
//check against google safe search
//if passed, add to db, add userid to record. DO NOT ADD srID or bidID yet
/*
{
  "responses": [
    {
      "safeSearchAnnotation": {
        "adult": "VERY_LIKELY",
        "spoof": "VERY_UNLIKELY",
        "medical": "UNLIKELY",
        "violence": "VERY_UNLIKELY",
        "racy": "VERY_LIKELY"
      }
    }
  ]
}

UNKNOWN 	Unknown likelihood.
VERY_UNLIKELY 	It is very unlikely that the image belongs to the specified vertical.
UNLIKELY 	It is unlikely that the image belongs to the specified vertical.
POSSIBLE 	It is possible that the image belongs to the specified vertical.
LIKELY 	It is likely that the image belongs to the specified vertical.
VERY_LIKELY 	

*/
/*------------------------------
pre: php's session upload progress (http://php.net/manual/en/session.upload-progress.php), 
post: image gets uploaded, returns upload status
runs the code to accept $_FILES and $_POST request to upload image. Handles multiple images
but follows the convention that each upload input's name is <somestr>[]. example:
<input name='file[]'>
*warning* doing <input name='[]file'> will crash the apache and cause it reboot.
------------------------------*/
function upload(){
$rtrn="";
global $_configs;


$files=reset($_FILES);
$inputname=key($_FILES);
$names=reset($files['name']);
$i=0;
$max=count($files['name']);
$key = ini_get("session.upload_progress.prefix") . $_POST[ini_get("session.upload_progress.name")];
	while($i<$max){
	$fn=$_configs['uploads_dir'] . $_SESSION['id']."_".basename($files['name'][$i]);
		if(move_uploaded_file($files['tmp_name'][$i], $fn)){
			$_SESSION[$key]['files'][$i]['final_path']=$fn;
		}
	$i++;
	}

return $_SESSION[$key];
}

/*--------------------
pre: common.inc.php's apiJsonPost, conf.php's settings
post:
sends image to google to check for porn. 
---------------------*/
function adultCheck($img){
	if(!$img||!file_exists($img)){
	return false;
	}
global $_configs;
$json=img2GoogleJson($img);
$url=$_configs['google_api_safe']['url'].$_configs['google_api_safe']['key'];
return apiJsonPost($url, $json);
}
//if failed, delete image from server. return message


/*----------------------------------------
pre: mysql_lib.php, the output of the above upload function and $_SESSION filled.
post: db changed
add the images to the users account.
  ["sid"]=>
  string(26) "fnau6n6o0dpu4hmfc19ug8v600"
  ["language"]=>
  string(2) "en"
  ["id"]=>
  string(1) "4"
  ["externId"]=>
  string(8) "jhyjuys6"
  ["username"]=>
  string(5) "Jeff2"
  ["status"]=>
  string(6) "active"
  ["verified"]=>
  string(6) "active"
  ["email"]=>
  string(26) "angelmichaeljeff@gmail.com"
  ["guardId"]=>
  NULL
  ["guardUsername"]=>
  NULL
  ["dob"]=>
  string(10) "1972-05-16"
  ["is18"]=>
  bool(true)
   array(2) {
      [0]=>
      array(7) {
        ["field_name"]=>
        string(6) "file[]"
        ["name"]=>
        string(35) "nexusae0_CTIA_OMTP_Pinout_thumb.png"
        ["tmp_name"]=>
        string(14) "/tmp/phpzP8Hhq"
        ["error"]=>
        int(0)
        ["done"]=>
        bool(true)
        ["start_time"]=>
        int(1535522907)
        ["bytes_processed"]=>
        int(5729)
      }
      [1]=>
      array(7) {
        ["field_name"]=>
        string(6) "file[]"
        ["name"]=>
        string(17) "nokia_headset.png"
        ["tmp_name"]=>
        string(14) "/tmp/phpju38Ua"
        ["error"]=>
        int(0)
        ["done"]=>
        bool(true)
        ["start_time"]=>
        int(1535522907)
        ["bytes_processed"]=>
        int(26402)
      }
    }
-----------------------------------------*/
function tagPics2UserDb($userId, $filePath, $num, $rates, $title, $srId=null){
	if(!$userId || !file_exists($filePath)){
	$rtrn['name']=$filePath;
	$rtrn['msg']="userId not supplied to file doesn't exist";
	$rtrn['status']=1;
	return $rtrn;
	}
$rtrn="";
global $_sqlObj;

$findStr='select id from pics where userId="'.$userId.'" and url="'.$_sqlObj->escape($filePath).'"';
$findRslt=$_sqlObj->query($findStr);
	//most likely (unless you're using this as a one-off function), by the time you're here, you've ran the other two functions before it
	// therefore, this is not an adult or violence picture, and needs to be overwritten and the db entry removed
	if(count($findRslt)>=1){
	//this deletes all entries withere both the $userId matches and the $filePath matches. It should only delete one entry as $filePath should be unique
	//if it is not, it should be deleted anyways as, again, it should be unique.
	$_sqlObj->query('delete from pics where userId="'.$userId.'" and url="'.$_sqlObj->escape($filePath).'"');
	}

	$rateStr="";
	if(is_array($rates)){
	$rateStr="a:".$rates['adult'].",v:".$rates['violence'];
	}


//$insrt='insert into pics(id, datetime, userId, orderNum, url, title, safeRate, notes) values(null, now(), "'.$userId.'","'.$num.'", "'.$_sqlObj->escape($filePath).'", "'.$_sqlObj->escape($title).'","'.$rateStr.'", "");';
$srId=$srId?$_sqlObj->escape($srId):'null';

$insrt='insert into pics(datetime, userId, srId, orderNum, url, title, safeRate, notes) values(now(), "'.$userId.'", '.$srId.', '.$num.', "'.$_sqlObj->escape($filePath).'", "'.$_sqlObj->escape($title).'","'.$rateStr.'", "");';

$insrtStatus=$_sqlObj->query($insrt);

	if($insrtStatus){
	$rtrn['name']=$filePath;
	$rtrn['filename']=basename($filePath);
	$rtrn['status']=0;
	}
	else{	
	$rtrn['msg']=$_sqlObj->error()."\n".$insrt;
	$rtrn['name']=$filePath;
	$rtrn['status']=1;
	}
return $rtrn;
}

/*-----------------------------
pre: everything here and what it requires
post: database updated, images potentially deleted
main upload image function.handles the logic of uploading the images, checking for inappropriate images, updating db and/or deleting the image.
------------------------------*/
function uploadMain(){
global $_configs;
global $_sqlObj;


// check if logged in. (make sure id exists) if logged in and $_files exist, start logic
	if(!$_SESSION['id']){
	$rtrn['status']=1;
	$rtrn['msg']="Not logged in.";
	return $rtrn;
	}
//checks files uploaded for size and type
$imgChkRtrn=imgChecks($_configs['upload_types']);
	if(!is_bool($imgChkRtrn) || $imgChkRtrn!=(bool)true){
	return $imgChkRtrn;
	}

//upload all images first.
$rtrn=upload();
	if(count(reset($rtrn))<=0){
	$rtrn['status']=1;
	$rtrn['msg']="No image uploaded.";
	return $rtrn;
	}
// once uploaded, check each image for inappropriate conten.
$rows=$rtrn['files'];
$lvl["adult"]=$_configs["google_api_safe"]["vals"][$_configs["google_api_safe"]["adult_limit"]];
$lvl["violence"]=$_configs["google_api_safe"]["vals"][$_configs["google_api_safe"]["violence_limit"]];
$rate=array();
$dbResp="";
	foreach($rows as $i => $tmp){

	$gglRsp=json_decode(adultCheck($tmp['final_path']), true);
	$rate['adult']=$_configs["google_api_safe"]["vals"][$gglRsp["responses"][0]["safeSearchAnnotation"]["adult"]];
	$rate['violence']=$_configs["google_api_safe"]["vals"][$gglRsp["responses"][0]["safeSearchAnnotation"]["violence"]];

		//compare the rate 
		//if($rate['adult']<$lvl['adult'] && $rate['violence']<$lvl['violence'] && file_exists($tmp['final_path'])){
		if(1){
		$image = new ImageResize($tmp['final_path']);
		$image->resizeToBestFit(300, 300);
		$str=smallPicName($tmp['final_path']);
		$image->save($str);

		//add to db
		$dbResp[$i]=tagPics2UserDb($_SESSION['id'], $tmp['final_path'], $i, $rate, $_POST['title'][$i], $_POST['srId'][$i]);
		}
		else{
		//blanket delete the image from the db
		$_sqlObj->query('delete from pics where userId="'.$_SESSION['id'].'" and url="'.$_sqlObj->escape($tmp['final_path']).'"'); 
		$dbResp[$i]['status']=1;
		$dbResp[$i]['name']=$tmp['final_path'];
		$msgstr="Image inappropriate. \nAdult rating: ".$rate['adult'].'/'.$lvl["adult"]." \nViolence rating: ".$rate['violence'].'/'.$lvl["violence"];
		unlink($tmp['final_path']);
		$dbResp[$i]['msg']=$msgstr;
		$dbResp[$i]['adult_lvl']=$rate['adult'];
		$dbResp[$i]['violence_lvl']=$rate['violence'];
		$dbResp[$i]['adult_limit']=$lvl["adult"];
		$dbResp[$i]['violence_limit']=$lvl["violence"];
		}

	}

return $dbResp;
	
}

$rtrn=uploadMain();
echo json_encode($rtrn);
?>
