<?php
/**
 * Plugin Name: My List Demo
 * Plugin URI: https://github.com/fhvicente/logrisechallenge
 * Description: A plugin that allows users to add a list of items and display them using shortcode.
 * Version: 1.0.0
 * Author: Flávio Vicente
 * Author URI: https://example.com
 * Text Domain: my-list-demo
 * Domain Path: /languages
 */

//  if this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('MYLISTDEMO_VERSION', '1.0.0');
define('MYLISTDEMO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MYLISTDEMO_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the main plugin class
require_once MYLISTDEMO_PLUGIN_DIR . 'includes/class-my-list-demo.php';

// Initialize the plugin
function run_my_list_demo() {
    $plugin = new My_List_Demo();
    $plugin->run();
}

run_my_list_demo();