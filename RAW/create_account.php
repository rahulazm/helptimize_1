<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$firstname = $_POST["firstname"];
$familyname = $_POST["familyname"];
$customer_username = $_POST["customer_username"];
$customer_email = $_POST["customer_email"];
$customer_mobile = $_POST["customer_mobile"];
$customer_password = $_POST["customer_password"];
$company_name = $_POST["company_name"];
$guard_username = $_POST["guard_username"];
$dob = $_POST["dob"];

$contact_name = $firstname . " " . $familyname;


$customer_password = encrypt_decrypt('encrypt', $customer_password);

function crypto_rand_super_secure($min, $max)
{
    $account_id_range = $max - $min;
    if ($account_id_range < 1) return $min; 
    $log_safe = ceil(log($account_id_range, 2));
    $bytes_down = (int) ($log_safe / 8) + 1; 
    $bits_sec = (int) $log_safe + 1; 
    $filter_help = (int) (1 << $bits_sec) - 1; 
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes_down)));
        $rnd = $rnd & $filter_help; 
    } while ($rnd > $account_id_range);
    return $min + $rnd;
}

function get_save_Token($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_super_secure(0, $max-1)];
    }

    return $token;
}

$account_id = get_save_Token("10");


$activation_code = mt_rand(100000,999999);

// remove + from the phone number

$customer_mobile = str_replace("+","",$customer_mobile);

$db_insert_account = new mysqli("$host", "$username", "$password", "$db_name");

if($db_insert_account->connect_errno > 0){
    die('Unable to connect to database [' . $db_insert_account->connect_error . ']');
}

$sql_check_username = "SELECT * FROM users WHERE username='" . $guard_username . "'";
  $result_username = $db_insert_account->query($sql_check_username); 
  $check_username = $result_username->fetch_assoc();
  $guardId = $check_username['id'];

if($guard_username != ""){
    $account_status = 2;
}else{
    $account_status = 1;
}


$sql_insert_account = "INSERT INTO users (externId,username,firstName,surName,email,phone,password,validCode,company,verified,status,dob,guardId) VALUES ('". $account_id ."','". $customer_username ."','". $firstname ."','". $familyname ."','". $customer_email ."','". $customer_mobile ."','". $customer_password ."','". $activation_code ."','". $company_name ."','1','".$account_status."','".$dob."','".$guardId."')";

if(!$result_insert_payment = $db_insert_account->query($sql_insert_account)){
    die('There was an error running the query [' . $db_insert_account->error . ']');
}

$new_id = $db_insert_account->insert_id;

$db_insert_account->close();


// create ZOHO contact information
/*
$data = array(
    'contact_name'=> $contact_name,
    'company_name'=> $company_name,
    'is_primary_contact' => true
    
);

$data = json_encode($data);



$data = array(
        'authtoken'   => '50e58b3118cacc9cabd7986fb72d93b0',
        'JSONString'   => $data,
         "organization_id"  => '648838133',
        "send"                  => 'false'
);


$url = "https://invoice.zoho.com/api/v3/contacts";
 
 				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
 				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded") );
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 		
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);
 				
 				print_r($output);
 				
 				$array = json_decode($output,TRUE);
			
				$contact_id = $array['contact']['contact_id'];
				

$data = array(
    'contact_id'=> $contact_id,
    'first_name'=> $firstname,
    'last_name'=> $familyname,
    'email'=> $customer_email

);

$data = json_encode($data);

print_r($data);


$data = array(
        'authtoken'   => '50e58b3118cacc9cabd7986fb72d93b0',
        'JSONString'   => $data,
         "organization_id"  => '648838133',
        "send"                  => 'false'
);


$url = "https://invoice.zoho.com/api/v3/contacts/contactpersons";
 
 				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				curl_setopt($ch, CURLOPT_POST, true);
 				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded") );
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 		
 				$output = curl_exec($ch);
 				$info = curl_getinfo($ch);
 				curl_close($ch);
				
			

// send activation code

		
		
		$message = "HELPTIMIZE-ACTIVATION CODE. Your activation code is: " .  $activation_code;
		
		
		$url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
    		[
      			'api_key' =>  '3e7b6a67',
      			'api_secret' => '374e4b9450c8b4eb',
      			'to' => $customer_mobile,
      			'from' => '19252337224',
      			'text' => $message
    		]
		);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);*/
		
		
echo $new_id;	



?>