<?php

/* ----
  Settings Starts Here
  ---- */
add_action('rest_api_init', 'carspotAPI_settings_api_hooks_get', 0);

function carspotAPI_settings_api_hooks_get()
{

    register_rest_route('carspot/v1', '/settings/',
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'carspotAPI_settings_me_get',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );

    /* fazal */
    register_rest_route('carspot/v1', '/settings/',
        array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_settings_me_get',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
    /* fazal */
}

if (!function_exists('carspotAPI_settings_me_get')) {

    function carspotAPI_settings_me_get($request)
    {
        global $carspotAPI;
        global $carspot_theme;
        $data = array();
        /* faz */
        $json_data = $request->get_json_params();
        $home_theme = '4';
        /* main theme style */
        if (isset($carspotAPI['app_home_themes']) && $carspotAPI['app_home_themes'] != "") {
            $home_theme = $carspotAPI['app_home_themes'];
        }
        $data['home_theme_type'] = $home_theme;


        /* faz */
        $app_is_open = (isset($carspotAPI['app_is_open']) && $carspotAPI['app_is_open'] == true) ? true : false;
        $data['is_app_open'] = $app_is_open;
        $data['heading'] = __("Register With Us!", "carspot-rest-api");
        $data['internet_dialog']['title'] = __("Error", "carspot-rest-api");
        $data['internet_dialog']['text'] = __("Internet not found", "carspot-rest-api");
        $data['internet_dialog']['ok_btn'] = __("Ok", "carspot-rest-api");
        $data['internet_dialog']['cancel_btn'] = __("Cancel", "carspot-rest-api");

        $data['alert_dialog']['message'] = __("Are you sure you want to do this?", "carspot-rest-api");
        $data['alert_dialog']['title'] = __("Alert!", "carspot-rest-api");

        $data['search']['text'] = __("Search Here", "carspot-rest-api");
        $data['search']['input'] = 'ad_title'; /* Static name For field name */
        $data['cat_input'] = 'ad_cats1'; /* Static name For categories */
        $data['message'] = __("Please wait!", "carspot-rest-api");

        /* Options Coming From Theme Options */

        $gmap_lang = (isset($carspotAPI['gmap_lang']) && $carspotAPI['gmap_lang'] == true) ? $carspotAPI['gmap_lang'] : 'en';
        $data['gmap_lang'] = $gmap_lang;

        $is_rtl = (isset($carspotAPI['app_settings_rtl']) && $carspotAPI['app_settings_rtl'] == true) ? true : false;
        $is_rtl_ = ($is_rtl == true) ? 'rtl' : 'ltr';
        $app_settings_rtl = csAPI_app_direction_callbacks($is_rtl_);
        $is_rtl = ($app_settings_rtl == 'rtl') ? true : false;

        $data['is_rtl'] = $is_rtl;

        $app_color = (isset($carspotAPI['app_settings_color'])) ? $carspotAPI['app_settings_color'] : '#f58936';
        $data['main_color'] = $app_color;
        $sb_location_type = (isset($carspotAPI['sb_location_type'])) ? $carspotAPI['sb_location_type'] : 'cities';
        $data['location_type'] = $sb_location_type;
        /* Some App Keys From Theme Options 
          $data['appKey']['stripe']		= (isset( $carspotAPI['appKey_stripeKey'] ) ) ? $carspotAPI['appKey_stripeKey'] : '';
          $data['appKey']['paypal']		= (isset( $carspotAPI['appKey_paypalKey'] ) ) ? $carspotAPI['appKey_paypalKey'] : ''; */

        $data['registerBtn_show']['google'] = (isset($carspotAPI['app_settings_google_btn']) && $carspotAPI['app_settings_google_btn'] == true) ? true : false;
        $data['registerBtn_show']['facebook'] = (isset($carspotAPI['app_settings_fb_btn']) && $carspotAPI['app_settings_fb_btn'] == true) ? true : false;
        $data['registerBtn_show']['apple'] = (isset($carspotAPI['app_settings_apple_btn']) && $carspotAPI['app_settings_apple_btn'] == true) ? true : false;

        $data['dialog']['confirmation'] = array(
            "title" => __("Confirmation", "carspot-rest-api"),
            "text" => __("Are you sure you want to do this.", "carspot-rest-api"),
            "btn_no" => __("Cancel", "carspot-rest-api"),
            "btn_ok" => __("Confirm", "carspot-rest-api"),
        );

        $data['notLogin_msg'] = __("Please login first.", "carspot-rest-api");
        $enable_featured_slider_scroll = (isset($carspotAPI['sb_enable_featured_slider_scroll']) && $carspotAPI['sb_enable_featured_slider_scroll'] == true) ? true : false;

        $data['featured_scroll_enabled'] = $enable_featured_slider_scroll;
        if ($enable_featured_slider_scroll) {
            $data['featured_scroll']['duration'] = (isset($carspotAPI['sb_enable_featured_slider_duration']) && $carspotAPI['sb_enable_featured_slider_duration'] == true) ? $carspotAPI['sb_enable_featured_slider_duration'] : 40;

            $data['featured_scroll']['loop'] = (isset($carspotAPI['sb_enable_featured_slider_loop']) && $carspotAPI['sb_enable_featured_slider_loop'] == true) ? $carspotAPI['sb_enable_featured_slider_loop'] : 2000;
        }

        $data['location_popup']['slider_number'] = 250;
        $data['location_popup']['slider_step'] = 5;
        $data['location_popup']['text'] = __("Select distance in (KM)", "carspot-rest-api");
        $data['location_popup']['btn_submit'] = __("Submit", "carspot-rest-api");
        $data['location_popup']['btn_clear'] = __("Clear", "carspot-rest-api");

        /* App GPS Section Starts */
        $allow_near_by = (isset($carspotAPI['allow_near_by']) && $carspotAPI['allow_near_by']) ? true : false;
        $data['show_nearby'] = $allow_near_by;
        $data['gps_popup']['title'] = __("GPS Settings", "carspot-rest-api");
        $data['gps_popup']['text'] = __("GPS is not enabled. Do you want to go to settings menu?", "carspot-rest-api");
        $data['gps_popup']['btn_confirm'] = __("Settings", "carspot-rest-api");
        $data['gps_popup']['btn_cancel'] = __("Cancel", "carspot-rest-api");
        /* App GPS Section Ends */
        /* App Rating Section Starts */
        $allow_app_rating = (isset($carspotAPI['allow_app_rating']) && $carspotAPI['allow_app_rating']) ? true : false;
        $allow_app_rating_title = (isset($carspotAPI['allow_app_rating_title']) && $carspotAPI['allow_app_rating_title'] != "") ? $carspotAPI['allow_app_rating_title'] : __("App Store Rating", "carspot-rest-api");
        $allow_app_rating_url = (isset($carspotAPI['allow_app_rating_url']) && $carspotAPI['allow_app_rating_url'] != "") ? $carspotAPI['allow_app_rating_url'] : '';
        $data['app_rating']['is_show'] = $allow_app_rating;
        $data['app_rating']['title'] = $allow_app_rating_title;
        $data['app_rating']['btn_confirm'] = __("Maybe Later", "carspot-rest-api");
        $data['app_rating']['btn_cancel'] = __("Never", "carspot-rest-api");
        $data['app_rating']['url'] = $allow_app_rating_url;
        /* App Rating Section Ends */

        /* App Share Section Starts */
        $allow_app_share = (isset($carspotAPI['allow_app_share']) && $carspotAPI['allow_app_share']) ? true : false;
        $allow_app_share_title = (isset($carspotAPI['allow_app_share_title']) && $carspotAPI['allow_app_share_title'] != "") ? $carspotAPI['allow_app_share_title'] : __("Share this", "carspot-rest-api");
        $allow_app_share_text = (isset($carspotAPI['allow_app_share_text']) && $carspotAPI['allow_app_share_text'] != "") ? $carspotAPI['allow_app_share_text'] : '';
        $allow_app_share_url = (isset($carspotAPI['allow_app_share_url']) && $carspotAPI['allow_app_share_url'] != "") ? $carspotAPI['allow_app_share_url'] : '';
        $data['app_share']['is_show'] = $allow_app_share;
        $data['app_share']['title'] = $allow_app_share_title;
        $data['app_share']['text'] = $allow_app_share_text;
        $data['app_share']['url'] = $allow_app_share_url;
        /* App Share Section Ends */
        $sb_user_guest_dp = CARSPOT_API_PLUGIN_URL . "images/user.jpg";
        if (carspotAPI_getReduxValue('sb_user_guest_dp', 'url', true)) {
            $sb_user_guest_dp = carspotAPI_getReduxValue('sb_user_guest_dp', 'url', false);
        }
        $data['guest_image'] = $sb_user_guest_dp;
        $data['guest_name'] = __("Guest", "carspot-rest-api");
        $has_value = false;
        $array_sortable = array();
        if (isset($carspotAPI['home-screen-sortable']) && $carspotAPI['home-screen-sortable'] > 0 && $carspotAPI['app_home_themes'] == '1') {
            $array_sortable = $carspotAPI['home-screen-sortable'];
            foreach ($array_sortable as $key => $val) {
                if (isset($val) && $val != "") {
                    $has_value = true;
                }
            }
        }
        $data['ads_position_sorter'] = $has_value;
        $data['menu'] = carspotAPI_settingsMenu();

        /* === WPML === */
        $data['wpml_settings']['sb_language_opt_menu'] = false;
        if (isset($carspotAPI['sb_language_opt']) && $carspotAPI['sb_language_opt'] == true) {
            $data['wpml_settings']['sb_language_opt_menu'] = true;
        }

        $data['wpml_settings']['sb_wpml_select_lang_title'] = __("Select Your Language", "carspot-rest-api");
        if (isset($carspotAPI['sb_wpml_select_lang_title']) && $carspotAPI['sb_wpml_select_lang_title'] != "") {
            $data['wpml_settings']['sb_wpml_select_lang_title'] = $carspotAPI['sb_wpml_select_lang_title'];
        }

        $is_wpml_active = false;
        if (isset($carspotAPI['enable_wpml_app']) && $carspotAPI['enable_wpml_app'] == true) {
            $is_wpml_active = true;
        }

        $is_duplicate_post = false;
        if (isset($carspotAPI['duplicate_wpml_app_posts']) && $carspotAPI['duplicate_wpml_app_posts'] == true) {
            $is_duplicate_post = true;
        }
        
        $is_display_all_post = false;
        if (isset($carspotAPI['display_all_wpml_app_posts']) && $carspotAPI['display_all_wpml_app_posts'] == true) {
            $is_display_all_post = true;
        }
        $default_logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo.png';

        $wpml_site_logo = (isset($carspotAPI['wpml_app_logo'])) ? $carspotAPI['wpml_app_logo']['url'] : $default_logo;

        /* installed wpml languages */
        $wpml_switcher_langs = array();
        $switch_wpml = array();
        if (!empty($carspotAPI["all_wpml_app_langs"])) {
            $wpml_switcher_langs = $carspotAPI["all_wpml_app_langs"];
        }
        if (is_array($wpml_switcher_langs) && count($wpml_switcher_langs) > 0) {
            foreach ($wpml_switcher_langs as $lang) {
                $switch_wpml[] = get_language_details($lang);
            }
        }
        $wpml_default_lang = 'en';
        if (class_exists('SitePress')) {
            $wpml_default_lang = ICL_LANGUAGE_CODE;
        }

        $data['is_wpml_switch_on'] = $is_wpml_active;
        $data['wpml_settings']['is_duplicate_wpml_post'] = $is_duplicate_post;
        $data['wpml_settings']['is_display_all_wpml_posts'] = $is_display_all_post;
        $data['wpml_settings']['wpml_site_logo'] = $wpml_site_logo;
        $data['wpml_settings']['wpml_site_languages'] = $switch_wpml;
        $data['wpml_settings']['wpml_site_no_languages'] = $wpml_default_lang;

        /* === end WPML === */

        $data['messages_screen']['main_title'] = __("Messages", "carspot-rest-api");
        $data['messages_screen']['sent'] = __("Sent Offers", "carspot-rest-api");
        $data['messages_screen']['receive'] = __("Offers on Ads", "carspot-rest-api");
        $data['gmap_has_countries'] = false;
        if (isset($carspot_theme['sb_location_allowed']) && $carspot_theme['sb_location_allowed'] == false && isset($carspot_theme['sb_list_allowed_country'])) {
            $data['gmap_has_countries'] = true;
            $lists = $carspot_theme['sb_list_allowed_country'];
            /* $countries = array(); foreach( $lists as $list ) { $countries[] = $list; } */
            $data['gmap_countries'] = $lists;
        }
        $data['app_show_languages'] = false;
        $languages = array();
        /* $languages[] = array("key" => "en", "value" => "English", "is_rtl" => false);
          $languages[] = array("key" => "ar", "value" => "Arabic", "is_rtl" => true);
          $languages[] = array("key" => "ro_RO", "value" => "RO Lang", "is_rtl" => false); */
        if (count($languages) > 0) {
            $data['app_text_title'] = __("Select or Search Language", "carspot-rest-api");
            $data['app_text_close'] = __("Close", "carspot-rest-api");
            $data['app_show_languages'] = true;
            $data['app_languages'] = $languages;
        }
        $data['screen_titles'] = carspotAPI_settings_screenTitles();
        $data['dealer_cinfirm_dialog'] = carspotAPI_dealer_cinfirmDialog();
        $data['allow_block'] = (isset($carspotAPI['sb_user_allow_block']) && $carspotAPI['sb_user_allow_block']) ? true : false;
        /* FOR ADMOB ADS */
        $is_show_Banner = '';
        if (isset($carspotAPI['sb_admob_switch'])) {
            if ($carspotAPI['sb_admob_switch'] == '1') {
                $is_show_Banner = 'true';
            } else {
                $is_show_Banner = 'false';
            }
        }
        $is_show_inti = '';
        if (isset($carspotAPI['sb_admob_interstitial_switch'])) {
            if ($carspotAPI['sb_admob_interstitial_switch'] == '1') {
                $is_show_inti = 'true';
            } else {
                $is_show_inti = 'false';
            }
        }
        $data['get_all_parent_terms'] = carspot_all_get_terms('ad_cats', 0);
        $data['date_time_pop_mesages']['select_date_mesg'] = __('Select Date', 'carspot-rest-api');
        $data['date_time_pop_mesages']['select_date_confirm'] = __('Confirm', 'carspot-rest-api');
        $data['date_time_pop_mesages']['select_date_cancel'] = __('Cancel', 'carspot-rest-api');
        $data['ad_mob']['banner'] = array("isShow" => $is_show_Banner, "position" => $carspotAPI['sb_admob_banner_position'], "banner_id" => $carspotAPI['sb_admob_banner_id']);
        $data['ad_mob']['interstitial'] = array("isShow" => $is_show_inti, "interval" => $carspotAPI['sb_admob_interstitial_interval'], "banner_id" => $carspotAPI['sb_admob_interstitial_id']);

        return $response = array('success' => true, 'data' => $data, 'message' => '');
    }

}


if (!function_exists('carspotAPI_is_app_open')) {

    function carspotAPI_is_app_open()
    {
        global $carspotAPI;
        $app_is_open = (isset($carspotAPI['app_is_open']) && $carspotAPI['app_is_open'] == true) ? true : false;
        $data['is_app_open'] = $app_is_open;
    }
}

if (!function_exists('carspotAPI_settingsMenu')) {

    function carspotAPI_settingsMenu()
    {
        global $carspotAPI;
        $is_show_message_count = (isset($carspotAPI['api-menu-message-count']) && $carspotAPI['api-menu-message-count']) ? true : false;
        $number_of_messages = ($is_show_message_count) ? ' (' . carspotAPI_getUnreadMessageCount() . ')' : '';
        $menu_array = array();
        $menu_data = (isset($carspotAPI['api-sortable-app-menu']) && $carspotAPI['api-sortable-app-menu']) ? $carspotAPI['api-sortable-app-menu'] : array();
        if (isset($menu_data) && count($menu_data) > 0) {
            foreach ($menu_data as $m_key => $m_val) {
                $message_count = '';
                $type = 'both';
                if ($m_key == 'login' || 'register' == $m_key) {
                    $type = 'not_login';
                }
                if ($m_key == 'logout') {
                    $type = 'only_login';
                }
                if ($m_key == 'profile') {
                    $type = 'only_login';
                }
                if ($m_key == 'inbox_list') {
                    $type = 'only_login';
                    $message_count = $number_of_messages;
                }
                //if( $m_key == 'sell_your_car' ) { $type = 'only_login'; }

                if ('dynamic_pages' != $m_key) {
                    $is_show = (isset($m_val) && trim($m_val) != "") ? true : false;
                    $menu_array[] = array("key" => $m_key, "value" => $m_val, "is_show" => $is_show, "menu_for" => $type, "message_count" => $message_count);
                } else {

                    $pages = (isset($carspotAPI['carspot_dynamic_pages']) && $carspotAPI['carspot_dynamic_pages']) ? $carspotAPI['carspot_dynamic_pages'] : array();
                    if (count($pages) > 0) {
                        foreach ($pages as $page) {
                            $page_title = get_the_title($page);
                            $page_link = get_the_permalink($page);
                            $menu_array[] = array("key" => $page_link, "value" => $page_title, "is_show" => true, "menu_for" => $type);
                            //$menu_array["$page_link"] = array("key" => $page_link, "value" => $page_title, "is_show" => true, "menu_for" => $type );
                        }
                    } else {
                        //$menu_array["$m_key"] = array();
                    }
                }
            }
        } else {
            $menu_array["home"] = array("key" => "home", "value" => __("Home", "carspot-rest-api"), "is_show" => true, "menu_for" => 'both');
        }

        return $menu_array;
    }

}


if (!function_exists('carspotAPI_settings_screenTitles')) {

    function carspotAPI_settings_screenTitles()
    {
        global $carspotAPI;
        //$screen_titles = (isset( $carspotAPI['screen_titles'] ) && $carspotAPI['screen_titles'] == true) ? true : false;
        $data = array();
        $data['home'] = $carspotAPI['sb_home_screen_title'];
        $data['profile'] = __("Profile", "carspot-rest-api");
        $data['public_profile'] = __("Profile", "carspot-rest-api");
        $data['advance_search'] = __("Advanced Search", "carspot-rest-api");
        $data['advance_search_result'] = __("Advanced Search Result", "carspot-rest-api");
        $data['support'] = __("Support", "carspot-rest-api");
        $data['inbox'] = __("Inbox", "carspot-rest-api");
        $data['offers'] = __("Offers", "carspot-rest-api");
        $data['chats'] = __("Chat", "carspot-rest-api");
        $data['sell'] = __("Sell", "carspot-rest-api");
        $data['sell_edit'] = __("Edit Ad", "carspot-rest-api");
        $data['ad_detail'] = __("Ad Detail", "carspot-rest-api");
        $data['packages'] = __("Packages", "carspot-rest-api");
        $data['blog'] = __("Blog", "carspot-rest-api");
        $data['blog_detail'] = __("Blog Detail", "carspot-rest-api");
        $data['camparison_search'] = __("Camparison Search", "carspot-rest-api");
        $data['comparison_detail'] = __("Comparison Detail", "carspot-rest-api");
        $data['review'] = __("Review", "carspot-rest-api");
        $data['review_detail'] = __("Review Detail", "carspot-rest-api");
        $data['about_us'] = __("About Us", "carspot-rest-api");
        $data['contact_us'] = __("Contact Us", "carspot-rest-api");
        return $data;
    }

}


add_action('rest_api_init', 'carspotAPI_settings_app_contact_hook', 0);

function carspotAPI_settings_app_contact_hook()
{

    register_rest_route('carspot/v1', '/app/contact/',
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'carspotAPI_settings_app_contact',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
    register_rest_route('carspot/v1', '/app/contact/',
        array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_settings_app_contact_submit',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_settings_app_contact')) {

    function carspotAPI_settings_app_contact()
    {
        $data = array();

        $data['main_title'] = __("Contact Us", "carspot-rest-api");
        $data['description'] = __("Please use the contact form below to contact us.", "carspot-rest-api");
        $user_name = $user_email = '';
        $user = wp_get_current_user();
        if ($user) {
            $user_name = $user->display_name;
            $user_email = $user->user_email;
        }

        /* Form Section */
        $data['form']['is_show'] = true;
        $data['form']['form_type'] = array('form_type' => 'app_contact_form');
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'name', "field_name" => __("Name", "carspot-rest-api"), "field_val" => $user_name, "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'email', "field_name" => __("Email", "carspot-rest-api"), "field_val" => $user_email, "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'subject', "field_name" => __("Subject", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textarea', "field_type_name" => 'message', "field_name" => __("Message", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['btn_submit'] = __("Contact Us", "carspot-rest-api");

        return $response = array('success' => true, 'data' => $data, 'message' => '');
    }

}


if (!function_exists('carspotAPI_settings_app_contact_submit')) {

    function carspotAPI_settings_app_contact_submit($request)
    {
        global $carspot_theme;
        global $carspotAPI;
        $json_data = $request->get_json_params();

        $form_type = (isset($json_data['form_type'])) ? $json_data['form_type'] : '';
        /* For Make Offer */
        $name = (isset($json_data['name'])) ? $json_data['name'] : '';
        $email = (isset($json_data['email'])) ? $json_data['email'] : '';
        $subject = (isset($json_data['subject'])) ? $json_data['subject'] : '';
        $message_desc = (isset($json_data['message'])) ? $json_data['message'] : '';
        if ($name == "" || $email == "" || $subject == "" || $message_desc == "") {
            return array('success' => false, 'data' => '', 'message' => __("All fields are required", "carspot-rest-api"));
        } else {
            $message = __("Something went wrong.", 'carspot-rest-api');
            $success = false;
            $to = "";
            if (isset($carspotAPI['carspot_app_contact_form_content']) && $carspotAPI['carspot_app_contact_form_content'] != '') {
                $get_bloginfo = get_bloginfo('name');
                $subject = '[' . $get_bloginfo . '] - ' . __('You have been contacted via contact form ', 'carspot-rest-api') . $get_bloginfo;
                $body = '<html><body><p>' . __('Someone has contacted you over ', 'carspot-rest-api') . '' . $get_bloginfo . ' </a></p></body></html>';
                $from = $get_bloginfo;
                if (isset($carspotAPI['carspot_app_contact_form_from']) && $carspotAPI['carspot_app_contact_form_from'] != "") {
                    $from = $carspotAPI['carspot_app_contact_form_from'];
                }
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $app_from = (CARSPOT_API_REQUEST_FROM == 'ios') ? 'IOS' : 'Android';
                /*  -------- $name $email $subject $message  ------- */
                $send_to = (isset($carspotAPI['carspot_app_contact_form_to']) && $carspotAPI['carspot_app_contact_form_to'] != "") ? $carspotAPI['carspot_app_contact_form_to'] : get_option('admin_email');
                $to = $send_to;
                $subject_keywords = array('%site_name%', '%app_name%');
                $subject_replaces = array($get_bloginfo, $app_from);
                $subject = str_replace($subject_keywords, $subject_replaces, $carspotAPI['carspot_app_contact_form_subject']);
                $msg_keywords = array('%site_name%', '%app_name%', '%sender_name%', '%sender_email%', '%sender_subject%', '%sender_desc%');
                $msg_replaces = array($get_bloginfo, $app_from, $name, $email, $subject, $message_desc);
                $body = str_replace($msg_keywords, $msg_replaces, $carspotAPI['carspot_app_contact_form_content']);
                $sent_email = wp_mail($to, $subject, $body, $headers);
                if ($sent_email) {
                    $message = __("Message sent successfully", 'carspot-rest-api');
                    $success = true;
                }
            }
            return array('success' => $success, 'data' => '', 'message' => $message);
        }

        return array('success' => $success, 'data' => '', 'message' => __("Something went wrong please try again.", "carspot-rest-api"));
    }
}


add_action('rest_api_init', 'carspotAPI_settings_app_aboutus_hook', 0);

function carspotAPI_settings_app_aboutus_hook()
{

    register_rest_route('carspot/v1', '/app/aboutus/',
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'carspotAPI_settings_app_aboutus',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_settings_app_aboutus')) {

    function carspotAPI_settings_app_aboutus()
    {
        global $carspotAPI;

        $main_title = (isset($carspotAPI['other-pages-1-title']) && !empty($carspotAPI['other-pages-1-title'])) ? $carspotAPI['other-pages-1-title'] : '';
        $main_desc = (isset($carspotAPI['other-pages-1-desc']) && !empty($carspotAPI['other-pages-1-desc'])) ? $carspotAPI['other-pages-1-desc'] : '';

        $data['main_title'] = $main_title;
        $data['main_desc'] = $main_desc;
        if (isset($carspotAPI['other_pages_1_show']) && $carspotAPI['other_pages_1_show']) {
            $data['list_is_show'] = true;
        } else {
            $data['list_is_show'] = false;
        }
        $lists = array();
        if (isset($carspotAPI['other-pages-1-slides']) && !empty($carspotAPI['other-pages-1-slides'])) {
            foreach ($carspotAPI['other-pages-1-slides'] as $slide) {
                $lists[] = array("title" => $slide['title'], "desc" => $slide['description'],);
            }
        }

        $data['list'] = $lists;
        return $response = array('success' => true, 'data' => $data, 'message' => '');
    }

}