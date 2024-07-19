<?php
/* ------------------------------------------------ */
/* comparison */
/* ------------------------------------------------ */

if (!function_exists('comparison_data_shortcode2')) {
    function comparison_data_shortcode2($post_type = 'comparison')
    {
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'order' => 'DESC',
            'post_status' => 'publish',
            'post_type' => $post_type,
        ));
        $result = array();
        foreach ($posts as $post) {
            $result[] = array(
                'value' => $post->ID,
                'label' => $post->post_title,
            );
        }
        return $result;
    }
}

if (!function_exists('compare_short2')) {
    function compare_short2()
    {
        vc_map(array(
            "name" => esc_html__("Car Comparison", 'carspot'),
            "base" => "compare_short2_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('car-comparison.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Read More Link", 'carspot'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                ),


                array(
                    'group' => esc_html__('Comparison', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Make Comparison', 'carspot'),
                    'param_name' => 'comparison1_loop',
                    'params' => array(
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("First Car", 'carspot'),
                            "param_name" => "first_car1",
                            'settings' => array('values' => comparison_data_shortcode2()),
                        ),
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Second Car", 'carspot'),
                            "param_name" => "second_car1",
                            'settings' => array('values' => comparison_data_shortcode2()),
                        ),

                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'compare_short2');

if (!function_exists('compare_short2_base_func')) {
    function compare_short2_base_func($atts, $content = '')
    {
        global $carspot_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $id1 = $id2 = $compare_grid_html = $page_link = $leftside = $rightside = '';

        //Loop the data
        $comparison1_loop = vc_param_group_parse_atts($atts['comparison1_loop']);
        if (count((array)$comparison1_loop) > 0) {
            $compare_page = '';
            if (isset($carspot_theme['carspot_compare_page']) && $carspot_theme['carspot_compare_page'] != "") {
                $compare_page = cs_language_page_id_callback($carspot_theme['carspot_compare_page']);
            }
            $final_img = '';
            foreach ($comparison1_loop as $comparison) {
                $id1 = $comparison['first_car1'];
                $id2 = $comparison['second_car1'];
                $page_link = carspot_set_url_params_multi(get_the_permalink($compare_page), array('id1' => $id1, 'id2' => $id2));
                if ($id1 != '' && $id2 != '') {
                    $response1 = carspot_get_feature_image($id1, 'carspot-comparison_thumb');
                    if (wp_attachment_is_image(get_post_thumbnail_id($id1))) {
                        $final_img = $response1[0];
                    } else {
                        $final_img = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $response2 = carspot_get_feature_image($id2, 'carspot-comparison_thumb');
                    if (wp_attachment_is_image(get_post_thumbnail_id($id2))) {
                        $final_img2 = $response2[0];
                    } else {
                        $final_img2 = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $compare_grid_html .= '<div class="item">
                                            <div class="comparison-card">
                                              <div class="row">
                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                  <div class="left-item">
                                                    <a href="' . $page_link . '"><img class="img-responsive" src="' . esc_url($final_img) . '" alt=""></a>
                                                    <a href="' . $page_link . '"><h5>' . get_the_title($id1) . '</h5></a>
                                                    <div class="rating">
                                                      ' . carspot_get_comparison_rating($id1) . '
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                  <div class="right-item">
                                                    <a href="' . $page_link . '"><img class="img-responsive" src="' . esc_url($final_img2) . '" alt=""></a>
                                                    <a href="' . $page_link . '"><h5>' . get_the_title($id2) . '</h5></a>
                                                    <div class="rating">
                                                      ' . carspot_get_comparison_rating($id2) . '
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="vs">' . esc_html__("VS", "carspot") . '</div>
                                            </div>
                                        </div>';
                }
            }
        }

        $button = '';
        $button = carspot_ThemeBtn($main_link, 'btn btn-theme', false, false, '');

        return '<section class="car-comparison used-cars-sales ' . $top_padding. ' ' . $bg_color . '" ' . $style . '>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="heading-content">
              <div class="top-heading">
                ' . $header . '
                ' . $button . '
              </div>
            </div>
            <div class="owl-carousel owl-theme owl-loaded comparison-owl car-arrow-owl">
            ' . $compare_grid_html . '
          </div>
          </div>
        </div>
      </div>
    </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('compare_short2_base', 'compare_short2_base_func');
}
