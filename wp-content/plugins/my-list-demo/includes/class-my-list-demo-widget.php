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

    /**
     * Register widget controls
     */
    public function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Settings', 'my-list-demo'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'widget_title',
            [
                'label' => __('Title', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('My List', 'my-list-demo'),
                'placehodler' => __('Enter your title', 'my-list-demo'),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'my-list-demo'),
                'label_off' => __('Hide', 'my-list-demo'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'my-list-demo'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mylistdemo-widget-title' => 'color: {{VALUE}},',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .mylistdemo-widget-title',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => __('Item Background', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selector' => [
                    '{{WRAPPER}} .mylistdemo-list-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __('Item Text Color', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mylistdemo-list-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .mylistdemo-list-item',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'list_border',
                'selector' => '{{WRAPPER}} .mylistdemo-list',
            ]
        );

        $this->add_control(
            'list-border_radius',
            [
                'label' => __('Border Radius', 'my-list-demo'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mylistdemo-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'list_box_shadow',
                'selector' => '{{WRAPPER}} .mylistdemo-list',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    public function render() {
        $settings = $this->get_settings_for_display();

        // Get the shortcode content
        $shortcode_content = do_shortcode('[mylistdemo]');

        echo '<div class="mylistdemo-widget">';

        if ($settings['show_title'] === 'yes' && !empty($settings['widget_title'])) {
            echo '<h3 class="mylistdemo-widget-title">' . esc_html($settings['widget_title']) . '</h3>';
        }

        echo $shortcode_content;

        echo '</div>';
    }
}