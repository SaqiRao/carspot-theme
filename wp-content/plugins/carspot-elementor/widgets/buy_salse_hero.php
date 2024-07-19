<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Buy_Sale_Hero extends Widget_Base {

    public function get_name() {
        return 'buy_sale_hero_shortcode';
    }

    public function get_title() {
        return __('Buy Or Sale Main Banner', 'cs-elementor');
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
        /* for Looking tab */
        $this->start_controls_section(
                'looking_for_tab',
                [
                    'label' => __('Looking For', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
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
                    'placeholder' => __('https://your-link.com', 'cs-elementor'),
                    'show_external' => true,
                    'label_block' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'bg_img',
                [
                    'label' => __('Background Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->end_controls_section();

        /* for Want to Hire tab */
        $this->start_controls_section(
                'want_to_hire_tab',
                [
                    'label' => __('Want To Hire', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'sell_tagline',
                [
                    'label' => __('Section Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'main_description1',
                [
                    'label' => __('Section Description', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
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
                'main_image1',
                [
                    'label' => __('Background Image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
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
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['bg_img'] = $settings['bg_img']['id'] ? $settings['bg_img']['id'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        
        $params['sell_tagline'] = $settings['sell_tagline'] ? $settings['sell_tagline'] : '';
        $params['main_description1'] = $settings['main_description1'] ? $settings['main_description1'] : '';
        $params['main_image1'] = $settings['main_image1']['id'] ? $settings['main_image1']['id'] : '';
        $params['btn_title1'] = $settings['btn_title1'] ? $settings['btn_title1'] : '';
        $params['btn_link1'] = $settings['btn_link1']['url'] ? $settings['btn_link1']['url'] : '';
        $params['target_one1'] = $settings['btn_link1']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one1'] = $settings['btn_link1']['nofollow'] ? ' rel="nofollow"' : '';
        
        
        echo cs_elementor_buy_or_sell($params);
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