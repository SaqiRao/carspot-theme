<?php
/* ------------------------------------------------ */
/* Services */
/* ------------------------------------------------ */
if (!function_exists('shop_classic')) {
    function shop_classic()
    {
        vc_map(array(
            "name" => esc_html__("Shop Products", 'carspot'),
            "base" => "shop_classic_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('shop_classic.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Header Style", 'carspot'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Section Header Style', 'carspot') => '',
                        esc_html__('No Header', 'carspot') => '',
                        esc_html__('Classic', 'carspot') => 'classic',
                        esc_html__('Regular', 'carspot') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Chose header style.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title",
                    "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic', 'regular'),
                    ),
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
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic', 'regular'),
                    ),
                ),

                array(
                    "group" => esc_html__("Products Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Ads", 'carspot'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),

                array(
                    "group" => esc_html__("Products Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Order By", 'carspot'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Ads order', 'carspot') => '',
                        esc_html__('Oldest', 'carspot') => 'asc',
                        esc_html__('Latest', 'carspot') => 'desc',
                        esc_html__('Random', 'carspot') => 'rand'
                    ),
                ),


                array(
                    "group" => esc_html__("Products Settings", "'carspot"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Read More Link", 'carspot'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
                ),


                array
                (
                    'group' => esc_html__('Categories', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_get_parests('product_cat', 'no'),

                        ),
                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'shop_classic');
if (!function_exists('shop_classic_base_func')) {
    function shop_classic_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/shop_layout.php";


        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $button = '';
        $button = carspot_ThemeBtn($main_link, 'btn btn-lg  btn-theme', false, false, '<i class="fa fa-refresh"></i>');

        return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
				<!-- Main Container -->
				<div class="container">
				   <!-- Row -->
				   <div class="row">
						' . $header . '
						' . $html . '
						<div class="text-center">
                           <div class="load-more-btn">
						   ' . $button . '
                           </div>
                        </div>
				   </div>
				</div>
			</section>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('shop_classic_base', 'shop_classic_base_func');
}