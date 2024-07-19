<?php
/* ------------------------------------------------ */
/* Location Based */
/* ------------------------------------------------ */
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

if (!function_exists('location_short')) {
    function location_short()
    {
        vc_map(array(
            "name" => esc_html__("Location Based", 'carspot'),
            "base" => "location_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('location_short.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),

                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Category link Page", 'carspot'),
                    "param_name" => "cat_link_page",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Search Page', 'carspot') => 'search',
                        esc_html__('Category Page', 'carspot') => 'category',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
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
                    'group' => esc_html__('Locations', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Locations', 'carspot'),
                    'param_name' => 'select_locations',
                    'value' => '',


                    'params' => array(
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Location Name", 'carspot'),
                            "param_name" => "name",
                            'settings' => array('values' => location_data_shortcode()),
                        ),

                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Location Background Image", 'carspot'),
                            "param_name" => "img",
                        ),
                    )
                ),
            ),
        ));
    }
}

add_action('vc_before_init', 'location_short');

if (!function_exists('location_short_base_func')) {
    function location_short_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        global $carspot_theme;
        $locations_html = '';
        if (isset($atts['select_locations']) && $atts['select_locations'] != '') {
            $rows = vc_param_group_parse_atts($atts['select_locations']);
            if (count((array)$rows) > 0) {
                foreach ($rows as $r) {
                    if ($r != '') {
                        $img_thumb = '';
                        $img = (isset($r['img'])) ? $r['img'] : '';
                        $id = (isset($r['name'])) ? $r['name'] : '';
                        if (wp_attachment_is_image($img)) {
                            $img_url = wp_get_attachment_image_src($img, 'carspot-reviews-thumb');
                            $img_thumb = $img_url[0];
                        } else {
                            $img_thumb = esc_url($carspot_theme['default_related_image']['url']);
                        }
                        $term = get_term_by('slug', $id, 'ad_country');
                        if (isset($term->name)) {
                            $id_get = $term->term_id;
                            $slug = $term->slug;
                            $name = $term->name;
                            $count = $term->count;
                            $link = get_term_link($slug, 'ad_country');
                            // If there was an error, continue to the next term.
                            if (is_wp_error($link)) {
                                continue;
                            }
                            $parent = $term->parent;
                            $innerHTML = '';
                            if ($parent == 0) {

                                $innerHTML = '<h2 class="country-name">' . esc_html($name) . ' <span> (' . $count . ') </span></h2>
						 <p class="country-ads"></p>';
                            } else {
                                $term = get_term($parent, 'ad_country');
                                $parent_name = $term->name;
                                $innerHTML = '<h2 class="country-name">' . esc_html($name) . ' <span> (' . $count . ') </span></h2>
							<p class="country-ads">' . esc_html($parent_name) . '</p>';
                            }

                            $locations_html .= '<div class="col-sm-6 col-xs-12 col-md-4">
					
					<a href="' . carspot_location_page_link($id_get, $cat_link_page) . '">
					 <div class="country-box">
						<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr($name) . '">
						<div class="country-description"> ' . $innerHTML . '</div>
					 </div>
					</a>
					</div>	';
                        }
                    }

                }
            }
        }


        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }


        return '<section class="custom-padding cities-section ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . ' >
         <div class="container">
			' . $header . '
            <div class="row">
                 <div class="cities-grid-area posts-masonry">
				   ' . $locations_html . '
               </div>
            </div>
         </div>
      </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('location_short_base', 'location_short_base_func');
}