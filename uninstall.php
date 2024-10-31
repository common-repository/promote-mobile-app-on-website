<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @link       https://omnishopapp.com
 * @since      1.0.0
 *
 * @package    Promote_Mobile_App_On_WordPress
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


/*
 * Only remove ALL product and page data if WC_REMOVE_ALL_DATA constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'WC_REMOVE_ALL_DATA' ) && true === WC_REMOVE_ALL_DATA ) {
	

	delete_option('pmaw_ios_appid');
	delete_option('pmaw_android_appid');
	delete_option('pmaw_android_title');
	delete_option('pmaw_android_author');
	delete_option('pmaw_android_icon');
	delete_option('pmaw_android_app_store');
	delete_option('pmaw_android_price');
	delete_option('pmaw_android_button');

	// Clear any cached data that has been removed.
	wp_cache_flush();
}
