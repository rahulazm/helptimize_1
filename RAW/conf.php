<?php

//manual document root for helptimize
$_root='/all_helptimize/helptimize';

$_urgHr=3;

$_configs=array(
    'application_name' => 'HELPTIMIZE',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db_name' => 'helptimize', 
    'google_map_api_new' => 'AIzaSyC7Y4opceNAVG8qp53FvFNV3IG7aUHU2GU',
    'google_map_api' => 'AIzaSyAMU6SOKe_BeAfS8hopKSBNlTp5etaAwZA',
    'uploads_dir' => '/var/www/html/all_helptimize/uploads/',
    'google_api_safe' => array(
	'key' => 'AIzaSyAMU6SOKe_BeAfS8hopKSBNlTp5etaAwZA',
    	'url' => 'https://vision.googleapis.com/v1/images:annotate?key=',
    	'adult_limit' => 'LIKELY',
    	'violence_limit' => 'LIKELY',
	'vals' => array(
		'UNKNOWN' => 0,
		'VERY_UNLIKELY' => 1,
		'UNLIKELY' => 2,
		'POSSIBLE' => 3,
		'LIKELY' => 4,
		'VERY_LIKELY' => 5
	)
    ),
    'upload_types' => array(
       'image/png'=>1, 
       'image/jpg'=>1, 
       'image/jpeg'=>1, 
       'image/gif'=>1,
       'image/bmp'=>1
    ),
    'upload_size_limit'=>15728640,
    'upload_resize_prefix'=>'small_',
    'profile_url'=>$_root.'/'.'profile_pictures/',
    'def_prof_pic' => 'helptimizeapp_logo_small.png',
	'private_live_key'=>'',
	'public_live_key'=>'',
	'private_test_key'=>'sk_test_5ZIiXxD7RbgyWP4SIaYdPByc00RkF4AKOe',
	'public_test_key'=>'pk_test_IJWUgzA3RluvFfSNLEnjnEkj00sYAc5CnE',
	'testmode'=>'on'
	
);

return $_configs;

//manual document root for helptimize
$_root='/all_helptimize/helptimize';

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'hhfdj736hdj5sg455637j__826ebd6dbs64567_987754###nxnx';
    $secret_iv = '273hdnckdu__948jsh6356wg^^720-s9*&hgs54hbd7';

    // hash
    $key = hash('sha256', $secret_key);
    $iv = hash('sha256', $secret_iv);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = $decryptedMessage = openssl_decrypt(base64_decode($string), $encrypt_method, $key, $iv);
    }

    return $output;
}



?>
