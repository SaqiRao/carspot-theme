<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Ads_Google_Map extends Widget_Base {

    public function get_name() {
        return 'ad_by_google_map';
    }

    public function get_title() {
        return __('ADs - Google Map', 'cs-elementor');
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
        /* for Ads tab */
        $this->start_controls_section(
                'ad_aetting_tab',
                [
                    'label' => __('Ads Setting', 'cs-elementor'),
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
                        'feature' => __('Featured Ads', 'cs-elementor'),
                        'regular' => __('Simple Ads', 'cs-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number fo Ads', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 4,
                ]
        );
        $this->end_controls_section();
        /* for Map tab */
        $this->start_controls_section(
                'ad_map_tab',
                [
                    'label' => __('Map', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'map_zoom',
                [
                    'label' => __('Map Zoom', 'cs-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 6,
                    'step' => 1,
                    'default' => 5,
                ]
        );
        $this->add_control(
                'map_latitude',
                [
                    'label' => __('Latitude', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Put your latitude here', 'cs-elementor'),
                ]
        );
        $this->add_control(
                'map_longitude',
                [
                    'label' => __('Longitude', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Put your longitude here', 'cs-elementor'),
                ]
        );
        $this->end_controls_section();
        /* for Category tab */
        $this->start_controls_section(
                'ad_categories_tab',
                [
                    'label' => __('Categories', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Category', 'plugin-domain'),
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
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => ''
                    ],
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Select Category', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'cat' => '',
                            'img' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['ad_type'] = $settings['ad_type'] ? $settings['ad_type'] : '';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : '';
        $params['map_zoom'] = $settings['map_zoom'] ? $settings['map_zoom'] : '';
        $params['map_latitude'] = $settings['map_latitude'] ? $settings['map_latitude'] : '';
        $params['map_longitude'] = $settings['map_longitude'] ? $settings['map_longitude'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();

        echo cs_elementor_ads_google_map($params);
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