<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us_Simple extends Widget_Base {

    public function get_name() {
        return 'about_simple';
    }

    public function get_title() {
        return __('About Us Simple', 'cs-elementor');
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
                'about_simple_tab',
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
                'section_description',
                [
                    'label' => __('Section Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'attach_image',
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
                        'right' => __('Right Side', 'cs-elementor'),
                        'left' => __('Left Side', 'cs-elementor'),
                    ],
                    'default' => 'right',
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
                    'label' => __('Animation Effects', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
                    'default' => 'bounce',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title_about'] = $settings['section_title_about'] ? $settings['section_title_about'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['attach_image'] = $settings['attach_image']['id'] ? $settings['attach_image']['id'] : '';
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : '';
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : array();
        echo cs_elementor_about_simple($params);
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