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
        register_activation_hook((__DIR__) . 'my-list-demo.php', array($this, 'activate'));
        register_deactivation_hook((__DIR__) . 'my-list-demo.php', array($this, 'deactivation'));

        add_action('admin-menu', array($this, 'add_admin_menu'));

        // Register scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        
        // Register shortcode
        add_shortcode('mylistdemo', array($this, 'render_shortcode'));
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Set defalut option
        if (!get_option('mylistdemo_items')) {
            update_option('mylistdemo_items', array());
        }
    }

    /**
     * Plugin deactivation
     */
    public function deactivation() {
        delete_transient('mylistdemo_cached_items');
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

    /**
     * Equeue admin assets
     */
    public function enqueue_admin_assets($hoot) {

    }

    /**
     * Render shortcode
     */
    public function render_shortcode($atts) {
        $items = get_option('mylistdemo_items', array());

        if (empty($items)) {
            return '<div class="mylistdemo-empty">' . __('No items to display.', 'my-list-demo') . '</div>';
        }

        ob_start();
        ?>
        <ul class="mylistdemo-list">
            <?php foreach ($items as $item) : ?>
                <li><?php echo esc_html($item); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php
        return ob_get_clean();
    }
 }