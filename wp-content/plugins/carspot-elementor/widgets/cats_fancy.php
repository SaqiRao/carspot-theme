<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Cat_Fancy extends Widget_Base {

    public function get_name() {
        return 'cats_fancy_short_base';
    }

    public function get_title() {
        return __('Ads By Make', 'cs-elementor');
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
                'cat_fancy_general_tab',
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
                'hover_anim',
                [
                    'label' => __('Enable hover animation', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select an option', 'cs-elementor'),
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => ['no'],
                ]
        );
        $this->add_control(
                'cat_link_page',
                [
                    'label' => __('Category link Page', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select an option', 'cs-elementor'),
                        'search' => __('Search Page', 'cs-elementor'),
                        'category' => __('Category Page', 'cs-elementor'),
                    ],
                    'default' => ['search'],
                ]
        );
        $this->end_controls_section();

        /* for Categories tab */
        $this->start_controls_section(
                'cat_fancy_tab',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select Category', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_cats', 'no'),
                ]
        );
        $repeater->add_control(
                'img',
                [
                    'label' => __('Category Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'description' => __('Image size must be 94x90 px', 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => '',
                    ],
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'cat' => '',
                            'img' => ''
                        ],
                    ]
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
        $params['hover_anim'] = $settings['hover_anim'] ? $settings['hover_anim'] : '';
        $params['cat_link_page'] = $settings['cat_link_page'] ? $settings['cat_link_page'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();

        echo cs_elementor_cats_fancy($params);
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