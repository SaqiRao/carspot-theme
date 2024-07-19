<?php
/**
 * Plugin Name: Carspot Framework
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: This plugin is essential for the proper theme funcationality.
 * Version: 2.3.0
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: redux-framework
 */
$my_theme = wp_get_theme();
$my_theme->get('Name');
if ($my_theme->get('Name') != 'carspot' && $my_theme->get('Name') != 'carspot child')
    return;
define('SB_PLUGIN_FRAMEWORK_PATH', plugin_dir_path(__FILE__));
define('THEMEPATH', get_template_directory_uri());
define('SB_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SB_THEMEURL_PLUGIN', get_template_directory_uri() . '/');
define('SB_IMAGES_PLUGIN', SB_THEMEURL_PLUGIN . 'images/');
define('SB_CSS_PLUGIN', SB_THEMEURL_PLUGIN . 'css/');
/* For Redux Framework */
require SB_PLUGIN_FRAMEWORK_PATH . '/admin-init.php';
/* For Add to Cart */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (class_exists('Redux')) {
        $get_optz = get_option('carspot_theme');
        if (isset($get_optz['carspot_package_type']) && $get_optz['carspot_package_type'] == 'category_based') {
            require SB_PLUGIN_PATH . 'cart/cart-js.php';
        } else {
            require SB_PLUGIN_PATH . 'cart/packages_cart-js.php';
        }
    }
}
/* For Contact us */
require SB_PLUGIN_PATH . 'js/bg.php';
/* Category Templates */
require SB_PLUGIN_PATH . 'ad_post/custom-category-templates.php';
require SB_PLUGIN_FRAMEWORK_PATH . '/gecka-terms-ordering/gecka-terms-ordering.php';
/* For Metaboxes */
require SB_PLUGIN_PATH . 'ad_post/index.php';
require SB_PLUGIN_PATH . 'cpt/index.php';
require SB_PLUGIN_PATH . 'cpt/inspection.php';
/* class add metabox for backend/admin  */
include SB_PLUGIN_PATH . 'cpt/class_adds_post_metabox.php';
require SB_PLUGIN_PATH . 'cpt/reviews.php';
require SB_PLUGIN_PATH . 'cpt/comparison.php';
/* For Metaboxes  User profile */
require SB_PLUGIN_PATH . 'user_profile/index.php';
require SB_PLUGIN_PATH . 'cpt/metaboxes/inspection.php';
/* Theme functions */
require SB_PLUGIN_PATH . 'functions.php';
/* admin side ajax-calls */
include SB_PLUGIN_PATH . 'admin/ajax-calls.php';
function carspots_framework_get_url($path = '')
{
    return plugin_dir_url(__FILE__) . $path;
}

add_action('admin_enqueue_scripts', 'carspot_framework_scripts');

