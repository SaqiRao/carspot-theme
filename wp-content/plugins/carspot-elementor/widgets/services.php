<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Services extends Widget_Base {

    public function get_name() {
        return 'services_short_base';
    }

    public function get_title() {
        return __('Services', 'cs-elementor');
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
                'services_basic_tab',
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
        $this->end_controls_section();

        /* for service left tab */
        $this->start_controls_section(
                'services_service_left_tab',
                [
                    'label' => __('Service Left', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
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
        $this->add_control(
                'services_add_left',
                [
                    'label' => __('Select Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'serv_title' => '',
                            'serv_desc' => '',
                            'icon' => ''
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for service right tab */
        $this->start_controls_section(
                'services_service_right_tab',
                [
                    'label' => __('Service Right', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'serv_title_right',
                [
                    'label' => __('Title Of Service', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'serv_desc_right',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'icon_right',
                [
                    'label' => __('Icons', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => 'flaticon-car-wash',
                    'description' => 'https://www.flaticon.com/',
                ]
        );
        $this->add_control(
                'services_add_right',
                [
                    'label' => __('Select Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'serv_title_right' => '',
                            'serv_desc_right' => '',
                            'icon_right' => ''
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for service right tab */
        $this->start_controls_section(
                'services_service_image_tab',
                [
                    'label' => __('Service Image', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'service_img',
                [
                    'label' => __('Service Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'animation_effects',
                [
                    'label' => __('Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
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

        $params['services_add_left'] = $settings['services_add_left'] ? $settings['services_add_left'] : array();
        $params['services_add_right'] = $settings['services_add_right'] ? $settings['services_add_right'] : array();

        $params['service_img'] = $settings['service_img']['id'] ? $settings['service_img']['id'] : '';
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : '';

        echo cs_elementor_services($params);
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