<?php
if (!function_exists('about_us_simple')) {
function about_us_simple()
{
	vc_map(array(
		"name" => esc_html__("About Us Simple", 'carspot') ,
		"base" => "about_simple_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('classic.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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
				"group" => esc_html__("About Us", "'carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title_about",
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			array(
				"group" => esc_html__("About Us", "'carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			 array(
				"group" => esc_html__("About Us", "'carspot"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"heading" => esc_html__( "Image", 'carspot' ),
				"param_name" => "main_image",

			),
			array(
				"group" => esc_html__("About Us", "'carspot"),
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
			"group" => esc_html__("Animation", "carspot"),
			"type" => "dropdown",
			"class" => "",
			"description" =>  esc_html__('Animation Effects', 'carspot') . '<strong>' . esc_html__('warp text within this tag', 'carspot')  . '</strong>',
			"heading" => esc_html__( "Animation Effects", 'carspot' ),
			"param_name" => "animation_effects",
			"value" => carspot_revial_animations(),
		),   
		),
	));
}
}

add_action('vc_before_init', 'about_us_simple');
if (!function_exists('about_simple_func')) {
function about_simple_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	$html = '';	
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	//animation
	$revail_animation = ''; 
	if(isset($animation_effects) && $animation_effects !="")
	{
		$revail_animation = $animation_effects;
	}
	$img_left	=	''; $img_right	=	''; $left_column = '';
	$main_img	=	carspot_returnImgSrc( $main_image );
	if( isset( $main_img ) && $main_img !='' )
	{
		if($img_postion == 'left')
		{
			$img_left = '<div class="col-md-5 col-sm-12 col-xs-12"><div class="border-around"><img src="'.$main_img.'" class="wow '.$revail_animation.' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="'.esc_html__('Image Not Found','carspot').'"></div></div>';
		}
		else
		{
			$img_right = '<div class="col-md-5 col-sm-12 col-xs-12"><div class="border-around"><img src="'.$main_img.'" class="wow '.$revail_animation.' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="'.esc_html__('Image Not Found','carspot').'"></div></div>';
		}
	}
	$title = '';
	if(isset($section_title_about) && $section_title_about != '')
	{
		 $title = '<h2>'.carspot_color_text($section_title_about).'</h2>';
	}
	return '<section class="section-padding '.$parallex.' '.$bg_color.' '.$top_padding.'" id="about '.$style .'">
         <div class="container">
            <div class="row clearfix">
               <!--Column-->
			   '.$img_left.'
               <div class="col-md-7 col-sm-12 col-xs-12 ">
                  <div class="about-title">
                     '.$title.'
                     <p>'.$section_description.'</p>
                  </div>
               </div>
               <!-- RIght Grid Form -->
			   '.$img_right.'
            </div>
         </div>
      </section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('about_simple_base', 'about_simple_func');
}