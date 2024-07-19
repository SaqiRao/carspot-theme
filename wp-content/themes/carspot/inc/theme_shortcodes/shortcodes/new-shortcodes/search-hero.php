<?php
if (!function_exists('carspot_search_hero')) {
    function carspot_search_hero()
    {
        vc_map(array(
                "name" => esc_html__("Hero Section", 'carspot'),
                "base" => "carspot_search_hero_base",
                "category" => esc_html__("Theme Shortcodes", 'carspot'),
                "params" => array(
                    array(
                        'group' => esc_html__('Shortcode Output', 'carspot'),
                        'type' => 'custom_markup',
                        'heading' => esc_html__('Shortcode Output', 'carspot'),
                        'param_name' => 'order_field_key',
                        'description' => carspot_VCImage('hero-search.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                    ),
                    array(
                        "group" => esc_html__("Basic", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Section Title", 'carspot'),
                        "param_name" => "search_hero_section_title",
                    ),
                    array(
                        "group" => esc_html__("Basic", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Section Tagline", 'carspot'),
                        "description" => '',
                        "param_name" => "search_hero_tag_line",
                    ),
                    array(
                        "group" => esc_html__("Basic", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Video Link", 'carspot'),
                        "description" => '',
                        "param_name" => "search_hero_video_link",
                    ),
                    array(
                        "group" => esc_html__("Basic", "'carspot"),
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__("Video Text", 'carspot'),
                        "description" => '',
                        "param_name" => "search_hero_video_text",
                    ),
                    array(
                        "group" => esc_html__("Basic", "'carspot"),
                        "type" => "vc_link",
                        "heading" => esc_html__("Read More Link", 'carspot'),
                        "param_name" => "search_hero_main_link",
                        "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                    ),
                    array(
                        'group' => esc_html__('Slider', 'carspot'),
                        'type' => 'param_group',
                        'heading' => esc_html__('Add Slider Image', 'carspot'),
                        'param_name' => 'slides',
                        'value' => '',
                        'params' => array(
                            array(
                                "type" => "attach_image",
                                "holder" => "bg_img",
                                "class" => "",
                                "heading" => esc_html__("Background Image", 'carspot'),
                                "param_name" => "slide_img",
                                "description" => esc_html__("1650x500", 'carspot'),
                            ),

                        )
                    ),

                )
            )
        );
    }
}
add_action('vc_before_init', 'carspot_search_hero');

if (!function_exists('carspot_search_hero_base_func')) {
    function carspot_search_hero_base_func($atts, $content = '')
    {
        extract(shortcode_atts(array(
            'search_hero_section_title' => '',
            'search_hero_tag_line' => '',
            'search_hero_main_link' => '',
            'slides' => '',
            'slide_img' => '',
            'search_hero_video_link' => '',
            'search_hero_video_text' => '',
        ), $atts));

        /* ================
        *     Video Link
         * ================ */
        $search_hero_tag_line = (isset($search_hero_tag_line) && $search_hero_tag_line != '') ? $search_hero_tag_line : '';
        $search_hero_section_title = (isset($search_hero_section_title) && $search_hero_section_title != '') ? $search_hero_section_title : '';
        $tag_title_line = '<p>' . $search_hero_tag_line . '</p><h2>' . $search_hero_section_title . '</h2>';

        /* ================
        *     Video Link
         * ================ */
        $vid_link = (isset($search_hero_video_link) && $search_hero_video_link != '') ? $search_hero_video_link : '#';
        $vid_title = (isset($search_hero_video_text) && $search_hero_video_text != '') ? $search_hero_video_text : esc_html__("Watching Video", "carspot");
        $video_link_title = '<span><a href="' . $vid_link . '"><span class="iconify" data-icon="bi:play-fill"></span></a></span><h6>' . $vid_title . '</h6>';

        /* ==============
        *     Read More
         * ============== */
        $button = '';
        $button = carspot_ThemeBtn($search_hero_main_link, 'read-more', false, false, '');

        /* ==============
        *     slides
         * ============== */
        $slides = vc_param_group_parse_atts($atts['slides']);
        $slider_html = '';
        if (count((array)$slides) > 0) {
            foreach ($slides as $slide) {
                if (isset($slide['slide_img'])) {
                    $slider_html .= '<div class="item"><img class="img-responsive" src="' . carspot_returnImgSrc($slide['slide_img']) . '" alt="' . esc_html__('image', 'carspot') . '"></div>';
                }
            }
        }

        return '<section class="hero-top-banner">
                  <div class="owl-carousel owl-theme banner-carousel">
                    ' . $slider_html . '
                  </div>
                  <div class="hero-top-banner-cont">
                    <div class="container">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 col-xxl-5"></div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-7 col-xxl-7">
                            <div class="banner-meta">
                              <div class="video-title">
                                ' . $video_link_title . '
                              </div>
                              ' . $tag_title_line . '
                              ' . $button . '
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </section>';

    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('carspot_search_hero_base', 'carspot_search_hero_base_func');
}