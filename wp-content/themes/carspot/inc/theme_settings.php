<?php
global $carspot_theme;
/*
  Theme Settings.
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on Leisure Sols, use a find and replace
 * to change ''rane to the name of your theme in all the template files.
 */
load_theme_textdomain('carspot', trailingslashit(get_template_directory()) . 'languages/');
/* Content width */
if (!isset($content_width)) {
    $content_width = 600;
}
/* WooCommrce */
add_theme_support('woocommerce');


/* Add default posts and comments RSS feed links to head. */
add_theme_support('automatic-feed-links');
add_theme_support('custom-header');

/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support('title-tag');
/* Theme editor style */
add_editor_style('editor.css');
/*
 * Enable support for Post Thumbnails on posts and pages.
 *
 * @link https://developer.wordpress.org/themes/functionality/featured-SB_TAMEER_IMAGES-post-thumbnails/
 */
//crop_ad_images

$crop_ad_images = isset($carspot_theme['crop_ad_images']) && $carspot_theme['crop_ad_images'] == false ? false : true;
add_theme_support('post-thumbnails', array('post', 'project'));
add_image_size('carspot-single-post', 750, 420, $crop_ad_images);
add_image_size('carspot-category', 400, 300, $crop_ad_images);
add_image_size('carspot-single-small', 80, 80, $crop_ad_images);
add_image_size('carspot-ad-thumb', 200, 112, $crop_ad_images);
add_image_size('carspot-ad-related', 360, 270, $crop_ad_images);
add_image_size('carspot-grid_small', 268, 166, $crop_ad_images);
add_image_size('carspot-user-profile', 300, 300, $crop_ad_images);
add_image_size('carspot-small-thumb', 100, 80, $crop_ad_images);
add_image_size('carspot-listing-small', 110, 60, $crop_ad_images);
add_image_size('carspot-reviews-thumb', 360, 270, $crop_ad_images);
add_image_size('carspot-testimonial-thumb', 90, 90, $crop_ad_images);
add_image_size('carspot-reviews-thumb-shortcode', 133, 95, $crop_ad_images);
add_image_size('carspot-reviews-large-shortcode', 653, 435, $crop_ad_images);
add_image_size('carspot-clients_thumbs', 128, 128, $crop_ad_images);
add_image_size('carspot-comparison_thumb', 310, 190, $crop_ad_images);
add_image_size('carspot-wocommerce-single', 458, 420, $crop_ad_images);
add_image_size('carspot-wocommerce-cat', 266, 200, $crop_ad_images);
add_image_size('carspot-review-stamp-logo', 150, 150, $crop_ad_images);
/* sizes for new pages 23/9/2021 */
add_image_size('carspot-ads-banner1', 270, 290, $crop_ad_images);
add_image_size('carspot-ads-banner2', 870, 290, $crop_ad_images);
// This theme uses wp_nav_menu() in one location.
register_nav_menus(array(
    'main_menu' => esc_html__('carspot Primary Menu', 'carspot'),
));
/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));
add_theme_support('post-formats', array('gallery'));
/*
 * Enable support for Post Formats.
 * See https://developer.wordpress.org/themes/functionality/post-formats/
 */
// Set up the WordPress core custom background feature.
add_theme_support('custom-background', apply_filters('carspot_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
)));
// Register side bar for widgets
add_action('widgets_init', 'sb_themes_sidebar_widgets_init');
if (!function_exists('sb_themes_sidebar_widgets_init')) {

    function sb_themes_sidebar_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('carspot Sidebar', 'carspot'),
            'id' => 'sb_themes_sidebar',
            'before_widget' => '<div class="widget widget-content"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));

        register_sidebar(array(
            'name' => esc_html__('Ads Search', 'carspot'),
            'id' => 'carspot_search_sidebar',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
        register_sidebar(array(
            'name' => esc_html__('Single Ad Top', 'carspot'),
            'id' => 'carspot_ad_sidebar_top',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
        register_sidebar(array(
            'name' => esc_html__('Single Ad Bottom', 'carspot'),
            'id' => 'carspot_ad_sidebar_bottom',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
        //Sidebar For Review & Comparison
        register_sidebar(array(
            'name' => esc_html__('Review & Comparison Sidebar', 'carspot'),
            'id' => 'sb_themes_sidebar_review',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'carspot'),
            'id' => 'sb_themes_sidebar_shop',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Archive Sidebar', 'carspot'),
            'id' => 'sb_themes_sidebar_archive',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));
    }

}