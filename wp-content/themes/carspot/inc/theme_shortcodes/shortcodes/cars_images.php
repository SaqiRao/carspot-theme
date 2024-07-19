<?php
/* ------------------------------------------------ */
/* car_image */
/* ------------------------------------------------ */
if (!function_exists('car_image')) {
function car_image()
{
	vc_map(array(
		"name" => esc_html__("Additional Image ", 'carspot') ,
		"base" => "car_images_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('additional_image.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
			array(
				"group" => esc_html__("Basic", "carspot"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Background Image", 'carspot' ),
				"param_name" => "bg_img_static",
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
		
		
		  
	)
	
	);
}
}

add_action('vc_before_init', 'car_image');

if (!function_exists('car_images_short_base_func')) {
function car_images_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array('bg_img_static' => '','animation_effects' => '') , $atts));
	//animation
	$revail_animation = ''; 
	if(isset($animation_effects) && $animation_effects !="")
	{
		$revail_animation = $animation_effects;
	}
	
	if(wp_attachment_is_image($bg_img_static))
	{
		$bg_img_static =  carspot_returnImgSrc( $bg_img_static );
	}
	else
	{
		$bg_img_static =  get_template_directory_uri().'/images/additional_image.png';
	}
	
	if( isset( $bg_img_static ) && $bg_img_static !='' )
	{
		$bg_img_static = '<img alt="'.esc_html__('img','carspot').'" src="'.esc_url($bg_img_static).'" class="block-content wow '.$revail_animation.'" data-wow-delay="0ms" data-wow-duration="3500ms">';
	}
	return  '<div class="container"><div class="row">'.$bg_img_static.'</div></div>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('car_images_short_base', 'car_images_short_base_func');
}