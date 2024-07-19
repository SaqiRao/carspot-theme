<?php
/* ------------------------------------------------ */
/* Buy Or Sale Main Banner */
/* ------------------------------------------------ */
if (!function_exists('buy_sale_poster')) {
function buy_sale_poster()
{
	vc_map(array(
		"name" => esc_html__("Buy Or Sale Main Banner", 'carspot') ,
		"base" => "buy_sale_poster_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' =>carspot_VCImage('buy_sale_poster.png') .  esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		
			array(
				"group" => esc_html__("Looking For ", "carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "section_title",
				
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			
			array(
				"group" => esc_html__("Looking For ", "carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "section_description",
								"description" =>  esc_html__('Description ', 'carspot') . '<strong>' . esc_html__('Your description content', 'carspot')  . '</strong>',

				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			
			array(
				"group" => esc_html__("Looking For ", "carspot"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Background Image", 'carspot' ),
				"param_name" => "bg_img",
			),
			
			array(
				"group" => esc_html__("Looking For ", "carspot"),
				"type" => "vc_link",
				"heading" => esc_html__( "Read More Link", 'carspot' ),
				"param_name" => "main_link",
				"description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
			),
			
			
			array(
				"group" => esc_html__("Want To Hire ", "carspot"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'carspot' ),
				"param_name" => "sell_tagline",
				"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			
			array(
				"group" => esc_html__("Want To Hire ", "carspot"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'carspot' ),
				"param_name" => "main_description1",
				"description" =>  esc_html__('Description ', 'carspot') . '<strong>' . esc_html__('Your description content', 'carspot')  . '</strong>',
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		
		
			array(
				"group" => esc_html__("Want To Hire ", "carspot"),
				"type" => "attach_image",
				"holder" => "bg_imag",
				"class" => "",
				"description" =>  esc_html__('Background Image ', 'carspot') . '<strong>' . esc_html__('Your description content', 'carspot')  . '</strong>',
				"heading" => esc_html__( "Background  Image", 'carspot' ),
				"param_name" => "main_image1"
			),  
			
			array(
				"group" => esc_html__("Want To Hire ", "carspot"),
				"type" => "vc_link",
				"heading" => esc_html__( "Read More Link", 'carspot' ),
				"param_name" => "main_link1",
				"description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
			),
			
		
			
		),
	));
}
}

add_action('vc_before_init', 'buy_sale_poster');

if (!function_exists('buy_sale_poster_short_base_func')) {
function buy_sale_poster_short_base_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
	//left Image
	$bgImageURL	=	carspot_returnImgSrc( $bg_img );
	$style = ( $bgImageURL != "" ) ? ' style="background-image: url('.$bgImageURL.');background-position: center center;background-repeat: no-repeat;background-size: cover;"' : "";

	//Right Image
	$bgImageURL2	=	carspot_returnImgSrc( $main_image1 );
	$style2 = ( $bgImageURL2 != "" ) ? ' style="background-image: url('.$bgImageURL2.');background-position: center center;background-repeat: no-repeat;background-size: cover;"' : "";
	
	return '<section class="buysell-section">
         <div class="background-3"  '.$style.'></div>
         <div class="background-4" '.$style2.'></div>
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                  <div class="section-container-left">
                     <h1>'.$section_title.'</h1>
                     <p>'.$section_description.'</p>
					 '. carspot_ThemeBtn($main_link, 'btn-theme btn-lg btn', false , false , '').'
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                  <div class="section-container-right">
                     <h1>'.$sell_tagline.'</h1>
                     <p>'.$main_description1.'</p>
					 '. carspot_ThemeBtn($main_link1, 'btn-primary btn-lg btn', false , false , '').'
                  </div>
               </div>
            </div>
         </div>
      </section>';
}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('buy_sale_poster_short_base', 'buy_sale_poster_short_base_func');
}