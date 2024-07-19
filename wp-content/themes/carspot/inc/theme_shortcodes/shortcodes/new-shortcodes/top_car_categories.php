<?php
if (!function_exists('location_data_shortcode')) {
    function location_data_shortcode($term_type = 'ad_country')
    {
        $terms = get_terms($term_type, array('hide_empty' => false,));
        $result = array();
        if (count((array)$terms) > 0) {
            foreach ($terms as $term) {
                $result[] = array
                (
                    'value' => $term->slug,
                    'label' => $term->name,
                );
            }
        }
        return $result;
    }
}
if (!function_exists('top_car_categories')) {
    function top_car_categories()
    {
        vc_map(array(
                "name" => esc_html__("Top Car Categories", 'carspot'),
                "base" => "top_car_categories_base",
                "category" => esc_html__("Theme Shortcodes", 'carspot'),
                "params" => array(
                    array(
                        'group' => esc_html__('Shortcode Output', 'carspot'),
                        'type' => 'custom_markup',
                        'heading' => esc_html__('Shortcode Output', 'carspot'),
                        'param_name' => 'order_field_key',
                        'description' => carspot_VCImage('top-categories.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                        "type" => "dropdown",
                        "heading" => esc_html__("Section Top Padding", 'carspot'),
                        "param_name" => "section_padding",
                        "admin_label" => true,
                        "value" => array(
                            esc_html__('Select Section Padding', 'carspot') => '',
                            esc_html__('No', 'carspot') => '',
                            esc_html__('Yes', 'carspot') => 'yes',
                        ),
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                        "std" => '',
                        "description" => esc_html__("Remove Padding From Section Top.", 'carspot'),
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
                        "description" => esc_html__("Choose header style.", 'carspot'),
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
                    /* categories tab one */
                    array(
                        'group' => esc_html__('By Tags', 'carspot'),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Top Category Title", 'carspot'),
                        "param_name" => "category1_title",
                        "description" => "",
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        'group' => esc_html__('By Tags', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Tags', 'carspot'),
                        'param_name' => 'top_tags',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Category", 'carspot'),
                                "param_name" => "cat_tags",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_tags', 'no'),
                            ),
                        )
                    ),
                    /* categories tab two */
                    array(
                        'group' => esc_html__('By City', 'carspot'),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Top Category Title", 'carspot'),
                        "param_name" => "category2_title",
                        "description" => "",
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        'group' => esc_html__('By City', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose City', 'carspot'),
                        'param_name' => 'top_city',
                        'params' => array(
                            array(
                                "type" => "autocomplete",
                                "holder" => "div",
                                "heading" => esc_html__("Location Name", 'carspot'),
                                "param_name" => "ad_city",
                                'settings' => array('values' => location_data_shortcode()),
                            ),
                        )
                    ),
                    /* categories tab three */
                    array(
                        'group' => esc_html__('By Make', 'carspot'),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Top Category Title", 'carspot'),
                        "param_name" => "category3_title",
                        "description" => "",
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        'group' => esc_html__('By Make', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Makers', 'carspot'),
                        'param_name' => 'top_makers',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Category", 'carspot'),
                                "param_name" => "cat_maker",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_cats', 'no'),
                            ),
                        )
                    ),

                    /* categories tab four */
                    array(
                        'group' => esc_html__('By colors', 'carspot'),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Top Category Title", 'carspot'),
                        "param_name" => "category4_title",
                        "description" => "",
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        'group' => esc_html__('By colors', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Colors', 'carspot'),
                        'param_name' => 'top_colors',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Category", 'carspot'),
                                "param_name" => "cat_colors",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_colors', 'no'),
                            ),
                        )
                    ),

                ),
            )
        );
    }
}

add_action('vc_before_init', 'top_car_categories');

