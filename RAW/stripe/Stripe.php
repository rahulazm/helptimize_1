<?php

// Tested on PHP 5.2, 5.3

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
  throw new Exception('Stripe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Stripe needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
  throw new Exception('Stripe needs the Multibyte String PHP extension.');
}

// Stripe singleton
require(dirname(__FILE__) . '/Stripe/Stripe.php');

// Utilities
require(dirname(__FILE__) . '/Stripe/Util.php');
require(dirname(__FILE__) . '/Stripe/Util/Set.php');

// Errors
require(dirname(__FILE__) . '/Stripe/Error.php');
require(dirname(__FILE__) . '/Stripe/ApiError.php');
require(dirname(__FILE__) . '/Stripe/ApiConnectionError.php');
require(dirname(__FILE__) . '/Stripe/AuthenticationError.php');
require(dirname(__FILE__) . '/Stripe/CardError.php');
require(dirname(__FILE__) . '/Stripe/InvalidRequestError.php');
require(dirname(__FILE__) . '/Stripe/RateLimitError.php');

// Plumbing
require(dirname(__FILE__) . '/Stripe/Object.php');
require(dirname(__FILE__) . '/Stripe/ApiRequestor.php');
require(dirname(__FILE__) . '/Stripe/ApiResource.php');
require(dirname(__FILE__) . '/Stripe/SingletonApiResource.php');
require(dirname(__FILE__) . '/Stripe/AttachedObject.php');
require(dirname(__FILE__) . '/Stripe/List.php');
require(dirname(__FILE__) . '/Stripe/RequestOptions.php');

// Stripe API Resources
require(dirname(__FILE__) . '/Stripe/Account.php');
require(dirname(__FILE__) . '/Stripe/Card.php');
require(dirname(__FILE__) . '/Stripe/Balance.php');
require(dirname(__FILE__) . '/Stripe/BalanceTransaction.php');
require(dirname(__FILE__) . '/Stripe/Charge.php');
require(dirname(__FILE__) . '/Stripe/Customer.php');
require(dirname(__FILE__) . '/Stripe/FileUpload.php');
require(dirname(__FILE__) . '/Stripe/Invoice.php');
require(dirname(__FILE__) . '/Stripe/InvoiceItem.php');
require(dirname(__FILE__) . '/Stripe/Plan.php');
require(dirname(__FILE__) . '/Stripe/Subscription.php');
require(dirname(__FILE__) . '/Stripe/Token.php');
require(dirname(__FILE__) . '/Stripe/Coupon.php');
require(dirname(__FILE__) . '/Stripe/Event.php');
require(dirname(__FILE__) . '/Stripe/Transfer.php');
require(dirname(__FILE__) . '/Stripe/Recipient.php');
require(dirname(__FILE__) . '/Stripe/Refund.php');
require(dirname(__FILE__) . '/Stripe/ApplicationFee.php');
require(dirname(__FILE__) . '/Stripe/ApplicationFeeRefund.php');
require(dirname(__FILE__) . '/Stripe/BitcoinReceiver.php');
require(dirname(__FILE__) . '/Stripe/BitcoinTransaction.php');

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
