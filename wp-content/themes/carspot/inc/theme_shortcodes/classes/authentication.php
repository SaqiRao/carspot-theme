<?php
// sign up form
if (!class_exists('authentication')) {

    class authentication
    {

        function carspot_sign_up_form($string, $terms, $key = '', $is_captcha = '', $key_code = '', $page_builder = '')
        {
            global $carspot_theme;
            // Check phone is required or not
            $phone_html = '<input class="form-control" name="sb_reg_contact" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" placeholder="' . esc_html__('Your Contact Number', 'carspot') . '" type="text">';
            if (isset($carspot_theme['sb_user_phone_required']) && !$carspot_theme['sb_user_phone_required']) {
                $phone_html = '<input placeholder="' . esc_html__('Your Contact Number', 'carspot') . '" class="form-control" type="text" name="sb_reg_contact">';
            }
            if ($page_builder == 'elementor') {
                $result = $string;
                $res['url'] = ($result['url'] != '') ? $result['url'] : '';
                $res['title'] = $result['title'] ? $result['title'] : '';
                $res['target'] = $result['target'] ? $result['target'] : '';
            } else {
                $res = carspot_extarct_link($string);
            }


            $captcha = '<input type="hidden" value="no" name="is_captcha" />';
            if ($is_captcha == 'with' && $key != "") {
                $captcha = '<div class="form-group">
			  <div class="g-recaptcha" data-sitekey="' . $key . '"></div>
		   </div><input type="hidden" value="yes" name="name_captcha" />
		';
            }
            if ($terms == '') {
                $terms = __('I agree with the Terms & Condition!', 'carspot');
            }
            $terms_links = '';
            $terms_links = '<label class="term-class" for="minimal-checkbox"><a href="' . $res['url'] . '" title="' . $res['title'] . '" target="' . $res['target'] . '">' . $terms . '</a></label>';
            return '<form id="sb-sign-form" >
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
				   <div class="form-group">
					  <label>' . esc_html__('Name', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Your Name', 'carspot') . '" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter your name.', 'carspot') . '" name="sb_reg_name" id="sb_reg_name">
				   </div>
			   </div>
			   <div class="col-md-6 col-sm-6 col-xs-12">
				   <div class="form-group">
					  <label>' . esc_html__('Contact Number', 'carspot') . '</label>
					  ' . $phone_html . '
				   </div>
			   </div>
		   </div>
		   <div class="row">
			   <div class="col-md-6 col-sm-6 col-xs-12">
				   <div class="form-group">
					  <label>' . esc_html__('Email', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Your Email', 'carspot') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter your valid email.', 'carspot') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
				   </div>
			   </div>
			   <div class="col-md-6 col-sm-6 col-xs-12">
				   <div class="form-group">
					  <label>' . esc_html__('Password', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Your Password', 'carspot') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter your password.', 'carspot') . '" name="sb_reg_password">
				   </div>
			   </div>
		   </div>
		   <div class="row">
			   <div class="col-md-12 col-sm-12 col-xs-12">
				   <div class="form-group">
						<label>' . esc_html__('User Type', 'carspot') . '</label>
					   <select class="form-control" data-placeholder="' . esc_html__('Select user type.', 'carspot') . '" name="sb_user_type" data-parsley-required="true" data-parsley-error-message="' . __('Please select user type.', 'carspot') . '">
								<option value="">' . esc_html__('Select user type.', 'carspot') . '</option>
								<option value="individual">' . esc_html__('Individual', 'carspot') . '</option>
								<option value="dealer">' . esc_html__('Dealer', 'carspot') . '</option>
						</select>
					</div>
				 </div>
			 </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-md-12 col-sm-12">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" data-parsley-required="true" data-parsley-error-message="' . __('Please accept terms and conditions.', 'carspot') . '" id="minimal-checkbox-1" name="minimal-checkbox-1">
							 ' . $terms_links . '
						  </li>
					   </ul>
					</div>
				 </div>
			  </div>
		   </div>
		' . $captcha . '   
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_register_submit">' . esc_html__('Register', 'carspot') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_msg">' . esc_html__('Processing...', 'carspot') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_redirect">' . esc_html__('Redirecting...', 'carspot') . '</button>
		   <br />
		   <p class="text-center"><a href="' . get_the_permalink($carspot_theme['sb_sign_in_page']) . '">' . esc_html__('Already registered? Log in here', 'carspot') . '</a>
					</p>
		   <input type="hidden" id="get_action" value="register" />
		   <input type="hidden" id="nonce" value="' . $key_code . '" />
		   <input type="hidden" id="verify_account_msg" value="' . __('Verificaton email has been sent to your email.', 'carspot') . '" />
		   <input type="hidden" id="register_nonce" value="' . wp_create_nonce('carspot_register_secure') . '"  />
		  </form>';
        }

        // sign In form
        function carspot_sign_in_form($key_code = '')
        {
            global $carspot_theme;
            return '<form id="sb-login-form" >
		   <div class="form-group">
			  <label>' . esc_html__('Email', 'carspot') . '</label>
			  <input placeholder="' . esc_html__('Your Email', 'carspot') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter your valid email.', 'carspot') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group">
			  <label>' . esc_html__('Password', 'carspot') . '</label>
			  <input placeholder="' . esc_html__('Your Password', 'carspot') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter your password.', 'carspot') . '" name="sb_reg_password">
		   </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-sm-7">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" name="is_remember" id="is_remember">
							 <label for="is_remember">' . esc_html__('Remember Me', 'carspot') . '</label>
						  </li>
					   </ul>
					</div>
				 </div>
				 <div class="col-xs-12 col-sm-5 text-right">
					<p class="help-block"><a data-target="#myModal" data-toggle="modal">' . esc_html__('Forgot password?', 'carspot') . '</a>
					</p>
				 </div>
			  </div>
		   </div>
		   
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_login_submit">' . esc_html__('Login', 'carspot') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_msg">' . esc_html__('Processing...', 'carspot') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_redirect">' . esc_html__('Redirecting...', 'carspot') . '</button>
		   <br />
		   <p class="text-center"><a href="' . get_the_permalink($carspot_theme['sb_sign_up_page']) . '">' . esc_html__('Sign up for an account.', 'carspot') . '</a>
					</p>
		   <input type="hidden" id="nonce" value="' . $key_code . '" />
		   <input type="hidden" id="get_action" value="login" />
		   <input type="hidden" id="login_nonce" value="' . wp_create_nonce('carspot_login_secure') . '"  />
		</form>';
        }

        // Forgot Password Form
        function carspot_forgot_password_form()
        {
            return '
			<form id="sb-forgot-form">
				 <div class="modal-body">
					<div class="form-group">
					  <label>' . esc_html__('Email', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Your Email', 'carspot') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . esc_html__('Please enter valid email.', 'carspot') . '" data-parsley-trigger="change" name="sb_forgot_email" id="sb_forgot_email">
					</div>
				 </div>
				 <div class="modal-footer">
					   <button class="btn btn-theme" type="submit" id="sb_forgot_submit">' . esc_html__('Reset My Account', 'carspot') . '</button>
					   <button class="btn btn-theme" type="button" id="sb_forgot_msg">' . esc_html__('Processing...', 'carspot') . '</button>
					
				 </div>
				 <input type="hidden" id="forget_psw_nonce" value="' . wp_create_nonce('carspot_forget_pwd_secure') . '"  />
		  </form>
		';
        }

    }

}

