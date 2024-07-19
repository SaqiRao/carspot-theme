<?php
/* ------------------------------------------------ */
/* Cats Fancy */
/* ------------------------------------------------ */
if (!function_exists('cats_fancy_short')) {
function cats_fancy_short()
{
	vc_map(array(
		"name" => esc_html__("Ads By Make", 'carspot') ,
		"base" => "cats_fancy_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('ads_bymake.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),
		  array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "dropdown",
			"heading" => esc_html__("Enable hover animation", 'carspot') ,
			"param_name" => "hover_anim",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select an option', 'carspot') => '',
				esc_html__('Yes', 'carspot') => 'yes',
				esc_html__('No', 'carspot') => 'no'
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"description" => esc_html__("If you want to enable the hover animation then select YES.", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "dropdown",
			"heading" => esc_html__("Category link Page", 'carspot') ,
			"param_name" => "cat_link_page",
			"admin_label" => true,
			"value" => array(
			esc_html__('Search Page', 'carspot') => 'search',
			esc_html__('Category Page', 'carspot') => 'category',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
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
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "dropdown",
				"heading" => esc_html__("Header Style", 'carspot') ,
				"param_name" => "header_style",
				"admin_label" => true,
				"value" => array(
				esc_html__('Section Header Style', 'carspot') => '',
				esc_html__('No Header', 'carspot') => '',
				esc_html__('Classic', 'carspot') => 'classic',
				esc_html__('Regular', 'carspot') => 'regular'
				) ,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				"std" => '',
				"description" => esc_html__("Chose header style.", 'carspot'),
			),
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title",
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic', 'regular'),
				) ,
			),	
			
			array(
				"group" => esc_html__("Basic", "'carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic', 'regular'),
				) ,
			),
			
		array
		(
			'group' => esc_html__( 'Categories', 'carspot' ),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Category', 'carspot' ),
			'param_name' => 'cats',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Category", 'carspot') ,
					"param_name" => "cat",
					"admin_label" => true,
					"value" => carspot_get_parests('ad_cats','no'),
				),
				array(
				"group" => esc_html__("Basic", "carspot"),
				"type" => "attach_image",
				"holder" => "img",
				"heading" => esc_html__( "Category Image", 'carspot' ),
				"param_name" => "img",
				"description" => esc_html__('94x90', 'carspot'),
				),

			)
		),
								
		),
	));
}
}

add_action('vc_before_init', 'cats_fancy_short');

if (!function_exists('cats_fancy_short_base_func')) {
function cats_fancy_short_base_func($atts, $content = '')
{
	global $carspot_theme;
	$bg_bootom	=	'yes';
	require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	
	$hover_animation = '';
	if( $hover_anim == 'yes' )
	{
		$hover_animation	=	'hover-animation';
	}
	$categories_html	=	'';
	if( isset( $atts['cats'] ) )
	{
		$rows = vc_param_group_parse_atts( $atts['cats'] );
		
		if( count((array) $rows ) > 0 )
		{
			$counter = 0;
			foreach($rows as $row )
			{
				if( isset( $row['cat'] ) && isset( $row['img'] ) && $row['cat'] !="" )
				{
					$category = get_term_by('slug', $row['cat'], 'ad_cats');
					if( count((array) $category ) == 0 )
						continue;
					$bgImageURL	=	carspot_returnImgSrc( $row['img'] );
					if( isset($category->name) && $bgImageURL != "" && $category->name != ""){
					$categories_html .= '<div class="col-md-2 col-sm-4">
                     <div class="box">
					 <a href="'. esc_url(carspot_cat_link_page($category->term_id, $cat_link_page)) .'">
                         <img alt="'.esc_attr($category->name).'" src="'.esc_url($bgImageURL).'">
                        <h4>
						'.$category->name.'
						</h4>
                       </a> 
                     </div>
                  </div>';
				  if(++$counter % 6 == 0)
				  {
					 $categories_html .= '<div class="clearfix"></div>';
				  }
					}
				}
			}
		}
	}

return '<section class="custom-padding categories '.$hover_animation.' '.$parallex.' '.$bg_color.' '.$top_padding.'"' . $style .'>
            <div class="container">
               <div class="row">
			   		'.$header.'
					 <div class="row">'.$categories_html.'</div>
			   </div>
            </div>
         </section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('cats_fancy_short_base', 'cats_fancy_short_base_func');
}