<?php
/* ------------------------------------------------ */
/* Call to Action */
/* ------------------------------------------------ */
if (!function_exists('call_to_action_short3')) {
	function call_to_action_short3()
	{
		vc_map(array(
			"name" => esc_html__("Call to Action 3", 'carspot'),
			"base" => "call_to_action_short_base3",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('call_to_action_3.png') . esc_html__('Output of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"group" => esc_html__("Left Side", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__(" Left Tagline", 'carspot'),
					"param_name" => "tagline_left",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Left Side", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__(" Left Side Heading", 'carspot'),
					"param_name" => "title_left",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Left Side", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Left Side Description", 'carspot'),
					"param_name" => "desc_left",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Left Side", "'carspot"),
					"type" => "vc_link",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Call to action button Link", 'carspot'),
					"param_name" => "left_link",
				),
				array(
					"group" => esc_html__("Left Side", "'carspot"),
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Left Car Image", 'carspot'),
					"param_name" => "left_car_img",
					"description" => esc_html__("1280x800", 'carspot'),
				),
				array(
					"group" => esc_html__("Right Side", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__(" Right Tagline", 'carspot'),
					"param_name" => "tagline_right",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Right Side", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__(" Right Side Heading", 'carspot'),
					"param_name" => "title_right",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Right Side", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Right Side Description", 'carspot'),
					"param_name" => "desc_right",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					"group" => esc_html__("Right Side", "'carspot"),
					"type" => "vc_link",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Call to action button Link", 'carspot'),
					"param_name" => "right_link",
				),
				array(
					"group" => esc_html__("Right Side", "'carspot"),
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Right Car Image", 'carspot'),
					"param_name" => "right_car_img",
					"description" => esc_html__("1280x800", 'carspot'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"description" =>  esc_html__('Want to show image as back ground or only text', 'carspot'),
					"heading" => esc_html__("Want to show bg image?", 'carspot'),
					"param_name" => "bg_show_hide",
					"value" => array(
						esc_html__('Yes', 'carspot') => 'yes',
						esc_html__('No', 'carspot') => 'no',
					)
				),
				array(
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
					"description" => esc_html__("1280x800", 'carspot'),
					'dependency' => array(
						'element' => 'bg_show_hide',
						'value' => array('yes'),
					),
				),
			),
		));
	}
}
add_action('vc_before_init', 'call_to_action_short3');
if (!function_exists('call_to_action_short_base_func3')) {
	function call_to_action_short_base_func3($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'bg_img' => '',
			'right_car_img' => '',
			'desc_right' => '',
			'title_right' => '',
			'tagline_right' => '',
			'left_car_img' => '',
			'desc_left' => '',
			'title_left' => '',
			'tagline_left' => '',
			'bg_show_hide' => '',
			'right_link' => '',
			'left_link' => '',
		), $atts));

		$style = '';
		$black_text = '';

		if ($bg_img != "") {
			$bgImageURL	=	carspot_returnImgSrc($bg_img);
			$style = ($bgImageURL != "") ? ' style=" background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center;background-size: cover;-moz-background-size: cover;-ms-background-size: cover;-o-background-size: cover;-webkit-background-size: cover;"' : "";
		} else {
			$black_text = 'black_text';
		}
		$left_car_imgURL = '';
		$left_image_full  = '';
		$right_car_imgURL = '';
		$right_image_full  = '';
		if ($left_car_img != "") {
			if (wp_attachment_is_image($left_car_img)) {
				$left_car_imgURL	=	carspot_returnImgSrc($left_car_img);
				$left_image_full 	=	'<div class="text-center"><img class="img-responsive wow slideInLeft center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . $left_car_imgURL . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
			} else {
				$left_image_full 	=	'<div class="text-center"><img class="img-responsive wow slideInLeft center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . get_template_directory_uri() . '/images/sell.png' . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
			}
		}
		if ($right_car_img != "") {
			if (wp_attachment_is_image($right_car_img)) {
				$right_car_imgURL	=	carspot_returnImgSrc($right_car_img);
				$right_image_full 	=	 '<div class="text-center"><img class="img-responsive wow slideInRight center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . $right_car_imgURL . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
			} else {
				$right_image_full 	=	 '<div class="text-center"><img class="img-responsive wow slideInRight center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . get_template_directory_uri() . '/images/sell-1.png' . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
			}
		}
		return '<section class="sell-box sell-box-2 section-padding ' . $black_text . '" ' . $style . '>
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                     <div class="sell-box-grid">
                        <div class="short-info">
                           <h3>' . $tagline_left . '</h3>
                           <a href="javascript:void()" class="headings">' . $title_left . '</a>
                           <p>' . $desc_left . ' </p>
						   ' . carspot_ThemeBtn($left_link, 'btn btn-theme', false, '', '') . '
                        </div>
                        
                           ' . $left_image_full . '
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                     <div class="sell-box-grid right">
                        <div class="short-info">
                           <h3> ' . $tagline_right . '</h3>
                           <a href="javascript:void()" class="headings">' . $title_right . '</a>
                           <p>' . $desc_right . ' </p>
						   ' . carspot_ThemeBtn($right_link, 'btn btn-theme', false, '', '') . '
                        </div>
                           ' . $right_image_full . '
                     </div>
                  </div>
               </div>
            </div>
         </section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('call_to_action_short_base3', 'call_to_action_short_base_func3');
}
