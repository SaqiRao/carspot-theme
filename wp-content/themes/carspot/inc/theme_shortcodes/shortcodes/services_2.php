<?php
/* ------------------------------------------------ */
/* Services Style 2 */ 
/* ------------------------------------------------ */
if (!function_exists('services_short_2')) {
function services_short_2()
{
	vc_map(array(
		"name" => esc_html__("Services Style 2", 'carspot') ,
		"base" => "services_short_base_2",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('services_grid_2.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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
		   'group' => esc_html__('Services Left', 'carspot') ,
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
		  
		  array(
		   'group' => esc_html__('Services Right', 'carspot') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('Select Services', 'carspot') ,
		   'param_name' => 'services_add_right',
		   'value' => '',
		   'params' => array(
				
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Title Of Service", 'carspot' ),
				  "param_name" => "serv_title_right",
				),	
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Description", 'carspot' ),
				  "param_name" => "serv_desc_right",
				),
				

			 array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'carspot' ),
				 'param_name' => 'icon_right',
				'settings' => array(
				 'emptyIcon' => false,
				 'type' => 'classified',
				 'iconsPerPage' => 100, // default 100, how many icons per/page to display
				 ),
             ),
		   )
		  ),
		  
		array(
			"group" => esc_html__("Service Image", "carspot"),
			"type" => "dropdown",
			"class" => "",
			"description" =>  esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
			"heading" => esc_html__( "Animation Effects", 'carspot' ),
			"param_name" => "animation_effects",
			"value" => carspot_revial_animations(),
		),    
		
		array(
			"group" => esc_html__("Service Image", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_imag",
			"class" => "",
			"description" =>  esc_html__('For Service Image ', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
			"heading" => esc_html__( "Service Image", 'carspot' ),
			"param_name" => "service_img"
		), 
		
		
			
		),
	));
}
}

add_action('vc_before_init', 'services_short_2');

if (!function_exists('services_short_base_func_2')) {
function services_short_base_func_2($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	$html = '';	
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	
	$revail_animation = ''; 
	if(isset($animation_effects) && $animation_effects !="")
	{
		$revail_animation = $animation_effects;
	}
	
	$left_column = ''; $right_column = '';
	//Left Services Column
	$rows = vc_param_group_parse_atts( $atts['services_add_left'] );
	if( count((array) $rows ) > 0 )
	{
	
		foreach($rows as $row )
		{
			if( isset( $row['serv_title'] ) && isset( $row['serv_desc'] ) )
			{
				$left_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="'.$row['icon'].'"></i></div>
                        <h4>'.$row['serv_title'].'</h4>
                        <p>'.$row['serv_desc'].'</p>
                     </div>';	
			}
		}
	}
	
	//Right Services Column
	$rows2 = vc_param_group_parse_atts( $atts['services_add_right'] );
	if( count((array) $rows ) > 0 )
	{
	
		foreach($rows2 as $row1 )
		{
			if( isset( $row1['serv_title_right'] ) && isset( $row1['serv_desc_right'] ) )
			{
				$right_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="'.$row1['icon_right'].'"></i></div>
                        <h4>'.$row1['serv_title_right'].'</h4>
                        <p>'.$row1['serv_desc_right'].'</p>
                     </div>';	
			}
		}
	}
	
	//Service Image
	$main_img	=	'';
	$img_src =  carspot_returnImgSrc($service_img);
	if( isset( $img_src ) && ($img_src != "") )
	{
		          $main_img.=  '<figure class="wow '.$revail_animation.'  animated" data-wow-delay="0ms" data-wow-duration="3500ms" >
                        <img class="center-block" src="'.$img_src.'" alt="'. esc_html__('Image Not Available', 'carspot')  . '">
                     </figure>';	
	}
	
	$flip_it = '';
	if( is_rtl() )
	{
		$flip_it = 'flip';
	}
	
	return '<section class="padding-top-90 services-center '.$parallex.' '.$bg_color.'" ' . $style .' >
            <div class="container">
			   '.$header.'
			<div class="row clearfix">
                  <div class="col-md-4 col-sm-6 col-xs-12 pull-left '.$flip_it.'">
				  '.$left_column.'
				  </div>
                  
                  <!--Right Column-->
                  <div class="col-md-4 col-sm-6 col-xs-12 pull-right '.$flip_it.'">
                    '.$right_column.'
                  </div>
                  <!--Image Column-->
                  <div class="col-md-4 col-sm-12 col-xs-12">
                     '.$main_img.'
                  </div>
               </div>
			</div>
			</section>';
}
}
if (function_exists('carspot_add_code'))
{
	carspot_add_code('services_short_base_2', 'services_short_base_func_2');
}