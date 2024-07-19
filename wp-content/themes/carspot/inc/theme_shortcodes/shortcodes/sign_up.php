<?php
/* ------------------------------------------------ */
/* Sign Up */
/* ------------------------------------------------ */
if (!function_exists('register_short')) {

    function register_short()
    {
        vc_map(array(
            "name" => esc_html__("Sign Up", 'carspot'),
            "base" => "register_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                carspot_generate_type(esc_html__('Terms & Conditions', 'carspot'), 'vc_link', 'terms_link'),
                carspot_generate_type(esc_html__('Terms & Condition Title', 'carspot'), 'textfield', 'terms_title'),
                carspot_generate_type(esc_html__('Capcha Code', 'carspot'), 'dropdown', 'is_captcha', esc_html__("Captcha is for stop spamming", 'carspot'), "", array("Please select" => "", "With Capcha" => "with", "Without Capcha" => "without")),
            ),
        ));
    }
}

add_action('vc_before_init', 'register_short');
if (!function_exists('register_short_base_func')) {

    function register_short_base_func($atts, $content = '')
    {
        // print_r("shortcode issue");
        extract(shortcode_atts(array(
            'terms_link' => '',
            'terms_title' => '',
            'section_title' => '',
            'is_captcha' => '',
        ), $atts));

        global $carspot_theme;
        $register_process = isset($carspot_theme['cs_register_proces']) ? $carspot_theme['cs_register_proces'] : true;

        $singnup_flag = false;
        // print_r("again shortcode");
        if (isset($register_process) && $register_process) {
            $singnup_flag = true;
            // echo "if";

        } else if (current_user_can('administrator')) {
            $singnup_flag = true;
            // echo "if else";
        }
        else
        {
            // echo "else";
            $singnup_flag = true;
        }

        // print_r($singnup_flag);
        if ($singnup_flag) {
            if (!carspot_vc_forntend_edit()) {
                carspot_user_logged_in();
            }
            $rows = vc_param_group_parse_atts($atts['features']);

            $features = '';
            if (count((array) $rows) > 0) {
                foreach ($rows as $row) {
                    $icon = '';
                    if (isset($row['image'])) {
                        $img = wp_get_attachment_image_src($row['image'], 'full');
                        $icon = '<div class="features-icons"><img src="' . esc_url($img[0]) . '" alt="' . esc_html__('image', 'carspot') . '"></div>';
                    }
                    $title = '';
                    if (isset($row['title'])) {
                        if (isset($row['link'])) {
                            $res = carspot_extarct_link($row['link']);
                            $title = '<h3><a href="' . esc_url($res['url']) . '" title="' . esc_attr($res['title']) . '" target="' . $res['target'] . '">' . $row['title'] . '</a></h3>';
                        } else {
                            $title = '<h3>' . $row['title'] . '</h3>';
                        }
                    }
                    $desc = '';
                    if (isset($row['description'])) {
                        $desc = '<p>' . $row['description'] . '</p>';
                    }
                    $features .= '<div class="features">
                           ' . $icon . '
                           <div class="features-text"> ' . $title . ' ' . $desc . ' </div>
                        </div>';
                }
            }

            global $carspot_theme;
            $social_login = '';
            if ($carspot_theme['fb_api_key'] != "") {
                $social_login .= '<div class="col-md-6 col-sm-12 col-xs-12"><a class="btn btn-lg btn-block btn-social btn-facebook" onclick="hello(\'facebook\').login(' . "{scope : 'email',}" . ')"><span class="fa fa-facebook"></span>' . esc_html__('Sign up with Facebook', 'carspot') . ' </a> </div>';
            }
            if ($carspot_theme['gmail_api_key'] != "") {
                $social_login .= '<div class="col-md-6 col-sm-12 col-xs-12"><a class="btn btn-block btn-social btn-google" onclick="hello(\'google\').login(' . "{scope : 'email'}" . ')">
                           <img src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'images/g-logo.png" class="img-resposive" alt="' . esc_html__('Google logo', 'carspot') . '">	' . esc_html__('Sign up with Google', 'carspot') . '</a></div>';
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

            $class = 'style="display:none;"';
            return ' <div class="main-content-area clearfix">
         <section class="section-padding ' . carspot_returnEcho($top_padding) . ' gray">
            <div class="container">
               <div class="row">
                   <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                     <div class="form-grid">
					 
					 <div class="form-group resend_email" ' . $class . '>
                	<div role="alert" class="alert alert-success alert-outline alert-dismissible ">
                	<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
                	' . __('You did not get the e-mail? RESEND NOW', 'carspot') . '<a href="javascript:void(0)"  id="resend_email"> <strong>' . __('Resend now.', 'carspot') . ' </strong></a>
                	</div>
                	</div>
                					 
                					 <div class="form-group  contact_admin" ' . $class . '>
                	<div role="alert" class="alert alert-success alert-outline alert-dismissible ">
                	<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
                	' . __('You still haven’t received the e-mail? Contact the Administrator', 'carspot') . '<a href="' . trailingslashit(get_the_permalink($carspot_theme['admin_contact_page'])) . '"  id="resend_email"> <strong>' . __('You still haven’t received the e-mail? Contact the Administrator.', 'carspot') . '</strong></a>
                	</div>
                	</div>
					 
					 
					<div class="row"><div class="social-btns-grid">' . $social_login . '</div></div>
					' . $if_social_login_enable . '
				 	' . $authentication->carspot_sign_up_form($terms_link, $terms_title, $carspot_theme['google_api_key'], $is_captcha, $code) . '
                   </div>
                  </div>
               </div>
            </div>
         </section>
      </div>';
         }else {
            wp_redirect(home_url());
            exit;
        }
 }}
   

if (function_exists('carspot_add_code')) {
    carspot_add_code('register_short_base', 'register_short_base_func');
}
