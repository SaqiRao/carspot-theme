<?php
/** Add REST API support to an already registered post type. */
add_action('init', 'carspotAPI_post_type_rest_support_search', 25);

function carspotAPI_post_type_rest_support_search()
{
    global $wp_post_types;
    $post_type_name = 'ad_post';
    if (isset($wp_post_types[$post_type_name])) {
        $wp_post_types[$post_type_name]->show_in_rest = true;
        $wp_post_types[$post_type_name]->rest_base = $post_type_name;
        $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
    }
}

/** display ads detail page  */
add_action('rest_api_init', 'carspotAPI_profile_api_ads_hooks_get', 0);

function carspotAPI_profile_api_ads_hooks_get()
{
    register_rest_route(
        'carspot/v1', '/ad_post/', array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_ad_posts_get',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_ad_posts_get')) {

    function carspotAPI_ad_posts_get($request)
    {
        global $carspotAPI;
        global $carspot_theme;
        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $user = wp_get_current_user();
        $user_id = (@$user) ? @$user->data->ID : '';
        $post = get_post($ad_id);
        $ad_post_author = get_post_field('post_author', $post->ID);
        /* Expiration of ad starts */
        $has_ad_expired = false;
        if (isset($carspot_theme['simple_ad_removal']) && $carspot_theme['simple_ad_removal'] != '-1') {
            $now = strtotime(current_time('mysql')); /* time(); // or your date as well */
            $simple_date = strtotime(get_the_date('Y-m-d', $post->ID));
            $simple_days = carspotAPI_days_diff($now, $simple_date);
            $expiry_days = $carspot_theme['simple_ad_removal'];
            if ($simple_days > $expiry_days) {
                $has_ad_expired = true;
                wp_trash_post($ad_id);
            }
        }

        if (get_post_meta($ad_id, '_carspot_is_feature', true) == '1' && $carspot_theme['featured_expiry'] != '-1') {
            if (isset($carspot_theme['featured_expiry']) && $carspot_theme['featured_expiry'] != '-1') {
                $now = strtotime(current_time('mysql')); /* time(); // or your date as well */
                $featured_date = strtotime(get_post_meta($ad_id, '_carspot_is_feature_date', true));
                $featured_days = carspotAPI_days_diff($now, $featured_date);
                $expiry_days = $carspot_theme['featured_expiry'];
                if ($featured_days > $expiry_days) {
                    update_post_meta($ad_id, '_carspot_is_feature', 0);
                }
            }
        }
        /* Expiration of ad ends */
        $data = '';
        if (!$post && @count($post) == 0) {
            $response = array('success' => false, 'data' => $data, 'message' => __("'Invalid post id'", "carspot-rest-api"));
        }
        $post_categories = wp_get_object_terms($ad_id, array('ad_cats'), array('orderby' => 'term_group'));
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cat_name = esc_html($cat->name);
        }
        $description = trim(preg_replace('/\s+/', ' ', API_carspot_get_formated_description($post->post_content)));
        $ad_author_id = get_post_field('post_author', $post->ID);

        $ad_detail['ad_author_id'] = $ad_author_id;
        $ad_detail['author_id'] = $ad_author_id;
        $ad_detail['ad_id'] = $post->ID;
        $ad_detail['ad_cat'] = $cat_name;
        $ad_detail['ad_title'] = $post->post_title;
        $ad_detail['ad_desc'] = $description;
        $ad_detail['ad_date'] = get_the_date("", $post->ID);
        $ad_detail['ad_price'] = carspotAPI_get_price('', $post->ID);
        $poster_name = get_post_meta($post->ID, '_carspot_poster_name', true);
        $ad_detail['name'] = $poster_name;
        $ad_detail['ad_bidding'] = get_post_meta($post->ID, '_carspot_ad_bidding', true);
        $ad_detail['featured_ads'] = get_post_meta($post->ID, '_carspot_featured_ads', true);
        $ad_detail['expire_date'] = get_post_meta($post->ID, '_carspot_expire_ads', true);
        $ad_detail['ad_status'] = get_post_meta($post->ID, '_carspot_ad_status_', true);
        $ad_detail['ad_timer'] = carspotAPI_get_adTimer($post->ID);
        $poster_phone = get_post_meta($post->ID, '_carspot_poster_contact', true);
        $ad_type_bar = false;
        if (get_post_meta($post->ID, '_carspot_ad_type', true) != "") {
            $ad_type_bar = true;
            $ad_detail['ad_type_bar']['text'] = get_post_meta($post->ID, '_carspot_ad_type', true);
        }
        $ad_detail['ad_type_bar']['is_show'] = false;

        $is_feature_ads = (get_post_meta($post->ID, '_carspot_is_feature', true) == '1') ? true : false;
        $ad_detail['is_feature'] = $is_feature_ads;
        $ad_detail['is_feature_text'] = ($is_feature_ads) ? __("Featured", "carspot-rest-api") : '';
        /* setPostViews */
        carspotAPI_setPostViews($post->ID);
        $viewCount = get_post_meta($post->ID, "sb_post_views_count", true);
        $viewCount = ($viewCount != "") ? $viewCount : 0;
        $ad_detail['ad_view_count'] = $viewCount;

        $ad_detail['ad_video'] = carspotAPI_get_adVideo($post->ID);
        $myAdLocation = carspotAPI_get_adAddress($post->ID);
        $ad_detail['location'] = $myAdLocation;

        $ad_myCountry1 = (isset($myAdLocation['address']) && $myAdLocation['address'] != "") ? $myAdLocation['address'] : '';
        $is_show_location = wp_count_terms('ad_country');
        $ad_myCountry2 = '';
        if (isset($is_show_location) && $is_show_location > 0) {
            $ad_myCountry2 = carspotAPI_get_ad_terms_names($ad_id, 'ad_country', '', '', $separator = ',');
        }

        $ad_myCountry = ($ad_myCountry2 != "") ? $ad_myCountry2 : $ad_myCountry1;
        $ad_detail['fieldsData_feature_txt'] = __("Overview", "carspot-rest-api");
        $ad_detail['fieldsData'] = carspotAPI_get_customFields((int)$post->ID);

        $ad_mileage = '';
        $ad_mileage = get_post_meta($ad_id, '_carspot_ad_mileage', true);

        if (isset($ad_mileage)) {
            $ad_detail['ad_mileage'] = $ad_mileage;
        }

        $ad_detail['fieldsData_location'] = array("key" => __("Location", "carspot-rest-api"), "value" => esc_html($ad_myCountry), "type" => '');
        $ad_avg_city = get_post_meta($post->ID, '_carspot_ad_avg_city', true);
        $ad_avg_hwy = get_post_meta($post->ID, '_carspot_ad_avg_hwy', true);
        $isCityHwy = ($ad_avg_hwy != "" && $ad_avg_hwy != "") ? true : false;
        if (isset($carspot_theme['allow_ad_economy']) && $carspot_theme['allow_ad_economy'] == false) {
            $isCityHwy = false;
        }
        $ad_detail['fuel_economy_is_show'] = $isCityHwy;
        if ($isCityHwy) {
            $ad_detail['fuel_economy'] = array("title" => __("Fuel Economy", "carspot-rest-api"), "city" => $ad_avg_city, "city_text" => __("City MPG", "carspot-rest-api"), "highway" => $ad_avg_hwy, "highway_text" => __("Highway MPG", "carspot-rest-api"),);
        }
        /* Car Features */
        $ad_detail['car_features_title'] = __("Features", "carspot-rest-api");
        $ad_detail['car_features'] = array();
        $adfeatures = get_post_meta($post->ID, '_carspot_ad_features', true);
        if (isset($adfeatures) && $adfeatures != "") {
            $features = explode('|', $adfeatures);
            if (count((array)$features) > 0) {
                foreach ($features as $feature) {
                    $tax_feature = get_term_by('name', $feature, 'ad_features');
                    if ($tax_feature == true) {
                        $cat_meta = get_option("taxonomy_term_$tax_feature->term_id");
                        $ad_detail['car_features'][] = esc_html($feature);
                    }
                }
            }
        }

        /* Vehicle History Report Under Description */
        $ad_detail['review_history']['vehicle_review_url'] = '';
        $ad_detail['review_history']['review_title_opt'] = '';
        $ad_detail['review_history']['review_logo_opt'] = '';
        if ($carspot_theme['enable_vehicle_review'] == true) {
            $vehicle_revi_url = '';
            $ad_vehicle_review_url = (get_post_meta($post->ID, '_carspot_ad_vehicle_review_url', true) != '') ? get_post_meta($post->ID, '_carspot_ad_vehicle_review_url', true) : '';
            $vehicle_review_enabled_opt = ($carspot_theme['vehicle_review_enabled_opt'] != '') ? $carspot_theme['vehicle_review_enabled_opt'] : '';
            $vehicle_review_title_opt = ($carspot_theme['vehicle_review_title'] != '') ? $carspot_theme['vehicle_review_title'] : '';
            $vehicle_review_url_opt = ($carspot_theme['vehicle_review_url'] != '') ? $carspot_theme['vehicle_review_url'] : '';
            $vehicle_review_logo_opt = ($carspot_theme['vehicle_review_logo'] != '') ? $carspot_theme['vehicle_review_logo']['url'] : '';

            if ($vehicle_review_url_opt != '' && $vehicle_review_enabled_opt == 'all' && $ad_vehicle_review_url == '') {
                $vehicle_revi_url = $vehicle_review_url_opt;
            } elseif ($ad_vehicle_review_url != '' && ($vehicle_review_enabled_opt == 'specific' || $vehicle_review_enabled_opt == 'all')) {
                $vehicle_revi_url = $ad_vehicle_review_url;
            }
            if ($vehicle_revi_url != '' && $vehicle_review_title_opt != '') {
                $ad_detail['review_history']['vehicle_review_url'] = $vehicle_revi_url;
                $ad_detail['review_history']['review_title_opt'] = $vehicle_review_title_opt;
                $ad_detail['review_history']['review_logo_opt'] = $vehicle_review_logo_opt;
            }
        }

        /* Brochure show or hide during post ad */
        $allow_brochure_on_ad = false;
        if (isset($carspotAPI['allow_brochure_on_ad']) && $carspotAPI['allow_brochure_on_ad'] == true) {
            $allow_brochure_on_ad = true;
        }
        $extra['brochere_show'] = $allow_brochure_on_ad;
        /* uploaded pdf brochure detail */
        $borchure = array();
        $brochure_attachment_id = get_post_meta($post->ID, 'carspot_pdf_brochure_arrangement_', true);
        $brochure_attachment_id = explode(",", $brochure_attachment_id);
        if (isset($brochure_attachment_id) && count($brochure_attachment_id) > 0) {
            //for ($i = 0; $i < count($brochure_attachment_id); $i++) {
            foreach ($brochure_attachment_id as $brochr_id) {
                $borchure[] = array("type" => "brochure", "brochure_url" => wp_get_attachment_url($brochr_id), "brochure_name" => get_the_title($brochr_id), "brochure_id" => $brochr_id);
            }
        }
        $ad_detail['pdf_brochures'] = $borchure;

        /* uploaded video detail */
        $upload_video = array();
        $video_attachment_id = get_post_meta($post->ID, 'carspot_video_uploaded_attachment_', true);
        $video_attachment_id = explode(",", $video_attachment_id);
        if (isset($video_attachment_id) && count($video_attachment_id) != '') {
            foreach ($video_attachment_id as $vid_ids) {
                $upload_video[] = array("type" => "uploaded_video", "upload_vid_url" => wp_get_attachment_url($vid_ids), "upload_vid_name" => get_the_title($vid_ids), "upload_vid_id" => $vid_ids);
            }
        }
        $ad_detail['uploaded_video'] = $upload_video;

        /* review stamp logo */
        $ad_detail['car_review_stamp'] = $review = array();
        if ($carspot_theme['enable_review_stamp'] == true) {
            $review_stamp_db = get_post_meta($post->ID, '_carspot_ad_review_stamp', true);
            $get_termID = get_term_by('name', $review_stamp_db, 'ad_review_stamp');
            $term_logo_url = get_term_meta($get_termID->term_id, 'saved_review_logo_url', true);
            $rev_compny_url = get_term_meta($get_termID->term_id, 'review_company_url', true);
            $output_stamps = isset($review_stamp_db) ? $review_stamp_db : '';
            $vin_num_db = get_post_meta($post->ID, 'carspot_ad_vin_number', true);
            if ($review_stamp_db != '' && $vin_num_db != '') {
                $final_url = str_replace('{{vin}}', $vin_num_db, $rev_compny_url);
                $review['review_url'] = ($final_url);
                $review['review_logo'] = esc_url($term_logo_url);
                $review['review_mesg'] = __('Record Found', 'carspot-rest-api');
                $review['vin_nmbr'] = $vin_num_db;
            } else {
                $review['review_url'] = '';
                $review['review_logo'] = '';
                $review['review_mesg'] = __('No Record Found', 'carspot-rest-api');
                $review['vin_nmbr'] = '';
            }
        }
        $ad_detail['car_review_stamp'] = $review;
        /* Get ads images */
        //$ad_detail['images'] = carspotAPI_get_ad_image($post->ID);
        $ad_detail['images'] = carspotAPI_get_ad_videos_images_with_arrangment($post->ID, '', 'image');
        $ad_detail['images_count'] = sprintf(__('See %d photos.', 'carspot-rest-api'), count(carspotAPI_get_ad_image($post->ID)));
        $profile_detail = carspotAPI_basic_profile_bar($ad_author_id);
        $static_text['share_btn'] = __("Share", "carspot-rest-api");
        $static_text['fav_btn'] = __("Add To Favourites", "carspot-rest-api");
        $static_text['report_btn'] = __("Report", "carspot-rest-api");
        $send_msg_btn_type = ($user_id == $ad_author_id) ? 'receive' : 'sent';
        $send_msg_btn = ($user_id == $ad_author_id) ? __("View Messages", "carspot-rest-api") : __("Send Message", "carspot-rest-api");
        $static_text['send_msg_btn_type'] = $send_msg_btn_type;
        $static_text['send_msg_btn'] = $send_msg_btn;
        $static_text['call_now_btn'] = __("Call Now", "carspot-rest-api");
        $static_text['pdf_brocher'] = __("Pdf Brochure", "carspot-rest-api");
        $communication_mode = (isset($carspot_theme['communication_mode'])) ? $carspot_theme['communication_mode'] : 'both';
        if ($communication_mode == 'phone') {
            $show_call_btn = true;
            $show_megs_btn = false;
        } else if ($communication_mode == 'message') {
            $show_call_btn = false;
            $show_megs_btn = true;
        } else {
            $show_call_btn = true;
            $show_megs_btn = true;
        }
        $static_text['show_call_btn'] = $show_call_btn;
        $static_text['show_megs_btn'] = $show_megs_btn;
        /* For Contact Info */
        $static_text['contact_info']['phone']['is_show'] = $show_call_btn;
        $static_text['contact_info']['phone']['text'] = __("Click To View Phone Number", "carspot-rest-api");
        $static_text['contact_info']['phone']['number'] = $poster_phone;
        $static_text['contact_info']['message']['is_show'] = $show_megs_btn;
        $static_text['contact_info']['message']['text'] = __("Message", "carspot-rest-api");
        /* For offer Popup Starts */
        $offer_is_show = (isset($carspot_theme['make_offer_form_on']) && $carspot_theme['make_offer_form_on'] == true) ? true : false;
        $static_text['contact_info']['offer']['is_show'] = $offer_is_show;
        $static_text['contact_info']['offer']['form_type'] = array('form_type' => 'offer', 'ad_id' => $post->ID);
        $static_text['contact_info']['offer']['text'] = __("Make Offer", "carspot-rest-api");
        $static_text['contact_info']['offer']['popup']['title'] = __("Make an offer for", "carspot-rest-api");
        $static_text['contact_info']['offer']['popup']['sub_title'] = $post->post_title;

        $static_text['contact_info']['offer']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'name', "field_name" => __("Name", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['offer']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'email', "field_name" => __("Email", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['offer']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'phone', "field_name" => __("Phone", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['offer']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'price', "field_name" => __("Price", "carspot-rest-api"), "field_val" => "", "is_required" => true);

        $static_text['contact_info']['offer']['popup']['fields'][] = array("field_type" => 'textarea', "field_type_name" => 'message', "field_name" => __("Message", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['offer']['popup']['btn_submit'] = __("Make Offer", "carspot-rest-api");
        /* For offer Popup ends */
        /* For schedule Popup Starts */
        $is_show_test_drive = (isset($carspot_theme['test_drive_form_on']) && $carspot_theme['test_drive_form_on'] == true) ? true : false;
        $static_text['contact_info']['schedule']['is_show'] = $is_show_test_drive;
        $static_text['contact_info']['schedule']['form_type'] = array('form_type' => 'schedule', 'ad_id' => $post->ID);
        $static_text['contact_info']['schedule']['text'] = __("Schedule Drive", "carspot-rest-api");
        $static_text['contact_info']['schedule']['popup']['title'] = __("Schedule test drive", "carspot-rest-api");
        $static_text['contact_info']['schedule']['popup']['sub_title'] = $post->post_title;
        $static_text['contact_info']['schedule']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'name', "field_name" => __("Name", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['schedule']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'email', "field_name" => __("Email", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['schedule']['popup']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'phone', "field_name" => __("Phone", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['schedule']['popup']['fields'][] = array("field_type" => 'textfield_datetime', "field_type_name" => 'set_time', "field_name" => __("Set Date", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['schedule']['popup']['fields'][] = array("field_type" => 'textarea', "field_type_name" => 'message', "field_name" => __("Message", "carspot-rest-api"), "field_val" => "", "is_required" => true);
        $static_text['contact_info']['schedule']['popup']['btn_submit'] = __("Request Schedule", "carspot-rest-api");
        /* For schedule Popup ENds */
        /* For Finacne Calc Starts */
        $finacne_calc_is_show = (isset($carspot_theme['finacne_calc_on']) && $carspot_theme['finacne_calc_on'] == true) ? true : false;
        $static_text['finacne_calc']['is_show'] = $finacne_calc_is_show;
        if ($finacne_calc_is_show) {
            $static_text['finacne_calc']['title'] = __("Financing Calculator", "carspot-rest-api");
            $static_text['finacne_calc']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'vehicle_price', "field_name" => __("Vehicle price ($ )", "carspot-rest-api"), "field_val" => "", "is_required" => true);
            $static_text['finacne_calc']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'rate', "field_name" => __("Rate (%)", "carspot-rest-api"), "field_val" => "", "is_required" => true);
            $static_text['finacne_calc']['fields'][] = array("field_type" => 'textfield', "field_type_name" => 'period', "field_name" => __("Period (month)", "carspot-rest-api"), "field_val" => "", "is_required" => true);
            $static_text['finacne_calc']['fields'][] = array("field_type" => 'textfield_datetime', "field_type_name" => 'down_payment', "field_name" => __("Down Payment ($ )", "carspot-rest-api"), "field_val" => "", "is_required" => true);
            $static_text['finacne_calc']['rate'] = 1200;
            $static_text['finacne_calc']['btn_submit'] = __("Calculate", "carspot-rest-api");
            $static_text['finacne_calc']['btn_reset'] = __("Reset", "carspot-rest-api");
            $static_text['finacne_calc']['monthly_pay'] = __("Monthly Installment:", "carspot-rest-api");
            $static_text['finacne_calc']['total_rate'] = __("Total Interest:", "carspot-rest-api");
            $static_text['finacne_calc']['total_pay'] = __("Total Amount to Pay:", "carspot-rest-api");
        }
        /* For Finacne Calc Ends */
        $bid_now_txt = ($user_id != $ad_author_id) ? __("Bid Now", "carspot-rest-api") : __("View Bids", "carspot-rest-api");
        $static_text['bid_now_btn'] = $bid_now_txt;
        $static_text['bid_stats_btn'] = __("Bid Statistics", "carspot-rest-api");
        $static_text['bid_tabs']['bid'] = __("Bidding", "carspot-rest-api");
        $static_text['bid_tabs']['stats'] = __("Bid Statistics", "carspot-rest-api");
        $static_text['get_direction'] = __("Get Direction", "carspot-rest-api");
        $static_text['description_title'] = __("Description", "carspot-rest-api");
        $allow_block = (isset($carspotAPI['sb_user_allow_block']) && $carspotAPI['sb_user_allow_block']) ? true : false;
        $static_text['block_user']['is_show'] = $allow_block;
        if ($allow_block) {
            $static_text['block_user']['text'] = __("Block User", "carspot-rest-api");
            $static_text['block_user']['popup_title'] = __("Block User?", "carspot-rest-api");
            $static_text['block_user']['popup_text'] = __("Are you sure you want to block user. You will not see this user ads anywhere.", "carspot-rest-api");
            $static_text['block_user']['popup_cancel'] = __("Cancel", "carspot-rest-api");
            $static_text['block_user']['popup_confirm'] = __("Confrim", "carspot-rest-api");
        }
        /* Bids */
        $is_bid_enabled = false;
        if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer']) {
            $is_bid_enabled = true;
            if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user']) {
                $is_bid_enabled = true;
                $is_exist = get_post_meta($post->ID, "_carspot_ad_bidding", true);
                $is_bid_enabled = ($is_exist == 1) ? true : false;
            }
        }
        $static_text['ad_bids_enable'] = $is_bid_enabled;
        $static_text['ad_bids'] = carspotAPI_bid_stat($post->ID);
        //$static_text['ad_bids_btn'] = __("Make A Bid", "carspot-rest-api");
        $bid_popup['is_show'] = $is_bid_enabled;
        $bid_popup['bid_section_title'] = __("Biddings", "carspot-rest-api");
        $bid_popup['bid_login_text'] = __("User must be logged in in order to post bid", "carspot-rest-api");
        $bid_popup['no_bid'] = __("Be the first bidder", "carspot-rest-api");
        $bid_popup['bid_details'] = carspotAPI_get_ad_bids1($post->ID, true);
        $bid_popup['input_text'] = __("Bid Amount", "carspot-rest-api");
        $bid_popup['input_textarea'] = __("Bid description here", "carspot-rest-api");
        $bid_popup['btn_send'] = __("Send", "carspot-rest-api");
        $bid_popup['btn_cancel'] = __("Cancel", "carspot-rest-api");
        $report_popup['select']['key'] = __("Select Option", "carspot-rest-api");
        $report_popup['select']['text'] = __("Why are you reporting this ad?", "carspot-rest-api");
        $report_popup['select']['name'] = array("offensive", "Spam", "Duplicate",);
        $report_popup['select']['value'] = array("offensive", "Spam", "Duplicate",);
        $report_popup['input_textarea'] = __("You message here.", "carspot-rest-api");
        $report_popup['btn_send'] = __("Send", "carspot-rest-api");
        $report_popup['btn_cancel'] = __("Cancel", "carspot-rest-api");
        $send_message['input_textarea'] = __("You message here.", "carspot-rest-api");
        $send_message['btn_send'] = __("Send", "carspot-rest-api");
        $send_message['btn_cancel'] = __("Cancel", "carspot-rest-api");
        $call_now['text'] = __("Call Now", "carspot-rest-api");
        $call_now['btn_send'] = __("Call Now", "carspot-rest-api");
        $call_now['btn_cancel'] = __("Cancel", "carspot-rest-api");
        $phone_verification = (isset($carspotAPI['sb_phone_verification']) && $carspotAPI['sb_phone_verification']) ? true : false;
        $call_now['phone_verification'] = $phone_verification;
        if ($phone_verification) {
            $is_phone_verified = false;
            $verified_text = __("Not verified", "carspot-rest-api");
            $ad_post_author_id = $ad_author_id;
            $saved_ph = get_user_meta($ad_post_author_id, '_sb_contact', true);
            $adNum = get_user_meta($ad_post_author_id, '_sb_is_ph_verified', true);
            $adNumV = ($adNum == 1) ? true : false;
            if ($saved_ph == $poster_phone && $adNum == 1) {
                $is_phone_verified = true;
                $verified_text = __("verified", "carspot-rest-api");
            }
            $call_now['is_phone_verified'] = $is_phone_verified;
            $call_now['is_phone_verified_text'] = $verified_text;
        }
        $share_info['title'] = $post->post_title;
        $share_info['link'] = get_the_permalink($post->ID);
        $share_info['text'] = __("Share this", "carspot-rest-api");
        $post_status = (get_post_status($post->ID) != "publish") ? __("Waiting for admin approval.", "carspot-rest-api") : "";
        $featured_notify = carspotAPI_adFeatured_notify($post->ID);
        $is_featured_ad['is_show'] = (isset($featured_notify) && count($featured_notify) > 0) ? true : false;
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            /* SomeTHingNew */
        } else {
            $is_featured_ad['is_show'] = false;
        }
        $is_featured_ad['notification'] = $featured_notify;
        //$ad_rating = carspotAPI_adDetails_rating_get($ad_id, 1, false);
        $ad_rating = avg_user_rating_apps($ad_author_id);

        /* Related Articles Started */
        $related_ads_is_show = false;
        $getSimilar = carspotApi_related_ads($post->ID, 1);
        if (isset($carspot_theme['Related_ads_on']) && $carspot_theme['Related_ads_on'] == true && count($getSimilar) > 0) {
            $rtitle = ($carspot_theme['sb_related_ads_title'] != "") ? $carspot_theme['sb_related_ads_title'] : __("Related Posts", "carspot-rest-api");
            $related_ads['title'] = $rtitle;
            $relatedAds = (isset($carspot_theme['max_ads'])) ? $carspot_theme['max_ads'] : 5;
            $getSimilar = carspotApi_related_ads($post->ID, $relatedAds);
            $related_ads['type'] = (isset($carspot_theme['related_ad_style']) && '2' == $carspot_theme['related_ad_style']) ? 'list' : 'grid';
            $related_ads['ads'] = $getSimilar;
            $related_ads_is_show = true;
        }
        $related_ads['is_show'] = $related_ads_is_show;
        /* Related Articles Ends */
        //global $carspotAPI;
        $before_descp = (isset($carspotAPI['style_ad_720_1']) && $carspotAPI['style_ad_720_1'] != "") ? $carspotAPI['style_ad_720_1'] : '';
        $after_descp = (isset($carspotAPI['style_ad_720_2']) && $carspotAPI['style_ad_720_2'] != "") ? $carspotAPI['style_ad_720_2'] : '';

        $section_title = array(
            "video_title" => __("Video", "carspot-rest-api"),
            "map_title" => __("Location On Map", "carspot-rest-api"),
            "bid_title" => __("Bid Stats", "carspot-rest-api"),
        );
        $tabs_text = array(
            "bid_tab_text" => __("Bids", "carspot-rest-api"),
            "overview_tab_text" => __("Overview", "carspot-rest-api"),
        );
        $data = array(
            "ad_detail" => $ad_detail,
            "profile_detail" => $profile_detail,
            "static_text" => $static_text,
            "bid_popup" => $bid_popup,
            "report_popup" => $report_popup,
            "message_popup" => $send_message,
            "call_now_popup" => $call_now,
            "share_info" => $share_info,
            "related_ads" => $related_ads,
            "banners" => array("before" => $before_descp, "after" => $after_descp),
            "section_title" => $section_title,
            "tabs_text" => $tabs_text,
            "profile_rating" => $ad_rating,
        );

        $message_text = '';
        $success_typle = true;
        if (get_post_status($post->ID) != "publish" && $ad_post_author != $user_id && $has_ad_expired) {
            $success_typle = false;
            $message_text = __("This ad is expired.", "carspot-rest-api");
        }
        $response = array('success' => $success_typle, 'data' => $data, 'message' => $message_text);
        return $response;
    }

}

/* add_filter( 'rest_prepare_ad_post', 'carspotAPI_ad_posts_get', 10, 3 ); */
add_action('rest_api_init', 'carspotAPI_ad_post_poup_type_hook', 0);

function carspotAPI_ad_post_poup_type_hook()
{
    register_rest_route(
        'carspot/v1', '/ad_post/popup/submit/', array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_ad_post_poup_type',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_ad_post_poup_type')) {

    function carspotAPI_ad_post_poup_type($request)
    {
        global $carspot_theme;
        $json_data = $request->get_json_params();
        $post_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $form_type = (isset($json_data['form_type'])) ? $json_data['form_type'] : '';
        if ($form_type == "" || $post_id == "") {
            return array('success' => false, 'data' => '', 'message' => __("Invalid Form Submission", "carspot-rest-api"));
        }

        if ($form_type == 'offer') {
            /* For Make Offer */
            $name = (isset($json_data['name'])) ? $json_data['name'] : '';
            $email = (isset($json_data['email'])) ? $json_data['email'] : '';
            $phone = $contact = (isset($json_data['phone'])) ? $json_data['phone'] : '';
            $price = (isset($json_data['price'])) ? $json_data['price'] : '';
            $message_ = (isset($json_data['message'])) ? $json_data['message'] : '';
            if ($name == "" || $email == "" || $phone == "" || $price == "" || $message_ == "") {
                return array('success' => false, 'data' => '', 'message' => __("All fields are required", "carspot-rest-api"));
            } else {
                $message = __("Something went wrong.", 'carspot-rest-api');
                $success = false;
                if (isset($carspot_theme['make_offer_form_on']) && $carspot_theme['make_offer_form_on'] != '') {
                    $message = __("Email sent successfully.", 'carspot-rest-api');
                    $subject = __('Someone make an offer for your ad', 'carspot-rest-api') . '-' . get_the_title($post_id);
                    $body = '<html><body><p>' . $name . __('You have been contacted for test drive of your car', 'carspot-rest-api') . ' <a href="' . esc_url(get_the_permalink($post_id)) . '">' . get_the_title($post_id) . '</a></p></body></html>';
                    $from = get_bloginfo('name');
                    if (isset($carspot_theme['sb_make_offer_email_from']) && $carspot_theme['sb_make_offer_email_from'] != "") {
                        $from = $carspot_theme['sb_make_offer_email_from'];
                    }
                    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                    if (isset($carspot_theme['sb_make_offer_email_message']) && $carspot_theme['sb_make_offer_email_message'] != "") {
                        $author_id = get_post_field('post_author', $post_id);
                        $user_info = get_userdata($author_id);
                        $to = $user_info->user_email;
                        $subject_keywords = array('%mo_name%', '%mo_email%', '%mo_phone%', '%mo_price%', '%mo_msg%', '%mo_ad_link%');
                        $subject_replaces = array($name, $email, $contact, $price, $message_, get_the_permalink($post_id));
                        $subject = str_replace($subject_keywords, $subject_replaces, $carspot_theme['sb_make_offer_email_subject']);
                        $msg_keywords = array('%mo_name%', '%mo_email%', '%mo_phone%', '%mo_price%', '%mo_msg%', '%mo_ad_link%');
                        $msg_replaces = array($name, $email, $contact, $price, $message_, get_the_permalink($post_id));
                        $body = str_replace($msg_keywords, $msg_replaces, $carspot_theme['sb_make_offer_email_message']);
                        $sent_email = wp_mail($to, $subject, $body, $headers);
                        if ($sent_email) {
                            $message = __("Email sent to author successfully.", 'carspot-rest-api');
                            $success = true;
                        }
                    }
                }
                return array('success' => $success, 'data' => '', 'message' => $message);
            }
        } else if ($form_type == 'schedule') {
            /* For Test Drive */
            $name = (isset($json_data['name'])) ? $json_data['name'] : '';
            $email = (isset($json_data['email'])) ? $json_data['email'] : '';
            $phone = (isset($json_data['phone'])) ? $json_data['phone'] : '';
            $set_time = (isset($json_data['set_time'])) ? $json_data['set_time'] : '';
            $message_ = (isset($json_data['message'])) ? $json_data['message'] : '';
            $date_time = $set_time;
            if ($name == "" || $email == "" || $phone == "" || $set_time == "" || $message_ == "") {
                return array('success' => false, 'data' => '', 'message' => __("All fields are required", "carspot-rest-api"));
            } else {
                $message = __("Something went wrong.", 'carspot-rest-api');
                $success = false;
                if (isset($carspot_theme['test_drive_form_on']) && $carspot_theme['test_drive_form_on'] != '') {
                    $message = __("Email sent successfully.", 'carspot-rest-api');
                    //$to = $carspot_theme['sb_test_drive_email_from'];
                    $subject = __('Car test drive query', 'carspot-rest-api') . '-' . get_the_title($post_id);
                    $body = '<html><body><p>' . __('You have been contacted for test drive of your car', 'carspot-rest-api') . ' <a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a></p></body></html>';
                    $from = get_bloginfo('name');
                    if (isset($carspot_theme['sb_test_drive_email_from']) && $carspot_theme['sb_test_drive_email_from'] != "") {
                        $from = $carspot_theme['sb_test_drive_email_from'];
                    }

                    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                    if (isset($carspot_theme['sb_test_drive_email_message']) && $carspot_theme['sb_test_drive_email_message'] != "") {
                        $author_id = get_post_field('post_author', $post_id);
                        $user_info = get_userdata($author_id);
                        $to = $user_info->user_email;
                        $subject_keywords = array('%td_name%', '%td_email%', '%td_phone%', '%td_date_time%', '%td_msg%', '%td_ad_link%');
                        $subject_replaces = array($name, $email, $phone, $date_time, $message_, get_the_permalink($post_id));
                        $subject = str_replace($subject_keywords, $subject_replaces, $carspot_theme['sb_test_drive_email_subject']);
                        $msg_keywords = array('%td_name%', '%td_email%', '%td_phone%', '%td_date_time%', '%td_msg%', '%td_ad_link%');
                        $msg_replaces = array($name, $email, $phone, $date_time, $message_, get_the_permalink($post_id));
                        $body = str_replace($msg_keywords, $msg_replaces, $carspot_theme['sb_test_drive_email_message']);
                        $sent_email = wp_mail($to, $subject, $body, $headers);
                        if ($sent_email) {
                            $message = __("Email sent to author successfully.", 'carspot-rest-api');
                            $success = true;
                        }
                    }
                }
                return array('success' => $success, 'data' => '', 'message' => $message);
            }
        } else {
            return array('success' => false, 'data' => '', 'message' => __("Invalid Form Submission", "carspot-rest-api"));
        }
    }

}
/* Fav Ad */
add_action('rest_api_init', 'carspotAPI_ad_favourite_hook', 0);

function carspotAPI_ad_favourite_hook()
{
    register_rest_route(
        'carspot/v1', '/ad_post/favourite/', array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_ad_favourite',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_ad_favourite')) {

    function carspotAPI_ad_favourite($request)
    {
        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->data->ID;
        if (get_user_meta($current_user_id, '_sb_fav_id_' . $ad_id, true) == $ad_id) {
            return array('success' => false, 'data' => '', 'message' => __("You have added already.", "carspot-rest-api"));
        } else {
            update_user_meta($current_user_id, '_sb_fav_id_' . $ad_id, $ad_id);
            return array('success' => true, 'data' => '', 'message' => __("Added to your favourites.", "carspot-rest-api"));
        }
    }

}
/* Report ad */
add_action('rest_api_init', 'carspotAPI_ad_report_hook', 0);

function carspotAPI_ad_report_hook()
{
    register_rest_route(
        'carspot/v1', '/ad_post/report/', array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'carspotAPI_ad_report',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_ad_report')) {

    function carspotAPI_ad_report($request)
    {
        global $carspotAPI;
        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $option = (isset($json_data['option'])) ? $json_data['option'] : '';
        $comments = (isset($json_data['comments'])) ? $json_data['comments'] : '';
        $ad_owser = get_post_field('post_author', $ad_id);
        $message = '';
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->data->ID;
        if ($ad_owser == $current_user_id) {
            return array('success' => false, 'data' => '', 'message' => __("You can't report your own ad", "carspot-rest-api"));
        }
        if (get_post_meta($ad_id, '_sb_user_id_' . $current_user_id, true) == $current_user_id) {
            return array('success' => false, 'data' => '', 'message' => __("You have reported already.", "carspot-rest-api"));
        } else {
            update_post_meta($ad_id, '_sb_user_id_' . $current_user_id, $current_user_id);
            update_post_meta($ad_id, '_sb_report_option_' . $current_user_id, $option);
            update_post_meta($ad_id, '_sb_report_comments_' . $current_user_id, $comments);
            $count = get_post_meta($ad_id, '_sb_count_report', true);
            $count = (int)$count + 1;
            update_post_meta($ad_id, '_sb_count_report', $count);
            if ($count >= $carspotAPI['report_limit']) {
                $message = __("Reported successfully.", "carspot-rest-api");
                if ($carspotAPI['report_action'] == '1') {
                    $my_post = array('ID' => $ad_id, 'post_status' => 'pending',);
                    wp_update_post($my_post);
                    $message = __("The ad you have reported has been removed.", "carspot-rest-api");
                } else {
                    /* Send Email Function */
                    carspotAPI_sb_report_ad($ad_id, $option, $comments, $current_user_id);
                    $message = __("Successfully reported.", "carspot-rest-api");
                }
            }
            return array('success' => true, 'data' => '', 'message' => $message);
        }
    }

}
add_action('rest_api_init', 'carspotAPI_ads_hooks_ad_search_template_get', 0);

function carspotAPI_ads_hooks_ad_search_template_get()
{
    register_rest_route(
        'carspot/v1', '/ad_post/dynamic_widget/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_search_get1',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_ad_search_get1')) {

    function carspotAPI_ad_search_get1($request)
    {
        global $carspotAPI;
        $showcatData = false;
        $arrays = array();
        $showcatData = (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true) ? true : false;
        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
            return $response = array('success' => true, 'data' => $arrays, 'message' => '');
        }
        $json_data = $request->get_json_params();
        $term_id = (isset($json_data['cat_id'])) ? $json_data['cat_id'] : '';
        $result = carspot_dynamic_templateID($term_id);
        $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);
        $templateID = ($showcatData == true) ? $templateID : '';
        /* New Code Starts Here */
        $price = sb_custom_form_data($templateID, '_sb_default_cat_price_show');
        $priceType = sb_custom_form_data($templateID, '_sb_default_cat_price_type_show');
        $condition = sb_custom_form_data($templateID, '_sb_default_cat_condition_show');
        $warranty = sb_custom_form_data($templateID, '_sb_default_cat_warranty_show');
        $type = sb_custom_form_data($templateID, '_sb_default_cat_ad_type_show');
        $ad_years = sb_custom_form_data($templateID, '_sb_default_cat_ad_years_show');
        $ad_body_types = sb_custom_form_data($templateID, '_sb_default_cat_ad_body_types_show');
        $ad_transmissions = sb_custom_form_data($templateID, '_sb_default_cat_ad_transmissions_show');
        $ad_engine_capacities = sb_custom_form_data($templateID, '_sb_default_cat_ad_engine_capacities_show');
        $ad_engine_types = sb_custom_form_data($templateID, '_sb_default_cat_ad_engine_types_show');
        $ad_assembles = sb_custom_form_data($templateID, '_sb_default_cat_ad_assembles_show');
        $ad_colors = sb_custom_form_data($templateID, '_sb_default_cat_ad_colors_show');
        $ad_insurance = sb_custom_form_data($templateID, '_sb_default_cat_ad_insurance_show');
        /* New Code Ends Here */
        $showcatData = (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true) ? true : false;
        $isStatic = ($showcatData == true) ? 'dynamic' : 'static';
        /* Custom taxonomy feilds */
        $ad_id = '';
        $arrays2 = carspot_get_term_searchFormAPI($result, $ad_id, $isStatic);
        if (isset($templateID) && $templateID != "") {
            $formData = sb_dynamic_form_data($templateID);
            foreach ($formData as $r) {
                if (isset($r['types']) && trim($r['types']) != "") {
                    $in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
                    if ($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1) {
                        $mainTitle = $name = $r['titles'];
                        $fieldName = $r['slugs'];
                        $fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][$r['slugs']])) ? $_GET['custom'][$r['slugs']] : '';
                        /* Inputs */
                        if (isset($r['types']) && $r['types'] == 1) {
                            $arrays[] = array("main_title" => $mainTitle, "field_type" => 'textfield', "field_type_name" => $fieldName, "field_val" => "", "field_name" => "", "title" => $name, "values" => $fieldValue);
                        }
                        /* select option */
                        if (isset($r['types']) && $r['types'] == 2 || isset($r['types']) && $r['types'] == 3) {
                            $varArrs = @explode("|", $r['values']);
                            $termsArr = array();
                            if ($r['types'] == 2) {
                                $termsArr[] = array
                                (
                                    "id" => "",
                                    "name" => esc_html__("Select Option", "carspot-rest-api"),
                                    "has_sub" => false,
                                    "has_template" => false,
                                );
                            }
                            foreach ($varArrs as $v) {
                                $termsArr[] = array
                                (
                                    "id" => $v,
                                    "name" => $v,
                                    "has_sub" => false,
                                    "has_template" => false,
                                );
                            }
                            $ftype = ($r['types'] == 2) ? 'select' : 'radio';
                            $arrays[] = array("main_title" => $mainTitle, "field_type" => $ftype, "field_type_name" => $fieldName, "field_val" => "", "field_name" => "", "title" => $name, "values" => $termsArr);
                        }
                        /* DateField */
                        if (isset($r['types']) && $r['types'] == 4) {
                            $arrays[] = array("main_title" => $mainTitle, "field_type" => 'textfield_date', "field_type_name" => $fieldName, "field_val" => "", "field_name" => "", "title" => $name, "values" => $fieldValue);
                        }
                    }
                }
            }
        }

        if (isset($arrays2) && count($arrays2) > 0) {
            $arrays = array_merge($arrays2, $arrays);
        } else {
            //
        }

        if ($result != "") {
            /* return $arrays; */
            $ad_condition_array = carspotAPI_ad_search_return_fields($templateID, $condition, $showcatData, 'select', 'ad_condition', 'ad_condition', 0, __("Condition", "carspot-rest-api"), '', '', false);

            if (isset($ad_condition_array) && count($ad_condition_array) > 0) {
                $arrays[] = $ad_condition_array;
            }
            //ad_warranty
            $ad_warranty_array = carspotAPI_ad_search_return_fields($templateID, $warranty, $showcatData, 'select', 'ad_warranty', 'ad_warranty', 0, __("Warranty", "carspot-rest-api"), '', '', false);
            if (isset($ad_warranty_array) && count($ad_warranty_array) > 0) {
                $arrays[] = $ad_warranty_array;
            }
            /* Add Type */
            $ad_type_array = carspotAPI_ad_search_return_fields($templateID, $type, $showcatData, 'select', 'ad_type', 'ad_type', 0, __("Ad Type", "carspot-rest-api"), '', '', false);
            if (isset($ad_type_array) && count($ad_type_array) > 0) {
                $arrays[] = $ad_type_array;
            }

            /* ad_years */
            $ad_years_array = carspotAPI_ad_search_return_fields($templateID, $ad_years, $showcatData, 'select', 'ad_years', 'ad_years', 0, __("Ad Years", "carspot-rest-api"), '', '', false);
            if (isset($ad_years_array) && count($ad_years_array) > 0) {
                $arrays[] = $ad_years_array;
            }
            /* ad_body_types */
            $ad_body_types_array = carspotAPI_ad_search_return_fields($templateID, $ad_body_types, $showcatData, 'select', 'ad_body_types', 'ad_body_types', 0, __("Ad Body Types", "carspot-rest-api"), '', '', false);
            if (isset($ad_body_types_array) && count($ad_body_types_array) > 0) {
                $arrays[] = $ad_body_types_array;
            }
            //ad_transmissions
            $ad_transmissions_array = carspotAPI_ad_search_return_fields($templateID, $ad_transmissions, $showcatData, 'select', 'ad_transmissions', 'ad_transmissions', 0, __("Transmissions", "carspot-rest-api"), '', '', false);
            if (isset($ad_transmissions_array) && count($ad_transmissions_array) > 0) {
                $arrays[] = $ad_transmissions_array;
            }
            //ad_engine_capacities
            $ad_engine_capacities_array = carspotAPI_ad_search_return_fields($templateID, $ad_engine_capacities, $showcatData, 'select', 'ad_engine_capacities', 'ad_engine_capacities', 0, __("Engine Capacities", "carspot-rest-api"), '', '', false);
            if (isset($ad_engine_capacities_array) && count($ad_engine_capacities_array) > 0) {
                $arrays[] = $ad_engine_capacities_array;
            }
            //ad_engine_types
            $ad_engine_types_array = carspotAPI_ad_search_return_fields($templateID, $ad_engine_types, $showcatData, 'select', 'ad_engine_types', 'ad_engine_types', 0, __("Engine Type", "carspot-rest-api"), '', '', false);
            if (isset($ad_engine_types_array) && count($ad_engine_types_array) > 0) {
                $arrays[] = $ad_engine_types_array;
            }
            //ad_assembles
            $ad_assembles_array = carspotAPI_ad_search_return_fields($templateID, $ad_assembles, $showcatData, 'select', 'ad_assembles', 'ad_assembles', 0, __("Assembles", "carspot-rest-api"), '', '', false);
            if (isset($ad_assembles_array) && count($ad_assembles_array) > 0) {
                $arrays[] = $ad_assembles_array;
            }
            //ad_colors
            $ad_colors_array = carspotAPI_ad_search_return_fields($templateID, $ad_colors, $showcatData, 'select', 'ad_colors', 'ad_colors', 0, __("Colors", "carspot-rest-api"), '', '', false);
            if (isset($ad_colors_array) && count($ad_colors_array) > 0) {
                $arrays[] = $ad_colors_array;
            }
            //ad_insurance
            $ad_insurance_array = carspotAPI_ad_search_return_fields($templateID, $ad_insurance, $showcatData, 'select', 'ad_insurance', 'ad_insurance', 0, __("Insurance", "carspot-rest-api"), '', '', false);
            if (isset($ad_insurance_array) && count($ad_insurance_array) > 0) {
                $arrays[] = $ad_insurance_array;
            }
        }

        /* Add Price */
        //$showcatData
        if ($priceType == 1 && $templateID != "" && $showcatData == true) {
            $fieldTitle = array(__("Min Price", "carspot-rest-api"), __("Max Price", "carspot-rest-api"),);
            //$arrays[] = carspotAPI_getSearchFields('select', 'ad_currency', 'ad_currency', 0, __("Currency", "carspot-rest-api"),'', '', false);
            $arrays[] = carspotAPI_getSearchFields('range_textfield', 'ad_price', '', 0, $fieldTitle, __("Price", "carspot-rest-api"));
        } else if ($templateID != "" && $priceType == 0) {

        } else if ($templateID == "" || $showcatData == true) {
            $fieldTitle = array(__("Min Price", "carspot-rest-api"), __("Max Price", "carspot-rest-api"));
            $arrays[] = carspotAPI_getSearchFields('select', 'ad_currency', 'ad_currency', 0, __("Currency", "carspot-rest-api"), '', '', false);
            $arrays[] = carspotAPI_getSearchFields('range_textfield', 'ad_price', '', 0, $fieldTitle, __("Price", "carspot-rest-api"));
        }
        return $response = array('success' => true, 'data' => $arrays, 'message' => '');
    }

}

