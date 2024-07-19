<?php
if (in_array('carspot_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    $carspot_package_type = get_option('carspot_theme');
    $carspot_package_type_value = (isset($carspot_package_type['carspot_package_type']) && $carspot_package_type['carspot_package_type'] != "") ? $carspot_package_type['carspot_package_type'] : '';
  
    if (class_exists('Redux')) {
        Redux::getOption('carspot_theme', 'carspot_package_type');
    }
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/icons/icons.php';
    /* ------------------------------------------------ */
    /* Common Shortcode */
    /* ------------------------------------------------ */
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/short_codes_functions.php';
    
if (class_exists('Redux') && $carspot_package_type_value != "" && $carspot_package_type_value == 'category_based') {
    
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/woo_functions.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/category_based_functions.php';
        
    } else {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/woo_packages_based.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/packages.php';
        }
    }
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/ads.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/packages.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/authentication.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/profile.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/ad_post.php';
    
    

    
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/sign_up.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/sign_in.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/profile.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ad_post.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads_google_map.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads-slider.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_simple.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_modern.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_fancy.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_fancy.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/blog.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/why_chose.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/apps.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/apps_classic.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/process_cycle.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/fun_facts.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/text_block.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/faq.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/contact_us.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/advertisement_720-90.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_3.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_modern.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_simple.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/testimonials.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/expert_reviews.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/reviews.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/clients_slider.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/car_inspection.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/buy_sell.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/about_us.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/about_us_simple.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/about_us_fancy.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_classic.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/testimonials_2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_creative.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_tabs.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cars_images.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_bar_minimal.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/buy_sale_hero.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/compare_posts.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads_by_location.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/call_to_action.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/call_to_action2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/our_team.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/quote.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_classic.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/revolution-slider/index.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_tabs_classified.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_make_models.php';
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/shop_classic.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/shop_slider.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/shop_gallery.php';
    }
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_side_form.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_side_form_2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/services_with_facts.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/call_to_action3.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads_by_make.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_modern_2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/car_inspection2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/packages_2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ad_inspect.php';

    /* new shortcodes 23-9-2021 */
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/featured-offer.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/ads-banner.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/used_cars.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/compare_posts2.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/top_car_categories.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/city-carType-recentAds.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/search-hero.php';
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/new-shortcodes/search-hero-form.php';
}