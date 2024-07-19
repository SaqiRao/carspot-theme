<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Our_Team extends Widget_Base
{

    public function get_name()
    {
        return 'team_short_base';
    }

    public function get_title()
    {
        return __('Team Members', 'cs-elementor');
    }

    public function get_icon()
    {
        return 'eicon-animation';
    }

    public function get_categories()
    {
        return ['cstheme'];
    }

    public function get_script_depends()
    {
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
    protected function _register_controls()
    {
        /* for Basic tab */
        $this->start_controls_section(
            'our_team_basic_tab',
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

        /* for Basic tab */
        $this->start_controls_section(
            'our_team_tab',
            [
                'label' => __('Add Team', 'cs-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'member_name',
            [
                'label' => __('Name Of Member', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'member_desgination',
            [
                'label' => __('Desgination Of Member', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'team_img',
            [
                'label' => __('Team MemberImage', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'description' => __('Recommended Size For Image should be 555x296.png', 'cs-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
            ]
        );
        $repeater->add_control(
            'fb',
            [
                'label' => __('Facebook Link', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'twitter',
            [
                'label' => __('Twitter Link', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'google_plus',
            [
                'label' => __('Google Plus Link', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'LinkedIn',
            [
                'label' => __('LinkedIn Link', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'add_team',
            [
                'label' => __('Add Team Members', 'cs-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => '',
                        'member_desgination' => '',
                        'team_img' => '',
                        'fb' => '',
                        'twitter' => '',
                        'google_plus' => '',
                        'LinkedIn' => '',
                    ],
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['header_style'] = $settings['header_style'] ? $settings['header_style'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['add_team'] = $settings['add_team'] ? $settings['add_team'] : array();


        echo cs_elementor_our_team($params);
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
    protected function _content_template()
    {

    }
}