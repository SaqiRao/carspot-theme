<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Ads_Slider extends Widget_Base {

    public function get_name() {
        return 'ads_slider_shortcode';
    }

    public function get_title() {
        return __('ADs - Slider', 'cs-elementor');
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
                'ad_location_basic_tab',
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
        /* for Ads tab */
        $this->start_controls_section(
                'ad_settings_tab',
                [
                    'label' => __('Ads Settings', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'ad_type',
                [
                    'label' => __('Ads Type', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Ads Type', 'cs-elementor'),
                        'feature' => __('Featured Ads', 'cs-elementor'),
                        'regular' => __('Simple Ads', 'cs-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'layout_type',
                [
                    'label' => __('Layout Type', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Layout Type', 'cs-elementor'),
                        'grid_1' => __('Grid 1', 'cs-elementor'),
                        'grid_2' => __('Grid 2', 'cs-elementor'),
                        'grid_3' => __('Grid 3', 'cs-elementor'),
                        'grid_4' => __('Grid 4', 'cs-elementor'),
                        'grid_5' => __('Grid 5', 'cs-elementor'),
                    ],
                    'default' => 'grid_4'
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number fo Ads', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 90,
                    'step' => 1,
                    'default' => 8,
                ]
        );
        $this->end_controls_section();
        /* for Categories tab */
        $this->start_controls_section(
                'ad_categories_tab',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cs_cats',
                [
                    'label' => __('Select Category', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => cs_elementor_get_parents_cats('ad_cats', 'no'),
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
                            'cs_cats' => '',
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
        $params['ad_type'] = $settings['ad_type'] ? $settings['ad_type'] : '';
        $params['layout_type'] = $settings['layout_type'] ? $settings['layout_type'] : '';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : '';
        // $params['cats'] = $settings['cats'] ? $settings['cats'] : array();

        /* ============ cats ============ */
        $cs_category_ = array();
        if (!empty($settings['cats'])) {
            foreach ($settings['cats'] as $item) {
                if ($item['cs_cats'] != '') {
                    $cs_category_[] = $item['cs_cats'];
                }
            }
        }
        $params['cats'] = $cs_category_;
       
        echo cs_elementor_ads_slider($params);
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