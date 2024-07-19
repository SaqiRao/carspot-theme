<?php
/* ------------------------------------------------ */
/* User Profile */
/* ------------------------------------------------ */
if (!function_exists('profile_short')) {

	function profile_short()
	{
		vc_map(array(
			"name" => esc_html__("User Profile", 'carspot'),
			"base" => "profile_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				carspot_generate_type(esc_html__('Prolfile Layout', 'carspot'), 'dropdown', 'profile_layout', '', "", array("Please select" => "", "Profile 1" => "p1", "Profile 2" => "p2")),
			),
		));
	}
}

add_action('vc_before_init', 'profile_short');

if (!function_exists('profile_short_base_func')) {
	function profile_short_base_func($atts, $content = '')
	{
		global $carspot_theme;
		extract(shortcode_atts(array(
			'profile_layout' => '',
		), $atts));

		$profile	=	new carspot_profile();
		carspot_user_not_logged_in();

		$top_padding = 'no-top';
		if (isset($carspot_theme['sb_header']) &&  $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
			$top_padding = '';
		}



		return '<section class="section-padding ' . carspot_returnEcho($top_padding) . ' gray" >
            <div class="container">
               ' . $profile->carspot_profile_full_top() . '
               <br>
               ' . $profile->carspot_profile_full_body() . '
            </div>
         </section>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('profile_short_base', 'profile_short_base_func');
}
