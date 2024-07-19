<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Apps_Classic extends Widget_Base {

    public function get_name() {
        return 'apps_classic_base';
    }

    public function get_title() {
        return __('Apps - Classic', 'cs-elementor');
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
                'app_img',
                [
                    'label' => __('Main Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
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
                'section_title',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for Key Points tab */
        $this->start_controls_section(
                'ad_app_key_points_tab',
                [
                    'label' => __('Key Points', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'points_sec',
                [
                    'label' => __('Points', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'points',
                [
                    'label' => __('Add Points', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'points_sec' => '',
                        ],
                    ],
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
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['app_img'] = $settings['app_img']['id'] ? $settings['app_img']['id'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        
        $params['points'] = $settings['points'] ? $settings['points'] : array();

        $params['a_title'] = $settings['a_title'] ? $settings['a_title'] : '';
        $params['a_tag_line'] = $settings['a_tag_line'] ? $settings['a_tag_line'] : '';
        $params['a_link'] = $settings['a_link'] ? $settings['a_link'] : '';

        $params['i_title'] = $settings['i_title'] ? $settings['i_title'] : '';
        $params['i_tag_line'] = $settings['i_tag_line'] ? $settings['i_tag_line'] : '';
        $params['i_link'] = $settings['i_link'] ? $settings['i_link'] : '';

        echo cs_elementor_apps_classic($params);
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