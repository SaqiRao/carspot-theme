<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Fancy extends Widget_Base {

    public function get_name() {
        return 'search_fancy_short_base';
    }

    public function get_title() {
        return __('Search - Fancy', 'cs-elementor');
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
        /* for search fancy tab */
        $this->start_controls_section(
                'search_fancy_basic_tab',
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
        $this->add_control(
                'section_tag_line',
                [
                    'label' => __('Section Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' => __('%count% for total ads.', 'cs-elementor'),
                ]
        );
        $this->end_controls_section();

        /* for search slider tab */
        $this->start_controls_section(
                'search_slider__tab',
                [
                    'label' => __('Slider', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'img',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 1280x600.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'slides',
                [
                    'label' => __('Add Slider Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'img' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for search fancy select make tab */
        $this->start_controls_section(
                'search_modern_tab',
                [
                    'label' => __('Select Make', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Do you want to show?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('yes', 'cs-elementor'),
                        'no' => __('no', 'cs-elementor'),
                    ],
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Category', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_cats', 'yes'),
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Select Make ( All or Selective )', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'cat' => '',
                        ],
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
        $params['want_to_show'] = $settings['want_to_show'] ? $settings['want_to_show'] : '';
        $params['slides'] = $settings['slides'] ? $settings['slides'] : array();
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();


        echo cs_elementor_search_fancy($params);
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