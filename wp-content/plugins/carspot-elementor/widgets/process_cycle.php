<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Process_Cycle extends Widget_Base {

    public function get_name() {
        return 'process_cycle_short_base';
    }

    public function get_title() {
        return __('Process Cycle', 'cs-elementor');
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
                'process_cycle_basic_tab',
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
        /* for setp1 tab */
        $this->start_controls_section(
                'process_cycle_step1_tab',
                [
                    'label' => __('Step 1', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                's1_icon',
                [
                    'label' => __('Icons', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::ICON,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                's1_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                's1_description',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for setp2 tab */
        $this->start_controls_section(
                'process_cycle_step2_tab',
                [
                    'label' => __('Step 2', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                's2_icon',
                [
                    'label' => __('Icons', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::ICON,
                ]
        );
        $this->add_control(
                's2_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                's2_description',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for setp3 tab */
        $this->start_controls_section(
                'process_cycle_step3_tab',
                [
                    'label' => __('Step 1', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                's3_icon',
                [
                    'label' => __('Icons', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::ICON,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                's3_title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                's3_description',
                [
                    'label' => __('Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
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

        $params['s1_icon'] = $settings['s1_icon'] ? $settings['s1_icon'] : '';
        $params['s1_title'] = $settings['s1_title'] ? $settings['s1_title'] : '';
        $params['s1_description'] = $settings['s1_description'] ? $settings['s1_description'] : '';
        
        $params['s2_icon'] = $settings['s2_icon'] ? $settings['s2_icon'] : '';
        $params['s2_title'] = $settings['s2_title'] ? $settings['s2_title'] : '';
        $params['s2_description'] = $settings['s2_description'] ? $settings['s2_description'] : '';
        
        $params['s3_icon'] = $settings['s3_icon'] ? $settings['s3_icon'] : '';
        $params['s3_title'] = $settings['s3_title'] ? $settings['s3_title'] : '';
        $params['s3_description'] = $settings['s3_description'] ? $settings['s3_description'] : '';



        echo cs_elementor_process_cycle($params);
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