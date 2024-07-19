<?php
/* ------------------------------------------------ */
/* advertisement */
/* ------------------------------------------------ */
vc_map( array(
	"name" => __("Advertisement", 'carspot') ,
	"description" => __("Banner Ad 720x90", 'carspot') ,
	"base" => "advertisement",
	"category" => __("Theme Shortcodes", 'carspot') ,
	"as_child" => array('only' => 'sticky_sidebar'),
	"content_element" => true,
	"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('advertisement.png') . __( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
			array(
				"type" => "textarea_raw_html",
				"holder" => "div",
				"heading" => __( "Banner Ad 720x90", 'carspot' ),
				"param_name" => "ad_720",
				"description" => __("Ad size 720 X 90", 'carspot'),
			),	
		),
	) );