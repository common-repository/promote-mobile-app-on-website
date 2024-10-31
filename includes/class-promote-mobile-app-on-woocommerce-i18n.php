<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://omnishopapp.com
 * @since      1.0.0
 *
 * @package    Promote_Mobile_App_On_WordPress
 * @subpackage Promote_Mobile_App_On_WordPress/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Promote_Mobile_App_On_WordPress
 * @subpackage Promote_Mobile_App_On_WordPress/includes
 * @author     Byteout Software <dusan@byteout.com>
 */
class Promote_Mobile_App_On_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'promote-mobile-app-on-website',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
