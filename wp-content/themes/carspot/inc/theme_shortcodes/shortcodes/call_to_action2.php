<?php
/* ------------------------------------------------ */
/* Call to Action */
/* ------------------------------------------------ */
if (!function_exists('call_to_action_short2')) {
	function call_to_action_short2()
	{
		vc_map(array(
			"name" => esc_html__("Call to Action 2", 'carspot'),
			"base" => "call_to_action_short_base2",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('call_to_action.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
					"description" => esc_html__("1280x800", 'carspot'),
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title", 'carspot'),
					"param_name" => "title",
				),
				array(
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Description", 'carspot'),
					"param_name" => "description",
				),
				array(
					"type" => "vc_link",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Read More Link", 'carspot'),
					"param_name" => "link",
				),
				array(
					"type" => "vc_link",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Read More Link", 'carspot'),
					"param_name" => "link2",
				),
			),
		));
	}
}
add_action('vc_before_init', 'call_to_action_short2');
if (!function_exists('call_to_action_short_base_func2')) {
	function call_to_action_short_base_func2($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'bg_img' => '',
			'title' => '',
			'description' => '',
			'link' => '',
			'link2' => '',
		), $atts));

		$style = '';
		if ($bg_img != "") {
			$bgImageURL	=	carspot_returnImgSrc($bg_img);
			$style = ($bgImageURL != "") ? ' style=" background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') repeat fixed center center;background-size: cover;-moz-background-size: cover;-ms-background-size: cover;-o-background-size: cover;-webkit-background-size: cover;"' : "";
		}
		return '
<div class="parallex section-padding about-us text-center" ' . $style . '>
         <div class="container">
            <div class="row">
               <!-- countTo -->
               <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="parallex-text">
                 <h5>' . esc_html($title) . '</h5>
                     <h4>' . esc_html($description) . '</h4>
                     ' . carspot_ThemeBtn($link, 'btn btn-theme', false, '', '') . '
                     ' . carspot_ThemeBtn($link2, 'btn btn-clean', false, '', '') . '
                  </div>
               </div>
               <!-- end col-xs-6 col-sm-3 col-md-3 -->
            </div>
            <!-- End row -->
         </div>
      </div>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('call_to_action_short_base2', 'call_to_action_short_base_func2');
}
