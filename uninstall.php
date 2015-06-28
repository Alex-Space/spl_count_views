<?php 

if ( !defined('WP_UNINSTALL_PLUGIN') ) {
  exit;
}

include dirname( __FILE__ ) . '/spl_check.php';

if ( spl_check_field('spl_views') ) {
  global $wpdb;

  $query = "ALTER TABLE $wpdb->posts DROP spl_views";
  $wpdb->query($query);
}