if (!function_exists('carspot_get_term_searchFormAPI')) {

    function carspot_get_term_searchFormAPI($term_id = '', $post_id = '', $formType = 'dynamic', $is_array = '')
    {
        global $carspot_theme;
        //$formType = 'dynamic';
        $data = ($formType == 'dynamic' && $term_id != "") ? sb_text_field_value($term_id) : sb_getTerms('custom');

        if ($is_array == 'arr') {
            return $data;
        }
        $dataHTML = '';
        foreach ($data as $d) {
            $name = $d['name'];
            $slug = $d['slug'];
            if ($formType == 'static' || $term_id == '') {
                $showme = 1;
                if (isset($carspot_theme["allow_tax_condition"]) && $slug == 'ad_condition') {
                    $showme = $carspot_theme["allow_tax_condition"];
                }
                if (isset($carspot_theme["allow_tax_warranty"]) && $slug == 'ad_warranty') {
                    $showme = $carspot_theme["allow_tax_warranty"];
                }
                if (isset($carspot_theme["allow_ad_years"]) && $slug == 'ad_years') {
                    $showme = $carspot_theme["allow_ad_years"];
                }
                if (isset($carspot_theme["allow_ad_body_types"]) && $slug == 'ad_body_types') {
                    $showme = $carspot_theme["allow_ad_body_types"];
                }
                if (isset($carspot_theme["allow_ad_transmissions"]) && $slug == 'ad_transmissions') {
                    $showme = $carspot_theme["allow_ad_transmissions"];
                }
                if (isset($carspot_theme["allow_ad_engine_capacities"]) && $slug == 'ad_engine_capacities') {
                    $showme = $carspot_theme["allow_ad_engine_capacities"];
                }
                if (isset($carspot_theme["allow_ad_engine_types"]) && $slug == 'ad_engine_types') {
                    $showme = $carspot_theme["allow_ad_engine_types"];
                }
                if (isset($carspot_theme["allow_ad_assembles"]) && $slug == 'ad_assembles') {
                    $showme = $carspot_theme["allow_ad_assembles"];
                }
                if (isset($carspot_theme["allow_ad_colors"]) && $slug == 'ad_colors') {
                    $showme = $carspot_theme["allow_ad_colors"];
                }
                if (isset($carspot_theme["allow_ad_insurance"]) && $slug == 'ad_insurance') {
                    $showme = $carspot_theme["allow_ad_insurance"];
                }
                if (isset($carspot_theme["allow_ad_features"]) && $slug == 'ad_features') {
                    $showme = $carspot_theme["allow_ad_features"];
                }
                $is_show = $showme;
                $is_this_req = 1;
            } else {
                $is_show = $d['is_show'];
                $is_this_req = $d['is_req'];
            }
            $is_req = $is_this_req;
            $is_search = $d['is_search'];
            $is_type = $d['is_type'];
            $required = (isset($is_req) && $is_req == 1) ? true : false;
            if ($is_show == 1 && $is_search == 1) {
                $inputVal = '';
                if ($is_type == 'textfield') {
                    if ('ad_avg_hwy' == $slug || $slug == 'ad_avg_city') {
                        continue;
                    }
                    $arrays[] = array("main_title" => ucfirst($name), "field_type" => 'textfield', "field_type_name" => $slug, "field_val" => $inputVal, "field_name" => "", "title" => $name, "values" => '');
                } else if ($slug == 'ad_features') {
                    $required = '';
                    $adfeatures = '';
                    $frs = array();
                    $ad_features = carspot_get_cats('ad_features', 0);
                    $count = 1;
                    $adfeatures = get_post_meta($post_id, '_carspot_' . $slug, true);
                    if ($adfeatures != "") {
                        $frs = explode('|', $adfeatures);
                    }
                    foreach ($ad_features as $feature) {
                        $selected = (in_array($feature->name, $frs)) ? true : false;
                        $features_values[] = array("name" => $feature->name, "is_checked" => $selected);
                        $count++;
                    }
                } else {
                    $values = carspot_get_cats($slug, 0);
                    $select_values = array();
                    if (!empty($values) && count((array)$values) > 0) {
                        $select_values[] = array("id" => "", "name" => esc_html__("Select an option", "carspot-rest-api"), "has_sub" => false, "has_template" => false);
                        foreach ($values as $val) {
                            if (isset($val->term_id) && $val->term_id != "") {
                                $id = $val->term_id;
                                $name2 = $val->name;
                                $select_values[] = array("id" => $id, "name" => $name2, "has_sub" => false, "has_template" => false);
                            }
                        }
                        /* Replaced By ScriptsBundle */
                        $arrays[] = array("main_title" => $name, "field_type" => 'select', "field_type_name" => "" . $slug, "field_val" => $inputVal, "field_name" => "", "title" => $name, "values" => $select_values);
                    }
                }
            }
        }
        return $arrays;
    }

}
if (!function_exists('carspotAPI_ad_search_return_fields')) {

    function carspotAPI_ad_search_return_fields($templateID = '', $is_show = '', $showcatData = '', $field_type = '', $field_type_name = '', $term_type = 'ad_cats', $only_parent = 0, $name = '', $mainTitle = '', $defaultValue = '', $is_id = true)
    {
        $return_data = array();
        if ($is_show == 1 && $templateID != "" && $showcatData == true) {
            $return_data = carspotAPI_getSearchFields($field_type, $field_type_name, $term_type, $only_parent, $name, $mainTitle, $defaultValue, $is_id);
        } else if ($templateID != "" && $is_show == 0) {

        } else if ($templateID == "" || $showcatData == true) {
            $return_data = carspotAPI_getSearchFields($field_type, $field_type_name, $term_type, $only_parent, $name, $mainTitle, $defaultValue, $is_id);
        }
        return $return_data;
    }

}

