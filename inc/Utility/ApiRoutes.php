<?php
/**
 * @package  eventRsvp
 */

namespace Inc\Utility;

class ApiRoutes{

    public $current_user_can;

    function __construct(){
        //Check if Current user can edit posts
        $this->$current_user_can = current_user_can('edit_posts');
    }

     //Register Api Routefor deleteing Event
    public function registerDropEventRoute(){
       
        register_rest_route( 'z-event-rsvp/v1', '/event/drop', array(
            'methods' => 'POST',
            'callback' => [$this, 'dropEvent'],
            'permission_callback'=>function(){
                return $this->$current_user_can;
            }
          ) );
    }

    // Call back function for "drop event Api Route"
    public static function dropEvent(\WP_REST_Request $request ){
        $event_id = $request['id'];
        if(!empty($event_id)){
            \Inc\Functions\Event::dropEvent($event_id);
        } 
    }

    //Register Api route for Rsvp list
    public function registerListRoute(){
        //Register Api Route
        register_rest_route( 'z-event-rsvp/v1', '/event/rsvp/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'listAttendees'],
             'permission_callback'=>function(){
                 return $this->$current_user_can;
             }
          ) );
    }

    //This method will return a JSON data of all RSVP for each Event
    public function listAttendees(\WP_REST_Request $request){
       global $wpdb;
       $id =  $request['id'];

      $data = $wpdb->get_results("SELECT attendee_name, attendee_email FROM  {$wpdb->prefix}rsvp WHERE event_id = {$id} ");
      
      if(!empty($data)){
          return $data;
      }
    }

    public function run(){
        //Register API Route Hook
        add_action( 'rest_api_init', [$this, 'registerDropEventRoute'] );
        add_action( 'rest_api_init', [$this, 'registerListRoute'] );
    }
}