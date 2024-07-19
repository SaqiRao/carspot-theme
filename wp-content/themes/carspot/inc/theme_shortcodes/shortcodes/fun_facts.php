<?php
/* ------------------------------------------------ */
/* Fun Facts */
/* ------------------------------------------------ */
if (!function_exists('fun_factsshort')) {
	function fun_factsshort()
	{
		vc_map(array(
			"name" => esc_html__("Fun Facts", 'carspot'),
			"base" => "fun_factsshort_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('fun_fact.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
					"description" => esc_html__("1280x800", 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Column", 'carspot'),
					"param_name" => "p_cols",
					"value" => array(
						esc_html__('Select Col ', 'carspot') => '',
						esc_html__('3 Col', 'carspot') => '4',
						esc_html__('4 Col', 'carspot') => '3'
					),
				),

				array(
					'group' => esc_html__('Fun Facts', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Fun Fact', 'carspot'),
					'param_name' => 'fun_facts',
					'value' => '',
					'params' => array(
						array(
							'group' => esc_html__('Fun Facts', 'carspot'),
							'type' => 'iconpicker',
							'heading' => esc_html__('Icon', 'carspot'),
							'param_name' => 'icon',
							'settings' => array(
								'emptyIcon' => true,
								'type' => 'classified',
								'iconsPerPage' => 100, // default 100, how many icons per/page to display
							),
						),
						array(
							'group' => esc_html__('Fun Facts', 'carspot'),
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Numbers", 'carspot'),
							"param_name" => "numbers",
						),
						array(
							'group' => esc_html__('Fun Facts', 'carspot'),
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Title", 'carspot'),
							"param_name" => "title",
						),
						array(
							'group' => esc_html__('Fun Facts', 'carspot'),
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Color Title", 'carspot'),
							"param_name" => "color_title",
						),
					)
				),


			),
		));
	}
}

add_action('vc_before_init', 'fun_factsshort');

if (!function_exists('fun_factsshort_base_func')) {
	function fun_factsshort_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'bg_img' => '',
			'p_cols' => '3',
			'fun_facts' => '',
		), $atts));

		$fun_html  = '';
		$rows = vc_param_group_parse_atts($atts['fun_facts']);
		if (count((array) $rows) > 0) {
			foreach ($rows as $row) {
				if (isset($row['numbers']) && isset($row['title'])) {
					$color_html = '';
					if (isset($row['color_title']))
						$color_html = '<span>' . $row['color_title'] . '</span>';

					$icon_html = '';
					if (isset($row['icon']))
						$icon_html = '<div class="icons">
                        <i class="' . esc_attr($row['icon']) . '"></i>
                     </div>';

					$fun_html .= '<div class="col-lg-' . esc_attr($p_cols) . ' col-md-' . esc_attr($p_cols) . ' col-sm-6 col-xs-6">
						' . $icon_html . '
                     <div class="number"><span class="timer" data-from="0" data-to="' . $row['numbers'] . '" data-speed="1500" data-refresh-interval="5">0</span></div>
                     <h4>' . $row['title'] . ' ' . $color_html . '</h4>
                  </div>';
				}
			}
		}


		$style = '';
		if ($bg_img != "") {
			$bgImageURL	=	carspot_returnImgSrc($bg_img);
			$style = ($bgImageURL != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
		}

		return '<div class="funfacts custom-padding parallex" ' . $style . '>
            <div class="container">
               <div class="row">' . $fun_html . '</div>
            </div>
         </div> ';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('fun_factsshort_base', 'fun_factsshort_base_func');
}
