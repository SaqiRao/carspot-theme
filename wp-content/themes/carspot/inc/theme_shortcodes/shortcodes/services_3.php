<?php
/* ------------------------------------------------ */
/* Services */ 
/* ------------------------------------------------ */
if (!function_exists('services_3_short')) {
function services_3_short()
{
	vc_map(array(
		"name" => esc_html__("Services Style 3", 'carspot') ,
		"base" => "services_3_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('services_3.png') .  esc_html__( 'Output of the shortcode will be look like this.', 'carspot' ),
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
		   'heading' => esc_html__('Select Services', 'carspot'),
		   'param_name' => 'services',
		   'value' => '',
		   'params' => array(
				array(
					"group" => esc_html__("Service Image", "carspot"),
					"type" => "attach_image",
					"holder" => "bg_imag",
					"class" => "",
					"description" =>  esc_html__('For Service Image ', 'carspot'),
					"heading" => esc_html__( "Service Image", 'carspot' ),
					"param_name" => "service_img"
				),
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Service Title", 'carspot' ),
				  "param_name" => "serv_title",
				),	
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Description", 'carspot' ),
				  "param_name" => "serv_desc",
				),
		   )
		  ),
		  
		),
	));
}
}

add_action('vc_before_init', 'services_3_short');
if (!function_exists('services_3_short_base_func')) {
function services_3_short_base_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	$html = '';	
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	$ext_single_serv = '';
	$serImageURL ='';
	
	$rows = vc_param_group_parse_atts( $atts['services'] );
	
	if( count((array) $rows ) > 0 )
	{
	
		foreach($rows as $row1 )
		{
			if( isset( $row1['serv_title'] ) && isset( $row1['serv_desc'] ) )
			{
				$serImageURL	=	carspot_returnImgSrc( $row1['service_img'] );
				$ext_single_serv .= '<div class="col-lg-3 col-xs-12 col-md-3 col-sm-3">
            <div class="services-box-section">
              <div class="services-main-content">
                <div class="services-icons-section">
				<img src="'.$serImageURL.'" alt="'.__( 'image not found', 'carspot' ).'" class="img-responsive"> </div>
                <h3>'.$row1['serv_title'].'</h3>
                <p>'.$row1['serv_desc'].'</p>
              </div>
            </div>
          </div>';	
			}
		}
	}
	return '<section class="our-best-services section-style-divider-2 opacity-color '.$parallex.' '.$bg_color.' '.$top_padding.'" ' . $style .' >
            <div class="container">
			   '.$header.'
			<div class="row clearfix">
                  <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
					<div class="services-wrapped-section">
					  '.$ext_single_serv.'
					</div>
				  </div>
               </div>
			</div>
			</section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('services_3_short_base', 'services_3_short_base_func');
}