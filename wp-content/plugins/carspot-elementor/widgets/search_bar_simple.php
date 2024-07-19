<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Bar_Simple extends Widget_Base {

    public function get_name() {
        return 'simple_searchbar_base';
    }

    public function get_title() {
        return __('Simple Search Bar', 'cs-elementor');
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
        /* for minimal bar keyword tab */
        $this->start_controls_section(
                'car_inspection_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        

        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['field_heading'] = $settings['field_heading'] ? $settings['field_heading'] : '';
        $params['place_title'] = $settings['place_title'] ? $settings['place_title'] : '';
        $params['want_to_show'] = $settings['want_to_show'] ? $settings['want_to_show'] : '';
        $params['cats'] = $settings['cats'] ? $settings['cats'] : array();
        $params['years'] = $settings['years'] ? $settings['years'] : array();
        $params['body_types'] = $settings['body_types'] ? $settings['body_types'] : array();



        echo cs_elementor_search_bar_minimal($params);
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