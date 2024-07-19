<?php
/* ------------------------------------------------ */
/* Featured Car Offer */
/* ------------------------------------------------ */
if (!function_exists('ads_banner')) {
    function ads_banner()
    {
        vc_map(array(
            "name" => esc_html__("ADS Banner", 'carspot'),
            "base" => "ads_banner_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('ads-banner.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Section Top Padding", 'carspot'),
                    "param_name" => "section_padding",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Section Padding', 'carspot') => '',
                        esc_html__('No', 'carspot') => '',
                        esc_html__('Yes', 'carspot') => 'yes',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Remove Padding From Section Top.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'carspot'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'carspot') => '',
                        esc_html__('White', 'carspot') => '',
                        esc_html__('Gray', 'carspot') => 'gray',
                        esc_html__('Image', 'carspot') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("ADS Image", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Link", 'dwt-listing'),
                    "param_name" => "ads_banner_link1",
                ),
                array(
                    "group" => esc_html__("ADS Image", "carspot"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => esc_html__("Banner Image", 'carspot'),
                    "param_name" => "ads_img1",
                    "description" => esc_html__("only one image with 270x290 dimention.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("ADS Image", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Link", 'dwt-listing'),
                    "param_name" => "ads_banner_link2",
                ),
                array(
                    "group" => esc_html__("ADS Image", "carspot"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => esc_html__("Banner Image", 'carspot'),
                    "param_name" => "ads_img2",
                    "description" => esc_html__("only one image with 870x290 dimention", 'carspot'),
                ),
            )));
    }
}
add_action('vc_before_init', 'ads_banner');

if (!function_exists('ads_banner_func')) {
    function ads_banner_func($atts, $content = '')
    {
        global $carspot_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'ads_img1' => '',
            'ads_banner_link1' => '',
            'ads_img2' => '',
            'ads_banner_link2' => '',
        ), $atts));

        /* banner image one with link */
        $banner1_link = 'javascript:void(0)';
        if (isset($ads_banner_link1) && $ads_banner_link1 != '') {
            $banner1_link = esc_url($ads_banner_link1);
        }
        $banner_img1 = '';
        if (isset($ads_img1) && $ads_img1 != '') {
            $banner_img1 = '<a href="' . $banner1_link . '" target="_blank"><img src="' . carspot_returnImgSrc($ads_img1) . '" alt="' . esc_html("Banner Image One", "carspot") . '"></a>';
        }

        /* banner image two with link */
        $banner2_link = 'javascript:void(0)';
        if (isset($ads_banner_link1) && $ads_banner_link1 != '') {
            $banner2_link = esc_url($ads_banner_link2);
        }
        $banner_img2 = '';
        if (isset($ads_img2) && $ads_img2 != '') {
            $banner_img2 = '<a href="' . $banner2_link . '" target="_blank"><img src="' . carspot_returnImgSrc($ads_img2) . '" alt="' . esc_html('Banner Image Two', 'carspot') . '"></a>';
        }

        return '<section class="car-display-banner ' . $top_padding. ' ' . $bg_color . '" ' . $style . '>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
            <div class="left-cont">
              ' . $banner_img1 . '
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
            <div class="right-cont">
              ' . $banner_img2 . '
            </div>
          </div>
        </div>
      </div>
    </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('ads_banner_base', 'ads_banner_func');
}