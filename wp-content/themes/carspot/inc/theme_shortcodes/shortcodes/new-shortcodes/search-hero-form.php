<?php
if (!function_exists('carspot_search_form_hero')) {
    function carspot_search_form_hero()
    {
        vc_map(array(
                "name" => esc_html__("Hero Search Form", 'carspot'),
                "base" => "carspot_search_hero_form_base",
                "category" => esc_html__("Theme Shortcodes", 'carspot'),
                "params" => array(
                    array(
                        'group' => esc_html__('Shortcode Output', 'carspot'),
                        'type' => 'custom_markup',
                        'heading' => esc_html__('Shortcode Output', 'carspot'),
                        'param_name' => 'order_field_key',
                        'description' => carspot_VCImage('hero-search-form.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                    ),
                    array(
                        'group' => esc_html__('Categories', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Choose Categories', 'carspot'),
                        'param_name' => 'hero_form_categories',
                        'description' => 'choose only four categories',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Category", 'carspot'),
                                "param_name" => "hero_cat",
                                "admin_label" => true,
                                "value" => carspot_get_parests('ad_cats', 'yes'),
                            ),
                            array(
                                "type" => "attach_image",
                                "holder" => "img",
                                "heading" => esc_html__("Icon Image", 'carspot'),
                                "param_name" => "cat_hero_icon",
                                "description" => esc_html__('40x40', 'carspot'),
                            ),
                        )
                    ),
                    /* price range */
                    array(
                        "group" => esc_html__("Categories", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Min Price Range", 'carspot'),
                        "param_name" => "car_min_price_range",

                    ),
                    array(
                        "group" => esc_html__("Categories", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Max Price Range", 'carspot'),
                        "param_name" => "car_max_price_range",
                    ),
                    array(
                        "group" => esc_html__("Years", "carspot"),
                        'type' => 'param_group',
                        'heading' => esc_html__('Select Year ( All or Selective )', 'carspot'),
                        'param_name' => 'years',
                        'value' => '',
                        'params' => array(
                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Select Year", 'carspot'),
                                "param_name" => "year",
                                "admin_label" => true,
                                "value" => carspot_get_all('ad_years', 'yes'),
                            ),

                        )
                    ),

                    /* search by car Brands */
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
                )
            )
        );
    }
}
add_action('vc_before_init', 'carspot_search_form_hero');

if (!function_exists('carspot_search_hero_form_base_func')) {
    function carspot_search_hero_form_base_func($atts, $content = '')
    {
        global $carspot_theme;
        extract(shortcode_atts(array(
            'hero_form_categories' => '',
            'hero_cat' => '',
            'cat_hero_icon' => '',
            'car_min_price_range' => '',
            'car_max_price_range' => '',
            'years' => '',
            'year' => '',
            'car_brand_tab_title' => '',
            'search_brand' => '',
            'ad_brand' => '',
            'brand_img' => '',
            'search_body_type' => '',
            'car_body_tab_title' => '',
            'ad_body_type' => '',
            'body_img' => '',
        ), $atts));

        /* =================== */
        /*  search Tabs        */
        /* =================== */

        $car_min_price_range = (isset($car_min_price_range) && $car_min_price_range != '') ? (int)$car_min_price_range : 0;
        $car_max_price_range = (isset($car_max_price_range) && $car_max_price_range != '') ? (int)$car_max_price_range : 500000;

        /* years */
        $rows_years = vc_param_group_parse_atts($atts['years']);
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        $year_arr = array();
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == 'all') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0) {
                        continue;
                    }
                    $year_arr[] = $get_year->term_id;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $year_arr[] = $all_year->term_id;
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }

        /* all categories for dropdown */
        $cats_html = '';
        $ad_cats_drop = carspot_get_cats('ad_cats', 0);
        if (count((array)$ad_cats_drop) > 0) {
            foreach ($ad_cats_drop as $row_cat) {
                $cats_html .= '<option value="' . $row_cat->term_id . '">' . $row_cat->name . '</option>';
            }
        }

        /*
         * Price Slider
         * */
        wp_enqueue_script('price-slider-custom', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array(), false, true);

        /* Choosed Categories */
        $search_hero_categ_tab_html = $hero_form_section_html = '';
        if (isset($atts['hero_form_categories'])) {
            $categ_rows = vc_param_group_parse_atts($atts['hero_form_categories']);
            if (count((array)$categ_rows) > 0) {
                $count = 0;
                $active = '';
                foreach ($categ_rows as $row) {
                    $count = $count + 1;
                    if ($count > 4) {
                        break;
                    }
                    if (isset($row['hero_cat']) && $row['hero_cat'] != "") {
                        $cat_hero_icon = (isset($row['cat_hero_icon']) && $row['cat_hero_icon'] != '') ? '<img src="' . carspot_returnImgSrc($row['cat_hero_icon']) . '">' : '<span class="iconify" data-icon="cil:car-alt"></span>';
                        $category_hero = get_term_by('slug', $row['hero_cat'], 'ad_cats');
                        if (count((array)$category_hero) == 0) {
                            continue;
                        }
                        if ($count == 1) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        $search_hero_categ_tab_html .= '<li class="categ_data ' . $active . '" data-categ_id="' . $category_hero->term_id . '" data-years_arr="' . serialize($year_arr) . '"><a href="#' . $category_hero->slug . '" data-toggle="tab">
      <span class="iconify" data-icon="cil:car-alt"></span>
      <span>' . $category_hero->name . ' ' . esc_html__("Search", "carspot") . '</span>
    </li>';
                        $hero_form_section_html .= '<div class="tab-pane ' . $active . '" id="' . $category_hero->slug . '">
                                                          <div class="search-content">
                                                            <div class="srh-heading">
                                                              <h4>' . esc_html__("Search Keyword", "carspot") . '</h4>
                                                              <a href="javascript:void(0)" id="reset_hero_form"><span><span class="iconify" data-icon=""></span>' . esc_html__("", "carspot") . '</span></a>
                                                            </div>
                                                            <form id="hero-form" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                                                            <input class="form-control banner-icon-search" type="text" autocomplete="off" id="autocomplete-dynamic" name="ad_title" placeholder="' . esc_html__('What are you looking for...', 'carspot') . '">
                                                            <div class="slct-optn">
                                                              <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                  <h4>' . esc_html__("Select Make", "carspot") . '</h4>
                                                                  <div class="category_change">
                                                                  <select class="form-select" id="new_hero_cat" aria-label="Default select example" name="cat_id">
                                                                    <option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>
				  		' . $cats_html . '
                                                                  </select>
                                                                  </div>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                  <h4>' . esc_html__("Select Year", "carspot") . '</h4>
                                                                  <select class="form-select" aria-label="Default select example" name="year_from">
                                                                    <option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
							' . $years_html . '
                                                                  </select>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <h4>' . esc_html__("Price", "carspot") . '</h4>
                                                            <div id="price-slider"></div>
                                                            <div class="input-group margin-top-10">
                                                                <input type="text" class="form-control" name="min_price" id="min_selected" value="' . esc_attr($car_min_price_range) . '"  autocomplete="off"/>
                                                                <span class="input-group-addon">-</span>
                                                                <input type="text" class="form-control" name="max_price" id="max_selected" value="' . esc_attr($car_max_price_range) . '" autocomplete="off"/>
                                                            </div>
                                                            <input type="hidden" id="min_price" value="' . $car_min_price_range . '" />
                                                            <input type="hidden" id="max_price" value="' . $car_max_price_range . '" />
                                                            <div class="botm-btn" >
                                                            <button type = "submit" class="btn btn-danger btn-lg btn-block" > ' . esc_html__('Search', 'carspot') . ' </button >
                                                            </div >
                        ' . cs_form_lang_field_callback(true) . '
                                                            </form >
                                                          </div >
                                                        </div > ';
                    }
                }
            }
        }


        /* =================== */
        /*  search by Brands   */
        /* =================== */
        $brands_html = $search_brand_tab = '';
        $car_brand_tab_title = (isset($car_brand_tab_title) && $car_brand_tab_title != '') ? $car_brand_tab_title : esc_html__("Search By Car Brands", "carspot");
        if (isset($atts['search_brand'])) {
            $rows = vc_param_group_parse_atts($atts['search_brand']);
            if (count((array)$rows) > 0) {
                $search_brand_tab = '<li id = "brand_tab" class="active" ><a class="left" href = "#abrand" role = "tab" data-toggle = "tab" > ' . $car_brand_tab_title . '</a ></li >';
                $brands_html .= '<div class="tab-pane active" id = "abrand" ><div id = "owl1" class="owl-carousel owl-theme car-brand-owl car-arrow-owl owl-loaded" > ';
                foreach ($rows as $row) {
                    if (isset($row['ad_brand']) && isset($row['brand_img']) && $row['ad_brand'] != "") {
                        $category_brand = get_term_by('slug', $row['ad_brand'], 'ad_cats');
                        if (count((array)$category_brand) == 0) {
                            continue;
                        }
                        $bgImageURL = carspot_returnImgSrc($row['brand_img']);
                        if (isset($category_brand->name) && $bgImageURL != "" && $category_brand->name != "") {
                            $brands_html .= '<div class="item" >
                                                <div class="car-type" >
                                                <a href = "' . esc_url(get_term_link($category_brand->term_id)) . '" ><img src = "' . esc_url($bgImageURL) . '" alt = "' . esc_attr($category_brand->name) . '" ></a >
                                                <a href = "' . esc_url(get_term_link($category_brand->term_id)) . '" ><p > ' . esc_attr($category_brand->name) . '</p ></a >
                                                </div >
                                           </div > ';
                        }
                    }
                }
                $brands_html .= '</div ></div > ';
            }
        }

        /* =================== */
        /* Search by Body Type */
        /* ================== */
        $car_body_tab_title = (isset($car_body_tab_title) && $car_body_tab_title != '') ? ($car_body_tab_title) : esc_html__("Search By Body Type", "carspot");
        $body_html = $search_body_tab = '';
        if (isset($atts['search_body_type'])) {
            $rows_body = vc_param_group_parse_atts($atts['search_body_type']);
            if (count((array)$rows_body) > 0) {
                $search_body_tab = '<li id = "type_tab" ><a class="right" href = "#btype" role = "tab" data-toggle = "tab" > ' . $car_body_tab_title . '</a ></li > ';
                $body_html .= '<div class="tab-pane" id = "btype" ><div id = "owl2" class="owl-carousel owl-theme car-type-owl car-arrow-owl owl-loaded" > ';
                foreach ($rows_body as $row) {
                    if (isset($row['ad_body_type']) && $row['ad_body_type'] != "") {
                        $category_body = get_term_by('slug', $row['ad_body_type'], 'ad_body_types');
                        if (count((array)$category_body) == 0) {
                            continue;
                        }
                        $bgImageURL_body = carspot_returnImgSrc($row['body_img']);
                        if (isset($category_body->name) && $bgImageURL_body != "" && $category_body->name != "") {
                            $body_html .= '<div class="item">
                              <div class="car-type" >
                                <a href = "' . esc_url(get_term_link($category_body->term_id)) . '" ><img src = "' . esc_url($bgImageURL_body) . '" alt = "' . esc_attr($category_body->name) . '" ></a >
                                <a href = "' . esc_url(get_term_link($category_body->term_id)) . '" ><p > ' . esc_attr($category_body->name) . '</p ></a >
                              </div >
                            </div >';
                        }
                    }
                }
                $body_html .= '</div ></div > ';
            }
        }

        return '<section class="search-car-brands" >
      <div class="container" >
        <div class="row" >
          <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 col-xxl-5" >
            <div class="search-car-option" >
              <ul class="nav nav-tabs search-tab" >
                        ' . $search_hero_categ_tab_html . '
              </ul >
              <div class="tab-content" >
                        ' . $hero_form_section_html . '
              </div >
            </div >
          </div >
          <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-7 col-xxl-7" >
            <div class="srh-car-types" >
              <ul class="nav nav-tabs my-custom-tab" >
                        ' . $search_brand_tab . '
                 ' . $search_body_tab . '
                 </ul >
              <div class="tab-content" >
                        ' . $brands_html . '
                    ' . $body_html . '
                    </div >
              </div >
            </div >
          </div >
        </div >
    </section > ';

    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('carspot_search_hero_form_base', 'carspot_search_hero_form_base_func');
}