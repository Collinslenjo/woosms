<?php
/**
 * WordPress settings API class
 *
 * @author Tareq Hasan
 */

class SatSMS_Setting_Options {

    private $settings_api;

    function __construct() {

        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    /**
     * Admin init hook
     * @return void
     */
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Admin Menu CB
     * @return void
     */
     function admin_menu() {
        //create a submenu under the plugin main display
        add_submenu_page('WooSMS', __( 'Settings', 'satosms' ), __( 'Settings', 'satosms' ), 'manage_options', 'sat-order-sms-notification-settings', array( $this, 'plugin_page' ), 'dashicons-email-alt' );
     }


    /**
     * Get All settings Field
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'satosms_general',
                'title' => __( 'General Settings', 'satosms' )
            ),
            array(
                'id' => 'satosms_gateway',
                'title' => __( 'SMS Gateway Settings', 'satosms' )
            ),

            array(
                'id' => 'satosms_message',
                'title' => __( 'SMS Settings', 'satosms' )
            )
        );
        return apply_filters( 'satosms_settings_sections' , $sections );
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {


        $buyer_message = "Thanks for purchasing\nYour [order_id] is now [order_status]\nThank you";
        $admin_message = "You have a new Order\nThe [order_id] is now [order_status]\n";
        $settings_fields = array(

            'satosms_general' => apply_filters( 'satosms_general_settings', array(
                array(
                    'name' => 'enable_notification',
                    'label' => __( 'Enable SMS Notifications', 'satosms' ),
                    'desc' => __( 'If checked then enable your sms notification for new order', 'satosms' ),
                    'type' => 'checkbox',
                ),

                array(
                    'name' => 'admin_notification',
                    'label' => __( 'Enable Admin Notifications', 'satosms' ),
                    'desc' => __( 'If checked then enable admin sms notification for new order', 'satosms' ),
                    'type' => 'checkbox',
                    'default' => 'on'
                ),

                array(
                    'name' => 'buyer_notification',
                    'label' => __( 'Enable buyer Notification', 'satosms' ),
                    'desc' => __( 'If checked then buyer can get notification options in checkout page', 'satosms' ),
                    'type' => 'checkbox',
                ),

                array(
                    'name' => 'force_buyer_notification',
                    'label' => __( 'Force buyer notification', 'satosms' ),
                    'desc' => __( 'If select yes then buyer notification option must be required in checkout page', 'satosms' ),
                    'type' => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'   => 'No'
                    )
                ),

                array(
                    'name' => 'buyer_notification_text',
                    'label' => __( 'Buyer Notification Text', 'satosms' ),
                    'desc' => __( 'Enter your text which is appeared in checkout page for buyer as a checkbox', 'satosms' ),
                    'type' => 'textarea',
                    'default' => 'Send me order status notifications via sms (N.B.: Your SMS will be send in your billing email. Make sere phone number must have an extension)'
                ),
                array(
                    'name' => 'order_status',
                    'label' => __( 'Check Order Status ', 'satosms' ),
                    'desc' => __( 'In which status you will send notifications', 'satosms' ),
                    'type' => 'multicheck',
                    'options' => array(
                        'on-hold' => __( 'On Hold', 'satosms' ),
                        'pending'  => __( 'Pending', 'satosms' ),
                        'processing'  => __( 'Processing', 'satosms' ),
                        'completed'  => __( 'Completed', 'satosms' ),
                    )
                )
            ) ),

            'satosms_gateway' => apply_filters( 'satosms_gateway_settings',  array(
                array(
                    'name' => 'sms_gateway',
                    'label' => __( 'Select your Gateway', 'satosms' ),
                    'desc' => __( 'Select your sms gateway', 'satosms' ),
                    'type' => 'select',
                    'default' => '-1',
                    'options' => $this->get_sms_gateway()
                ),
            ) ),

            'satosms_message' => apply_filters( 'satosms_message_settings',  array(
                array(
                    'name' => 'sms_admin_phone',
                    'label' => __( 'Enter your Phone Number with extension', 'satosms' ),
                    'desc' => __( '<br>Admin order sms notifications will be send in this number. Please make sure that the number must have a extension (e.g.: +2547088768 where +254 will be extension)', 'satosms' ),
                    'type' => 'text'
                ),
                array(
                    'name' => 'admin_sms_body',
                    'label' => __( 'Enter your SMS body', 'satosms' ),
                    'desc' => __( ' Write your custom message. When an order is create then you get this type of format message. For order id just insert <code>[order_id]</code> and for order status insert <code>[order_status]</code>', 'satosms' ),
                    'type' => 'textarea',
                    'default' => __( $admin_message, 'satosms' )
                ),

                array(
                    'name' => 'sms_body',
                    'label' => __( 'Enter buyer SMS body', 'satosms' ),
                    'desc' => __( ' Write your custom message. If enbale buyer notification options then buyer can get this message in this format. For order id just insert <code>[order_id]</code> and for order status insert <code>[order_status]</code>', 'satosms' ),
                    'type' => 'textarea',
                    'default' => __( $buyer_message, 'satosms' )
                ),
            ) ),
        );

        return apply_filters( 'satosms_settings_
            section_content', $settings_fields );
    }

    /**
     * Loaded Plugin page
     * @return void
     */
    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

    /**
     * Get sms Gateway settings
     * @return array
     */
    function get_sms_gateway() {
        $gateway = array(
            'none'      => __( '--Select--', 'satosms' ),
            'AfricasTalking' => __( 'AfricasTalking', 'satosms' ),
        );

        return apply_filters( 'satosms_sms_gateway', $gateway );
    }

} // End of SatSMS_Setting_Options Class

/**
 * SMS Gateway Settings Extra panel options
 * @return void
 */
function satosms_settings_field_gateway() {


    $africastalking_name         = satosms_get_option( 'africastalking_name', 'satosms_gateway', '' );
    $africastalking_password     = satosms_get_option( 'africastalking_password', 'satosms_gateway', '' );
    $africastalking_api          = satosms_get_option( 'africastalking_api', 'satosms_gateway', '' );

    $africastalking_helper = sprintf( 'Please fill Africas Talking informations. If not then visit <a href="%s" target="_blank">%s</a> and get your informations', 'https://account.africastalking.com/login', 'AfricasTalking');

    ?>

    <?php do_action( 'satosms_gateway_settings_options_before' ); ?>

<div class="AfricasTalking_wrapper hide_class">
   <hr>
   <p style="margin-top:15px; margin-bottom:0px; padding-left: 20px; font-style: italic; font-size: 14px;">
       <strong><?php _e( $africastalking_helper, 'satosms' ); ?></strong>
  </p>
   <table class="form-table">
       <tr valign="top">
           <th scrope="row"><?php _e( 'Africastalking name', 'satosms' ) ?></th>
           <td>
               <input type="text" name="satosms_gateway[africastalking_name]" id="satosms_gateway[africastalking_name]" value="<?php echo $africastalking_name; ?>">
               <span><?php _e( 'africastalking Username', 'satosms' ); ?></span>
           </td>
       </tr>

       <tr valign="top">
           <th scrope="row"><?php _e( 'africastalking Password', 'satosms' ) ?></th>
           <td>
               <input type="password" name="satosms_gateway[africastalking_password]" id="satosms_gateway[africastalking_password]" value="<?php echo $africastalking_password; ?>">
               <span><?php _e( 'africastalking password', 'satosms' ); ?></span>
           </td>
       </tr>

       <tr valign="top">
           <th scrope="row"><?php _e( 'africastalking api', 'satosms' ) ?></th>
           <td>
               <input type="text" name="satosms_gateway[africastalking_api]" id="satosms_gateway[africastalking_api]" value="<?php echo $africastalking_api; ?>">
               <span><?php _e( 'africastalking API id', 'satosms' ); ?></span>
           </td>
       </tr>
   </table>
</div>

    <?php do_action( 'satosms_gateway_settings_options_after' ) ?>
    <?php
}

// hook for Settings API for adding extra sections
add_action( 'wsa_form_bottom_satosms_gateway', 'satosms_settings_field_gateway' );
