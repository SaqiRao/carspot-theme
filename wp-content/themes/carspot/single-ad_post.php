<?php
get_header();
global $carspot_theme;
$time = get_post_meta(get_the_ID(), '_ad_time_key', true);
//echo $time;
/* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */
wp_enqueue_script('carspot-search');
if (have_posts()) {
    $my_url = '';
    $my_url = carspot_get_current_url();
    while (have_posts()) {
        the_post();
        $aid = get_the_ID();
        //blocking ad expirty on demo servers
        if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {

        } else {
            /* if ad is not feature then */
            if (get_post_meta($aid, '_carspot_is_feature', true) != '1') {
                cs_ads_check_expiry($aid);
            }
        }
        // Make expired to featured ad
        if (get_post_meta($aid, '_carspot_is_feature', true) == '1' && $carspot_theme['featured_expiry'] != '-1') {
            if (isset($carspot_theme['featured_expiry']) && $carspot_theme['featured_expiry'] != '-1') {
                $now = time(); // or your date as well
                $featured_date = strtotime(get_post_meta($aid, '_carspot_is_feature_date', true));
                $featured_days = carspot_days_diff($now, $featured_date);
                $expiry_days = $carspot_theme['featured_expiry'];
                if ($featured_days > $expiry_days) {
                    update_post_meta($aid, '_carspot_is_feature', 0);
                }
            }
        }
        carspot_setPostViews($aid);
        if ($carspot_theme['single_ad_style'] == "1") {
            get_template_part('template-parts/layouts/ad_style/style', '1');
        } else if($carspot_theme['single_ad_style'] == "2") {
            get_template_part('template-parts/layouts/ad_style/style', '2');
        }  else {
            get_template_part('template-parts/layouts/ad_style/style', '3');
        }
    }
} else {
    get_template_part('template-parts/content', 'none');
}
get_footer();
