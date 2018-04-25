<?php
/**
 * Enqueue Parent Styles
 */
add_action( 'wp_enqueue_scripts', 'dara_child_enqueue_styles' );
function dara_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

/**
 * Enqueue Theme Styles
 */
 function tgb_scripts() {
   wp_enqueue_style( 'tgb-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Slab:700 ' );
   wp_enqueue_style( 'tgb-custom-css', get_stylesheet_directory_uri() . '/assets/css/tgb-styles.min.css', array() );
   wp_enqueue_style( 'dashicons' );
 }
 add_action( 'wp_enqueue_scripts', 'tgb_scripts', 999 );
