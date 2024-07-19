<?php
/* ------------------------------------------------ */
/* Ads */
/* ------------------------------------------------ */
vc_map( array(
	"name" => __("Ads", 'carspot') ,
	"description" => __("Featured or Simple Ads", 'carspot') ,
	"base" => "carspot_ads",
	"category" => __("Theme Shortcodes", 'carspot') ,
	"as_child" => array('only' => 'sticky_sidebar'),
	"content_element" => true,
	"params" => array(
	
		array(
		"group" => __("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"heading" => __( "Title", 'carspot' ),
			"param_name" => "s_title",
		),	
		array(
			"group" => __("Basic", "'carspot"),
			"type" => "dropdown",
			"heading" => __("Ads Type", 'carspot') ,
			"param_name" => "ad_type",
			"admin_label" => true,
			"value" => array(
			__('Select Ads Type', 'carspot') => '',
			__('Featured Ads', 'carspot') => 'feature',
			__('Simple Ads', 'carspot') => 'regular'
			) ,
		),
		array(
			"group" => __("Basic", "'carspot"),
			"type" => "dropdown",
			"heading" => __("Layout Type", 'carspot') ,
			"param_name" => "layout_type",
			"admin_label" => true,
			"value" => array(
			__('Select Layout Type', 'carspot') => '',
			__('Slider (Use once on a page.)', 'carspot') => 'slider',
			__('Grid 1', 'carspot') => 'grid_1',
			__('Grid 2', 'carspot') => 'grid_2',
			__('Grid 3', 'carspot') => 'grid_3',
			__('List 1', 'carspot') => 'list_1',
			__('List 2', 'carspot') => 'list_2',
			__('List 3', 'carspot') => 'list_3',
			) ,
		),
		array(
			"group" => __("Basic", "'carspot"),
			"type" => "dropdown",
			"heading" => __("Number fo Ads", 'carspot') ,
			"param_name" => "no_of_ads",
			"admin_label" => true,
			"value" => range( 1, 50 ),
		),
		//Group For Left Section
		array
		(
			'group' => __( 'Categories', 'carspot' ),
			'type' => 'param_group',
			'heading' => __( 'Select Category', 'carspot' ),
			'param_name' => 'cats',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => __("Category", 'carspot') ,
					"param_name" => "cat",
					"admin_label" => true,
					"value" => carspot_cats(),
				),
			)
		),
		),
	) );