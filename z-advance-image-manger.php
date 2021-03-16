<?php
/**
 * @package  eventRsvp
 */
/*
Plugin Name: Event Rsvp 
Plugin URI: http://israelakinola.com/plugin
Description
Version: 1.0.0
Author: Israel Akinola
Author URI: http://israelakinola.com
License: GPLv2 or later
*/


global $wpdb;

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

$plugin_path = plugin_dir_path(__FILE__);
$plugin_url = plugin_dir_url( __FILE__ );
$upload_path = $plugin_path . "uploads/";
// $plugin = plugin_basename( dirname( __FILE__,0 ) ) . '/z-advance-image-manger.php';


/**
 * The code that runs during plugin activation
 */
function activate___plugin() {
	Inc\Functions\Rsvp::createDbTable();
}
register_activation_hook( __FILE__, 'activate___plugin' );

/**
 * The code that runs during plugin deactivation
 */

function deactivate___plugin() {
	
}

register_deactivation_hook( __FILE__, 'deactivate___plugin' );


/**
 * The code initialize the apllication and runs all functioning code
 */


if(class_exists('Inc\\Init')){
	$init = new Inc\Init;
	add_action('init',[$init, 'run']);	 
}



