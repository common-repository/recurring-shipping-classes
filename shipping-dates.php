<?php
/**
 * @link              http://www.alexandregaboriau.fr/en/
 * @since             1.0.0
 * @package           Shipping_Dates
 *
 * @wordpress-plugin
 * Plugin Name:       Recurring Shipping Classes
 * Description:       This plugin works with WooCommerce. It allows you to change shipping classes dynamically.
 * Version:           1.0.0
 * Author:            Alexandre Gaboriau
 * Author URI:        http://www.alexandregaboriau.fr/en/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shipping-dates
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SHIPPING_DATES_VERSION', '1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shipping-dates-activator.php
 */
function activate_shipping_dates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-dates-activator.php';
	Shipping_Dates_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shipping-dates-deactivator.php
 */
function deactivate_shipping_dates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-dates-deactivator.php';
	Shipping_Dates_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_shipping_dates' );
register_deactivation_hook( __FILE__, 'deactivate_shipping_dates' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shipping-dates.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shipping_dates() {

	$plugin = new Shipping_Dates();
	$plugin->run();

}

// Check WooCommerce plugin
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    run_shipping_dates();
}