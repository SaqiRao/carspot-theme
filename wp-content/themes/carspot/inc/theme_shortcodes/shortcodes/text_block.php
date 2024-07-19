<?php
/* ------------------------------------------------ */
/* Text Blog */
/* ------------------------------------------------ */
if (!function_exists('ad_text_block_short')) {
function ad_text_block_short()
{
	vc_map(array(
		"name" => esc_html__("Text Block", 'carspot') ,
		"base" => "ad_text_block_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "dropdown",
			"heading" => esc_html__("Background Color", 'carspot') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select Background Color', 'carspot') => '',
				esc_html__('White', 'carspot') => '',
				esc_html__('Gray', 'carspot') => 'gray',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Select background color.", 'carspot'),
		),
		
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'carspot' ),
			"param_name" => "bg_img",
			'dependency' => array(
			'element' => 'section_bg',
			'value' => array('img'),
			) ,
		),
		
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "dropdown",
				"heading" => esc_html__("Header Style", 'carspot') ,
				"param_name" => "header_style",
				"admin_label" => true,
				"value" => array(
				esc_html__('Section Header Style', 'carspot') => '',
				esc_html__('No Header', 'carspot') => '',
				esc_html__('Classic', 'carspot') => 'classic',
				esc_html__('Regular', 'carspot') => 'regular'
				) ,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				"std" => '',
				"description" => esc_html__("Chose header style.", 'carspot'),
			),
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title",
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . esc_html('{color}') . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic'),
				) ,
			),	
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title_regular",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('regular'),
				) ,
			),	
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic'),
				) ,
			),
			array(
				"group" => esc_html__("Contents", "'carspot"),
				"type" => "textarea_html",
				"holder" => "div",
				"param_name" => "content",
			),	
			
			
		),
	));
}
}

add_action('vc_before_init', 'ad_text_block_short');

if (!function_exists('ad_text_block_short_base_func')) {
function ad_text_block_short_base_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	
	return '<section class="advertizing '.$bg_color.'">
            <div class="container">
               <div class="row">
			   		'.$header.'
                  <div class="col-md-12 col-xs-12 col-sm-12 post-excerpt post-desc">'.$content.'</div>
               </div>
            </div>
         </section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('ad_text_block_short_base', 'ad_text_block_short_base_func');
}