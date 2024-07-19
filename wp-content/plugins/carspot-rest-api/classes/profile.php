<?php

/* ----- 	Profile Starts Here	 ----- */
add_action('rest_api_init', 'carspotAPI_profile_api_update_img', 0);

function carspotAPI_profile_api_update_img() {
    register_rest_route(
            'carspot/v1', '/profile/image/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_update_img',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

function carspotAPI_custom_upload_mimes_here($mimes = array()) {
    $mimes['image'] = "image/jpeg";
    return $mimes;
}

add_action('upload_mimes', 'carspotAPI_custom_upload_mimes_here');
if (!function_exists('carspotAPI_profile_update_img')) {

    function carspotAPI_profile_update_img($request) {
        $user = wp_get_current_user();
        $user_id = @$user->data->ID;
        if ($user) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            define('ALLOW_UNFILTERED_UPLOADS', true);
            $attach_id = media_handle_upload('profile_img', 0);
            /*             * ***** Assign image to user *********** */
            if (is_wp_error($attach_id)) {
                $response = array('success' => false, 'data' => '', 'message' => esc_html__("Something went wrong while uploading image.", "carspot-rest-api"),);
            } else {

                update_user_meta($user_id, '_sb_user_pic', $attach_id);
                $image_link = wp_get_attachment_image_src($attach_id, 'carspot-user-profile');
                $profile_arr = array();
                $profile_arr['id'] = $user->ID;
                $profile_arr['user_email'] = $user->user_email;
                $profile_arr['display_name'] = $user->display_name;
                $profile_arr['phone'] = get_user_meta($user->ID, '_sb_contact', true);
                $profile_arr['profile_img'] = $image_link[0];
                $response = array('success' => true, 'data' => $profile_arr, 'message' => esc_html__("Profile image updated successfully", "carspot-rest-api"));
            }
        } else {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("You must be login to update the profile image.", "carspot-rest-api"), "extra" => '');
        }
        return $response;
    }

}

if (!function_exists('carspotAPI_profile_update_img11')) {

    function carspotAPI_profile_update_img11($request) {
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        //if ( ! function_exists( 'wp_handle_upload' ) ){
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        //}
        $uploadedfile = $_FILES['profile_img'];
        /*         * ***** user_photo Upload code *********** */
        $upload_overrides = array('test_form' => false);
        $movefile = media_handle_upload($uploadedfile, $upload_overrides);

        /*         * ***** Assign image to user *********** */
        $filename = $movefile['url'];
        $absolute_file = $movefile['file'];

        $extraData = wp_read_image_metadata($filename);

        $parent_post_id = 0;
        $filetype = wp_check_filetype(basename($filename), null);
        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        /* Insert the attachment. */
        $attach_id = wp_insert_attachment($attachment, $absolute_file, $parent_post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $absolute_file);
        //$attach_data = wp_get_attachment_image( $attach_id );
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($parent_post_id, $attach_id);
        update_user_meta($user_id, '_sb_user_pic', $attach_id);

        $idata['profile_img'] = $movefile['url'];
        $response = array('success' => true, 'data' => $idata, 'message' => esc_html__("Profile image updated successfully", "carspot-rest-api"), "extraData" => $extraData);
        return $response;
    }

}

add_action('rest_api_init', 'carspotAPI_profile_store_img_hook', 0);

function carspotAPI_profile_store_img_hook() {
    register_rest_route(
            'carspot/v1', '/profile/image_store/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_store_img',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_store_img')) {

    function carspotAPI_profile_store_img($request) {
        $user = wp_get_current_user();
        $user_id = @$user->data->ID;
        if ($user) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            define('ALLOW_UNFILTERED_UPLOADS', true);
            $attach_id = media_handle_upload('store_img', 0);

            /* issue with client when he upload .png converted image this code is working on his site */
//            $allowed_file_types = array('jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
//            $overrides = array('test_form' => false, 'mimes' => $allowed_file_types);
//            $attach_id = wp_handle_upload($_FILES['store_img'], $overrides);
//            $filename = $attach_id['url'];
//            $absolute_file = $attach_id['file'];
//            $parent_post_id = $user_id;
//            $filetype = wp_check_filetype(basename($filename), null);
//            $wp_upload_dir = wp_upload_dir();
//            $attachment = array(
//                'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
//                'post_mime_type' => $filetype['type'],
//                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
//                'post_content' => '',
//                    /* 'post_status'    => 'inherit' */
//            );

//            $attach_id = wp_insert_attachment($attachment, $absolute_file, $parent_post_id);
            /* end issue with client when he upload .png converted image */

            /*             * **** Assign image to user *********** */
            if (is_wp_error($attach_id)) {
                $response = array('success' => false, 'data' => '', 'message' => esc_html__("Something went wrong while uploading image.", "carspot-rest-api"),);
            } else {
                update_user_meta($user_id, '_sb_store_pic', $attach_id);
                $image_link = wp_get_attachment_image_src($attach_id, 'carspot-user-profile');
                $profile_arr = array();
                $profile_arr['profile_img'] = $image_link[0];
                $response = array('success' => true, 'data' => $profile_arr, 'message' => esc_html__("Store image updated successfully", "carspot-rest-api"));
            }
        } else {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("You must be login to update the Store image.", "carspot-rest-api"), "extra" => '');
        }
        return $response;
    }

}

