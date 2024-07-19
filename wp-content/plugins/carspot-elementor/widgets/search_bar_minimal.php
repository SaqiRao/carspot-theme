<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Bar_Minimal extends Widget_Base {

    public function get_name() {
        return 'minimal_searchbar_base';
    }

    public function get_title() {
        return __('Minimal Search Bar', 'cs-elementor');
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
                'car_inspection_keyword_tab',
                [
                    'label' => __('Keyword', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'field_heading',
                [
                    'label' => __('Field Heading', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'place_title',
                [
                    'label' => __('Placeholder Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for minimal bar select make tab */
        $this->start_controls_section(
                'car_inspection_make_tab',
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
                    'label' => __('Select Category', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_cats', 'yes'),
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Categories', 'cs-elementor'),
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
                'car_inspection_years_tab',
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
                'car_inspection_body_type_tab',
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
                    'options' => cs_elementor_get_parents_cats('ad_body_types', 'yes'),
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
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['field_heading'] = $settings['field_heading'] ? $settings['field_heading'] : '';
        $params['place_title'] = $settings['place_title'] ? $settings['place_title'] : '';
        $params['want_to_show'] = $settings['want_to_show'] ? $settings['want_to_show'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();
        $params['years'] = $settings['years'] ? $settings['years'] : array();
        $params['body_types'] = $settings['body_types'] ? $settings['body_types'] : array();



        echo cs_elementor_search_bar_minimal($params);
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