<?php
session_start();
$configs = require_once("/etc/helptimize/conf.php");
//require_once("./common.inc.php");
require_once("./mysql_lib.php");
require_once 'stripe/Stripe.php';
print("<pre>");
//print_r($_POST);
//exit;

//replace with actual data
$_POST['transAmnt'] = "10.88";
$_POST['invoiceid'] = "108";
$_POST['description'] = "SOME desc";

if(isset($_POST['stripeToken']))
{
	//transAmnt
	$amount_cents = str_replace(".","",$_POST['transAmnt']);  // Chargeble amount
	$invoiceid = $_POST['invoiceid']; 
	$description=$_POST['description'];
	//$description = "Invoice #" . $invoiceid . " - " . $invoiceid;
   
	try {
		$charge = Stripe_Charge::create(array(		 
			  "amount" => $amount_cents,
			  "currency" => "usd",
			  "source" => $_POST['stripeToken'],
			  "description" => $description)			  
		);

		if ($charge->card->address_zip_check == "fail") {
			throw new Exception("zip_check_invalid");
		} else if ($charge->card->address_line1_check == "fail") {
			throw new Exception("address_check_invalid");
		} else if ($charge->card->cvc_check == "fail") {
			throw new Exception("cvc_check_invalid");
		}
		// Payment has succeeded, no exceptions were thrown or otherwise caught				

		$result = "success";
		$email=$charge->name;
		$item_number=$charge->id;
		$amount_cents=$charge->amount;
		$amount = number_format(($amount_cents /100), 2, '.', ' ');
		$currency_code=$charge->currency;
		$txn_id=$charge->balance_transaction;
		$payment_status=$result;
		$payment_response=$charge->status;
		//$create_at=date("m/d/y H:i:s A");

		$res=$_sqlObj->query("INSERT INTO `stripe_payment` (`id`, `email`, `item_number`, `amount`, `currency_code`, `txn_id`, `payment_status`, `payment_response`, `create_at`) VALUES (NULL, '$email', '$item_number', '$amount', '$currency_code', '$txn_id', '$payment_status', '$payment_response', CURRENT_TIMESTAMP);");


	} catch(Stripe_CardError $e) {			

	$error = $e->getMessage();
		$result = "declined";

	} catch (Stripe_InvalidRequestError $e) {
		$result = "declined";		  
	} catch (Stripe_AuthenticationError $e) {
		$result = "declined";
	} catch (Stripe_ApiConnectionError $e) {
		$result = "declined";
	} catch (Stripe_Error $e) {
		$result = "declined";
	} catch (Exception $e) {

		if ($e->getMessage() == "zip_check_invalid") {
			$result = "declined";
		} else if ($e->getMessage() == "address_check_invalid") {
			$result = "declined";
		} else if ($e->getMessage() == "cvc_check_invalid") {
			$result = "declined";
		} else {
			$result = "declined";
		}		  
	}
	
	echo "<BR>Stripe Payment Status : ".$result;
	
	echo "<BR>Stripe Response : ";
	
	print_r($charge); 
	exit;
}

?>