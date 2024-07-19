<?php
/* ------------------------------------------------ */
/* Process Cycle */
/* ------------------------------------------------ */
if (!function_exists('process_cycle_short')) {
	function process_cycle_short()
	{
		vc_map(array(
			"name" => esc_html__("Process Cycle", 'carspot'),
			"base" => "process_cycle_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('process_cycle.png') .  esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
				// Step 1
				array(
					"group" => esc_html__("Step 1", "'carspot"),
					'type' => 'iconpicker',
					'heading' => esc_html__('Icon', 'carspot'),
					'param_name' => 's1_icon',
					'settings' => array(
						'emptyIcon' => false,
						'type' => 'classified',
						'iconsPerPage' => 100,
					),
				),
				array(
					"group" => esc_html__("Step 1", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title", 'carspot'),
					"param_name" => "s1_title",
				),
				array(
					"group" => esc_html__("Step 1", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Description", 'carspot'),
					"param_name" => "s1_description",
				),
				// Step 2
				array(
					"group" => esc_html__("Step 2", "'carspot"),
					'type' => 'iconpicker',
					'heading' => esc_html__('Icon', 'carspot'),
					'param_name' => 's2_icon',
					'settings' => array(
						'emptyIcon' => false,
						'type' => 'classified',
						'iconsPerPage' => 100,
					),
				),
				array(
					"group" => esc_html__("Step 2", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title", 'carspot'),
					"param_name" => "s2_title",
				),
				array(
					"group" => esc_html__("Step 2", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Description", 'carspot'),
					"param_name" => "s2_description",
				),
				// Step 3
				array(
					"group" => esc_html__("Step 3", "'carspot"),
					'type' => 'iconpicker',
					'heading' => esc_html__('Icon', 'carspot'),
					'param_name' => 's3_icon',
					'settings' => array(
						'emptyIcon' => false,
						'type' => 'classified',
						'iconsPerPage' => 100,
					),
				),
				array(
					"group" => esc_html__("Step 3", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Title", 'carspot'),
					"param_name" => "s3_title",
				),
				array(
					"group" => esc_html__("Step 3", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Description", 'carspot'),
					"param_name" => "s3_description",
				),


			),
		));
	}
}

add_action('vc_before_init', 'process_cycle_short');

if (!function_exists('process_cycle_short_base_func')) {
	function process_cycle_short_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'section_bg' => '',
			'header_style' => '',
			'section_title' => '',
			'section_title_regular' => '',
			'section_description' => '',
			's1_icon' => '',
			's1_title' => '',
			's1_description' => '',
			's2_icon' => '',
			's2_title' => '',
			's2_description' => '',
			's3_icon' => '',
			's3_title' => '',
			's3_description' => '',
		), $atts));

		if (isset($header_style)) {
			$main_title	=	'';
			if ($header_style == 'classic') {
				$main_title	=	$section_title;
			} else {
				$main_title	=	$section_title_regular;
			}
			$header	=	carspot_getHeader($main_title, $section_description, $header_style);
		}


		return '<section class="section-padding ' . $section_bg . '">
            <div class="container">
               <div class="row">
                  ' . $header . '
                  <div class="col-xs-12 col-md-12 col-sm-12 ">
                     <div class="row">
                        <div class="how-it-work text-center">
                           <div class="how-it-work-icon"> <i class="' . esc_attr($s1_icon) . '"></i> </div>
                           <h4>' . esc_html($s1_title) . '</h4>
                           <p>' . esc_html($s1_description) . '</p>
                        </div>
                        <div class="how-it-work text-center ">
                           <div class="how-it-work-icon"> <i class="' . esc_attr($s2_icon) . '"></i> </div>
                           <h4>' . esc_html($s2_title) . '</h4>
                           <p>' . esc_html($s2_description) . '</p>
                        </div>
                        <div class="how-it-work text-center">
                           <div class="how-it-work-icon "> <i class="' . esc_attr($s3_icon) . '"></i></div>
                           <h4>' . esc_html($s3_title) . '</h4>
                           <p>' . esc_html($s3_description) . '</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('process_cycle_short_base', 'process_cycle_short_base_func');
}
