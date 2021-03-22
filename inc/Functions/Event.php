<?php

/**
 * @package  eventRsvp
 */


 namespace Inc\Functions;


 class Event{


    // This Method Create the Admin Event Page View Template
    public static function adminEventPage(){
      global $plugin_path;
      require_once  $GLOBALS['plugin_path'] . 'templates/EventPage.php';
    }

    //This method hanldes the Create New Event Form from the EventPage View Template
    public static function handleNewEventForm(){
      if ($_SERVER["REQUEST_METHOD"] == "POST" and $_REQUEST['event-title'] != '') {
        // collect value of input field
        $event_title=  $_REQUEST['event-title'];
        $event_date =  $_REQUEST['event-date'];
        $event_venue = $_REQUEST['event-venue'];
        $event_poster = \Inc\Utility\FormHandling::handleFileUpload();

        //Check to see if any of the important event data are not empty
        if (empty($event_title) or empty($event_venue) or empty($event_date) or is_array($event_poster) ) {
          echo "Name is empty";
        } else {
          //Create Event Post
          self::createEventPost($event_title, $event_date,$event_venue,$event_poster);
        }
      }
    }

    //This Method insert the event post and meta
    public static function createEventPost($event_title,$event_date, $event_venue, $event_poster){
      global $plugin_url;
         $my_post = array(
        'post_title'    => wp_strip_all_tags($event_title),
        'post_content'  => 'ssssws',
        'post_status'   => 'publish',
        'post_type' => 'event'
      );
      // Insert the post into the database
     $post_id = wp_insert_post( $my_post );
     $event_poster = $plugin_url."uploads/" . $event_poster;
     
     //check if post was inserted
      if($post_id > 0 ){
        add_post_meta($post_id,'event_date', $event_date );
        add_post_meta($post_id,'event_venue', $event_venue );
        add_post_meta($post_id,'event_poster',  $event_poster );
      }
    }

     // Delete Event Post and all associated post meta
    public static function dropEvent($event_id){
      if(wp_delete_post($event_id) != null){
        //check if post deletion was successful
        delete_post_meta($post_id,'event_date');
        delete_post_meta($post_id,'event_venue');
        delete_post_meta($post_id,'event_poster');
        Rsvp::deleteRsvpList($event_id);
        return "deleted";
      }
      
    }
    //This method get an event data
    public static function getEventData($event_id){
       $post_data = get_post(112);
       return $event = ["event_id"=>$event_id, "event_title"=>$post_data->post_title, "event_venue"=>get_post_meta($event_id,'event_venue',true),"event_date"=>get_post_meta($event_id,'event_date',true), "event_poster"=>get_post_meta($event_id,'event_poster',true)];
    }

 
    // This method create the rsvp shortcode
    public static function zEventRsvpShortcode($atts){
      
      //Get the events data with the shortcode id(event_id) artribute
        $a = shortcode_atts( array(
            'id' => 0,
        ), $atts );
        $event_id = $a['id'];
        $event = self::getEventData($event_id);

         \Inc\Utility\FormHandling::rsvpAttendanceFormHandling($event_id);
      
        /**
         * Return the Shortcode Page View Template. 
         * The IF statments is to avoid WP getting an event post which doesn't exist.
         */
        if($event['event_title']!= '' and $event['event_venue']!= '' and $event['event_date']!= ''){
          include_once  $GLOBALS['plugin_path'] . 'templates/shortcodePage.php';
        }
    }

    public function run(){
        //Hook Rsvp Shortcode
        add_shortcode( 'z-event-rsvp', [$this, 'zEventRsvpShortcode'] );
        
    }
 }

