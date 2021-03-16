<?php
/**
 * @package  eventRsvp
 */

namespace Inc\Utility;

class CustomPost{
    
     // Create Events Post Type
    public function createEventCustomPost(){
        register_post_type( 'event', array(
           'show_in_rest' => true,
           'supports' => array('title', 'thumbnail'),
           'rewrite' => array('slug' => 'z-event'),
           'has_archive' => true,
           'public' => true,
           'labels' => array(
           'name' => 'Event',
           'add_new_item' => 'Add New Event',
           'edit_item' => 'Edit Event',
           'all_items' => 'All Events',
           'singular_name' => 'Events'
           ),
           'menu_icon' => 'dashicons-awards'
     ) );
    }
    public function run(){
        add_action( 'init', [$this, 'createEventCustomPost'] );
    }
}