<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://omnishopapp.com
 * @since             1.0.0
 * @package           Promote_Mobile_App_On_Website
 *
 * @wordpress-plugin
 * Plugin Name:       Promote mobile app on Website
 * Plugin URI:        https://omnishopapp.com/wp-plugin
 * Description:       The "Promote mobile app on Website" plugin showcases app banners on mobile devices, effectively promoting your app to visitors accessing your website.
 * Version:           1.0.0
 * Author:            Omnishop Dev Team
 * Author URI:        https://omnishopapp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pmaw
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
define( 'PROMOTE_MOBILE_APP_ON_WEBSITE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-promote-mobile-app-on-woocommerce-activator.php
 */
function pmaw_activate_promote_mobile_app_on_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-promote-mobile-app-on-woocommerce-activator.php';
	Promote_Mobile_App_On_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-promote-mobile-app-on-woocommerce-deactivator.php
 */
function pmaw_deactivate_promote_mobile_app_on_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-promote-mobile-app-on-woocommerce-deactivator.php';
	Promote_Mobile_App_On_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'pmaw_activate_promote_mobile_app_on_woocommerce' );
register_deactivation_hook( __FILE__, 'pmaw_deactivate_promote_mobile_app_on_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-promote-mobile-app-on-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function pmaw_run_promote_mobile_app_on_woocommerce() {

	$plugin = new Promote_Mobile_App_On_Woocommerce();
	$plugin->run();

}
pmaw_run_promote_mobile_app_on_woocommerce();


function pmaw_output_app_banner($post_ID) {

  /* fields/options from admin page in dashboard */
  $ios_app_id = get_option('pmaw_ios_appid');
  $android_app_id = get_option('pmaw_android_appid');
  $android_app_title = get_option('pmaw_android_title');
  $android_app_author = get_option('pmaw_android_author');
  $android_app_icon = get_option('pmaw_android_icon');
  $android_app_app_store = get_option('pmaw_android_app_store');
  $android_app_price = get_option('pmaw_android_price');
  $android_app_button = get_option('pmaw_android_button');

  // if app IDs are not set, exit
  if ((is_null($android_app_id) || $android_app_id == "") && (is_null($ios_app_id) || $ios_app_id == "")) {
      return;
  } else {
      echo '<meta name="apple-itunes-app" content="app-id=' . esc_attr($ios_app_id) .'">';
      echo '<meta name="google-play-app" content="app-id=' . esc_attr($android_app_id) . '">';
  }

  // Enqueue banner-style.css file from the plugin directory
  wp_enqueue_style('banner-style', plugins_url('/banner-style.css', __FILE__), array(), '1.0', 'all');

  // Enqueue android_and_old_ios.js file from the plugin directory
  wp_enqueue_script('android_and_old_ios', plugin_dir_url(__FILE__) . 'android_and_old_ios.js', array(), '1.0', true);

  // passing the input values to js
  $android_app_info = array(
      'title' => $android_app_title,
      'author' => $android_app_author,
      'icon' => $android_app_icon,
      'app_store' => $android_app_app_store,
      'price' => $android_app_price,
      'button' => $android_app_button
  );

  wp_localize_script('android_and_old_ios', 'androidInfo', $android_app_info);

} 
add_action('wp_head', 'pmaw_output_app_banner');



// Admin menu
function pmaw_admin_menu() {
	add_options_page( __('Promote Mobile App On Website Settings', 'pmaw'),
					  __('Promote Mobile App', 'pmaw'),
					  'manage_options',
					  'pmaw-options-page',
					  'pmaw_options' );
}

