<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Shop_Products extends Widget_Base {

    public function get_name() {
        return 'shop_classic_base';
    }

    public function get_title() {
        return __('Shop Products', 'cs-elementor');
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
                'shop_classic_basic_tab',
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

        /* for Products tab */
        $this->start_controls_section(
                'shop_classic_products_tab',
                [
                    'label' => __('Products', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number fo Ads', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 4,
                ]
        );
        $this->add_control(
                'ad_order',
                [
                    'label' => __('Order By', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Ads order', 'cs-elementor'),
                        'asc' => __('Oldest', 'cs-elementor'),
                        'desc' => __('Latest', 'cs-elementor'),
                        'rand' => __('Random', 'cs-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'btn_title',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Button title here', 'cs-elementor'),
                    'default' => __('Button Link', 'cs-elementor'),
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
        $this->end_controls_section();
        
        /* for Categories tab */
        $this->start_controls_section(
                'shop_classic_categ_tab',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cats',
                [
                    'label' => __('Category', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('product_cat', 'no'),
                ]
        );
        $this->add_control(
                'cat',
                [
                    'label' => __('Select Categories', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'cats' => '',
                        ],
                    ],
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
        
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : '';
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        
        $params['cat'] = $settings['cat'] ? $settings['cat'] : '';
       
        echo cs_elementor_shop_classic($params);
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