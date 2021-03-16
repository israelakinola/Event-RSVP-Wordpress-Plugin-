<?php
/**
 * @package  eventRsvp
 */

namespace Inc\Utility;

class AdminPages{


    public  function createAdminPages(){
        //Create a Plugin Admin Menu
        add_menu_page( 'My Events', 'Event Rsvp', 'manage_options', 'z-event-rsvp', [$this, 'AdminEventsPage'], 'dashicons-tickets-alt', NULL);
    }


    // List ALL Events
    public  function AdminEventsPage(){
        \Inc\Functions\Event::adminEventPage();
    }

     //Run all actions hooks
    public function run(){
        add_action( 'admin_menu', [$this, 'createAdminPages'] );
    }
}