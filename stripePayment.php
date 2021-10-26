<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set("allow_url_fopen", true);
    header('Content-type: application/json');
    header('Access-Control-Allow-Headers: Content-Type');
    
    require_once('stripe/init.php');
    process();
    function process() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $price = $_GET["price"]*100;
         $token = $_GET["token"];
         $mail = $_GET["email"];

         
         $stripe = array(
             "secret_key" => "sk_test_51Joo56JSls8qJhJThRUSjTeb9K8iisGWXYHLJGGLmt4wlWK5Kh6A8imlzx4cFrPctmAay1OoG65I2qrChi9x1zAO00ffsXIPPt",
             "publishable_key" => "pk_test_51Joo56JSls8qJhJTwC0UTHWBbg8fjxyEgvWSx4oJMrazPXXTlkNPBk7BetLGXe6PYXdeyzMNC2XO4QZQLjfgaFc800KHUDLg9n"
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

  
        
       
     }
    }