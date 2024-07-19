<?php
/* ------------------------------------------------ */
/* why chose us */
/* ------------------------------------------------ */
if (!function_exists('why_us_short')) {
	function why_us_short()
	{
		vc_map(array(
			"name" => esc_html__("Why Us", 'carspot'),
			"base" => "why_us_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('why_us.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
					"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . esc_html('{color}') . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency' => array(
						'element' => 'header_style',
						'value' => array('classic'),
					),
				),
				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "section_title_regular",
					"value" => "",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency' => array(
						'element' => 'header_style',
						'value' => array('regular'),
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
						'value' => array('classic'),
					),
				),

				array(
					'group' => esc_html__('Facts', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Select Category', 'carspot'),
					'param_name' => 'facts',
					'value' => '',
					'params' => array(
						array(
							'group' => esc_html__('Facts', 'carspot'),
							"type" => "textfield",
							"holder" => "div",
							"heading" => esc_html__("Title", 'carspot'),
							"param_name" => "title",
						),
						array(
							'group' => esc_html__('Facts', 'carspot'),
							"type" => "textarea",
							"holder" => "div",
							"heading" => esc_html__("Description", 'carspot'),
							"param_name" => "description",
						),
						array(
							'group' => esc_html__('Facts', 'carspot'),
							"type" => "vc_link",
							"heading" => esc_html__("Read More Link", 'carspot'),
							"param_name" => "link",
						),
					)
				),

			),
		));
	}
}

add_action('vc_before_init', 'why_us_short');

if (!function_exists('why_us_short_base_func')) {
	function why_us_short_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

		$rows = vc_param_group_parse_atts($atts['facts']);
		$facts_html	=	'';
		if (count((array) $rows) > 0) {
			foreach ($rows as $row) {
				if (isset($row['title']) && isset($row['description'])) {
					$read_more = '';
					if (isset($row['link']))
						$read_more = carspot_ThemeBtn($row['link'], '', false);
					$facts_html	.=	'<div class="col-sm-12 col-md-4 col-xs-12 no-padding">
                        <div class="why-us border-box text-center">
                           <h5>' . $row['title'] . '</h5>
                           <p>' . $row['description'] . '
						   ' . $read_more . '
						   </p>
                        </div>
                     </div>';
				}
			}
		}

		$parallex	=	'';
		if ($section_bg == 'img') {
			$parallex	=	'parallex';
		}

		return '<section class="about-us ' . $parallex . ' ' . $bg_color . '" ' . $style . '>
            <div class="container-fluid">
               <div class="row">
			   ' . $header . '
                  <div class="col-md-12 no-padding"> ' . $facts_html . ' </div>
				</div>
			</div>
			</section>
	';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('why_us_short_base', 'why_us_short_base_func');
}
