<?php
get_header();

wp_enqueue_script('carspot-search');
global $carspot_theme;
$meta = array(
    'key' => 'post_id',
    'value' => '0',
    'compare' => '!=',
);

/* ================= */
/*     Condition   */
/* ================= */
$condition = '';
if (isset($_GET['condition']) && $_GET['condition'] != "") {
    $condition = array(
        'key' => '_carspot_ad_condition',
        'value' => $_GET['condition'],
        'compare' => '=',
    );
    $condition = apply_filters('carsport_add_multiquery_args', $condition, 'condition', '_carspot_ad_condition');
}

/* ================= */
/*      Ad Type    */
/* ================= */
$ad_type = '';
if (isset($_GET['ad_type']) && $_GET['ad_type'] != "") {
    $ad_type = array(
        'key' => '_carspot_ad_type',
        'value' => $_GET['ad_type'],
        'compare' => '=',
    );
    $ad_type = apply_filters('carsport_add_multiquery_args', $ad_type, 'ad_type', '_carspot_ad_type');
}

/* ================= */
/*      Warranty   */
/* ================= */
$warranty = '';
if (isset($_GET['warranty']) && $_GET['warranty'] != "") {
    $warranty = array(
        'key' => '_carspot_ad_warranty',
        'value' => $_GET['warranty'],
        'compare' => '=',
    );
    $warranty = apply_filters('carsport_add_multiquery_args', $warranty, 'warranty', '_carspot_ad_warranty');
}

/* =========================== */
/*      Feature or simple     */
/* ========================== */
$feature_or_simple = '';
if (isset($_GET['ad']) && $_GET['ad'] != "") {
    $feature_or_simple = array(
        'key' => '_carspot_is_feature',
        'value' => $_GET['ad'],
        'compare' => '=',
    );
}

/* ================= */
/*      Price      */
/* ================= */
$price = '';
if (isset($_GET['min_price']) && $_GET['min_price'] != "") {
    $price = array(
        'key' => '_carspot_ad_price',
        'value' => array($_GET['min_price'], $_GET['max_price']),
        'type' => 'numeric',
        'compare' => 'BETWEEN',
    );
}

/* ================= */
/*      Sorting    */
/* ================= */
$order = 'desc';
$orderBy = 'date';
$price_key = "";
if (isset($_GET['sort']) && $_GET['sort'] != "") {
    $orde_arr = explode('-', $_GET['sort']);
    $order = isset($orde_arr[1]) ? $orde_arr[1] : 'desc';

    if (isset($orde_arr[0]) && $orde_arr[0] == 'price') {

        $price_key   =  "_carspot_ad_price";
        $orderBy = 'meta_value_num';
    } else {
        $orderBy = isset($orde_arr[0]) ? $orde_arr[0] : 'ID';
        $price_key   =  "_carspot_ad_price";
    }
}

/* ================= */
/*      Category     */
/* ================= */
$category = '';
if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
    $category = array(
        array(
            'taxonomy' => 'ad_cats',
            'field' => 'term_id',
            'terms' => $_GET['cat_id'],
            'include_children' => true,
        ),
    );
}

/* ================= */
/*      Title      */
/* ================= */
$title = '';
if (isset($_GET['ad_title']) && $_GET['ad_title'] != "") {
    $title = str_replace("–", "-", $_GET['ad_title']);
}

/* ================= */
/*       Year      */
/* ================= */
$year = '';
$year_from = '';
$year_to = '';
if (isset($_GET['year_from']) && $_GET['year_from'] != "") {
    $year_from = $_GET['year_from'];
    $year = array(
        'key' => '_carspot_ad_years',
        'value' => $_GET['year_from'],
        'compare' => '=',
    );
}

if (isset($_GET['year_to']) && $_GET['year_to'] != "") {
    $year_to = $_GET['year_to'];
}

if ($year_from != "" && $year_to != "") {
    $year = array(
        'key' => '_carspot_ad_years',
        'value' => array($year_from, $year_to),
        'type' => 'numeric',
        'compare' => 'BETWEEN',
    );
}

/* ============= */
/* Body Type */
/* ============= */
$body_type = '';
if (isset($_GET['body_type']) && $_GET['body_type'] != "") {
    $body_type = array(
        'key' => '_carspot_ad_body_types',
        'value' => $_GET['body_type'],
        'compare' => '=',
    );
    $body_type = apply_filters('carsport_add_multiquery_args', $body_type, 'body_type', '_carspot_ad_body_types');
}

