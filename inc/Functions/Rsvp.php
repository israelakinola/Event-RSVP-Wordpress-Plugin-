<?php
/**
 *  @package  eventRsvp
 */

namespace Inc\Functions;

class Rsvp{

        //Create RSVP Table
        public static function createDbTable(){
            global $wpdb;   
            $table_name = $wpdb->prefix . "rsvp";
            $wp_posts = $wpdb->prefix . "posts";
    
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'" ) == null) {
    
                    $sql  = "CREATE TABLE $table_name(
                    attendee_id INT(20) AUTO_INCREMENT,
                    attendee_name VARCHAR(255),
                    attendee_email VARCHAR(255),
                    event_id INT(20),
                    PRIMARY KEY(attendee_id))";
        
                    if(!function_exists('dbDelta')) {
                        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    }
        
                    dbDelta($sql);
                    update_option('rsvp_table_created', true);
                }
        }


        static function getRsvpData($id){
            global $wpdb;
            return $results = $wpdb->get_results("SELECT *  FROM {$wpdb->prefix}rsvp WHERE event_id=$id");
        }

        // Get Total of Attendee for given event
        static function getRsvpCount($id){
            return count(self::getRsvpData($id));
        }

       // Delete all RSVP assocated with a spefic event
        static function deleteRsvpList($event_id){
            global $wpdb;
            $wpdb->delete($wpdb->prefix.'rsvp',[
                'event_id'=> $event_id
            ],'%d' );
        }

}