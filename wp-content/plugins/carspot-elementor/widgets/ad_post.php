<?php
/* Sell your car */

namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Ad_Post extends Widget_Base {

    public function get_name() {
        return 'ad_post_sell_your_car';
    }

    public function get_title() {
        return __('Ad Post Form Type', 'cs-elementor');
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
        /* for General tab */
        $this->start_controls_section(
                'aboutus_section',
                [
                    'label' => __('General', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                '_type',
                [
                    'label' => __('Ad Post Form Type', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Post Form', 'cs-elementor'),
                        'no' => __('Default Form', 'cs-elementor'),
                        'yes' => __('Categories Based Form', 'cs-elementor'),
                    ],
                    'default' => 'no',
                ]
        );
        $this->add_control(
                'extra_section_title',
                [
                    'label' => __('Extra Fields Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'tip_section_title',
                [
                    'label' => __('Tip Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => __('Safety Tips for Buyers', 'cs-elementor'),
                    'placeholder' => __('Put safety tip section title', 'cs-elementor'),
                ]
        );
        $this->add_control(
                'tips_description',
                [
                    'label' => __('Tips Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for Extra Fields tab */
        $this->start_controls_section(
                'extra_fields_tab',
                [
                    'label' => __('Extra Fileds', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'slug',
                [
                    'label' => __('Slug', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' => __('This should be unique and if you change it the pervious data of this field will be lost', 'cs-elementor')
                ]
        );
        $repeater->add_control(
                'type',
                [
                    'label' => __('Type', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Please select', 'cs-elementor'),
                        'text' => __('Textfield', 'cs-elementor'),
                        'select' => __('Select/List', 'cs-elementor'),
                    ],
                ]
        );
        $repeater->add_control(
                'option_values',
                [
                    'label' => __('Values for Select/List', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'description' => __('Like: value1,value2,value3', 'cs-elementor'),
                    'condition' => [
                        'type' => ['select']
                    ],
                ]
        );
        $this->add_control(
                'fields',
                [
                    'label' => __('Items', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => '',
                            'slug' => '',
                            'type' => '',
                            'option_values'=> ''
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* Safety Tips */
        $this->start_controls_section(
                'safety_tip_tab',
                [
                    'label' => __('Safety Tips', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'description',
                [
                    'label' => __('Add Tips', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'tips',
                [
                    'label' => __('Tips', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'description' => __('Use a safe location to meet seller', 'cs-elementor'),
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $params['_type'] = $settings['_type'] ? $settings['_type'] : '';
        $params['extra_section_title'] = $settings['extra_section_title'] ? $settings['extra_section_title'] : '';
        $params['tip_section_title'] = $settings['tip_section_title'] ? $settings['tip_section_title'] : '';
        $params['tips_description'] = $settings['tips_description'] ? $settings['tips_description'] : '';
        $params['fields'] = $settings['fields'] ? $settings['fields'] : array();
        $params['tips'] = $settings['tips'] ? $settings['tips'] : array();

        echo cs_elementor_ad_post($params);
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