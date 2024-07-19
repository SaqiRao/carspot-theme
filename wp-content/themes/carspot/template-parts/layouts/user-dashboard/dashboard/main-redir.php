<?php
global $carspot_theme;

if (isset($_GET['page-type']) && $_GET['page-type'] != "") {
    $page_type = $_GET['page-type'];
    if ($page_type == "dashboard") {
        get_template_part('template-parts/layouts/user-dashboard/dashboard/dashboard');
    }
    if ($page_type == "published-ads") {
        get_template_part('template-parts/layouts/user-dashboard/ads/published-ads');
    }
    if ($page_type == "expired-ads") {
        get_template_part('template-parts/layouts/user-dashboard/ads/expired-ads');
    }
    if ($page_type == "sold-ads") {
        get_template_part('template-parts/layouts/user-dashboard/ads/sold-ads');
    }
    if ($page_type == "fav-ads") {
        get_template_part('template-parts/layouts/user-dashboard/ads/fav-ads');
    }
    if ($page_type == "edit-profile") {
        get_template_part('template-parts/layouts/user-dashboard/my-profile/eidt-profile');
    }
    if ($page_type == "my_ratings") {
        if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting'] == true) {
            get_template_part('template-parts/layouts/user-dashboard/my-profile/profile-ratings');
        }
    }
    if ($page_type == "my-messages") {
        get_template_part('template-parts/layouts/user-dashboard/messages/my-messages');
    }
    if ($page_type == "pending-ads") {
        get_template_part('template-parts/layouts/user-dashboard/ads/pending-ads');
    }
} else {
    get_template_part('template-parts/layouts/user-dashboard/dashboard/dashboard');
}
?>