<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us_Fancy extends Widget_Base {

    public function get_name() {
        return 'about_fancy';
    }

    public function get_title() {
        return __('About Us Modern/Fancy', 'cs-elementor');
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
                'about_us_tab',
                [
                    'label' => __('About Us', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'bg_img',
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
                'section_title_about',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => __('About Car Spot Dealership', 'cs-elementor'),
                    'placeholder' => __('About Carspot Dealership', 'cs-elementor'),
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

        /* for Services */
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'services',
                [
                    'label' => __('Service', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );

        $this->add_control(
                'services_add_left',
                [
                    'label' => __('Services', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'label_block' => true,
                    'default' => [
                        [
                            'services' => __('Extend the life of the car', 'cs-elementor'),
                        ],
                    ],
                ]
        );
        $this->end_controls_section();

        /* for content tab */
        $this->start_controls_section(
                'content_tab',
                [
                    'label' => __('Content', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'content',
                [
                    'label' => __('Content', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'default' => __('Content', 'cs-elementor'),
                    'label_block' => true,
                    'placeholder' => __('Your Content here', 'cs-elementor'),
                ]
        );
        $this->end_controls_section();
        /* for funfacts */
        $this->start_controls_section(
                'fun_fact_tab',
                [
                    'label' => __('Fun Facts', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'p_cols',
                [
                    'label' => __('Column', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '4' => __('3 Col', 'cs-elementor'),
                        '3' => __('4 Col', 'cs-elementor'),
                    ],
                    'default' => '3',
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'icon',
                [
                    'label' => __('Icon', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => ('flaticon-vehicle'),
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'numbers',
                [
                    'label' => __('Numbers', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => ('12000'),
                    'placeholder' => __('Eter only numeric', 'cs-elementor'),
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'title',
                [
                    'label' => __('Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Some Title', 'cs-elementor'),
                    'placeholder' => __('Enter Title here.', 'cs-elementor'),
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'color_title',
                [
                    'label' => __('Color Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Color Title', 'cs-elementor'),
                    'placeholder' => __('Enter Color Title', 'cs-elementor'),
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'fun_facts',
                [
                    'label' => __('Fun Facts', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon' => 'flaticon-key',
                            'numbers' => '2500',
                            'title' => __('Your Title', 'cs-elementor'),
                            'color_title' => __('Your Color Title', 'cs-elementor'),
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['bg_img'] = $settings['bg_img']['id'] ? $settings['bg_img']['id'] : '';
        $params['section_title_about'] = $settings['section_title_about'] ? $settings['section_title_about'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['services_add_left'] = $settings['services_add_left'] ? $settings['services_add_left'] : '';
        $params['content'] = $settings['content'] ? $settings['content'] : '';
        $params['p_cols'] = $settings['p_cols'] ? $settings['p_cols'] : '';
        $params['fun_facts'] = $settings['fun_facts'] ? $settings['fun_facts'] : '';

        echo cs_elementor_about_fancy($params);
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