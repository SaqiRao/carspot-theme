<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Ads extends Widget_Base {

    public function get_name() {
        return 'ads_short_base';
    }

    public function get_title() {
        return __('ADS Carspot', 'cs-elementor');
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
                'aboutus_section',
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
        $this->end_controls_section();

        /* for Ad Settings tab */
        $this->start_controls_section(
                'ad_settings',
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
                    'default' => 'asc',
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
                        'grid_6' => __('Grid 6', 'cs-elementor'),
                        'grid_7' => __('Grid 7', 'cs-elementor'),
                        'list' => __('List', 'cs-elementor'),
                        'list_4' => __('List 4', 'cs-elementor'),
                    ],
                    'default' => 'grid_4',
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number fo Ads', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 3,
                    'max' => 90,
                    'step' => 1,
                    'default' => 8,
                ]
        );
        $this->add_control(
                'btn_title',
                [
                    'label' => __('Button Title', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Button title here', 'cs-elementor'),
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
        $this->end_controls_section();

        /* for Ad Category tab */
        $this->start_controls_section(
                'cs_category_tab',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'all_cat_ads',
                [
                    'label' => __('Want to show ads fom all categories?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        '' => __('Select Layout Type', 'cs-elementor'),
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cs_cats',
                [
                    'label' => __('Select Category', 'plugin-domain'),
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
                    'condition' => [
                        'all_cat_ads' => ['no']
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
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : '';
        $params['layout_type'] = $settings['layout_type'] ? $settings['layout_type'] : '';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['all_cat_ads'] = $settings['all_cat_ads'] ? $settings['all_cat_ads'] : '';

        /* ============ cats ============ */
        $cs_category_ = array();
        if ($params['all_cat_ads'] == 'no') {
            if (!empty($settings['cats'])) {
                foreach ($settings['cats'] as $item) {
                    if ($item['cs_cats'] != '') {
                        $cs_category_[] = $item['cs_cats'];
                    }
                }
            }
        }
        $params['cats'] = $cs_category_;

        echo cs_elementor_ads($params);
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