add_action('rest_api_init', 'carspotAPI_ads_hooks_ad_search_get', 0);

function carspotAPI_ads_hooks_ad_search_get()
{
    register_rest_route(
        'carspot/v1', '/ad_post/search/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'carspotAPI_ad_search_get',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_ad_search_get')) {

    function carspotAPI_ad_search_get()
    {
        global $carspotAPI;
        global $carspot_theme;
        $is_featured_data['-1'] = __("Select Option", "carspot-rest-api");
        $is_featured_data['0'] = __("Simple", "carspot-rest-api");
        $is_featured_data['1'] = __("Featured", "carspot-rest-api");
        $data[] = carspotAPI_getSearchFields('textfield', 'ad_title', '', 0, __("Search", "carspot-rest-api"), '', __("Type keyword", "carspot-rest-api"));
        $data[] = carspotAPI_getSearchFields('select', 'ad_cats1', 'ad_cats', 0, __("Categories", "carspot-rest-api"), '');

        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
            $data[] = carspotAPI_getSearchFields('select', 'is_featured', $is_featured_data, 0, __("Ad Type", "carspot-rest-api"), '');
            if (isset($carspot_theme['allow_tax_condition']) && $carspot_theme['allow_tax_condition'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_condition', 'ad_condition', 0, __("Condition", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_tax_warranty']) && $carspot_theme['allow_tax_warranty'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_warranty', 'ad_warranty', 0, __("Warranty", "carspot-rest-api"), '', '', false);
            }

            $data[] = carspotAPI_getSearchFields('select', 'ad_type', 'ad_type', 0, __("Ad Type", "carspot-rest-api"), '', '', false);
            if (isset($carspot_theme['allow_ad_years']) && $carspot_theme['allow_ad_years'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_years', 'ad_years', 0, __("Year", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_body_types']) && $carspot_theme['allow_ad_body_types'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_body_types', 'ad_body_types', 0, __("Body Type", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_transmissions']) && $carspot_theme['allow_ad_transmissions'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_transmissions', 'ad_transmissions', 0, __("Transmission", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_engine_capacities']) && $carspot_theme['allow_ad_engine_capacities'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_engine_capacities', 'ad_engine_capacities', 0, __("Engine Size", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_engine_types']) && $carspot_theme['allow_ad_engine_types'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_engine_types', 'ad_engine_types', 0, __("Engine Type", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_assembles']) && $carspot_theme['allow_ad_assembles'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_assembles', 'ad_assembles', 0, __("Assembly", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_colors']) && $carspot_theme['allow_ad_colors'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_colors', 'ad_colors', 0, __("Colour", "carspot-rest-api"), '', '', false);
            }
            if (isset($carspot_theme['allow_ad_insurance']) && $carspot_theme['allow_ad_insurance'] == 1) {
                $data[] = carspotAPI_getSearchFields('select', 'ad_insurance', 'ad_insurance', 0, __("Insurance", "carspot-rest-api"), '', '', false);
            }
            /* $data[] = carspotAPI_getSearchFields('glocation_textfield', 'ad_location', '', 0, __("Location", "carspot-rest-api"), ''); */
            $fieldTitle = array(__("Min Price", "carspot-rest-api"), __("Max Price", "carspot-rest-api"));
            $millageTitle = array(__("From", "carspot-rest-api"), __("To", "carspot-rest-api"));
            //$data[] = carspotAPI_getSearchFields('select', 'ad_currency', 'ad_currency', 0, __("Currency", "carspot-rest-api"),'', '', false);
            $data[] = carspotAPI_getSearchFields('range_textfield', 'ad_price', '', 0, $fieldTitle, __("Price", "carspot-rest-api"));
            $data[] = carspotAPI_getSearchFields('range_textfield', 'ad_millage', '', 0, $millageTitle, __("Mileage (Km)", "carspot-rest-api"));
            //$data[] = carspotAPI_getSearchFields('range_textfield', 'ad_avg_hwy', '', 0, $millageTitle, __("Average in Highway", "carspot-rest-api"));
            //$data[] = carspotAPI_getSearchFields('range_textfield', 'ad_avg_city', '', 0, $millageTitle, __("Average in City", "carspot-rest-api"));
        }
        $is_show_location = wp_count_terms('ad_country');
        if (isset($is_show_location) && $is_show_location > 0) {
            $data[] = carspotAPI_getSearchFields('select', 'ad_country', 'ad_country', 0, __("Location", "carspot-rest-api"), '');
        }
        $data[] = carspotAPI_getSearchFields('glocation_textfield', 'ad_location', '', 0, __("Address", "carspot-rest-api"), '');
        /* For radious search only */
        $data[] = carspotAPI_getSearchFields('seekbar', 'ad_seekbar', '', 0, __("Select Distance (KM)", "carspot-rest-api"), '');
        /* fields name will be sort */
        $topbar['sort_arr'][] = array("key" => "desc", "value" => __("DESC", "carspot-rest-api"));
        $topbar['sort_arr'][] = array("key" => "asc", "value" => __("ASC", "carspot-rest-api"));
        $topbar['sort_arr'][] = array("key" => "price_desc", "value" => __("Price: High to Low", "carspot-rest-api"));
        $topbar['sort_arr'][] = array("key" => "price_asc", "value" => __("Price: Low to High", "carspot-rest-api"));
        if (isset($carspotAPI['search_price_slider_min'])) {
            $min = $carspotAPI['search_price_slider_min'];
        } else {
            $min = __("500", "carspot-rest-api");
        }
        if (isset($carspotAPI['search_price_slider_max'])) {
            $max = $carspotAPI['search_price_slider_max'];
        } else {
            $max = __("100000", "carspot-rest-api");
        }
        $category_template_switch = 0;
        if ($carspotAPI['adpost_cat_template'] == true) {
            $category_template_switch = 1;
        }
        $extra['category_template_switch'] = $category_template_switch;
        $extra['field_type_name'] = 'ad_cats1';
        $extra['title'] = __("Search Here", "carspot-rest-api");
        $extra['search_btn'] = __("Search Now", "carspot-rest-api");
        $extra['dialog_send'] = __("Submit", "carspot-rest-api");
        $extra['dialg_cancel'] = __("Cancel", "carspot-rest-api");
        $extra['range_value'] = array((int)$min, (int)$max);
        $extra['from'] = __("From", "carspot-rest-api");
        $extra['to'] = __("To", "carspot-rest-api");
        $extra['select'] = __("select option", "carspot-rest-api");
        $extra['location'] = __("select location", "carspot-rest-api");

        return $response = array('success' => true, 'data' => $data, 'message' => '', 'topbar' => $topbar, 'extra' => $extra);
    }

}