function pmaw_options() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $hidden_field_name = 'pmaw_submit_hidden';
	  $ios_appid_field_name = 'pmaw_ios_appid';
    $android_appid_field_name = 'pmaw_android_appid';
    $android_title_field_name = 'pmaw_android_title';
	  $android_author_field_name = 'pmaw_android_author';
    $android_icon_field_name = 'pmaw_android_icon';
    $android_app_store_field_name = 'pmaw_android_app_store';
    $android_price_field_name = 'pmaw_android_price';
    $android_button_field_name = 'pmaw_android_button';
    
    // Read in existing option value from database
	  $ios_appid_val = get_option( $ios_appid_field_name );
    $android_appid_val = get_option( $android_appid_field_name );
    $android_title_val = get_option( $android_title_field_name );
    $android_author_val = get_option( $android_author_field_name );
	  $android_icon_val = get_option( $android_icon_field_name );
    $android_app_store_val = get_option( $android_app_store_field_name );
    $android_price_val = get_option( $android_price_field_name );
    $android_button_val = get_option( $android_button_field_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {

      if (!isset($_POST['pmaw-update']) || !wp_verify_nonce(sanitize_text_field($_POST['pmaw-update']),'pmaw-update')) {
        die("<br><br>Invalid update");    
      }

    elseif (isset($_POST['changeApp'])) {

      // Read their posted value
      $ios_appid_val = sanitize_text_field( $_POST[ $ios_appid_field_name ] );
      $android_appid_val = sanitize_text_field( $_POST[ $android_appid_field_name ] );
      $android_title_val = sanitize_text_field( $_POST[ $android_title_field_name ] );
      $android_author_val = sanitize_text_field( $_POST[ $android_author_field_name ] );
      $android_icon_val = sanitize_text_field( $_POST[ $android_icon_field_name ] );
      $android_app_store_val = sanitize_text_field( $_POST[ $android_app_store_field_name ] );
      $android_price_val = sanitize_text_field( $_POST[ $android_price_field_name ] );
      $android_button_val = sanitize_text_field( $_POST[ $android_button_field_name ] );

      // Save the posted value in the database
      update_option( $ios_appid_field_name, $ios_appid_val );
      update_option( $android_appid_field_name, $android_appid_val );
      update_option( $android_title_field_name, $android_title_val );
      update_option( $android_author_field_name, $android_author_val );
      update_option( $android_icon_field_name, $android_icon_val );
      update_option( $android_app_store_field_name, $android_app_store_val );
      update_option( $android_price_field_name, $android_price_val );
      update_option( $android_button_field_name, $android_button_val );
    }
  }

?>

<!-- Settings interface fields in wp dashboard -->
<div class="wrap">
<h2><?php esc_html_e( 'Promote Mobile App On Website', 'pmaw' ) ?></h2>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo esc_attr($hidden_field_name); ?>" value="Y">
<?php wp_nonce_field('pmaw-update', 'pmaw-update'); ?>
<p style="margin-bottom: 40px;"><?php esc_html_e('(Leave blank if no banner is required.)', 'pmaw'); ?></p>

<table class="ios-table" style="margin-top: 40px;">
  
  <tr>
    <td><h2><?php esc_html_e('iOS Banner Settings', 'pmaw') ?></h2></td>
  </tr>

  <tr>
    <td><?php esc_html_e('iOS App ID:','pmaw'); ?></td>
    <td><input type="text" placeholder="123456789" name="<?php echo esc_attr($ios_appid_field_name); ?>" value="<?php echo esc_attr($ios_appid_val); ?>" /></td>
  </tr>

</table>

<table class="android-table" style="margin-top: 40px;">

  <tr style="display:flex; flex-direction: column; margin-bottom: 100px">
    <td><h2><?php esc_html_e('Android Banner Settings', 'pmaw') ?></h2></td>
    <td><img style="position: absolute;" src="<?php echo esc_attr(plugin_dir_url( __FILE__ )) . 'images/banner-example.png'; ?>" alt="banner-example"></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Android App ID','pmaw'); ?></td>
    <td><input type="text" placeholder="com.google.android.youtube" name="<?php echo esc_attr($android_appid_field_name); ?>" value="<?php echo esc_attr($android_appid_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Android Title','pmaw'); ?></td>
    <td><input type="text" placeholder="YouTube" name="<?php echo esc_attr($android_title_field_name); ?>" value="<?php echo esc_attr($android_title_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Android Author','pmaw'); ?></td>
    <td><input type="text" placeholder="Google LLC" name="<?php echo esc_attr($android_author_field_name); ?>" value="<?php echo esc_attr($android_author_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Android Icon (URL) W: 60px H:60px','pmaw'); ?></td>
    <td><input type="text" name="<?php echo esc_attr($android_icon_field_name); ?>" value="<?php echo esc_attr($android_icon_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('App Store','pmaw'); ?></td>
    <td><input type="text" placeholder="In Google Play" name="<?php echo esc_attr($android_app_store_field_name); ?>" value="<?php echo esc_attr($android_app_store_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Price','pmaw'); ?></td>
    <td><input type="text" placeholder="FREE" name="<?php echo esc_attr($android_price_field_name); ?>" value="<?php echo esc_attr($android_price_val); ?>" /></td>
  </tr>

  <tr>
    <td><?php esc_html_e('Button','pmaw'); ?></td>
    <td><input type="text" placeholder="View" name="<?php echo esc_attr($android_button_field_name); ?>" value="<?php echo esc_attr($android_button_val); ?>" /></td>
  </tr>

</table>


<p class="submit">
<input type="submit" name="changeApp" class="button-primary" value="<?php esc_html_e('Save Changes') ?>" />

<?php if (isset($_POST['changeApp'])) : ?>
  <div class="notice notice-success is-dismissible"> 
    <p><strong>Settings saved.</strong></p>
  </div>
<?php endif; ?>
</p>

<?php

}
add_action('admin_menu', 'pmaw_admin_menu');


?>
