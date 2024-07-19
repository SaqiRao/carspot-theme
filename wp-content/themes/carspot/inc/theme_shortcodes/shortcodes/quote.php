<?php
/* ------------------------------------------------ */
/* Contact us */
/* ------------------------------------------------ */
function qoute_short()
{
	vc_map(array(
		"name" => esc_html__("Quote From", 'carspot'),
		"base" => "quote_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot'),
		"params" => array(
			array(
				'group' => esc_html__('Shortcode Output', 'carspot'),
				'type' => 'custom_markup',
				'heading' => esc_html__('Shortcode Output', 'carspot'),
				'param_name' => 'order_field_key',
				'description' => carspot_VCImage('contact-us.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
			),

			array(
				"group" => esc_html__("Basic", "carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Quote Form shortcode", 'carspot'),
				"param_name" => "form_7",
			),

			array(
				"group" => esc_html__("Basic", "carspot"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"heading" => esc_html__("Image", 'carspot'),
				"param_name" => "main_image",

			),
		),
	));
}

add_action('vc_before_init', 'qoute_short');

function quote_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'form_7' => '',
		'main_image' => '',
	), $atts));

	$img_src = '';
	$main_img = '';
	$main_img	=	carspot_returnImgSrc($main_image);
	if (isset($main_img) && $main_img != '') {
		$img_src = ' <img src="' . $main_img . '" class="center-block img-responsive" alt="' . esc_html__('Image Not Found', 'carspot') . '">';
	}
	return '<section class="section-padding no-bottom gray no-top ">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 no-padding commentForm">
                     <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                           ' . do_shortcode(carspot_clean_shortcode($form_7)) . '
                     </div>
                     <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					   ' . $img_src . '
                     </div>
                  </div>
               </div>
            </div>
         </section>';
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('quote_short_base', 'quote_base_func');
}
