<?php
/* ------------------------------------------------ */
/* clients_slider */
/* ------------------------------------------------ */
if (!function_exists('clients_slider_short')) {

    function clients_slider_short()
    {
        vc_map(array(
            "name" => esc_html__("Clients or Partners Slider", 'carspot'),
            "base" => "clients_slider_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('clients_slider.png') . esc_html__('Output of the shortcode will be look like this.', 'carspot'),
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
                    'group' => esc_html__('Clients Or Partner', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Add Clients', 'carspot'),
                    'param_name' => 'my_clients',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "class" => "",
                            "heading" => esc_html__("Client logo", 'carspot'),
                            "param_name" => "clients_thumb",
                            "description" => esc_html__('Image Size Should Be <strong> 200x130 </strong> ', 'carspot'),
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Client URL", 'carspot'),
                            "param_name" => "client_url",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'clients_slider_short');

if (!function_exists('clients_slider_short_base_func')) {

    function clients_slider_short_base_func($atts, $content = '')
    {
        extract(shortcode_atts(array(
            'client_url' => '',
            'my_clients' => '',
        ), $atts));
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $html = '';
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $testimonials_loop = '';
        $rows = array();
        if (isset($atts['my_clients']) && !empty($atts['my_clients'])) {
            $rows = vc_param_group_parse_atts($atts['my_clients']);
        }
        if (count((array)$rows) > 0) {
            $clients_thumb = '';
            $client_url = '';
            foreach ($rows as $row) {
                if (isset($row['clients_thumb'])) {
                    $clients_logo = carspot_returnImgSrc($row['clients_thumb']);
                    if (isset($row['client_url']) && $row['client_url'] != '') {
                        $testimonials_loop .= '<div class="client-logo">
                              <a href="' . esc_url($row['client_url']) . '" target="_blank"><img src="' . esc_url($clients_logo) . '" class="img-responsive" alt="' . esc_html__("clients", "carspot") . '" /></a>
                           </div>';
                    } else {
                        $testimonials_loop .= '<div class="client-logo">
								  <img src="' . esc_url($clients_logo) . '" class="img-responsive" alt="' . esc_html__("clients", "carspot") . '" />
							   </div>';
                    }
                }
            }
        }
        return '<section class="client-section ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '">
            <div class="container">
               <div class="row">
                  <div class="col-md-4 col-sm-12 col-xs-12">
                     <div class="margin-top-10">
                        <h3>' . $client_tagline . '</h3>
                        <h2>' . $client_heading . '</h2>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <div class="brand-logo-area clients-bg">
                        <div class="clients-list owl-carousel owl-theme">
                           ' . $testimonials_loop . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('clients_slider_short_base', 'clients_slider_short_base_func');
}