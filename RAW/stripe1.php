<?php
require_once('stripe-php/init.php');

function Stripe(){
    Stripe\Stripe::setApiKey('sk_test_5ZIiXxD7RbgyWP4SIaYdPByc00RkF4AKOe');
    try {
        // first create bank token
        $bankToken = \Stripe\Token::create([
            'bank_account' => [
                'country' => 'GB',
                'currency' => 'GBP',
                'account_holder_name' => 'Soura Sankar',
                'account_holder_type' => 'individual',
                'routing_number' => '108800',
                'account_number' => '00012345'
            ]
        ]); 
        // second create stripe account
        $stripeAccount = \Stripe\Account::create([
            "type" => "custom",
            "country" => "GB",
            "email" => "rsinha108@gmail.com"
            //"requested_capabilities" => ["card_payments", "transfers"]   
            /**"business_type" => "individual",
            "individual" => [
                'address' => [
                    'city' => 'London',
                    'line1' => '16a, Little London, Milton Keynes, MK19 6HT ',
                    'postal_code' => 'MK19 6HT',            
                ],
                'dob'=>[
                    "day" => '25',
                    "month" => '02',
                    "year" => '1994'
                ],
                "email" => 'rsinha108@gmail.com',
                "first_name" => 'Soura',
                "last_name" => 'Ghosh',
                "gender" => 'male',
                "phone"=> "(555) 555-1234"
                **/
                
        ]);
        // third link the bank account with the stripe account
        $bankAccount = \Stripe\Account::createExternalAccount(
          $stripeAccount->id,['external_account' => $bankToken->id]
        );
        // Fourth stripe account update for tos acceptance
        \Stripe\Account::update(
            $stripeAccount->id,[
            'tos_acceptance' => [
                  'date' => time(),
                  'ip' => $_SERVER['REMOTE_ADDR'] // Assumes you're not using a proxy
                ],
            ]
        );
        $response = ["bankToken"=>$bankToken->id,"stripeAccount"=>$stripeAccount->id,"bankAccount"=>$bankAccount->id];
        print_r($response);
        $amount = 1000;  // amount in cents
        $application_fee = intval($amount * 0.2);  // 20% of the amount

        $charge = \Stripe\Charge::create(array(
            "amount" => $amount,
            "currency" => "usd",
            "source" => $bankToken->id,
            "destination" => $stripeAccount->id,
            "application_fee" => $application_fee,
        ));

        print_r($charge);




    } catch (\Exception $e) {
       echo($e->jsonBody['error']['message']);
    }
}

$res = Stripe();
//print_r($res);
?>