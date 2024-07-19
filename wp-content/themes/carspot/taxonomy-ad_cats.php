<?php
get_header();
global $carspot_theme;
$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
$ad_type = '';
if (isset($_GET['ad_type']) && $_GET['ad_type'] != "") {
    $ad_type = array(
        'key' => '_carspot_ad_type',
        'value' => $_GET['ad_type'],
        'compare' => '=',
    );
}
else if (isset($_GET['adtype']) && $_GET['adtype'] != "") {
    $ad_type = array(
        'key' => '_carspot_ad_type',
        'value' => $_GET['adtype'],
        'compare' => '=',
    );
}
//Location
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
$order = 'desc';
$orderBy = 'date';
if (isset($_GET['sort']) && $_GET['sort'] != "") {
    $orde_arr = explode('-', $_GET['sort']);
    $order = isset($orde_arr[1]) ? $orde_arr[1] : 'desc';
    if (isset($orde_arr[0]) && $orde_arr[0] == 'price') {
        $orderBy = 'meta_value_num';
    } else {
        $orderBy = isset($orde_arr[0]) ? $orde_arr[0] : 'date';
    }
}


$category = '';
$category = array(
    array(
        'taxonomy' => 'ad_cats',
        'field' => 'term_id',
        'terms' => get_queried_object_id(),
        'include_children' => 0,
    ),
);
$condition = '';
if (isset($_GET['condition']) && $_GET['condition'] != "") {
    $condition = array(
        'key' => '_carspot_ad_condition',
        'value' => $_GET['condition'],
        'compare' => '=',
    );
}

global $pass_term_id;
$pass_term_id = get_queried_object_id();


$title = '';
if (isset($_GET['ad_title']) && $_GET['ad_title'] != "") {
    $title = $_GET['ad_title'];
}

$custom_search = array();

if (isset($_GET['min_custom'])) {
    foreach ($_GET['min_custom'] as $key => $val) {
        $get_minVal = $val;
        $get_maxVal = ( isset($_GET['max_custom']["$key"]) && $_GET['max_custom']["$key"] != "" ) ? $_GET['max_custom']["$key"] : '';
        if ($get_minVal != "" && $get_maxVal != "") {
            $metaKey = '_carspot_tpl_field_' . $key;

            if (carspot_validateDateFormat($get_minVal) && carspot_validateDateFormat($get_maxVal)) {
                $custom_search[] = array(
                    'key' => $metaKey,
                    'value' => array($get_minVal, $get_maxVal),
                    'compare' => 'BETWEEN',
                );
            } else {

                $custom_search[] = array(
                    'key' => $metaKey,
                    'value' => array($get_minVal, $get_maxVal),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN',
                );
            }
        }
    }
}

if (isset($_GET['custom'])) {
    foreach ($_GET['custom'] as $key => $val) {
        if (is_array($val)) {
            $arr = array();
            $metaKey = '_carspot_tpl_field_' . $key;

            foreach ($val as $v) {

                $custom_search[] = array(
                    'key' => $metaKey,
                    'value' => $v,
                    'compare' => 'LIKE',
                );
            }
        } else {
            if (trim($val) == "0") {
                continue;
            }

            $val = stripslashes_deep($val);

            $metaKey = '_carspot_tpl_field_' . $key;
            $custom_search[] = array(
                'key' => $metaKey,
                'value' => $val,
                'compare' => 'LIKE',
            );
        }
    }
}

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    // This will occur if on front page.
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$args = array(
    's' => $title,
    'post_type' => 'ad_post',
    'post_status' => 'publish',
    'posts_per_page' =>  get_option('posts_per_page'),
    'tax_query' => array(
        $category,
        $countries_location,
    ),
    'meta_key' => '_carspot_ad_price',
    'meta_query' => array(
        $condition,
        $ad_type,
        $custom_search,
    ),
    'order' => $order,
    'orderby' => $orderBy,
    'paged' => $paged,
);
$args = apply_filters('carspot_wpml_show_all_posts', $args);

$results = new WP_Query($args);

$search_cat_page = isset($carspot_theme['search_cat_page']) && $carspot_theme['search_cat_page'] ? TRUE : FALSE;
?>
    <div class="main-content-area clearfix">
        <section class="section-padding <?php echo esc_attr($top_padding); ?> ">
            <!-- Main Container -->
            <div class="container-fluid">
                <!-- Row -->
                <div class="row">
                    <!-- Middle Content Area -->
                    <div class="col-md-12 col-lg-12 col-sx-12">
                        <!-- Row -->
                        <div class="row">
                            <?php
//                            $search_sidebar_position = isset($carspot_theme['search_sidebar_position']) ? $carspot_theme['search_sidebar_position'] : 'bottom';

//                            if ($search_sidebar_position == 'top') {
//                                get_sidebar('ads');
//                            }
                            ?>
                            <div class="col-md-4 col-xs-12 col-sm-12 col-lg-2 padding-top-20">
                              <?php  if (is_active_sidebar('sb_themes_sidebar_archive')) {
                                    dynamic_sidebar('sb_themes_sidebar_archive');
                                }?>
                            </div>
                            <?php
                                if (have_posts()) {
                            ?>
                                <!-- Ads Archive -->
                                <div class="posts-masonry gray">
                                    <div class="cat-description">
                                        <?php echo category_description(); ?>
                                    </div>
                                    <div class="col-md-8 col-xs-12 col-sm-12 col-lg-10">
                                        <ul class="list-unstyled">
                                            <?php
                                            while (have_posts()) {
                                                the_post();
                                                $pid = get_the_ID();
                                                $ad = new ads();
                                                echo($ad->carspot_search_layout_list($pid));
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Ads Archive End -->
                                <div class="clearfix"></div>
                                <!-- Pagination -->
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <?php carspot_pagination(); ?>
                                </div>
                                <!-- Pagination End -->
                                <?php
                            } else {
                                get_template_part('template-parts/content', 'none');
                            }
                            ?>
                        </div>
                        <!-- Row End -->
                    </div>
                    <!-- Middle Content Area  End -->
                </div>
                <!-- Row End -->
            </div>
            <!-- Main Container End -->
        </section>
    </div>
<?php get_footer();