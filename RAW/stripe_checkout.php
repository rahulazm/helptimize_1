<?php
session_start();
//print_r($_SESSION);
$configs = include("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");
/**
 * Stripe - Payment Gateway integration example (Stripe Checkout)
 * ==============================================================================
 */
//get users details
 $res=$_sqlObj->query('SELECT email FROM `users` where id='.$_SESSION[id] );
//print( $res[0]['email']);
 
// Stripe library
require 'stripe/Stripe.php';

$params = array(
	"testmode"   => $configs['testmode'],
	"private_live_key" => $configs['private_live_key'],
	"public_live_key"  => $configs['public_live_key'],
	"private_test_key" =>$configs['private_test_key'],
	"public_test_key"  =>$configs['public_test_key']
);

if ($params['testmode'] == "on") {
	Stripe::setApiKey($params['private_test_key']);
	$pubkey = $params['public_test_key'];
} else {
	Stripe::setApiKey($params['private_live_key']);
	$pubkey = $params['public_live_key'];
}

if(isset($_POST['stripeToken']))
{
	$transAmnt =1;
	$amount_cents = str_replace(".","",$transAmnt);  // Chargeble amount
	$invoiceid = "14526321";                      // Invoice ID
	$description = "Invoice #" . $invoiceid . " - " . $invoiceid;

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
		//$res=$_sqlObj->query('');

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
	
	print_r($charge); exit;
}
?>

<div align="center">
  <form action="" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $params['public_test_key']; ?>"
    data-amount="999"
    data-name="Helptimize"
    data-description="Service"
    data-image="img/helptimizeapp_logo_small.png"
    data-locale="auto"
	data-email="<?php echo $res[0]['email'];?>"
    data-zip-code="false">
  </script>
</form>
</div>
<!--
data-label="Proceed to Pay with Card"

-->
