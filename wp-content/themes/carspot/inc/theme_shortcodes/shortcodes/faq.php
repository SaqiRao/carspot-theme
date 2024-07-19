<?php
/* ------------------------------------------------ */
/* Faq */
/* ------------------------------------------------ */
if (!function_exists('faq_short')) {
	function faq_short()
	{
		vc_map(array(
			"name" => esc_html__("FAQ", 'carspot'),
			"base" => "faq_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('faq.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
					'group' => esc_html__('FAQ', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Question & Answer', 'carspot'),
					'param_name' => 'cats',
					'value' => '',
					'params' => array(
						array(
							"type" => "textfield",
							"heading" => esc_html__("Question", 'carspot'),
							"param_name" => "title",
							"admin_label" => true,
						),
						array(
							"type" => "textarea",
							"heading" => esc_html__("Answer", 'carspot'),
							"param_name" => "description",
							"admin_label" => true,
						),

					)
				),

				// Making add more loop for tips

				array(
					'group' => esc_html__('Saftey Tips', 'carspot'),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "tip_section_title",
				),

				array(
					'group' => esc_html__('Saftey Tips', 'carspot'),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Description", 'carspot'),
					"param_name" => "tips_description",
				),

				array(
					'group' => esc_html__('Saftey Tips', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Add Tip', 'carspot'),
					'param_name' => 'tips',
					'value' => '',
					'params' => array(
						carspot_generate_type(esc_html__('Tip', 'carspot'), 'textarea', 'description'),
					)
				),

			),
		));
	}
}

add_action('vc_before_init', 'faq_short');

if (!function_exists('faq_short_base_func')) {
	function faq_short_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

		global $carspot_theme;

		$bg_bootom	=	'yes';
		$rows = vc_param_group_parse_atts($atts['cats']);
		$faq_html	=	'';
		if (count((array) $rows) > 0) {
			$faq_html .= '<ul class="accordion">';
			foreach ($rows as $row) {
				if (isset($row['title']) && isset($row['description'])) {
					$faq_html .= '<li>
                           <h3 class="accordion-title"><a href="#">' . esc_html($row['title']) . '</a></h3>
                           <div class="accordion-content">
                              <p>' . esc_html($row['description']) . '</p>
                           </div>
                        </li>';
				}
			}
			$faq_html .= '</ul>';
		}

		// Making tips
		$rows = vc_param_group_parse_atts($atts['tips']);
		$tips	=	'';
		if (count((array) $rows) > 0) {
			foreach ($rows as $row) {
				if (isset($row['description'])) {
					$tips	.=	'<li>' . $row['description'] . '</li>';
				}
			}
		}


		$parallex	=	'';
		if ($section_bg == 'img') {
			$parallex	=	'parallex';
		}

		return '<section class="section-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
            <div class="container">
               <div class="row">
				   ' . $header . '
                  <div class="col-md-8 col-xs-12 col-sm-12">
				  	' . $faq_html . '
				  </div>
				  <div class="col-md-4 col-xs-12 col-sm-12">
                     <div class="blog-sidebar">
                        <div class="widget">
                           <div class="widget-heading">
                              <h4 class="panel-title"><a>' . $tip_section_title . ' </a></h4>
                           </div>
                           <div class="widget-content">
                               <p class="lead">' . $tips_description . '</p>
                              <ol>' . $tips . ' </ol>
                           </div>
                        </div>
                     </div>
                  </div>
			  </div>
		  </div>
	   </section>
';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('faq_short_base', 'faq_short_base_func');
}
