<?php
/* ------------------------------------------------ */
/* Car Inspection */
/* ------------------------------------------------ */
if (!function_exists('inspection_short')) {
    function inspection_short()
    {
        vc_map(array(
            "name" => esc_html__("Car Inspection", 'carspot'),
            "base" => "inspection_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('inspection.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Tagline", 'carspot'),
                    "param_name" => "client_tagline",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Heading", 'carspot'),
                    "param_name" => "client_heading",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Read More Link", 'carspot'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", "carspot"),
                ),


                array(
                    'group' => esc_html__('Inspection List', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Add Inspection List', 'carspot'),
                    'param_name' => 'inspection',
                    'value' => '',
                    'params' => array(

                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("List", 'carspot'),
                            "param_name" => "inspection_list",
                        ),

                    )
                ),

                array(
                    "group" => esc_html__("Inspection Image", "'carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => esc_html__("Image", 'carspot'),
                    "param_name" => "main_image",
                    "description" => "685x429",
                ),

                array(
                    "group" => esc_html__("Inspection Image", "'carspot"),
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

add_action('vc_before_init', 'inspection_short');

if (!function_exists('inspection_short_base_func')) {
    function inspection_short_base_func($atts, $content = '')
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
        $main_img = carspot_returnImgSrc($main_image);
        if (isset($main_img)) {
            if ($img_postion == 'left') {
                $img_left = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . esc_url($main_img) . '" class="wow ' . $revail_animation . ' img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            } else {
                $img_right = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . esc_url($main_img) . '" class="wow ' . $revail_animation . ' img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            }
        }

        $inspection_list = '';
        $rows = vc_param_group_parse_atts($atts['inspection']);
        if (count((array)$rows) > 0) {
            $inspection_list = '';
            foreach ($rows as $row) {
                if (isset($row['inspection_list'])) {
                    $inspection_list .= '<li class="col-sm-4"> <i class="fa fa-check"></i> ' . $row['inspection_list'] . '</li>';
                }

            }
        }

        return '<section class="car-inspection section-padding  ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <div class="container">
               <div class="row">
                  ' . $img_left . '
                  <div class="col-md-6 col-sm-12 col-xs-12 nopadding">
                     <div class="call-to-action-detail-section">
                        <div class="heading-2">
                           <h3>' . $client_tagline . '</h3>
                           <h2>' . $client_heading . '</h2>
                        </div>
                        <p>' . $section_description . ' </p>
                        <div class="row">
                           <ul>
                             ' . $inspection_list . '
                           </ul>
                        </div>
						' . carspot_ThemeBtn($main_link, 'btn-theme btn-lg btn', false, false, '<i class="fa fa-angle-right"></i>') . '
                     </div>
                  </div>
				   ' . $img_right . '
               </div>
            </div>
         </section>';

    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('inspection_short_base', 'inspection_short_base_func');
}