if (!function_exists('top_car_categories_base_func')) {
    function top_car_categories_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'category1_title' => '',
            'top_tags' => '',
            'category2_title' => '',
            'top_city' => '',
            'category3_title' => '',
            'top_makers' => '',
            'category4_title' => '',
            'top_colors' => '',
        ), $atts));

        /* top tags */
        $tags_title = (isset($category1_title) && $category1_title != '') ? '<h4>' . $category1_title . '</h4>' : '';
        $tag_html = '';
        if (isset($atts['top_tags'])) {
            $rows_tags = vc_param_group_parse_atts($atts['top_tags']);
            if (count((array)$rows_tags) > 0) {
                $tag_html .= '<ul>';
                foreach ($rows_tags as $row) {
                    $tags_ad = get_term_by('slug', $row['cat_tags'], 'ad_tags');
                    $tag_html .= '<li><a href="' . esc_url(carspot_cat_link_page($tags_ad->term_id, 'category')) . '">' . $tags_ad->name . '</a></li>';
                }
                $tag_html .= '</ul>';
            }
        }

        /* top city */
        $country_title = (isset($category2_title) && $category2_title != '') ? '<h4>' . $category2_title . '</h4>' : '';
        $country_html = '';
        if (isset($atts['top_city'])) {
            $rows_country = vc_param_group_parse_atts($atts['top_city']);
            if (count((array)$rows_country) > 0) {
                $country_html .= '<ul>';
                foreach ($rows_country as $r) {
                    if ($r != '') {
                        $id = (isset($r['ad_city'])) ? $r['ad_city'] : '';
                        $term = get_term_by('slug', $id, 'ad_country');
                        if (isset($term->name)) {
                            $id_get = $term->term_id;
                            $name = $term->name;
                            $country_html .= '<li><a href="' . carspot_location_page_link($id_get, 'category') . '">' . $name . '</a></li>';
                        }
                    }
                }
                $country_html .= '</ul>';
            }
        }

        /* top Makers */
        $maker_title = (isset($category3_title) && $category3_title != '') ? '<h4>' . $category3_title . '</h4>' : '';
        $maker_html = '';
        if (isset($atts['top_makers'])) {
            $rows_maker = vc_param_group_parse_atts($atts['top_makers']);
            if (count((array)$rows_maker) > 0) {
                $maker_html .= '<ul>';
                foreach ($rows_maker as $row) {
                    $maker_ad = get_term_by('slug', $row['cat_maker'], 'ad_cats');
                    $maker_html .= '<li><a href="' . esc_url(carspot_cat_link_page($maker_ad->term_id, 'category')) . '">' . $maker_ad->name . '</a></li>';
                }
                $maker_html .= '</ul>';
            }
        }

        /* top colors */
        $color_title = (isset($category4_title) && $category4_title != '') ? '<h4>' . $category4_title . '</h4>' : '';
        $color_html = '';
        if (isset($atts['top_colors'])) {
            $rows_color = vc_param_group_parse_atts($atts['top_colors']);
            if (count((array)$rows_color) > 0) {
                $color_html .= '<ul>';
                foreach ($rows_color as $row) {
                    $color_ad = get_term_by('slug', $row['cat_colors'], 'ad_colors');
                    $color_html .= '<li><a href="' . esc_url(carspot_cat_link_page($color_ad->term_id, 'category')) . '">' . $color_ad->name . '</a></li>';
                }
                $color_html .= '</ul>';
            }
        }

        return '<section class="top-cars-categories ' . $top_padding. ' ' . $bg_color . '" ' . $style . '>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="top-heading">
              ' . $header . '
            </div>
            <div class="select-any-car">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                  <div class="choose-car">
                    ' . $tags_title . '
                    ' . $tag_html . '
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                  <div class="choose-car">
                    ' . $country_title . '
                    ' . $country_html . '
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                  <div class="choose-car">
                    ' . $maker_title . '
                    ' . $maker_html . '
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                  <div class="choose-car">
                    ' . $color_title . '
                    ' . $color_html . '
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('top_car_categories_base', 'top_car_categories_base_func');
}