if (!function_exists('carspotAPI_get_dealer_store_front')) {

    function carspotAPI_get_dealer_store_front($user_id, $size = 'full') {
        global $carspot_theme;
        $image_link = array();
        if (get_user_meta($user_id, '_sb_store_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_store_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }
        if (isset($image_link[0]) && $image_link[0] != "") {
            return $image_link[0];
        } else {
            return false;
        }
    }

}


add_action('rest_api_init', 'carspotAPI_profile_api_profile_delete', 0);
function carspotAPI_profile_api_profile_delete() {
    register_rest_route(
            'carspot/v1', '/profile-delete/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_delete',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_delete')) {
    function carspotAPI_profile_delete($request) {
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id']) && $json_data['user_id']) ? $json_data['user_id'] : "";
        
         if(get_current_user_id() == $user_id){
                 require_once(ABSPATH.'wp-admin/includes/user.php' );
                 $success = wp_delete_user( (int)$user_id );
                 
                 
                if ( is_wp_error( $success ) ) {
                    $error_string = $result->get_error_message();
                    $response = array('success' => false, 'message' => $error_string);
                } else{
                    $response = array('success' => true, 'message' => esc_html__("User Deleted.", "carspot-rest-api"));
                }               
                 
             }
             else{
                 $response = array('success' => false, 'message' => esc_html__("You can not delete this user.", "carspot-rest-api"));
             }
            
            return $response;

  
    }
}


/* Edit Profile */
add_action('rest_api_init', 'carspotAPI_profile_api_ads_hooks_post', 0);

function carspotAPI_profile_api_ads_hooks_post() {
    register_rest_route(
            'carspot/v1', '/profile/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_post',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}


if (!function_exists('carspotAPI_profile_post')) {

    function carspotAPI_profile_post($request) {
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $json_data = $request->get_json_params();
        $name = (isset($json_data['user_name'])) ? trim($json_data['user_name']) : '';
        $location = (isset($json_data['sb_address'])) ? trim($json_data['sb_address']) : '';
        $location_lat = (isset($json_data['sb_user_address_lat'])) ? trim($json_data['sb_user_address_lat']) : '';
        $location_long = (isset($json_data['sb_user_address_long'])) ? trim($json_data['sb_user_address_long']) : '';
        $phone = (isset($json_data['phone_number'])) ? trim($json_data['phone_number']) : '';
        $accountType = (isset($json_data['account_type'])) ? trim($json_data['account_type']) : '';
        $user_introduction = (isset($json_data['sb_user_about'])) ? trim($json_data['sb_user_about']) : '';

        if ($name == "") {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Please enter name.", "carspot-rest-api"));
            return $response;
        }
        if ($phone == "") {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Please enter phone number.", "carspot-rest-api"));
            return $response;
        }
        $saved_ph = get_user_meta($user_id, '_sb_contact', true);

        if ($phone != "") {
            update_user_meta($user_id, '_sb_contact', $phone);
        }
        if ($location != "") {
            update_user_meta($user_id, '_sb_address', $location);
        }
        if ($location_lat != "") {
            update_user_meta($user_id, '_sb_user_address_lat', $location_lat);
        }
        if ($location_long != "") {
            update_user_meta($user_id, '_sb_user_address_long', $location_long);
        }
        if ($saved_ph != $phone) {
            update_user_meta($user_id, '_sb_is_ph_verified', '0');
        }
        if ($accountType != "") {
            update_user_meta($user_id, '_sb_user_type', $accountType);
        }
        if ($name != "") {
            $user_name = wp_update_user(array('ID' => $user_id, 'display_name' => $name));
        }

        $sb_userType = get_user_meta($user_id, '_sb_user_type', true);

        if ($sb_userType == 'dealer') {
            $sb_camp_name = (isset($json_data['sb_camp_name'])) ? trim($json_data['sb_camp_name']) : '';
            $sb_user_lisence = (isset($json_data['sb_user_lisence'])) ? trim($json_data['sb_user_lisence']) : '';
            $sb_user_timings = (isset($json_data['sb_user_timings'])) ? trim($json_data['sb_user_timings']) : '';
            $sb_user_facebook = (isset($json_data['sb_user_facebook'])) ? trim($json_data['sb_user_facebook']) : '';
            $sb_user_twitter = (isset($json_data['sb_user_twitter'])) ? trim($json_data['sb_user_twitter']) : '';
            $sb_user_linkedin = (isset($json_data['sb_user_linkedin'])) ? trim($json_data['sb_user_linkedin']) : '';
            $sb_user_youtube = (isset($json_data['sb_user_youtube'])) ? trim($json_data['sb_user_youtube']) : '';

            update_user_meta($user_id, '_sb_camp_name', ($sb_camp_name));
            update_user_meta($user_id, '_sb_user_lisence', ($sb_user_lisence));
            update_user_meta($user_id, '_sb_user_timings', ($sb_user_timings));
            update_user_meta($user_id, '_sb_user_facebook', ($sb_user_facebook));
            update_user_meta($user_id, '_sb_user_twitter', ($sb_user_twitter));
            update_user_meta($user_id, '_sb_user_linkedin', ($sb_user_linkedin));
            update_user_meta($user_id, '_sb_user_youtube', ($sb_user_youtube));
        }
        /* update user info here */
        update_user_meta($user_id, '_sb_user_intro', $user_introduction);
        update_user_meta($user_id, '_sb_user_about', $user_introduction);
        /* Social profile Starts */
        $social_profiles = carspotAPI_social_profiles();
        if (isset($social_profiles) && count($social_profiles) > 0) {
            foreach ($social_profiles as $key => $val) {
                $keyName = '';
                $keyName = "_sb_profile_" . $key;
                /* $keyVal  = get_user_meta( $user->ID, $keyName, true ); */
                $social = (isset($json_data['social_icons'][$keyName])) ? trim($json_data['social_icons'][$keyName]) : '';
                update_user_meta($user_id, $keyName, sanitize_textarea_field($social));
            }
        }
        /* Social Profile Ends */
        $data = carspotAPI_basic_profile_data($user_id);
        $page_title['page_title'] = esc_html__("Edit Profile", "carspot-rest-api");
        $response = array('success' => true, 'data' => $data, 'message' => esc_html__("Profile Updated.", "carspot-rest-api"), 'page_title' => $page_title);
        return $response;
    }

}
/* Edit Profile Ends */
add_action('rest_api_init', 'carspotAPI_profile_reset_pass_hooks_post', 0);

function carspotAPI_profile_reset_pass_hooks_post() {
    register_rest_route(
            'carspot/v1', '/profile/reset_pass/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_reset_pass_post',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
    register_rest_route(
            'carspot/v1', '/profile/reset_pass/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_reset_password_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_reset_pass_post')) {

    function carspotAPI_profile_reset_pass_post($request) {
        if (CARSPOT_API_ALLOW_EDITING == false) {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Editing Not Allowed In Demo", "carspot-rest-api"));
            return $response;
        }

        $json_data = $request->get_json_params();
        $old_pass = (isset($json_data['old_pass'])) ? trim($json_data['old_pass']) : '';
        $new_pass = (isset($json_data['new_pass'])) ? trim($json_data['new_pass']) : '';
        $new_pass_con = (isset($json_data['new_pass_con'])) ? trim($json_data['new_pass_con']) : '';

        if ($old_pass == "") {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Please enter current password", "carspot-rest-api"));
            return $response;
        }
        if ($new_pass == "") {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Please enter new password", "carspot-rest-api"));
            return $response;
        }
        if ($new_pass != $new_pass_con) {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Password confirm password mismatched", "carspot-rest-api"));
            return $response;
        }
        $user = get_user_by('ID', get_current_user_id());
        if ($user && wp_check_password($old_pass, $user->data->user_pass, $user->ID)) {
            wp_set_password($new_pass, $user->ID);
            $response = array('success' => true, 'data' => '', 'message' => esc_html__("Password successfully chnaged", "carspot-rest-api"));
            return $response;
        } else {
            $response = array('success' => false, 'data' => '', 'message' => esc_html__("Invalid old password", "carspot-rest-api"));
            return $response;
        }
        die();
    }

}

add_action('rest_api_init', 'carspotAPI_profile_forgot_pass_hooks_post', 0);

function carspotAPI_profile_forgot_pass_hooks_post() {
    register_rest_route(
            'carspot/v1', '/profile/forgot_pass/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_forgot_pass_post',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_forgot_pass_post')) {

    function carspotAPI_profile_forgot_pass_post($request) {
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $json_data = $request->get_json_params();
        $old_pass = (isset($json_data['old_pass'])) ? trim($json_data['old_pass']) : '';
    }

}
/* API custom endpoints for WP-REST API */
add_action('rest_api_init', 'carspotAPI_profile_api_hooks_get', 0);

function carspotAPI_profile_api_hooks_get() {
    register_rest_route(
            'carspot/v1', '/profile/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_myProfile_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );

    register_rest_route(
            'carspot/v1', '/profile_ads/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_myProfile_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_myProfile_get')) {

    function carspotAPI_myProfile_get($request) {
        global $carspotAPI;
        global $carspot_theme;
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';
        $user = wp_get_current_user();
        $profile_arr['id'] = $user->ID;
        $profile_arr['user_email'] = array("key" => esc_html__("Email", "carspot-rest-api"), "value" => $user->user_email, "placeholder" => esc_html__("Enter Email", "carspot-rest-api"), "field_name" => "user_email");
        $profile_arr['display_name'] = array("key" => esc_html__("Name", "carspot-rest-api"), "value" => $user->display_name, "placeholder" => esc_html__("Enter Name", "carspot-rest-api"), "field_name" => "user_name");
        $profile_arr['phone'] = array("key" => esc_html__("Phone Number", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_contact', true), "placeholder" => esc_html__("Enter phone number", "carspot-rest-api"), "field_name" => "phone_number");
        $profile_arr['address'] = array("key" => esc_html__("Address", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_address', true), "placeholder" => esc_html__("Enter address", "carspot-rest-api"), "field_name" => "user_addres");

        /* Profile Work for New Feature Against Dealers Starts */
        $latitude = $carspot_theme['sb_default_lat'];
        $longitude = $carspot_theme['sb_default_long'];
        if (get_user_meta($user->ID, '_sb_user_address_lat', true) != '') {
            $longitude = get_user_meta($user->ID, '_sb_user_address_lat', true);
        }
        if (get_user_meta($user->ID, '_sb_user_address_long', true) != '') {
            $longitude = get_user_meta($user->ID, '_sb_user_address_long', true);
        }
        $sb_user_type = get_user_meta($user->ID, '_sb_user_type', true);
        $sb_user_type_is_show = ($sb_user_type == "dealer") ? true : false;
        $profile_arr['dealer_details_is_show'] = $sb_user_type_is_show;
        $profile_arr['dealer_details']['section_title'] = esc_html__("Dealer's Detail", "carspot-rest-api");
        $profile_arr['dealer_details']['company_name'] = array("key" => esc_html__("Company Name", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_camp_name', true), "placeholder" => esc_html__("Company Name", "carspot-rest-api"), "field_name" => "sb_camp_name", "field_type_name" => "textfield");
        $profile_arr['dealer_details']['user_web_url'] = array("key" => esc_html__("Website URL", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_web_url', true), "placeholder" => esc_html__("Website URL", "carspot-rest-api"), "field_name" => "sb_user_web_url", "field_type_name" => "textfield_url");
        $profile_arr['dealer_details']['user_lisence'] = array("key" => esc_html__("License No.  (For Admin Only)", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_lisence', true), "placeholder" => esc_html__("License No.", "carspot-rest-api"), "field_name" => "sb_user_lisence", "field_type_name" => "textfield");
        $profile_arr['dealer_details']['opening_hours'] = array("key" => esc_html__("Opening Hours", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_timings', true), "placeholder" => esc_html__("Opening Hours", "carspot-rest-api"), "field_name" => "sb_user_timings", "field_type_name" => "textfield");
        $profile_arr['dealer_details']['company_address'] = array("key" => esc_html__("Address", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_address', true), "placeholder" => esc_html__("Address", "carspot-rest-api"), "field_name" => "sb_address", "field_type_name" => "textfield");
        $profile_arr['dealer_details']['company_address_lat'] = array("key" => esc_html__("Latitude", "carspot-rest-api"), "value" => $latitude, "placeholder" => esc_html__("Latitude", "carspot-rest-api"), "field_name" => "sb_user_address_lat", "field_type_name" => "textfield");
        $profile_arr['dealer_details']['company_address_long'] = array("key" => esc_html__("Longitude", "carspot-rest-api"), "value" => $longitude, "placeholder" => esc_html__("Longitude", "carspot-rest-api"), "field_name" => "sb_user_address_long", "field_type_name" => "textfield");

        //Need some work
        $profile_arr['dealer_details']['store_front_image'] = array("key" => esc_html__("Store Front Image", "carspot-rest-api"), "value" => 'need to work for image funcationality.', "placeholder" => esc_html__("Store Front Image", "carspot-rest-api"), "field_name" => "my_store_file", "field_type_name" => "image");
        $profile_arr['dealer_details']['about_company'] = array("key" => esc_html__("About Yourself", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_about', true), "placeholder" => esc_html__("About Yourself", "carspot-rest-api"), "field_name" => "sb_user_about", "field_type_name" => "textarea");
        $profile_arr['dealer_details']['social']['facebook'] = array("key" => esc_html__("Facebook Link", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_facebook', true), "placeholder" => esc_html__("Facebook Link", "carspot-rest-api"), "field_name" => "sb_user_facebook", "field_type_name" => "textfield_url");
        $profile_arr['dealer_details']['social']['twitter'] = array("key" => esc_html__("Twitter Link", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_twitter', true), "placeholder" => esc_html__("Twitter Link", "carspot-rest-api"), "field_name" => "sb_user_twitter", "field_type_name" => "textfield_url");
        $profile_arr['dealer_details']['social']['linkedIn'] = array("key" => esc_html__("LinkedIn Profile", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_linkedin', true), "placeholder" => esc_html__("LinkedIn Profile", "carspot-rest-api"), "field_name" => "sb_user_linkedin", "field_type_name" => "textfield_url");
        $profile_arr['dealer_details']['social']['youtube'] = array("key" => esc_html__("Youtube Channel", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_user_youtube', true), "placeholder" => esc_html__("Youtube Channel", "carspot-rest-api"), "field_name" => "sb_user_youtube", "field_type_name" => "textfield_url");
        /* Profile Work for New Feature Against Dealers Ends */

        $social_profiles = carspotAPI_social_profiles();
        $profile_arr['is_show_social'] = false;
        if (isset($social_profiles) && count($social_profiles) > 0) {
            $profile_arr['is_show_social'] = true;
            foreach ($social_profiles as $key => $val) {
                $keyName = '';
                $keyName = "_sb_profile_" . $key;
                $keyVal = get_user_meta($user->ID, $keyName, true);
                $keyVal = ($keyVal) ? $keyVal : '';
                $profile_arr['social_icons'][] = array("key" => $val, "value" => $keyVal, "field_name" => $keyName);
            }
        }

        $sb_user_type_text = '';
        $package_type = get_user_meta($user->ID, '_sb_pkg_type', true);
        $package_type = ($package_type == 'free' || $package_type == "") ? esc_html__('Free', 'carspot-rest-api') : esc_html__('Paid', 'carspot-rest-api');
        $profile_arr['package_type'] = array("key" => esc_html__("Package Type", "carspot-rest-api"), "value" => $package_type, "field_name" => "package_type");
        $profile_arr['account_type'] = array("key" => esc_html__("Account Type", "carspot-rest-api"), "value" => $sb_user_type_text, "field_name" => "account_type");
        $profile_arr['location'] = array("key" => esc_html__("Location", "carspot-rest-api"), "value" => get_user_meta($user->ID, '_sb_address', true), "field_name" => "location");
        $profile_arr['profile_img'] = array("key" => esc_html__("Image", "carspot-rest-api"), "value" => carspotAPI_user_dp($user->ID), "field_name" => "profile_img");
        $store_img_url = carspotAPI_get_dealer_store_front($user->ID, 'full');
        $store_img_url = ($store_img_url) ? $store_img_url : "";
        $profile_arr['store_img'] = $store_img_url;

        $sb_expire_ads = get_user_meta($user->ID, '_carspot_expire_ads', true);
        $expiery_date = ($sb_expire_ads != '-1') ? $sb_expire_ads : esc_html__("Never", "carspot-rest-api");
        $profile_arr['expire_date'] = array("key" => esc_html__("Expiry date", "carspot-rest-api"), "value" => $expiery_date, "field_name" => "expire_date");
        $profile_arr['blocked_users_show'] = (isset($carspotAPI['sb_user_allow_block']) && $carspotAPI['sb_user_allow_block']) ? true : false;
        $profile_arr['blocked_users'] = array("key" => esc_html__("Blocked Users", "carspot-rest-api"), "value" => esc_html__("Click Here", "carspot-rest-api"), "field_name" => "blocked_users");
        $sb_simple_ads = get_user_meta($user->ID, '_sb_simple_ads', true);
        $sb_simple_ads = ($sb_simple_ads != "") ? $sb_simple_ads : 0;
        $sb_simple_ads = ($sb_simple_ads >= 0) ? $sb_simple_ads : esc_html__("Unlimited", "carspot-rest-api");
        $profile_arr['simple_ads'] = array("key" => esc_html__("Simple Ads", "carspot-rest-api"), "value" => $sb_simple_ads, "field_name" => "simple_ads");

        $sb_featured_ads = get_user_meta($user->ID, '_carspot_featured_ads', true);
        $sb_featured_ads = ($sb_featured_ads != "") ? $sb_featured_ads : 0;
        $sb_featured_ads = ($sb_featured_ads >= 0) ? $sb_featured_ads : esc_html__("Unlimited", "carspot-rest-api");

        $profile_arr['featured_ads'] = array("key" => esc_html__("Featured Ads", "carspot-rest-api"), "value" => $sb_featured_ads, "field_name" => "featured_ads");
        $sb_bump_ads = get_user_meta($user->ID, '_carspot_bump_ads', true);
        $sb_bump_ads = ($sb_bump_ads != "") ? $sb_bump_ads : 0;
        $sb_bump_ads = ($sb_bump_ads >= 0) ? $sb_bump_ads : esc_html__("Unlimited", "carspot-rest-api");

        $bump_ad_is_show = false;

        if (isset($carspot_theme['sb_allow_free_bump_up']) && $carspot_theme['sb_allow_free_bump_up'] == true) {
            $bump_ad_is_show = true;
        } else if (isset($carspot_theme['sb_allow_bump_ads']) && $carspot_theme['sb_allow_bump_ads'] == true) {
            $bump_ad_is_show = true;
        }
        $profile_arr['bump_ads_is_show'] = $bump_ad_is_show;
        $profile_arr['bump_ads'] = array("key" => esc_html__("Bump Ads", "carspot-rest-api"), "value" => $sb_bump_ads, "field_name" => "bump_ads");
        $profile_arr['profile_extra'] = carspotAPI_basic_profile_data();
        $profile_arr['active_add'] = carspotApi_userAds($user->ID, '', '', $paged);
        $profile_arr['inactive_add'] = carspotApi_userAds($user->ID, 'active', '', $paged, 'pending');
        $profile_arr['expire_add'] = carspotApi_userAds($user->ID, 'expired', '', $paged);
        $profile_arr['sold_add'] = carspotApi_userAds($user->ID, 'sold', '', $paged);
        $profile_arr['featured_add'] = carspotApi_userAds($user->ID, 'active', '1', $paged);
        $profile_arr['favourite_add'] = carspotApi_userAds_fav($user->ID, '', '', $paged);
        /* $active_ads 	= carspotAPI_countPostsHere('publish', '_carspot_ad_status_', 'active', $user_id);
          $inactive_ads 	= carspotAPI_countPostsHere( 'pending', '', '', $user_id);
          $sold_ads     	= carspotAPI_countPostsHere( 'publish', '_carspot_ad_status_', 'sold', $user_id);
          $expired_ads  	= carspotAPI_countPostsHere('publish', '_carspot_ad_status_', 'expired', $user_id);
          $featured 		= carspotAPI_countPostsHere('publish', '_carspot_is_feature', '1', $user_id); */
        $extra_arr['profile_title'] = esc_html__("My Profile", "carspot-rest-api");
        $extra_arr['ads_title'] = esc_html__("Ads", "carspot-rest-api");
        $extra_arr['my_title'] = esc_html__("My", "carspot-rest-api");
        $extra_arr['active_title'] = esc_html__("Active", "carspot-rest-api");
        $extra_arr['inactive_title'] = esc_html__("Pendind", "carspot-rest-api");
        $extra_arr['expired_title'] = esc_html__("Expired", "carspot-rest-api");
        $extra_arr['feature_title'] = esc_html__("Featured", "carspot-rest-api");
        $extra_arr['sold_title'] = esc_html__("Sold", "carspot-rest-api");
        $extra_arr['fav_title'] = esc_html__("Favourite", "carspot-rest-api");
        $extra_arr['status_text'] = carspotAPI_user_ad_strings();
        $extra_arr['profile_edit_title'] = esc_html__("Edit Profile", "carspot-rest-api");
        $extra_arr['save_btn'] = esc_html__("Update", "carspot-rest-api");
        $extra_arr['cancel_btn'] = esc_html__("Cancel", "carspot-rest-api");
        $extra_arr['profile_alert'] = esc_html__("Are you sure ?", "carspot-rest-api");
        $extra_arr['ok_btn'] = esc_html__("Ok", "carspot-rest-api");
        $extra_arr['select_image'] = esc_html__("Select Image", "carspot-rest-api");
        $extra_arr['change_pass']['heading'] = esc_html__("Forgot your password", "carspot-rest-api");
        $extra_arr['change_pass']['title'] = esc_html__("Change Password?", "carspot-rest-api");
        $extra_arr['change_pass']['old_pass'] = esc_html__("Old Password", "carspot-rest-api");
        $extra_arr['change_pass']['new_pass'] = esc_html__("New Password", "carspot-rest-api");
        $extra_arr['change_pass']['new_pass_con'] = esc_html__("Confirm New Password", "carspot-rest-api");
        $extra_arr['change_pass']['err_pass'] = esc_html__("Password Not Matched", "carspot-rest-api");

        $extra_arr['select_pic']['title'] = esc_html__("Add Photo!", "carspot-rest-api");
        $extra_arr['select_pic']['camera'] =esc_html__("Take Photo", "carspot-rest-api");
        $extra_arr['select_pic']['library'] = esc_html__("Choose From Gallery", "carspot-rest-api");
        $extra_arr['select_pic']['cancel'] = esc_html__("Cancel", "carspot-rest-api");
        $extra_arr['select_pic']['no_camera'] = esc_html__("camera Not Available", "carspot-rest-api");

        $profile_arr['page_title'] = esc_html__("My Profile", "carspot-rest-api");
        $profile_arr['page_title_edit'] = esc_html__("Edit Profile", "carspot-rest-api");
        $is_verification_on = false;
        if (isset($carspotAPI['sb_phone_verification']) && $carspotAPI['sb_phone_verification'] == true) {
            $is_verification_on = true;
            $number_verified = get_user_meta($user->ID, '_sb_is_ph_verified', '1');
            $number_verified_text = ($number_verified && $number_verified == 1) ? esc_html__("verified", "carspot-rest-api") : esc_html__("Not verified", "carspot-rest-api");
            $extra_arr['is_number_verified'] = ($number_verified && $number_verified == 1) ? true : false;
            $extra_arr['is_number_verified_text'] = $number_verified_text;
            $extra_arr['phone_dialog'] = array(
                "text_field" => esc_html__("Verify Your Code", "carspot-rest-api"),
                "btn_cancel" => esc_html__("Cancel", "carspot-rest-api"),
                "btn_confirm" => esc_html__("Confirm", "carspot-rest-api"),
                "btn_resend" => esc_html__("Resend", "carspot-rest-api"),
            );
            $extra_arr['send_sms_dialog'] = array(
                "title" => esc_html__("Confirmation", "carspot-rest-api"),
                "text" => esc_html__("Send SMS verification code.", "carspot-rest-api"),
                "btn_send" => esc_html__("Send", "carspot-rest-api"),
                "btn_cancel" => esc_html__("Cancel.", "carspot-rest-api"),
            );
        }
        $extra_arr['is_verification_on'] = $is_verification_on;
        $delete_profile = (isset($carspotAPI['sb_new_user_delete_option']) && $carspotAPI['sb_new_user_delete_option']) ? true : false;
        $profile_arr['can_delete_account'] = $delete_profile;
        if ($delete_profile) {
            $profile_arr['delete_user']['text'] = esc_html__("Delete Account", "carspot-rest-api");
            $profile_arr['delete_account']['text'] = esc_html__("Delete Account?", "carspot-rest-api");
            $delete_profile_text = (isset($carspotAPI['sb_new_user_delete_option_text']) && $carspotAPI['sb_new_user_delete_option_text'] != "") ? $carspotAPI['sb_new_user_delete_option_text'] : esc_html__("Are you sure you want to delete the account.", "carspot-rest-api");
            $profile_arr['delete_account']['popuptext'] = $delete_profile_text;
            $profile_arr['delete_account']['btn_cancel'] = esc_html__("Cancel", "carspot-rest-api");
            $profile_arr['delete_account']['btn_submit'] = esc_html__("Confirm", "carspot-rest-api");
        }
        $profile_arr['tabs_text']['profile'] = esc_html__("Profile", "carspot-rest-api");
        $profile_arr['tabs_text']['edit_profile'] = esc_html__("Edit Profile", "carspot-rest-api");
        $profile_arr['tabs_text']['featured_ads'] = esc_html__("Featured Ads", "carspot-rest-api");
        $profile_arr['tabs_text']['my_ads'] = esc_html__("My Ads", "carspot-rest-api");
        $profile_arr['tabs_text']['inactive_ads'] = esc_html__("Pending Ads", "carspot-rest-api");
        $profile_arr['tabs_text']['favorite_ads'] = esc_html__("Favorite Ads", "carspot-rest-api");
        $profile_arr['tabs_text']['expired_ads'] = esc_html__("Expired Ads", "carspot-rest-api");
        $profile_arr['tabs_text']['sold_ads'] = esc_html__("Sold Ads", "carspot-rest-api");
        $profile_arr['user_addr_field'] = false;
        if ($carspotAPI['api_individual_user_addres'] == true) {
            $profile_arr['user_addr_field'] = true;
        }
        $response = array('success' => true, 'data' => $profile_arr, "message" => "", "extra_text" => $extra_arr);
        return $response;
    }

}

/* Public profile starts */
add_action('rest_api_init', 'carspotAPI_userPublicProfile_hooks_get', 0);

function carspotAPI_userPublicProfile_hooks_get() {
    register_rest_route(
            'carspot/v1', '/profile/public/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_userPublicProfile_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_userPublicProfile_get')) {

    function carspotAPI_userPublicProfile_get($request) {
        global $carspot_theme;
        global $carspotAPI;
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id'])) ? $json_data['user_id'] : '';
        $user = get_userdata($user_id);
        if (!$user) {
            $response = array('success' => false, 'data' => '', "message" => esc_html__("User does not exists", "carspot-rest-api"));
            return $response;
        }
        $data = array();
        $user_id = $user->ID;
        $name = get_user_meta($user_id, '_sb_camp_name', true);
        $sb_userType = get_user_meta($user_id, '_sb_user_type', true);
        $name = ($sb_userType == 'dealer') ? get_user_meta($user_id, '_sb_camp_name', true) : $user->display_name;
        if (get_user_meta($user->ID, '_sb_camp_name', true) != '') {
            $name = get_user_meta($user->ID, '_sb_camp_name', true);
        } else {
            $name = $user->display_name;
        }

        $user_badge_color = '';
        $user_badge_text = '';
        if (get_user_meta($user_id, '_sb_badge_text', true) != "" && get_user_meta($user_id, '_sb_badge_type', true) != "") {
            $user_badge_color = get_user_meta($user_id, '_sb_badge_type', true);
            $user_badge_text = get_user_meta($user_id, '_sb_badge_text', true);

            if ($user_badge_color == 'label-success') {
                $user_badge_color = '#8ac249';
            }
            if ($user_badge_color == 'label-warning') {
                $user_badge_color = '#fe9700';
            }
            if ($user_badge_color == 'label-info') {
                $user_badge_color = '#02a8f3';
            }
            if ($user_badge_color == 'label-danger') {
                $user_badge_color = '#f34235';
            }
        }


        $ds = ($sb_userType == 'dealer') ? true : false;
        /* List Section */
        $data['is_show'] = true;
        $data['id'] = $user_id;
        $data['name'] = $name;
        $data['profile_img'] = carspotAPI_user_dp($user_id, 'carspot-user-profile');
        $data['verify']['text'] = $user_badge_text;
        $data['verify']['color'] = $user_badge_color;
        $data['list']['title'] = esc_html__("Contact", "carspot-rest-api");
        $data['list']['text'][] = array("is_show" => $ds, "key" => ("Address"), "val" => get_user_meta($user_id, '_sb_address', true));
        $data['list']['text'][] = array("is_show" => true, "key" => ("Contact Number"), "val" => get_user_meta($user_id, '_sb_contact', true));
        $data['list']['text'][] = array("is_show" => $ds, "key" => ("Website"), "val" => get_user_meta($user_id, '_sb_user_web_url', true));

        $facebook = get_user_meta($user->ID, '_sb_user_facebook', true);
        $twitter = get_user_meta($user->ID, '_sb_user_twitter', true);
        $linkedin = get_user_meta($user->ID, '_sb_user_linkedin', true);
        $youtube = get_user_meta($user->ID, '_sb_user_youtube', true);

        $data['social']['is_show'] = $ds;
        $data['social']['loop'][] = array("name" => esc_html__("Facebook", "carspot-rest-api"), "url" => $facebook);
        $data['social']['loop'][] = array("name" => esc_html__("Twitter", "carspot-rest-api"), "url" => $twitter);
        $data['social']['loop'][] = array("name" => esc_html__("Linkedin", "carspot-rest-api"), "url" => $linkedin);
        $data['social']['loop'][] = array("name" => esc_html__("Youtube", "carspot-rest-api"), "url" => $youtube);

        /* Form Section */
        $data['form']['is_show'] = true;
        $data['form']['form_type'] = array('form_type' => 'public_profile_contact_form');
        $data['form']['title'] = esc_html__("Contact", "carspot-rest-api");
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'name', "field_name" => esc_html__("Name", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'email', "field_name" => esc_html__("Email", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'phone', "field_name" => esc_html__("Phone", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['fields'][] = array("field_type" => 'textarea', "field_type_name" => 'message', "field_name" => esc_html__("Message", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $data['form']['btn_submit'] = esc_html__("Request Schedule", "carspot-rest-api");
        /* Get Lat and Long */
        $data['lat_long']['is_show'] = $ds;
        $data['lat_long']['text'] = esc_html__("Get Direction", "carspot-rest-api");
        $data['lat_long']['lat'] = get_user_meta($user_id, '_sb_user_address_lat', true);
        $data['lat_long']['long'] = get_user_meta($user_id, '_sb_user_address_long', true);
        /* Last Login Check */
        $data['last_login'] = carspotAPI_getLastLogin($user_id, true);

        /* User Intro */
        $about_title = (isset($carspot_theme['sb_about_title']) && $carspot_theme['sb_about_title'] != "") ? $carspot_theme['sb_about_title'] : "";
        $data['intro']['title'] = $name;
        if ($ds) {
            $data['intro']['image'] = carspotAPI_get_dealer_store_front($user_id, 'full');
        }
        $data['intro']['desc_title'] = $about_title;
        $data['intro']['desc'] = get_user_meta($user_id, '_sb_user_about', true);

        /* Boxes Starts */
        $ratting_star_avg = avg_user_rating_apps($user_id);
        if (isset($ratting_star_avg) && $ratting_star_avg != null) {
            $data['boxes'][] = array("is_show" => true, "key" => esc_html__("Rating Average", "carspot-rest-api"), "val" => $ratting_star_avg);
        } else {
            $data['boxes'][] = array("is_show" => true, "key" => esc_html__("Rating Average", "carspot-rest-api"), "val" => 0);
        }
        $ratting_count = carspot_dealer_review_count($user_id);
        $data['boxes'][] = array("is_show" => true, "key" => esc_html__("Ratings", "carspot-rest-api"), "val" => $ratting_count);
        $register_date = date_i18n("F j, Y", strtotime($user->user_registered));
        $data['boxes'][] = array("is_show" => true, "key" => esc_html__("Member Since", "carspot-rest-api"), "val" => $register_date);
        $user_timings = get_user_meta($user_id, '_sb_user_timings', true);
        $data['boxes'][] = array("is_show" => $ds, "key" => esc_html__("Working Hours", "carspot-rest-api"), "val" => $user_timings);
        /* Boxes Ends */
        /**/
        $inventory_title = (isset($carspot_theme['sb_inventory_title']) && $carspot_theme['sb_inventory_title'] != "") ? $carspot_theme['sb_inventory_title'] : "";
        $inventory = array();
        $inventory['is_show'] = true;
        $inventory['title'] = $inventory_title;
        $inventory['lists'] = carspotAPI_get_user_ads_by_id2($user_id, 1, 'arr');
        if (count($inventory['lists']['ads']) == 0) {
            $inventory['no_inventory_msg'] = esc_html__("No inventory found.", "carspot-rest-api");
        }
        //$inventory['no_rating_msg'] = esc_html__("No inventory found.", "carspot-rest-api");
        $data['inventory'] = $inventory;

        /* Rating Titles Stars */
        $sb_first_rating_stars_title = (isset($carspot_theme['sb_first_rating_stars_title']) && $carspot_theme['sb_first_rating_stars_title'] != "") ? $carspot_theme['sb_first_rating_stars_title'] : "";
        $sb_second_rating_stars_title = (isset($carspot_theme['sb_second_rating_stars_title']) && $carspot_theme['sb_second_rating_stars_title'] != "") ? $carspot_theme['sb_second_rating_stars_title'] : "";
        $sb_third_rating_stars_title = (isset($carspot_theme['sb_third_rating_stars_title']) && $carspot_theme['sb_third_rating_stars_title'] != "") ? $carspot_theme['sb_third_rating_stars_title'] : "";
        /* Rating Titles Ends */

        /* Show Reviews */
        $sb_reviews_title = (isset($carspot_theme['sb_reviews_title']) && $carspot_theme['sb_reviews_title'] != "") ? $carspot_theme['sb_reviews_title'] : "";
        $reviews = array();
        $reviews['is_show'] = true;
        $reviews['title'] = $sb_reviews_title;
        $dealer_reviews_list = carspotAPI_dealer_reviews_list($user_id);
        $reviews['lists'] = $dealer_reviews_list;
        /* $count_dealer_reviews_list = count($dealer_reviews_list); */
        $data['reviews_msg'] = (isset($dealer_reviews_list['reviews']) && count($dealer_reviews_list['reviews']) == 0) ? esc_html__("No Review Found", "carspot-rest-api") : '';

        $data['reviews'] = $reviews;
        /* Write Reviews */
        $sb_write_reviews_title = (isset($carspot_theme['sb_write_reviews_title']) && $carspot_theme['sb_write_reviews_title'] != "") ? $carspot_theme['sb_write_reviews_title'] : "";
        $review_form = array();
        $review_form['is_show'] = true;
        $review_form['title'] = $sb_write_reviews_title;
        $review_form['form']['form_type'] = 'public_profile_review_form';
        $review_form['form']['stars_1'] = array("field_type" => 'star_1', "field_type_name" => 'star_1', "field_name" => $sb_first_rating_stars_title, "field_val" => "", "is_required" => true);
        $review_form['form']['stars_2'] = array("field_type" => 'star_2', "field_type_name" => 'star_2', "field_name" => $sb_second_rating_stars_title, "field_val" => "", "is_required" => true);
        $review_form['form']['stars_3'] = array("field_type" => 'star_3', "field_type_name" => 'star_3', "field_name" => $sb_third_rating_stars_title, "field_val" => "", "is_required" => true);

        $review_form['form']['subject'] = array("field_type" => 'textfield', "field_type_name" => 'subject', "field_name" => esc_html__("Review Title", "carspot-rest-api"), "field_val" => "", "is_required" => true);

        $radios = array();
        $radios[] = array("key" => "yes", "val" => esc_html__("Yes", "carspot-rest-api"));
        $radios[] = array("key" => "no", "val" => esc_html__("No", "carspot-rest-api"));

        $review_form['form']['recommend'] = array("field_type" => 'radio', "field_type_name" => 'recommend', "field_name" => esc_html__("Will you Recommend this vendor?", "carspot-rest-api"), "field_val" => $radios, "is_required" => true);
        $review_form['form']['textarea'] = array("field_type" => 'textarea', "field_type_name" => 'message', "field_name" => esc_html__("Message", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $review_form['form']['btn_submit'] = esc_html__("Submit Review", "carspot-rest-api");
        $data['review_form'] = $review_form;
        $data['advertisement'] = (isset($carspot_theme['dealer_ad_320']) && $carspot_theme['dealer_ad_320'] != "") ? $carspot_theme['dealer_ad_320'] : "";
        /* profile tabs */
        $sb_user_profile_tab1 = esc_html__('Inventory', 'carspot-rest-api');
        $sb_user_profile_tab2 = esc_html__('Review', 'carspot-rest-api');
        $sb_user_profile_tab3 = esc_html__('Contact', 'carspot-rest-api');
        if (isset($carspotAPI['sb_user_profile_tab1']) && $carspotAPI['sb_user_profile_tab1'] != '') {
            $sb_user_profile_tab1 = $carspotAPI['sb_user_profile_tab1'];
        }
        if (isset($carspotAPI['sb_user_profile_tab2']) && $carspotAPI['sb_user_profile_tab2'] != '') {
            $sb_user_profile_tab2 = $carspotAPI['sb_user_profile_tab2'];
        }
        if (isset($carspotAPI['sb_user_profile_tab3']) && $carspotAPI['sb_user_profile_tab3'] != '') {
            $sb_user_profile_tab3 = $carspotAPI['sb_user_profile_tab3'];
        }
        $data['profile_tab']['tab1'] = $sb_user_profile_tab1;
        $data['profile_tab']['tab2'] = $sb_user_profile_tab2;
        $data['profile_tab']['tab3'] = $sb_user_profile_tab3;
        /* end */
        $response = array("success" => true, "data" => $data, "message" => "");
        return $response;
    }

}

add_action('rest_api_init', 'carspotAPI_dealer_reviews_hook', 0);

function carspotAPI_dealer_reviews_hook() {
    register_rest_route(
            'carspot/v1', '/profile/public/dealer/reviews/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_dealer_reviews',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_dealer_reviews')) {

    function carspotAPI_dealer_reviews($request) {
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';
        $dealer_id = (isset($json_data['dealer_id'])) ? $json_data['dealer_id'] : '';
        if ($dealer_id == "") {
            return array("success" => false, "data" => $data, "message" => esc_html__("Something went wrong.", "carspot-rest-api"));
        }
        $data = array();
        $data['title'] = esc_html__("Dealer Ratings", "carspot-rest-api");
        $dealer_reviews_list = carspotAPI_dealer_reviews_list($dealer_id, $paged);
        if (count($dealer_reviews_list) > 0) {
            $data['ratings'] = carspotAPI_dealer_reviews_list($dealer_id, $paged);
            $success = true;
            $message = '';
        } else {
            $data['ratings'] = array();
            $success = true;
            $message = esc_html__("No Rating Found", "carspot-rest-api");
        }
        $response = array("success" => true, "data" => $data, "message" => "");
        return $response;
    }

}

if (!function_exists('carspotAPI_dealer_reviews_list')) {

    function carspotAPI_dealer_reviews_list($user_id = '', $paged = 1) {
        global $carspot_theme;
        $commentsData = array();
        $sb_first_rating_stars_title = (isset($carspot_theme['sb_first_rating_stars_title']) && $carspot_theme['sb_first_rating_stars_title'] != "") ? $carspot_theme['sb_first_rating_stars_title'] : "";
        $sb_second_rating_stars_title = (isset($carspot_theme['sb_second_rating_stars_title']) && $carspot_theme['sb_second_rating_stars_title'] != "") ? $carspot_theme['sb_second_rating_stars_title'] : "";
        $sb_third_rating_stars_title = (isset($carspot_theme['sb_third_rating_stars_title']) && $carspot_theme['sb_third_rating_stars_title'] != "") ? $carspot_theme['sb_third_rating_stars_title'] : "";

        $comment_count = carspot_dealer_review_count($user_id);

        $limit = $posts_per_page = (isset($carspot_theme['sb_reviews_count_limit'])) ? $carspot_theme['sb_reviews_count_limit'] : 10;


        $total_posts = $comment_count;
        $max_num_pages = ceil($total_posts / $posts_per_page);
        //if(isset($limit) && $limit !=""){ $pages = ceil($comment_count)/$limit; }

        $args = array('user_id' => $user_id, 'type' => 'dealer_review', 'order' => 'DESC', 'paged' => $paged, 'number' => $limit,);
        $get_rating = get_comments($args);
        $ratings_lists = $ratings_array = $replies = array();
        if (count((array) $get_rating) > 0) {
            foreach ($get_rating as $get_ratings) {
                $comment_ids = $get_ratings->comment_ID;
                $service_stars = get_comment_meta($comment_ids, '_rating_service', true);
                $process_stars = get_comment_meta($comment_ids, '_rating_proces', true);
                $selection_stars = get_comment_meta($comment_ids, '_rating_selection', true);
                $single_avg = 0;
                $total_stars = $service_stars + $process_stars + $selection_stars;
                $single_avg = round($total_stars / "3", 1);

                $ratings_array['average_rating'] = $single_avg;
                $total_stars = 5;
                $current_stars = 0;
                for ($i = 1; $i <= $total_stars; $i++) {
                    if ($i <= $single_avg) {
                        $current_stars++;
                    }
                }
                $ratings_array['rating_stars'] = array("total" => 5, "current" => $current_stars);
                $ratings_array['rating_title'] = get_comment_meta($comment_ids, '_rating_title', true);
                $ratings_array['rating_content'] = $get_ratings->comment_content;
                $ratings_array['rating_link'] = esc_url(get_author_posts_url($get_ratings->comment_post_ID));
                /* Comment Poster Data */
                $comment_poster = get_userdata($get_ratings->comment_post_ID);
                $ratings_array['rating_poster_name'] = $comment_poster->display_name;

                $recomment = get_comment_meta($comment_ids, '_rating_recommand', true);
                $is_recommended = ($recomment != "") ? true : false;
                $ratings_array['rating_recommended'] = $is_recommended;
                $is_recommended_txt = '';
                if ($is_recommended) {
                    $is_recommended_txt = ($recomment == 'yes') ? esc_html__('Recommended', 'carspot-rest-api') : esc_html__('Not Recommended', 'carspot-rest-api');
                    $is_recommended_txt = esc_html__('Has', 'carspot-rest-api') . ' ' . $is_recommended_txt;
                    $is_recommended_txt = $is_recommended_txt . ' ' . esc_html__('this vendor on', 'carspot-rest-api');
                    $is_recommended_txt = $is_recommended_txt . ' ' . date(get_option('date_format'), strtotime($get_ratings->comment_date));
                }
                $ratings_array['rating_recommended_text'] = $is_recommended_txt;
                $reply_text = get_comment_meta($comment_ids, '_rating_reply', true);
                $can_reply = ($reply_text) ? true : false;
                $star_total_stars = 5;
                $star_1_current_stars = 0;
                for ($i = 1; $i <= $star_total_stars; $i++) {
                    if ($i <= $service_stars) {
                        $star_1_current_stars++;
                    }
                }
                $ratings_array['ratings']['star_1'] = array("title" => $sb_first_rating_stars_title, "total" => $star_total_stars, "current" => $star_1_current_stars);

                $star_2_current_stars = 0;
                for ($i = 1; $i <= $star_total_stars; $i++) {
                    if ($i <= $process_stars) {
                        $star_2_current_stars++;
                    }
                }
                $ratings_array['ratings']['star_2'] = array("title" => $sb_second_rating_stars_title, "total" => $star_total_stars, "current" => $star_2_current_stars);

                $star_3_current_stars = 0;
                for ($i = 1; $i <= $star_total_stars; $i++) {
                    if ($i <= $selection_stars) {
                        $star_3_current_stars++;
                    }
                }
                $ratings_array['ratings']['star_3'] = array("title" => $sb_third_rating_stars_title, "total" => $star_total_stars, "current" => $star_3_current_stars);

                $ratings_array['rating_show_reply'] = $can_reply;

                $ratings_array['author_reply']['title'] = esc_html__('Dealer Reply', 'carspot-rest-api');
                $ratings_array['author_reply']['desc'] = $reply_text;

                $replies[] = $ratings_array;
            }
        }

        $nextPaged = $paged + 1;
        $has_next_page = ($nextPaged <= (int) $max_num_pages) ? true : false;

        $ratings_lists['reviews'] = $replies;
        $ratings_lists['pagination'] = array("max_num_pages" => (int) $max_num_pages, "current_page" => (int) $paged, "next_page" => (int) $nextPaged, "increment" => (int) $posts_per_page, "current_no_of_ads" => (int) count($commentsData), "has_next_page" => $has_next_page);

        return $ratings_lists;
    }

}
add_action('rest_api_init', 'carspotAPI_public_profile_form_submit_hook', 0);

function carspotAPI_public_profile_form_submit_hook() {

    register_rest_route(
            'carspot/v1', '/profile/public/submit/form/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_public_profile_form_submit',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_public_profile_form_submit')) {

    function carspotAPI_public_profile_form_submit($request) {
        global $carspot_theme;
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id'])) ? $json_data['user_id'] : '';
        $form_type = (isset($json_data['form_type'])) ? $json_data['form_type'] : '';

        if ($form_type == "" || $user_id == "") {
            return array('success' => false, 'data' => '', 'message' => esc_html__("Invalid Form Submission", "carspot-rest-api"));
        }

        if ($form_type == 'public_profile_contact_form') {
            /* For Make Offer */
            $name = (isset($json_data['name'])) ? $json_data['name'] : '';
            $email = (isset($json_data['email'])) ? $json_data['email'] : '';
            $phone = $contact = (isset($json_data['phone'])) ? $json_data['phone'] : '';
            $message_text = (isset($json_data['message'])) ? $json_data['message'] : '';
            $dealer_id = $user_id;
            if ($name == "" || $email == "" || $phone == "" || $message_text == "") {
                return array('success' => false, 'data' => '', 'message' => esc_html__("All fields are required", "carspot-rest-api"));
            } else {
                $message = esc_html__("Something went wrong.", 'carspot-rest-api');
                $success = false;
                $to = "";
                if (isset($carspot_theme['sb_dealer_contact']) && $carspot_theme['sb_dealer_contact'] != '') {
                    $subject = '[' . get_bloginfo('name') . '] - ' . esc_html__('You have been contacted via profile on ', 'carspot-rest-api') . get_bloginfo('name');
                    $body = '<html><body><p>' . esc_html__('Someone has contacted you over ', 'carspot-rest-api') . '' . get_bloginfo('name') . ' </a></p></body></html>';
                    $from = get_bloginfo('name');
                    if (isset($carspot_theme['sb_contact_dealer_email_from']) && $carspot_theme['sb_contact_dealer_email_from'] != "") {
                        $from = $carspot_theme['sb_contact_dealer_email_from'];
                    }

                    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                    if (isset($carspot_theme['sb_contact_dealer_email_message']) && $carspot_theme['sb_contact_dealer_email_message'] != "") {
                        /* $author_id = get_post_field ('post_author', $pid); */
                        $user_info = get_userdata($dealer_id);
                        $to = $user_info->user_email;
                        $subject_keywords = array('%dc_name%', '%dc_email%', '%dc_phone%', '%dc_msg%');
                        $subject_replaces = array($name, $email, $contact, $message_text);
                        $subject = str_replace($subject_keywords, $subject_replaces, $carspot_theme['sb_contact_dealer_email_subject']);
                        $msg_keywords = array('%dc_name%', '%dc_email%', '%dc_phone%', '%dc_msg%');
                        $msg_replaces = array($name, $email, $contact, $message_text);
                        $body = str_replace($msg_keywords, $msg_replaces, $carspot_theme['sb_contact_dealer_email_message']);

                        $sent_email = wp_mail($to, $subject, $body, $headers);
                        if ($sent_email) {
                            $message = esc_html__("Email sent to dealer successfully.", 'carspot-rest-api');
                            $success = true;
                        }
                    }
                }
                return array('success' => $success, 'data' => '', 'message' => $message);
            }
        } else if ($form_type == 'public_profile_review_form') {
            $rator = get_current_user_id();
            if ($rator != '') {
                /* public_profile_review_form */
                $star_1 = $rating_service_stars = (isset($json_data['star_1'])) ? $json_data['star_1'] : '';
                $star_2 = $rating_process_stars = (isset($json_data['star_2'])) ? $json_data['star_2'] : '';
                $star_3 = $rating_selection_stars = (isset($json_data['star_3'])) ? $json_data['star_3'] : '';
                $subject = $review_title = (isset($json_data['subject'])) ? $json_data['subject'] : '';
                $recommend = $rating_recommand = (isset($json_data['recommend'])) ? $json_data['recommend'] : '';
                $message = $review_message = (isset($json_data['message'])) ? $json_data['message'] : '';
                $dealer_id = $user_id;
                if ($star_1 == "" || $star_2 == "" || $star_3 == "" || $subject == "" || $recommend == "" || $message == "") {
                    return array('success' => false, 'data' => '', 'message' => esc_html__("All fields are required", "carspot-rest-api"));
                } else {
                    $message = esc_html__("Something went wrong.", 'carspot-rest-api');
                    $success = false;

                    $current_user = wp_get_current_user();
                    /* Form Data */
                    $star_1 = $rating_service_stars = (isset($json_data['star_1'])) ? $json_data['star_1'] : '';
                    $star_2 = $rating_process_stars = (isset($json_data['star_2'])) ? $json_data['star_2'] : '';
                    $star_3 = $rating_selection_stars = (isset($json_data['star_3'])) ? $json_data['star_3'] : '';
                    $subject = $review_title = (isset($json_data['subject'])) ? $json_data['subject'] : '';
                    $recommend = $rating_recommand = (isset($json_data['recommend'])) ? $json_data['recommend'] : '';
                    $message = $review_message = (isset($json_data['message'])) ? $json_data['message'] : '';
                    $dealer_id = $user_id;

                    $rating_data = array();
                    if ($dealer_id == $rator) {
                        $message = esc_html__("You can't rate yourself.", 'carspot-rest-api');
                        $success = false;
                    } /* if(get_user_meta( $dealer_id, '_is_rated_'.$rator, true ) == $rator)
                      {
                      $message  =   esc_html__( "You already rated this vendor.", 'carspot-rest-api' );
                      //message  =   get_user_meta( $dealer_id, '_is_rated_'.$rator, true );
                      $success  = false;
                      } */ else {
                        $time = current_time('mysql');

                        $data = array(
                            'comment_post_ID' => $rator,
                            'comment_author' => $current_user->display_name,
                            'comment_author_email' => $current_user->user_email,
                            'comment_author_url' => '',
                            'comment_content' => sanitize_text_field($review_message),
                            'comment_type' => 'dealer_review',
                            'comment_parent' => 0,
                            'user_id' => $dealer_id,
                            'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                            'comment_date' => $time,
                            'comment_approved' => 1,
                        );

                        $comment_id = wp_insert_comment($data);
                        update_comment_meta($comment_id, '_rating_service', sanitize_text_field($rating_service_stars));
                        update_comment_meta($comment_id, '_rating_proces', sanitize_text_field($rating_process_stars));
                        update_comment_meta($comment_id, '_rating_selection', sanitize_text_field($rating_selection_stars));
                        update_comment_meta($comment_id, '_rating_title', sanitize_text_field($review_title));
                        update_comment_meta($comment_id, '_rating_recommand', sanitize_text_field($rating_recommand));
                        update_user_meta($dealer_id, '_is_rated_' . $rator, $rator);

                        $total_stars = $rating_service_stars + $rating_process_stars + $rating_selection_stars;
                        $ratting = round($total_stars / "3", 1);
                        // Send email if enabled

                        if (isset($carspot_theme['email_to_user_on_rating']) && $carspot_theme['email_to_user_on_rating']) {
                            //carspot_send_email_new_rating( $sender_id, $receiver_id, $rating = '', $comments = '' )
                            //carspot_send_email_new_rating( $rator, $dealer_id, $ratting, $review_message );
                            $receiver_info = get_userdata($receiver_id);
                            $to = $receiver_info->user_email;
                            $subject = esc_html__('New Rating', 'carspot-rest-api') . '-' . get_bloginfo('name');

                            $body = '<html><body><p>' . esc_html__('Got new Rating', 'carspot-rest-api') . ' <a href="' . get_author_posts_url($receiver_id) . '">' . get_author_posts_url($receiver_id) . '</a></p></body></html>';
                            $from = get_bloginfo('name');

                            if (isset($carspot_theme['sb_new_rating_from']) && $carspot_theme['sb_new_rating_from'] != "") {
                                $from = $carspot_theme['sb_new_rating_from'];
                            }
                            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                            if (isset($carspot_theme['sb_new_rating_message']) && $carspot_theme['sb_new_rating_message'] != "") {
                                $subject_keywords = array('%site_name%');
                                $subject_replaces = array(get_bloginfo('name'));
                                $subject = str_replace($subject_keywords, $subject_replaces, $carspot_theme['sb_new_rating_subject']);
                                // Rator info
                                $sender_info = get_userdata($sender_id);
                                $msg_keywords = array('%site_name%', '%receiver%', '%rator%', '%rating%', '%comments%', '%rating_link%');
                                $msg_replaces = array(get_bloginfo('name'), $receiver_info->display_name, $sender_info->display_name, $rating, $comments, get_author_posts_url($receiver_id));

                                $body = str_replace($msg_keywords, $msg_replaces, $carspot_theme['sb_new_rating_message']);
                            }
                            wp_mail($to, $subject, $body, $headers);
                        }
                        $message = esc_html__("You've rated this user.", 'carspot-rest-api');
                        $success = true;
                        $rating_data = carspotAPI_dealer_reviews_list($dealer_id);
                    }

                    return array('success' => $success, 'data' => $rating_data, 'message' => $message);
                }
            } else {
                return array('success' => false, 'data' => '', 'message' => esc_html__("You must be login to submit review", "carspot-rest-api"));
            }
        } else {
            return array('success' => false, 'data' => '', 'message' => esc_html__("Invalid Form Submission", "carspot-rest-api"));
        }
    }

}


/* Public profile ends */

add_action('rest_api_init', 'carspotAPI_get_user_ads_by_id_hook', 0);

function carspotAPI_get_user_ads_by_id_hook() {

    /* Routs */
    register_rest_route(
            'carspot/v1', '/profile/public/inventory/',
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'carspotAPI_get_user_ads_by_id',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
    register_rest_route(
            'carspot/v1', '/profile/public/inventory/',
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => 'carspotAPI_get_user_ads_by_id',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
}

if (!function_exists('carspotAPI_get_user_ads_by_id')) {

    function carspotAPI_get_user_ads_by_id($request) {
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id'])) ? $json_data['user_id'] : '';
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';
        return carspotAPI_get_user_ads_by_id2($user_id, $paged);
    }

}

if (!function_exists('carspotAPI_get_user_ads_by_id2')) {

    function carspotAPI_get_user_ads_by_id2($user_id = '', $paged = 1, $array = '') {
        $adsData = carspotApi_userAds($user_id, '', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        if ($array == 'arr') {
            return $arr;
        }
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}


add_action('rest_api_init', 'carspotAPI_user_ads_get', 0);

function carspotAPI_user_ads_get() {

    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_all_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_all_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));

    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/active/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_active_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/active/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_active_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/expired/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_expired_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/expired/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_expired_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/sold/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_sold_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/sold/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_sold_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/featured/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_featured_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/featured/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_featured_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/inactive/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_inactive_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/inactive/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_inactive_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/update/status/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_change_user_ad_status',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));

    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/delete/', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'carspotAPI_change_user_ad_delete',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
        'args' => array('force' => array('default' => true,),),
    ));
    register_rest_route(
            'carspot/v1', '/ad/delete/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_change_user_ad_delete',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
        'args' => array('force' => array('default' => true,),),
    ));

    /* favourite */
    register_rest_route(
            'carspot/v1', '/ad/favourite/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_user_ad_favourite',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    register_rest_route(
            'carspot/v1', '/ad/favourite/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_user_ad_favourite',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
    /* favourite remove */
    register_rest_route(
            'carspot/v1', '/ad/favourite/remove', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_user_ad_favourite_remove',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

/* Active Ads */
if (!function_exists('carspotAPI_ad_all_get')) {

    function carspotAPI_ad_all_get($request) {

        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds($userID->ID, '', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];

        $arr['page_title'] = esc_html__('My Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'myads';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '1';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}

/* inActive Ads */
if (!function_exists('carspotAPI_ad_inactive_get')) {

    function carspotAPI_ad_inactive_get($request) {
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';
        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds($userID->ID, 'active', '', $paged, 'pending');

        $arr['notification'] = esc_html__("Waiting for admin approval.", "carspot-rest-api");
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['page_title'] = esc_html__('Inactive Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'inactive';
        $arr['text']['editable'] = '0';
        $arr['text']['show_dropdown'] = '0';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}

/* Active Ads */
if (!function_exists('carspotAPI_ad_active_get')) {

    function carspotAPI_ad_active_get($request) {

        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $arr['page_title'] = esc_html__('Active Ads', 'carspot-rest-api');
        $adsData = carspotApi_userAds($userID->ID, 'active', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'active';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '1';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}
/* expired Ads */
if (!function_exists('carspotAPI_ad_expired_get')) {

    function carspotAPI_ad_expired_get($request) {

        $arr['page_title'] = esc_html__('Expired Ads', 'carspot-rest-api');
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds($userID->ID, 'expired', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['page_title'] = esc_html__('Expired Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'expired';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '1';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);

        return $response;
    }

}
/* sold Ads */
if (!function_exists('carspotAPI_ad_sold_get')) {

    function carspotAPI_ad_sold_get($request) {
        $arr['page_title'] = esc_html__('Sold Ads', 'carspot-rest-api');
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';
        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds($userID->ID, 'sold', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['page_title'] = esc_html__('Sold Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'sold';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '1';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);

        return $response;
    }

}
/* featured Ads */
if (!function_exists('carspotAPI_ad_featured_get')) {

    function carspotAPI_ad_featured_get($request) {
        $arr['page_title'] = esc_html__('Featured Ads', 'carspot-rest-api');
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds($userID->ID, 'active', '1', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['page_title'] = esc_html__('Featured Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'featured';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '0';

        $arr['profile'] = carspotAPI_basic_profile_data();

        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}

/* favourite Ads - Remove to favourites */
if (!function_exists('carspotAPI_user_ad_favourite_remove')) {

    function carspotAPI_user_ad_favourite_remove($request) {

        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id']) && $json_data['ad_id'] != "") ? $json_data['ad_id'] : '';

        $user = wp_get_current_user();
        $user_id = $user->data->ID;

        if (delete_user_meta($user_id, '_sb_fav_id_' . $ad_id)) {
            return array('success' => true, 'data' => '', 'message' => esc_html__("Ad removed successfully.", "carspot-rest-api"));
        } else {
            return array('success' => false, 'data' => '', 'message' => esc_html__("There'is some problem, please try again later.", "carspot-rest-api"));
        }
    }

}

/* favourite Ads */
if (!function_exists('carspotAPI_user_ad_favourite')) {

    function carspotAPI_user_ad_favourite($request) {
        $arr['page_title'] = esc_html__('Favourite Ads', 'carspot-rest-api');
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds_fav($userID->ID, '', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];
        $arr['page_title'] = esc_html__('Favourite Ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'favourite';
        $arr['text']['editable'] = '0';
        $arr['text']['show_dropdown'] = '0';

        $arr['profile'] = carspotAPI_basic_profile_data();

        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";

        $response = array('success' => true, 'data' => $arr, 'message' => $message);

        return $response;
    }

}


if (!function_exists('carspotAPI_user_ad_strings')) {

    function carspotAPI_user_ad_strings() {

        $status_dropdown_value = array("active", "expired", "sold", "edit", "delete");
        $status_dropdown_name = array(
            esc_html__("Active", "carspot-rest-api"),
            esc_html__("Expired", "carspot-rest-api"),
            esc_html__("Sold", "carspot-rest-api"),
            esc_html__("Edit", "carspot-rest-api"),
            esc_html__("Delete", "carspot-rest-api"),
        );

        $string["status_dropdown_value"] = $status_dropdown_value;
        $string["status_dropdown_name"] = $status_dropdown_name;
        $string["edit_text"] = esc_html__("Edit", "carspot-rest-api");
        $string["delete_text"] = esc_html__("Delete", "carspot-rest-api");


        return $string;
    }

}

if (!function_exists('carspotAPI_change_user_ad_status')) {

    function carspotAPI_change_user_ad_status($request) {
        $userID = wp_get_current_user();
        if (empty($userID)) {
            $message = esc_html__("Invalid Access", "carspot-rest-api");
            return $response = array('success' => true, 'data' => '', 'message' => $message);
        }
        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $ad_status = (isset($json_data['ad_status'])) ? $json_data['ad_status'] : '';
        $post_tmp = get_post($ad_id);
        if (isset($post_tmp) && $post_tmp != "") {
            $author_id = $post_tmp->post_author;
            if (isset($userID) && $author_id == $userID->ID && $ad_id != "" && $ad_status != "") {
                update_post_meta($ad_id, "_carspot_ad_status_", $ad_status);
                $message = esc_html__("Ad Status Updated", "carspot-rest-api");
            } else {
                $message = esc_html__("Some error occured.", "carspot-rest-api");
            }
        } else {
            $message = esc_html__("Invalid Post Id", "carspot-rest-api");
        }
        $response = array('success' => true, 'data' => '', 'message' => $message);
        return $response;
    }

}

/* Delete ad */
if (!function_exists('carspotAPI_change_user_ad_delete')) {

    function carspotAPI_change_user_ad_delete($request) {
        $userID = wp_get_current_user();

        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $post_data = get_post($ad_id);

        if (empty($userID)) {
            $message = esc_html__("Invalid Access", "carspot-rest-api");
            return $response = array('success' => false, 'data' => '', 'message' => $message);
        }

        $status = get_post_status($ad_id);

        if (get_post_status($ad_id) != "publish") {
            $message = esc_html__("You can't delete this ad.", "carspot-rest-api");
            return $response = array('success' => false, 'data' => $request, 'message' => $message);
        }

        if (isset($post_data) && $post_data != "") {
            $author_id = $post_data->post_author;

            if ($author_id == $userID->ID && $post_data->ID != "") {
                $query = array('ID' => $post_data->ID, 'post_status' => 'trash',);
                wp_update_post($query, true);
                $message = esc_html__("Ad Deleted Successfully", "carspot-rest-api");
            } else {
                $message = esc_html__("Some error occured.", "carspot-rest-api");
            }
        } else {
            $message = esc_html__("Invalid Post Id", "carspot-rest-api");
        }
        $response = array('success' => true, 'data' => $query, 'message' => $message);
        return $response;
    }

}

/* Add To favs */
if (!function_exists('carspotAPI_ad_add_to_fav')) {

    function carspotAPI_ad_add_to_fav($request) {
        $userID = wp_get_current_user();

        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $post_data = get_post($ad_id);

        if (empty($userID) || $userID == "") {
            $message = esc_html__("Invalid Access", "carspot-rest-api");
            return $response = array('success' => false, 'data' => '', 'message' => $message);
        }

        if (isset($post_data) && $post_data != "") {
            $author_id = $post_data->post_author;

            if ($author_id == $userID->ID && $post_data->ID != "") {
                $query = array('ID' => $post_data->ID, 'post_status' => 'trash',);

                $message = esc_html__("Added To Favourites", "carspot-rest-api");
            } else {
                $message = esc_html__("Already Added To Favourites", "carspot-rest-api");
            }
        } else {
            $message = esc_html__("Invalid Post Id", "carspot-rest-api");
        }
        $response = array('success' => true, 'data' => '', 'message' => $message);

        return $response;
    }

}
/* Add To favs ends */

if (!function_exists('carspotAPI_basic_profile_bar')) {

    function carspotAPI_basic_profile_bar($user_id = '') {
        if ($user_id == "") {
            $user = wp_get_current_user();
            $user_id = $user->ID;
        } else {
            $user = get_userdata($user_id);
        }


        $sb_user_type = get_user_meta($user->ID, '_sb_user_type', true);
        //$usr_company_name = ( $sb_user_type == 'dealer' ) ? get_user_meta($user->ID, '_sb_camp_name', true ) : $user->display_name;
        if (get_user_meta($user->ID, '_sb_camp_name', true) != '') {
            $usr_company_name = get_user_meta($user->ID, '_sb_camp_name', true);
        } else {
            $usr_company_name = $user->display_name;
        }

        $data = array();
        $data['id'] = $user_id;
        $data['name'] = $usr_company_name;
        $data['btn_text'] = esc_html__("View Profile", "carspot-rest-api");
        $data['location'] = get_user_meta($user_id, '_sb_address', true);
        $data['image'] = carspotAPI_user_dp($user_id, 'carspot-user-profile');
        $data['last_login'] = carspotAPI_getLastLogin($user_id, true);
        $data['rating']['is_show'] = true;
        $data['rating']['number'] = carspotAPI_user_ratting_info($user_id, 'stars');
        $data['rating']['text'] = carspotAPI_user_ratting_info($user_id, 'count');
        return $data;
    }

}

if (!function_exists('carspotAPI_basic_profile_data')) {

    function carspotAPI_basic_profile_data($user_id = '') {
        if ($user_id == "") {
            $user = wp_get_current_user();
            $user_id = $user->ID;
        } else {
            $user = get_userdata($user_id);
        }

        if (!$user_id)
            return '';

        $profile_arr['id'] = $user_id;
        $profile_arr['user_email'] = $user->user_email;
        $profile_arr['display_name'] = $user->display_name;
        $profile_arr['pro_text'] = esc_html__("My Profile", "carspot-rest-api");
        $profile_arr['view_btn_text'] = esc_html__("View Profile", "carspot-rest-api");
        $profile_arr['phone'] = get_user_meta($user_id, '_sb_contact', true);
        $profile_arr['location'] = get_user_meta($user_id, '_sb_address', true);
        $profile_arr['profile_img'] = carspotAPI_user_dp($user_id, 'carspot-user-profile');
        /* all active ads */
        $ads_total_text = esc_html__("All Ads", "carspot-rest-api");
        $profile_arr['ads_total'] = array("key" => $ads_total_text, "value" => carspotAPI_countPostsHere('publish', '_carspot_ad_status_', 'active', $user_id));

        $ads_inactive_text = esc_html__("Inactive Ads", "carspot-rest-api");
        $profile_arr['ads_inactive'] = array("key" => $ads_inactive_text, "value" => carspotAPI_countPostsHere('pending', '', '', $user_id));

        $ads_sold_text = esc_html__("Sold Ads", "carspot-rest-api");
        $profile_arr['ads_solds'] = array("key" => $ads_sold_text, "value" => carspotAPI_countPostsHere('publish', '_carspot_ad_status_', 'sold', $user_id));

        $ads_expired_text = esc_html__("Expired Ads", "carspot-rest-api");
        $profile_arr['ads_expired'] = array("key" => $ads_expired_text, "value" => carspotAPI_countPostsHere('publish', '_carspot_ad_status_', 'expired', $user_id));

        $ads_featured_text = esc_html__("Featured Ads", "carspot-rest-api");
        $profile_arr['ads_featured'] = array("key" => $ads_featured_text, "value" => carspotAPI_countPostsHere('publish', '_carspot_is_feature', '1', $user_id));

        $profile_arr['expire_ads'] = array("key" => esc_html__("Expiry Ads", "carspot-rest-api"), "value" => get_user_meta($user_id, '_carspot_expire_ads', true));
        $profile_arr['simple_ads'] = array("key" => esc_html__("Simple Ads", "carspot-rest-api"), "value" => get_user_meta($user_id, '_sb_simple_ads', true));

        $profile_arr['featured_ads'] = array("key" => esc_html__("Featured Ads", "carspot-rest-api"), "value" => get_user_meta($user_id, '_sb_featured_ads', true));
        $profile_arr['featured_ads'] = get_user_meta($user_id, '_sb_featured_ads', true);
        $profile_arr['package_type'] = get_user_meta($user_id, '_sb_pkg_type', true);
        if (get_user_meta($user_id, '_carspot_expire_ads', true) == -1) {
            $profile_arr['package_expiry'] = array("key" => esc_html__('Package Expire', "carspot-rest-api"), "value" => esc_html__('Never Expire', "carspot-rest-api"));
        } else {
            $profile_arr['package_expiry'] = array("key" => esc_html__("Package Expire", "carspot-rest-api"), "value" => get_user_meta($user_id, '_sb_featured_ads', true));
        }

        $profile_arr['view_public_prfile_text'] = esc_html__("View My Profile", "carspot-rest-api");
        $profile_arr['last_login'] = carspotAPI_getLastLogin($user_id, true);
        $profile_arr['edit_text'] = esc_html__("Edit Profile", "carspot-rest-api");
        $profile_arr['manage_text'] = esc_html__("Manage your ", "carspot-rest-api");
        $profile_arr['manage_text2'] = esc_html__("account settings", "carspot-rest-api");

        $badge_text = esc_attr(get_the_author_meta('_sb_badge_text', $user_id));
        global $carspotAPI;
        if (isset($carspotAPI['sb_new_user_email_verification']) && $carspotAPI['sb_new_user_email_verification']) {
            $token = get_user_meta($user_id, 'sb_email_verification_token', true);
            if ($token && $token != "") {
                $badge_text = esc_html__('Not Verified', "carspot-rest-api");
            }
        }

        $badge_text = ($badge_text) ? $badge_text : esc_html__('Verified', "carspot-rest-api");
        $badge_color = '#8ac249';
        $sb_badge_type = esc_attr(get_the_author_meta('_sb_badge_type', $user_id));
        if ($sb_badge_type == 'label-success')
            $badge_color = '#8ac249';
        else if ($sb_badge_type == 'label-warning')
            $badge_color = '#fe9700';
        else if ($sb_badge_type == 'label-info')
            $badge_color = '#02a8f3';
        else if ($sb_badge_type == 'label-danger')
            $badge_color = '#f34235';

        //$badge_text =
        $profile_arr['verify_buton']['text'] = $badge_text;
        $profile_arr['verify_buton']['color'] = $badge_color;


        $rating_star_avg = avg_user_rating_apps($user_id);
        if (isset($rating_star_avg) && $rating_star_avg != null) {

        } else {
            $rating_star_avg = 0;
        }

        $profile_arr['rate_bar']['avg'] = $rating_star_avg;
        $profile_arr['rate_bar']['count'] = carspot_dealer_review_count($user_id);

        $sb_userType = get_user_meta($user->ID, '_sb_user_type', true);
        $sb_userType = ($sb_userType) ? $sb_userType : esc_html__('Individual', "carspot-rest-api");
        $profile_arr['userType_buton']['text'] = $sb_userType;
        $profile_arr['userType_buton']['color'] = '#8ac249';

        $social_profiles = carspotAPI_social_profiles();
        $profile_arr['is_show_social'] = false;
        if (isset($social_profiles) && count($social_profiles) > 0) {
            $profile_arr['is_show_social'] = true;
            foreach ($social_profiles as $key => $val) {
                $keyName = '';
                $keyName = "_sb_profile_" . $key;
                $keyVal = get_user_meta($user_id, $keyName, true);
                $keyVal = ($keyVal) ? $keyVal : '';
                $profile_arr['social_icons'][] = array("key" => $val, "value" => $keyVal, "field_name" => $keyName);
            }
        }

        return $profile_arr;
    }

}


if (!function_exists('carspotAPI_user_ratting_info')) {

    function carspotAPI_user_ratting_info($user_id = '', $type = 'stars') {
        $stars = get_user_meta($user_id, "_carspot_rating_avg", true);
        $info["stars"] = ($stars == "") ? "0" : $stars;
        $starsCount = get_user_meta($user_id, "_carspot_rating_count", true);
        $info["count"] = ($starsCount != "") ? $starsCount : "0";
        return $info["$type"];
    }

}

if (!function_exists('carspotAPI_countPostsHere')) {

    function carspotAPI_countPostsHere($status = 'publish', $meta_key = '', $meta_val = '', $postAuthor = '') {
        if ($meta_key != "") {

            $args = array("author" => $postAuthor, 'post_type' => 'ad_post', 'post_status' => $status, 'meta_key' => $meta_key, 'meta_value' => $meta_val);
            $query = new WP_Query($args);
        } else {
            $args = array("author" => $postAuthor, 'post_type' => 'ad_post', 'post_status' => $status);
            $query = new WP_Query($args);
        }

        wp_reset_postdata();
        return $query->found_posts;
    }

}

add_action('rest_api_init', 'carspotAPI_user_public_profile_hook', 0);

function carspotAPI_user_public_profile_hook() {

    /* Routs */
    register_rest_route(
            'carspot/v1', '/profile/public/',
            array('methods' => WP_REST_Server::READABLE,
                'callback' => 'carspotAPI_user_public_profile',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
    ///Not using
    register_rest_route(
            'carspot/v1', '/profile/public/',
            array('methods' => WP_REST_Server::EDITABLE,
                'callback' => 'carspotAPI_user_public_profile',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
}

if (!function_exists('carspotAPI_user_public_profile')) {

    function carspotAPI_user_public_profile($request) {
        global $carspotAPI;
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id'])) ? $json_data['user_id'] : '';

        if ($user_id == "") {
            $user = wp_get_current_user();
            $user_id = $user->data->ID;
        }


        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $adsData = carspotApi_userAds($userID->ID, '', '', $paged);
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];

        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'myads';
        $arr['text']['editable'] = 0;
        $arr['text']['show_dropdown'] = 0;
        $arr['profile'] = carspotAPI_basic_profile_data($user_id);
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";

        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}


add_action('rest_api_init', 'carspotAPI_user_ratting_hook', 0);

function carspotAPI_user_ratting_hook() {

    /* Routs */
    register_rest_route(
            'carspot/v1', '/profile/ratting/',
            array('methods' => WP_REST_Server::READABLE,
                'callback' => 'carspotAPI_user_ratting_list',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
    register_rest_route(
            'carspot/v1', '/profile/ratting_get/',
            array('methods' => WP_REST_Server::EDITABLE,
                'callback' => 'carspotAPI_user_ratting_list',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
}

if (!function_exists('carspotAPI_user_ratting_list')) {

    function carspotAPI_user_ratting_list($request = '') {
        $json_data = $request->get_json_params();
        $author_id = (isset($json_data['author_id'])) ? $json_data['author_id'] : '';

        if ($author_id == "") {
            $author = wp_get_current_user();
            $author_id = $author->data->ID;
        }
        return carspotAPI_user_ratting_list1($author_id);
    }

}

if (!function_exists('carspotAPI_user_ratting_list1')) {

    function carspotAPI_user_ratting_list1($author_id = '', $return_arr = true) {
        $rating_user = wp_get_current_user();
        $rating_user_id = $rating_user->data->ID;
        $ratings = carspotAPI_get_all_ratings($author_id);
        $rateArr = array();
        $rate = array();
        $message = '';
        $rdata = array();
        if (count($ratings) > 0) {

            foreach ($ratings as $rating) {
                $data = explode('_separator_', $rating->meta_value);
                $rated = trim((int) $data[0]);
                $comments = trim($data[1]);
                $date = $data[2];
                $reply = (isset($data[3])) ? $data[3] : '';
                $reply_date = (isset($data[4])) ? $data[4] : '';


                $_arr = explode('_user_', $rating->meta_key);
                $rator = $_arr[1];

                $user = get_user_by('ID', $rator);
                if ($user) {
                    $img = carspotAPI_user_dp($user->ID);
                    $can_reply = ($reply == "" && $rating_user_id == $author_id) ? true : false;
                    $has_reply = ($reply == "") ? false : true;

                    $rate['reply_id'] = $rator;
                    $rate['name'] = $user->display_name;
                    $rate['img'] = $img;
                    $rate['stars'] = (int) ($rated != "") ? $rated : 0;
                    $rate['date'] = date(get_option('date_format'), strtotime($date));
                    $rate["can_reply"] = $can_reply;
                    $rate["has_reply"] = $has_reply;
                    $rate["reply_txt"] = esc_html__('Reply', 'carspot-rest-api');
                    $rate["comments"] = $comments;

                    $rate2 = array();
                    if ($reply != "") {
                        $userR = get_user_by('ID', $author_id);
                        $img2 = carspotAPI_user_dp($author_id);
                        $rate2['name'] = $userR->display_name;
                        $rate2['img'] = $img2;
                        $rate2['stars'] = 0;
                        $rate2['date'] = date(get_option('date_format'), strtotime($reply_date));
                        $rate2["can_reply"] = false;
                        $rate2["has_reply"] = true;
                        $rate2["reply_txt"] = esc_html__('Reply', 'carspot-rest-api');
                        $rate2["comments"] = trim($reply);
                    }

                    $rate["reply"] = $rate2;

                    $rateArr[] = $rate;
                }

                if (count($rateArr) == 0) {
                    $message = ($author_id != $rating_user_id) ? esc_html__('Be the first one to rate this user.', 'carspot-rest-api') : esc_html__('Currently no rating available..', 'carspot-rest-api');
                }
            }
        } else {

            $message = ($author_id != $rating_user_id) ? esc_html__('Be the first one to rate this user.', 'carspot-rest-api') : esc_html__('Currently no rating available..', 'carspot-rest-api');
        }
        $can_rate = ($author_id == $rating_user_id) ? false : true;
        /* User Ratting Form Info */
        $rdata['page_title'] = esc_html__('User Rating', 'carspot-rest-api');
        $rdata['rattings'] = $rateArr;
        $rdata['can_rate'] = $can_rate;
        $rdata['form']['title'] = esc_html__('Rate Here', 'carspot-rest-api');
        $rdata['form']['select_text'] = esc_html__('Rating', 'carspot-rest-api');
        $rdata['form']['select_value'] = array(1, 2, 3, 4, 5);
        $rdata['form']['textarea_text'] = esc_html__('Comments', 'carspot-rest-api');
        $rdata['form']['textarea_value'] = '';
        $rdata['form']['tagline'] = esc_html__('You can not edit it later.', 'carspot-rest-api');
        $rdata['form']['btn'] = esc_html__('Submit Your Rating', 'carspot-rest-api');

        if ($return_arr == true) {
            $response = array('success' => true, 'data' => $rdata, 'message' => $message, "ratings " => $ratings);
            return $response;
        } else {
            return $rateArr;
        }
    }

}

add_action('rest_api_init', 'carspotAPI_post_ratting_hook', 0);

function carspotAPI_post_ratting_hook() {
    register_rest_route(
            'carspot/v1', '/profile/ratting/',
            array('methods' => WP_REST_Server::EDITABLE,
                'callback' => 'carspotAPI_post_user_ratting',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
    ));
}

if (!function_exists('carspotAPI_post_user_ratting')) {

    function carspotAPI_post_user_ratting($request) {
        $json_data = $request->get_json_params();
        $ratting = (isset($json_data['ratting'])) ? (int) $json_data['ratting'] : '';
        $comments = (isset($json_data['comments'])) ? trim($json_data['comments']) : '';
        $author = (isset($json_data['author_id'])) ? (int) $json_data['author_id'] : '';
        $is_reply = (isset($json_data['is_reply']) && $json_data['is_reply'] == true) ? true : false;
        $authorData = wp_get_current_user();
        $rator = $authorData->data->ID;
        $cUser = $authorData->data->ID;

        if ($author == $rator)
            return array('success' => false, 'data' => '', 'message' => esc_html__("You can't rate yourself.", "carspot-rest-api"));

        if ($is_reply == true) {
            $rdata = array();
            $rator = $author;
            $got_ratting = $rator;

            $ratting = get_user_meta($cUser, "_user_" . $rator, true);
            $data_arr = explode('_separator_', $ratting);
            if (count($data_arr) > 3) {
                return array('success' => false, 'data' => '', 'message' => esc_html__("You already replied to this user.", "carspot-rest-api"));
            } else {
                $ratting = $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d');
                update_user_meta($cUser, '_user_' . $rator, $ratting);

                $rdata['rattings'] = carspotAPI_user_ratting_list1($cUser, false);
                return array('success' => true, 'data' => $rdata, 'message' => esc_html__("You're reply has been posted.", "carspot-rest-api"));
            }
        } else {
            if (get_user_meta($author, "_user_" . $rator, true) == "") {
                $rdata = array();
                update_user_meta($author, "_user_" . $rator, $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d'));
                $ratings = carspotAPI_get_all_ratings($author);
                $all_rattings = 0;
                $got = 0;
                if (count($ratings) > 0) {
                    foreach ($ratings as $rating) {
                        $data = explode('_separator_', $rating->meta_value);
                        $got = $got + $data[0];
                        $all_rattings++;
                    }
                    $avg = $got / $all_rattings;
                } else {
                    $avg = $ratting;
                }

                update_user_meta($author, "_carspot_rating_avg", $avg);
                $total = get_user_meta($author, "_carspot_rating_count", true);
                if ($total == "") {
                    $total = 0;
                }
                $total = $total + 1;
                update_user_meta($author, "_carspot_rating_count", $total);

                // Send email if enabled
                global $carspotAPI;
                if (isset($carspotAPI['sb_rating_email_author']) && $carspotAPI['sb_rating_email_author']) {
                    carspot_send_email_new_rating($rator, $author, $ratting, $comments);
                }
                $rdata['rattings'] = carspotAPI_user_ratting_list1($author, false);
                return array('success' => true, 'data' => $rdata, 'message' => esc_html__("You've rated this user.", "carspot-rest-api"));
            } else {
                return array('success' => false, 'data' => '', 'message' => esc_html__("You already rated this user.", "carspot-rest-api"));
            }
        }
    }

}

/* API custom endpoints for WP-REST API */
add_action('rest_api_init', 'carspotAPI_profile_nearby', 0);

function carspotAPI_profile_nearby() {
    register_rest_route(
            'carspot/v1', '/profile/nearby/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_profile_nearby_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );

    register_rest_route(
            'carspot/v1', '/profile/nearby/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_profile_nearby_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_nearby_get')) {

    function carspotAPI_profile_nearby_get($request) {
        $data = array();
        $user_id = get_current_user_id();
        $success = false;
        if ($user_id) {

            if (isset($request)) {
                $json_data = $request->get_json_params();
                $latitude = (isset($json_data['nearby_latitude'])) ? $json_data['nearby_latitude'] : '';
                $longitude = (isset($json_data['nearby_longitude'])) ? $json_data['nearby_longitude'] : '';
                $distance = (isset($json_data['nearby_distance'])) ? $json_data['nearby_distance'] : '20';
                if ($latitude != "" && $longitude != "") {
                    $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
                    update_user_meta($user_id, '_sb_user_nearby_data', $data_array);
                    $success = true;
                } else {
                    update_user_meta($user_id, '_sb_user_nearby_data', '');
                    $success = false;
                }
            }

            $data = carspotAPI_determine_minMax_latLong();
        }

        $message = ($success) ? esc_html__("Nearby option turned on", "carspot-rest-api") : esc_html__("Nearby option turned of", "carspot-rest-api");

        return array('success' => $success, 'data' => $data, 'message' => $message);
    }

}
/* NearByAdsStarts */
add_action('rest_api_init', 'carspotAPI_nearby_ads_hook', 0);

function carspotAPI_nearby_ads_hook() {
    /* Routs */
    register_rest_route(
            'carspot/v1', '/ad/nearby/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_nearby_ads_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

/* Active Ads */
if (!function_exists('carspotAPI_nearby_ads_get')) {

    function carspotAPI_nearby_ads_get($request) {
        $json_data = $request->get_json_params();
        $paged = (isset($json_data['page_number'])) ? $json_data['page_number'] : '1';

        $userID = wp_get_current_user();
        $adsData = carspotApi_userAds('', '', '', $paged, 'publish', 'near_me');
        $arr['ads'] = $adsData['ads'];
        $arr['pagination'] = $adsData['pagination'];

        $arr['page_title'] = esc_html__('Near By ads', 'carspot-rest-api');
        $arr['text'] = carspotAPI_user_ad_strings();
        $arr['text']['ad_type'] = 'nearby';
        $arr['text']['editable'] = '1';
        $arr['text']['show_dropdown'] = '1';
        $arr['profile'] = carspotAPI_basic_profile_data();
        $message = (count($arr['ads']) == 0) ? esc_html__("No ad found", "carspot-rest-api") : "";
        $response = array('success' => true, 'data' => $arr, 'message' => $message);
        return $response;
    }

}
/* NearByAdsENds */

add_action('rest_api_init', 'carspotAPI_profile_package_details_hook', 0);

function carspotAPI_profile_package_details_hook() {

    register_rest_route(
            'carspot/v1', '/profile/purchases/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_profile_package_details',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
            )
    );
}

if (!function_exists('carspotAPI_profile_package_details')) {

    function carspotAPI_profile_package_details() {

        $user_id = get_current_user_id();
        $args = array('customer_id' => $user_id,);

        $order_hostory = array();
        $order_hostory[] = array(
            "order_number" => esc_html__('Order #', 'carspot-rest-api'),
            "order_name" => esc_html__('Package(s)', 'carspot-rest-api'),
            "order_status" => esc_html__('Status', 'carspot-rest-api'),
            "order_date" => esc_html__('Date', 'carspot-rest-api'),
            "order_total" => esc_html__('Order total', 'carspot-rest-api'),
        );

        $orders = wc_get_orders($args);
        $message = '';
        if (count($orders) > 0) {
            foreach ($orders as $order) {
                $order_id = $order->get_id();
                $items = $order->get_items();
                $product_name = array();

                foreach ($items as $item) {
                    $product_name[] = $item->get_name();
                }
                $product_names = implode(",", $product_name);
                $order_hostory[] = array(
                    "order_number" => $order_id,
                    "order_name" => $product_names,
                    "order_status" => wc_get_order_status_name($order->get_status()),
                    "order_date" => date_i18n(get_option('date_format'), strtotime($order->get_date_created())),
                    "order_total" => $order->get_total(),
                );
            }
        } else {
            $message = esc_html__('No Order Found', 'carspot-rest-api');
        }
        $data['page_title'] = esc_html__('Packages History', 'carspot-rest-api');
        $data['order_hostory'] = $order_hostory;
        return array('success' => true, 'data' => $data, 'message' => $message);
    }

}

/* -----  Ad rating And Comments Starts  ----- */
add_action('rest_api_init', 'carspotAPI_profile_gdpr_delete_user_hook', 0);

function carspotAPI_profile_gdpr_delete_user_hook() {

    register_rest_route('carspot/v1', '/profile/delete/user_account/',
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => 'carspotAPI_profile_gdpr_delete_user',
                'permission_callback' => function () {
                    return carspotAPI_basic_auth();
                },
            )
    );
}

if (!function_exists('carspotAPI_profile_gdpr_delete_user')) {

    function carspotAPI_profile_gdpr_delete_user($request) {
        global $carspotAPI; /* For Redux */
        $json_data = $request->get_json_params();
        $user_id = (isset($json_data['user_id']) && $json_data['user_id'] != "") ? $json_data['user_id'] : '';

        $current_user = get_current_user_id();

        $success = false;
        $message = esc_html__("Something went wrong.", "carspot-rest-api");
        $if_user_exists = carspotAPI_user_id_exists($user_id);
        if ($current_user == $user_id && $if_user_exists) {
            if (current_user_can('administrator')) {

                $success = false;
                $message = esc_html__("Admin can not delete his account from here.", "carspot-rest-api");
            } else {
                carspotAPI_delete_userComments($user_id);
                $user_delete = wp_delete_user($user_id);
                if ($user_delete) {

                    $success = true;
                    $message = esc_html__("You account has been delete successfully.", "carspot-rest-api");
                }
            }
        }

        return array('success' => $success, 'data' => '', 'message' => $message);
    }

}

if (!function_exists('carspotAPI_user_id_exists')) {

    function carspotAPI_user_id_exists($user) {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
        return ($count == 1) ? true : false;
    }

}

if (!function_exists('carspotAPI_delete_userComments')) {

    function carspotAPI_delete_userComments($user_id) {
        $user = get_user_by('id', $user_id);

        $comments = get_comments('author_email=' . $user->user_email);
        if ($comments && count($comments) > 0) {
            foreach ($comments as $comment) :
                @wp_delete_comment($comment->comment_ID, true);
            endforeach;
        }

        $comments = get_comments('user_id=' . $user_id);
        if ($comments && count($comments) > 0) {
            foreach ($comments as $comment) :
                @wp_delete_comment($comment->comment_ID, true);
            endforeach;
        }
    }

}

if (!function_exists('carspotAPI_dealer_cinfirmDialog')) {

    function carspotAPI_dealer_cinfirmDialog($user_id = '') {
        if ($user_id == "" || $user_id == 0) {
            $user = wp_get_current_user();
            $user_id = (isset($user->data->ID) && $user->data->ID) ? $user->data->ID : 0;
        }

        $dealer_dialog = array();
        if ($user_id) {
            $sb_userType_data = get_user_meta($user_id, '_sb_user_type', true);
            $dealer_dialog_is_show = ($sb_userType_data != '') ? false : true;

            //$dealer_dialog_is_show = true;

            $dealer_dialog['is_show'] = $dealer_dialog_is_show;
            if ($dealer_dialog_is_show) {
                $dealer_dialog['title'] = esc_html__("Please select your user type", "carspot-rest-api");
                $dealer_dialog['desc'] = esc_html__("NOTE: Please note that you cannot change it later so please make it sure if you are a dealer or individual", "carspot-rest-api");

                $dealer_dialog['select_type'] = 'user_type';
                $type_array = array();
                $type_array[] = array("key" => "", "value" => esc_html__("Please select your user type", "carspot-rest-api"));
                $type_array[] = array("key" => "individual", "value" => esc_html__("Individual", "carspot-rest-api"));
                $type_array[] = array("key" => "dealer", "value" => esc_html__("Dealer", "carspot-rest-api"));

                $dealer_dialog['select'] = $type_array;

                $dealer_dialog['button'] = esc_html__("Save", "carspot-rest-api");
                $dealer_dialog['alert']['text'] = esc_html__("Are you sure you want to save?", "carspot-rest-api");
                $dealer_dialog['alert']['confirm'] = esc_html__("Confirm", "carspot-rest-api");
                $dealer_dialog['alert']['cancel'] = esc_html__("Cancel", "carspot-rest-api");
            }
        }
        return $dealer_dialog;
    }

}

if (!function_exists('avg_user_rating_apps')) {

    function avg_user_rating_apps($user_id = '') {
        $total_ratings_count = carspot_dealer_review_count($user_id);
        $args = array(
            'user_id' => $user_id,
            'type' => 'dealer_review',
        );

        $get_rating = get_comments($args);
        if (count((array) $get_rating) > 0) {
            $avg_array = array();
            foreach ($get_rating as $get_ratings) {
                $comment_ids = $get_ratings->comment_ID;
                $service_stars = get_comment_meta($comment_ids, '_rating_service', true);
                $process_stars = get_comment_meta($comment_ids, '_rating_proces', true);
                $selection_stars = get_comment_meta($comment_ids, '_rating_selection', true);

                $single_avg = 0;
                $total_stars = $service_stars + $process_stars + $selection_stars;
                $single_avg = round($total_stars / "3", 1);


                $avg_array[] = $single_avg;
            }
            $total_sum = array_sum($avg_array);

            $total_avg = round($total_sum / $total_ratings_count, 1);
            return $total_avg;
        }
    }

}
    