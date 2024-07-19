<?php
/* ------------------------------------------------ */
/* Sign In */
/* ------------------------------------------------ */
if (!function_exists('login_short')) {

    function login_short()
    {
        vc_map(array(
            "name" => esc_html__("Sign In", 'carspot'),
            "base" => "login_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(),
        ));
    }
}

add_action('vc_before_init', 'login_short');

if (!function_exists('login_short_base_func')) {

    function login_short_base_func($atts, $content = '')
    {
        extract(shortcode_atts(array(
            'sb_bg_color' => '',
            'section_title' => '',
            'bg_img' => '',
        ), $atts));
        global $carspot_theme;
        if (!carspot_vc_forntend_edit()) {
            carspot_user_logged_in();
        }
        $social_login = '';
        $social_login = '';
        if ($carspot_theme['fb_api_key'] != "") {
            $social_login .= '<div class="col-md-6 col-sm-12 col-xs-12"><a class="btn btn-block btn-lg btn-social btn-facebook" onclick="hello(\'facebook\').login(' . "{scope : 'email',}" . ')"><span class="fa fa-facebook"></span>' . esc_html__('Sign in with Facebook', 'carspot') . '</a> </div>';
        }
        if ($carspot_theme['gmail_api_key'] != "") {
            $social_login .= '<div class="col-md-6 col-sm-12 col-xs-12"><a class="btn btn-block btn-social btn-google" onclick="hello(\'google\').login(' . "{scope : 'email'}" . ')">
                           <img src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'images/g-logo.png" class="img-resposive" alt="' . esc_html__('Google logo', 'carspot') . '">	' . esc_html__('Sign in with Google', 'carspot') . '</a></div>';
        }

        $authentication = new authentication();
        $code = time();
        $_SESSION['sb_nonce'] = $code;
        $if_social_login_enable = '';
        if ($social_login != "") {
            $if_social_login_enable = '<h2 class="no-span"><b>' . esc_html__('OR', 'carspot') . '</b></h2>';
        }
        global $carspot_theme;
        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
            $top_padding = '';
        }
        return ' <div class="main-content-area clearfix ">
        <section class="section-padding ' . carspot_returnEcho($top_padding) . ' gray">
            <div class="container">
               <div class="row">
                  <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                     <div class="form-grid">
						<div class="row"><div class="social-btns-grid">' . $social_login . '</div></div>
						' . $if_social_login_enable . '
					 	' . $authentication->carspot_sign_in_form($code) . '
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <!-- Main Content Area End --> 
      <!-- Forget Password -->
      <div class="custom-modal">
         <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header rte">
                     <h2 class="modal-title">' . esc_html__('Forgot Your Password ?', 'carspot') . '</h2>
                  </div>
					' . $authentication->carspot_forgot_password_form() . '
               </div>
            </div>
         </div>
      </div>';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('login_short_base', 'login_short_base_func');
}