<?php
    header('Content-type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    require_once('stripe/init.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $postdata = file_get_contents("php://input");
         $request = json_decode($postdata);
         $token = $request->token;
         $mail = $request->email;
         $price = (intval($request->price));

         $stripe = array(
             "secret_key" => "your_secret_key_here",
             "publishable_key" => "your_publishable_key_here"
         );
         
         \Stripe\Stripe::setApiKey($stripe['secret_key']);
 
         $customer = \Stripe\Customer::create(array(
             'email' =>  $mail,
             'source' => $token
         ));

         $charge = \Stripe\Charge::create(array(
             'customer' => $customer->id,
             'amount' => $price,
             'currency' => 'cad'
         ));

         json_encode("Success!");
     }