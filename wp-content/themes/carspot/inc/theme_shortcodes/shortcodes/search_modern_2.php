<?php
/* ------------------------------------------------ */
/* Home - Hero Section */
/* ------------------------------------------------ */
if (!function_exists('search_modern_2')) {

    function search_modern_2() {
        vc_map(array(
            "name" => esc_html__("Home - Search Modern 2", 'carspot'),
            "base" => "search_modern_2",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('search_modern_2.png') . esc_html__('Output of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'carspot'),
                    "param_name" => "bg_img",
                    "description" => esc_html__("1920x1300", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Tagline", 'carspot'),
                    "description" => esc_html__("%count% for total ads.", 'carspot'),
                    "param_name" => "section_tag_line",
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Bottom car image", 'carspot'),
                    "param_name" => "car_img",
                    "description" => esc_html__("good quality image", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "vc_link",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Button Title", 'carspot'),
                    "param_name" => "link",
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_modern_2');
if (!function_exists('search_modern_2_base_func')) {

    function search_modern_2_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'button_title' => '',
            'link' => '',
            'car_img' => '',
                        ), $atts));
        global $carspot_theme;

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = carspot_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        if ($car_img != "") {
            if (wp_attachment_is_image($car_img)) {
                $car_imgURL = carspot_returnImgSrc($car_img);
            } else {
                $car_imgURL = get_template_directory_uri() . '/images/hero-cars-2.png';
            }
        }
        $button = carspot_ThemeBtn($link, 'btn btn-theme', false, false, false);
        $count_posts = wp_count_posts('ad_post');
        return '<section class="hero-section-2 section-style-3 opacity-color" ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
        <div class="hero-section-2-text">
          <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
          <h1> ' . $section_title . '</h1>
		  ' . $button . '
        </div>
      </div>
      <img src="' . esc_url($car_imgURL) . '" class="hero-car wow zoomIn img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms"  alt="' . esc_html__("image not found", 'carspot') . '"> </div>
  </div>
</section>';
    }

}
if (function_exists('carspot_add_code')) {
    carspot_add_code('search_modern_2', 'search_modern_2_base_func');
}