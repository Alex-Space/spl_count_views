<?php
/*
Plugin Name: Счетчик просмотров записи
Description: Создает счетчик просмотров записи
Version: 1.0
Author: Alex Space
Author URI: http://spaceliquis.tk
*/

include dirname( __FILE__ ) . '/spl_check.php';

register_activation_hook( __FILE__, 'spl_create_field' );
add_filter( 'the_content', 'spl_show_counter' );
add_action( 'wp_head', 'spl_add_view' );

function spl_create_field() {
  global $wpdb;

  if ( ! spl_check_field('spl_views') ) {
    $query = "ALTER TABLE $wpdb->posts ADD spl_views INT NOT NULL DEFAULT '0'";
    $wpdb->query($query);
  }
  
}

function spl_show_counter($content) {
  global $post;
  $views = $post->spl_views;
 
  if ( is_page() ) {
    return $content;
  }
  
  if ( is_single() ) {
    $views += 1;
  }

  return $content . 'Счетчик просмотров: ' . $views;
}

function spl_add_view($content) {
  if ( !is_single() ) {
    return;
  }

  global $post, $wpdb;

  $fields = $wpdb->get_results( "SHOW fields FROM $wpdb->posts", ARRAY_A );
  $spl_id = $post->ID;
  $views = $post->spl_views + 1; 

  $wpdb->update(
    $wpdb->posts,
    array ( 'spl_views' => $views ),
    array ( 'ID' => $spl_id )
  );

}