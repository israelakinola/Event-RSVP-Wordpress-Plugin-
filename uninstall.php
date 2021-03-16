<?php
/**
 * @package  eventRsvp
 */




defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// Clear Database stored data
$events = get_posts( array( 'post_type' => 'event', 'numberposts' => -1 ) );

foreach( $books as $book ) {
	wp_delete_post( $events->ID, true );
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'event'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
$table_name = $wpdb->prefix . "rsvp";
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
delete_option("rsvp_table_created");
