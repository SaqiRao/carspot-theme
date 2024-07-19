<?php
/* ------------------------------------------------ */
/* Testimonials */
/* ------------------------------------------------ */
if (!function_exists('testimonial_short')) {
	function testimonial_short()
	{
		vc_map(array(
			"name" => esc_html__("Testimonials", 'carspot'),
			"base" => "testimonials_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('testimonials.png') .  esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
					"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
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
					'group' => esc_html__('Testimonials', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Add Testimonials', 'carspot'),
					'param_name' => 'testimonials',
					'value' => '',
					'params' => array(

						array(
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Title", 'carspot'),
							"param_name" => "testi_title",
						),
						array(
							"type" => "textarea",
							"holder" => "div",
							"heading" => esc_html__("Description", 'carspot'),
							"param_name" => "testi_desc",
						),

						array(
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("User Name", 'carspot'),
							"param_name" => "testi_user_name",
						),
						array(
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("User Desgination", 'carspot'),
							"param_name" => "testi_user_desg",
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Header Style", 'carspot'),
							"param_name" => "testi_rating",
							"admin_label" => true,
							"value" => array(
								esc_html__('Select Rating', 'carspot') => '',
								esc_html__('No Reating', 'carspot') => '',
								esc_html__('1 Star', 'carspot') => '1',
								esc_html__('2 Star', 'carspot') => '2',
								esc_html__('3 Star', 'carspot') => '3',
								esc_html__('4 Star', 'carspot') => '4',
								esc_html__('5 Star', 'carspot') => '5',
							),
							'edit_field_class' => 'vc_col-sm-12 vc_column',
							"std" => '',
							"description" => esc_html__("User Rating.", 'carspot'),
						),

						array(
							"type" => "attach_image",
							"holder" => "bg_img",
							"class" => "",
							"heading" => esc_html__("User Image", 'carspot'),
							"param_name" => "testi_user_img",
							"description" =>  esc_html__('Image Size Should Be <strong> 90x90 </strong> ', 'carspot'),
						),

					)
				),

			),
		));
	}
}

add_action('vc_before_init', 'testimonial_short');

if (!function_exists('testimonial_short_base_func')) {
	function testimonial_short_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
		$html = '';
		$parallex	=	'';
		if ($section_bg == 'img') {
			$parallex	=	'parallex';
		}
		$testimonials = '';
		//Left Services Column
		$rows = vc_param_group_parse_atts($atts['testimonials']);
		if (count((array) $rows) > 0) {
			$testi_thumb = '';
			$user_name = '';
			$user_desg = '';
			$rating_val = '';
			foreach ($rows as $row) {
				if (isset($row['testi_user_img'])) {
					$testi_thumb =  carspot_returnImgSrc($row['testi_user_img'], 'carspot-testimonial-thumb');
				}
				if (isset($row['testi_user_name'])) {
					$user_name =  $row['testi_user_name'];
				}
				if (isset($row['testi_user_desg'])) {
					$user_desg =  $row['testi_user_desg'];
				}

				if (isset($row['testi_rating'])) {
					$rating =  $row['testi_rating'];
					$rating_val = '';
					for ($i = 1; $i <= 5; $i++) {
						$star = "";
						if (!empty($rating) && $i <= $rating) {
							$star = "fa fa-star";
						}
						$rating_val .= '<i class="fa fa-star-o' . $star . '"></i>';
					}
				}


				if (isset($row['testi_title']) && isset($row['testi_desc'])) {
					$testimonials .= '
                    <!--Testimonial Column-->
                     <div class="single_testimonial">
                        <div class="textimonial-content">
                           <h4>' . $row['testi_title'] . '</h4>
                           <p>' . $row['testi_desc'] . '</p>
                        </div>
                        <div class="testimonial-meta-box">
                           <img src="' . esc_url($testi_thumb) . '" alt="' . esc_attr($user_name) . '">
                           <div class="testimonial-meta">
                              <h3>' . $user_name . '</h3>
                              <p>' . $user_desg . '</p>
                                ' . $rating_val . '
                           </div>
                        </div>
                     </div>';
				}
			}
		}

		return '
	 <section class="section-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <!-- Main Container -->
            <div class="container">
			   ' . $header . '
				<div class="row">
                  	<div class="owl-testimonial-2  owl-carousel owl-theme">' . $testimonials . '</div>	 
				</div>
			</div>
	</section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('testimonials_short_base', 'testimonial_short_base_func');
}
