<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us extends Widget_Base {

    public function get_name() {
        return 'about_classic';
    }

    public function get_title() {
        return __('About Us Classic', 'cs-elementor');
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
        /* for About Us tab */
        $this->start_controls_section(
                'aboutus_section',
                [
                    'label' => __('About Us', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'section_title_about',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('About Car Spot Dealership', 'cs-elementor'),
                    'placeholder' => __('About Carspot Dealership', 'cs-elementor'),
                    'label_block' => true,
                ]
        );

        $this->add_control(
                'sell_tagline',
                [
                    'label' => __('Your Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
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
                'main_image',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'description' => __('Recommended Size For Image should be 555x296.png', 'cs-elementor'),
                    'label_block' => true,
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
                        'right' => __('Right', 'cs-elementor'),
                        'left' => __('Left', 'cs-elementor'),
                    ],
                    'default' => 'right',
                ]
        );
        $this->end_controls_section();

        /* for Feature tab */
        $this->start_controls_section(
                'what_we_do',
                [
                    'label' => __('What We Do', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon',
                [
                    'label' => __('Icon', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
        ]);
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
                    'label' => __('Items', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'label_block' => true,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon' => (''),
                            'serv_title' => __('Some Description', 'cs-elementor'),
                            'serv_desc' => __('We have the right caring, experience and dedicated professional for you.', 'cs-elementor'),
                        ],
                    ]
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'about_animation_tab',
                [
                    'label' => __('Animation', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'animation_effects',
                [
                    'label' => __('Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => carspot_elementor_animations(),
                    'default' => 'bounceOutRight',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title_about'] = $settings['section_title_about'] ? $settings['section_title_about'] : '';
        $params['sell_tagline'] = $settings['sell_tagline'] ? $settings['sell_tagline'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['main_image'] = $settings['main_image']['id'] ? $settings['main_image']['id'] : '';
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : '';
        $params['services_add_left'] = $settings['services_add_left'] ? $settings['services_add_left'] : array();
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : '';
        echo cs_elementor_about_classic($params);
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