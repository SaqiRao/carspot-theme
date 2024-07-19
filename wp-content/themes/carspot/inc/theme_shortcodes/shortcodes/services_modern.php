<?php
/* ------------------------------------------------ */
/* Services Modern */
/* ------------------------------------------------ */
if (!function_exists('services_modern')) {
function services_modern()
{
	vc_map(array(
		"name" => esc_html__("Services Modern", 'carspot') ,
		"base" => "services_modern_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('services_modern.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		
		array(
			"group" => esc_html__("Background Images", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image Left Side", 'carspot' ),
			"param_name" => "bg_img1",
			"description" => esc_html__("Recommended Size For Image should be 792x637.jpg", 'carspot'),
		),
		
		array(
			"group" => esc_html__("Background Images", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image Right Side", 'carspot' ),
			"param_name" => "bg_img2",
			"description" => esc_html__("Recommended Size For Image should be 1200x637.jpg", 'carspot'),
		),
		
		
		array(
				"group" => esc_html__("Services", "'carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title_about",
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			
			
			
			array(
				"group" => esc_html__("Services", "'carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			 array(
				"group" => esc_html__("Services", "'carspot"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"heading" => esc_html__( "Car Image", 'carspot' ),
				"param_name" => "main_image",
				"description" => esc_html__("Recommended Size For Image should be 715x215.png", 'carspot'),
			),
			
			array(
				"group" => esc_html__("Services", "'carspot"),
				"type" => "dropdown",
				"heading" => esc_html__("Select Image Position", 'carspot') ,
				"param_name" => "img_postion",
				"admin_label" => true,
				"value" => array(
				esc_html__('Left Side', 'carspot') => 'left',
				esc_html__('Right Side', 'carspot') => 'right'
				) ,
				"description" => esc_html__("Chose image position.", 'carspot'),
			),
			 array(
			"group" => esc_html__("Services", "'carspot"),
			"type" => "dropdown",
			"class" => "",
			"description" =>  esc_html__('Car Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
			"heading" => esc_html__( "Animation Effects", 'carspot' ),
			"param_name" => "animation_effects",
			"value" => carspot_revial_animations(),
		), 
		
		array(
				"group" => esc_html__("Services", "'carspot"),
				"type" => "dropdown",
				"class" => "",
				"description" =>  esc_html__('Services Box Animation', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
				"heading" => esc_html__( "Animation Effects", 'carspot' ),
				"param_name" => "animation_effects2",
				"value" => carspot_revial_animations(),
			), 
			
		  
		  array(
		   'group' => esc_html__('Services List', 'carspot') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('Select Services', 'carspot') ,
		   'param_name' => 'services_add_left',
		   'value' => '',
		   'params' => array(
		   
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
				 
				 array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Count", 'carspot' ),
				  "param_name" => "client_tagline",
				),	
				
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
				
				
		   )
		  ),

			
		),
	));
}
}

add_action('vc_before_init', 'services_modern');

if (!function_exists('services_modern_func')) {
function services_modern_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	
	$img_left	=	''; $img_right	=	''; $left_column = ''; $bgImageURL = ''; $background_img1 = ''; $background_img2 = ''; $bgImageURL2 = ''; $$client_tagline = '';
	
	
	//animation
	$revail_animation = ''; 
	if(isset($animation_effects) && $animation_effects !="")
	{
		$revail_animation = $animation_effects;
	}
	//animation
	$revail_animation2 = ''; 
	if(isset($animation_effects2) && $animation_effects2 !="")
	{
		$revail_animation2 = $animation_effects2;
	}
	
	if(wp_attachment_is_image($main_image))
	{
		$main_img	=	carspot_returnImgSrc( $main_image );
	}
	else
	{
		$main_img =  get_template_directory_uri().'/images/sell-1.png';
	}
	if( isset( $main_img ) && $main_img !='' )
	{
		if($img_postion == 'left')
		{
			$img_left = '<img alt="'.esc_html__('Image Not Found','carspot').'" src="'.$main_img.'" class="img-responsive wow '.$revail_animation.' custom-img-left" data-wow-delay="0ms" data-wow-duration="2000ms">';
			
		}
		else
		{
			$img_right = '<img alt="'.esc_html__('Image Not Found','carspot').'" src="'.$main_img.'" class="img-responsive wow '.$revail_animation.' custom-img" data-wow-delay="0ms" data-wow-duration="2000ms">';
			$column_left = '';
		}
	}
	
	if( isset( $bg_img1 ) && $bg_img1 !='' )
	{
		$bgImageURL	=	carspot_returnImgSrc( $bg_img1 );
		$background_img1 = 'style="background-image: url('.$bgImageURL.');background-position: center top;background-repeat: no-repeat;background-size: cover;height: 100%;left: 0;margin-left: -10%;position: absolute;top: 0;width: 50%;z-index: 1;"';
	}
	
	if( isset( $bg_img2 ) && $bg_img2 !='' )
	{
		$bgImageURL2	=	carspot_returnImgSrc( $bg_img2 );
		$background_img2 = 'style=" background-image: url('.$bgImageURL2.');background-position: center center;background-repeat: no-repeat;background-size: cover;height: 100%;position: absolute;right: 0;top: 0;width: 80%;"';
	}
	
	
	
	
	$title = '';
	if(isset($section_title_about) && $section_title_about != '')
	{
		 $title = '<h2>'.($section_title_about).'</h2>';
	}
	
	$rows = vc_param_group_parse_atts( $atts['services_add_left'] );
	if( count((array) $rows ) > 0 )
	{
		foreach($rows as $row )
		{
			if( isset( $row['serv_title'] ) && isset( $row['serv_desc'] ) )
			{
				if(isset($row['client_tagline']))
				{
					$client_tagline = $row['client_tagline'];
				}
				$left_column .= '
				 <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="services-grid-3">
                          <div class="content-area">
						        <h1>'.$client_tagline.'</h1>
								<a href="javascript:void(0)">
								   <h4>'.$row['serv_title'].'</h4>
								</a>
                                <p>'.$row['serv_desc'].'</p>
								<div class="service-icon">
                                      <i class="'.$row['icon'].'"></i>
                                </div>
						</div>
				   </div>
				 </div>';
			}
		}
	}
	
return '<section class="section-padding-120 our-services">
            <div class="background-1" '.$background_img1.'></div>
            <div class="background-2" '.$background_img2.'></div>
            '.$img_left.'
		    '.$img_right.'
            <div class="container">
               <div class="row clearfix">
                  <div class="left-column col-lg-4 col-md-4 col-md-12">
                     <div class="inner-box">
                         '.$title.'
                        <div class="text">'.$section_description.'</div>
                     </div>
                  </div>
                  <div class="service-column col-lg-8 col-md-12">
                     <div class="inner-box wow '.$revail_animation2.' animated" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="row clearfix">
                           '.$left_column.'
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('services_modern_base', 'services_modern_func');
}