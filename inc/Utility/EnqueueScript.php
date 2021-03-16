<?php
/**
 *  @package  eventRsvp
 */

namespace Inc\Utility;


class EnqueueScript{

	// enqueue Admin Scripts
    function admin_enqueue() {
		wp_enqueue_style( 'zain Bootstrap CSS', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' );
		wp_enqueue_style( 'zain_plugin_style', $GLOBALS['plugin_url'] . 'assets/css/style.css');
		wp_enqueue_script( 'zain Bootstrap JS', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js', 'jquery-core-js', NULL, true  );
		wp_enqueue_script( 'zain_plugin_script', $GLOBALS['plugin_url'] . 'assets/js/app.js',[],'',true );
	}

	public function run(){
    	 add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
    }
}