<?php
/* ------------------------------------------------ */
/* Search Simple */
/* ------------------------------------------------ */
if (!function_exists('search_simple_short')) {
function search_simple_short()
{
	vc_map(array(
		"name" => esc_html__("Search - Simple", 'carspot') ,
		"base" => "search_simple_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('search-simple.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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
			"description" => esc_html__( "%count% for total ads.", 'carspot' ),
			"param_name" => "section_title",
		),	
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Tagline", 'carspot' ),
			"param_name" => "section_tag_line",
		),	
		
		),
	));
}
}

add_action('vc_before_init', 'search_simple_short');
if (!function_exists('search_simple_short_base_func')) {
function search_simple_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'section_tag_line' => '',
	) , $atts));
	global $carspot_theme;

$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	carspot_returnImgSrc( $bg_img );
$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
$count_posts = wp_count_posts('ad_post');

$main_title = str_replace( '%count%', '<b>' .  $count_posts->publish . '</b>', $section_title);
return '<section class="simple-search" '.$style.'>
         <div class="container">
		    <h1>'.$main_title.'</h1>
            <p>'.esc_html($section_tag_line).'</p>
            <div class="search-holder">
               <div id="custom-search-input">
				  <form method="get" action="'.get_the_permalink($carspot_theme['sb_search_page']).'">
				  <div class="col-md-11 col-sm-11 col-xs-11 no-padding">
                     <input type="text" autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control " placeholder="'.esc_html__('What Are You Looking For...','carspot').'" />
				</div>
				<div class="col-md-1 col-sm-1 col-xs-1 no-padding">	 
                     <button class="btn btn-theme" type="submit"> <span class=" glyphicon glyphicon-search"></span> </button>
				</div>	
				'. cs_form_lang_field_callback(true) .' 
					</form>
               </div>
            </div>
         </div>
      </section>
';

}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('search_simple_short_base', 'search_simple_short_base_func');
}