function carspot_framework_scripts()
{
    wp_enqueue_style('tagsinput', THEMEPATH . '/css/jquery.tagsinput.min.css');
    wp_enqueue_style('minimal', THEMEPATH . '/skins/minimal/minimal.css');
    if (isset($_GET['page']) && $_GET['page'] == 'carspot_theme_options') {

    } else {
        wp_enqueue_style('arspot-select2', THEMEPATH . '/css/select2.min.css');
    }
    wp_enqueue_style('date-picker', THEMEPATH . '/css/datepicker.min.css');

    wp_register_script('ichecks', THEMEPATH . '/js/icheck.min.js', false, false, true);
    wp_register_script('selects-2', THEMEPATH . '/js/select2.min.js', false, false, true);
    wp_register_script('tagsinputs', THEMEPATH . '/js/jquery.tagsinput.min.js', false, false, false);
    wp_register_script('date-picker', THEMEPATH . '/js/datepicker.min.js', false, false, false);
    wp_enqueue_script('ichecks');
    wp_enqueue_script('selects-2');
    wp_enqueue_script('date-picker');
    /* Map */
    $mapType = carspot_mapType();
    if ($mapType == 'leafletjs_map') {
        /* Open Street Map In The API */
        if (!is_rtl()) {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.css');
        } else {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-rtl.css');
        }
        wp_enqueue_style('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.css');
        wp_register_script('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.js', false, false, false);
        wp_register_script('leaflet-markercluster', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.markercluster.js', false, false, false);
        wp_register_script('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.js', false, false, false);
        wp_enqueue_script('leaflet');
        wp_enqueue_script('leaflet-markercluster');
        wp_enqueue_script('leaflet-search');
    } else if ($mapType == 'no_map') {
        /* No Mapp In The Theme */
    } else {
        if (isset($carspot_theme['gmap_api_key']) && $carspot_theme['gmap_api_key'] != "") {
            $map_lang = 'en';
            if (isset($downtown_options['carspot_gmap_lang']) && $downtown_options['carspot_gmap_lang'] != "") {
                $map_lang = $downtown_options['carspot_gmap_lang'];
            }
            wp_enqueue_script('google-map', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&language=' . $map_lang, false, false, true);
        }
    }
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_style('sb-frm-plugin-css', plugin_dir_url(__FILE__) . 'css/plugin.css');
    wp_register_script('sb-frm-plugins-js', plugin_dir_url(__FILE__) . 'js/plugin.js', false, false, true);
    wp_enqueue_script('sb-frm-plugins-js');
    /* localize for ajax calls */
    wp_localize_script('sb-frm-plugins-js', 'carspot_ajax_url', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'plugin_url' => carspots_framework_get_url(),
            'ads_img_title' => esc_html__('Choose Ads Images', 'redux-framework'),
            'ads_img_upload_btn' => esc_html__('Add Images', 'redux-framework'),
            'ads_img_upload_btn' => esc_html__('Are You Sure', 'redux-framework'),
            'ad_review_logo_title' => __('Choose Logo', 'redux-framework'),
            'ad_review_logo_upload_btn' => __('Add Logo', 'redux-framework'),
            'ad_review_logo_delete_btn' => __('Are you sure', 'redux-framework'),
            'ad_pdf_brochure_title' => __('Choose pdf brochure', 'redux-framework'),
            'ad_pdf_brochure_upload_btn' => __('Add pdf brochure', 'redux-framework'),
            'ad_pdf_brochure_delete_btn' => __('Are you sure to delete', 'redux-framework'),
            'ad_video_delete_btn' => __('Are you sure to delete', 'redux-framework'),
            'Sunday' => __('Sunday', 'redux-framework'),
            'Monday' => __('Monday', 'redux-framework'),
            'Tuesday' => __('Tuesday', 'redux-framework'),
            'Wednesday' => __('Wednesday', 'redux-framework'),
            'Thursday' => __('Thursday', 'redux-framework'),
            'Friday' => __('Friday', 'redux-framework'),
            'Saturday' => __('Saturday', 'redux-framework'),
            'Sun' => __('Sun', 'redux-framework'),
            'Mon' => __('Mon', 'redux-framework'),
            'Tue' => __('Tue', 'redux-framework'),
            'Wed' => __('Wed', 'redux-framework'),
            'Thu' => __('Thu', 'redux-framework'),
            'Fri' => __('Fri', 'redux-framework'),
            'Sat' => __('Sat', 'redux-framework'),
            'Su' => __('Su', 'redux-framework'),
            'Mo' => __('Mo', 'redux-framework'),
            'Tu' => __('Tu', 'redux-framework'),
            'We' => __('We', 'redux-framework'),
            'Th' => __('Th', 'redux-framework'),
            'Fr' => __('Fr', 'redux-framework'),
            'Sa' => __('Sa', 'redux-framework'),
            'January' => __('January', 'redux-framework'),
            'February' => __('February', 'redux-framework'),
            'March' => __('March', 'redux-framework'),
            'April' => __('April', 'redux-framework'),
            'May' => __('May', 'redux-framework'),
            'June' => __('June', 'redux-framework'),
            'July' => __('July', 'redux-framework'),
            'August' => __('August', 'redux-framework'),
            'September' => __('September', 'redux-framework'),
            'October' => __('October', 'redux-framework'),
            'November' => __('November', 'redux-framework'),
            'December' => __('December', 'redux-framework'),
            'Jan' => __('Jan', 'redux-framework'),
            'Feb' => __('Feb', 'redux-framework'),
            'Mar' => __('Mar', 'redux-framework'),
            'Apr' => __('Apr', 'redux-framework'),
            'May' => __('May', 'redux-framework'),
            'Jun' => __('Jun', 'redux-framework'),
            'Jul' => __('July', 'redux-framework'),
            'Aug' => __('Aug', 'redux-framework'),
            'Sep' => __('Sep', 'redux-framework'),
            'Oct' => __('Oct', 'redux-framework'),
            'Nov' => __('Nov', 'redux-framework'),
            'Dec' => __('Dec', 'redux-framework'),
            'Today' => __('Today', 'redux-framework'),
            'Clear' => __('Clear', 'redux-framework'),
            'dateFormat' => __('dateFormat', 'redux-framework'),
            'timeFormat' => __('timeFormat', 'redux-framework'),
        )
    );
}
add_action('wp_enqueue_scripts', 'sb_theme_scripts');

function sb_theme_scripts()
{
    // wp_enqueue_script('jquery');
    wp_register_script('carspot-theme-js', plugin_dir_url(__FILE__) . 'js/theme.js', false, false, true);
    wp_register_script('carspot-jquery-ui', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', false, false, true);
    wp_enqueue_script('carspot-theme-js');
}

add_action('wp', 'remove_admin_bar');

function remove_admin_bar()
{
    global $carspot_theme;
    if ($carspot_theme['admin_bar']) {
        if (is_user_logged_in()) {
            show_admin_bar(true);
        }
    } else {
        show_admin_bar(false);
    }
}

// Load text domain
add_action('plugins_loaded', 'carspot_framework_load_plugin_textdomain');

function carspot_framework_load_plugin_textdomain()
{
    load_plugin_textdomain('redux-framework', FALSE, basename(dirname(__FILE__)) . '/languages/');
}

if (get_option('carspot_theme') == "") {

    $sb_option_name = 'carspot_theme';
    /* Header Options */
    Redux::setOption($sb_option_name, 'sb_site_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_site_logo_light', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_enable_top_bar', '0');
    Redux::setOption($sb_option_name, 'for_email', array('rane_field_1' => 'Main Title', 'rane_field_2' => 'Email Adress'));
    Redux::setOption($sb_option_name, 'for_call', array('rane_field_1' => 'Main Title', 'rane_field_2' => 'Contact No'));
    Redux::setOption($sb_option_name, 'for_location', array('rane_field_1' => 'Main Title', 'rane_field_2' => 'For Location'));
    Redux::setOption($sb_option_name, 'admin_bar', '1');
    Redux::setOption($sb_option_name, 'theme_color', 'defualt');
    Redux::setOption($sb_option_name, 'sb_header', 'white');
    Redux::setOption($sb_option_name, 'sb_sticky_header', '0');
    Redux::setOption($sb_option_name, 'scroll_to_top', '1');
    Redux::setOption($sb_option_name, 'sell_button', '1');
    Redux::setOption($sb_option_name, 'sb_user_dp', array('url' => SB_THEMEURL_PLUGIN . 'images/users/1.jpg'));
    Redux::setOption($sb_option_name, 'sb_top_bar', '1');
    Redux::setOption($sb_option_name, 'top_bar_color', 'colored');
    Redux::setOption($sb_option_name, 'top_bar_type', 'classified');
    Redux::setOption($sb_option_name, 'sb_sign_in_page', array('6'));
    Redux::setOption($sb_option_name, 'sb_sign_up_page', array('10'));
    Redux::setOption($sb_option_name, 'sb_profile_page', array('15'));
    Redux::setOption($sb_option_name, 'sb_post_ad_page', array('17'));
    Redux::setOption($sb_option_name, 'sb_color_plate', '0');
    Redux::setOption($sb_option_name, 'sb_pre_loader', '1');
    Redux::setOption($sb_option_name, 'theme_loader_type', 'modern');
    Redux::setOption($sb_option_name, 'theme_loader_type_modern', array('url' => SB_THEMEURL_PLUGIN . 'images/sb-loader.gif'));
    Redux::setOption($sb_option_name, 'ad_in_menu', '1');
    Redux::setOption($sb_option_name, 'ad_button_type', 'post');
    Redux::setOption($sb_option_name, 'ad_button_title', 'Sell Your Car');
    Redux::setOption($sb_option_name, 'contact_in_menu', '1');
    Redux::setOption($sb_option_name, 'search_in_header', '1');
    Redux::setOption($sb_option_name, 'sb_contact_btn', array('call'));
    Redux::setOption($sb_option_name, 'contact_icon', 'flaticon-customer-service');
    Redux::setOption($sb_option_name, 'sb_contact_btn_text', 'Call Us Now');
    Redux::setOption($sb_option_name, 'sb_contact_btn_value', '111 222 333 444');
    Redux::setOption($sb_option_name, 'sb_admin_translate', '0');
    /* Social Media */
    Redux::setOption($sb_option_name, 'social_media', array('Facebook' => '#', 'Twitter' => '#', 'Linkedin' => '#', 'Google' => '#', 'YouTube' => '#', 'Vimeo' => '', 'Pinterest' => '', 'Tumblr' => '', 'Instagram' => '', 'Reddit' => '', 'Flickr' => '', 'StumbleUpon' => '', 'Delicious' => '', 'dribble' => '', 'behance' => '', 'DeviantART' => ''));
    /* Social Media Coming Soon */
    Redux::setOption($sb_option_name, 'social_media_soon', array('Facebook' => '#', 'Twitter' => '#', 'Linkedin' => '#', 'Google' => '#', 'YouTube' => '', 'Vimeo' => '', 'Pinterest' => '', 'Tumblr' => '', 'Instagram' => '', 'Reddit' => '', 'Flickr' => '', 'StumbleUpon' => '', 'Delicious' => '', 'dribble' => '', 'behance' => '', 'DeviantART' => '',));
    /* Footer Options */
    Redux::setOption($sb_option_name, 'footer_type', 'white');
    Redux::setOption($sb_option_name, 'footer_logo', array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'footer_text_under_logo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et dolor eget erat fringilla port.');
    Redux::setOption($sb_option_name, 'section_2_title', 'Follow Us');
    Redux::setOption($sb_option_name, 'section_3_title', 'Singup for Weekly Newsletter');
    Redux::setOption($sb_option_name, 'sb_footer_pages', array('2'));
    Redux::setOption($sb_option_name, 'section_4_title', 'Quick Links');
    Redux::setOption($sb_option_name, 'sb_footer_links', array('2'));
    Redux::setOption($sb_option_name, 'footer_android_app', '#');
    Redux::setOption($sb_option_name, 'footer_ios_app', '#');
    Redux::setOption($sb_option_name, 'section_3_text', 'We may send you information about related events, webinars, products and services which we believe.');
    Redux::setOption($sb_option_name, 'section_3_mc', '1');
    Redux::setOption($sb_option_name, 'mailchimp_footer_list_id', '');
    Redux::setOption($sb_option_name, 'sb_footer', 'Copyright 2017 &copy; Theme Created By <a href="https://themeforest.net/user/scriptsbundle/portfolio">ScriptsBundle</a> All Rights Reserved.');
    /* Reviews Settings */
    Redux::setOption($sb_option_name, 'review_sidebar', 'right');
    Redux::setOption($sb_option_name, 'default_related_image_review', array('url' => SB_THEMEURL_PLUGIN . 'images/no-pic.jpg'));
    Redux::setOption($sb_option_name, 'review_related_image_large', array('url' => SB_THEMEURL_PLUGIN . 'images/review-large.jpg'));
    /* Blog  */
    Redux::setOption($sb_option_name, 'sb_blog_page_title', 'Blog Posts');
    Redux::setOption($sb_option_name, 'sb_blog_single_title', 'Blog Details');
    Redux::setOption($sb_option_name, 'blog_sidebar', 'right');
    Redux::setOption($sb_option_name, 'enable_share_post', '0');
    /* Shop */
    Redux::setOption($sb_option_name, 'related_products', '1');
    Redux::setOption($sb_option_name, 'max_related_products', '5');
    Redux::setOption($sb_option_name, 'related_products_title', 'Related {color} Products {/color}');
    Redux::setOption($sb_option_name, 'show_cart_top', '1');
    Redux::setOption($sb_option_name, 'cart_float_text', 'Pay');
    Redux::setOption($sb_option_name, 'cart_float_animation', 'tada');
    /* Ad Post */
    Redux::setOption($sb_option_name, 'sb_location_allowed', '1');
    Redux::setOption($sb_option_name, 'communication_mode', 'both');
    Redux::setOption($sb_option_name, 'communication_icon_message', 'flaticon-mail-1');
    Redux::setOption($sb_option_name, 'communication_icon_phone', 'flaticon-smartphone');
    Redux::setOption($sb_option_name, 'sb_send_email_on_message', '1');
    Redux::setOption($sb_option_name, 'sb_send_email_on_ad_post', '1');
    Redux::setOption($sb_option_name, 'ad_post_email_value', get_option('admin_email'));
    Redux::setOption($sb_option_name, 'sb_currency', 'USD');
    Redux::setOption($sb_option_name, 'sb_price_direction', 'left');
    Redux::setOption($sb_option_name, 'sb_price_separator', ',');
    Redux::setOption($sb_option_name, 'sb_price_decimals', '0');
    Redux::setOption($sb_option_name, 'sb_price_decimals_separator', '.');
    Redux::setOption($sb_option_name, 'email_on_ad_approval', '1');
    Redux::setOption($sb_option_name, 'email_on_inspection_approval', '1');
    Redux::setOption($sb_option_name, 'sb_allow_ads', '1');
    Redux::setOption($sb_option_name, 'sb_free_ads_limit', '-1');
    Redux::setOption($sb_option_name, 'admin_allow_unlimited_ads', '1');
    Redux::setOption($sb_option_name, 'sb_allow_featured_ads', '1');
    Redux::setOption($sb_option_name, 'sb_featured_ads_limit', '1');
    Redux::setOption($sb_option_name, 'sb_package_validity', '-1');
    Redux::setOption($sb_option_name, 'sb_upload_limit', '5');
    Redux::setOption($sb_option_name, 'sb_upload_size', '819200-800kb');
    Redux::setOption($sb_option_name, 'sb_ad_approval', 'auto');
    Redux::setOption($sb_option_name, 'sb_update_approval', 'auto');
    /* post texnomies */
    Redux::setOption($sb_option_name, 'allow_tax_condition', '1');
    Redux::setOption($sb_option_name, 'allow_tax_warranty', '1');
    Redux::setOption($sb_option_name, 'allow_ad_years', '1');
    Redux::setOption($sb_option_name, 'allow_ad_body_types', '1');
    Redux::setOption($sb_option_name, 'allow_ad_transmissions', '1');
    Redux::setOption($sb_option_name, 'allow_ad_engine_capacities', '1');
    Redux::setOption($sb_option_name, 'allow_ad_engine_types', '1');
    Redux::setOption($sb_option_name, 'allow_ad_assembles', '1');
    Redux::setOption($sb_option_name, 'allow_ad_colors', '1');
    Redux::setOption($sb_option_name, 'allow_ad_insurance', '1');
    Redux::setOption($sb_option_name, 'allow_ad_features', '1');
    Redux::setOption($sb_option_name, 'allow_lat_lon', '1');
    Redux::setOption($sb_option_name, 'sb_default_lat', '40.7127837');
    Redux::setOption($sb_option_name, 'sb_default_long', '-74.00594130000002');
    Redux::setOption($sb_option_name, 'allow_price_type', '1');
    Redux::setOption($sb_option_name, 'sb_ad_update_notice', 'Hey, be careful you are updating this AD.');
    Redux::setOption($sb_option_name, 'bad_words_filter', '');
    Redux::setOption($sb_option_name, 'bad_words_replace', '');
    Redux::setOption($sb_option_name, 'ad_slider_type', '1');
    Redux::setOption($sb_option_name, 'style_ad_720_1', '');
    Redux::setOption($sb_option_name, 'style_ad_720_2', '');
    Redux::setOption($sb_option_name, 'style_ad_160_1', '');
    Redux::setOption($sb_option_name, 'style_ad_160_2', '');
    Redux::setOption($sb_option_name, 'report_options', 'Spam|Offensive|Duplicated|Fake');
    Redux::setOption($sb_option_name, 'featured_expiry', '7');
    Redux::setOption($sb_option_name, 'sb_packages_page', '');
    Redux::setOption($sb_option_name, 'report_limit', '10');
    Redux::setOption($sb_option_name, 'report_action', '1');
    Redux::setOption($sb_option_name, 'report_email', get_option('admin_email'));
    Redux::setOption($sb_option_name, 'Related_ads_on', '0');
    Redux::setOption($sb_option_name, 'share_ads_on', '1');
    Redux::setOption($sb_option_name, 'sb_related_ads_title', 'Similiar Ads');
    Redux::setOption($sb_option_name, 'related_ad_style', '1');
    Redux::setOption($sb_option_name, 'max_ads', '5');
    /* features */
    Redux::setOption($sb_option_name, 'car_key_features', '1');
    Redux::setOption($sb_option_name, 'car_key_icons_enginetype', 'flaticon-gas-station-1');
    Redux::setOption($sb_option_name, 'car_key_icons_mileage', 'flaticon-dashboard-1');
    Redux::setOption($sb_option_name, 'car_key_icons_engine_capacity', 'flaticon-tool');
    Redux::setOption($sb_option_name, 'car_key_icons_year', 'flaticon-calendar');
    Redux::setOption($sb_option_name, 'car_key_icons_transmission', 'flaticon-gearshift');
    Redux::setOption($sb_option_name, 'car_key_icons_body_type', 'flaticon-transport-1');
    Redux::setOption($sb_option_name, 'car_key_icons_color', 'flaticon-cogwheel-outline');
    Redux::setOption($sb_option_name, 'default_related_image', array('url' => SB_THEMEURL_PLUGIN . 'images/no-image.jpg'));
    Redux::setOption($sb_option_name, 'tips_title', 'Safety tips for deal');
    Redux::setOption($sb_option_name, 'tips_for_ad', '<ol><li>Use a safe location to meet seller</li><li>Avoid cash transactions</li><li>Beware of unrealistic offers</li></ol>');
    Redux::setOption($sb_option_name, 'sb_search_page', array('13'));
    Redux::setOption($sb_option_name, 'search_layout', 'grid_1');
    Redux::setOption($sb_option_name, 'cat_level_1', 'Select Make');
    Redux::setOption($sb_option_name, 'cat_level_2', 'Select Model');
    Redux::setOption($sb_option_name, 'cat_level_3', 'Select Version');
    Redux::setOption($sb_option_name, 'cat_level_4', 'Select 4th Level');
    Redux::setOption($sb_option_name, 'listing_features_grids', 'car');
    Redux::setOption($sb_option_name, 'sb_video_icon', '1');
    Redux::setOption($sb_option_name, 'video_icon', array('url' => SB_THEMEURL_PLUGIN . 'images/youtube-flat.png'));
    Redux::setOption($sb_option_name, 'ad_title_limt', '1');
    Redux::setOption($sb_option_name, 'grid_title_limit', '20');
    Redux::setOption($sb_option_name, 'cat_and_location', 'search');
    Redux::setOption($sb_option_name, 'feature_on_search', '0');
    Redux::setOption($sb_option_name, 'max_ads_feature', '5');
    Redux::setOption($sb_option_name, 'feature_ads_title', 'Featured Ads');
    Redux::setOption($sb_option_name, 'search_ad_720_1', '');
    Redux::setOption($sb_option_name, 'search_ad_720_2', '');
    /* User Settings */
    Redux::setOption($sb_option_name, 'sb_new_user_email_to_admin', '1');
    Redux::setOption($sb_option_name, 'sb_new_user_email_to_user', '1');
    Redux::setOption($sb_option_name, 'sb_user_phone_required', '1');
    Redux::setOption($sb_option_name, 'sb_enable_user_badge', '1');
    Redux::setOption($sb_option_name, 'sb_enable_user_ratting', '1');
    Redux::setOption($sb_option_name, 'email_to_user_on_rating', '1');
    /* Contact Info */
    Redux::setOption($sb_option_name, 'sb_timing', 'Mon - Sat: 09.00 - 19.00');
    Redux::setOption($sb_option_name, 'sb_phone', '+(789) 675 978');
    Redux::setOption($sb_option_name, 'sb_email', 'support@glixentech.com');
    Redux::setOption($sb_option_name, 'sb_address', 'Link Road, Lahore, Pakistan');
    Redux::setOption($sb_option_name, 'sb_fax', '(880) 777 4444');
    Redux::setOption($sb_option_name, 'sb_site_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    /* Comming Soon */
    Redux::setOption($sb_option_name, 'sb_comming_soon_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_comming_soon_mode', 0);
    Redux::setOption($sb_option_name, 'sb_comming_soon_date', '2017/06/28');
    Redux::setOption($sb_option_name, 'coming_soon_notify', '0');
    Redux::setOption($sb_option_name, 'mailchimp_notify_list_id', '');
    Redux::setOption($sb_option_name, 'sb_comming_soon_title', "Our website is under construction.");
    /* Woo Commerce */
    Redux::setOption($sb_option_name, 'shop_view', 'grid');
    Redux::setOption($sb_option_name, 'sb_shop_page_title', 'Shop');
    Redux::setOption($sb_option_name, 'sb_shop_single_title', 'Product Details');
    Redux::setOption($sb_option_name, 'enable_share', '1');
    Redux::setOption($sb_option_name, 'sb_woo_related_products', '1');
    Redux::setOption($sb_option_name, 'single_shop_view', 'without_sidebar');
    Redux::setOption($sb_option_name, 'sb_bread_crumb_enable_shop', '1');
    Redux::setOption($sb_option_name, 'sb_bread_crumb_shop', array('url' => SB_THEMEURL_PLUGIN . 'images/bredcrumb.jpg'));
    Redux::setOption($sb_option_name, 'sb_woo_related_products_title', 'Related Products');
    Redux::setOption($sb_option_name, 'sb_woo_related_products_description', 'You may like also.');
    /* API Settings */
    Redux::setOption($sb_option_name, 'google_api_key', '');
    Redux::setOption($sb_option_name, 'google_api_secret', '');
    Redux::setOption($sb_option_name, 'gmap_api_key', 'AIzaSyB_La6qmewwbVnTZu5mn3tVrtu6oMaSXaI');
    Redux::setOption($sb_option_name, 'mailchimp_api_key', '');
    Redux::setOption($sb_option_name, 'fb_api_key', '');
    Redux::setOption($sb_option_name, 'gmail_api_key', '');
    Redux::setOption($sb_option_name, 'hotmail_api_key', '');
    Redux::setOption($sb_option_name, 'linked_api_key', '');
    Redux::setOption($sb_option_name, 'redirect_uri', '');
    Redux::setOption($sb_option_name, 'carspot_ad_order_approved', '1');
    Redux::setOption($sb_option_name, 'sb_post_ad_page', array('17'));
    /* Notification */
    Redux::setOption($sb_option_name, 'sb_notification_page', array('935'));
    /* Free ADs */
    Redux::setOption($sb_option_name, 'sb_allow_ads', '1');
    Redux::setOption($sb_option_name, 'sb_free_ads_limit', '5');
    Redux::setOption($sb_option_name, 'sb_allow_featured_ads', '1');
    Redux::setOption($sb_option_name, 'sb_featured_ads_limit', '3');
    Redux::setOption($sb_option_name, 'sb_allow_bump_ads', '1');
    Redux::setOption($sb_option_name, 'sb_bump_ads_limit', '2');
    Redux::setOption($sb_option_name, 'sb_allow_free_bump_up', '1');

    Redux::setOption($sb_option_name, 'carspot_package_type', 'package_based');
}
/* On Plugin Activation. */
register_activation_hook(__FILE__, 'carspot_framework_activate');

function carspot_framework_activate()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'carspot_locations';
    $url = esc_url("http://authenticate.scriptsbundle.com/carspot/activated.php") . "?purchase_code=" . get_option('_sb_purchase_code');
    $res = file_get_contents($url);
}

register_uninstall_hook(__FILE__, 'carspot_framework_uninstall');

// And here goes the uninstallation function:
function carspot_framework_uninstall()
{
    delete_option('_sb_purchase_code');
}

// Keep admin section in english
$get_val = get_option('carspot_theme');
if (isset($get_val['sb_admin_translate']) && $get_val['sb_admin_translate'] == 0) {
    add_filter('locale', 'sb_admin_in_english_locale');
}

// Keep admin section in english
function sb_admin_in_english_locale($locale)
{
    if (sb_admin_in_english_should_use_english()) {
        $locale = 'en_US';
    }
    return $locale;
}

function sb_admin_in_english_should_use_english()
{
    // frontend AJAX calls are mistakend for admin calls, because the endpoint is wp-admin/admin-ajax.php
    return sb_admin_in_english_is_admin() && !sb_admin_in_english_is_frontend_ajax();
}

function sb_admin_in_english_is_admin()
{
    return
        is_admin() || sb_admin_in_english_is_tiny_mce() || sb_admin_in_english_is_login_page();
}

function sb_admin_in_english_is_frontend_ajax()
{
    return defined('DOING_AJAX') && DOING_AJAX && false === strpos(wp_get_referer(), '/wp-admin/');
}

function sb_admin_in_english_is_tiny_mce()
{
    return false !== strpos($_SERVER['REQUEST_URI'], '/wp-includes/js/tinymce/');
}

function sb_admin_in_english_is_login_page()
{
    return false !== strpos($_SERVER['REQUEST_URI'], '/wp-login.php');
}

add_action('add_meta_boxes', 'carspot_framework_ad_meta_box');

function carspot_framework_ad_meta_box()
{
    add_meta_box('carspot_framework_themes_metaboxes_for_ad', __('Assign AD', 'redux-framework'), 'sb_render_meta_for_ads', 'ad_post', 'normal', 'high');
}

function sb_render_meta_for_ads($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    ?>
    <div class="margin_top">
        <p><?php echo __('Select Author', 'redux-framework'); ?></p>
        <select name="sb_change_author" style="width:100%; height:40px;">
            <?php
            $users = get_users(array('fields' => array('display_name', 'ID', 'user_email')));
            if (isset($users) && is_array($users)) {
                foreach ($users as $user) {
                    echo '<span>' . esc_html($user->display_name) . '</span>';
                    ?>
                    <option value="<?php echo esc_attr($user->ID); ?>" <?php if ($post->post_author == $user->ID) echo 'selected'; ?>>
                        <?php echo esc_html($user->display_name) . " - " . esc_html($user->user_email); ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_for_ad');

function sb_themes_meta_save_for_ad($post_id)
{

    if (isset($_POST['post_type']) && $_POST['post_type'] == 'ad_post') {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_ad'))
            return;

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post'))
            return;

        // Make sure your data is set before trying to save it
        if (isset($_POST['sb_change_author'])) {
            $my_post = array(
                'ID' => $post_id,
                'post_author' => $_POST['sb_change_author'],
            );
            // unhook this function so it doesn't loop infinitely
            remove_action('save_post', 'sb_themes_meta_save_for_ad');

            // update the post, which calls save_post again
            wp_update_post($my_post);

            // re-hook this function
            add_action('save_post', 'sb_themes_meta_save_for_ad');
        }
    }
}

function carspot_review_sidebar_shortcode()
{
    ob_start();
    get_sidebar('reviews');
    $sidebar = ob_get_contents();
    ob_end_clean();
    return $sidebar;
}

add_shortcode('get_sidebar', 'carspot_review_sidebar_shortcode');