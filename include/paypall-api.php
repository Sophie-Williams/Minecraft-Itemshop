<?php
//Do przeróbki




/*$amount,
  $email,
  $ipnlink,
  $walut (PLN...),
  $api_user,
  $api_password,
  
  
  
  


*/

$payRequest = new PayRequest();

$receiver = array();
$receiver[0] = new Receiver();
$receiver[0]->amount = $amount;
$receiver[0]->email = $email;
$receiverList = new ReceiverList($receiver);
$payRequest->receiverList = $receiverList;

$requestEnvelope = new RequestEnvelope("pl_PL");
$payRequest->requestEnvelope = $requestEnvelope; 
$payRequest->actionType = "PAY";
$payRequest->cancelUrl = "https://devtools-paypal.com/guide/ap_simple_payment/php?cancel=true";
$payRequest->returnUrl = "https://devtools-paypal.com/guide/ap_simple_payment/php?success=true";
$payRequest->currencyCode = $walut;
$payRequest->ipnNotificationUrl = $ipnlink;

$sdkConfig = array(
	"mode" => "live",
	"acct1.UserName" => $api_user,
	"acct1.Password" => $api_password,
	"acct1.Signature" => "{API_SIGNATURE}",
	"acct1.AppId" => "APP-80W284485P519543T"
);

$adaptivePaymentsService = new AdaptivePaymentsService($sdkConfig);
$payResponse = $adaptivePaymentsService->Pay($payRequest);





?>
