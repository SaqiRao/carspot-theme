<?php
/* ------------------------------------------------ */
/* Contact us */
/* ------------------------------------------------ */
if (!function_exists('contact_usshort')) {
	function contact_usshort()
	{
		vc_map(array(
			"name" => esc_html__("Contact Us", 'carspot'),
			"base" => "contact_usshort_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('contact-us.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),

				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Contact form 7 shortcode", 'carspot'),
					"param_name" => "contact_short_code",
				),
				array(
					"group" => esc_html__("Address", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Address", 'carspot'),
					"param_name" => "address",
				),
				array(
					"group" => esc_html__("Phone", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Phone", 'carspot'),
					"param_name" => "phone",
				),
				array(
					"group" => esc_html__("Email", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Email", 'carspot'),
					"param_name" => "email",
				),


			),
		));
	}
}

add_action('vc_before_init', 'contact_usshort');
if (!function_exists('contact_usshort_base_func')) {
	function contact_usshort_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'contact_short_code' => '',
			'address' => '',
			'phone' => '',
			'email' => '',
		), $atts));

		/* email html */
		$email_html = '';
		if ($email != '') {
			$email_html = '<div class="singleContadds">
                              <i class="fa fa-envelope"></i>
                              ' . $email . '
                           </div>';
		}
		/* phone html */
		$phone_html = '';
		if ($phone != '') {
			$phone_html = ' <div class="singleContadds phone">
                              <i class="fa fa-phone"></i>
                              <p>' . $phone . ' </p>
                           </div>';
		}
		/* adress html */
		$address_html = '';
		if ($address != '') {
			$address_html = '<div class="singleContadds">
                              <i class="fa fa-map-marker"></i>
                              <p>
                                 ' . $address . '
                              </p>
                           </div>';
		}
		global $carspot_theme;
		$top_padding = 'no-top';
		if (isset($carspot_theme['sb_header']) &&  $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
			$top_padding = '';
		}

		return '<section class="section-padding gray ' . carspot_returnEcho($top_padding) . ' ">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 no-padding commentForm">
                     <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                           ' . do_shortcode(carspot_clean_shortcode($contact_short_code)) . '
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="contactInfo">
                          ' . $address_html . '
                           ' . $phone_html . '
                           ' . $email_html . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('contact_usshort_base', 'contact_usshort_base_func');
}