add_action('rest_api_init', 'carspotAPI_ad_subcats_get', 0);

function carspotAPI_ad_subcats_get()
{
    register_rest_route(
        'carspot/v1', '/ad_post/subcats/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_subcats',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_ad_subcats')) {

    function carspotAPI_ad_subcats($request)
    {
        $json_data = $request->get_json_params();
        //$subcat		= (isset($json_data['subcat'])) ? $json_data['subcat'] : '';

        $subcat = (isset($json_data['subcat'])) ? $json_data['subcat'] : '';
        if ($subcat == "") {
            $subcat = (isset($json_data['ad_cats1'])) ? $json_data['ad_cats1'] : '';
        }

        $mainTermName = '';
        if ($subcat != "") {
            $mainTerm = get_term($subcat);
            $mainTermName = htmlspecialchars_decode($mainTerm->name, ENT_NOQUOTES);
        }

        $data = carspotAPI_getSubCats('select', 'ad_cats1', 'ad_cats', $subcat, $mainTermName, '', false);
        return $response = array('success' => true, 'data' => $data, 'message' => '');
    }

}

add_action('rest_api_init', 'carspotAPI_ad_sublocations_get', 0);

function carspotAPI_ad_sublocations_get()
{
    register_rest_route(
        'carspot/v1', '/ad_post/sublocations/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_sublocations',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_ad_sublocations')) {

    function carspotAPI_ad_sublocations($request)
    {
        $json_data = $request->get_json_params();
        $subcat = (isset($json_data['ad_country'])) ? $json_data['ad_country'] : '';
        $mainTermName = '';
        if ($subcat != "") {
            $mainTerm = get_term($subcat);
            $mainTermName = htmlspecialchars_decode($mainTerm->name, ENT_NOQUOTES);
        }
        $data = carspotAPI_getSubCats('select', 'ad_country', 'ad_country', $subcat, $mainTermName, '', false);
        return $response = array('success' => true, 'data' => $data, 'message' => '');
    }

}

add_action('rest_api_init', 'carspotAPI_ads_hooks_get_all', 0);

function carspotAPI_ads_hooks_get_all()
{
    register_rest_route(
        'carspot/v1', '/ad_post/search/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_posts_get_all',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));

    register_rest_route(
        'carspot/v1', '/ad_post/category/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_ad_posts_get_all',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_ad_posts_get_all')) {

    function carspotAPI_ad_posts_get_all($request)
    {
        global $carspotAPI;
        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? $json_data['ad_id'] : '';
        $meta = array('key' => 'post_id', 'value' => '0', 'compare' => '!=',);
        /* For Near By Ads */
        $allow_near_by = (isset($carspotAPI['allow_near_by']) && $carspotAPI['allow_near_by']) ? true : false;
        $lat_lng_meta_query = array();
        if ($allow_near_by) {
            $latitude = (isset($json_data['nearby_latitude'])) ? $json_data['nearby_latitude'] : '';
            $longitude = (isset($json_data['nearby_longitude'])) ? $json_data['nearby_longitude'] : '';
            $distance = (isset($json_data['nearby_distance'])) ? $json_data['nearby_distance'] : '20';
            $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
            if ($latitude != "" && $longitude != "") {
                $lats_longs = carspotAPI_determine_minMax_latLong($data_array, false);
                if (isset($lats_longs) && count($lats_longs) > 0) {
                    if (isset($lats_longs['lat']['original']) && $lats_longs['lat']['original'] > 0) {
                        $lat_lng_meta_query[] = array(
                            'key' => '_carspot_ad_map_lat',
                            'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                            'compare' => 'BETWEEN',
                        );
                    } else {
                        $lat_lng_meta_query[] = array(
                            'key' => '_carspot_ad_map_lat',
                            'value' => array($lats_longs['lat']['max'], $lats_longs['lat']['min']),
                            'compare' => 'BETWEEN',
                        );
                    }

                    if (isset($lats_longs['long']['original']) && $lats_longs['long']['original'] > 0) {
                        $lat_lng_meta_query[] = array(
                            'key' => '_carspot_ad_map_long',
                            'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                            'compare' => 'BETWEEN',
                        );
                    } else {
                        $lat_lng_meta_query[] = array(
                            'key' => '_carspot_ad_map_long',
                            'value' => array($lats_longs['long']['max'], $lats_longs['long']['min']),
                            'compare' => 'BETWEEN',
                        );
                    }
                }
            }
        }
        /* For Near By Ads Ends */
        /* Done Stars */
        $title = (isset($json_data['ad_title']) && $json_data['ad_title'] != "") ? $json_data['ad_title'] : "";
        $price = array();

        $priceVal = array();
        if (isset($json_data['ad_price']) && $json_data['ad_price'] != "") {
            $priceVal = (isset($json_data['ad_price']) && $json_data['ad_price'] != "") ? $json_data['ad_price'] : '';
        } else if (isset($json_data['custom_fields']['ad_price']) && $json_data['custom_fields']['ad_price'] != "") {
            $priceVal = (isset($json_data['custom_fields']['ad_price']) && $json_data['custom_fields']['ad_price'] != "") ? $json_data['custom_fields']['ad_price'] : '';
        }

        $priceValue = !empty($priceVal) ? @explode("-", $priceVal) : array();
        $minPrice = (isset($priceValue[0]) && $priceValue[0] != "") ? $priceValue[0] : "";
        $maxPrice = (isset($priceValue[1]) && $priceValue[1] != "") ? $priceValue[1] : "";
        if ($minPrice != "") {
            $price = array(
                'key' => '_carspot_ad_price',
                'value' => array((int)$minPrice, (int)$maxPrice),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            );
        }

        /* ================= */
        /*      Location     */
        /* ================= */
        $location = array();
        if (isset($json_data['ad_location']) && $json_data['ad_location'] != "") {
            $location = array(
                'key' => '_carspot_ad_location',
                'value' => @trim($json_data['ad_location']),
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['ad_location']) && $json_data['custom_fields']['ad_location'] != "") {
            $location = array(
                'key' => '_carspot_ad_location',
                'value' => @trim($json_data['custom_fields']['ad_location']),
                'compare' => '=',
            );
        }

        /* ================= */
        /*      Currency     */
        /* ================= */
        $ad_currency = array();
        if (isset($json_data['ad_currency']) && $json_data['ad_currency'] != "") {
            $ad_currency = array(
                'key' => '_carspot_ad_currency',
                'value' => @trim($json_data['ad_currency']),
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['ad_currency']) && $json_data['custom_fields']['ad_currency'] != "") {
            $ad_currency = array(
                'key' => '_carspot_ad_currency',
                'value' => @trim($json_data['custom_fields']['ad_currency']),
                'compare' => '=',
            );
        }


        /* ================= */
        /*      Category     */
        /* ================= */
        $category = array();
        if (isset($json_data['ad_cats1']) && $json_data['ad_cats1'] != "") {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['ad_cats1'],
                    'include_children' => 1,
                ),
            );
        } else if (isset($json_data['custom_fields']['ad_cats1']) && $json_data['custom_fields']['ad_cats1'] != "") {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['custom_fields']['ad_cats1'],
                    'include_children' => 1,
                ),
            );
        }

        $category = (isset($category) && count($category) > 0) ? $category : '';


        /* ================= */
        /*      Country     */
        /* ================= */
        $ad_country = array();
        if (isset($json_data['ad_country']) && $json_data['ad_country'] != "") {
            $ad_country = array(
                array(
                    'taxonomy' => 'ad_country',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['ad_country'],
                ),
            );
        } else if (isset($json_data['custom_fields']['ad_country']) && $json_data['custom_fields']['ad_country'] != "") {
            $ad_country = array(
                array(
                    'taxonomy' => 'ad_country',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['custom_fields']['ad_country'],
                ),
            );
        }

        $ad_country = (isset($ad_country) && count($ad_country) > 0) ? $ad_country : '';

        /* ================= */
        /*      Color     */
        /* ================= */
        $ad_colors_term = array();
        if (isset($json_data['ad_colors']) && $json_data['ad_colors'] != "") {
            $ad_colors_term = array(
                array(
                    'taxonomy' => 'ad_colors',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['ad_colors'],
                ),
            );
        } else if (isset($json_data['custom_fields']['ad_colors']) && $json_data['custom_fields']['ad_colors'] != "") {
            $ad_colors_term = array(
                array(
                    'taxonomy' => 'ad_colors',
                    'field' => 'term_id',
                    'terms' => (int)$json_data['custom_fields']['ad_colors'],
                ),
            );
        }

        $ad_colors_terms = (isset($ad_colors_term) && count($ad_colors_term) > 0) ? $ad_colors_term : '';


        // ['custom_fields']
        //ad_price, ad_location, ad_currency, ad_country, is_featured, ad_type, ad_condition, ad_warranty, transmission, year_from, year_to, engine_type, engine_capacity, assembly, color_family, insurance, mileage_from, mileage_to


        $custom_search = array();
        if (isset($json_data['custom_fields'])) {
            foreach ((array)$json_data['custom_fields'] as $key => $val) {

                if ($key == 'ad_price' || $key == 'ad_location' || $key == 'ad_currency' || $key == 'ad_country' || $key == 'is_featured'
                    || $key == 'ad_type'
                    || $key == 'ad_condition'
                    || $key == 'ad_warranty'
                    || $key == 'transmission'
                    || $key == 'year_from'
                    || $key == 'year_to'
                    || $key == 'engine_capacity'
                    || $key == 'assembly'
                    || $key == 'color_family'
                    || $key == 'insurance'
                    || $key == 'mileage_from'
                    || $key == 'mileage_to'
                    || $key == 'ad_colors'
                    || $key == 'ad_cats1'
                    || $key == 'max_price'
                    || $key == 'min_price'
                    || $key == 'body_type'
                    || $key == 'sort'
                ) {
                    continue;
                }

                if (is_array($val)) {
                    $arr = array();
                    $metaKey = '_carspot_tpl_field_' . $key;
                    foreach ($val as $v) {
                        if ($v != "") {

                            $custom_search[] = array(
                                'key' => $metaKey,
                                'value' => $v,
                                'compare' => 'LIKE',
                            );
                        }
                    }
                } else {
                    if (trim($val) == "0") {
                        continue;
                    }
                    if ($val != "") {
                        $metaKey = '_carspot_tpl_field_' . $key;
                        $val = stripslashes_deep($val);
                        $custom_search[] = array(
                            'key' => $metaKey,
                            'value' => $val,
                            'compare' => 'LIKE',
                        );
                    }
                }
            }
        }

        $feature_or_simple = array();
        if (isset($json_data['is_featured']) && $json_data['is_featured'] != "" && $json_data['is_featured'] == 1) {
            $feature_or_simple = array(
                'key' => '_carspot_is_feature',
                'value' => (int)$json_data['is_featured'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['is_featured']) && $json_data['custom_fields']['is_featured'] != "" && $json_data['custom_fields']['is_featured'] == 1) {
            $feature_or_simple = array(
                'key' => '_carspot_is_feature',
                'value' => (int)$json_data['custom_fields']['is_featured'],
                'compare' => '=',
            );
        } else {
            $feature_or_simple = array();
        }


        /* Enable only if needs noe featured ads in search */
        /* $feature_or_simple =     array(
          'relation' => 'OR',
          array(
          'key' => '_carspot_is_feature',
          'value' => '', //<--- not required but necessary in this case
          'compare' => 'NOT EXISTS',
          ),
          array(
          'key' => '_carspot_is_feature',
          'value' => '1',
          'compare' => '!=',
          ),
          ); */


        $ad_type = array();
        if (isset($json_data['ad_type']) && $json_data['ad_type'] != "") {
            $ad_type = array(
                'key' => '_carspot_ad_type',
                'value' => $json_data['ad_type'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['ad_type']) && $json_data['custom_fields']['ad_type'] != "") {
            $ad_type = array(
                'key' => '_carspot_ad_type',
                'value' => $json_data['custom_fields']['ad_type'],
                'compare' => '=',
            );
        }


        $condition = array();
        if (isset($json_data['ad_condition']) && $json_data['ad_condition'] != "") {
            $condition = array(
                'key' => '_carspot_ad_condition',
                'value' => @trim($json_data['ad_condition']),
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['ad_condition']) && $json_data['custom_fields']['ad_condition'] != "") {
            $condition = array(
                'key' => '_carspot_ad_condition',
                'value' => @trim($json_data['custom_fields']['ad_condition']),
                'compare' => '=',
            );
        }

        $warranty = array();
        if (isset($json_data['ad_warranty']) && $json_data['ad_warranty'] != "") {
            $warranty = array(
                'key' => '_carspot_ad_warranty',
                'value' => @trim($json_data['ad_warranty']),
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['ad_warranty']) && $json_data['custom_fields']['ad_warranty'] != "") {
            $warranty = array(
                'key' => '_carspot_ad_warranty',
                'value' => @trim($json_data['custom_fields']['ad_warranty']),
                'compare' => '=',
            );
        }


        //Transmission
        $transmission = '';
        if (isset($json_data['transmission']) && $json_data['transmission'] != "") {
            $transmission = array(
                'key' => '_carspot_ad_transmissions',
                'value' => $json_data['transmission'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['transmission']) && $json_data['custom_fields']['transmission'] != "") {
            $transmission = array(
                'key' => '_carspot_ad_transmissions',
                'value' => $json_data['custom_fields']['transmission'],
                'compare' => '=',
            );
        }


        /* Carspot search taxonomies start */
        $year = '';
        $year_from = '';
        $year_to = '';
        if (isset($json_data['year_from']) && $json_data['year_from'] != "") {
            $year_from = $_GET['year_from'];
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => $json_data['year_from'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['year_from']) && $json_data['custom_fields']['year_from'] != "") {
            $year_from = $_GET['custom_fields']['year_from'];
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => $json_data['custom_fields']['year_from'],
                'compare' => '=',
            );
        }

        if (isset($json_data['year_to']) && $json_data['year_to'] != "") {
            //$year_to = $json_data['year_to'];
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => $json_data['year_to'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['year_to']) && $json_data['custom_fields']['year_to'] != "") {
            //$year_to = $json_data['custom_fields']['year_to'];
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => $json_data['custom_fields']['year_to'],
                'compare' => '=',
            );
        }


        if (isset($json_data['year_from']) && $json_data['year_from'] != '' && isset($json_data['year_to']) && $json_data['year_to'] != '') {
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => array($json_data['year_from'], $json_data['year_to']),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            );
        } else if (isset($json_data['custom_fields']['year_from']) && $json_data['custom_fields']['year_from'] != '' && isset($json_data['custom_fields']['year_to']) && $json_data['custom_fields']['year_to'] != '') {
            $year = array(
                'key' => '_carspot_ad_years',
                'value' => array($json_data['custom_fields']['year_from'], $json_data['custom_fields']['year_to']),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            );
        }

        /* Price */

        if (isset($json_data['min_price']) && $json_data['min_price'] != "") {
            $price = '';
            $price = array(
                'key' => '_carspot_ad_price',
                'value' => array($json_data['min_price'], $json_data['max_price']),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            );
        } else if (isset($json_data['custom_fields']['min_price']) && $json_data['custom_fields']['min_price'] != "") {
            $price = '';
            $price = array(
                'key' => '_carspot_ad_price',
                'value' => array($json_data['custom_fields']['min_price'], $json_data['custom_fields']['max_price']),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            );
        }


        /* Body Type */
        $body_type = '';
        if (isset($json_data['body_type']) && $json_data['body_type'] != "") {
            $body_type = array(
                'key' => '_carspot_ad_body_types',
                'value' => $json_data['body_type'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['body_type']) && $json_data['custom_fields']['body_type'] != "") {
            $body_type = array(
                'key' => '_carspot_ad_body_types',
                'value' => $json_data['custom_fields']['body_type'],
                'compare' => '=',
            );
        }


        /* Transmission 
        $transmission = '';
        if (isset($json_data['transmission']) && $json_data['transmission'] != "") {
            $transmission = array(
                'key' => '_carspot_ad_transmissions',
                'value' => $json_data['transmission'],
                'compare' => '=',
            );
        }*/
        $ad_transmissions = $transmission;
        //Engine Type
        $engine_type = '';
        if (isset($json_data['engine_type']) && $json_data['engine_type'] != "") {
            $engine_type = array(
                'key' => '_carspot_ad_engine_types',
                'value' => $json_data['engine_type'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['engine_type']) && $json_data['custom_fields']['engine_type'] != "") {
            $engine_type = array(
                'key' => '_carspot_ad_engine_types',
                'value' => $json_data['custom_fields']['engine_type'],
                'compare' => '=',
            );
        }


        //Engine Capacity
        $engine_capacity = '';
        if (isset($json_data['engine_capacity']) && $json_data['engine_capacity'] != "") {
            $engine_capacity = array(
                'key' => '_carspot_ad_engine_capacities',
                'value' => $json_data['engine_capacity'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['engine_capacity']) && $json_data['custom_fields']['engine_capacity'] != "") {
            $engine_capacity = array(
                'key' => '_carspot_ad_engine_capacities',
                'value' => $json_data['custom_fields']['engine_capacity'],
                'compare' => '=',
            );
        }

        //Assembly
        $assembly = '';
        if (isset($json_data['assembly']) && $json_data['assembly'] != "") {
            $assembly = array(
                'key' => '_carspot_ad_assembles',
                'value' => $json_data['assembly'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['assembly']) && $json_data['custom_fields']['assembly'] != "") {
            $assembly = array(
                'key' => '_carspot_ad_assembles',
                'value' => $json_data['custom_fields']['assembly'],
                'compare' => '=',
            );
        }


        //Color Family
        $color_family = '';
        if (isset($json_data['color_family']) && $json_data['color_family'] != "") {
            $color_family = array(
                'key' => '_carspot_ad_colors',
                'value' => $json_data['color_family'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['color_family']) && $json_data['custom_fields']['color_family'] != "") {
            $color_family = array(
                'key' => '_carspot_ad_colors',
                'value' => $json_data['custom_fields']['color_family'],
                'compare' => '=',
            );
        }
        //Insurance
        $ad_insurance = '';
        if (isset($json_data['insurance']) && $json_data['insurance'] != "") {
            $ad_insurance = array(
                'key' => '_carspot_ad_insurance',
                'value' => $json_data['insurance'],
                'compare' => '=',
            );
        } else if (isset($json_data['custom_fields']['insurance']) && $json_data['custom_fields']['insurance'] != "") {
            $ad_insurance = array(
                'key' => '_carspot_ad_insurance',
                'value' => $json_data['custom_fields']['insurance'],
                'compare' => '=',
            );
        }
        //Mileage
        $mileage = '';
        $milage_from = '';
        $mileage_to = '';
        if (isset($json_data['mileage_from']) && $json_data['mileage_from'] != "") {
            $milage_from = $json_data['mileage_from'];
        } else if (isset($json_data['custom_fields']['mileage_from']) && $json_data['custom_fields']['mileage_from'] != "") {
            $milage_from = $json_data['custom_fields']['mileage_from'];
        }

        if (isset($json_data['mileage_to']) && $json_data['mileage_to'] != "") {
            $mileage_to = $json_data['mileage_to'];
        } else if (isset($json_data['custom_fields']['mileage_to']) && $json_data['custom_fields']['mileage_to'] != "") {
            $mileage_to = $json_data['custom_fields']['mileage_to'];
        }


        if ($milage_from != '' && $mileage_to != '') {
            $mileage = array(
                'key' => '_carspot_ad_mileage',
                'value' => array($milage_from, $mileage_to),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            );
        }

        /* Carspot search taxonomies End */
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (isset($json_data['page_number'])) {
            $paged = $json_data['page_number'];
        } else {
            $paged = 1;
        }

        $is_active = array('key' => '_carspot_ad_status_', 'value' => 'active', 'compare' => '=',);
        $order = 'desc';
        $orderBy = 'date';

        if (isset($json_data['sort']) && $json_data['sort'] != "") {
            $order_val = $json_data['sort'];
            if ($order_val == 'asc' || $order_val == 'price_asc') {
                $order = 'asc';
            }
            if ($order_val == 'price_desc' || $order_val == 'price_asc') {
                $orderBy = 'meta_value_num';
            }
        } else if (isset($json_data['custom_fields']['sort']) && $json_data['custom_fields']['sort'] != "") {
            $order_val = $json_data['custom_fields']['sort'];
            if ($order_val == 'asc' || $order_val == 'price_asc') {
                $order = 'asc';
            }
            if ($order_val == 'price_desc' || $order_val == 'price_asc') {
                $orderBy = 'meta_value_num';
            }
        }

        $author_not_in = carspotAPI_get_authors_notIn_list();
        $args = array(
            's' => $title,
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'tax_query' => array($category, $ad_country, $ad_transmissions, $ad_colors_terms),
            //'meta_key' => '_carspot_ad_price',
            'meta_query' => array(
                'relation' => 'AND',
                $is_active,
                $condition,
                $ad_type,
                $warranty,
                $feature_or_simple,
                $price,
                $year,
                $body_type,
                $transmission,
                $engine_type,
                $engine_capacity,
                $assembly,
                $color_family,
                $ad_insurance,
                $mileage,
                $custom_search
            ),
            'order' => $order,
            'orderby' => $orderBy,
            'paged' => $paged,
            'author__not_in' => $author_not_in
        );

        $args = cs_wpml_show_all_posts_callback_rest_api($args);
        $results = new WP_Query($args);
        $count = 0;
        $ad_detail = array();
        foreach ($results->posts as $r) {
            $ad_detail[$count]['ad_id'] = $r->ID;
            $ad_detail[$count]['ad_title'] = $r->post_title;
            $ad_detail[$count]['ad_author_id'] = get_post_field('post_author', $r->ID);
            $ad_detail[$count]['ad_date'] = get_the_date("", $r->ID);
            $ad_detail[$count]['ad_price'] = carspotAPI_get_price('', $r->ID);
            $ad_detail[$count]['images'] = carspotAPI_get_ad_image($r->ID, 1, 'thumb');
            $ad_detail[$count]['ad_video'] = carspotAPI_get_adVideo($r->ID);
            $ad_detail[$count]['location'] = carspotAPI_get_adAddress($r->ID);
            $ad_detail[$count]['ad_cats_name'] = carspotAPI_get_ad_terms_names($r->ID, 'ad_cats', '', '', ', ');
            $ad_detail[$count]['ad_cats'] = carspotAPI_get_ad_terms($r->ID, 'ad_cats', '', __("Categories", "carspot-rest-api"));
            $ad_detail[$count]['ad_status'] = carspotAPI_adStatus($r->ID);
            $ad_detail[$count]['ad_views'] = get_post_meta($r->ID, "sb_post_views_count", true);
            $ad_detail[$count]['ad_saved'] = array("is_saved" => 0, "text" => __("Save Ad", "carspot-rest-api"));
            $ad_detail[$count]['ad_timer'] = carspotAPI_get_adTimer($r->ID);
            $count++;
        }
        wp_reset_postdata();
        $fads['text'] = '';
        $fads['ads'] = array();
        $extra['is_show_featured'] = (isset($carspotAPI['feature_on_search']) && $carspotAPI['feature_on_search'] == 1) ? true : false;
        if (isset($carspotAPI['feature_on_search']) && $carspotAPI['feature_on_search'] == 1) {
            $featuredAdsCount = ($carspotAPI['search_related_posts_count'] != "") ? $carspotAPI['search_related_posts_count'] : 5;
            $featuredAdsTitle = ($carspotAPI['sb_search_ads_title'] != "") ? $carspotAPI['sb_search_ads_title'] : __("Featured Ads", "carspot-rest-api");
            $featured_termID = (isset($json_data['ad_cats1']) && $json_data['ad_cats1'] != "") ? $json_data['ad_cats1'] : '';
            $featuredAds = carspotApi_featuredAds_slider('', 'active', '1', $featuredAdsCount, $featured_termID, 'publish');
            if (isset($featuredAds) && count($featuredAds) > 0) {
                $fads['text'] = $featuredAdsTitle;
                $fads['ads'] = $featuredAds;
                $extra['is_show_featured'] = true;
            } else {
                $extra['is_show_featured'] = false;
            }
        }
        $topbar['count_ads'] = __("No of Ads Found", "carspot-rest-api") . ': ' . $results->found_posts;
        $nextPaged = $paged + 1;
        $has_next_page = ($nextPaged <= (int)$results->max_num_pages) ? true : false;
        $pagination = array("max_num_pages" => (int)$results->max_num_pages, "current_page" => (int)$paged, "next_page" => (int)$nextPaged, "increment" => (int)get_option('posts_per_page'), "current_no_of_ads" => $results->found_posts, "has_next_page" => $has_next_page);

        $data = array("featured_ads" => $fads, "ads" => $ad_detail, "sidebar" => "");
        /* fields name will be sort */
        $sort_arr_desc = array("key" => "desc", "value" => __("DESC", "carspot-rest-api"));
        $sort_arr_asc = array("key" => "asc", "value" => __("ASC", "carspot-rest-api"));
        $sort_arr_price_desc = array("key" => "price_desc", "value" => __("Price: High to Low", "carspot-rest-api"));
        $sort_arr_price_asc = array("key" => "price_asc", "value" => __("Price: Low to High", "carspot-rest-api"));
        if ($order == 'desc') {
            $topbar['sort_arr_key'] = $sort_arr_desc;
            $topbar['sort_arr'][] = $sort_arr_desc;
            $topbar['sort_arr'][] = $sort_arr_asc;
            $topbar['sort_arr'][] = $sort_arr_price_desc;
            $topbar['sort_arr'][] = $sort_arr_price_asc;
        }
        if ($order == 'asc') {
            $topbar['sort_arr_key'] = $sort_arr_asc;
            $topbar['sort_arr'][] = $sort_arr_asc;
            $topbar['sort_arr'][] = $sort_arr_desc;
            $topbar['sort_arr'][] = $sort_arr_price_desc;
            $topbar['sort_arr'][] = $sort_arr_price_asc;
        }
        if ($order == 'price_desc') {
            $topbar['sort_arr_key'] = $sort_arr_price_desc;
            $topbar['sort_arr'][] = $sort_arr_price_desc;
            $topbar['sort_arr'][] = $sort_arr_asc;
            $topbar['sort_arr'][] = $sort_arr_desc;
            $topbar['sort_arr'][] = $sort_arr_price_asc;
        }
        if ($order == 'price_asc') {
            $topbar['sort_arr_key'] = $sort_arr_price_asc;
            $topbar['sort_arr'][] = $sort_arr_price_asc;
            $topbar['sort_arr'][] = $sort_arr_asc;
            $topbar['sort_arr'][] = $sort_arr_desc;
            $topbar['sort_arr'][] = $sort_arr_price_desc;
        }

        $searchTitle = __("Category", "carspot-rest-api");
        if (isset($json_data['ad_cats1']) && $json_data['ad_cats1'] != "") {
            $term = get_term($json_data['ad_cats1'], 'ad_cats');
            $searchTitle = htmlspecialchars_decode(@$term->name, ENT_NOQUOTES);
        }

        $extra['field_type_name'] = 'ad_cats1';
        $extra['title'] = $searchTitle;
        $extra['no_ads_found'] = __("No Ads Found", "carspot-rest-api");
        return $response = array('success' => true, 'data' => $data, 'message' => '', 'extra' => $extra, "topbar" => $topbar, "pagination" => $pagination);
    }

}

if (!function_exists('carspotAPI_ad_dynamic_fields_data')) {

    function carspotAPI_ad_dynamic_fields_data($term_id = '')
    {
        $result = carspot_dynamic_templateID($term_id);
        $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);
        $arrays = array();
        if (isset($templateID) && $templateID != "") {
            $formData = sb_dynamic_form_data($templateID);
            foreach ($formData as $r) {
                if (isset($r['types']) && trim($r['types']) != "") {
                    $in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
                    if ($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1) {
                        $mainTitle = $name = $r['titles'];
                        /* $fieldName = "custom[".$r['slugs']."]"; */
                        $fieldName = $r['slugs'];
                        $fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][$r['slugs']])) ? $_GET['custom'][$r['slugs']] : '';
                        /* Inputs */
                        if (isset($r['types']) && $r['types'] == 1) {
                            $arrays[] = array("key" => $name, "value" => $fieldValue);
                        }
                        /* select option */
                        if (isset($r['types']) && $r['types'] == 2 || isset($r['types']) && $r['types'] == 3) {
                            $varArrs = @explode("|", $r['values']);
                            $termsArr = array();
                            foreach ($varArrs as $v) {
                                $termsArr[] = array("id" => $v, "name" => $v,);
                            }
                            $arrays[] = array("key" => $name, "value" => $termsArr);
                        }
                    }
                }
            }
        }

        return $arrays;
    }

}

