<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Services_With_Facts extends Widget_Base {

    public function get_name() {
        return 'services_with_facts_base';
    }

    public function get_title() {
        return __('Services With Facts', 'cs-elementor');
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
                'services_with_facts_basic_tab',
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
                    ],
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
                    ],
                ]
        );
        $this->add_control(
            'bg_img',
            [
                'label' => __('Background Image', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'description' => __('Recommended Size For Image should be 1920x717.png', 'cs-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
            ]
        );
        $this->end_controls_section();

        /* for Offer tab */
        $this->start_controls_section(
                'services_classic_offer_tab',
                [
                    'label' => __('Services We Offer', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'icon',
                [
                    'label' => __('Icon Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Image size must be 64x64 px', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => '',
                    ]
                ]
        );
        $repeater->add_control(
                'serv_count',
                [
                    'label' => __('Services Count', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'serv_title',
                [
                    'label' => __('Title Of Service', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'serv_desc',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'services_with_img',
                [
                    'label' => __('Select Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon' => '',
                            'serv_title' => '',
                            'serv_desc' => '',
                            'serv_count' => ''
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for Funfacts tab */
        $this->start_controls_section(
                'services_classic_fun_tab',
                [
                    'label' => __('Fun Facts', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'funfact_show_hide',
                [
                    'label' => __('Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'fact_count',
                [
                    'label' => __('Total Numbers in counter', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'fact_text',
                [
                    'label' => __('Text below the numbers', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'fact_color_text',
                [
                    'label' => __('Colored Text', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'funfact_detaisl',
                [
                    'label' => __('Select Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'fact_count' => '',
                            'fact_text' => '',
                            'fact_color_text' => '',
                        ],
                    ],
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
        $params['services_with_img'] = $settings['services_with_img'] ? $settings['services_with_img'] : array();
        $params['bg_img'] = $settings['bg_img']['id'] ? $settings['bg_img']['id'] : '';
        $params['funfact_show_hide'] = $settings['funfact_show_hide'] ? $settings['funfact_show_hide'] : '';
        $params['funfact_detaisl'] = $settings['funfact_detaisl'] ? $settings['funfact_detaisl'] : array();

        echo cs_elementor_services_facts($params);
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