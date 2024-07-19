<?php
/* ------------------------------------------------ */
/* ADs - With Tabs */
/* ------------------------------------------------ */
if (!function_exists('ads_with_tabs_short')) {
    function ads_with_tabs_short()
    {
        vc_map(array(
            "name" => esc_html__("ADs - With Tabs", 'carspot'),
            "description" => esc_html__("Once on a Page.", 'carspot'),
            "base" => "ads_with_tabs_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('ad_with_tabs.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "heading" => esc_html__("Order By", 'carspot'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Ads order', 'carspot') => '',
                        esc_html__('Oldest', 'carspot') => 'asc',
                        esc_html__('Latest', 'carspot') => 'desc',
                        esc_html__('Random', 'carspot') => 'rand'
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

                array
                (
                    'group' => esc_html__('Select Condition', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Condition', 'carspot'),
                    'param_name' => 'conditions',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Condtion Of Ad", 'carspot'),
                            "param_name" => "condition",
                            "admin_label" => true,
                            "value" => carspot_cats('ad_condition', 'no'),
                        ),

                    )
                ),

                //Group For Left Section
                array
                (
                    'group' => esc_html__('Select Make', 'carspot'),
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

add_action('vc_before_init', 'ads_with_tabs_short');

if (!function_exists('ads_with_tabs_base_func')) {
    function ads_with_tabs_base_func($atts, $content = '')
    {
        global $carspot_theme;
        $no_title = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'layout_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
        ), $atts));

        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else {
            $is_type = 0;
        }

        //Condition
        $condition_rows = vc_param_group_parse_atts($atts['conditions']);


        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $categories_html = '';
        $categories_contents = '';
        $counnt = 1;
        $ads = new ads();
        if (count((array)$rows) > 0) {
            $categories_html .= '<ul role="tablist" class="nav nav-tabs">';
            $categories_contents .= '<div class="tab-content">';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    $is_active = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $counnt++;
                    }

                    $cat_obj = get_category($row['cat']);
                    if (count((array)$cat_obj) == 0)
                        continue;

                    $categories_html .= ' <li class="clearfix ' . esc_attr($is_active) . '">
                              <a data-toggle="tab" title="' . $cat_obj->name . '" role="tab" href="#' . $cat_obj->slug . '" aria-expanded="false"> <i class="' . esc_attr($row['icon']) . '"></i> </a>
                           </li>';

                    $categories_contents .= '<div id="' . $cat_obj->slug . '" class=" row tab-pane in fade ' . esc_attr($is_active) . '">';
                    if ($layout_type == 'list')
                        $categories_contents .= '<ul class="list-unstyled">';
                    $category = array(
                        array(
                            'taxonomy' => 'ad_cats',
                            'field' => 'term_id',
                            'terms' => $row['cat'],
                        ),
                    );
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

                    $ordering = 'DESC';
                    $order_by = 'ID';
                    if ($ad_order == 'asc') {
                        $ordering = 'ASC';
                    } else if ($ad_order == 'desc') {
                        $ordering = 'DESC';
                    } else if ($ad_order == 'rand') {
                        $order_by = 'rand';
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
                        'orderby' => $order_by,
                        'order' => $ordering,

                    );
                    $ads_html = '';

                    $args = carspot_wpml_show_all_posts_callback($args);
                    $results = new WP_Query($args);
                    if ($results->have_posts()) {
                        while ($results->have_posts()) {
                            $results->the_post();
                            $function = "carspot_search_layout_$layout_type";
                            $categories_contents .= $ads->$function(get_the_ID(), 4);
                        }
                    }
                    if ($layout_type == 'list')
                        $categories_contents .= '</ul>';

                    $categories_contents .= '</div>';

                }
            }
            $categories_html .= '</ul>';
            $categories_contents .= '</div>';
        }
        $categories_html .= $categories_contents;

        wp_reset_postdata();
        return '<section class="home-tabs ' . $bg_color . '">
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-md-12">
                     <div class="tabs-container">
					 	' . $categories_html . '
                     </div>
                  </div>
               </div>
            </div>
         </section>
				  ';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('ads_with_tabs_short_base', 'ads_with_tabs_base_func');
}