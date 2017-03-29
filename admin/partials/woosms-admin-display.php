<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://collinslenjo.co.nf
 * @since      1.0.0
 *
 * @package    Woosms
 * @subpackage Woosms/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<style type="text/css">
.login-page {
  width: 450px;
  padding: 4% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form textarea {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
  height: 140px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
.error{color: orange;}
</style>
<?php
require_once 'AfricasTalkingApi.php';
//Top statement
$africastalking_helper = sprintf( 'Fill the form below to send a message to the receipent <br/>Please fill in the  <a href="%s">%s</a> before using this form', 'admin.php?page=sat-order-sms-notification-settings', 'settings');
//Logic to send sms from this page
$africastalking_name         = satosms_get_option( 'africastalking_name', 'satosms_gateway', '' );
$africastalking_password     = satosms_get_option( 'africastalking_password', 'satosms_gateway', '' );
$africastalking_api          = satosms_get_option( 'africastalking_api', 'satosms_gateway', '' );
?>
<p style="text-align:center;margin-top:15px; padding: 5px; font-style: italic; font-size: 14px;">
       <strong><?php _e( $africastalking_helper, 'satosms' ); ?></strong>
  </p>
<div class="login-page">
  <div class="form">
  <span class="error"><?php echo $Err; ?></span>
    <form class="login-form" method="POST">
      <input type="text" placeholder="Recepient phone number" name='number'/>
      <textarea  placeholder="Enter Your message" name='text'></textarea>
      <button type="submit">Send</button>
    </form>
  </div>
</div>