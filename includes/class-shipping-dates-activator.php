<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.alexandregaboriau.fr/en/
 * @since      1.0.0
 *
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/includes
 * @author     Alexandre Gaboriau <contact@alexandregaboriau.fr>
 */
class Shipping_Dates_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            if ( !wp_next_scheduled ( 'shipping_dates_event' ) ) {
                wp_schedule_event( time(), 'hourly', 'shipping_dates_event' );
            }
	}

}
