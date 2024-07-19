<?php
global $carspot_theme;
$pid = get_the_ID();
if ($carspot_theme['Related_ads_on']) {
    $categories = array();
    if ($carspot_theme['related_parent_or_child'] == true) {
        $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
        if (is_array($post_categories) && $post_categories != '') {
            foreach ($post_categories as $c) {
                $cat_terms = get_term($c);
                if ($cat_terms->parent != 0) {
                    $categories[] = $cat_terms->term_id;
                }
            }
        }
    } else {
        $cats = wp_get_post_terms($pid, 'ad_cats', array('parent' => 0, 'fields' => 'all')); // wp_get_post_terms($pid, 'ad_cats');
        foreach ($cats as $cat) {
            $categories[] = $cat->term_id;
        }
    }

    $args = array(
        'post_type' => 'ad_post',
        'posts_per_page' => $carspot_theme['max_ads'],
        'order' => 'DESC',
        'post__not_in' => array($pid),
        'tax_query' => array(
            array(
                'taxonomy' => 'ad_cats',
                'field' => 'id',
                'terms' => $categories,
                'operator' => 'IN'
    )));
    $ads = new ads();
    if ($carspot_theme['related_ad_style'] == '1') {
        echo ( $ads->carspot_get_ads_grid_slider($args, $carspot_theme['sb_related_ads_title']) );
    } else {
        echo ( $ads->carspot_get_ads_list_style($args, $carspot_theme['sb_related_ads_title']) );
    }
}
?>
