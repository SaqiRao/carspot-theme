<?php
/* ------------------------------------------------ */
/* About Us Classic */
/* ------------------------------------------------ */
if (!function_exists('about_classic')) {
    function about_classic()
    {
        vc_map(array(
            "name" => esc_html__("About Us Classic", 'carspot'),
            "base" => "about_classic_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('classic.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "heading" => esc_html__("Your Tagline", 'carspot'),
                    "param_name" => "sell_tagline",
                    "value" => "",
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
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => esc_html__("Image", 'carspot'),
                    "param_name" => "main_image",
                    "description" => esc_html__("Recommended Size For Image should be 555x296 .png", 'carspot'),
                ),

                array(
                    "group" => esc_html__("About Us", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select Image Position", 'carspot'),
                    "param_name" => "img_postion",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Left Side', 'carspot') => 'left',
                        esc_html__('Right Side', 'carspot') => 'right'
                    ),
                    "description" => esc_html__("Chose image position.", 'carspot'),
                ),


                array(
                    'group' => esc_html__('What We Do', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Services', 'carspot'),
                    'param_name' => 'services_add_left',
                    'value' => '',
                    'params' => array(

                        array(
                            'type' => 'iconpicker',
                            'heading' => esc_html__('Icon', 'carspot'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),

                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Title Of Service", 'carspot'),
                            "param_name" => "serv_title",
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "heading" => esc_html__("Description", 'carspot'),
                            "param_name" => "serv_desc",
                        ),
                    )
                ),

                array(
                    "group" => esc_html__("Animation", "carspot"),
                    "type" => "dropdown",
                    "class" => "",
                    "description" => esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot') . '</strong>',
                    "heading" => esc_html__("Animation Effects", 'carspot'),
                    "param_name" => "animation_effects",
                    "value" => carspot_revial_animations(),
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'about_classic');

if (!function_exists('about_classic_func')) {
    function about_classic_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }

        //animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }


        $img_left = '';
        $img_right = '';
        $left_column = '';
        $main_img = carspot_returnImgSrc($main_image);
        if (isset($main_img) && $main_img != '') {
            if ($img_postion == 'left') {
                $img_left = '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><img src="' . $main_img . '" class="wow ' . $revail_animation . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            } else {
                $img_right = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . $main_img . '" class="wow ' . $revail_animation . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            }
        }


        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<div class="title"><h3>' . carspot_color_text($section_title_about) . '</h3></div>';
        }


        $rows = vc_param_group_parse_atts($atts['services_add_left']);
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $left_column .= '<div class="col-md-3 col-xs-12 col-sm-6">
                     <!-- services grid -->
                     <div class="services-grid">
                        <div class="icons"><i class="' . $row['icon'] . '"></i></div>
                        <h4>' . $row['serv_title'] . '</h4>
                       <p>' . $row['serv_desc'] . '</p>
                     </div>
                  </div>';
                }
            }
        }
        return '<section class="custom-padding about-us ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '"' . $style . '>
            <div class="container">
               <div class="row">
			      ' . $img_left . '
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    ' . $title . '
                     <div class="content">
                        <p class="service-summary">' . $sell_tagline . '</p>
                        <p>' . $section_description . '</p>
                     </div>
                  </div>
                  ' . $img_right . '
               </div>
               <div class="row margin-top-20">
                 ' . $left_column . '
               </div>
            </div>
         </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('about_classic_base', 'about_classic_func');
}