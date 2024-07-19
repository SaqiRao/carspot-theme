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
if (!function_exists('city_cartype_recentads')) {
    function city_cartype_recentads()
    {
        vc_map(array(
                "name" => esc_html__("City, Car Type, Recent Ads", 'carspot'),
                "base" => "city_cartype_recentads_base",
                "category" => esc_html__("Theme Shortcodes", 'carspot'),
                "params" => array(
                    array(
                        'group' => esc_html__('Shortcode Output', 'carspot'),
                        'type' => 'custom_markup',
                        'heading' => esc_html__('Shortcode Output', 'carspot'),
                        'param_name' => 'order_field_key',
                        'description' => carspot_VCImage('multi-search.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    /* city tab one */
                    array(
                        "group" => esc_html__("By City", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Title", 'carspot'),
                        "param_name" => "city_title",
                        "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        'group' => esc_html__('By City', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose City', 'carspot'),
                        'param_name' => 'search_city',
                        'params' => array(
                            array(
                                "type" => "autocomplete",
                                "holder" => "div",
                                "heading" => esc_html__("Location Name", 'carspot'),
                                "param_name" => "ad_city",
                                'settings' => array('values' => location_data_shortcode()),
                            ),
                            array(
                                "type" => "attach_image",
                                "holder" => "bg_img",
                                "heading" => esc_html__("Location Background Image", 'carspot'),
                                "description" => '239x250',
                                "param_name" => "ad_img",
                            ),
                        )
                    ),
                    /* search by car Brands */
                    array(
                        "group" => esc_html__("By Car Brand", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Title", 'carspot'),
                        "param_name" => "car_brand_title",
                        "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        "group" => esc_html__("By Car Brand", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Tab Title", 'carspot'),
                        "param_name" => "car_brand_tab_title",
                    ),
                    array(
                        'group' => esc_html__('By Car Brand', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Brand', 'carspot'),
                        'param_name' => 'search_brand',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Brand", 'carspot'),
                                "param_name" => "ad_brand",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_cats', 'no'),
                            ),
                            array(
                                "type" => "attach_image",
                                "holder" => "img",
                                "heading" => esc_html__("Brand Image", 'carspot'),
                                "param_name" => "brand_img",
                                "description" => esc_html__('62x37', 'carspot'),
                            ),
                        )
                    ),
                    /* search by body type */
                    array(
                        "group" => esc_html__("By Body Type", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Tab Title", 'carspot'),
                        "param_name" => "car_body_tab_title",
                    ),
                    array(
                        'group' => esc_html__('By Body Type', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Body Type', 'carspot'),
                        'param_name' => 'search_body_type',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Body Type", 'carspot'),
                                "param_name" => "ad_body_type",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_body_types', 'no'),
                            ),
                            array(
                                "type" => "attach_image",
                                "holder" => "img",
                                "heading" => esc_html__("Body Image", 'carspot'),
                                "param_name" => "body_img",
                                "description" => esc_html__('62x37', 'carspot'),
                            ),
                        )
                    ),
                    /* recent ads */
                    array(
                        "group" => esc_html__("By Recent Ads", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Title", 'carspot'),
                        "param_name" => "recent_ad_title",
                        "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                        'edit_field_class' => 'vc_col-sm-12 vc_column',
                    ),
                    array(
                        "group" => esc_html__("By Recent Ads", "'carspot"),
                        "type" => "dropdown",
                        "heading" => esc_html__("Number fo Ads", 'carspot'),
                        "param_name" => "recent_num_ads",
                        "admin_label" => true,
                        "value" => range(1, 50),
                    ),

                ),
            )
        );
    }
}

add_action('vc_before_init', 'city_cartype_recentads');

if (!function_exists('city_cartype_recentads_base_func')) {
    function city_cartype_recentads_base_func($atts, $content = '')
    {
        global $carspot_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'city_title' => '',
            'search_city' => '',
            'ad_city' => '',
            'ad_img' => '',
            'car_brand_title' => '',
            'car_brand_tab_title' => '',
            'search_brand' => '',
            'ad_brand' => '',
            'brand_img' => '',
            'car_body_tab_title' => '',
            'search_body_type' => '',
            'ad_body_type' => '',
            'body_img' => '',
            'recent_ad_title' => '',
            'recent_num_ads' => '',
        ), $atts));


        /* ===============*/
        /* search by city */
        /* =============== */
        $search_city_title = (isset($city_title) && $city_title != '') ? '<h3>' . carspot_color_text($city_title) . '</h3>' : '';
        $car_brand_title = (isset($car_brand_title) && $car_brand_title != '') ? '<h3>' . carspot_color_text($car_brand_title) . '</h3>' : '';

        $search_city_html = $locations_html = '';
        if (isset($atts['search_city']) && $atts['search_city'] != '') {
            $rows = vc_param_group_parse_atts($atts['search_city']);
            if (count((array)$rows) > 0) {
                foreach ($rows as $r) {
                    if ($r != '') {
                        $img_thumb = '';
                        $img = (isset($r['ad_img'])) ? $r['ad_img'] : '';
                        $id = (isset($r['ad_city'])) ? $r['ad_city'] : '';
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
                                $innerHTML = '<div class="city-name"><p>' . esc_html($name) . ' </p><span> (' . $count . ') </span></div>';
                            } else {
                                $term = get_term($parent, 'ad_country');
                                $parent_name = $term->name;
                                $innerHTML = '<div class="city-name"><p>' . esc_html($parent_name) . ' </p><span> (' . $count . ') </span></div>';
                            }
                            $locations_html .= '<div class="item">
                                  <div class="card">
                                    <a href="' . carspot_location_page_link($id_get, 'category') . '"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr($name) . '"></a>
                                    <div class="botm-meta">
                                      ' . $innerHTML . '
                                      <div class="arrow">
                                        <a href="' . carspot_location_page_link($id_get, 'category') . '"><span class="iconify" data-icon="bi:arrow-right"></span></a>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                        }
                    }
                }
            }
        }


        /* =================== */
        /*  search by Brands   */
        /* =================== */
        $brands_html = $search_brand_tab = '';
        if (isset($atts['search_brand'])) {
            $rows = vc_param_group_parse_atts($atts['search_brand']);
            if (count((array)$rows) > 0) {
                $search_brand_tab = '<li class="active"><a class="left" href="#brand" data-toggle="tab">' . esc_html__("Search By Car Brands", "carspot") . '</a></li>';
                $brands_html .= '<div class="tab-pane active" id="brand"><div class="row">';
                foreach ($rows as $row) {
                    if (isset($row['ad_brand']) && isset($row['brand_img']) && $row['ad_brand'] != "") {
                        $category_brand = get_term_by('slug', $row['ad_brand'], 'ad_cats');
                        if (count((array)$category_brand) == 0) {
                            continue;
                        }
                        $bgImageURL = carspot_returnImgSrc($row['brand_img']);
                        if (isset($category_brand->name) && $bgImageURL != "" && $category_brand->name != "") {
                            $brands_html .= '<a href="' . esc_url(get_term_link($category_brand->term_id)) . '"><div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                                              <div class="cars-ads">
                                                <div class="left-cont">
                                                  <img src="' . esc_url($bgImageURL) . '" alt="' . esc_attr($category_brand->name) . '">
                                                </div>
                                                <div class="right-cont">
                                                  <h5>' . esc_attr($category_brand->name) . '</h5>
                                                  <span>' . $category_brand->count . ' ' . esc_html__("Ads", "carspot") . '</span>
                                                </div>
                                              </div>
                                            </div></a>';
                        }
                    }
                }
                $brands_html .= '</div></div>';
            }
        }

        /* =================== */
        /* Search by Body Type */
        /* ================== */
        $car_body_tab_title = (isset($car_body_tab_title) && $car_body_tab_title != '') ? ($car_body_tab_title) : '';
        $body_html = $search_body_tab = '';
        if (isset($atts['search_body_type'])) {
            $rows_body = vc_param_group_parse_atts($atts['search_body_type']);
            if (count((array)$rows_body) > 0) {
                $search_body_tab = '<li><a class="right" href="#body-type" data-toggle="tab">' . $car_body_tab_title . '</a></li>';
                $body_html .= '<div class="tab-pane" id="body-type"><div class="row">';
                foreach ($rows_body as $row) {
                    if (isset($row['ad_body_type']) && $row['ad_body_type'] != "") {
                        $category_body = get_term_by('slug', $row['ad_body_type'], 'ad_body_types');
                        if (count((array)$category_body) == 0) {
                            continue;
                        }
                        $bgImageURL_body = carspot_returnImgSrc($row['body_img']);
                        if (isset($category_body->name) && $bgImageURL_body != "" && $category_body->name != "") {
                            $body_html .= '<a href="' . esc_url(get_term_link($category_body->term_id)) . '"><div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                                  <div class="cars-ads">
                                    <div class="left-cont">
                                      <img src="' . esc_url($bgImageURL_body) . '" alt="' . esc_attr($category_body->name) . '">
                                    </div>
                                    <div class="right-cont">
                                      <h5>' . $category_body->name . '</h5>
                                      <span>' . $category_body->count . ' ' . esc_html__("Ads", "carspot") . '</span>
                                    </div>
                                  </div>
                                </div></a>';
                        }
                    }
                }
                $body_html .= '</div></div>';
            }
        }

        /* =========== */
        /* Recent Ads  */
        /* =========== */
        $recent_ads_title = (isset($recent_ad_title) && $recent_ad_title != '') ? '<h3>' . carspot_color_text($recent_ad_title) . '</h3>' : '';
        $recent_ad_html = '';
        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $recent_num_ads,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $result = new WP_Query($args);

        if ($result->have_posts()) {
            $ad_image_html = '';
            while ($result->have_posts()) {
                $result->the_post();
                $pid = get_the_ID();
                /* ads title */
                $car_ad_title = '';
                if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                    $limit_value = $carspot_theme['grid_title_limit'];
                    $car_ad_title = carspot_words_count(get_the_title(), $limit_value);
                } else {
                    $car_ad_title = get_the_title();
                }
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
                        $image = wp_get_attachment_image_src($mid, 'carspot-small-thumb', false);
                        if (wp_attachment_is_image($mid)) {
                            $ad_image_html = '<a href="' . get_the_permalink() . '"><img class="img-responsive" src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '"></a>';
                        } else {
                            $ad_image_html = '<a href="' . get_the_permalink() . '"><img class="img-responsive" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"></a>';
                        }
                        $counting++;
                    }
                } else {
                    $ad_image_html = '<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>';
                }
                $recent_ad_html .= '<div class="list-card">
                  <div class="cont-left">
                    ' . $ad_image_html . '
                  </div>
                  <div class="cont-right">
                    <p>' . carspot_adPrice($pid) . '</p>
                    <a href="' . get_the_permalink() . '"><h5>' . $car_ad_title . '</h5></a>
                    <div class="location"><span class="iconify" data-icon="entypo:location-pin"></span> ' . carspot_display_adLocation($pid) . '</div>
                  </div>
                </div>';
            }
            wp_reset_postdata();
        }

        return '<section class="explore-cars-cities ' . $bg_color . ' ' . $top_padding . '"' . $style . '>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
            <div class="explore-cities">
              <div class="top-heading">
                ' . $search_city_title . '
              </div>
              <div class="owl-carousel owl-theme explore-city-carousel car-arrow-owl">
              ' . $locations_html . '  
              </div>
            </div>
            <div class="used-cars srh-car-types">
              <div class="top-heading">
                ' . $car_brand_title . '
              </div>
              <ul class="nav nav-tabs my-custom-tab">
                 ' . $search_brand_tab . '
                 ' . $search_body_tab . '
              </ul>
              <div class="tab-content">
                    ' . $brands_html . '
                    ' . $body_html . '
                </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
            <div class="recent-cars">
              <div class="cars-title">
                <div class="top-heading">
                    ' . $recent_ads_title . '
                </div>
              </div>
              <div class="recent-cars-list scroller">
              ' . $recent_ad_html . '
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('city_cartype_recentads_base', 'city_cartype_recentads_base_func');
}