<?php
/* ------------------------------------------------ */
/* Reviews Post */
/* ------------------------------------------------ */
if (!function_exists('all_reviews')) {
    function all_reviews()
    {
        vc_map(array(
            "name" => esc_html__("Reviews Post", 'carspot'),
            "base" => "all_reviews",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('reviews_posts.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__("No Of Reviews Per Page", 'carspot'),
                    "param_name" => "max_limit",
                    "description" => esc_html__("How many Reviews you want to show on page -1 means all post without pagination", 'carspot'),
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
                            "value" => carspot_cats('reviews_cats', 'yes'),
                        ),
                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'all_reviews');

if (!function_exists('all_reviews_short_base_func')) {
    function all_reviews_short_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        global $carspot_theme;
        $pagination = '';

        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $is_all = false;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] != 'all') {
                        $cats[] = $row['cat'];
                    }
                }
            }
        }

        if ($max_limit != '') {
            $max_limit = $max_limit;
        } else {
            $max_limit = '8';
        }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'reviews',
            'posts_per_page' => $max_limit,
            'paged' => $paged,
            'post_status' => 'publish',
            'category__in' => $cats,
            'orderby' => 'ID',
            'order' => 'DESC',
        );
        $args = carspot_wpml_show_all_posts_callback($args);
        $posts = new WP_Query($args);
        $html = '';
        $response = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = get_the_ID();

                $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-category');
                if ($image != '') {
                    $img_header = '';
                    if ($image[0] != "") {

                        $response = $image[0];
                        $img_header = '<div class="post-img">
                                 <a href="' . get_the_permalink() . '">
								 <img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '">
								 </a>
                              </div>';
                    } else {
                        $response = $carspot_theme['default_related_image_review']['url'];
                    }
                }
                $terms = get_the_terms($pid, 'reviews_cats');
                $cat_name = '';
                if ($terms != null) {
                    foreach ($terms as $term) {
                        $cat_name .= ' <span class="badge text-uppercase badge-overlay badge-tech"><a href="' . esc_url(get_term_link($term)) . '"> ' . esc_html($term->name) . ' </a></span>';
                    }
                }
                $html .= '<div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="mainimage">
                                 ' . $cat_name . '
                                 <a href="' . get_the_permalink() . '">
                                    <img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($response) . '">
                                    <div class="overlay small-font">
                                       <h2>' . get_the_title() . '</h2>
                                    </div>
                                 </a>
                                 <div class="clearfix"></div>
                              </div>
                           </div>';
            }
        }
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $paginationz = '';

        if (function_exists('carspot_shortcodes_pagination')) {
            $paginationz = carspot_shortcodes_pagination($posts->max_num_pages, "", $paged);
        }

        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent2' || $carspot_theme['sb_header'] == 'transparent') {
            $top_padding = '';
        }

        return '<section class="custom-padding reviews ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
			<!-- Main Container -->
            <div class="container">
               <div class="row">
			   ' . $header . '
			   <div class="col-md-8 col-xs-12 col-sm-12 news">
				   <div class="row">
						' . $html . '
						
				   </div>
				   <div class="cleaxfix"></div>
						' . $paginationz . '
				</div>
				' . carspot_review_sidebar_shortcode() . '
		   </div>
		</div>
	</section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('all_reviews', 'all_reviews_short_base_func');
}
