<?php
/**
 * Plugin Name: Beaverlodge Maintenance
 * Plugin URI: https://www.beaverlodgehq.com
 * Description: Enable maintenance mode and use with Beaver Builder Template.
 * Version: 1.1.4
 * Author: Beaverlodge HQ
 * Author URI: https://www.beaverlodgehq.com
 */


if ( ! class_exists( 'FLBuilder' )) {
	require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
	require_once dirname( __FILE__ ) . '/tgm_settings.php';
	
	function sw_maintenance_lite_branding() {
		echo 'https://www.wpbeaverbuilder.com/?fla=283';
	}
	add_action ('fl_builder_upgrade_url', 'sw_maintenance_lite_branding');

}


function sw_maintenance_mode() {
    $settings = get_option( 'sw_maintenance_options');
    $enable = 'sw-maintenance-enable';
    $role = 'sw-maintenance-role';
    
    if ($settings[$enable] == 'true') {
        
        global $pagenow;
        if ( $pagenow !== 'wp-login.php' && ! current_user_can( $settings[$role] ) && ! is_admin() ) {
            header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
            header( 'Content-Type: text/html; charset=utf-8' );
            if ( file_exists( plugin_dir_path( __FILE__ ) . 'maintenance.php' ) ) {
                require_once( plugin_dir_path( __FILE__ ) . 'maintenance.php' );
            }
            die();
        }
        
    }
}
add_action( 'wp_loaded', 'sw_maintenance_mode' );

function sw_maintenance_mode_post() {

	$title = 'Maintenance Mode Template';
	$slug = 'sw-maintenance-template';
	$url = site_url();
	$page = get_page_by_title( $title, OBJECT, 'fl-builder-template');
	
	if( $page == NULL ) {
	
	        $maintenance_post = array(
			'post_title'    => $title,
			'post_name'     => $slug,
			'post_content'  => __('Please edit the <strong>Maintenance Mode Template</strong> <a href="'. $url .'/wp-admin/edit.php?post_type=fl-builder-template">Beaver Builder template</a> to create your design', 'sw_maintenance'),
			'post_status'   => 'publish',
			'post_type' 	=> 'fl-builder-template'
		);

	}
	
	wp_insert_post( $maintenance_post );
	
}
register_activation_hook(__FILE__, 'sw_maintenance_mode_post');


function sw_maintenance_load_textdomain() {
  load_plugin_textdomain( 'sw_maintenance', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'sw_maintenance_load_textdomain' );

if( !class_exists( 'RW_Meta_Box' ) ) {
	include plugin_dir_path( __FILE__ ) . 'meta/meta-box/meta-box.php';
}

if( !class_exists( 'MB_Settings_Page_Meta_Box' ) ) {
	include plugin_dir_path( __FILE__ ) . 'meta/mb-settings-page/mb-settings-page.php';
}

if( !class_exists( 'MB_Conditional_Logic' ) ) {
	include plugin_dir_path( __FILE__ ) . 'meta/meta-box-conditional-logic/meta-box-conditional-logic.php';
}

include plugin_dir_path( __FILE__ ) . 'meta/sw-maintenance-settings.php';