// Goog re-capthca verification
if (!function_exists('carspot_recaptcha_verify')) {

    function carspot_recaptcha_verify($api_secret, $code, $ip, $is_captcha)
    {
        if ($is_captcha == 'no')
            return true;
        global $carspot_theme;
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $api_secret . '&response=' . $code . '&remoteip=' . $ip;
        $responseData = wp_remote_get($url);
        $res = json_decode($responseData['body'], true);
        if ($res["success"] === true) {
            return true;
        } else {
            return false;
        }
    }

}

/* Ajax handler for Login User */
add_action('wp_ajax_sb_login_user', 'carspot_login_user');
add_action('wp_ajax_nopriv_sb_login_user', 'carspot_login_user');
/* Login User */

if (!function_exists('carspot_login_user')) {

    function carspot_login_user()
    {
      
        global $carspot_theme;
        check_ajax_referer('carspot_login_secure', 'security');
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $remember = false;
        if ($params['is_remember']) {
            $remember = true;
        }
        $user = wp_authenticate($params['sb_reg_email'], $params['sb_reg_password']);
        if (!is_wp_error($user)) {
            if (count((array)$user->roles) == 0) {
                echo __('Your account is not verified yet.', 'carspot');
                die();
            } else { 
                $res = carspot_auto_login($params['sb_reg_email'], $params['sb_reg_password'], $remember);
                if ($res == 1) {
                    // send_response_json_success(["success"=>true,'previous_url'=>$previous_url]);
                    // die;
                    echo "1";
                }
            }
        } else {
            echo __('Invalid email or password.', 'carspot');
        }
        die();
    }

}

