<?php
/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('search_side_two_form')) {

    function search_side_two_form() {
        vc_map(array(
            "name" => esc_html__("Search Side Form Two", 'carspot'),
            "base" => "search_side_two_form_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('search_side_form.png') . esc_html__('Output of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Tagline", 'carspot'),
                    "description" => esc_html__("Text below the main heading.", 'carspot'),
                    "param_name" => "section_tag_line",
                ),
                array(
                    'group' => esc_html__('Basic', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Features List', 'carspot'),
                    'param_name' => 'feature_list',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("List", 'carspot'),
                            "param_name" => "single_feature",
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Read More Link", 'carspot'),
                    "param_name" => "post_job_btn_link",
                    "description" => esc_html__("Link where you want to ridirect.", "'carspot"),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'carspot'),
                    "param_name" => "bg_img",
                    "description" => esc_html__("1280x800", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Floating car image", 'carspot'),
                    "param_name" => "float_car_img",
                    "description" => esc_html__("Should be transparent", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Form Detail", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("No of posts", 'carspot'),
                    "param_name" => "no_of_ads",
                ),
                array(
                    "group" => esc_html__("Form Detail", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Form text", 'carspot'),
                    "param_name" => "form_text",
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Category on Form? ", 'carspot'),
                    "param_name" => "categ_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('No', 'carspot') => 'no',
                        __('Yes', 'carspot') => 'yes',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'yes',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Category Field", 'carspot'),
                    "param_name" => "label_catego_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'catego_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Year on Form? ", 'carspot'),
                    "param_name" => "year_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Year Field", 'carspot'),
                    "param_name" => "label_year_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'year_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Tags on Form? ", 'carspot'),
                    "param_name" => "tag_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Tag Field", 'carspot'),
                    "param_name" => "label_tag_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'tag_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Condition on Form? ", 'carspot'),
                    "param_name" => "condition_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Condition Field", 'carspot'),
                    "param_name" => "label_condition_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'condition_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Type on Form? ", 'carspot'),
                    "param_name" => "type_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Type Field", 'carspot'),
                    "param_name" => "label_type_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'type_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Warranty on Form? ", 'carspot'),
                    "param_name" => "warranty_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Warranty Field", 'carspot'),
                    "param_name" => "label_warranty_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'warranty_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Body Type on Form? ", 'carspot'),
                    "param_name" => "body_type_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Body Type Field", 'carspot'),
                    "param_name" => "label_body_type_field",
                    'dependency' => array(
                        'element' => 'body_type_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Transmission on Form? ", 'carspot'),
                    "param_name" => "transmission_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Transmission Field", 'carspot'),
                    "param_name" => "label_transmission_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'transmission_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Engine size on Form? ", 'carspot'),
                    "param_name" => "engine_size_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Engine size Field", 'carspot'),
                    "param_name" => "label_engine_size_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'engine_size_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Engine Type on Form? ", 'carspot'),
                    "param_name" => "engine_type_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Engine Type Field", 'carspot'),
                    "param_name" => "label_engine_type_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'engine_type_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Assembly on Form? ", 'carspot'),
                    "param_name" => "assembly_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Assembly Field", 'carspot'),
                    "param_name" => "label_assembly_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'assembly_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Color on Form? ", 'carspot'),
                    "param_name" => "color_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Color Field", 'carspot'),
                    "param_name" => "label_color_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'color_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Insurance on Form? ", 'carspot'),
                    "param_name" => "insurance_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Insurance Field", 'carspot'),
                    "param_name" => "label_insurance_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'insurance_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Features on Form? ", 'carspot'),
                    "param_name" => "features_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Features Field", 'carspot'),
                    "param_name" => "label_feature_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'features_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Countires on Form? ", 'carspot'),
                    "param_name" => "countries_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Countiry Field", 'carspot'),
                    "param_name" => "label_country_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'countries_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Price Range on Form? ", 'carspot'),
                    "param_name" => "price_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Price Field", 'carspot'),
                    "param_name" => "label_price_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'price_show_form',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Do you want to show Radius on Form? ", 'carspot'),
                    "param_name" => "radius_show_form",
                    "admin_label" => true,
                    "value" => array(
                        __('Yes', 'carspot') => 'yes',
                        __('No', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                ),
                array(
                    'group' => __('Filters', 'carspot'),
                    "type" => "dropdown",
                    "heading" => __("Please Choose Distance Unit ", 'carspot'),
                    "param_name" => "radius_distance_unit",
                    "admin_label" => true,
                    "value" => array(
                        __('Miles', 'carspot') => 'miles',
                        __('KM', 'carspot') => 'km',
                    ),
                    'dependency' => array(
                        'element' => 'radius_show_form',
                        'value' => array('yes'),
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'km',
                ),
                array(
                    "group" => esc_html__('Filters', 'carspot'),
                    "type" => "textfield",
                    "heading" => esc_html__("Label for Radius Field", 'carspot'),
                    "param_name" => "label_radius_field",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'radius_show_form',
                        'value' => array('yes'),
                    ),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_side_two_form');
if (!function_exists('search_side_two_form_func')) {

    function search_side_two_form_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'post_job_btn_link' => '',
            'no_of_ads' => '',
            'form_text' => '',
            'float_car_img' => '',
            'feature_list' => '',
            'categ_show_form' => '',
            'label_catego_field' => '',
            'year_show_form' => '',
            'label_year_field' => '',
            'tag_show_form' => '',
            'label_tag_field' => '',
            'condition_show_form' => '',
            'label_condition_field' => '',
            'type_show_form' => '',
            'label_type_field' => '',
            'warranty_show_form' => '',
            'label_warranty_field' => '',
            'body_type_show_form' => '',
            'label_body_type_field' => '',
            'transmission_show_form' => '',
            'label_transmission_field' => '',
            'engine_size_show_form' => '',
            'label_engine_size_field' => '',
            'engine_type_show_form' => '',
            'label_engine_type_field' => '',
            'assembly_show_form' => '',
            'label_assembly_field' => '',
            'color_show_form' => '',
            'label_color_field' => '',
            'insurance_show_form' => '',
            'label_insurance_field' => '',
            'features_show_form' => '',
            'label_feature_field' => '',
            'countries_show_form' => '',
            'label_country_field' => '',
            'price_show_form' => '',
            'label_price_field' => '',
            'radius_show_form' => '',
            'radius_distance_unit' => '',
            'label_radius_field' => ''
                        ), $atts));
        global $carspot_theme;

        /* make/category field label */
        $label_catego_field_ = __('Select Make : Any make', 'carspot');
        if (isset($label_catego_field) && $label_catego_field != '') {
            $label_catego_field_ = $label_catego_field;
        }

        /* year field label */
        $label_year_field_ = __('Select Manufacturing Year', 'carspot');
        if (isset($label_year_field) && $label_year_field != '') {
            $label_year_field_ = $label_year_field;
        }

        /* Condition field label */
        $label_condition_field_ = __('Select Condition', 'carspot');
        if (isset($label_condition_field) && $label_condition_field != '') {
            $label_condition_field_ = $label_condition_field;
        }

        /* Tag field label */
        $label_tag_field_ = __('Select Tag', 'carspot');
        if (isset($label_tag_field) && $label_tag_field != '') {
            $label_tag_field_ = $label_tag_field;
        }

        /* Ad Type field label */
        $label_type_field_ = __('Select Ad Type', 'carspot');
        if (isset($label_type_field) && $label_type_field != '') {
            $label_type_field_ = $label_type_field;
        }

        /* Warranty field label */
        $label_warranty_field_ = __('Select Warranty', 'carspot');
        if (isset($label_warranty_field) && $label_warranty_field != '') {
            $label_warranty_field_ = $label_warranty_field;
        }

        /* Body Type field label */
        $label_body_type_field_ = __('Select Body Type', 'carspot');
        if (isset($label_body_type_field) && $label_body_type_field != '') {
            $label_body_type_field_ = $label_body_type_field;
        }

        /* Transmission field label */
        $label_transmission_field_ = __('Select Transmission', 'carspot');
        if (isset($label_transmission_field) && $label_transmission_field != '') {
            $label_transmission_field_ = $label_transmission_field;
        }

        /* Engine Size field label */
        $label_engine_size_field_ = __('Select Engine Size', 'carspot');
        if (isset($label_engine_size_field) && $label_engine_size_field != '') {
            $label_engine_size_field_ = $label_engine_size_field;
        }

        /* Engine Type field label */
        $label_engine_type_field_ = __('Select Engine Type', 'carspot');
        if (isset($label_engine_type_field) && $label_engine_type_field != '') {
            $label_engine_type_field_ = $label_engine_type_field;
        }

        /* Assemble field label */
        $label_assembly_field_ = __('Select Assemble', 'carspot');
        if (isset($label_assembly_field) && $label_assembly_field != '') {
            $label_assembly_field_ = $label_assembly_field;
        }

        /* Color field label */
        $label_color_field_ = __('Select Color', 'carspot');
        if (isset($label_color_field) && $label_color_field != '') {
            $label_color_field_ = $label_color_field;
        }

        /* Insurance field label */
        $label_insurance_field_ = __('Select Insurance', 'carspot');
        if (isset($label_insurance_field) && $label_insurance_field != '') {
            $label_insurance_field_ = $label_insurance_field;
        }

        /* Feature field label */
        $label_feature_field_ = __('Select Feature', 'carspot');
        if (isset($label_feature_field) && $label_feature_field != '') {
            $label_feature_field_ = $label_feature_field;
        }

        /* Country field label */
        $label_country_field_ = __('Select Country', 'carspot');
        if (isset($label_country_field) && $label_country_field != '') {
            $label_country_field_ = $label_country_field;
        }

        /* Price field label */
        $label_price_field_ = __('Choose Price', 'carspot');
        if (isset($label_price_field) && $label_price_field != '') {
            $label_price_field_ = $label_price_field;
        }

        /* Radius field label */
        $label_radius_field_ = __('Choose Location With Radius', 'carspot');
        if (isset($label_radius_field) && $label_radius_field != '') {
            $label_radius_field_ = $label_radius_field;
        }

        /* Radius Unit */
        $radius_distance_unit_ = __('KM', 'carspot');
        if (isset($radius_distance_unit) && $radius_distance_unit != '') {
            $radius_distance_unit_ = __('Miles', 'carspot');
        }


        /* ====================
         *  for category 
          ===================== */
        $cats_html = '';
        $heading = '';
        if (isset($carspot_theme['cat_level_1']) && $carspot_theme['cat_level_1'] != "") {
            $heading = $carspot_theme['cat_level_1'];
        }
        //if (isset($categ_show_form) && $categ_show_form == "yes") {
        $catego_option = '';
        $all_cats = carspot_get_cats('ad_cats', 0);
        if (is_array($all_cats) && count($all_cats) > 0) {
            foreach ($all_cats as $all_cat) {
                $catego_option .= '<option value="' . $all_cat->term_id . '">' . $all_cat->name . '</option>';
            }
        }

        /* cats html */
        $cats_html .= '<div class="form-group">
                                    <label>' . $heading . '</label>
                                        <select class="form-control make" id="make_id_2">
                                            <option label="' . $label_catego_field_ . '" value="">' . $label_catego_field_ . '</option>
										' . $catego_option . '
                                        </select>
                                        <input type="hidden" name="cat_id" id="cat_id_2" value="" />
                                </div>';
        //}
        /* ====================
         *  for years 
          ===================== */
        $years_html = '';
        if (isset($year_show_form) && $year_show_form == "yes") {
            $year_option = '';
            $ad_years = carspot_get_cats('ad_years', 0);
            if (is_array($ad_years) && count($ad_years) > 0) {
                foreach ($ad_years as $ad_year) {
                    $year_option .= '<option value="' . $ad_year->name . '">' . $ad_year->name . '</option>';
                }
            }
            /* year html */
            $years_html .= '<div class="form-group">
                                <label>' . $label_year_field_ . '</label>
                                <div class="input-group">
                                    <span class="input-group-addon">' . __("From", "carspot") . '</span>
                                        <select id="year_from" name="year_from" class="form-control">
                                            <option label="' . __('Year From', 'carspot') . '" value="">' . __('Year From', 'carspot') . '</option>
						' . $year_option . '
                                        </select>
                                    <span class="input-group-addon">' . __("To", "carspot") . '</span>
                                        <select id="year_to" name="year_to" class="form-control">
                                            <option label="' . __('Year To', 'carspot') . '" value="">' . __('Year To', 'carspot') . '</option>
                                                ' . $year_option . '
                                        </select>
                                </div>
                            </div>';
        }



        /* ====================
         *  for tags 
          ===================== */
        $tag_html = '';
        if (isset($tag_show_form) && $tag_show_form == "yes") {
            $tag_option = '';
            $all_tags = carspot_get_cats('ad_tags', 0);
            if (is_array($all_tags) && count($all_tags) > 0) {
                foreach ($all_tags as $all_tag) {
                    $tag_option .= '<option value="' . $all_tag->term_id . '">' . $all_tag->name . '</option>';
                }
            }
            /* tags html */
            $tag_html .= '<div class="form-group">
                                    <label>' . $label_tag_field_ . '</label>
                                        <select class=" form-control make" name="ad_tag">
                                            <option label="' . $label_tag_field_ . '" value="">' . $label_tag_field_ . '</option>
										' . $tag_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for condition 
          ===================== */
        $condition_html = '';
        if (isset($condition_show_form) && $condition_show_form == "yes") {
            $condition_option = '';
            $all_conditions = carspot_get_cats('ad_condition', 0);
            if (is_array($all_conditions) && count($all_conditions) > 0) {
                foreach ($all_conditions as $all_condition) {
                    $condition_option .= '<option value="' . $all_condition->name . '">' . $all_condition->name . '</option>';
                }
            }
            /* condition html */
            $condition_html .= '<div class="form-group">
                                    <label>' . $label_condition_field_ . '</label>
                                        <select class=" form-control make" name="condition">
                                            <option label="' . $label_condition_field_ . '" value="">' . $label_condition_field_ . '</option>
										' . $condition_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Type 
          ===================== */
        $type_html = '';
        if (isset($type_show_form) && $type_show_form == "yes") {
            $type_option = '';
            $all_types = carspot_get_cats('ad_type', 0);
            if (is_array($all_types) && count($all_types) > 0) {
                foreach ($all_types as $all_type) {
                    $type_option .= '<option value="' . $all_type->name . '">' . $all_type->name . '</option>';
                }
            }
            /* Type html */
            $type_html .= '<div class="form-group">
                                    <label>' . $label_type_field_ . '</label>
                                        <select class=" form-control make" name="ad_type">
                                            <option label="' . $label_type_field_ . '" value="">' . $label_type_field_ . '</option>
										' . $type_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Warranty 
          ===================== */
        $warranty_html = '';
        if (isset($warranty_show_form) && $warranty_show_form == "yes") {
            $warranty_option = '';
            $all_warranties = carspot_get_cats('ad_warranty', 0);
            if (is_array($all_warranties) && count($all_warranties) > 0) {
                foreach ($all_warranties as $all_warranty) {
                    $warranty_option .= '<option value="' . $all_warranty->name . '">' . $all_warranty->name . '</option>';
                }
            }
            /* Warranty html */
            $warranty_html .= '<div class="form-group">
                                    <label>' . $label_warranty_field_ . '</label>
                                        <select class=" form-control make" name="warranty">
                                            <option label="' . $label_warranty_field_ . '" value="">' . $label_warranty_field_ . '</option>
										' . $warranty_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Body Type 
          ===================== */
        $body_type_html = '';
        if (isset($body_type_show_form) && $body_type_show_form == "yes") {
            $body_type_option = '';
            $all_body_types = carspot_get_cats('ad_body_types', 0);

            if (is_array($all_body_types) && count($all_body_types) > 0) {
                foreach ($all_body_types as $all_body_type) {
                    $body_type_option .= '<option value="' . $all_body_type->name . '">' . $all_body_type->name . '</option>';
                }
            }
            /* Body Type html */
            $body_type_html .= '<div class="form-group">
                                    <label>' . $label_body_type_field_ . '</label>
                                        <select class=" form-control make" name="body_type">
                                            <option label="' . $label_body_type_field_ . '" value="">' . $label_body_type_field_ . '</option>
										' . $body_type_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Transmission 
          ===================== */
        $transmission_html = '';
        if (isset($transmission_show_form) && $transmission_show_form == "yes") {
            $transmission_option = '';
            $all_transmissions = carspot_get_cats('ad_transmissions', 0);
            if (is_array($all_transmissions) && count($all_transmissions) > 0) {
                foreach ($all_transmissions as $all_transmission) {
                    $transmission_option .= '<option value="' . $all_transmission->name . '">' . $all_transmission->name . '</option>';
                }
            }
            /* Transmission html */
            $transmission_html .= '<div class="form-group">
                                    <label>' . $label_transmission_field_ . '</label>
                                        <select class=" form-control make" name="transmission">
                                            <option label="' . $label_transmission_field_ . '" value="">' . $label_transmission_field_ . '</option>
										' . $transmission_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Engine Size 
          ===================== */
        $engineSize_html = '';
        if (isset($engine_size_show_form) && $engine_size_show_form == "yes") {
            $engineSize_option = '';
            $all_engineSizes = carspot_get_cats('ad_engine_capacities', 0);
            if (is_array($all_engineSizes) && count($all_engineSizes) > 0) {
                foreach ($all_engineSizes as $all_engineSize) {
                    $engineSize_option .= '<option value="' . $all_engineSize->name . '">' . $all_engineSize->name . '</option>';
                }
            }
            /* Engine Size html */
            $engineSize_html .= '<div class="form-group">
                                    <label>' . $label_engine_size_field_ . '</label>
                                        <select class=" form-control make" name="engine_capacity">
                                            <option label="' . $label_engine_size_field_ . '" value="">' . $label_engine_size_field_ . '</option>
										' . $engineSize_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Engine Type 
          ===================== */
        $engineType_html = '';
        if (isset($engine_type_show_form) && $engine_type_show_form == "yes") {
            $engineType_option = '';
            $all_engineTypes = carspot_get_cats('ad_engine_types', 0);
            if (is_array($all_engineTypes) && count($all_engineTypes) > 0) {
                foreach ($all_engineTypes as $all_engineType) {
                    $engineType_option .= '<option value="' . $all_engineType->name . '">' . $all_engineType->name . '</option>';
                }
            }
            /* Engine Type html */
            $engineType_html .= '<div class="form-group">
                                    <label>' . $label_engine_type_field_ . '</label>
                                        <select class=" form-control make" name="engine_type">
                                            <option label="' . $label_engine_type_field_ . '" value="">' . $label_engine_type_field_ . '</option>
										' . $engineType_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Assembly 
          ===================== */
        $assembly_html = '';
        if (isset($assembly_show_form) && $assembly_show_form == "yes") {
            $assembly_option = '';
            $all_assembles = carspot_get_cats('ad_assembles', 0);
            if (is_array($all_assembles) && count($all_assembles) > 0) {
                foreach ($all_assembles as $all_assemble) {
                    $assembly_option .= '<option value="' . $all_assemble->name . '">' . $all_assemble->name . '</option>';
                }
            }
            /* asemble html */
            $assembly_html .= '<div class="form-group">
                                    <label>' . $label_assembly_field_ . '</label>
                                        <select class=" form-control make" name="assembly">
                                            <option label="' . $label_assembly_field_ . '" value="">' . $label_assembly_field_ . '</option>
										' . $assembly_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Color 
          ===================== */
        $color_html = '';
        if (isset($color_show_form) && $color_show_form == "yes") {
            $color_option = '';
            $all_colors = carspot_get_cats('ad_colors', 0);
            if (is_array($all_colors) && count($all_colors) > 0) {
                foreach ($all_colors as $all_color) {
                    $color_option .= '<option value="' . $all_color->name . '">' . $all_color->name . '</option>';
                }
            }
            /* color html */
            $color_html .= '<div class="form-group">
                                    <label>' . $label_color_field_ . '</label>
                                        <select class=" form-control make" name="color_family">
                                            <option label="' . $label_color_field_ . '" value="">' . $label_color_field_ . '</option>
										' . $color_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Insurance 
          ===================== */
        $insurance_html = '';
        if (isset($insurance_show_form) && $insurance_show_form == "yes") {
            $insurance_option = '';
            $all_insurances = carspot_get_cats('ad_insurance', 0);
            if (is_array($all_insurances) && count($all_insurances) > 0) {
                foreach ($all_insurances as $all_insurance) {
                    $insurance_option .= '<option value="' . $all_insurance->name . '">' . $all_insurance->name . '</option>';
                }
            }
            /* Insurance html */
            $insurance_html .= '<div class="form-group">
                                    <label>' . $label_insurance_field_ . '</label>
                                        <select class=" form-control make" name="insurance">
                                            <option label="' . $label_insurance_field_ . '" value="">' . $label_insurance_field_ . '</option>
										' . $insurance_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Features 
          ===================== */
        $feature_html = '';
        if (isset($features_show_form) && $features_show_form == "yes") {
            $feature_option = '';
            $all_features = carspot_get_cats('ad_features', 0);
            if (is_array($all_features) && count($all_features) > 0) {
                foreach ($all_features as $all_feature) {
                    $feature_option .= '<option value="' . $all_feature->name . '">' . $all_feature->name . '</option>';
                }
            }
            /* feature html */
            $feature_html .= '<div class="form-group">
                                    <label>' . $label_feature_field_ . '</label>
                                        <select class=" form-control make" name="ad_feature">
                                            <option label="' . $label_feature_field_ . '" value="">' . $label_feature_field_ . '</option>
										' . $feature_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Countries 
          ===================== */
        $countries_html = '';
        if (isset($countries_show_form) && $countries_show_form == "yes") {
            $countries_option = '';
            $all_countries = carspot_get_cats('ad_country', 0);
            if (is_array($all_countries) && count($all_countries) > 0) {
                foreach ($all_countries as $all_countrie) {
                    $countries_option .= '<option value="' . $all_countrie->term_id . '">' . $all_countrie->name . '</option>';
                }
            }
            /* Countries html */
            $countries_html .= '<div class="form-group">
                                    <label>' . $label_country_field_ . '</label>
                                        <select class="form-control make" name="country_id">
                                            <option label="' . $label_country_field_ . '" value="">' . $label_country_field_ . '</option>
										' . $countries_option . '
                                        </select>
                                </div>';
        }

        /* ==================== */
        /* for Price */
        /* ===================== */
        wp_enqueue_script('price-slider-custom2', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array(), false, true);
        global $carspot_theme;
        $min_price = 50;
        $max_price = 100000;
        $price_html = '';
        if (isset($price_show_form) && $price_show_form == "yes") {
            $price_html .= '<div class="form-group">
                <label>' . $label_price_field_ . '</label>
                <div class="panel panel-default" id="red-price">
                        <div id = "collapsefour" class = "panel-collapse" role = "tabpanel" aria-labelledby = "headingfour">
                            <div class = "panel-body">
                                <span class = "price-slider-value">' . $label_price_field_ . '
                                    (' . esc_html($carspot_theme['sb_currency']) . ') 
                                    <span id="price-min"></span>
                                    - 
                                    <span id="price-max"></span>
                                </span>
                                <div id="price-slider"></div>
                                <div class="input-group margin-top-10">
                                    <input type="text" class="form-control" name="min_price" id="min_selected" value="' . esc_attr($min_price) . '"  autocomplete="off"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="max_price" id="max_selected" value="' . esc_attr($max_price) . '" autocomplete="off"/>
                                </div>
                                <input type="hidden" id="min_price" value="' . $min_price . '" />
                                <input type="hidden" id="max_price" value="' . $max_price . '" />
                            </div>
                        </div>
                        ' . carspot_search_params('min_price', 'max_price') . '
                </div>
            </div>';
        }

        /* ==================== */
        /*     for Radius        */
        /* ===================== */
        $mapType = carspot_mapType();
        if ($mapType == 'google_map') {
            wp_enqueue_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&libraries=places&callback=', false, false, true);
        }
        $radius_html = '';
        if (isset($radius_show_form) && $radius_show_form != '') {
            $heading_html = '';
            $heading_html .= '<label>' . $label_radius_field_ . '</label>';
            //==================
            $stricts = '';
            if (isset($carspot_theme['sb_location_allowed']) && !$carspot_theme['sb_location_allowed'] && isset($carspot_theme['sb_list_allowed_country'])) {
                $stricts = "componentRestrictions: {country: " . json_encode($carspot_theme['sb_list_allowed_country']) . "}";
            }
            //=============
            $map_js_code = '';
            if ($mapType == 'google_map') {
                $map_js_code .= "<script>
			(function ($) {
				'use strict';
				$( document ).ready(function() {
					function initMap() {
						var options = {
						  types: ['(regions)'],
						  " . $stricts . "
						  //componentRestrictions: {country: ['NL','BE']} 
						 };
						var input = document.getElementById('searchMapInput');
						var autocomplete = new google.maps.places.Autocomplete(input, options);
						autocomplete.addListener('place_changed', function() {
							var place = autocomplete.getPlace();
							$('#location-snap').val(place.formatted_address); 
							$('#loc_lat').val(place.geometry.location.lat());
							$('#loc_long').val(place.geometry.location.lng());
						});
					}
					initMap();
				});
				})(jQuery);
            
            </script>";
            }
            $radius_html .= '
                <div class="form-group">
                    ' . $heading_html . '
                    <div class="panel panel-default" id="red-radius">
                    ' . $map_js_code . '
                        <div class="panel-body">
                            <input id="searchMapInput" class="form-control" type="text" name="radius_address" placeholder="' . esc_html__('Search location', 'carspot') . '" value="">
                            <select class="form-control make" id="radius_number" name="radius" data-placeholder="' . esc_html__('Select Radius', 'carspot') . '">
                                <option value="">' . esc_html__("Radius in $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('5', 'carspot') . '">' . esc_html__("5 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('10', 'carspot') . '">' . esc_html__("10 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('15', 'carspot') . '">' . esc_html__("15 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('20', 'carspot') . '">' . esc_html__("20 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('25', 'carspot') . '">' . esc_html__("25 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('35', 'carspot') . '">' . esc_html__("35 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('50', 'carspot') . '">' . esc_html__("50 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('100', 'carspot') . '">' . esc_html__("100 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('150', 'carspot') . '">' . esc_html__("150 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('200', 'carspot') . '">' . esc_html__("200 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('300', 'carspot') . '">' . esc_html__("300 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('500', 'carspot') . '">' . esc_html__("500 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('1000', 'carspot') . '">' . esc_html__("1000 $radius_distance_unit_", 'carspot') . ' </option>
                            </select>
                            <input type="hidden" name="loc_long" id="loc_long" value="" />
                            <input type="hidden" name="loc_lat" id="loc_lat" value="" />
                            <input type="hidden" name="radius_unit" id="radius_unit" value="' . $radius_distance_unit_ . '" />
                            <input type="hidden" id="location-snap" value="">
                        </div>
                        ' . carspot_search_params('radius', 'loc_long', 'loc_lat', 'radius_address') . '
                    </div>
                </div>';
        }

        /* =============== */
        $style = '';
        if ($bg_img != "") {
            $bgImageURL = carspot_returnImgSrc($bg_img);
            $style = 'style = "background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"';
        }
        $floatCarImgURL = '';
        $floatCarImgURL = get_template_directory_uri() . '/images/hero-car.png';
        if ($float_car_img != "") {
            if (wp_attachment_is_image($float_car_img)) {
                $floatCarImgURL = carspot_returnImgSrc($float_car_img);
            }
        }
        $single_feature = '';
        $rows = vc_param_group_parse_atts($atts['feature_list']);
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['single_feature'])) {
                    $single_feature .= '<li> <i class = "fa fa-hand-o-right"></i> ' . $row['single_feature'] . '</li>';
                }
            }
        }

        $button = carspot_ThemeBtn($post_job_btn_link, 'btn btn-theme', false, false, false);
        $count_posts = wp_count_posts('ad_post');
        return '<section class = "hero-section section-style" ' . $style . '>
            <div class = "container">
            <div class = "row">
            <div class = "col-lg-7 col-md-7 col-sm-6 col-xs-12">
            <div class = "hero-text">
            <h1> ' . esc_html($section_title) . '</h1>
            <p> ' . esc_html($section_tag_line) . '</p>
            <ul>
            ' . $single_feature . '
            </ul>
            ' . $button . '
            </div>
            </div>
            <div class = "col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <img src = "' . trailingslashit(get_template_directory_uri()) . 'images/hero-form-shedow.png" class = "hero-form-top-style" alt = "' . esc_attr__('image not found', 'carspot') . '">
            <div class = "hero-form">
            <div class = "hero-form-heading">
            <h2> ' . esc_html($no_of_ads) . '</h2>
            <p>' . esc_html($form_text) . '</p>
            </div>
            <form action = "' . get_the_permalink($carspot_theme['sb_search_page']) . '">
            <div class = "form-group">
            <label>' . esc_html__('Keyword', 'carspot') . '</label>
            <input type = "text" class = "form-control" autocomplete = "off" id = "autocomplete-dynamic" name = "ad_title" placeholder = "' . esc_html__('What are you looking for...', 'carspot') . '" />
            </div>
            ' . $cats_html . '
                <div id="select_modal_2" class="margin-top-10"></div>
                <div id="select_modals_2" class="margin-top-10"></div>
                <div id="select_forth_div_2" class="margin-top-10"></div>
            
            ' . $years_html . '
            ' . $condition_html . '
            ' . $tag_html . '
            ' . $type_html . '
            ' . $warranty_html . '
            ' . $body_type_html . '
            ' . $transmission_html . '
            ' . $engineSize_html . '
            ' . $engineType_html . '
            ' . $assembly_html . '
            ' . $color_html . '
            ' . $insurance_html . '
            ' . $feature_html . '
            ' . $countries_html . '
            ' . $price_html . '
            ' . $radius_html . '
            <div class = "form-group">
            <button type = "submit" class = "btn btn-lg btn-theme btn-block" >' . esc_html__('Search Now', 'carspot') . '</button>
            </div>
            '. cs_form_lang_field_callback(true) .'
            </form>
            </div>
            </div>
            <img src = "' . $floatCarImgURL . '" class = "hero-car wow slideInLeft img-responsive" data-wow-delay = "0ms" data-wow-duration = "3000ms" alt = "' . __('Image not found', 'carspot') . '">
            </div>
            </div>
            </section>';
    }

}
if (function_exists('carspot_add_code')) {
    carspot_add_code('search_side_two_form_base', 'search_side_two_form_func');
}