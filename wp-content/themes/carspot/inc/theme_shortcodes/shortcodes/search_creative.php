<?php
/* ------------------------------------------------ */
/* Home - Hero Section */ 
/* ------------------------------------------------ */
if (!function_exists('search_creative')) {
function search_creative()
{
	vc_map(array(
		"name" => esc_html__("Home - Hero Section", 'carspot') ,
		"base" => "search_creative",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('home-defualt.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'carspot' ),
			"param_name" => "bg_img",
			"description" => esc_html__("1280x800", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'carspot' ),
			"param_name" => "section_title",
		),	
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Tagline", 'carspot' ),
			"description" => esc_html__( "%count% for total ads.", 'carspot' ),
			"param_name" => "section_tag_line",
		),
		array(
		"group" => esc_html__("Basic", "'carspot"),
			"type" => "vc_link",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Button Title", 'carspot' ),
			"param_name" => "link",
		),
		
		),
	));
}
}

add_action('vc_before_init', 'search_creative');
if (!function_exists('search_creative_short_base_func')) {
function search_creative_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'section_tag_line' => '',
		'button_title' => '',
		'link' => '',
	) , $atts));
	global $carspot_theme;
	
$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	carspot_returnImgSrc( $bg_img );
$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
$count_posts = wp_count_posts('ad_post');
   return   ' <div id="banner" '.$style.'>
         <div class="container">
            <div class="search-container">
               <h2>'.esc_html($section_title).'</h2>
               <p>'.str_replace( '%count%', '<strong>'.$count_posts->publish.'</strong>', $section_tag_line).'</p>
              '.carspot_ThemeBtn($link, 'btn btn-theme', false, '', '').'
            </div>
         </div>
      </div>';
}
}
if (function_exists('carspot_add_code'))
{
	carspot_add_code('search_creative', 'search_creative_short_base_func');
}