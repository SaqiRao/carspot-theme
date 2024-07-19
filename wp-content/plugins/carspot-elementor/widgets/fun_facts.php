<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Fun_Fact extends Widget_Base {

    public function get_name() {
        return 'fun_factsshort_base';
    }

    public function get_title() {
        return __('Fun Facts', 'cs-elementor');
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
        /* for general tab */
        $this->start_controls_section(
                'fun_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'p_cols',
                [
                    'label' => __('Column', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Col', 'cs-elementor'),
                        '4' => __('3 Col', 'cs-elementor'),
                        '3' => __('4 Col', 'cs-elementor'),
                    ],
                ]
        );
        $this->end_controls_section();

        /* for general tab */
        $this->start_controls_section(
                'fun_facts_tab',
                [
                    'label' => __('Fun Facts', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'icon',
                [
                    'label' => __('Icons', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => 'flaticon-car-wash',
                    'description' => 'https://www.flaticon.com/',
                ]
        );
        $repeater->add_control(
                'numbers',
                [
                    'label' => __('Numbers', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'color_title',
                [
                    'label' => __('Color Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'fun_facts',
                [
                    'label' => __('Fun Fact', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon' => '',
                            'numbers' => '',
                            'title' => '',
                            'color_title' => '',
                        ],
                    ]
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();

        $params['p_cols'] = $settings['p_cols'] ? $settings['p_cols'] : '';
        $params['fun_facts'] = $settings['fun_facts'] ? $settings['fun_facts'] : array();
        
        echo cs_elementor_fun_facts($params);
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