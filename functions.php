<?php
/**
 * Enqueue Parent Styles
 */
add_action( 'wp_enqueue_scripts', 'dara_child_enqueue_styles' );
function dara_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
