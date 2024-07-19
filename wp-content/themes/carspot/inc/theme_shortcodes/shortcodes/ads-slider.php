<?php
/* ------------------------------------------------ */
/* Ads Slider */
/* ------------------------------------------------ */
if (!function_exists('ads_slider_short')) {

    function ads_slider_short() {
        vc_map(array(
            "name" => esc_html__("ADs - Slider", 'carspot'),
            "description" => esc_html__("Once on a Page.", 'carspot'),
            "base" => "ads_slider_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('ad_slider.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'carspot'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'carspot') => '',
                        esc_html__('White', 'carspot') => '',
                        esc_html__('Gray', 'carspot') => 'gray',
                        esc_html__('Image', 'carspot') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'carspot'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Header Style", 'carspot'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Section Header Style', 'carspot') => '',
                        esc_html__('No Header', 'carspot') => '',
                        esc_html__('Classic', 'carspot') => 'classic',
                        esc_html__('Regular', 'carspot') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Chose header style.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title",
                    "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic', 'regular'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic', 'regular'),
                    ),
                ),
                array(
                    "group" => esc_html__("Ads Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Ads Type", 'carspot'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Ads Type', 'carspot') => '',
                        esc_html__('Featured Ads', 'carspot') => 'feature',
                        esc_html__('Simple Ads', 'carspot') => 'regular'
                    ),
                ),
                array(
                    "group" => esc_html__("Ads Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Layout Type", 'carspot'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Layout Type', 'carspot') => '',
                        esc_html__('Grid 1', 'carspot') => 'grid_1',
                        esc_html__('Grid 2', 'carspot') => 'grid_2',
                        esc_html__('Grid 3', 'carspot') => 'grid_3',
                        esc_html__('Grid 4', 'carspot') => 'grid_4',
                        esc_html__('Grid 5', 'carspot') => 'grid_5',
                    ),
                ),
                array(
                    "group" => esc_html__("Ads Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Ads", 'carspot'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                //Group For Left Section
                array
                    (
                    'group' => esc_html__('Categories', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_get_parests('ad_cats', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_slider_short');

if (!function_exists('ads_slider_short_base_func')) {

    function ads_slider_short_base_func($atts, $content = '') {
        global $carspot_theme;
        $no_title = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'layout_type' => 'grid_5',
            'no_of_ads' => '',
                        ), $atts));

        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else {
            $is_type = 0;
        }

        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == 'all') {
                        break;
                    } else {
                        $cats[] = $row['cat'];
                    }
                }
            }
        }

        $category = '';
        if (count((array) $cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'slug',
                    'terms' => $cats,
                ),
            );
        }

        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => '_carspot_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else {
            $is_feature = array(
                'key' => '_carspot_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }


        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature,
            ),
            'tax_query' => array(
                $category,
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $ads_html = '';
        $class = '';
        $ads = new ads();
        $args = carspot_wpml_show_all_posts_callback($args);
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            if ($layout_type == "grid_1") {
                $class = 'grid-style-2';
            }
            if ($layout_type == "grid_5") {
                $class = 'grid-style-1';
            }
            while ($results->have_posts()) {
                $results->the_post();
                $ads_html .= '<div class="item">';
                $function = "carspot_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 12, 12, 'slider-');
                $ads_html .= '</div>';
            }

            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
        }
        wp_reset_postdata();
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }

        return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . '  over-hidden">
            <div class="container">
               <div class="row ' . esc_attr($class) . '">
                  ' . $header . '
                  <!-- Middle Content Box -->
                  <div class="col-md-12 col-xs-12 col-sm-12 ads-for-home">
                     <div class="row">
                        <div class="featured-slider container owl-carousel owl-theme">
                           	' . $ads_html . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

if (function_exists('carspot_add_code')) {
    carspot_add_code('ads_slider_short_base', 'ads_slider_short_base_func');
}