/* Single Ad Featured Notification */
if (!function_exists('carspotAPI_adFeatured_notify')) {

    function carspotAPI_adFeatured_notify($ad_id = '', $check_statuc = false)
    {
        $user = wp_get_current_user();
        $uid = @$user->data->ID;
        $pid = $uid;

        $data = array();
        $isFeature = get_post_meta($ad_id, '_carspot_is_feature', true);
        $isFeature = ($isFeature) ? $isFeature : 0;
        if (get_post_meta($ad_id, '_carspot_ad_status_', true) == 'active' && $check_statuc == false) {

        }
        /* //&& get_post_meta( $ad_id, '_carspot_ad_status_', true ) == 'active' */
        if ($uid != "" && $isFeature == 0) {
            if (get_post_field('post_author', $ad_id) == $uid) {
                $featured_ads_count = get_user_meta($uid, '_carspot_featured_ads', true);
                if ($featured_ads_count != 0) {
                    $expire_ads_time = get_user_meta($uid, '_carspot_expire_ads', true);
                    if ($expire_ads_time != '-1') {
                        if ($expire_ads_time < date('Y-m-d')) {
                            $data['text'] = __('Your package has been expired', 'carspot-rest-api');
                            $data['toaster_text'] = __('Your package has been expired, please subscribe the package to make it feature AD. ', 'carspot-rest-api');
                            $data['link'] = $ad_id;
                            $data['make_feature'] = false;
                            $data['btn'] = __('Buy', 'carspot-rest-api');
                        } else {
                            $data['text'] = __('Click Here To make this ad featured.', 'carspot-rest-api');
                            $data['toaster_text'] = "";
                            $data['link'] = $ad_id;
                            $data['make_feature'] = true;
                            $data['btn'] = __('Make Featured', 'carspot-rest-api');
                        }
                    } else {
                        $data['text'] = __('Click Here To make this ad featured.', 'carspot-rest-api');
                        $data['link'] = $ad_id;
                        $data['make_feature'] = true;
                        $data['toaster_text'] = "";
                        $data['btn'] = __('Make Featured', 'carspot-rest-api');
                    }
                } else {
                    $data['text'] = __('To make ad featured buy package.', 'carspot-rest-api');
                    $data['toaster_text'] = __('Please purchase package to make it this  ad featured. ', 'carspot-rest-api');
                    $data['link'] = $ad_id;
                    $data['make_feature'] = false;
                    $data['btn'] = __('Buy', 'carspot-rest-api');
                }
            }
        }
        return $data;
    }

}


