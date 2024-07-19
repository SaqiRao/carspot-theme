<?php
/* ------------------------------------------------ */
/* Car Buy & Sell */
/* ------------------------------------------------ */
if (!function_exists('buy_sell_short')) {
    function buy_sell_short()
    {
        vc_map(array(
            "name" => esc_html__("Car Buy & Sell", 'carspot'),
            "base" => "buy_sale_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('buy_sell.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),

                array(
                    "group" => esc_html__("Buy Section", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Tagline", 'carspot'),
                    "param_name" => "client_tagline",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Buy Section", "'carspot"),
                    "type" => "dropdown",
                    "class" => "",
                    "description" => esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot') . '</strong>',
                    "heading" => esc_html__("Animation Effects", 'carspot'),
                    "param_name" => "animation_effects",
                    "value" => carspot_revial_animations(),
                ),

                array(
                    "group" => esc_html__("Buy Section", "'carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Your Title & Link ", 'carspot'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                ),

                array(
                    "group" => esc_html__("Buy Section", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Buy Section", "'carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => esc_html__("Image", 'carspot'),
                    "param_name" => "main_image",
                    "description" => esc_html__("Recommended image size should be 715x215 .png ", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Sell Section", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Tagline", 'carspot'),
                    "param_name" => "sell_tagline",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Sell Section", "'carspot"),
                    "type" => "dropdown",
                    "class" => "",
                    "description" => esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot') . '</strong>',
                    "heading" => esc_html__("Animation Effects", 'carspot'),
                    "param_name" => "animation_effects2",
                    "value" => carspot_revial_animations(),
                ),

                array(
                    "group" => esc_html__("Sell Section", "'carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Your Title & Link ", 'carspot'),
                    "param_name" => "main_link1",
                    "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                ),

                array(
                    "group" => esc_html__("Sell Section", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description1",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),

                array(
                    "group" => esc_html__("Sell Section", "'carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => esc_html__("Image", 'carspot'),
                    "param_name" => "main_image1",
                    "description" => esc_html__("Recommended image size should be 715x215 .png ", 'carspot'),
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'buy_sell_short');

if (!function_exists('buy_sale_short_func')) {
    function buy_sale_short_func($atts, $content = '')
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
        //animation
        $revail_animation2 = '';
        if (isset($animation_effects2) && $animation_effects2 != "") {
            $revail_animation2 = $animation_effects2;
        }

        $buy = '';
        $sell = '';
        $main_img = carspot_returnImgSrc($main_image);
        if (isset($main_img) && ($main_img != "")) {

            $buy = '<div class="text-center"><img class="img-responsive wow ' . $revail_animation . ' center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . esc_url($main_img) . '" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        }

        $main_img1 = carspot_returnImgSrc($main_image1);
        if (isset($main_image1) && ($main_image1 != "")) {

            $sell = '<div class="text-center"><img class="img-responsive wow ' . $revail_animation2 . ' center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . esc_url($main_img1) . '" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        }

        return '<section class="sell-box padding-top-70">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                     <div class="sell-box-grid">
                        <div class="short-info">
                        <h3> ' . $client_tagline . '</h3>
                           <h2>' . carspot_ThemeBtn($main_link, false) . '</h2>
                           <p>' . $section_description . '</p>
                        </div>
                        ' . $buy . '
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                     <div class="sell-box-grid">
                        <div class="short-info">
                        <h3>' . $sell_tagline . '</h3>
                           <h2>' . carspot_ThemeBtn($main_link1, false) . '</h2>
                           <p>' . $section_description1 . '</p>
                        </div>
                        ' . $sell . '
                     </div>
                  </div>
               </div>
            </div>
         </section> ';

    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('buy_sale_base', 'buy_sale_short_func');
}