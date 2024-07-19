<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Services_Modern extends Widget_Base {

    public function get_name() {
        return 'services_modern_base';
    }

    public function get_title() {
        return __('Services Modern', 'cs-elementor');
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
                'services_modern_basic_tab',
                [
                    'label' => __('Background Images', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'bg_img1',
                [
                    'label' => __('Background Image Left Side', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'bg_img2',
                [
                    'label' => __('Background Image Right Side', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();

        /* for Basic tab */
        $this->start_controls_section(
                'services_modern_services_tab',
                [
                    'label' => __('Services', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' => __('For color {color}warp text within this tag{/color}', 'cs-elementor'),
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'main_image',
                [
                    'label' => __('Car Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 715x215.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'img_postion',
                [
                    'label' => __('Select Image Position', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'left' => __('Left Side', 'cs-elementor'),
                        'right' => __('Right Side', 'cs-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'animation_effects',
                [
                    'label' => __('Car Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
                ]
        );
        $this->add_control(
                'animation_effects2',
                [
                    'label' => __('Services Box Animation', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
                ]
        );
        $this->end_controls_section();

        /* for service List tab */
        $this->start_controls_section(
                'services_add_left_tab',
                [
                    'label' => __('Services List', 'cs-elementor'),
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
                'client_tagline',
                [
                    'label' => __('Count', 'cs-elementor'),
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
                'services_add_left',
                [
                    'label' => __('Select Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon' => '',
                            'client_tagline' => '',
                            'serv_title' => '',
                            'serv_desc' => '',
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
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : '';
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : ''; 
        $params['animation_effects2'] = $settings['animation_effects2'] ? $settings['animation_effects2'] : '';

        $params['bg_img1'] = $settings['bg_img1']['id'] ? $settings['bg_img1']['id'] : '';
        $params['bg_img2'] = $settings['bg_img2']['id'] ? $settings['bg_img2']['id'] : '';
        $params['main_image'] = $settings['main_image']['id'] ? $settings['main_image']['id'] : '';

        $params['services_add_left'] = $settings['services_add_left'] ? $settings['services_add_left'] : array();

        echo cs_elementor_services_modern($params);
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