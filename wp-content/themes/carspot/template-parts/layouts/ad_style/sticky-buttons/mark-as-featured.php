<?php
global $carspot_theme;

$listing_id = get_the_ID();
$user_id = get_current_user_id();
if (get_current_user_id() != 0 && get_post_meta($listing_id, '_carspot_is_feature', true) == '0' && get_post_meta($listing_id, '_carspot_ad_status_', true) == 'active') {
    if (get_post_field('post_author', $listing_id) == $user_id) {
        if (get_user_meta($user_id, '_carspot_featured_ads', true) != 0) {
            if (get_user_meta($user_id, '_carspot_expire_ads', true) != '-1') {
                if (get_user_meta($user_id, '_carspot_expire_ads', true) < date('Y-m-d')) {
                    echo "<div class='sticky-button-feature'>
        				<a href='" . get_the_permalink($carspot_theme['sb_packages_page']) . "'>" . esc_html__('Package Expired', 'carspot') . "</a>
    				</div>";
                } else {
                    echo carspot_mark_listing_featured($listing_id);
                }
            } else {
                echo carspot_mark_listing_featured($listing_id);
            }
        } else {
            echo "<div class='sticky-button-feature'>
        		<a href='" . get_the_permalink($carspot_theme['sb_packages_page']) . "'>" . esc_html__('Buy Package', 'carspot') . "</a>
    		</div>";
        }
    }
}