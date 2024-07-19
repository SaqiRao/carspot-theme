<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Packages extends Widget_Base {

    public function get_name() {
        return 'packages_short_base';
    }

    public function get_title() {
        return __('Packages', 'cs-elementor');
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
                'packages_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'header_style',
                [
                    'label' => __('Header Style', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('No Header', 'cs-elementor'),
                        'classic' => __('Classic', 'cs-elementor'),
                        'regular' => __('Regular', 'cs-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'header_style' => ['classic', 'regular']
                    ]
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'condition' => [
                        'header_style' => ['classic', 'regular']
                    ]
                ]
        );
        $this->end_controls_section();

        /* for Packages tab */
        $this->start_controls_section(
                'packages_tab',
                [
                    'label' => __('Packages', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'product',
                [
                    'label' => __('Select package', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_get_packages(),
                ]
        );
        $this->add_control(
                'woo_products',
                [
                    'label' => __('Packages', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'product' => '',
                        ],
                    ]
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['header_style'] = $settings['header_style'] ? $settings['header_style'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';

        $params['woo_products'] = $settings['woo_products'] ? $settings['woo_products'] : array();


        echo cs_elementor_packages($params);
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