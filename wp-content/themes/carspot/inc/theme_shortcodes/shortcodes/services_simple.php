<?php
if (!function_exists('services_short_simple')) {
function services_short_simple()
{
	vc_map(array(
		"name" => esc_html__("Services Simple", 'carspot') ,
		"base" => "services_short_base_simple",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('services_grid.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
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
				esc_html__('Image', 'carspot') => 'img'
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Select background color.", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "dropdown",
			"heading" => esc_html__("Section Top Padding", 'carspot') ,
			"param_name" => "section_padding",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select Section Padding', 'carspot') => '',
				esc_html__('No', 'carspot') => '',
				esc_html__('Yes', 'carspot') => 'yes',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Remove Padding From Section Top.", 'carspot'),
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
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic', 'regular'),
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
				'value' => array('classic', 'regular'),
				) ,
			),
			array(
		   'group' => esc_html__('Services', 'carspot') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('Select Services', 'carspot') ,
		   'param_name' => 'services_add_left',
		   'value' => '',
		   'params' => array(
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Title Of Service", 'carspot' ),
				  "param_name" => "serv_title",
				),	
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Description", 'carspot' ),
				  "param_name" => "serv_desc",
				),
			 array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'carspot' ),
				 'param_name' => 'icon',
				'settings' => array(
				 'emptyIcon' => false,
				 'type' => 'classified',
				 'iconsPerPage' => 100, // default 100, how many icons per/page to display
				 ),
             ),
		   )
		  ),
		),
	));
}
}
add_action('vc_before_init', 'services_short_simple');
if (!function_exists('services_short_base_func_simple')) {
function services_short_base_func_simple($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	$html = '';	
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	//Left Services Column
	$rows = vc_param_group_parse_atts( $atts['services_add_left'] );
	if( count((array) $rows ) > 0 )
	{
		$counter = 0;
		foreach($rows as $row )
		{
			if( isset( $row['serv_title'] ) && isset( $row['serv_desc'] ) )
			{
				$html .= '
								<div class="col-md-4 col-xs-12 col-sm-6">
								 <!-- services grid -->
								 <div class="services-grid-new">
									<div class="icons"> <i class="'.$row['icon'].'"></i></div>
									<h4>'.$row['serv_title'].'</h4>
									<p>'.$row['serv_desc'].'</p>
								 </div>
								</div>';
				if(++$counter % 3 == 0)
				{
					$html .= '<div class="clearfix"></div>';
				}				
			}
		}
	}
	return '<section class="custom-padding services '.$parallex.' '.$bg_color.' '.$top_padding.'" ' . $style .' >
            <div class="container">
			   '.$header.'
			<div class="row clearfix">
				 <div id="services-3">
					  '.$html.'
				  </div>
			 </div>  
			</div>
			</section>';
}
}
if (function_exists('carspot_add_code'))
{
	carspot_add_code('services_short_base_simple', 'services_short_base_func_simple');
}