/* ============= */
/* Transmission */
/* ============= */
$transmission = '';
if (isset($_GET['transmission']) && $_GET['transmission'] != "") {
    $transmission = array(
        'key' => '_carspot_ad_transmissions',
        'value' => $_GET['transmission'],
        'compare' => '=',
    );
    $transmission = apply_filters('carsport_add_multiquery_args', $transmission, 'transmission', '_carspot_ad_transmissions');
}

/* ============= */
/* Engine Type */
/* ============= */
$engine_type = '';
if (isset($_GET['engine_type']) && $_GET['engine_type'] != "") {
    $engine_type = array(
        'key' => '_carspot_ad_engine_types',
        'value' => $_GET['engine_type'],
        'compare' => '=',
    );
    $engine_type = apply_filters('carsport_add_multiquery_args', $engine_type, 'engine_type', '_carspot_ad_engine_types');
}

/* ================= */
/* Engine Capacity */
/* ================= */
$engine_capacity = '';
if (isset($_GET['engine_capacity']) && $_GET['engine_capacity'] != "") {
    $engine_capacity = array(
        'key' => '_carspot_ad_engine_capacities',
        'value' => $_GET['engine_capacity'],
        'compare' => '=',
    );
    $engine_capacity = apply_filters('carsport_add_multiquery_args', $engine_capacity, 'engine_capacity', '_carspot_ad_engine_capacities');
}
/* ================= */
/*     Assembly    */
/* ================= */
$assembly = '';
if (isset($_GET['assembly']) && $_GET['assembly'] != "") {
    $assembly = array(
        'key' => '_carspot_ad_assembles',
        'value' => $_GET['assembly'],
        'compare' => '=',
    );
    $assembly = apply_filters('carsport_add_multiquery_args', $assembly, 'assembly', '_carspot_ad_assembles');
}

/* ================= */
/*   Color Family  */
/* ================= */
$color_family = '';
if (isset($_GET['color_family']) && $_GET['color_family'] != "") {
    $color_family = array(
        'key' => '_carspot_ad_colors',
        'value' => $_GET['color_family'],
        'compare' => '=',
    );
    $color_family = apply_filters('carsport_add_multiquery_args', $color_family, 'color_family', '_carspot_ad_colors');
}

/* ================= */
/*     Insurance   */
/* ================= */
$ad_insurance = '';
if (isset($_GET['insurance']) && $_GET['insurance'] != "") {
    $ad_insurance = array(
        'key' => '_carspot_ad_insurance',
        'value' => $_GET['insurance'],
        'compare' => '=',
    );
    $ad_insurance = apply_filters('carsport_add_multiquery_args', $ad_insurance, 'insurance', '_carspot_ad_insurance');
}

/* ================= */
/*    car features   */
/* ================= */
$ad_features = '';
if (isset($_GET['ad_feature']) && $_GET['ad_feature'] != "") {
    $ad_features = array(
        'key' => '_carspot_ad_features',
        'value' => $_GET['ad_feature'],
        'compare' => 'LIKE',
    );
    //$ad_features = apply_filters('carsport_add_multiquery_args', $ad_features, 'ad_feature', '_carspot_ad_features');
}
/* ================= */
/*     car Tags      */
/* ================= */
$ad_tags = '';
if (isset($_GET['ad_tag']) && $_GET['ad_tag'] != "") {
    $ad_tags = array(
        'taxonomy' => 'ad_tags',
        'field' => 'term_id',
        'terms' => $_GET['ad_tag'],
    );
    //$ad_tags = apply_filters('carsport_add_multiquery_args', $ad_tags, 'ad_tag', 'ad_tags');
}


/* ================= */
/*      Mileage      */
/* ================= */
$mileage = '';
$milage_from = '';
$mileage_to = '';
if (isset($_GET['mileage_from']) && $_GET['mileage_from'] != "") {
    $milage_from = $_GET['mileage_from'];
}
if (isset($_GET['mileage_to']) && $_GET['mileage_to'] != "") {
    $mileage_to = $_GET['mileage_to'];
}
if ($milage_from != '' && $mileage_to != '') {
    $mileage = array(
        'key' => '_carspot_ad_mileage',
        'value' => array($milage_from, $mileage_to),
        'type' => 'numeric',
        'compare' => 'BETWEEN',
    );
}

