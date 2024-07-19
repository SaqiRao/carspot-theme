<?php
/* ------------------------------------------------ */
/* Blog */
/* ------------------------------------------------ */
if (!function_exists('blog_short')) {
    function blog_short()
    {
        vc_map(array(
            "name" => esc_html__("Blog Posts", 'carspot'),
            "base" => "blog_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('blog.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
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
                        'value' => array('classic'),
                    ),
                ),


                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Ads", 'carspot'),
                    "param_name" => "max_limit",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),


                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Read More Link", 'carspot'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                ),

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
                            "value" => carspot_cats('category', 'no'),
                        ),
                    )
                ),

            ),
        ));
    }
}

add_action('vc_before_init', 'blog_short');

if (!function_exists('blog_short_base_func')) {
    function blog_short_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        global $carspot_theme;
        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $is_all = false;
        $blog_category = '';
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] != 'all') {
                        $blog_category = get_term_by('slug', $row['cat'], 'category');
                        if (!empty($blog_category)) {
                            if (count((array)$blog_category) == 0)
                                continue;
                            $blog_category->term_id;
                            $cats[] = $blog_category->term_id;
                        }
                    }
                }
            }
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $max_limit,
            'post_status' => 'publish',
            'category__in' => $cats,
            'orderby' => 'ID',
            'order' => 'DESC',
        );
        $args = carspot_wpml_show_all_posts_callback($args);
        $posts = new WP_Query($args);
        $html = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = get_the_ID();
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-category');
                    $img_header = '';
                    if ($image[0] != "") {
                        $img_header = '<div class="post-img"><a href="' . get_the_permalink() . '"><img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '"></a></div>';
                    }
                } else {
                    $img_header = '<div class="post-img"><a href="' . get_the_permalink() . '"><img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '"></a></div>';
                }
                $user_pic = '';
                $img = '';
                $user_pic = carspot_get_user_dp(get_current_user_id(), 'carspot-single-small');

                $img = '<img class="img-circle resize" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url($user_pic) . '" />';

                $html .= '<div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="blog-post">
                              	' . $img_header . '
							 <div class="blog-content">
							 <div class="user-preview">
							  <a href="' . esc_attr(get_author_posts_url(get_the_author_meta('ID'))) . '"> ' . $img . '</a>
                     		 </div>
                              <div class="post-info">
							  <a href="javascript:void(0);">' . get_the_date(get_option('date_format'), $pid) . '</a>
							  <a href="javascript:void(0);">' . get_comments_number() . ' ' . esc_html__('comments', 'carspot') . '</a>
							  </div>
                              <h3 class="post-title">
							  <a href="' . get_the_permalink() . '">' . get_the_title() . '</a> </h3>
                              <p class="post-excerpt"> ' . carspot_words_count(get_the_excerpt(), 140) . '
							  <a href="' . get_the_permalink() . '"> <strong> ' . esc_html__('Read More', 'carspot') . ' </strong></a>
							  </p>
                           </div>
                        </div></div>';

            }
        }
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }


        $button = carspot_ThemeBtn($main_link, 'btn btn-lg  btn-theme', false, false, '<i class="fa fa-refresh"></i>');
        return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . '" ' . $style . '>
			<!-- Main Container -->
			<div class="container">
			   <div class="row">
			   ' . $header . '
			   <div class="col-md-12 col-xs-12 col-sm-12">
			   <div class="row">
					' . $html . '
					<div class="clearfix"></div>
					<div class="text-center">
					   <div class="load-more-btn">' . $button . '</div>
					</div>
			   </div>
			</div>
		   </div>
		</div>
		</section>';

    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('blog_short_base', 'blog_short_base_func');
}