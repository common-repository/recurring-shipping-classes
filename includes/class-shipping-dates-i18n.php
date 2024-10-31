<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.alexandregaboriau.fr/en/
 * @since      1.0.0
 *
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/includes
 * @author     Alexandre Gaboriau <contact@alexandregaboriau.fr>
 */
class Shipping_Dates_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'shipping-dates',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
