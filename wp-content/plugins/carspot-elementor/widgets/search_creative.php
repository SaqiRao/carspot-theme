<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Creative extends Widget_Base {

    public function get_name() {
        return 'search_creative_short_base';
    }

    public function get_title() {
        return __('Home - Hero Section', 'cs-elementor');
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    public function get_categories() {
        return ['cstheme'];
    }

    public function get_script_depends() {
        return [''];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        /* for minimal bar keyword tab */
        $this->start_controls_section(
            'search_simple_basic_tab',
            [
                'label' => __('Keyword', 'cs-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __('%count% for total ads.', 'cs-elementor'),
            ]
        );
        $this->add_control(
            'section_tag_line',
            [
                'label' => __('Section Tagline', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'btn_title',
            [
                'label' => __('Button Title', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __('Button title here', 'cs-elementor'),
                'default' => __('Button Link', 'cs-elementor'),
                'label_block' => true
            ]
        );
        $this->add_control(
            'btn_link',
            [
                'label' => __('Button Link', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => __('https://your-link.com', 'cs-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';

        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';


        echo cs_elementor_search_creative($params);
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {

    }

}