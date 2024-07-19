<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Car_Inspection extends Widget_Base {

    public function get_name() {
        return 'inspection_short_base';
    }

    public function get_title() {
        return __('Car Inspection', 'cs-elementor');
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
        /* for car inspection tab */
        $this->start_controls_section(
                'car_inspection_general_tab',
                [
                    'label' => __('General', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'client_tagline',
                [
                    'label' => __('Your Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'client_heading',
                [
                    'label' => __('Your Heading', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
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
                'btn_title',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Button Link', 'cs-elementor'),
                    'label_block' => true
                ]
        );
        $this->add_control(
                'btn_link',
                [
                    'label' => __('Button Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'label_block' => true,
                    'placeholder' => __('https://your-link.com', 'cs-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->end_controls_section();
        //inspection list
        $this->start_controls_section(
                'car_inspection_list_tab',
                [
                    'label' => __('Inspection List', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'inspection',
                [
                    'label' => __('Add Inspection List', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'inspection_list',
                [
                    'label' => __('List', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'inspection' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'car_inspection_image_tab',
                [
                    'label' => __('Inspection Image', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'img_postion',
                [
                    'label' => __('Select Image Position', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => [
                        'right' => __('Right Side', 'cs-elementor'),
                        'left' => __('Left Side', 'cs-elementor'),
                    ],
                    'default' => 'right',
                ]
        );
        $this->add_control(
                'main_image',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'description' => __('Recommended Size For Image should be 685x429.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();

        //Animation list
        $this->start_controls_section(
                'car_inspection_animation_tab',
                [
                    'label' => __('Animation', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'animation_effects',
                [
                    'label' => __('Animation Effects', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => carspot_elementor_animations(),
                    'default' => 'bounce',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['client_tagline'] = $settings['client_tagline'] ? $settings['client_tagline'] : '';
        $params['client_heading'] = $settings['client_heading'] ? $settings['client_heading'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['main_image'] = $settings['main_image']['id'] ? $settings['main_image']['id'] : '';
        $params['inspection_list'] = $settings['inspection_list'] ? $settings['inspection_list'] : array();
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : '';
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : '';
        echo cs_elementor_car_inspection($params);
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