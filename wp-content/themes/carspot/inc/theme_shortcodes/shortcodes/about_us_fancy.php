<?php
/* ------------------------------------------------ */
/* About Us Modern */
/* ------------------------------------------------ */
if (!function_exists('about_fancy')) {

    function about_fancy() {
        vc_map(array(
            "name" => esc_html__("About Us Modern", 'carspot'),
            "base" => "about_fancy_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('about_withfun.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'carspot'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Image", 'carspot'),
                    "param_name" => "main_image",
                ),
                array(
                    "group" => esc_html__("About Us", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title_about",
                    "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("About Us", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("About Us", "'carspot"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Services', 'carspot'),
                    'param_name' => 'services_add_left',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Service", 'carspot'),
                            "param_name" => "serv_title",
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Contents", "'carspot"),
                    "type" => "textarea_html",
                    "holder" => "div",
                    "heading" => esc_html__("Your Content", 'carspot'),
                    "param_name" => "content",
                    "description" => esc_html__("Content Here", 'carspot'),
                ),
                array(
                    'group' => esc_html__('Fun Facts', 'carspot'),
                    "type" => "dropdown",
                    "heading" => esc_html__("Column", 'carspot'),
                    "param_name" => "p_cols",
                    "value" => array(
                        esc_html__('Select Column ', 'carspot') => '',
                        esc_html__('3 Col', 'carspot') => '4',
                        esc_html__('4 Col', 'carspot') => '3'
                    ),
                ),
                array
                    (
                    'group' => esc_html__('Fun Facts', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Fun Fact', 'carspot'),
                    'param_name' => 'fun_facts',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'group' => esc_html__('Fun Facts', 'carspot'),
                            'type' => 'iconpicker',
                            'heading' => esc_html__('Icon', 'carspot'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => true,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),
                        array(
                            'group' => esc_html__('Fun Facts', 'carspot'),
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Numbers", 'carspot'),
                            "param_name" => "numbers",
                        ),
                        array(
                            'group' => esc_html__('Fun Facts', 'carspot'),
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Title", 'carspot'),
                            "param_name" => "title",
                        ),
                        array(
                            'group' => esc_html__('Fun Facts', 'carspot'),
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Color Title", 'carspot'),
                            "param_name" => "color_title",
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'about_fancy');
if (!function_exists('about_fancy_func')) {

    function about_fancy_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'p_cols' => '3',
            'fun_facts' => '',
                        ), $atts));


        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }


        $img_left = '';
        $img_right = '';
        $left_column = '';
        if (wp_attachment_is_image($main_image)) {
            $main_img = carspot_returnImgSrc($main_image);
        } else {
            $main_img = get_template_directory_uri() . '/images/mechanic.png';
        }



        if (isset($main_img) && $main_img != '') {

            $img_left = '<img src="' . $main_img . '" class="center-block img-responsive" alt="' . esc_html__('Image Not Found', 'carspot') . '">';
        }


        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = carspot_color_text($section_title_about);
        }


        $rows = vc_param_group_parse_atts($atts['services_add_left']);
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['serv_title'])) {
                    $left_column .= '<li><a href="javascript:void(0)">' . $row['serv_title'] . '</a></li>';
                }
            }
        }


        $fun_html = '';
        $rows = vc_param_group_parse_atts($atts['fun_facts']);
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['numbers']) && isset($row['title'])) {
                    $color_html = '';
                    if (isset($row['color_title']))
                        $color_html = '<span>' . $row['color_title'] . '</span>';

                    $icon_html = '';
                    if (isset($row['icon']))
                        $icon_html = '<div class="icons">
                        <i class="' . esc_attr($row['icon']) . '"></i>
                     </div>';

                    $fun_html .= '<div class="col-lg-' . esc_attr($p_cols) . ' col-md-' . esc_attr($p_cols) . ' col-sm-6 col-xs-6">
						' . $icon_html . '
                     <div class="number"><span class="timer" data-from="0" data-to="' . $row['numbers'] . '" data-speed="1500" data-refresh-interval="5">0</span></div>
                     <h4>' . $row['title'] . ' ' . $color_html . '</h4>
                  </div>';
                }
            }
        }


        return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . ' id="about-section-3">
            <div class="container">
               <div class="row">
                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                     <div class="about-title">
                        <h2>' . $title . '</h2>
                        <p>' . $section_description . '</p>
                        <ul class="custom-links">
                          ' . $left_column . '
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                     <div class="right-side">
                         ' . $content . '
                       ' . $img_left . '
                     </div>
                  </div>
               </div>
               <div class="row about-stats">
                  <div class="">
                    ' . $fun_html . '
                  </div>
               </div>
            </div>
         </section>';
    }

}

if (function_exists('carspot_add_code')) {
    carspot_add_code('about_fancy_base', 'about_fancy_func');
}