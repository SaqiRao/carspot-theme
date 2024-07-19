<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Testi_Monial_Two extends Widget_Base {

    public function get_name() {
        return 'testimonials_two_short_base';
    }

    public function get_title() {
        return __('Testimonials Two', 'cs-elementor');
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
                'testimonials_two_basic_tab',
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

        /* for Testimonials tab */
        $this->start_controls_section(
                'testimonials_two_tab',
                [
                    'label' => __('Testimonials Two', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'testi_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'testi_desc',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'testi_user_name',
                [
                    'label' => __('User Name', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'testi_user_desg',
                [
                    'label' => __('User Desgination', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'testi_rating',
                [
                    'label' => __('Rating', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Rating', 'cs-elementor'),
                        '1' => __('1 Star', 'cs-elementor'),
                        '2' => __('2 Star', 'cs-elementor'),
                        '3' => __('3 Star', 'cs-elementor'),
                        '4' => __('4 Star', 'cs-elementor'),
                        '5' => __('5 Star', 'cs-elementor'),
                    ],
                ]
        );
        $repeater->add_control(
                'testi_user_img',
                [
                    'label' => __('User Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Recommended Size For Image should be 90x90.png', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'testimonials',
                [
                    'label' => __('Testimonials', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'testi_title' => '',
                            'testi_desc' => '',
                            'testi_user_name' => '',
                            'testi_user_desg' => '',
                            'testi_rating' => '',
                            'testi_user_img' => '',
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
        
        $params['testimonials'] = $settings['testimonials'] ? $settings['testimonials'] : array();
        
        echo cs_elementor_testimonial_two($params);
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