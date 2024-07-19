<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Inspection extends Widget_Base {

    public function get_name() {
        return 'inspection';
    }

    public function get_title() {
        return __('Inspection', 'cs-elementor');
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
                'inspection',
                [
                    'label' => __('Inspection', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'section_title_inspection',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Car Inspection Form', 'cs-elementor'),
                    'placeholder' => __('Car Inspection Form', 'cs-elementor'),
                    'label_block' => true,
                ]
        );
    $this->add_control(
                  'btn_title',
                  [
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Control Name', 'plugin-name' ),
                  ]
       );

    
        $this->end_controls_section();  
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title_inspection'] = $settings['section_title_inspection'] ? $settings['section_title_inspection'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
       
        echo cs_elementor_inspection_classic($params);
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