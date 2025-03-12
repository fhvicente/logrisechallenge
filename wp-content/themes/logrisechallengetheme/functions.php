<?php
/**
 * Theme functions
 */

//  Add support to theme resources
function logrisechallenge_theme_setup() {
    
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(array(
        'primary' => __('Main Menu', 'logrisechallenge'),
    ));

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'logrisechallenge_theme_setup');

// Enqueue scripts and styles
function logrisechallenge_theme_scripts() {
    wp_enqueue_style('style', get_stylesheet_uri());
    // wp_enqueue_script('script', get_template_directory_uri() . '/js/navigation.js, array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'logrisechallenge_theme_scripts');