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
/*     Condition     */
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

$price_key   =  "";
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
    'meta_key' => $price_key,
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
    ),
    'order' => $order,
    'orderby' => $orderBy,
    'paged' => $paged,
);
$args = carspot_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);

?>
    <section class="carspot-search-filter featured-offer page-search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md 12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="filter-switcher">
                        <div class="left-cont">
                            <button class="btn filter-btn"><span class="iconify"
                                                                 data-icon="system-uicons:filtering"></span>
                                <?php echo esc_html__("Filter", "carspot"); ?>
                            </button>
                        </div>
                        <div class="right-cont">
                            <div class="left-meta">
                                <h5><?php echo $results->found_posts . esc_html__(" Matches Found For", "carspot"); ?> :
                                    <span><?php echo esc_html__("Ads", "carspot"); ?></span></h5>
                            </div>
                            <div class="right-meta">
                                <a href="#">
                                    <div class="refresh"><span class="iconify" data-icon="tabler:refresh"></span>
                                        <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"><?php echo esc_html__("Reset Filter", "carspot"); ?>
                                    </div>
                                </a>
                                <div class="sort">
                                    <span class="txt"><?php echo esc_html__("Sort By", "carspot"); ?>:</span>
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
                                    <div class="form-group freelance-category ">
                                        <form method="get">
                                            <select class="js-example-basic-single category" name="sort"
                                                    id="order_by">
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
                    <div class="side-bar-used-cars-list">
                        <div class="side-bar">
                            <div class="heading">
                                <div class="heading-left-cont">
                                    <h4>Filter</h4>
                                </div>
                                <div class="heading-right-cont">
                                    <a class="filter-reverse-btn" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             aria-hidden="true" role="img" class="iconify iconify--akar-icons"
                                             width="1em"
                                             height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"
                                             data-icon="akar-icons:chevron-right">
                                            <g fill="none">
                                                <path d="M8 4l8 8l-8 8" stroke="currentColor" stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <?php get_sidebar('ads'); ?>
                        </div>
                        <div class="used-cars-grid-list">
                            <div class="used-cars-list">
                                <div class="row">
                                    <div class="posts-masonry">
                                        <?php
                                        if ($results->have_posts()) {
                                            while ($results->have_posts()) {
                                                $results->the_post();
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
                                                        $image = wp_get_attachment_image_src($mid, 'carspot-category', false);
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
                                                ?>
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3 toggle-list-items">
                                                    <div class="ftd-card">
                                                        <div class="card-img">
                                                            <?php echo $ad_image_html; ?>
                                                            <?php echo $is_feature; ?>
                                                        </div>
                                                        <div class="card-meta">
                                                            <h6><?php echo carspot_adPrice($pid); ?></h6>
                                                            <a href="<?php echo get_the_permalink(); ?>">
                                                                <h4><?php echo $car_ad_title; ?></h4></a>
                                                            <div class="location">
                                                                <p><span class="iconify"
                                                                         data-icon="entypo:location-pin"></span>
                                                                    <?php echo carspot_display_adLocation($pid); ?></p>
                                                            </div>
                                                            <a href="javascript:void(0)">
                                                                <img class="prf-back"
                                                                     src="<?php echo get_template_directory_uri() . '/images/layer-102.png'; ?>"
                                                                     alt="">
                                                                <img class="prf" src="<?php echo esc_url($user_pic); ?>"
                                                                     alt="<?php echo __(" Profile", "carspot"); ?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            /* Restore original Post Data */
                                            wp_reset_postdata();
                                        }
                                        ?>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                            <nav aria-label="Page navigation example">
                                                <?php
                                                carspot_pagination_search($results);
                                                ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();