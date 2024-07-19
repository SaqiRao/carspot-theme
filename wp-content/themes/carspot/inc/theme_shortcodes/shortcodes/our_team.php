<?php
/* ------------------------------------------------ */
/* Search Simple */
/* ------------------------------------------------ */
if (!function_exists('team_short')) {
function team_short()
{
	vc_map(array(
		"name" => esc_html__("Team Members", 'carspot') ,
		"base" => "team_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('services_grid.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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
			array(
		   'group' => __('Add Team', 'carspot') ,
		   'type' => 'param_group',
		   'heading' => __('Add Team Members', 'carspot') ,
		   'param_name' => 'add_team',
		   'value' => '',
		   'params' => array(
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "Name Of Member", 'carspot' ),
				  "param_name" => "member_name",
				),	
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "Desgination Of Member", 'carspot' ),
				  "param_name" => "member_desgination",
				),	
				
				array(
				  "type" => "attach_image",
				  "holder" => "img",
				  "heading" => __( "Team MemberImage", 'carspot' ),
				  "param_name" => "team_img",
				),	
			array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "Facebook Link", 'carspot' ),
				  "param_name" => "fb",
				),
				
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "Twitter Link", 'carspot' ),
				  "param_name" => "twitter",
				),	
				
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "Google Plus Link", 'carspot' ),
				  "param_name" => "google_plus",
				),	
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => __( "LinkedIn Link", 'carspot' ),
				  "param_name" => "LinkedIn",
				),		
		   )
		  ),
		),
	));
}
}

add_action('vc_before_init', 'team_short');
if (!function_exists('team_short_base_func')) {
function team_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'fb' => '',
		'twitter' => '',
		'google_plus' => '',
		'LinkedIn' => '',
		'img' => '',
	) , $atts));
	$html = '';	
	$parallex	=	'';
	if( $section_bg == 'img' )
	{
		$parallex	=	'parallex';
	}
	
	$rows = vc_param_group_parse_atts( $atts['add_team'] );
	if( count((array) $rows ) > 0 )
	{
		$counter = 0;
		foreach($rows as $row )
		{
			$img =  wp_get_attachment_image_src($row['team_img'], 'gofinance_teammember');
			if( isset( $row['member_name'] ) )
			{
				$social_link = '';
				if(isset($row['fb']))
				{
					$social_link .= '<li><a target="_blank" class="facebook" href="'.$row['fb'].'"><i class="fa fa-facebook"></i></a></li>';
				}
				if(isset($row['twitter']))
				{
					$social_link .= '<li><a target="_blank" class="twitter" href="'.$row['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
				}	
				if(isset($row['google_plus']))
				{
					$social_link .= '<li><a target="_blank" class="google" href="'.$row['google_plus'].'"><i class="fa fa-google-plus"></i></a></li>';
				}
				if(isset($row['LinkedIn']))
				{
					$social_link .= '<li><a target="_blank" class="linkedin" href="'.$row['LinkedIn'].'"><i class="fa fa-linkedin"></i></a></li>';
				}			
				$social_media = '<ul class="socials">'.$social_link.'</ul>';
				$html .= '<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="team">
							<div class="avatar">
								<img alt="'.$row['member_name'].'" class="img-responsive" src="'.$img[0].'">
							</div>
							<div class="team-info">
								<h3 class="team-name">'.$row['member_name'].'</h3>
								<span class="team-job">'.$row['member_desgination'].'</span>
								'.$social_media.'
							</div>
						</div>
					</div>';
					if(++$counter % 4 == 0) {
                      	$html .=  '<div class="clearfix"></div>';
					 }
			}
		}
	}
	return '<section class="custom-padding '.$parallex.' '.$bg_color.' '.$top_padding.'" ' . $style .'>
         <div class="container">
		   '.$header.'
               <div class="row">
                 '.$html.' 
               </div>
            </div>
         </section>';
}
}
if (function_exists('carspot_add_code'))
{
	carspot_add_code('team_short_base', 'team_short_base_func');
}