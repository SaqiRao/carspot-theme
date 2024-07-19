<?php
/* ------------------------------------------------ */
/* Services Classic */
/* ------------------------------------------------ */
if (!function_exists('services_with_facts')) {

	function services_with_facts()
	{
		vc_map(array(
			"name" => esc_html__("Services With Facts", 'carspot'),
			"base" => "services_with_facts_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('services_with_facts.png') .  esc_html__('Output of the shortcode will be look like this.', 'carspot'),
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
					'group' => esc_html__('Services We Offer', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Select Services', 'carspot'),
					'param_name' => 'services_with_img',
					'value' => '',
					'params' => array(
						array(
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Services Count", 'carspot'),
							"param_name" => "serv_count",
						),
						array(
							"type" => "attach_image",
							"holder" => "bg_img",
							"class" => "",
							"heading" => esc_html__("Icon Image", 'carspot'),
							"param_name" => "icon_img",
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
					"group" => esc_html__("Fun Facts", "carspot"),
					"type" => "dropdown",
					"class" => "",
					"description" =>  esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
					"heading" => esc_html__("Want to show?", 'carspot'),
					"param_name" => "funfact_show_hide",
					"value" => array(
						esc_html__('Yes', 'carspot') => 'yes',
						esc_html__('No', 'carspot') => 'no',
					)
				),
				array(
					'group' => esc_html__('Fun Facts', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Select Services', 'carspot'),
					'param_name' => 'funfact_detaisl',
					'value' => '',
					'dependency' => array(
						'element' => 'funfact_show_hide',
						'value' => array('yes'),
					),
					'params' => array(
						array(
							"group" => esc_html__("Fun Facts", "carspot"),
							"type" => "textfield",
							"holder" => "div",
							"class" => "",
							"heading" => esc_html__("Total Numbers in counter", 'carspot'),
							"param_name" => "fact_count",
							"value" => "",
							'edit_field_class' => 'vc_col-sm-12 vc_column',
						),
						array(
							"group" => esc_html__("Fun Facts", "carspot"),
							"type" => "textfield",
							"holder" => "div",
							"class" => "",
							"heading" => esc_html__("Text below the numbers", 'carspot'),
							"param_name" => "fact_text",
							"value" => "",
							'edit_field_class' => 'vc_col-sm-12 vc_column',
						),
						array(
							"group" => esc_html__("Fun Facts", "carspot"),
							"type" => "textfield",
							"holder" => "div",
							"class" => "",
							"heading" => esc_html__("Colored Text ", 'carspot'),
							"param_name" => "fact_color_text",
							"value" => "",
							'edit_field_class' => 'vc_col-sm-12 vc_column',
						),
					)
				),
			),
		));
	}
}

add_action('vc_before_init', 'services_with_facts');

if (!function_exists('services_with_facts_func')) {

	function services_with_facts_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

		$html = '';
		$parallex	=	'';
		if ($section_bg == 'img') {
			$parallex	=	'parallex';
		}

		$icon_imgURL = '';
		$title = '';
		if (isset($section_title_about) && $section_title_about != '') {
			$title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
		}

		$services_all = '';
		$rows = vc_param_group_parse_atts($atts['services_with_img']);
		if (count((array) $rows) > 0) {
			foreach ($rows as $row) {
				if (isset($row['serv_title']) && isset($row['serv_desc'])) {
					$icon_imgURL	= carspot_returnImgSrc($row['icon_img']);
					$services_all .= '
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="services-3-box">
                            <div class="icon-area"><img src="' . $icon_imgURL . '" alt="' . __('image not found', 'carspot') . '"></div>
                            <span class="counts">' . $row['serv_count'] . '</span>
                            <h3>' . $row['serv_title'] . '</h3>
                            <p>' . $row['serv_desc'] . '</p>
                        </div>
                      </div>';
				}
			}
		}

		/*FUNFACTS COUNTER*/
		$fact_count = '';
		$fact_text = '';
		$funfact_detaisl = '';
		$fact_color_text = '';
		$funfact_all = '';
		if (!empty($atts['funfact_detaisl'])) {

			$rows = vc_param_group_parse_atts($atts['funfact_detaisl']);
			if (count((array) $rows) > 0) {
				$funfact_all .= '<div class="row"><div class="funfacts with-services">';
				foreach ($rows as $row) {
					if (isset($row['fact_count']) && isset($row['fact_text'])) {
						$colored_html = '';
						if (isset($row['fact_color_text']))
							$colored_html = '<span>' . $row['fact_color_text'] . '</span>';

						$funfact_all .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                         <div class="number"><span class="timer" data-from="0" data-to="' . $row['fact_count'] . '" data-speed="1500" data-refresh-interval="5">0</span>+</div>
                         <h4>' . $row['fact_text'] . ' ' . $colored_html . ' </h4>
                      </div>';
					}
				}
				$funfact_all .= '</div></div>';
			}
		}



		return '<section class="section-padding services-3 section-style-2 ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                  	<div class="row">
                      ' . $services_all . '
                    </div>
                 </div>
               </div>
			  ' . $funfact_all . '
            </div>
         </section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('services_with_facts_base', 'services_with_facts_func');
}
