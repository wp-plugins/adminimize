<?php
/**
 * @package    Adminimize
 * @subpackage Notice for settings page
 * @author     Frank Bültge
 */
if ( ! function_exists( 'add_filter' ) ) {
	echo "Hi there! I'm just a part of plugin, not much I can do when called directly.";
	exit;
}
// always visible
add_action( 'load-settings_page_adminimize/adminimize', '_mw_adminimize_add_settings_error' );
//add_action( 'admin_notices', '_mw_adminimize_on_admin_init' );

function _mw_adminimize_add_settings_error() {
	
	$settings_hint_message = '<span style="font-size: 30px;">&#x261D;</span>' . __( 'Attention: The settings page ignores these Menu settings and views the menu with all entries!', FB_ADMINIMIZE_TEXTDOMAIN );
	
	add_settings_error(
		'_mw_settings_hint_message',
		'_mw_settings_hint',
		$settings_hint_message,
		'updated'
	);
	
}

function _mw_adminimize_get_admin_notices() {
	
	settings_errors( '_mw_settings_hint_message' );
}
