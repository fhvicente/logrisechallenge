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
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivation'));

        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Register scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        
        // Register shortcode
        add_shortcode('mylistdemo', array($this, 'render_shortcode'));

        // AJAX handlers
        add_action('wp_ajax_mylistdemo_save_items', array($this, 'ajax_save_items'));
        add_action('wp_ajax_mylistdemo_reset_items', array($this, 'ajax_reset_items'));
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Set default option
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
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_my-list-demo' !== $hook) {
            return;
        }

        // Enqueue jQuery UI Sortable
        wp_enqueue_script('jquery-ui-sortable');

        // Enqueue admin script
        wp_enqueue_script(
            'mylistdemo-admin-js',
            MYLISTDEMO_PLUGIN_DIR . 'assets/js/admin.js',
            array('jquery', 'jquery-ui-sortable'),
            MYLISTDEMO_VERSION,
            true
        );

        // Pass AJAX URL to script
        wp_localize_script(
            'mylistdemo-admin-js',
            'myListDemoAdmin',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('mylistdemo-admin-nonce'),
            )
        );
        
        // Enqueue admin styles
        wp_enqueue_style(
            'mylistdemo-admin-css',
            MYLISTDEMO_PLUGIN_DIR . 'assets/css/admin.css',
            array(),
            MYLISTDEMO_VERSION
        );
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'mylistdemo-frontend-css',
            MYLISTDEMO_PLUGIN_DIR . 'assets/css/frontend.css',
            array(),
            MYLISTDEMO_VERSION
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
     * AJAX callback to save items
     */
    public function ajax_save_items() {
        if(isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mylistdemo-admin-nonce')) {
            wp_send_json_error(array('message' => __('Security check failed', 'my-list-demo')));
            wp_die();
        }

        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Permission denied', 'my-list-demo')));
            wp_die();
        }

        $items = isset($_POST['items']) ? $_POST['items'] : array();

        update_option('mylistdemo_items', $items);

        delete_transient('mylistdemo_cached_items');

        wp_send_json_success(array('message' => __('Items saved successfully', 'my-list-demo')));
        wp_die();
    }

    /**
     * AJAX callback to reset items
     */
    public function ajax_reset_items() {
        
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