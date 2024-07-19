<?php
/* ------------------------------------------------ */
/* Process */
/* ------------------------------------------------ */
vc_map( array(
	"name" => __("Process", 'carspot') ,
	"description" => __("Process", 'carspot') ,
	"base" => "process",
	"category" => __("Theme Shortcodes", 'carspot') ,
	"as_child" => array('only' => 'sticky_sidebar'),
	"content_element" => true,	    
	"params" => array(	
		array(
		   'group' => __( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('process.png') . __( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
	  array
		(
			'group' => __( 'Steps', 'carspot' ),
			'type' => 'param_group',
			'heading' => __( 'Add Step', 'carspot' ),
			'param_name' => 'steps',
			'value' => '',
			'params' => array
			(

				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => __( "Title", 'carspot' ),
					"param_name" => "title",
				),	
				array(
					"type" => "textarea",
					"holder" => "div",
					"heading" => __( "Description", 'carspot' ),
					"param_name" => "description",
				),
				
				array(
					"type" => "attach_image",
					"holder" => "img",
					"heading" => __( "Background Image", 'carspot' ),
					"param_name" => "img",
					"description" => __( "64X64", 'carspot' ),
				),
			),
		),


    ),
) );