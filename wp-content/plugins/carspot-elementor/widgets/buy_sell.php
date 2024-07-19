<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Buy_Sell extends Widget_Base {

    public function get_name() {
        return 'buy_sell_shortcode';
    }

    public function get_title() {
        return __('Car Buy & Sell', 'cs-elementor');
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
        /* for Buy Section tab */
        $this->start_controls_section(
                'buy_section_tab',
                [
                    'label' => __('Buy Section', 'cs-elementor'),
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
                'animation_effects',
                [
                    'label' => __('Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
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
                    'label_block' => true,
                    "description" => __("Recommended image size should be 715x215 .png ", 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();

        /* for Buy Section tab */
        $this->start_controls_section(
                'sell_section_tab',
                [
                    'label' => __('Sell Section', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'sell_tagline',
                [
                    'label' => __('Your Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'animation_effects2',
                [
                    'label' => __('Animation Effects', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => carspot_elementor_animations(),
                ]
        );
        $this->add_control(
                'btn_title1',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Button Link', 'cs-elementor'),
                    'label_block' => true
                ]
        );
        $this->add_control(
                'btn_link1',
                [
                    'label' => __('Button Link', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'cs-elementor'),
                    'label_block' => true,
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'section_description1',
                [
                    'label' => __('Section Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'main_image1',
                [
                    'label' => __('Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    "description" => __("Recommended image size should be 715x215 .png ", 'cs-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['client_tagline'] = $settings['client_tagline'] ? $settings['client_tagline'] : '';
        $params['animation_effects'] = $settings['animation_effects'] ? $settings['animation_effects'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['main_image'] = $settings['main_image']['id'] ? $settings['main_image']['id'] : '';
        
        $params['sell_tagline'] = $settings['sell_tagline'] ? $settings['sell_tagline'] : '';
        $params['animation_effects2'] = $settings['animation_effects2'] ? $settings['animation_effects2'] : '';
        $params['btn_title1'] = $settings['btn_title1'] ? $settings['btn_title1'] : '';
        $params['btn_link1'] = $settings['btn_link1']['url'] ? $settings['btn_link1']['url'] : '';
        $params['target_one1'] = $settings['btn_link1']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one1'] = $settings['btn_link1']['nofollow'] ? ' rel="nofollow"' : '';
        $params['section_description1'] = $settings['section_description1'] ? $settings['section_description1'] : '';
        $params['main_image1'] = $settings['main_image1']['id'] ? $settings['main_image1']['id'] : '';
        
        echo cs_elementor_buy_sale($params);
        
        
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