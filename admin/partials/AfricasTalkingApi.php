<?php
require_once('AfricasTalkingGateway.php');
$username = satosms_get_option( 'africastalking_name', 'satosms_gateway', '' );
$apikey = satosms_get_option( 'africastalking_api', 'satosms_gateway', '' );
if (isset($_POST['number']) && isset($_POST['text'])){$Err = $results;} else {$Err = "";}
if (!empty($_POST['number']) || !empty($_POST['text'])) {
$recipients = $_POST['number'];
$message    = $_POST['text'];
$gateway    = new AfricasTalkingGateway($username, $apikey);
// Any gateway error will be captured by our custom Exception class below,
// so wrap the call in a try-catch block
try
{
  // Thats it, hit send and we'll take care of the rest.
  $results = $gateway->sendMessage($recipients, $message);

  foreach($results as $result) {
    // status is either "Success" or "error message"
    $echo = "Your Message was sent successfully"." Number: " .$result->number ." Status: " .$result->status ." MessageId: " .$result->messageId ."Cost: " .$result->cost."\n";
    //echo " Number: " .$result->number;
    //echo " Status: " .$result->status;
    //echo " MessageId: " .$result->messageId;
    //echo " Cost: "   .$result->cost."\n";
  }

}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}

    $Err = $echo;

} else{
    $Err = "All fields are required";
}

// DONE!!!