// Ajax handler for Register User
add_action('wp_ajax_sb_register_user', 'carspot_register_user');
add_action('wp_ajax_nopriv_sb_register_user', 'carspot_register_user');
if (!function_exists('carspot_register_user')) {
// Register User
    function carspot_register_user()
    {
        global $carspot_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('carspot_register_secure', 'security');
        //wp_verify_nonce( $_REQUEST['reg_nonce'], 'registration-nonce' );
        if (email_exists($params['sb_reg_email']) == false) {
            if (carspot_recaptcha_verify($carspot_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['is_captcha'])) {
                $user_name = explode('@', $params['sb_reg_email']);
                $u_name = carspot_check_user_name($user_name[0]);
                $uid = wp_create_user($u_name, sanitize_text_field($params['sb_reg_password']), sanitize_text_field($params['sb_reg_email']));
                wp_update_user(array('ID' => $uid, 'display_name' => sanitize_text_field($params['sb_reg_name'])));
                update_user_meta($uid, '_sb_contact', sanitize_text_field($params['sb_reg_contact']));
                update_user_meta($uid, '_sb_user_type', $params['sb_user_type']);
                //for package based only
                if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
                    if ($carspot_theme['sb_allow_ads']) {
                        update_user_meta($uid, '_sb_simple_ads', $carspot_theme['sb_free_ads_limit']);
                        if ($carspot_theme['sb_allow_featured_ads']) {
                            update_user_meta($uid, '_carspot_featured_ads', $carspot_theme['sb_featured_ads_limit']);
                        }
                        if ($carspot_theme['sb_allow_bump_ads']) {
                            update_user_meta($uid, '_carspot_bump_ads', $carspot_theme['sb_bump_ads_limit']);
                        }
                        if ($carspot_theme['sb_package_validity'] == '-1') {
                            update_user_meta($uid, '_carspot_expire_ads', $carspot_theme['sb_package_validity']);
                        } else {
                            $days = $carspot_theme['sb_package_validity'];
                            $expiry_date = date('Y-m-d', strtotime("+$days days"));
                            update_user_meta($uid, '_carspot_expire_ads', $expiry_date);
                        }
                    } else {
                        update_user_meta($uid, '_sb_simple_ads', 0);
                        update_user_meta($uid, '_carspot_featured_ads', 0);
                        update_user_meta($uid, '_carspot_bump_ads', 0);
                        update_user_meta($uid, '_carspot_expire_ads', '');
                    }
                }

                /* Email for new user */
                if (function_exists('carspot_email_on_new_user')) {
                    carspot_email_on_new_user($uid, '');
                }

                if (isset($carspot_theme['sb_new_user_email_verification']) && $carspot_theme['sb_new_user_email_verification']) {
                    $user = new WP_User($uid);
                    /* Remove all user roles after registration */
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    echo 2;
                    die();
                } else {
                    carspot_auto_login($params['sb_reg_email'], $params['sb_reg_password'], true);
                    echo 1;
                    die();
                }
            } else {
                echo esc_html__('please verify captcha code', 'carspot');
            }
        } else {
            echo esc_html__('Email already exist, please try other one.', 'carspot');
        }
        die();
    }

}


if (!function_exists('carspot_auto_login')) {

    function carspot_auto_login($username, $password, $remember)
    {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;
        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return false;
        } else {
            if (count((array)$user->roles) > 0) {
                return true;
            } else {
                return 2;
            }
        }
    }

}
//associating a function to login hook
add_action('wp_login', 'carspot_set_last_login');

//function for setting the last login
if (!function_exists('carspot_set_last_login')) {

    function carspot_set_last_login($login)
    {
        $user = get_user_by('login', $login);
        //add or update the last login value for logged in user
        update_user_meta($user->ID, '_sb_last_login', time());
    }

}
// Last login time
if (!function_exists('carspot_get_last_login')) {

    function carspot_get_last_login($uid)
    {
        $from = get_user_meta($uid, '_sb_last_login', true);
        $last = ($from) ? $from : time();
        return human_time_diff($last, time());
    }

}