/* Single Ad Featured Notification */
if (!function_exists('carspotAPI_adBump_notify')) {

    function carspotAPI_adBump_notify($ad_id = '', $check_statuc = false)
    {
        $user = wp_get_current_user();
        $uid = @$user->data->ID;
        $pid = $uid;
        $data = array();
        $isBump = get_post_meta($ad_id, '_carspot_bump_ads', true);
        $isBump = ($isBump) ? $isBump : 0;
        if (get_post_meta($ad_id, '_carspot_ad_status_', true) == 'active' && $check_statuc == false) {

        }
        /* //&& get_post_meta( $ad_id, '_carspot_ad_status_', true ) == 'active' */
        if ($uid != "" && $isBump == 0) {
            if (get_post_field('post_author', $ad_id) == $uid) {
                $featured_ads_count = get_user_meta($uid, '_carspot_bump_ads', true);
                if ($featured_ads_count != 0) {
                    $expire_ads_time = get_user_meta($uid, '_carspot_expire_ads', true);
                    if ($expire_ads_time != '-1') {
                        if ($expire_ads_time < date('Y-m-d')) {
                            $data['text'] = __('Your package has been expired', 'carspot-rest-api');
                            $data['toaster_text'] = __('Your package has been expired, please subscribe package to bump up this ad. ', 'carspot-rest-api');
                            $data['link'] = $ad_id;
                            $data['make_bum_up'] = false;
                            $data['btn'] = __('Buy', 'carspot-rest-api');
                        } else {
                            $data['text'] = __('Click Here To bump up.', 'carspot-rest-api');
                            $data['toaster_text'] = "";
                            $data['link'] = $ad_id;
                            $data['make_bum_up'] = true;
                            $data['btn'] = __('Bump up', 'carspot-rest-api');
                        }
                    } else {
                        $data['text'] = __('Click Here To bump up.', 'carspot-rest-api');
                        $data['link'] = $ad_id;
                        $data['make_bum_up'] = true;
                        $data['toaster_text'] = "";
                        $data['btn'] = __('Bump up', 'carspot-rest-api');
                    }
                } else {
                    $data['text'] = __('To bump up ad please purchase package.', 'carspot-rest-api');
                    $data['toaster_text'] = __('Please purchase package to bump up this ad. ', 'carspot-rest-api');
                    $data['link'] = $ad_id;
                    $data['make_bum_up'] = false;
                    $data['btn'] = __('Buy', 'carspot-rest-api');
                }
            }
        }
        return $data;
    }

}

