<?php
/* ------------------------------------------------ */
/* Apps Classic */
/* ------------------------------------------------ */
if (!function_exists('app_classic_short')) {
function app_classic_short()
{
	vc_map(array(
		"name" => esc_html__("Apps - Classic", 'carspot') ,
		"base" => "app_classic_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('apps_classic.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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
			"group" => esc_html__("Basic", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Main Image", 'carspot' ),
			"param_name" => "app_img",
			"description" => esc_html__("400x500", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Tagline", 'carspot' ),
			"param_name" => "section_tag_line",
		),	
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'carspot' ),
			"param_name" => "section_title",
		),	
		
		array
		(
			'group' => esc_html__( 'Key Points', 'carspot' ),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Category', 'carspot' ),
			'param_name' => 'points',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => esc_html__( "Point", 'carspot' ),
					"param_name" => "title",
				),	

			)
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
			
			
		),
	));
}
}

add_action('vc_before_init', 'app_classic_short');

if (!function_exists('app_classic_short_base_func')) {
function app_classic_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'section_tag_line' => '',
		'app_img' => '',
		'a_tag_line' => '',
		'a_title' => '',
		'a_link' => '',
		'i_tag_line' => '',
		'i_title' => '',
		'i_link' => '',
		'points' => '',
	) , $atts));

		$rows = vc_param_group_parse_atts( $atts['points'] );
		$point_html	=	'';
		if( count((array) $rows ) > 0 )
		{
			$point_html .= '<ul>';
			foreach($rows as $row )
			{
				if( isset( $row['title'] ) )
				{
					$point_html .= '<li>'.$row['title'].'</li>';
				}
			}
			$point_html .= '</ul>';
		}

	
	$apps = '';
	if( $a_link != "" )
	{
		$apps .= '<div class="col-md-6">
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
		$apps .= '<div class="col-md-6">
                           <a href="'.esc_url($i_link).'" title="'.esc_attr($i_title).'" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-apple"></i>
                           <span>
                           <span>'.esc_html($i_tag_line).'</span> <span>'.esc_html($i_title).'</span> </span>
                           </span>
                           </a>
                        </div>';	
	}
	
$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	carspot_returnImgSrc( $bg_img );
$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}

$img_html = '';
if( $app_img != "" )
{
	$img_html = '<div class="mobile-image-content">
	<img src="'.carspot_returnImgSrc( $app_img ).'" alt="'.esc_html__('app image', 'carspot' ).'">
	</div>';
}

return '<div class="app-download-section style-2" '. $style .'>
            <div class="parallex">
               <div class="app-download-section-container">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           '.$img_html.'
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                           <div class="app-text-section">
                              <h5>'.esc_html($section_tag_line) .'</h5>
                              <h3>'.esc_html($section_title) .'</h3>
                              	'.$point_html.'
                              <div class="app-download-btn">
                                 <div class="row">
								 	'.$apps.'
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('app_classic_short_base', 'app_classic_short_base_func');
}