/* ================= */
/*     Model   */
/* ================= */
$model = '';
if (isset($_GET['ad_model']) && $_GET['ad_model'] != "") {
    $model = array(
        'key' => '_carspot_tpl_field_ad_model',
        'value' => $_GET['ad_model'],
        'compare' => '=',
    );
}

/* ================= */
/*     Hours   */
/* ================= */
$hours = '';
if (isset($_GET['ad_hours']) && $_GET['ad_hours'] != "") {
    $hours = array(
        'key' => '_carspot_tpl_field_ad_hours',
        'value' => $_GET['ad_hours'],
        'compare' => '=',
    );
}


/* ================= */
/*     Brands   */
/* ================= */
$brand = '';
if (isset($_GET['ad_brand']) && $_GET['ad_brand'] != "") {
    $brand = array(
        'key' => '_carspot_tpl_field_ad_brand',
        'value' => $_GET['ad_brand'],
        'compare' => '=',
    );
}


/* ================= */
/*     Brand   */
/* ================= */
$weight = '';
if (isset($_GET['ad_weight']) && $_GET['ad_weight'] != "") {
    $weight = array(
        'key' => '_carspot_tpl_field_ad_weight',
        'value' => $_GET['ad_weight'],
        'compare' => '=',
    );
}




/* ================= */
/*     Location      */
/* ================= */
$countries_location = '';
if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
    $countries_location = array(
        array(
            'taxonomy' => 'ad_country',
            'field' => 'term_id',
            'terms' => $_GET['country_id'],
        ),
    );
}

$countries_custom_location = '';
if (isset($_GET['cs_srch_address']) && $_GET['cs_srch_address'] != "") {
    $countries_custom_location = array(
        array(
            'key' => '_carspot_ad_map_location',
            'value' => trim($_GET['cs_srch_address']),
            'compare' => 'LIKE',
        ),
    );
}

/* ================= */
/*      Radius       */
/* ================= */
$lat_lng_meta_query = array();
if (isset($_GET['radius']) && $_GET['radius'] != "") {
    $latitude = '';
    $longitude = '';
    $distance = '';
    $unit_radius = "KM";
    if (isset($_GET['radius_unit']) && $_GET['radius_unit'] != "" && $_GET['radius_unit'] === "Miles") {
        $unit_radius = "Miles";
    }
    if (!empty($_GET['loc_lat']) && !empty($_GET['loc_long']) && !empty($_GET['radius'])) {
        $latitude = $_GET['loc_lat'];
        $longitude = $_GET['loc_long'];
    }
    if (!empty($latitude) && !empty($longitude)) {
        $distance = $_GET['radius'];
        $data_array = array("longitude" => $longitude, "latitude" => $latitude, "distance" => $distance);
        $lats_longs = carspot_radius_search($data_array, false, $unit_radius);
        if (!empty($lats_longs) && count((array)$lats_longs) > 0) {
            $lat_lng_meta_query[] = array(
                'key' => '_carspot_ad_map_lat',
                'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                'compare' => 'BETWEEN',
                'type' => 'DECIMAL',
            );
            $lat_lng_meta_query[] = array(
                'key' => '_carspot_ad_map_long',
                'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                'compare' => 'BETWEEN',
                'type' => 'DECIMAL',
            );
            add_filter('get_meta_sql', 'carspot_cast_decimal_precision');
            if (!function_exists('carspot_cast_decimal_precision')) {

                function carspot_cast_decimal_precision($array)
                {
                    $array['where'] = str_replace('DECIMAL', 'DECIMAL(10,3)', $array['where']);
                    return $array;
                }

            }
        }
    }
}

//*****************************

$custom_search = array();
if (isset($_GET['custom'])) {
    foreach ($_GET['custom'] as $key => $val) {
        $val = stripslashes_deep($val);
        if (trim($val) == "0") {
            continue;
        }
        $metaKey = '_carspot_tpl_field_' . $key;
        $custom_search[] = array(
            'key' => $metaKey,
            'value' => trim($val),
            'compare' => 'LIKE',
        );
    }
}

