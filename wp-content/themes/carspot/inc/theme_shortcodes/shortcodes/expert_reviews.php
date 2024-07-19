<?php
/* ------------------------------------------------ */
/* Expert Reviews */
/* ------------------------------------------------ */
if (!function_exists('reviews_short')) {
    function reviews_short()
    {
        vc_map(array(
            "name" => esc_html__("Expert Reviews", 'carspot'),
            "base" => "experts_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('reviews.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "type" => "dropdown",
                    "heading" => esc_html__("Number of Ads Want To Show", 'carspot'),
                    "param_name" => "max_limit",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),

                array(
                    'group' => esc_html__('Categories', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_reviews_cats('reviews_cats', 'no'),
                        ),
                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'reviews_short');

if (!function_exists('reviews_short_base_func')) {
    function reviews_short_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        global $carspot_theme;
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }

        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $is_all = false;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] != 'all') {
                        $cats[] = $row['cat'];
                    } else {
                        $cats[] = $row['cat'];
                    }
                }
            }
        }
        $args = array(
            'post_type' => 'reviews',
            'posts_per_page' => $max_limit,
            'tax_query' => array(
                array(
                    'taxonomy' => 'reviews_cats',
                    'field' => 'slug',
                    'terms' => $cats
                )
            ),
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order' => 'DESC',
        );
        $posts = new WP_Query($args);
        $html = '';
        $big_img = '';

        if ($posts->have_posts()) {
            $counter = 0;
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = cs_language_page_id_callback(get_the_ID());

                //Large Thumb
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-reviews-large-shortcode');
                    $img_header = '';
                    if ($image[0] != "") {
                        $img_header = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '">';
                    }
                } else {
                    $img_header = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '">';
                }

                //Small Thumb
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $small_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-reviews-thumb-shortcode');
                    $img_header1 = '';
                    if ($small_thumb[0] != "") {
                        $img_header1 = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($small_thumb[0]) . '">';
                    }
                } else {
                    $img_header1 = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '">';
                }

                if (++$counter == 1) {
                    $big_img .= '<div class="mainimage">
                        <a href="' . get_the_permalink() . '">
                           ' . $img_header . '
                           <div class="overlay">
                              <h2>' . get_the_title() . '</h2>
                           </div>
                        </a>
                        <div class="clearfix"></div>
                     </div>';
                } else {
                    $html .= '<li>
					  <div class="imghold"> <a href="' . get_the_permalink() . '">' . $img_header1 . '</a> </div>
					  <div class="texthold">
						 <h4><a  href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
						 <p>' . carspot_words_count(get_the_excerpt(), 80) . '</p>
					  </div>
					  <div class="clear"></div>
				   </li>';
                }
            }
        }


        return ' <section class="news section-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <div class="container">
			<div class="row">
			   ' . $header . '
                  <div class="col-md-7 col-sm-12 col-xs-12">
                     ' . $big_img . '
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12">
                     <div class="newslist">
                        <ul> ' . $html . ' </ul>
                     </div>
                  </div>	 
				</div>
			</div>
	</section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('experts_short_base', 'reviews_short_base_func');
}
