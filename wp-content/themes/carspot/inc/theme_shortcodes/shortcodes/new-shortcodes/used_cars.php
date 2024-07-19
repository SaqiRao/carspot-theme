<?php
/* ------------------------------------------------ */
/* Featured Car Offer */
/* ------------------------------------------------ */
if (!function_exists('used_cars')) {
    function used_cars()
    {
        vc_map(array(
                "name" => esc_html__("Used Cars", 'carspot'),
                "base" => "used_cars_base",
                "category" => esc_html__("Theme Shortcodes", 'carspot'),
                "params" => array(
                    array(
                        'group' => esc_html__('Shortcode Output', 'carspot'),
                        'type' => 'custom_markup',
                        'heading' => esc_html__('Shortcode Output', 'carspot'),
                        'param_name' => 'order_field_key',
                        'description' => carspot_VCImage('used-cars.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                        "heading" => esc_html__("Cars Type", 'carspot'),
                        "param_name" => "ad_type",
                        "admin_label" => true,
                        "value" => array(
                            esc_html__('Select Ads Type', 'carspot') => '',
                            esc_html__('Used Cars', 'carspot') => 'used',
                            esc_html__('New Cars', 'carspot') => 'new'
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
                    array(
                        "group" => __("Ads Settings", "carspot"),
                        'type' => 'vc_link',
                        'holder' => 'div',
                        'class' => '',
                        'admin_label' => true,
                        'heading' => __('Button Link', 'carspot'),
                        'param_name' => 'used_car_link',
                    ),
                )
            )
        );
    }
}
add_action('vc_before_init', 'used_cars');

if (!function_exists('used_cars_func')) {
    function used_cars_func($atts, $content = '')
    {
        global $carspot_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'ad_type' => '',
            'no_of_ads' => '',
            'used_car_link' => '',
        ), $atts));

        /* view more button */
        $btn = carspot_ThemeBtn($used_car_link, 'btn btn-theme', false);

        /* single grid card */
        $grid_card_html = '';
        $is_used = array();
        if ($ad_type == 'new') {
            $is_used = array(
                'key' => '_carspot_ad_condition',
                'value' => 'New',
                'compare' => '=',
            );
        } else {
            $is_used = array(
                'key' => '_carspot_ad_condition',
                'value' => 'Used',
                'compare' => '=',
            );
        }
        $ordering = 'DESC';
        $order_by = 'date';
        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_used,
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $ads = new WP_Query($args);
        $ads_items_html = '';
        if ($ads->have_posts()) {
            while ($ads->have_posts()) {
                $ads->the_post();
                $pid = '';
                $pid = get_the_ID();
                /* attached media */
                $media = carspot_fetch_listing_gallery($pid);
                if (count((array)$media) > 0) {
                    $counting = 1;
                    foreach ($media as $m) {
                        if ($counting > 1) {
                            break;
                        }
                        $mid = '';
                        if (isset($m->ID)) {
                            $mid = $m->ID;
                        } else {
                            $mid = $m;
                        }
                        $image = wp_get_attachment_image_src($mid, 'carspot-grid_small', false);
                        if (wp_attachment_is_image($mid)) {
                            $ad_image_html = '<a href="' . get_the_permalink() . '"><img class="img-responsive" src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '"></a>';
                        } else {
                            $ad_image_html = '<a href="' . get_the_permalink() . '"><img class="img-responsive" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"></a>';
                        }
                        $counting++;
                    }
                } else {
                    $ad_image_html = '<a href="' . get_the_permalink() . '"><img class="img-responsive" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>';
                }
                /* author ID */
                $author_id = get_post_field('post_author', $pid);
                /* user picture */
                $user_pic = carspot_get_dealer_logo($author_id);
                /* ads title */
                $car_ad_title = '';
                if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                    $limit_value = $carspot_theme['grid_title_limit'];
                    $car_ad_title = carspot_words_count(get_the_title(), $limit_value);
                } else {
                    $car_ad_title = get_the_title();
                }
                /* check is Featured */
                $is_feature = '';
                if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                    $is_feature = '<span></span><span class="iconify" data-icon="ant-design:star-filled"></span>';
                }

                $ads_items_html .= '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3">
                  <div class="ftd-card">
                    <div class="card-img">
                      ' . $ad_image_html . '
                      ' . $is_feature . '
                    </div>
                    <div class="card-meta">
                      <h6>' . carspot_adPrice($pid) . '</h6>
                      <a href="' . get_the_permalink() . '"><h4>' . $car_ad_title . '</h4></a>
                      <div class="location">
                        <p><span class="iconify" data-icon="entypo:location-pin"></span> ' . carspot_display_adLocation($pid) . '</p>
                      </div>
                      <a href="javascript:void(0)">
                        <img class="prf-back" src="' . get_template_directory_uri() . '/images/layer-102.png" alt="">
                        <img class="prf" src="' . esc_url($user_pic) . '" alt="' . __("Profile", "carspot") . '">
                      </a>
                    </div>
                  </div>
                </div>';
            }
            wp_reset_postdata();
        }

        return '<section class="used-cars-sales featured-offer ' . $top_padding . ' ' . $bg_color . '" ' . $style . '>
      <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="top-heading">
                ' . $header . '
                ' . $btn . '
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="used-cars-list">
              <div class="row">
              <div class="posts-masonry">
                ' . $ads_items_html . '
              </div>
            </div>
          </div>
        </div></div>
      </div>
    </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('used_cars_base', 'used_cars_func');
}