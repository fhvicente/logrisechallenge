<?php
/**
 * The main plugin class
 */

class My_List_Demo {

    /**
     * Initialize the plugin
     */

    public function run() {
        // Register activation and deactivation hooks
        register_activation_hook(plugin_dir_path(__DIR__) . 'my-list-demo.php', array($this, 'activate'));
        register_deactivation_hook(plugin_dir_path(__DIR__) . 'my-list-demo.php', array($this, 'deactivation'));

        add_action('admin-menu', array($this, 'add_admin_menu'));

        // Register scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('My List Demo', 'my-list-demo'),
            __('My List Demo', 'my-list-demo'),
            'manage_options',
            'my-list-demo',
            array($this, 'render_admin_page'),
            'dashicons-list-view',
            30
        );
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('My List Demo Settings', 'my-list-demo'); ?></h1>
        </div>
        <?php
    }
 }