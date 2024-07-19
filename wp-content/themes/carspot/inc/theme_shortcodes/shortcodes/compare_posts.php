<?php
/* ------------------------------------------------ */
/* comparison */
/* ------------------------------------------------ */

if (!function_exists('comparison_data_shortcode1')) {
    function comparison_data_shortcode1($post_type = 'comparison')
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

if (!function_exists('compare_short')) {
    function compare_short()
    {
        vc_map(array(
            "name" => esc_html__("Comparison Post", 'carspot'),
            "base" => "compare_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('compare.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "group" => esc_html__("Sidebar", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Sidebar Postion", 'carspot'),
                    "param_name" => "sidebar_position",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Left Side', 'carspot') => '1',
                        esc_html__('Right Side', 'carspot') => '2',
                        esc_html__('No Side', 'carspot') => '0',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "description" => esc_html__("Sidebar position placement", 'carspot'),
                ),


                array(
                    'group' => esc_html__('Comparison', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Make Comparison', 'carspot'),
                    'param_name' => 'comparison_loop',
                    'params' => array(

                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("First Car", 'carspot'),
                            "param_name" => "first_car",
                            'settings' => array('values' => comparison_data_shortcode1()),
                        ),
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Second Car", 'carspot'),
                            "param_name" => "second_car",
                            'settings' => array('values' => comparison_data_shortcode1()),
                        ),

                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'compare_short');

if (!function_exists('compare_short_base_func')) {
    function compare_short_base_func($atts, $content = '')
    {
        global $carspot_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $id1 = $id2 = $compare_grid = $page_link = $leftside = $rightside = $columnsize = $inner_column = '';

        if ($sidebar_position == 0) {
            $columnsize = 'col-md-12';
            $inner_column = 'col-md-6';
        } else {
            $columnsize = 'col-md-8';
            $inner_column = 'col-md-12';
        }
        if ($sidebar_position == 1) {
            $leftside = carspot_review_sidebar_shortcode();
        }
        if ($sidebar_position == 2) {
            $rightside = carspot_review_sidebar_shortcode();
        }
        //Loop the data
        $comparison_loop = vc_param_group_parse_atts($atts['comparison_loop']);
        if (count((array)$comparison_loop) > 0) {
            $compare_page = '';
            if (isset($carspot_theme['carspot_compare_page']) && $carspot_theme['carspot_compare_page'] != "") {
                $compare_page = cs_language_page_id_callback($carspot_theme['carspot_compare_page']);
            }
            $final_img = '';
            foreach ($comparison_loop as $comparison) {
                $id1 = $comparison['first_car'];
                $id2 = $comparison['second_car'];
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
                    $compare_grid .= ' <li class="' . esc_attr($inner_column) . ' col-sm-6 col-xs-12"><div class="comparison-box"><a href="' . $page_link . '">
							 <div class="col-md-6 col-sm-12 col-xs-12">
								   <div class="compare-grid">
									<img src="' . esc_url($final_img) . '" alt="' . __('imag not found', 'carspot') . '" class="img-responsive">
								   <h2>' . get_the_title($id1) . '</h2>
								   <div class="rating">
									  ' . carspot_get_comparison_rating($id1) . '
								   </div>
								</div>
							 </div>';
                    $compare_grid .= ' <div class="vsbox">' . esc_html__('vs', 'carspot') . '</div>';
                    $compare_grid .= ' <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="compare-grid">
                                      <img src="' . esc_url($final_img2) . '" alt="' . __('imag not found', 'carspot') . '" class="img-responsive">
                                       <h2>' . get_the_title($id2) . '</h2>
                                       <div class="rating">
									    ' . carspot_get_comparison_rating($id2) . '
                                       </div>
                                    </div>
                                 </div>';
                    $compare_grid .= '</a></div><li>';
                }
            }
        }

        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent2' || $carspot_theme['sb_header'] == 'transparent') {
            $top_padding = '';
        }

        $button = '';
        $button = carspot_ThemeBtn($main_link, 'btn btn-lg  btn-theme', false, false, '');
        return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <div class="container">
			   ' . $header . '
               <div class="row">
			    ' . $leftside . '
                  <div class="' . esc_attr($columnsize) . ' col-xs-12 col-sm-12">
                     <div class="row">
                        <!-- Car Comparison Archive -->
                        <ul class="compare-masonry text-center">
						   ' . $compare_grid . '
                        </ul>
						<div class="clearfix"></div>
						<div class="text-center">
                           <div class="load-more-btn">
						   ' . $button . '
                           </div>
                        </div>
                     </div>
                  </div>
				 ' . $rightside . '
               </div>
            </div>
         </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('compare_short_base', 'compare_short_base_func');
}