// Ajax handler for Social login
add_action('wp_ajax_sb_social_login', 'carspot_check_social_user');
add_action('wp_ajax_nopriv_sb_social_login', 'carspot_check_social_user');
if (!function_exists('carspot_check_social_user')) {

    function carspot_check_social_user()
    {
        global $wp_session;
        $network = (isset($_POST['sb_network'])) ? $_POST['sb_network'] : '';
        $response_response = false;
        $user_name = "";
        if ($network == 'facebook') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://graph.facebook.com/me?fields=name,email&access_token=$access_token");
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
        } else if ($network == 'google') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=$access_token");
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
        }
        if ($response_response == false) {
            echo '0|error|Invalid request|Diret Access not allowed';
            die();
        }
        if ($_SESSION['sb_nonce'] == $_POST['key_code']) {
            // $user_name = $_POST['email'];
            unset($_SESSION['sb_nonce']);
            $_SESSION['sb_nonce'] = time();
            $exists = email_exists($user_name);
            if ($exists) {
                $user = get_user_by('email', $user_name);
                $user_id = $user->ID;
                if ($user) {
                    wp_set_current_user($user_id, $user->user_login);
                    wp_set_auth_cookie($user_id);
                    echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're logged in successfully.", 'carspot');
                }
            } else {
                // Here we need to register user.
                $password = mt_rand(1000, 10000);
                $uid = carspot_do_register($user_name, $password);
                global $carspot_theme;
                if (function_exists('carspot_email_on_new_user')) {
                    carspot_email_on_new_user($uid, $password);
                }
                echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're registered and logged in successfully.", 'carspot');
            }
        } else {
            echo '0|error|Invalid request|Diret Access not allowed';
        }
        die();
    }

}


if (!function_exists('carspot_user_not_logged_in')) {

    function carspot_user_not_logged_in()
    {
        global $carspot_theme;
        if (!is_user_logged_in() ) {
            echo carspot_redirect(get_the_permalink($carspot_theme['sb_sign_in_page']));
        }
    }

}
if (!function_exists('carspot_user_logged_in')) {

    function carspot_user_logged_in()
    {
        if (get_current_user_id() != 0) {
            echo carspot_redirect(home_url('/'));
        }
    }

}
if (!function_exists('carspot_check_user_name')) {

    function carspot_check_user_name($username = '')
    {
        if (username_exists($username)) {
            $random = rand();
            $username = $username . '-' . $random;
            carspot_check_user_name($username);
        }
        return $username;
    }

}

add_action('wp_ajax_sb_reset_password', 'carspot_reset_password');
add_action('wp_ajax_nopriv_sb_reset_password', 'carspot_reset_password');
// Reset Password
if (!function_exists('carspot_reset_password')) {
    function carspot_reset_password()
    {
        global $carspot_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $token = $params['token'];
        $token_arr = explode('-sb-uid-', $token);
        $key = $token_arr[0];
        $uid = $token_arr[1];
        $token_db = get_user_meta($uid, 'sb_password_forget_token', true);
        if ($token_db != $key) {
            echo '0|' . esc_html__("Invalid security token.", 'carspot');
        } else {
            $new_password = $params['sb_new_password'];
            wp_set_password($new_password, $uid);
            update_user_meta($uid, 'sb_password_forget_token', '');
            echo '1|' . esc_html__("Password Changed successfully.", 'carspot');
        }
        die();
    }
}

if (!function_exists('carspot_do_register')) {

    function carspot_do_register($email = '', $password = '')
    {
        global $carspot_theme;
        $user_name = explode('@', $email);
        $u_name = carspot_check_user_name($user_name[0]);
        $uid = wp_create_user($u_name, $password, $email);
        wp_update_user(array('ID' => $uid, 'display_name' => $u_name));
        carspot_auto_login($email, $password, true);

        //for package based only
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
            if ($carspot_theme['sb_allow_ads']) {
                update_user_meta($uid, '_sb_simple_ads', $carspot_theme['sb_free_ads_limit']);
                if ($carspot_theme['sb_allow_featured_ads']) {
                    update_user_meta($uid, '_carspot_featured_ads', $carspot_theme['sb_featured_ads_limit']);
                }
                if ($carspot_theme['sb_allow_bump_ads']) {
                    update_user_meta($uid, '_carspot_bump_ads', $carspot_theme['sb_bump_ads_limit']);
                }
                if ($carspot_theme['sb_package_validity'] == '-1') {
                    update_user_meta($uid, '_carspot_expire_ads', $carspot_theme['sb_package_validity']);
                } else {
                    $days = $carspot_theme['sb_package_validity'];
                    $expiry_date = date('Y-m-d', strtotime("+$days days"));
                    update_user_meta($uid, '_carspot_expire_ads', $expiry_date);
                }
            } else {
                update_user_meta($uid, '_sb_simple_ads', 0);
                update_user_meta($uid, '_carspot_featured_ads', 0);
                update_user_meta($uid, '_carspot_bump_ads', 0);
                update_user_meta($uid, '_carspot_expire_ads', '');
            }
        }
        return $uid;
    }
}