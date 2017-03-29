<?php

/**
 * SMS Gateway handler class
 *
 * @author satosms
 */
class SatSMS_SMS_Gateways {

    private static $_instance;

    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new SatSMS_SMS_Gateways();
        }

        return self::$_instance;
    }
/**
 * Sends SMS via AfricasTalking api
 *
 * @param type $sms_data
 * @return boolean
 */

function AfricasTalking( $sms_data ) {

$response = false;
$username = satosms_get_option( 'africastalking_name', 'satosms_gateway' );
$password = satosms_get_option( 'africastalking_password', 'satosms_gateway' );
$apikey = satosms_get_option( 'africastalking_api', 'satosms_gateway' );
$phone = str_replace( '+', '', $sms_data['number'] );
$text =  $sms_data['sms_body'] ;
//bail out if nothing provided
if ( empty( $username ) || empty( $password ) || empty( $apikey ) ) {
return $response;
}

   if (!empty($phone) && !empty($text)) {
$recipients = $phone;
$message    = $text;
$gateway    = new AfricasTalkingGateway($username, $apikey);
try {
  $results = $gateway->sendMessage($recipients, $message);
  foreach($results as $result) {
    echo "Your Message was sent successfully";
    echo " Number: " .$result->number;
    echo " Status: " .$result->status;
    echo " MessageId: " .$result->messageId;
    echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}

} else{
    echo "Fill all the fields.";
}


    }

}