add_action('rest_api_init', 'carspotAPI_makeAd_featured_hook', 0);

function carspotAPI_makeAd_featured_hook()
{
    register_rest_route(
        'carspot/v1', '/ad_post/featured/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'carspotAPI_makeAd_featured',
        'permission_callback' => function () {
            return carspotAPI_basic_auth();
        },
    ));
}

if (!function_exists('carspotAPI_makeAd_featured')) {

    function carspotAPI_makeAd_featured($request)
    {

        $json_data = $request->get_json_params();
        $ad_id = (isset($json_data['ad_id'])) ? trim($json_data['ad_id']) : '';
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $success = false;
        if (get_post_field('post_author', $ad_id) == $user_id) {
            if (get_post_meta($ad_id, '_carspot_is_feature', true) == 0) {
                if (get_user_meta($user_id, '_carspot_featured_ads', true) > 0 || get_user_meta($user_id, '_carspot_featured_ads', true) == '-1') {
                    if (get_user_meta($user_id, '_carspot_expire_ads', true) != '-1') {
                        if (get_user_meta($user_id, '_carspot_expire_ads', true) < date('Y-m-d')) {
                            $message = __("Your package has been expired.", 'carspot-rest-api');
                        }
                    }
                    $feature_ads = get_user_meta($user_id, '_carspot_featured_ads', true);
                    $feature_ads2 = $feature_ads;
                    $feature_ads = $feature_ads - 1;
                    if ($feature_ads2 != "-1") {
                        update_user_meta($user_id, '_carspot_featured_ads', $feature_ads);
                    }
                    update_post_meta($ad_id, '_carspot_is_feature', '1');
                    update_post_meta($ad_id, '_carspot_is_feature_date', date('Y-m-d'));
                    $message = __("This ad has been featured successfully.", 'carspot-rest-api');
                    $success = true;
                } else {
                    $message = __("Get package in order to make it feature.", 'carspot-rest-api');
                }
            } else {
                $message = __("Ad already featured.", 'carspot-rest-api');
            }
        } else {
            $message = __("You must be Ad owner to make it feature.", 'carspot-rest-api');
        }
        $response = array('success' => $success, 'data' => '', 'message' => $message);

        return $response;
    }

}

