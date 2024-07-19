<?php
/* ------------------------------------------------ */
/* Popular Cats */
/* ------------------------------------------------ */
if (!function_exists('popular_cats_short')) {
	function popular_cats_short()
	{
		vc_map(array(
			"name" => esc_html__("Popular - Categories", 'carspot'),
			"base" => "popular_cats_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('popular_cats.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "attach_image",
					"holder" => "img",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
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
				),

				array(
					'group' => esc_html__('Categories', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Select Category', 'carspot'),
					'param_name' => 'cats',
					'value' => '',
					'params' => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Category", 'carspot'),
							"param_name" => "cat",
							"admin_label" => true,
							"value" => carspot_cats('ad_cats', 'no'),
						),
						array(
							'type' => 'iconpicker',
							'heading' => esc_html__('Icon', 'carspot'),
							'param_name' => 'icon',
							'settings' => array(
								'emptyIcon' => false,
								'type' => 'classified',
								'iconsPerPage' => 100,
							),
						),

					)
				),

			),
		));
	}
}

add_action('vc_before_init', 'popular_cats_short');

if (!function_exists('popular_cats_short_base_func')) {
	function popular_cats_short_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'bg_img' => '',
			'section_title' => '',
			'section_description' => '',
			'cats' => '',
		), $atts));
		global $carspot_theme;

		$rows = vc_param_group_parse_atts($atts['cats']);
		$categories_html	=	'';
		if (count((array) $rows) > 0) {
			$categories_html .= '<ul class="nav nav-tabs">';
			foreach ($rows as $row) {
				if (isset($row['cat']) && isset($row['icon'])) {

					$categories_html .= '<li class="clearfix">
                     <a href="' . get_the_permalink($carspot_theme['sb_search_page']) . '?cat_id=' . $row['cat'] . '"> <i class="' . esc_attr($row['icon']) . '"></i> <span class="hidden-xs">' . get_cat_name($row['cat']) . '</span></a>
                  </li>';
				}
			}
			$categories_html .= '</ul>';
		}
		$style = '';
		if ($bg_img != "") {
			$bgImageURL	=	carspot_returnImgSrc($bg_img);
			$style = ($bgImageURL != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
		}
		return '<section id="hero" class="hero" ' . $style . '>
         <div class="content">
            <p>' . carspot_color_text($section_title) . '</p>
            <h1>' . esc_html($section_description) . '</h1>
            <div class="search-holder">
			' . $categories_html . '
            </div>
         </div>
      </section>
';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('popular_cats_short_base', 'popular_cats_short_base_func');
}