$show_featured_in_search = '';
$value_from_theme_options = $carspot_theme['feature_ads_in_regular'];
if ($value_from_theme_options == '1') {
    $show_featured_in_search = array(/* array(
              'key' => '_carspot_is_feature',
              'value' => 1,
              'compare' => '=',
              ), */
    );
} else {
    $show_featured_in_search = array(
        'relation' => 'OR',
        array(
            'key' => '_carspot_is_feature',
            'value' => '', //<--- not required but necessary in this case
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => '_carspot_is_feature',
            'value' => '1',
            'compare' => '!=',
        ),
    );
}

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    /* This will occur if on front page. */
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$is_active = '';
if (isset($carspot_theme['show_only_active_ads']) && $carspot_theme['show_only_active_ads']) {
    $is_active = array(
        'key' => '_carspot_ad_status_',
        'value' => 'active',
        'compare' => '=',
    );
}

$args = array(
    's' => $title,
    'post_type' => 'ad_post',
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'tax_query' => array(
        $category,
        $ad_tags,
        $countries_location,
    ),
    'meta_key' =>  $price_key,
    'meta_query' => array(
        $is_active,
        $condition,
        $ad_features,
        $ad_type,
        $warranty,
        $feature_or_simple,
        $price,
        $year,
        $body_type,
        $transmission,
        $engine_type,
        $engine_capacity,
        $assembly,
        $color_family,
        $ad_insurance,
        $mileage,
        $custom_search,
        $show_featured_in_search,
        $lat_lng_meta_query,
        $countries_custom_location,
        $model,
        $brand,
        $hours,
        $weight
    ),
    'order' => $order,
    'orderby' => $orderBy,
    'paged' => $paged,
);
$args = carspot_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);
$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
$search_sidebar_position = isset($carspot_theme['search_sidebar_position']) ? $carspot_theme['search_sidebar_position'] : 'bottom';
?>
    <div class="main-content-area clearfix">
        <section class="section-padding <?php echo esc_attr($top_padding); ?> gray page-search">
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <?php
                    if ($search_sidebar_position == 'top') {
                        get_sidebar('ads');
                    }
                    ?>
                    <div class="col-md-9 col-lg-9 col-xs-12">
                        <!-- Row -->
                        <div class="row">
                            <?php
                            $is_demo_get = '';
                            $is_demo_get = carspot_search_layouts_demo();
                            if (isset($carspot_theme['search_layout'])) {
                                ?>
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <div class="clearfix"></div>
                                    <div class="listingTopFilterBar">
                                        <div class="col-md-7 col-xs-12 col-sm-6 no-padding">
                                            <ul class="filterAdType">
                                                <li class="active">
                                                    <a href="javascript:void(0)"><?php echo esc_html__('Found Ads', 'carspot'); ?>
                                                        <small>(<?php echo esc_html($results->found_posts); ?>)</small>
                                                    </a>
                                                </li>
                                                <?php
                                                $param = $_SERVER['QUERY_STRING'];
                                                if ($param != "") {
                                                    ?>

                                                    <li class="">
                                                        <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"><?php echo esc_html__('Reset Search', 'carspot'); ?></a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-5 col-xs-12 col-sm-6 no-padding">
                                            <div class="header-listing">
                                                <h6><?php echo esc_html__('Sort by', 'carspot'); ?>:</h6>
                                                <div class="custom-select-box">
                                                    <?php
                                                 
                                                    $latest = '';
                                                    $oldest = '';
                                                    $selectedOldest = $selectedLatest = $selectedTitleAsc = $selectedTitleDesc = $selectedPriceHigh = $selectedPriceLow = '';
                                                    if (isset($_GET['sort'])) {
                                                        $selectedOldest = ($_GET['sort'] == 'id-asc') ? 'selected' : '';
                                                        $selectedLatest = ($_GET['sort'] == 'id-desc') ? 'selected' : '';
                                                        $selectedTitleAsc = ($_GET['sort'] == 'title-asc') ? 'selected' : '';
                                                        $selectedTitleDesc = ($_GET['sort'] == 'title-desc') ? 'selected' : '';
                                                        $selectedPriceHigh = ($_GET['sort'] == 'price-desc') ? 'selected' : '';
                                                        $selectedPriceLow = ($_GET['sort'] == 'price-asc') ? 'selected' : '';
                                                    }
                                                    ?>
                                                    <form method="get">
                                                        <select name="sort" id="order_by" class="custom-select">
                                                            <option value="id-desc" <?php echo esc_attr($selectedLatest); ?>>
                                                                <?php echo esc_html__('Newest To Oldest', 'carspot'); ?>
                                                            </option>
                                                            <option value="id-asc" <?php echo esc_attr($selectedOldest); ?>>
                                                                <?php echo esc_html__('Oldest To New', 'carspot'); ?>
                                                            </option>
                                                            <option value="title-asc" <?php echo esc_attr($selectedTitleAsc); ?>>
                                                                <?php echo esc_html__('Alphabetically [a-z]', 'carspot'); ?>
                                                            </option>
                                                            <option value="title-desc" <?php echo esc_attr($selectedTitleDesc); ?>>
                                                                <?php echo esc_html__('Alphabetically [z-a]', 'carspot'); ?>
                                                            </option>
                                                            <option value="price-desc" <?php echo esc_attr($selectedPriceHigh); ?>>
                                                                <?php echo esc_html__('Highest price', 'carspot'); ?>
                                                            </option>
                                                            <option value="price-asc" <?php echo esc_attr($selectedPriceLow); ?>>
                                                                <?php echo esc_html__('Lowest price', 'carspot'); ?>
                                                            </option>
                                                        </select>
                                                        <?php echo carspot_search_params('sort'); ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php
                            }
                            ?>
                            <?php
                            if (isset($carspot_theme['feature_on_search']) && $carspot_theme['feature_on_search']) {

                                $is_active = '';
                                if (isset($carspot_theme['show_only_active_ads']) && $carspot_theme['show_only_active_ads']) {
                                    $is_active = array(
                                        'key' => '_carspot_ad_status_',
                                        'value' => 'active',
                                        'compare' => '=',
                                    );
                                }
                                $args = array(
                                    'post_type' => 'ad_post',
                                    'posts_per_page' => $carspot_theme['max_ads_feature'],
                                    'tax_query' => array(
                                        $category,
                                        $ad_tags,
                                    ),
                                    'meta_query' => array(
                                        array(
                                            'key' => '_carspot_is_feature',
                                            'value' => 1,
                                            'compare' => '=',
                                        ),
                                        $is_active,
                                        $condition,
                                        $ad_features,
                                        $ad_type,
                                        $warranty,
                                        $feature_or_simple,
                                        $price,
                                        $year,
                                        $body_type,
                                        $transmission,
                                        $engine_type,
                                        $engine_capacity,
                                        $assembly,
                                        $color_family,
                                        $ad_insurance,
                                        $mileage,
                                        $custom_search,
                                        $lat_lng_meta_query,
                                    ),
                                    'orderby' => 'rand',
                                );
                                $ads = new ads();
                                if ($carspot_theme['search_featured_layout'] && $carspot_theme['search_featured_layout'] == 'search_featured_layout_grid') {
                                    echo($ads->carspot_get_ads_grid_slider($args, $carspot_theme['feature_ads_title']));
                                }
                                if ($carspot_theme['search_featured_layout'] && $carspot_theme['search_featured_layout'] == 'search_featured_layout_list') {
                                    echo($ads->carspot_search_layout_list_ads_featured($args, $carspot_theme['feature_ads_title']));
                                }
                            }
                            if (isset($carspot_theme['search_ad_720_1']) && $carspot_theme['search_ad_720_1'] != "") {
                                ?>
                                <div class="col-md-12">
                                    <div class="margin-bottom-30 margin-top-10">
                                        <?php echo "" . $carspot_theme['search_ad_720_1']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                            <?php
                            $current_layout = '';
                            $current_layout = $carspot_theme['search_layout'];
                            $is_demo_get = carspot_search_layouts_demo();
                            if ($is_demo_get != "")
                                $current_layout = $is_demo_get;

                            $layouts = array('list_1', 'list_2', 'list_3');

                            if ($results->have_posts()) {
                                if (in_array($current_layout, $layouts)) {
                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-list.php";
                                    echo($out);
                                } else {
                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
                                    echo($out);
                                }

                                /* Restore original Post Data */
                                wp_reset_postdata();
                            }
                            ?>
                            <div class="clearfix"></div>
                            <?php if (isset($carspot_theme['search_ad_720_2']) && $carspot_theme['search_ad_720_2'] != "") { ?>
                                <div class="col-md-12">
                                    <div class="margin-top-10 margin-bottom-30">
                                        <?php echo "" . $carspot_theme['search_ad_720_2']; ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="text-center margin-top-30 margin-bottom-20">
                                <?php carspot_pagination_search($results); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($search_sidebar_position == 'bottom') {
                        get_sidebar('ads');
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
<?php get_footer();