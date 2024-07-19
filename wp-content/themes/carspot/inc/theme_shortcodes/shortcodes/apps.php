<?php
/* ------------------------------------------------ */
/* Apps */
/* ------------------------------------------------ */
if (!function_exists('apps_short')) {
function apps_short()
{
	vc_map(array(
		"name" => esc_html__("Apps - Simple", 'carspot') ,
		"base" => "apps_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('apps.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'carspot' ),
			"param_name" => "bg_img",
			"description" => esc_html__("1280x480", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'carspot' ),
			"param_name" => "section_title",
		),	
		// Android
		array(
			"group" => esc_html__("Android", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tag Line", 'carspot' ),
			"param_name" => "a_tag_line",
		),	
		array(
			"group" => esc_html__("Android", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'carspot' ),
			"param_name" => "a_title",
		),	
		array(
			"group" => esc_html__("Android", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Download Link", 'carspot' ),
			"param_name" => "a_link",
		),	
		// IOS
		array(
			"group" => esc_html__("IOS", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tag Line", 'carspot' ),
			"param_name" => "i_tag_line",
		),	
		array(
			"group" => esc_html__("IOS", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'carspot' ),
			"param_name" => "i_title",
		),	
		array(
			"group" => esc_html__("IOS", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Download Link", 'carspot' ),
			"param_name" => "i_link",
		),	
		// Windows
		array(
			"group" => esc_html__("Windows", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tag Line", 'carspot' ),
			"param_name" => "w_tag_line",
		),	
		array(
			"group" => esc_html__("Windows", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'carspot' ),
			"param_name" => "w_title",
		),	
		array(
			"group" => esc_html__("Windows", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Download Link", 'carspot' ),
			"param_name" => "w_link",
		),	
			
			
		),
	));
}
}

add_action('vc_before_init', 'apps_short');

if (!function_exists('apps_short_base_func')) {
function apps_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'a_tag_line' => '',
		'a_title' => '',
		'a_link' => '',
		'w_tag_line' => '',
		'w_title' => '',
		'w_link' => '',
		'i_tag_line' => '',
		'i_title' => '',
		'i_link' => '',
	) , $atts));

	
	
	$apps = '';
	$count = 0;
	if( $a_link != "" )
	{
		$count++;
		$apps .= '<div class="col-md-4">
                           <a href="'.esc_url($a_link).'" title="'.esc_attr($a_title).'" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-android"></i>
                           <span>
                           <span>'.esc_html($a_tag_line).'</span> <span>'.esc_html($a_title).'</span> </span>
                           </span>
                           </a>
                        </div>';	
	}
	if( $i_link != "" )
	{
		$count++;
		$apps .= '<div class="col-md-4">
                           <a href="'.esc_url($i_link).'" title="'.esc_attr($i_title).'" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-apple"></i>
                           <span>
                           <span>'.esc_html($i_tag_line).'</span> <span>'.esc_html($i_title).'</span> </span>
                           </span>
                           </a>
                        </div>';	
	}
	if( $w_link != "" )
	{
		$count++;
		$apps .= '<div class="col-md-4">
                           <a href="'.esc_url($w_link).'" title="'.esc_attr($w_title).'" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-windows"></i>
                           <span>
                           <span>'.esc_html($w_tag_line).'</span> <span>'.esc_html($w_title).'</span> </span>
                           </span>
                           </a>
                        </div>';	
	}
	
	$off_set	=	'';
	if( $count == 1 )
	{
		$off_set = 'col-md-offset-4';
	}
	else if( $count == 2 )
	{
		$off_set = 'col-md-offset-2';
	}
	else if( $count == 3 )
	{
		$off_set = '';
	}
	
	
$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	carspot_returnImgSrc( $bg_img );
$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
	return ' <div class="app-download-section parallex" '. $style .'>
            <div class="app-download-section-wrapper">
               <div class="app-download-section-container">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="section-title"> <span>'.$section_title.'</span></div>
                        </div>
						<div class="col-md-12 '.$off_set.'">
						'.$apps.'
						</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
	
	';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('apps_short_base', 'apps_short_base_func');
}