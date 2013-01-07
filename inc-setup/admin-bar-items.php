<?php
/**
 * @package    Adminimize
 * @subpackage Admin Bar Items
 * @author     Frank Bültge
 */

if ( ! function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a part of plugin, not much I can do when called directly.";
	exit;
}

add_action( 'wp_before_admin_bar_render', '_mw_adminimize_filter_admin_bar' );
// test
function _mw_adminimize_filter_admin_bar() {
	global $wp_admin_bar;
	
	var_dump($wp_admin_bar->menu);	
}