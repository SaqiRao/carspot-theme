<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Sign_Up extends Widget_Base {

    public function get_name() {
        return 'register_short_base';
    }

    public function get_title() {
        return __('Sign Up', 'cs-elementor');
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
                'Signup_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'btn_title',
                [
                    'label' => __('Term and Condition', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Terms & Condition', 'cs-elementor'),
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
        $this->add_control(
                'terms_title',
                [
                    'label' => __('Terms & Condition Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'is_captcha',
                [
                    'label' => __('Capcha Code', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
	                    'without' => __('Without Capcha', 'cs-elementor'),
                        'with' => __('With Capcha', 'cs-elementor'),
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '#';

        $params['terms_title'] = $settings['terms_title'] ? $settings['terms_title'] : '';
        $params['is_captcha'] = $settings['is_captcha'] ? $settings['is_captcha'] : '';



        echo cs_elementor_sign_up($params);
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