<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_With_Make_Models extends Widget_Base {

    public function get_name() {
        return 'search_make_model_short_base_new';
    }

    public function get_title() {
        return __('Search with Make Model & Years', 'cs-elementor');
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
        /* for basic tab */
        $this->start_controls_section(
                'search_make_model_basic_tab',
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

        /* for categories tab */
        $this->start_controls_section(
                'search_make_model_categ_tab',
                [
                    'label' => __('Category', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

        /* for  years tab */
        $this->start_controls_section(
                'search_make_model_years_tab',
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
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();
        $params['years'] = $settings['years'] ? $settings['years'] : array();

        echo cs_elementor_search_make_model_year($params);
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