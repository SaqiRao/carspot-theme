<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Apps_Simple extends Widget_Base {

    public function get_name() {
        return 'apps_simple_base';
    }

    public function get_title() {
        return __('Apps - Simple', 'cs-elementor');
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
        /* for Basic tab */
        $this->start_controls_section(
                'ad_app_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();
        /* for android tab */
        $this->start_controls_section(
                'ad_android_tab',
                [
                    'label' => __('Android', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'a_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'a_tag_line',
                [
                    'label' => __('Tag Line', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'a_link',
                [
                    'label' => __('Download Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();
        /* for IOS tab */
        $this->start_controls_section(
                'ad_ios_tab',
                [
                    'label' => __('IOS', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'i_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'i_tag_line',
                [
                    'label' => __('Tag Line', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'i_link',
                [
                    'label' => __('Download Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();
        /* for Windows tab */
        $this->start_controls_section(
                'ad_window_tab',
                [
                    'label' => __('Window', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'w_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'w_tag_line',
                [
                    'label' => __('Tag Line', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'w_link',
                [
                    'label' => __('Download Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';

        $params['a_title'] = $settings['a_title'] ? $settings['a_title'] : '';
        $params['a_tag_line'] = $settings['a_tag_line'] ? $settings['a_tag_line'] : '';
        $params['a_link'] = $settings['a_link'] ? $settings['a_link'] : '';

        $params['i_title'] = $settings['i_title'] ? $settings['i_title'] : '';
        $params['i_tag_line'] = $settings['i_tag_line'] ? $settings['i_tag_line'] : '';
        $params['i_link'] = $settings['i_link'] ? $settings['i_link'] : '';

        $params['w_title'] = $settings['w_title'] ? $settings['w_title'] : '';
        $params['w_tag_line'] = $settings['w_tag_line'] ? $settings['w_tag_line'] : '';
        $params['w_link'] = $settings['w_link'] ? $settings['w_link'] : '';

        echo cs_elementor_apps_short($params);
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