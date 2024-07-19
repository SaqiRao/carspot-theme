<?php if ( ! defined( 'ABSPATH' ) ) { die( '-1' ); }
/* ------------------------------------------------ */
/* Homepage slider shortcode */
/* ------------------------------------------------ */
function revolution_slider_func() {
vc_map( array(
    "name" => __("Slider", 'carspot'),
    "base" => "homepage_slider",
    "as_parent" => array('only' => 'homepage_slider_block'),
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
	"category" => esc_html__("Theme Shortcodes", 'carspot') ,
	 "js_view" => 'VcColumnView',
	 "params" => array(

		array(
			"type"        => "dropdown",
			"heading"     => __("Slider Type", 'carspot' ),
			"param_name"  => "slider_type",
			"admin_label" => true,
			"value"       => array(
				'Select Slider Type' => '',
				'Standard'   => 'standard',
				'Hero'   => 'hero',
				'Carousel'   => 'carousel',
			),
			"std"         => 'standard',
			"description" => __("Select The Slider Type.", 'carspot' ),
		),
		
		array(
			"type"        => "dropdown",
			"heading"     => __("Slider Layout", 'carspot' ),
			"param_name"  => "slider_layout",
			"admin_label" => true,
			"value"       => array(
				'Select Slider Layout' => '',
				'Auto'   => 'auto',
				'Full Width'   => 'fullwidth',
				'Full Screen'   => 'fullscreen',
			),
			"std"         => 'auto',
			"description" => __("Select The Slider Layout.", 'carspot' ),
		), // 
		array(
			"type"        => "dropdown",
			"heading"     => __("Dotted Overlay", 'carspot' ),
			"param_name"  => "dotted_overlay",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'None'   => 'none',
				'Custom'      => 'custom',
				'2 X 2'      => 'twoxtwo',
				'3 X 3'      => 'threexthree',
				'2 X 2 White'      => 'twoxtwowhite',
				'3 X 3 White'		=> 'threexthreewhite',
			),
			"std"         => 'none',
		),	
		array(
			"type"        => "textfield",
			"heading"     => __("Delay", 'carspot' ),
			"param_name"  => "slider_delay",
			"admin_label" => true,
			"value"       => '5000',
			"description" => __("enter delay in ms e.g. 5000 is 5 seconds", 'carspot' ),
		),				

		/* Navigation */					
		array(
		    "group" => __( 'Navigation', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Keyboard Navigation", 'carspot' ),
			"param_name"  => "keyboard_navigation",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Off'   => 'off',
				'ON'   => 'on',
			),
			"std"         => 'off',
		),
		array(
		    "group" => __( 'Navigation', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Keyboard Direction", 'carspot' ),
			"param_name"  => "keyboard_direction",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Horizontal'   => 'horizontal',
			),
			"std"         => 'horizontal',
		),	
			
		array(
		    "group" => __( 'Navigation', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Mouse Scroll", 'carspot' ),
			"param_name"  => "mouse_scroll_navigation",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Off'   => 'off',
				'ON'   => 'on',
			),
			"std"         => 'off',
		),	
		array(
		    "group" => __( 'Navigation', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("On Hover Stop", 'carspot' ),
			"param_name"  => "on_hover_stop",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Off'   => 'off',
				'ON'   => 'on',
			),
			"std"         => 'off',
		),	
		array(
		    "group" => __( 'Navigation', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Touch Enabled", 'carspot' ),
			"param_name"  => "touchenabled",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Off'   => 'off',
				'ON'   => 'on',
			),
			"std"         => 'off',
		),	
		/* Arrows */
		array(
		    "group" => __( 'Arrows', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Arrows Enabled", 'carspot' ),
			"param_name"  => "arrows_enabled",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'True'   => 'true',
				'False'   => 'false',
			),
			"std"         => 'true',
		),	
		array(
		    "group" => __( 'Arrows', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Arrows Style", 'carspot' ),
			"param_name"  => "arrows_style",
			"admin_label" => true,
			"value"       => array(
				'Select Arrows Style' => '',
				'Gyges'   => 'gyges',
				'Hebe'   => 'hebe',
				'Hephaistos'   => 'hephaistos',
				'Hermes'   => 'hermes',
				'Hesperiden'   => 'hesperiden',
				'Metis'   => 'metis',
				'Persephone'   => 'persephone',
				'Uranus'   => 'uranus',
				'Zeus'   => 'zeus',
			),
			"std"         => 'gyges',
		),	
		array(
		    "group" => __( 'Arrows', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Hide On Mobile", 'carspot' ),
			"param_name"  => "hide_on_mobile",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'False'   => 'false',
				'True'   => 'true',
			),
			"std"         => 'true',
		),	
		array(
		    "group" => __( 'Arrows', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Hide On Leave", 'carspot' ),
			"param_name"  => "hide_on_leave",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'True'   => 'true',
				'False'   => 'false',
			),
			"std"         => 'true',
		),	
		array(
		    "group" => __( 'Arrows', 'carspot' ),		
			"type"        => "textfield",
			"heading"     => __("Hide Delay", 'carspot' ),
			"param_name"  => "hide_delay",
			"admin_label" => true,
			"value"       => '200',
			"description" => __("enter delay in ms e.g. 5000 is 5 seconds", 'carspot' ),
		),
		array(
		    "group" => __( 'Arrows', 'carspot' ),		
			"type"        => "textfield",
			"heading"     => __("Hide Mobile Delay", 'carspot' ),
			"param_name"  => "hide_delay_mobile",
			"admin_label" => true,
			"value"       => '1200',
			"description" => __("enter delay in ms e.g. 5000 is 5 seconds", 'carspot' ),
		),				
		/* Bullets */
		array(
		    "group" => __( 'Bullets', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Enable Bullets", 'carspot' ),
			"param_name"  => "bullets_enable",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'True'   => 'true',
				'False'   => 'false',
			),
			"std"         => 'true',
		),	
		array(
		    "group" => __( 'Bullets', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Hide On Mobile", 'carspot' ),
			"param_name"  => "bullets_hide_onmobile",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'True'   => 'true',
				'False'   => 'false',
			),
			"std"         => 'true',
		),	
		array(
			"group" => __( 'Bullets', 'carspot' ),
			"type"        => "textfield",
			"heading"     => __("Hide Under", 'carspot' ),
			"param_name"  => "bullets_hide_under",
			"admin_label" => true,
			"value"       => '800',
			"description" => __("Hide bullets under specific width", 'carspot' ),
		),				
		array(
		    "group" => __( 'Bullets', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Bullets Style", 'carspot' ),
			"param_name"  => "bullets_style",
			"admin_label" => true,
			"value"       => array(
				'Select Bullets Style' => '',
				'Gyges'   => 'gyges',
				'Hebe'   => 'hebe',
				'Hephaistos'   => 'hephaistos',
				'Hermes'   => 'hermes',
				'Hesperiden'   => 'hesperiden',
				'Metis'   => 'metis',
				'Persephone'   => 'persephone',
				'Uranus'   => 'uranus',
				'Zeus'   => 'zeus',
			),
			"std"         => 'gyges',
		),	
		array(
		    "group" => __( 'Bullets', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Hide On Leave", 'carspot' ),
			"param_name"  => "bullets_hide_onleave",
			"admin_label" => true,
			"value"       => array(
				'Select Hide On Leave' => '',
				'True'   => 'true',
				'False'   => 'false',
			),
			"std"         => 'true',
		),	
		array(
		    "group" => __( 'Bullets', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Hide On Leave", 'carspot' ),
			"param_name"  => "bullets_direction",
			"admin_label" => true,
			"value"       => array(
				'Horizontal'   => 'horizontal',
			),
			"std"         => 'horizontal',
		),	

	)
) );
vc_map( array(
    "name" => __("Add Slider Slides", 'carspot'),
    "base" => "homepage_slider_block",
    "content_element" => true,
    "as_child" => array('only' => 'homepage_slider'),
	"category" => __( "Theme Shortcodes", 'carspot'),
    "params" => array(
		
		array(
			"group" => __( 'Slide Settings', 'carspot' ),
			"type" => "attach_image",
			"holder" => "img",
			"heading" => esc_html__("Slide Image", 'carspot'),
			"param_name" => "slide_image",
			"value" => esc_html__("", 'carspot'),
			"description" => esc_html__("Upload slider image here.", 'carspot')
		),
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Text Position", 'carspot' ),
			"param_name"  => "slide_textpostion",
			"admin_label" => true,
			"value"       => array(
				'Select Text Position' => '',
				'Left' => 'left',
				'Center' => 'center',
				'Right' => 'right',	
				
			),
			"std"         => '',
		),
		
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Slide Data Transition", 'carspot' ),
			"param_name"  => "slide_data_transition",
			"admin_label" => true,
			"value"       => array(
				'Slide Data Transition' => '',
				'Sliding Overlay Horizontal' => 'slidingoverlayhorizontal',
				'Box Slide' => 'boxslide',
				'Box Fade' => 'boxfade',
				'Slotzoom Horizontal' => 'slotzoom-horizontal',
				'Slotslide Horizontal' => 'slotslide-horizontal',
				'Slotfade Horizontal' => 'slotfade-horizontal',
				'Slotzoom Vertical' => 'slotzoom-vertical',
				'Slotslide Certical' => 'slotslide-vertical',
				'Slotfade Vertical' => 'slotfade-vertical',
				'Curtain 1' => 'curtain-1',
				'Curtain 2' => 'curtain-2',
				'Curtain 3' => 'curtain-3',
				'Slide Left' => 'slideleft',
				'Slide Right' => 'slideright',
				'Slide Up' => 'slideup',
				'Slide Down' => 'slidedown',
				'Fade' => 'fade'
			),
			"std"         => 'slidingoverlayhorizontal',
		),
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Data Save Performance", 'carspot' ),
			"param_name"  => "data_saveperformance",
			"admin_label" => true,
			"value"       => array(
				'Off' => 'Off',
				'On' => 'on',
			),
		),	
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Background Position", 'carspot' ),
			"param_name"  => "data_bgposition",
			"admin_label" => true,
			"value"       => array(
				'Slide Background Position' => '',
				'Center Center' => 'center center',	
				'Left Top' => 'left top',
				'Right Bottom' => 'right bottom',
			),
			"std"         => 'center center',
		),
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Background Fit", 'carspot' ),
			"param_name"  => "slide_data_bgfit",
			"admin_label" => true,
			"value"       => array(
				'Slide Background Fit' => '',
				'Cover' => 'cover',
				'Auto' => 'auto',	
				'Length' => 'length',
				'Contain' => 'contain',
			),
			"std"         => 'cover',
		),

		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Background Repeat", 'carspot' ),
			"param_name"  => "slide_data_bgrepeat",
			"admin_label" => true,
			"value"       => array(
				'Slide Repeat Type' => '',
				'No-Repeat' => 'no-repeat',	
				'Repeat' => 'repeat',
				'Repeat-X' => 'repeat-x',
				'Repeat-Y' => 'repeat-y',
			),
			"std"         => 'no-repeat',
		),
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Background Parallax", 'carspot' ),
			"param_name"  => "slide_data_bgparallax",
			"admin_label" => true,
			"value"       => array(
				'Background Parallax' => '',
				'Off' => 'off',	
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',												
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',												
				'9' => '9',
				'10' => '10',
			),
			"std"         => 'off',
		),
		array(
		    "group" => __( 'Slide Settings', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Retina Image", 'carspot' ),
			"param_name"  => "slide_datanoretina",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'No' => 'data_no_retina',	
				'Yes' => ' ',
			),
			"std"         => 'data_no_retina',
		),
		
	//  
		array(
			"group" => __( 'Line 1', 'carspot' ),
			"type"        => "textfield",
			"heading"     => __("Line 1 Text", 'carspot' ),
			"param_name"  => "slide1_title",
			"admin_label" => true,
			"value"       => '',
			"description" => __("Enter line 1 text here", 'carspot' ),
		),
		
		
		
		array(
            "type" => "checkbox",
            "holder" => "div",
			"group" => __( 'Line 1', 'carspot' ),
            "class" => "",
            "param_name" => "slide1_title_bg",
            "admin_label" => '',
			'std' => '1',
            "value" => array(
				__('Do You Want To Show Bg Color For Title', 'carspot') => '1',
			) ,
         ),
		
		
		array(
		    "group" => __( 'Line 1', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Text Uppercase", 'carspot' ),
			"param_name"  => "slide1_textuppercase",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Yes' => 'yes',	
				'No' => 'no',
			),
			"std"         => 'yes',
		),
		array(
		    "group" => __( 'Line 1', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Size", 'carspot' ),
			"param_name"  => "slide1_datafontsize",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '26',
		),
		

		array(
		    "group" => __( 'Line 1', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Line Height", 'carspot' ),
			"param_name"  => "slide1_datalineheight",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '64',
		),
		array(
		    "group" => __( 'Line 1', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Weight", 'carspot' ),
			"param_name"  => "slide1_fontweight",
			"admin_label" => true,
			"value"       => array(
				'Select Weight' => '',
				'Lighter' => 'lighter',
				'BLod' => 'blod',	
				'Bolder' => 'bolder',	
				'Normal' => 'normal',	
				'900' => '900',	
				'800' => '800',	
				'700' => '700',	
				'600' => '600',	
				'500' => '500',	
				'400' => '400',	
				'300' => '300',	
				'200' => '200',	
				'100' => '100',	
			),
			"std"         => '700',
		),
	// line 2
		array(
			"group" => __( 'Line 2', 'carspot' ),
			"type"        => "textfield",
			"heading"     => __("Line 2 Text", 'carspot' ),
			"param_name"  => "slide2_title",
			"admin_label" => true,
			"value"       => '',
			"description" => __("Enter line 2 text here", 'carspot' ),
		),
		
		array(
            "type" => "checkbox",
            "holder" => "div",
			"group" => __( 'Line 2', 'carspot' ),
            "class" => "",
            "param_name" => "slide2_title_bg",
            "admin_label" => '',
			'std' => '1',
            "value" => array(
				__('Do You Want To Show Bg Color For Title', 'carspot') => '1',
			) ,
         ),
		
		
		array(
		    "group" => __( 'Line 2', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Text Uppercase", 'carspot' ),
			"param_name"  => "slide2_textuppercase",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Yes' => 'yes',	
				'No' => 'no',
			),
			"std"         => 'yes',
		),
		array(
		    "group" => __( 'Line 2', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Size", 'carspot' ),
			"param_name"  => "slide2_datafontsize",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '40',
		),

		array(
		    "group" => __( 'Line 2', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Line Height", 'carspot' ),
			"param_name"  => "slide2_datalineheight",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '64',
		),
		array(
		    "group" => __( 'Line 2', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Weight", 'carspot' ),
			"param_name"  => "slide2_fontweight",
			"admin_label" => true,
			"value"       => array(
				'Select Font Weight' => '',
				'Lighter' => 'lighter',
				'BLod' => 'blod',	
				'Bolder' => 'bolder',	
				'Normal' => 'normal',	
				'900' => '900',	
				'800' => '800',	
				'700' => '700',	
				'600' => '600',	
				'500' => '500',	
				'400' => '400',	
				'300' => '300',	
				'200' => '200',	
				'100' => '100',	
			),
			"std"         => '600',
		),		
	// line 2
		array(
			"group" => __( 'Line 3', 'carspot' ),
			"type"        => "textarea",
			"heading"     => __("Line Text 3", 'carspot' ),
			"param_name"  => "slide3_title",
			"admin_label" => true,
			"value"       => '',
			"description" => __("Enter line 3 text here", 'carspot' ),
		),
		array(
		    "group" => __( 'Line 3', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Text Uppercase", 'carspot' ),
			"param_name"  => "slide3_textuppercase",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Yes' => 'yes',	
				'No' => 'no',
			),
			"std"         => 'no',
		),
		array(
		    "group" => __( 'Line 3', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Size", 'carspot' ),
			"param_name"  => "slide3_datafontsize",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '18',
		),

		array(
		    "group" => __( 'Line 3', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Line Height", 'carspot' ),
			"param_name"  => "slide3_datalineheight",
			"admin_label" => true,
			"value"       => range(10,150),
			"std"         => '34',
		),
		array(
		    "group" => __( 'Line 3', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Font Weight", 'carspot' ),
			"param_name"  => "slide3_fontweight",
			"admin_label" => true,
			"value"       => array(
				'Select Font Weight' => '',
				'Lighter' => 'lighter',
				'BLod' => 'blod',	
				'Bolder' => 'bolder',	
				'Normal' => 'normal',	
				'900' => '900',	
				'800' => '800',	
				'700' => '700',	
				'600' => '600',	
				'500' => '500',	
				'400' => '400',	
				'300' => '300',	
				'200' => '200',	
				'100' => '100',	
			),
			"std"         => '300',
		),		

	// Button  //button_text, button_url, is_btn_target
		array(
			"group" => __( 'Button', 'carspot' ),
			"type"        => "textfield",
			"heading"     => __("Button Text", 'carspot' ),
			"param_name"  => "button_text",
			"admin_label" => true,
			"value"       => '',
			"description" => __("Enter button text", 'carspot' ),
		),
		array(
			"group" => __( 'Button', 'carspot' ),
			"type"        => "textfield",
			"heading"     => __("Button URL", 'carspot' ),
			"param_name"  => "button_url",
			"admin_label" => true,
			"value"       => '#',
			"description" => __("Enter url of button", 'carspot' ),
		),
		array(
		    "group" => __( 'Button', 'carspot' ),
			"type"        => "dropdown",
			"heading"     => __("Open In", 'carspot' ),
			"param_name"  => "is_btn_target",
			"admin_label" => true,
			"value"       => array(
				'Select Type' => '',
				'Current Window' => '_self',
				'New Window' => '_blank',	
			),
			"std"         => '_self',
		),	
		//close
    )
) );

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_homepage_slider extends WPBakeryShortCodesContainer {
		 }
	}
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_homepage_slider_block extends WPBakeryShortCode {
		}
	}



}
add_action( 'vc_before_init', 'revolution_slider_func' );

function rev_get_attachment( $attachment_id, $img_size ) {

	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, $img_size, true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID),
		'src' => $attachment->guid,
		'title' => $attachment->post_title,
		'_src'	=> wp_get_attachment_image_src( $attachment_id, $img_size ),
	);
}



function sb_themes_homepage_slider_header($atts, $content = '') {
	
	
   extract(shortcode_atts(array(
	'slider_type' => 'standard',
	'slider_layout' => 'auto',
	'dotted_overlay' => 'none',
	'slider_delay' => '5000',
	/* Navigation */
	'keyboard_navigation' => 'off',
	'keyboard_direction' => 'horizontal',
	'mouse_scroll_navigation' => 'off',
	'on_hover_stop' => 'off',
	'touchenabled' => 'off',
	/* Arrows */
	'arrows_style' => 'gyges',
	'arrows_enabled' => 'true',
	'hide_on_mobile' => 'false',
	'hide_on_leave' => 'true',
	'hide_delay' => '200',
	'hide_delay_mobile' => '1200',
	/* bullets */
	'bullets_enable' => 'true',
	'bullets_hide_onmobile' => 'true',
	'bullets_hide_under' => '800',
	'bullets_style' => 'hebe',
	'bullets_hide_onleave' => 'false',
	'bullets_direction' => 'horizontal',
   ), $atts));
/* Add Slider Assests CSS/JS */
$revFilePath =  trailingslashit( get_template_directory_uri() ) . 'inc/theme_shortcodes/shortcodes/revolution-slider/';

/*  Revolution Slider */
wp_enqueue_script( 'themepunch-tools', $revFilePath . 'js/jquery.themepunch.tools.min.js', false, false, true );
wp_enqueue_script( 'themepunch-revolution', $revFilePath . 'js/jquery.themepunch.revolution.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-actions', $revFilePath . 'js/extensions/revolution.extension.actions.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-carousel', $revFilePath . 'js/extensions/revolution.extension.carousel.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-kenburn', $revFilePath . 'js/extensions/revolution.extension.kenburn.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-layeranimation', $revFilePath . 'js/extensions/revolution.extension.layeranimation.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-migration', $revFilePath . 'js/extensions/revolution.extension.migration.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-navigation', $revFilePath . 'js/extensions/revolution.extension.navigation.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-parallax', $revFilePath . 'js/extensions/revolution.extension.parallax.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-slideanims', $revFilePath . 'js/extensions/revolution.extension.slideanims.min.js', false, false, true );
wp_enqueue_script( 'revolution-extension-video', $revFilePath . 'js/extensions/revolution.extension.video.min.js', false, false, true );
wp_enqueue_style( 'revolution-settings', $revFilePath . 'css/settings.css' );
wp_enqueue_style( 'revolution-navigation', $revFilePath . 'css/navigation.css' );

    $return = '';
	$return .= '<script  type="text/javascript">
	  jQuery(document).ready(function(e) {
		var revapi = jQuery(".rev_slider").revolution({
		  sliderType:"'. $slider_type .'",
		  jsFileLocation: "'.$revFilePath.'js/",
		  sliderLayout: "'. $slider_layout .'",
		  dottedOverlay: "'. $dotted_overlay .'",
		  delay: '. $slider_delay .',
		  navigation: {
			  keyboardNavigation: "'. $keyboard_navigation .'",
			  keyboard_direction: "'. $keyboard_direction .'",
			  mouseScrollNavigation: "'. $mouse_scroll_navigation .'",
			  onHoverStop: "'. $on_hover_stop .'",
			  touch: {
				  touchenabled: "'. $touchenabled .'",
				  swipe_threshold: 75,
				  swipe_min_touches: 1,
				  swipe_direction: "horizontal",
				  drag_block_vertical: false
			  },
			  arrows: {
				  style: "'. $arrows_style .'",
				  enable: '. $arrows_enabled .',
				  hide_onmobile: '. $hide_on_mobile .',
				  hide_onleave: '. $hide_on_leave .',
				  hide_delay: '. $hide_delay .',
				  hide_delay_mobile: '. $hide_delay_mobile .',
				  tmp: \'\',
				  left: {
					  h_align: "left",
					  v_align: "center",
					  h_offset: 0,
					  v_offset: 0
				  },
				  right: {
					  h_align: "right",
					  v_align: "center",
					  h_offset: 0,
					  v_offset: 0
				  }
			  },
				bullets: {
				enable: '. $bullets_enable .',
				hide_onmobile: '. $bullets_hide_onmobile .',
				hide_under: '. $bullets_hide_under .',
				style: "'. $bullets_style .'",
				hide_onleave: '. $bullets_hide_onleave .',
				direction: "'. $bullets_direction .'",
				h_align: "center",
				v_align: "bottom",
				h_offset: 0,
				v_offset: 30,
				space: 5,
				tmp: \'<span class="tp-bullet-image"></span><span class="tp-bullet-imageoverlay"></span><span class="tp-bullet-title"></span>\'
			}
		  },
		  responsiveLevels: [1240, 1024, 778],
		  visibilityLevels: [1240, 1024, 778],
		  gridwidth: [1170, 1024, 778, 480],
		  gridheight: [620, 768, 960, 720],
		  lazyType: "none",
		  parallax: {
			type: "scroll",
			origo: "slidercenter",
			speed: 1000,
			levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 100, 55],
			type: "scroll",
		  },
		  shadow: 0,
		  spinner: "off",
		  stopLoop: "on",
		  stopAfterLoops: 0,
		  stopAtSlide: -1,
		  shuffle: "off",
		  autoHeight: "off",
		  fullScreenAutoWidth: "off",
		  fullScreenAlignForce: "off",
		  fullScreenOffsetContainer: "",
		  fullScreenOffset: "0",
		  hideThumbsOnMobile: "off",
		  hideSliderAtLimit: 0,
		  hideCaptionAtLimit: 0,
		  hideAllCaptionAtLilmit: 0,
		  debugMode: false,
		  fallbacks: {
			  simplifyAll: "off",
			  nextSlideOnWindowFocus: "off",
			  disableFocusListener: false,
		  }
		});
	  });
     </script>';

	$return .= '<div class="rev_slider_wrapper"><div class="rev_slider" data-version="5.0"><ul>'. do_shortcode($content) .'</ul></div></div>';

	return $return;
}
if( function_exists( 'carspot_add_code' ) ){ carspot_add_code('homepage_slider', 'sb_themes_homepage_slider_header'); }


