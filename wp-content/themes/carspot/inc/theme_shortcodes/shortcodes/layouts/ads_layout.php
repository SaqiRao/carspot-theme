<?php
extract(shortcode_atts(array(
    'cats' => '',
    's_title' => '',
    'ad_type' => '',
    'layout_type' => '',
    'ad_order' => '',
    'no_of_ads' => '',
    'main_link' => '',
    'all_cat_ads' => '',
), $atts));
$cats = array();

$is_all = false;
$html = '';
if ($all_cat_ads == 'no') {
    $rows = vc_param_group_parse_atts($atts['cats']);
    if (!isset($atts['cats']))
        return $html;
    if (count((array)$rows) > 0) {
        foreach ($rows as $row) {
            if (isset($row['cat'])) {
                if ($row['cat'] != 'all') {
                    $cats[] = $row['cat'];
                }
            }
        }
    }
}

$category = '';
if (count((array)$cats) > 0) {
    $category = array(
        array(
            'taxonomy' => 'ad_cats',
            'field' => 'slug',
            'terms' => $cats,
        ),
    );
}
$is_feature = array();
if ($ad_type == 'feature') {
    $is_feature = array(
        'key' => '_carspot_is_feature',
        'value' => 1,
        'compare' => '=',
    );
} else {
    $is_feature = array(
        'key' => '_carspot_is_feature',
        'value' => 0,
        'compare' => '=',
    );
}

$ordering = 'DESC';
$order_by = 'date';
if ($ad_order == 'asc') {
    $ordering = 'ASC';
} else if ($ad_order == 'desc') {
    $ordering = 'DESC';
} else if ($ad_order == 'rand') {
    $order_by = 'rand';
}


$args = array(
    'post_type' => 'ad_post',
    'posts_per_page' => $no_of_ads,
    'meta_query' => array(
        $is_feature,
    ),
    'tax_query' => array(
        $category,
    ),
    'orderby' => $order_by,
    'order' => $ordering,
);

$args = carspot_wpml_show_all_posts_callback($args);
$ads = new ads();
$html = '';
if ($layout_type == 'slider') {
    $html = $ads->carspot_get_ads_grid_slider($args, $s_title, 4);
} else {
    $results = new WP_Query($args);
    $layouts = array('list_1', 'list_2', 'list_3');
    if ($results->have_posts()) {
        $type = $layout_type;
        $col = 4;
        if (isset($no_title)) {
            $col = 4;
        }
        if (in_array($layout_type, $layouts)) {
            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-list.php";
        } else if ($layout_type == 'list') {
            $list_html = '';
            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                $list_html .= $ads->carspot_search_layout_list($pid);
            }
            $out = '<div class="posts-masonry">
                           <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <ul class="list-unstyled">
							  		' . $list_html . '
							  </ul>
                           </div>
                        </div>
                        <div class="clearfix"></div>';
        } else if ($layout_type == 'list_4') {
            $list_html = '';
            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                $list_html .= $ads->carspot_search_layout_list_4($pid);
            }
            $out = '<div class="posts-masonry">
                           <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <div class="row">
								<div class="trending-ads">
							  		' . $list_html . '
							  </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>';
        } else {
            $out = '';
            if ($layout_type == 'grid_1') {
                $out .= '<div class="grid-style-2">';
            }
            if ($layout_type == 'grid_5') {
                $out .= '<div class="grid-style-1">';
            }
            if ($layout_type == 'grid_6') {
                $out .= '<div class="grid-style-2 grid-style-3">';
            }
            if ($layout_type == 'grid_7') {
                $out .= '<div class="grids-style-4">';
            }
            $c = 6;
            if (isset($col)) {
                $c = $col;
            }
            $out .= '<div class="posts-masonry ads-for-home">';
            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                $ads = new ads();
                $option = $layout_type;
                $function = "carspot_search_layout_$option";
                $out .= $ads->$function($pid, $c);
            }
            $out .= '</div>';
            if ($layout_type == 'grid_1') {
                $out .= '</div>';
            }
            if ($layout_type == 'grid_5') {
                $out .= '</div>';
            }
            if ($layout_type == 'grid_6') {
                $out .= '</div>';
            }
            if ($layout_type == 'grid_7') {
                $out .= '</div>';
            }
        }
        wp_reset_postdata();
        $heading = '';
        if ($s_title != "") {
            $heading = '<div class="heading-panel">
                              <div class="col-xs-12 col-md-12 col-sm-12">
                                 <h3 class="main-title text-left">
                                   ' . $s_title . '
                                 </h3>
                              </div>
                           </div>';
        }

        $html = '
                           ' . $heading . '
                              <div class="col-md-12 col-xs-12 col-sm-12">
							  	<div class="row"> ' . $out . ' </div>
							  </div>';
    }
}