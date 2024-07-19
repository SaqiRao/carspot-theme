<?php
/* ------------------------------------------------ */
/* Call to Action */
/* ------------------------------------------------ */
if (!function_exists('call_to_action_short')) {
function call_to_action_short()
{
	vc_map(array(
		"name" => esc_html__("Call to Action", 'carspot') ,
		"base" => "call_to_action_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('call_to_action.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'carspot' ),
			"param_name" => "title",
		),	
		array(
			"type" => "vc_link",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Read More Link", 'carspot' ),
			"param_name" => "link",
		),	
	),
	));
}
}


add_action('vc_before_init', 'call_to_action_short');
if (!function_exists('call_to_action_short_base_func')) {
function call_to_action_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	) , $atts));
return '<div class="parallex-small ">
         <div class="container">
            <div class="row">
               <div class="col-md-8 col-xs-12 col-sm-8">
                  <div class="parallex-text">
                     <h4>'.esc_html($title) .'</h4>
                  </div>
               </div>
               <div class="col-md-4 col-sx-12 col-sm-4">
                  <div class="parallex-button">
				   '.carspot_ThemeBtn($link, 'btn btn-lg btn-theme', false, '', '<i class="fa fa-angle-double-right "></i>').'
				   </div>
               </div>
            </div>
         </div>
      </div>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('call_to_action_short_base', 'call_to_action_short_base_func');
}