function sb_theme_slider_body($atts, $content = '') {
	
	 extract(shortcode_atts(array(
		  'slide_image' => '',
		  'slide_textpostion'    => 'left',
		  'slide_data_transition' => 'slidingoverlayhorizontal',
		  'data_saveperformance' => 'on',
		  'data_bgposition' => 'center center',
		  'slide_data_bgfit' => 'cover',
		  'slide_data_bgrepeat' => 'no-repeat',
		  'slide_data_bgparallax' => '6',
		  'slide_datanoretina' => 'data-no-retina',
		  
		  //slide 1 text settings
		  'slide1_title' 		=> '',
		  'slide1_title_bg' 		=> '1',
		  'slide1_textuppercase' => 'yes',
		  'slide1_datafontsize'        => '26',
		  'slide1_datalineheight' => '64',
		  'slide1_fontweight' => '700',

		  //slide 2 text settings
		  'slide2_title' 		=> '',
		  'slide2_title_bg' 		=> '1',
		  'slide2_textuppercase' => 'yes',
		  'slide2_datafontsize'        => '40',
		  'slide2_datalineheight' => '64',
		  'slide2_fontweight' => '600',

		  //slide 3 text settings
		  'slide3_title' 		=> '',
		  'slide3_textuppercase' => 'no',
		  'slide3_datafontsize'        => '18',
		  'slide3_datalineheight' => '34',
		  'slide3_fontweight' => '300',
		  
		  //button
		  'button_text' => 'Read More',
		  'button_url' => '#',
		  'is_btn_target' => '_self',
		  
	   ), $atts));
	
	$revThumb = rev_get_attachment( $slide_image, 'carspot_revslider_thumb' );
	$revImg   = rev_get_attachment( $slide_image, 'gofinace_revslider_large' );
		
	if($is_btn_target != "_self"){$btn_target = 'target="_blank"';}else{$btn_target = 'target="_self"';}	
	$textuppercase1 = '';	
	if($slide1_textuppercase == 'yes'){ $textuppercase1 = 'text-uppercase'; }
	$textuppercase2 = '';	
	if($slide2_textuppercase == 'yes'){ $textuppercase2 = 'text-uppercase'; }
	$textuppercase3 = '';	
	if($slide3_textuppercase == 'yes'){ $textuppercase3 = 'text-uppercase'; }
	$custom_class = ''; $custom_class1 = '';
	if(isset($slide1_title_bg) && $slide1_title_bg == 1)
	{
		$custom_class = 'main-caption';
	}
	else
	{
		$custom_class = '';
	}
	
	if(isset($slide2_title_bg) && $slide2_title_bg == 1)
	{
		$custom_class1 = 'main-caption bg-white font-light';
	}
	else
	{
		$custom_class1 = '';
	}
		
			$li_data_index =  li_count();
			return '<li class="tp-revslider-slidesli " data-index="rs-'.$li_data_index.'" data-transition="'. esc_attr( $slide_data_transition ) .'" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="'. esc_attr( $revThumb['_src'][0] ) .'" data-rotate="0" data-saveperformance="'. esc_attr( $data_saveperformance ).'" data-title="'. esc_attr( $revImg['title'] ) .'" data-description="'. esc_attr(  $revImg['description'] ) .'" style="width: 100%; height: 100%; overflow: hidden; visibility: inherit; opacity: 1; background-color: rgba(255, 255, 255, 0);"> 
			
        <img src="'. esc_url( $revImg['_src'][0] ) .'"  alt="'. esc_attr( $revImg['description'] ) .'"  data-bgposition="'. esc_attr( $data_bgposition ) .'" data-bgfit="'. esc_attr( $slide_data_bgfit ) .'" data-bgrepeat="'. esc_attr( $slide_data_bgrepeat ) .'" class="rev-slidebg" data-bgparallax="'. esc_attr( $slide_data_bgparallax ) .'"  '. $slide_datanoretina .' >
		
		
        
		<div id="rs-'.$li_data_index.'-layer-1" class="tp-caption responsive-tagline '. $custom_class.' tp-resizeme text-white '. $textuppercase1.' text-'.$slide_textpostion.'"  data-x="['.  esc_attr( $slide_textpostion ) .']" data-hoffset="[\'30\']" data-y="[\'middle\']" data-voffset="[\'-125\']" data-fontsize="['. esc_attr(  $slide1_datafontsize ) .']" data-lineheight="['. esc_attr( $slide1_datalineheight ).']" style="z-index: 999; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px; transition: none 0s ease 0s ;font-weight:'.$slide1_fontweight.';" data-transform_idle="o:1;s:500" data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;" data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;" data-responsive_offset="on" data-splitin="none" data-start="1000" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;">'. esc_html( $slide1_title ) .'</div>

		<div id="rs-'.$li_data_index.'-layer-2" class="tp-caption tp-resizeme responsive-tagline2 text-white '. $custom_class1.' font-merry '.$textuppercase2.' text-'.$slide_textpostion.'"  data-x="['.  esc_attr(  $slide_textpostion ) .']" data-hoffset="[\'30\']" data-y="[\'middle\']" data-voffset="[\'-64\']" data-fontsize="['. esc_attr(  $slide2_datafontsize ).']" data-lineheight="['. esc_attr( $slide1_datalineheight ).']" style="z-index: 999; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px; transition: none 0s ease 0s ;font-weight:'.$slide2_fontweight.';" data-transform_idle="o:1;s:500" data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;" data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;" data-responsive_offset="on" data-splitin="none" data-start="1000" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;">'. esc_html( $slide2_title ) .'</div>

		<div id="rs-'.$li_data_index.'-layer-3" class="tp-caption tp-resizeme text-white font-merry responsive-font'.$textuppercase3.' text-'.$slide_textpostion.'"  data-x="['.  esc_attr( $slide_textpostion ).']" data-hoffset="[\'30\']" data-y="[\'middle\']" data-voffset="[\'20\']" data-fontsize="['. esc_attr( $slide3_datafontsize ) .']" data-lineheight="['. esc_attr( $slide3_datalineheight ).']" style="z-index: 999; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px; transition: none 0s ease 0s ;font-weight:'.$slide3_fontweight.';" data-transform_idle="o:1;s:500" data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;" data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;" data-responsive_offset="on" data-splitin="none" data-start="1000" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;">'. ( $slide3_title ) .'</div>


		<div id="rs-'.$li_data_index.'-layer-4" class="tp-caption tp-resizeme text-white font-merry text-uppercase"  data-x="['. esc_attr( $slide_textpostion ) .']" data-hoffset="[\'30\']" data-y="[\'middle\']" data-voffset="[\'100\']" style="z-index: 999; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px; transition: none 0s ease 0s ;z-index: 5; white-space: nowrap; letter-spacing:1px;" data-transform_idle="o:1;s:500" data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;" data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;" data-responsive_offset="on" data-splitin="none" data-start="1000" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"><a class="slider-main-button" href="'.esc_url($button_url).'" '.$btn_target.'>'. esc_html( $button_text ) . '  <i class="fa fa-arrow-circle-right"></i></a> </div>
      </li>';
}
if( function_exists( 'carspot_add_code' ) ){ carspot_add_code('homepage_slider_block', 'sb_theme_slider_body'); }
	function li_count()
	{
		static $r = 0; 	
		$r++;
		return $r;
	}