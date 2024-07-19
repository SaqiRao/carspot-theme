<?php
get_template_part('template-parts/layouts/html', 'head');
global $carspot_theme;
?>
    <div class="sb-top-bar_notification">
        <a href="javascript:void(0)">
            <?php echo esc_html__('For a better experience please change your browser to CHROME, FIREFOX, OPERA or Internet Explorer.', 'carspot'); ?>
        </a>
    </div>
<?php

if (is_page_template('page-profile.php')) {

} else {
    if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'black') {
        get_template_part('template-parts/layouts/header', '2');
    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'shop') {
        get_template_part('template-parts/layouts/header', 'shop');
    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'services') {
        get_template_part('template-parts/layouts/header', 'services');
    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent') {
        get_template_part('template-parts/layouts/header', 'transparent');
    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent2') {
        get_template_part('template-parts/layouts/header', 'transparent-with-searchbar');
    } else if(isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'new'){
        get_template_part('template-parts/layouts/header', 'new');
    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'elementorProHeader' && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        elementor_theme_do_location('header');
    } else {
        get_template_part('template-parts/layouts/header', '1');
    }
}


if (in_array('carspot_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (is_page('user-dashboard')) {

    } else if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
        if (is_singular('ad_post')) {
            if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' && $carspot_theme['single_ad_style'] != '2' || $carspot_theme['sb_header'] == 'transparent2') {
                if (isset($carspot_theme['single_ad_style']) && $carspot_theme['single_ad_style'] == 2) {
                } else {
                    get_template_part('template-parts/layouts/bread-crumb-single', 'transparenty');
                }
            } else {
            }
        } else if (basename(get_page_template()) != 'page-home.php') {
            get_template_part('template-parts/layouts/bread-crumb', 'transparenty');
        } else {

        }
    } else {
        global $post;
        if (is_404() || is_search()) {
            get_template_part('template-parts/layouts/bread', 'crumb-search');
        } else if (is_author()) {
            get_template_part('template-parts/layouts/bread', 'crumb');
        } else {
            if (is_singular('reviews')) {
                get_template_part('template-parts/layouts/bread', 'reviews');
            } else if (is_singular('ad_post')) {
                if (isset($carspot_theme['single_ad_style']) && $carspot_theme['single_ad_style'] == 2) {

                } else if (isset($carspot_theme['single_ad_style']) && $carspot_theme['single_ad_style'] == 3) {
                    get_template_part('template-parts/layouts/bread-new', 'crumb');
                } else {
                    get_template_part('template-parts/layouts/single-ad', 'bread');
                }
            } else if (basename(get_page_template()) == 'page-search.php') {
                if (isset($carspot_theme['search_page_layout']) && $carspot_theme['search_page_layout'] == 'search_layout_one') {
                    get_template_part('template-parts/layouts/bread', 'crumb');
                }
            } else {
                if (basename(get_page_template()) != 'page-home.php') {
                    get_template_part('template-parts/layouts/bread', 'crumb');
                }
            }
        }
    }
} else {
    get_template_part('template-parts/layouts/bread', 'crumb-before');
}