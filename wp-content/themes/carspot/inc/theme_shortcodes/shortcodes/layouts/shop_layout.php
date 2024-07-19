<?php
extract(shortcode_atts(array(
    'cats' => '',
    'ad_order' => '',
    'no_of_ads' => '',
    'main_link' => '',
    'shop_type' => '',
), $atts));
$cats = array();
$rows = vc_param_group_parse_atts($atts['cats']);
$is_all = false;
$html = '';
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

$category = '';
if (count((array)$cats) > 0) {
    $category = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $cats,
        ),
    );
}

$ordering = 'DESC';
$order_by = 'ID';
if ($ad_order == 'asc') {
    $ordering = 'ASC';
} else if ($ad_order == 'desc') {
    $ordering = 'DESC';
} else if ($ad_order == 'rand') {
    $order_by = 'rand';
}
$args = array(
    'post_type' => 'product',
    'posts_per_page' => $no_of_ads,
    'tax_query' => array(
        $category,
        array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => 'carspot_packages_pricing',
            'operator' => 'NOT IN'
        ),
        array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => 'carspot_category_pricing',
            'operator' => 'NOT IN'
        ),
    ),
    'orderby' => $order_by,
    'order' => $ordering,
);
$args = carspot_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);
if (count((array)$results) > 0) {
    $counter = 0;
    while ($results->have_posts()) {
        $results->the_post();
        $product = wc_get_product(get_the_ID());
        if ($product->get_type() == 'carspot_category_pricing')
            continue;
        $img = $product->get_image_id();
        $photo = wp_get_attachment_image_src($img, 'medium');
        $final_img = '';
        if ($photo[0] != "") {
            $final_img = '<img class="img-responsive" alt="' . get_the_title(get_the_ID()) . '" src="' . esc_url($photo[0]) . '">';
        } else {
            $final_img = '<img class="img-responsive custom_holder" alt="' . get_the_title(get_the_ID()) . '" src="' . wc_placeholder_img_src() . '">';
        }
        // Start Ratiing
        $ratting = $product->get_average_rating();
        $ratting_html = '';
        for ($star = 1; $star <= 5; $star++) {
            $is_filled = '';
            if ($star <= $ratting) {
                $is_filled = 'filled';
            }
            $ratting_html .= '<i class="fa fa-star-o ' . esc_html($is_filled) . '"></i>';
        }
        // Price
        $pricing = '';
        if ($product->get_type() != 'grouped') {
            if ($product->get_type() == 'variable') {
                $pricing = wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
                $pricing .= '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
            } else {
                $pricing = wc_price($product->get_sale_price());
            }
        }
        $reviews = '';
        $reviews = $product->get_review_count() . " " . esc_html__('Reviews', 'carspot');


        $html .= '<div class="col-md-3 col-sm-6 col-xs-12 ">
                     <div class="shop-grid">
                        <div class="shop-product"> 
						' . $final_img . '
                        <div class="shop-product-description">
                           <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                           <div class="rating-stars">' . $ratting_html . '
						   <a href="javascript:void(0)">(' . esc_html($reviews) . ')</a>
						   </div>
						   		<span>' . $pricing . '</span>
						   </div>

                     		</div>
					 </div>
					 </div>';
        if (++$counter % 4 == 0) {
            $html .= '<div class="clearfix"></div>';
        }
    }
    wp_reset_postdata();
}
?>