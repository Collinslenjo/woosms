<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://collinslenjo.co.nf
 * @since             1.0.0
 * @package           Woosms
 *
 * @wordpress-plugin
 * Plugin Name:       WooSMS
 * Plugin URI:        https://github.com/Collinslenjo/woosms
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Collins Lenjo
 * Author URI:        http://collinslenjo.co.nf
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woosms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woosms-activator.php
 */
function activate_woosms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woosms-activator.php';
	Woosms_Activator::activate();
}
include 'admin/ordersms/sat-wc-order-sms.php';
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woosms-deactivator.php
 */
function deactivate_woosms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woosms-deactivator.php';
	Woosms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woosms' );
register_deactivation_hook( __FILE__, 'deactivate_woosms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woosms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woosms() {

	$plugin = new Woosms();
	$plugin->run();

}
run_woosms();
