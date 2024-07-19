<?php
if (!function_exists('carspot_elementor_animations')) {

    function carspot_elementor_animations()
    {
        $animations = array('bounce' => 'bounce', 'flash' => 'flash', 'pulse' => 'pulse', 'rubberBand' => 'rubberBand', 'shake' => 'shake', 'swing' => 'swing', 'tada' => 'tada', 'wobble' => 'wobble', 'jello' => 'jello', 'bounceIn' => 'bounceIn', 'bounceInDown' => 'bounceInDown', 'bounceInUp' => 'bounceInUp', 'bounceOut' => 'bounceOut', 'bounceOutDown' => 'bounceOutDown', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'bounceOutUp' => 'bounceOutUp', 'fadeIn' => 'fadeIn', 'fadeInDown' => 'fadeInDown', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeft' => 'fadeInLeft', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeInUp' => 'fadeInUp', 'fadeInUpBig' => 'fadeInUpBig', 'fadeOut' => 'fadeOut', 'fadeOutDown' => 'fadeOutDown', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutLeftBig' => 'fadeOutLeftBig', 'fadeOutRightBig' => 'fadeOutRightBig', 'fadeOutUp' => 'fadeOutUp', 'fadeOutUpBig' => 'fadeOutUpBig', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipInY' => 'flipInY', 'flipOutX' => 'flipOutX', 'flipOutY' => 'flipOutY', 'fadeOutDown' => 'fadeOutDown', 'lightSpeedIn' => 'lightSpeedIn', 'lightSpeedOut' => 'lightSpeedOut', 'rotateIn' => 'rotateIn', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInDownRight' => 'rotateInDownRight', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateOut' => 'rotateOut', 'rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutDownRight' => 'rotateOutDownRight', 'rotateOutUpLeft' => 'rotateOutUpLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'slideInUp' => 'slideInUp', 'slideInDown' => 'slideInDown', 'slideInLeft' => 'slideInLeft', 'slideInRight' => 'slideInRight', 'slideOutUp' => 'slideOutUp', 'slideOutDown' => 'slideOutDown', 'slideOutLeft' => 'slideOutLeft', 'slideOutRight' => 'slideOutRight', 'zoomIn' => 'zoomIn', 'zoomInDown' => 'zoomInDown', 'zoomInLeft' => 'zoomInLeft', 'zoomInRight' => 'zoomInRight', 'zoomInUp' => 'zoomInUp', 'zoomOut' => 'zoomOut', 'zoomOutDown' => 'zoomOutDown', 'zoomOutLeft' => 'zoomOutLeft', 'zoomOutUp' => 'zoomOutUp', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut'
        );
        return $animations;
    }

}

/*
 * Get parent Category
 */
if (!function_exists('cs_elementor_get_parents_cats')) {

    function cs_elementor_get_parents_cats($taxonomy)
    {
        $cats = array();
        if (taxonomy_exists($taxonomy)) {
            $carspot_cats = carspot_get_cats($taxonomy, 0);
            $carspot_cats = apply_filters('carspot_wpml_show_all_posts', $carspot_cats);//get all parent categories
            if (count($carspot_cats) > 0 && $carspot_cats != "") {
                foreach ($carspot_cats as $cat) {
                    $cats[$cat->slug] = $cat->name . ' (' . $cat->count . ')';
                }
            }
        }
        return $cats;
    }

}

/* get child and parent categories */
if (!function_exists('cs_elementor_location_shortcode')) {

    function cs_elementor_location_shortcode($term_type = '')
    {
        $terms = get_terms($term_type, array('hide_empty' => false));
        $terms = apply_filters('carspot_wpml_show_all_posts', $terms);//get all language taxonomies
        $result = array();
        if (count((array)$terms) > 0) {
            foreach ($terms as $term) {
                $result[$term->slug] = $term->name . ' (' . $term->count . ')';
            }
        }
        return $result;
    }

}

/*
 *  Button with link
 */
if (!function_exists('cs_elementor_button_link')) {

    function cs_elementor_button_link($is_external = '', $nofollow = '', $btn_title = 'Button Link', $url = '', $class_css = '', $i_class = '')
    {
        $i_class_html = '';
        $target = $is_external ? ' target="_blank"' : '';
        $nofollow = $nofollow ? ' rel="nofollow"' : '';
        if ($i_class != '') {
            $i_class_html = '<i class="' . $i_class . '"></i>';
        }
        return '<a href="' . esc_url($url) . '" class="' . $class_css . '"' . $target . $nofollow . '>' . esc_html__($btn_title, 'cs-elementor') . ' ' . $i_class_html . '</a>';
    }
}

/*
 * Comparison two cars
 */
if (!function_exists('comparison_data_shortcode')) {

    function comparison_data_shortcode($post_type = 'comparison')
    {
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'order' => 'DESC',
            'post_status' => 'publish',
            'post_type' => $post_type,
        ));
        $posts = carspot_wpml_show_all_posts_callback($posts);
        //$posts = apply_filters('carspot_wpml_show_all_posts',$posts);
        $result = array();
        foreach ($posts as $post) {
            $result[$post->ID] = $post->post_title;
        }
        return $result;
    }

}

if (!function_exists('elementor_carspot_returnImgSrc')) {

    function elementor_carspot_returnImgSrc($id, $size = 'full', $showHtml = false, $class = '', $alt = '')
    {
        global $carspot_theme;
        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                $img1 = wp_get_attachment_image_src($id, $size);
                if (wp_attachment_is_image($id)) {
                    $img = $img1[0];
                } else {
                    $img = esc_url($carspot_theme['default_related_image']['url']);
                }
            } else {
                $class = ($class != "") ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ($alt != "") ? 'alt="' . esc_attr($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }
}

/**
 * Getting packages from product
 */
if (!function_exists('carspot_elementor_get_packages')) {

    function carspot_elementor_get_packages()
    {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
            $products = array();
            $args = array(
                'post_type' => 'product',
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'carspot_packages_pricing'
                    ),
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'subscription'
                    ),
                ),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date'
            );
            $args = carspot_wpml_show_all_posts_callback($args);
            $packages = new WP_Query($args);
            if ($packages->have_posts()) {
                while ($packages->have_posts()) {
                    $packages->the_post();
                    $products[get_the_ID()] = get_the_title();
                }
            }
            return $products;
        }
    }

}

