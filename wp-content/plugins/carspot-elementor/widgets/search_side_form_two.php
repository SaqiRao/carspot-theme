<?php
namespace ElementorCarspot\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Side_Form_Two extends Widget_Base {

    public function get_name() {
        return 'search_side_two_form_base';
    }

    public function get_title() {
        return __('Search Side Form Two', 'cs-elementor');
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
        /* for basic tab */
        $this->start_controls_section(
                'search_side_form_two_basic_tab',
                [
                    'label' => __('Basic', 'cs-elementor'),
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
                'section_tag_line',
                [
                    'label' => __('Section Tagline', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' => __('Text below the main heading.', 'cs-elementor'),
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'single_feature',
                [
                    'label' => __('List', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'feature_list',
                [
                    'label' => __('Features List', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'single_feature' => '',
                        ],
                    ],
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
                'float_car_img',
                [
                    'label' => __('Floating car image', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => '',
                    ],
                ]
        );
        $this->end_controls_section();

        /* for form detail tab */
        $this->start_controls_section(
                'search_side_form_two_detil_tab',
                [
                    'label' => __('Form Detail', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('No of posts', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ],
        );
        $this->add_control(
                'form_text',
                [
                    'label' => __('Form Detail', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $this->end_controls_section();

        /* for Filters tab */
        $this->start_controls_section(
                'search_form_two_filter_tab',
                [
                    'label' => __('Filters', 'cs-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        /* category */
        $this->add_control(
                'categ_show_form',
                [
                    'label' => __('Do you want to show Category on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_catego_field',
                [
                    'label' => __('Label for Category Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'categ_show_form' => ['yes']
                    ],
                ]
        );
        /* year */
        $this->add_control(
                'year_show_form',
                [
                    'label' => __('Do you want to show Year on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_year_field',
                [
                    'label' => __('Label for Year Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'year_show_form' => ['yes']
                    ],
                ]
        );
        /* tag */
        $this->add_control(
                'tag_show_form',
                [
                    'label' => __('Do you want to show Tags on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                       'no',
                    ],
                ]
        );
        $this->add_control(
                'label_tag_field',
                [
                    'label' => __('Label for Tag Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'tag_show_form' => ['yes']
                    ],
                ]
        );
        /* Condition */
        $this->add_control(
                'condition_show_form',
                [
                    'label' => __('Do you want to show Condition on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_condition_field',
                [
                    'label' => __('Label for Condition Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'condition_show_form' => ['yes']
                    ],
                ]
        );
        /* type */
        $this->add_control(
                'type_show_form',
                [
                    'label' => __('Do you want to show Type on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_type_field',
                [
                    'label' => __('Label for Type Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'type_show_form' => ['yes']
                    ],
                ]
        );
        /* warranty */
        $this->add_control(
                'warranty_show_form',
                [
                    'label' => __('Do you want to show Warranty on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_warranty_field',
                [
                    'label' => __('Label for Warranty Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'warranty_show_form' => ['yes']
                    ],
                ]
        );
        /* Body Type */
        $this->add_control(
                'body_type_show_form',
                [
                    'label' => __('Do you want to show Body Type on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_body_type_field',
                [
                    'label' => __('Label for Body Type Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'body_type_show_form' => ['yes']
                    ],
                ]
        );
        /* Transmission */
        $this->add_control(
                'transmission_show_form',
                [
                    'label' => __('Do you want to show Transmission on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_transmission_field',
                [
                    'label' => __('Label for Transmission Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'transmission_show_form' => ['yes']
                    ],
                ]
        );
        /* Engine size */
        $this->add_control(
                'engine_size_show_form',
                [
                    'label' => __('Do you want to show Engine size on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_engine_size_field',
                [
                    'label' => __('Label for Engine size Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'engine_size_show_form' => ['yes']
                    ],
                ]
        );
        /* Engine Type */
        $this->add_control(
                'engine_type_show_form',
                [
                    'label' => __('Do you want to show Engine Type on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_engine_type_field',
                [
                    'label' => __('Label for Engine Type Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'engine_type_show_form' => ['yes']
                    ],
                ]
        );
        /* Assembly */
        $this->add_control(
                'assembly_show_form',
                [
                    'label' => __('Do you want to show Assembly on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_assembly_field',
                [
                    'label' => __('Label for Assembly Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'assembly_show_form' => ['yes']
                    ],
                ]
        );

        /* Color */
        $this->add_control(
                'color_show_form',
                [
                    'label' => __('Do you want to show Color on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                       'no',
                    ],
                ]
        );
        $this->add_control(
                'label_color_field',
                [
                    'label' => __('Label for Color Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'color_show_form' => ['yes']
                    ],
                ]
        );
        /* Insurance */
        $this->add_control(
                'insurance_show_form',
                [
                    'label' => __('Do you want to show Insurance on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_insurance_field',
                [
                    'label' => __('Label for Insurance Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'insurance_show_form' => ['yes']
                    ],
                ]
        );
        /* Features */
        $this->add_control(
                'features_show_form',
                [
                    'label' => __('Do you want to show Features on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                       'no',
                    ],
                ]
        );
        $this->add_control(
                'label_feature_field',
                [
                    'label' => __('Label for Features Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'features_show_form' => ['yes']
                    ],
                ]
        );
        /* Countires */
        $this->add_control(
                'countries_show_form',
                [
                    'label' => __('Do you want to show Countires on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                       'no',
                    ],
                ]
        );
        $this->add_control(
                'label_country_field',
                [
                    'label' => __('Label for Countires Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'countries_show_form' => ['yes']
                    ],
                ]
        );
        /* Price Range */
        $this->add_control(
                'price_show_form',
                [
                    'label' => __('Do you want to show Price Range on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'label_price_field',
                [
                    'label' => __('Label for Price Range Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'price_show_form' => ['yes']
                    ],
                ]
        );
        /* Radius */
        $this->add_control(
                'radius_show_form',
                [
                    'label' => __('Do you want to show Radius on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'yes' => __('Yes', 'cs-elementor'),
                        'no' => __('No', 'cs-elementor'),
                    ],
                    'default' => [
                        'no',
                    ],
                ]
        );
        $this->add_control(
                'radius_distance_unit',
                [
                    'label' => __('Do you want to show Radius on Form?', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => [
                        'miles' => __('Miles', 'cs-elementor'),
                        'km' => __('KM', 'cs-elementor'),
                    ],
                    'condition' => [
                        'radius_show_form' => ['yes']
                    ],
                    'default' => [
                       'km',
                    ],
                ]
        );
        $this->add_control(
                'label_radius_field',
                [
                    'label' => __('Label for Radius Field', 'cs-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'radius_show_form' => ['yes']
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['feature_list'] = $settings['feature_list'] ? $settings['feature_list'] : array();
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['float_car_img'] = $settings['float_car_img']['id'] ? $settings['float_car_img']['id'] : '';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : '';
        $params['form_text'] = $settings['form_text'] ? $settings['form_text'] : '';
        $params['categ_show_form'] = $settings['categ_show_form'] ? $settings['categ_show_form'] : '';
        $params['label_catego_field'] = $settings['label_catego_field'] ? $settings['label_catego_field'] : '';

        $params['year_show_form'] = $settings['year_show_form'] ? $settings['year_show_form'] : '';
        $params['label_year_field'] = $settings['label_year_field'] ? $settings['label_year_field'] : '';

        $params['tag_show_form'] = $settings['tag_show_form'] ? $settings['tag_show_form'] : '';
        $params['label_tag_field'] = $settings['label_tag_field'] ? $settings['label_tag_field'] : '';

        $params['condition_show_form'] = $settings['condition_show_form'] ? $settings['condition_show_form'] : '';
        $params['label_condition_field'] = $settings['label_condition_field'] ? $settings['label_condition_field'] : '';

        $params['type_show_form'] = $settings['type_show_form'] ? $settings['type_show_form'] : '';
        $params['label_type_field'] = $settings['label_type_field'] ? $settings['label_type_field'] : '';

        $params['warranty_show_form'] = $settings['warranty_show_form'] ? $settings['warranty_show_form'] : '';
        $params['label_warranty_field'] = $settings['label_warranty_field'] ? $settings['label_warranty_field'] : '';

        $params['body_type_show_form'] = $settings['body_type_show_form'] ? $settings['body_type_show_form'] : '';
        $params['label_body_type_field'] = $settings['label_body_type_field'] ? $settings['label_body_type_field'] : '';

        $params['transmission_show_form'] = $settings['transmission_show_form'] ? $settings['transmission_show_form'] : '';
        $params['label_transmission_field'] = $settings['label_transmission_field'] ? $settings['label_transmission_field'] : '';

        $params['engine_size_show_form'] = $settings['engine_size_show_form'] ? $settings['engine_size_show_form'] : '';
        $params['label_engine_size_field'] = $settings['label_engine_size_field'] ? $settings['label_engine_size_field'] : '';

        $params['engine_type_show_form'] = $settings['engine_type_show_form'] ? $settings['engine_type_show_form'] : '';
        $params['label_engine_type_field'] = $settings['label_engine_type_field'] ? $settings['label_engine_type_field'] : '';

        $params['assembly_show_form'] = $settings['assembly_show_form'] ? $settings['assembly_show_form'] : '';
        $params['label_assembly_field'] = $settings['label_assembly_field'] ? $settings['label_assembly_field'] : '';

        $params['color_show_form'] = $settings['color_show_form'] ? $settings['color_show_form'] : '';
        $params['label_color_field'] = $settings['label_color_field'] ? $settings['label_color_field'] : '';

        $params['insurance_show_form'] = $settings['insurance_show_form'] ? $settings['insurance_show_form'] : '';
        $params['label_insurance_field'] = $settings['label_insurance_field'] ? $settings['label_insurance_field'] : '';

        $params['features_show_form'] = $settings['features_show_form'] ? $settings['features_show_form'] : '';
        $params['label_feature_field'] = $settings['label_feature_field'] ? $settings['label_feature_field'] : '';

        $params['countries_show_form'] = $settings['countries_show_form'] ? $settings['countries_show_form'] : '';
        $params['label_country_field'] = $settings['label_country_field'] ? $settings['label_country_field'] : '';

        $params['price_show_form'] = $settings['price_show_form'] ? $settings['price_show_form'] : '';
        $params['label_price_field'] = $settings['label_price_field'] ? $settings['label_price_field'] : '';

        $params['radius_show_form'] = $settings['radius_show_form'] ? $settings['radius_show_form'] : '';
        $params['radius_distance_unit'] = $settings['radius_distance_unit'] ? $settings['radius_distance_unit'] : '';
        $params['label_radius_field'] = $settings['label_radius_field'] ? $settings['label_radius_field'] : '';


        echo cs_elementor_search_side_form_two($params);
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