/*
 * code for terms search
 * write for user on
 * 15-2-2021
 */
add_action('rest_api_init', 'carspotAPI_get_terms_search_data', 0);

function carspotAPI_get_terms_search_data()
{
    register_rest_route(
        'carspot/v1', '/get_all_search_terms/', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'carspotAPI_search_terms_get',
            'permission_callback' => '__return_true',
        )
    );
}

if (!function_exists('carspotAPI_search_terms_get')) {

    function carspotAPI_search_terms_get($request)
    {
        $all_terms = array();
        $taxonomy = 'ad_cats';
        $parent_args = [
            'taxonomy' => $taxonomy,
            'parent' => 0,
            'hide_empty' => false
        ];
        $parent_terms = get_terms($parent_args);
        foreach ($parent_terms as $parent_term) {
            $term_imgUrl = carspotAPI_taxonomy_image_url($parent_term->term_id, NULL, TRUE);
            $data[] = array('id' => $parent_term->term_id, 'name' => $parent_term->name, 'slug' => $parent_term->slug, 'term_img' => $term_imgUrl, 'term_count' => $parent_term->count);
            $child_terms = get_all_term_children($parent_term, $taxonomy);
            if (!empty($child_terms) && is_array($child_terms)) {
                foreach ($child_terms as $child_term_id) {
                    $child_term = get_term($child_term_id);
                    $data[] = array('id' => $child_term->term_id, 'name' => $child_term->name, 'slug' => $child_term->slug, 'term_img' => '', 'term_count' => $child_term->count);

                }
            }
        }
        $response = $data;
        return $response;
    }
}

function get_all_term_children($term, $taxonomy)
{
    if (is_wp_error(get_term_children($term->term_id, $taxonomy))) {
        return;
    }
    return get_term_children($term->term_id, $taxonomy);
}