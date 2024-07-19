<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Tab_Advance extends Widget_Base {

    public function get_name() {
        return 'search_tabs';
    }

    public function get_title() {
        return __('Advance Search - Tabs', 'cs-elementor');
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
                'tab_advance_car_by_detail_tab',
                [
                    'label' => __('Car By Detail', 'cs-elementor'),
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

        /* for minimal bar select years tab */
        $this->start_controls_section(
                'tab_advance_years_tab',
                [
                    'label' => __('Years', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'year',
                [
                    'label' => __('Select Years', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_years', 'yes'),
                ]
        );
        $this->add_control(
                'years',
                [
                    'label' => __('Years', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'year' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for minimal bar select Body Type tab */
        $this->start_controls_section(
                'tab_advance_body_type_tab',
                [
                    'label' => __('Body Type', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'body_type',
                [
                    'label' => __('Body Type', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_body_types', 'yes'),
                ]
        );
        $repeater->add_control(
                'img',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 250x112.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'body_types',
                [
                    'label' => __('Select Body Type', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'body_type' => '',
                            'img' => ''
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
        $params['want_to_show'] = $settings['want_to_show'] ? $settings['want_to_show'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();
        $params['years'] = $settings['years'] ? $settings['years'] : array();
        $params['body_types'] = $settings['body_types'] ? $settings['body_types'] : array();

        echo cs_elementor_search_tab_advance($params);
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