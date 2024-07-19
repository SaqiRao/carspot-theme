<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Tab_Classified extends Widget_Base {

    public function get_name() {
        return 'search_tabs_classified';
    }

    public function get_title() {
        return __('Classifed Search - Tabs', 'cs-elementor');
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
                'tab_classified_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'first_tab',
                [
                    'label' => __('First Tab Heading', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'second_tab',
                [
                    'label' => __('Second Tab Heading', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for search fancy tab */
        $this->start_controls_section(
                'tab_classified_general_tab',
                [
                    'label' => __('General Tab', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Keyword Field Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'category_title',
                [
                    'label' => __('Category Field Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Show category with their childs?', 'cs-elementor'),
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
        $this->add_control(
                'price_title',
                [
                    'label' => __('Price Field Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'pricing_start',
                [
                    'label' => __('Minimum Price', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('0', 'cs-elementor'),
                ]
        );
        $this->add_control(
                'pricing_end',
                [
                    'label' => __('Maximum Price', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('999999999', 'cs-elementor'),
                ]
        );
        $this->end_controls_section();

        //inspection list
        $this->start_controls_section(
                'tab_classified_category_tab',
                [
                    'label' => __('Category Tab', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select Category', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_cats', 'yes'),
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
                'category_types',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'cat' => '',
                            'img' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();

        $params['first_tab'] = $settings['first_tab'] ? $settings['first_tab'] : '';
        $params['second_tab'] = $settings['second_tab'] ? $settings['second_tab'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['category_title'] = $settings['category_title'] ? $settings['category_title'] : '';
        $params['want_to_show'] = $settings['want_to_show'] ? $settings['want_to_show'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();
        $params['price_title'] = $settings['price_title'] ? $settings['price_title'] : '';
        $params['pricing_start'] = $settings['pricing_start'] ? $settings['pricing_start'] : '0';
        $params['pricing_end'] = $settings['pricing_end'] ? $settings['pricing_end'] : '9999999999';
        $params['category_types'] = $settings['category_types'] ? $settings['category_types'] : array();

        echo cs_elementor_search_tab_classified($params);
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