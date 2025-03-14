<?php

use function Avifinfo\read;

/**
 * Elementor widget fo My List Demo
 */

 class My_List_Demo_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'my_list_demo_widget';
    }

    /**
     * Get Widget title
     */
    public function get_title() {
        return __('My List Demo', 'my-list-demo');
    }

    /**
     * Get Widget icon
     */
    public function get_icon() {
        return 'eicon-bullet-list';
    }

    /**
     * Get Widget categories
     */
    public function get_categories() {
        return ['general'];
    }
 }