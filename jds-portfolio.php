<?php
/**
 * Plugin Name: JDs Portfolio
 * Plugin URI: https://wordpress.org/plugins/jds-portfolio/
 * Description: JDs Portfolio Plugin enables you to Add a projects detailed and produce portfolio page to display information of past  Projects, Use [JDs_portfolio] shortcode for display portfolio.
 * Version: 2.1.5
 * Author: JayDeep Nimavat
 * Author URI: https://profiles.wordpress.org/jaydeep-nimavat
 * License: GPLv2 or later
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'jds_fs' ) ) {
    // Create a helper function for easy SDK access.
    function jds_fs() {
        global $jds_fs;

        if ( ! isset( $jds_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $jds_fs = fs_dynamic_init( array(
                'id'                  => '3643',
                'slug'                => 'jds-portfolio',
                'type'                => 'plugin',
                'public_key'          => 'pk_0a3a5d124e6f8d497081020ce5b31',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'edit.php?post_type=jdsportfolio',
                    'account'        => false,
                    'contact'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $jds_fs;
    }

    // Init Freemius.
    jds_fs();
    // Signal that SDK was initiated.
    do_action( 'jds_fs_loaded' );
}

/**
 * Basic plugin definitions 
 * 
 * @package JDs Portfolio
 * @since 2.0.0
 */
global $wpdb;

if( !defined( 'WP_JDS_VERSION' ) ) {
	define( 'WP_JDS_VERSION', '2.1.5' ); // plugin dir
}
if( !defined( 'WP_JDS_DIR' ) ) {
	define( 'WP_JDS_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WP_JDS_URL' ) ) {
	define( 'WP_JDS_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'WP_JDS_ADMIN_DIR' ) ) {
	define( 'WP_JDS_ADMIN_DIR', WP_JDS_DIR . '/includes/admin' ); // plugin admin dir
}
if( !defined( 'WP_JDS_POST_TYPE' ) ) {
	define( 'WP_JDS_POST_TYPE', 'jdsportfolio' ); // follow post custom post type's slug
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
load_plugin_textdomain( 'wpjdsp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
register_activation_hook( __FILE__, 'wp_jds_install' );

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
register_deactivation_hook( __FILE__, 'wp_jds_uninstall');

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup,
 * stest default values for the plugin options.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
function wp_jds_install() {
	
	global $wpdb;

	//get all options of settings
	$wp_jds_options = get_option( 'wp_jds_options' );

	if ( empty($wp_jds_options) ) {
		
		$wp_jds_options = array(
			'column'			=> 'col-md-4',
			'width'				=> '',
			'height'			=> '',
			'animation'			=> 'slide',
			'layer_bg_color'	=> 'green'
		);

		// Update options
		update_option( 'wp_jds_options', $wp_jds_options );
		update_option( 'wp_jds_set_option', '2.0.1' );
	}

	//get all options of settings
	$wp_jds_options = get_option( 'wp_jds_options' );

	$wpw_fp_set_option = get_option( 'wp_jds_set_option' );
	if( $wpw_fp_set_option == '2.0.1' ) {

		$wp_jds_options['bootstrap'] = '1';

		// update options
		update_option( 'wp_jds_options', $wp_jds_options );
		update_option( 'wp_jds_set_option', '2.1.1' );
	}

	//get all options of settings
	$wp_jds_options = get_option( 'wp_jds_options' );

	$wpw_fp_set_option = get_option( 'wp_jds_set_option' );
	if( $wpw_fp_set_option == '2.1.1' ) {

		// future code
	}
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Delete  plugin options.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
function wp_jds_uninstall() {

	global $wpdb;
	
	//IMP Call of Function
	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
	
	//get all options of settings
	$wp_jds_options = get_option( 'wp_jds_options' );
}

/**
 * Add Plugin row action help links
 */
add_filter( 'plugin_action_links', 'wp_jds_manage_plugin_row_action_urls', 10, 2 );
function wp_jds_manage_plugin_row_action_urls( $actions, $file ) {
	if( strpos( $file, 'jds-portfolio.php' ) !== false ) {
		
		$url = add_query_arg( array(
			'post_type' => 'jdsportfolio',
			'page' => 'jds-settings'
		), admin_url('edit.php') );

		$new_actions = array( 'settings' => '<a href="'.$url.'">'.esc_html( 'Settings' ).'</a>' );
		$actions = array_merge( $new_actions, $actions );
	}
	return $actions;
}

//global variables
global $wp_jds_model, $wp_jds_public, $wp_jds_admin,
		$wp_jds_script, $wp_jds_options,
		$wp_jds_message, $wp_jds_shortcode;

$wp_jds_options = get_option( 'wp_jds_options' );

// Include widget files
include_once( WP_JDS_DIR . '/includes/widgets/class-wp-jds-recent-portfolio-widget.php' );

//Register Post Types
require_once( WP_JDS_DIR . '/includes/wp-jds-post-types.php' );

//Script Class to add styles and scripts to admin and public side
require_once( WP_JDS_DIR . '/includes/class-wp-jds-scripts.php' );
$wp_jds_script = new Wp_Jds_Scripts();
$wp_jds_script->add_hooks();

//Model class handles most of functionalities related Data in plugin
require_once( WP_JDS_DIR . '/includes/class-wp-jds-model.php' );
$wp_jds_model = new Wp_Jds_Model();

//Shortcodes class for handling shortcodes
require_once( WP_JDS_DIR . '/includes/class-wp-jds-shortcodes.php' );
$wp_jds_shortcode = new Wp_Jds_Shortcodes();
$wp_jds_shortcode->add_hooks();

//Admin Pages Class for admin side
require_once( WP_JDS_ADMIN_DIR . '/class-wp-jds-admin.php' );
$wp_jds_admin = new Wp_Jds_Admin();
$wp_jds_admin->add_hooks();