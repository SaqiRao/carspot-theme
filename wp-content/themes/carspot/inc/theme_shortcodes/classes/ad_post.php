<?php
if (!class_exists('carspot_ad_post')) {

    class carspot_ad_post
    {
        /* user object */
        var $user_info;
        public function __construct()
        {
            $this->user_info = get_userdata(get_current_user_id());
        }
    }
}



add_action('wp_ajax_sb_ad_inspection', 'carspot_sb_ad_inspection');
add_action('wp_ajax_nopriv_sb_ad_inspection', 'carspot_sb_ad_inspection');
if (!function_exists('carspot_sb_ad_inspection')) {

    function carspot_sb_ad_inspection()
    {
      global $carspot_theme;
      
       $params = array();
           parse_str($_POST['data'], $params);

        if (isset($params['inspection_title']) != "") {
            $title = $params['inspection_title'];
            
        }

        $my_post = array(
          'post_title'    =>  $title,
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'inspection',
       );

// Insert the post into the database
   $pid =    wp_insert_post( $my_post );

        if (isset($params['location']) != "") {
            $country[] = $params['location'];      
         $location_set =   wp_set_post_terms($pid, $country, 'ad_location');
    
        }

         if (isset($params['address']) != "") {
            $address = $params['address'];
             update_post_meta($pid, '_carspot_insepection_address', $address);  
        }

         if (isset($params['make']) != "") {
            $make[] = $params['make'];
            wp_set_post_terms($pid, $make, 'ad_make');
        }

          if (isset($params['ad_time']) != "") {
            $ad_time = $params['ad_time'];
           update_post_meta($pid, '_carspot_insepection_ad_time', $ad_time);  
        }


         if (isset($params['ad_email']) != "") {
            $ad_email = $params['ad_email'];
           update_post_meta($pid, '_carspot_insepection_ad_email', $ad_email);  
        }

        
         if (isset($params['contact_number']) != "") {
            $contact_number = $params['contact_number'];
            update_post_meta($pid, '_carspot_insepection_number', $contact_number);
        }


         /* Email for new Inspection user */
         if (function_exists('carspot_email_on_new_inspection_user')) {
              carspot_email_on_new_inspection_user($pid, '');
        }

     }

}



/* Ad Posting... */
add_action('wp_ajax_sb_ad_posting', 'carspot_ad_posting');
if (!function_exists('carspot_ad_posting')) {

    function carspot_ad_posting()
    {
        check_ajax_referer('carspot_ad_post_secure', 'security');
        global $carspot_theme;
        if (get_current_user_id() == "") {
            echo "0";
            die();
        }
        // Getting values
        $params = array();
       
        parse_str($_POST['sb_data'], $params);
        $cats = array();
        if (isset($params['ad_cat_sub_sub_sub'])) {
            $cats[] = $params['ad_cat_sub_sub_sub'];

        }
        if (isset($params['ad_cat_sub_sub'])) {
            $cats[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub'] )) {
            $cats[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat'])) {
            $cats[] = $params['ad_cat'];
        }
        $video_req = isset($_POST['video_req']) ? $_POST['video_req'] : "";
        $get_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
        $ad_status = 'publish';
        /* if post going to update */
        if ($_POST['is_update'] != "") {
            if ($carspot_theme['sb_update_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            if ($carspot_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = isset($_POST['is_update']) ? $_POST['is_update'] : "";
            $media = get_attached_media('image', $pid);
            $is_imageallow = carspotCustomFieldsVals($pid, $cats);
            if ($is_imageallow == 1 && count((array)$media) == 0) {
                echo "img_req";
                die();
            }
            /* video required or not */
            $total_vid = get_post_meta($pid, 'carspot_video_uploaded_attachment_', true);
            if ($video_req == 1 && ($total_vid == '' || count($total_vid) < 1)) {
                echo "vid_req";
                die();
            }
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($pid, $single_media->ID);
                }
            }
            } else {
            if ($carspot_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            $media = get_attached_media('image', $pid);
            $is_imageallow = carspotCustomFieldsVals($pid, $cats);

            if ($is_imageallow == 1 && count((array)$media) == 0) {
                echo "img_req";
                die();
            }
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($pid, $single_media->ID);
                }
            }
            /* video required or not */
            $total_vid = get_post_meta($pid, 'carspot_video_uploaded_attachment_', true);
           // if ($video_req == 1 && ($total_vid == '' || count($total_vid) < 1)) {
           if ($video_req == 1 && (!is_array($total_vid) || count($total_vid) < 1)) {

                echo "vid_req";
                die();
            }

            /* Now user can post new ad */
            delete_user_meta(get_current_user_id(), 'ad_in_progress');
            update_post_meta($pid, '_carspot_is_feature', '0');
            update_post_meta($pid, '_carspot_ad_status_', 'active');
            //send email on new post creation
            carspot_get_notify_on_ad_post($pid);
        }

        /* Bad words filteration */
        $words = explode(',', $carspot_theme['bad_words_filter']);
        $replace = $carspot_theme['bad_words_replace'];
        $desc = carspot_badwords_filter($words, $params['ad_description'], $replace);
        $title = carspot_badwords_filter($words, $params['ad_title'], $replace);
        $my_post = array(
            'ID' => $pid,
            'post_title' => sanitize_text_field($title),
            'post_status' => $ad_status,
            'post_content' => $desc,
            'post_name' => sanitize_text_field($title)
        );

        wp_update_post($my_post);
        /* ==============================
         *          Categories
         * ============================= */
        $category = array();
        if ($params['ad_cat'] != "") {
            $category[] = $params['ad_cat'];
        }
        if (isset($params['ad_cat_sub'])) {
            $category[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat_sub_sub'])) {
            $category[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub_sub_sub'])) {
            $category[] = $params['ad_cat_sub_sub_sub'];
        }

        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based' && class_exists('WooCommerce') && sizeof(WC()->cart->get_cart()) > 0 && $get_ads == 0) {
            $ad_status = 'pending';
            $my_post = array(
                'ID' => $pid,
                'post_status' => $ad_status,
            );
            wp_update_post($my_post);
            update_post_meta($pid, '_carspot_category_based_cats', $category);
            wp_set_post_terms($pid, $category, 'ad_cats');
        } else {
            wp_set_post_terms($pid, $category, 'ad_cats');
            update_post_meta($pid, '_carspot_category_based_cats', $category);
        }

        /* ==============================
         *          Country
         * ============================= */
        $countries = array();
        if (isset($params['ad_country'])) {
            $countries[] = $params['ad_country'];
        }
        if (isset($params['ad_country_states'])) {
            $countries[] = $params['ad_country_states'];
        }
        if (isset($params['ad_country_cities'])) {
            $countries[] = $params['ad_country_cities'];
        }
        if (isset($params['ad_country_towns'])) {
            $countries[] = $params['ad_country_towns'];
        }
        wp_set_post_terms($pid, $countries, 'ad_country');
        if (isset($params['ad_country']) && !empty($params['ad_country'])) {
            update_post_meta($pid, '_carspot_ad_country', ($params['ad_country']));
        }
        /* country-state */
        if (isset($params['ad_country_states']) && !empty($params['ad_country_states'])) {
            update_post_meta($pid, '_carspot_ad_country_states', ($params['ad_country_states']));
        }
        /* country-city */
        if (isset($params['ad_country_cities']) && !empty($params['ad_country_cities'])) {
            update_post_meta($pid, '_carspot_ad_country_cities', ($params['ad_country_cities']));
        }
        /* country-town */
        if (isset($params['ad_country_towns']) && !empty($params['ad_country_towns'])) {
            update_post_meta($pid, '_carspot_ad_country_towns', ($params['ad_country_towns']));
        }

        /* ==============================
         *          Ad Type
         * ============================= */
        if ($params['_carspot_ad_type'] != "") {
            $type_arr = explode('|', $params['_carspot_ad_type']);
            wp_set_post_terms($pid, $type_arr[0], 'ad_type');
            update_post_meta($pid, '_carspot_ad_type', ($type_arr[1]));
        }
        /* ==============================
         *          Ad Condition
         * ============================= */
        if ($params['_carspot_ad_condition'] != "") {
            $condition_arr = explode('|', $params['_carspot_ad_condition']);
            wp_set_post_terms($pid, $condition_arr[0], 'ad_condition');
            update_post_meta($pid, '_carspot_ad_condition', ($condition_arr[1]));
        }
        /* ==============================
         *          Ad Warranty
         * ============================= */
        if ($params['_carspot_ad_warranty'] != "") {
            $warranty_arr = explode('|', $params['_carspot_ad_warranty']);
            wp_set_post_terms($pid, $warranty_arr[0], 'ad_warranty');
            update_post_meta($pid, '_carspot_ad_warranty', ($warranty_arr[1]));
        }
        /* ==============================
         *          Ad Year
         * ============================= */
        if ($params['_carspot_ad_years'] != "") {
            $year_arr = explode('|', $params['_carspot_ad_years']);
            wp_set_post_terms($pid, $year_arr[0], 'ad_year');
            update_post_meta($pid, '_carspot_ad_years', ($year_arr[1]));
        }
        /* ==============================
         *          Ad Body Type
         * ============================= */
        if (isset($params['_carspot_ad_body_types'])) {
            $ad_body_type_arr = explode('|', $params['_carspot_ad_body_types']);
            wp_set_post_terms($pid, $ad_body_type_arr[0], 'ad_body_type');
            update_post_meta($pid, '_carspot_ad_body_types', ($ad_body_type_arr[1]));
        }
        /* ==============================
         *          Ad Transmission
         * ============================= */
        $ad_transmission = '';
        if ($params['_carspot_ad_transmissions'] != "") {
            $ad_transmission_arr = explode('|', $params['_carspot_ad_transmissions']);
            wp_set_post_terms($pid, $ad_transmission_arr[0], 'ad_transmission');
            update_post_meta($pid, '_carspot_ad_transmissions', ($ad_transmission_arr[1]));
        }
        /* ==============================
         *          Ad Engine Capacity
         * ============================= */
        if (isset($params['ad_engine_capacity'])) {
            $ad_engine_capacity_arr = explode('|', $params['ad_engine_capacity']);
            wp_set_post_terms($pid, $ad_engine_capacity_arr[0], 'ad_engine_capacity');
            update_post_meta($pid, '_carspot_ad_engine_capacities', ($ad_engine_capacity_arr[1]));
        }
        /* ==============================
         *          Ad Engine Type
         * ============================= */
        if ($params['_carspot_ad_engine_capacities'] != "") {
            $ad_engine_type_arr = explode('|', $params['_carspot_ad_engine_capacities']);
            wp_set_post_terms($pid, $ad_engine_type_arr[0], 'ad_engine_type');
            update_post_meta($pid, '_carspot_ad_engine_types', ($ad_engine_type_arr[1]));
        }
        /* ==============================
         *          Ad Assemble
         * ============================= */
        if ($params['_carspot_ad_assembles'] != "") {
            $ad_assemble_arr = explode('|', $params['_carspot_ad_assembles']);
            wp_set_post_terms($pid, $ad_assemble_arr[0], 'ad_assemble');
            update_post_meta($pid, '_carspot_ad_assembles', ($ad_assemble_arr[1]));
        }
        /* ==============================
         *          Ad Color
         * ============================= */
        if ($params['_carspot_ad_colors'] != "") {
            $ad_color_arr = explode('|', $params['_carspot_ad_colors']);
            wp_set_post_terms($pid, $ad_color_arr[0], 'ad_colors');
            update_post_meta($pid, '_carspot_ad_colors', ($ad_color_arr[1]));
        }
        /* ==============================
         *          Ad Insurance
         * ============================= */
        if ($params['_carspot_ad_insurance'] != "") {
            $ad_insurance_arr = explode('|', $params['_carspot_ad_insurance']);
            wp_set_post_terms($pid, $ad_insurance_arr[0], 'ad_insurance');
            update_post_meta($pid, '_carspot_ad_insurance', ($ad_insurance_arr[1]));
        }
        /* ==============================
         *          Ad Tags
         * ============================= */
        $tags = explode(',', $params['tags']);
        wp_set_object_terms($pid, $tags, 'ad_tags');

        /* Update post meta */
        //sb_user_name
        if(isset($params['sb_user_name'])){
        update_post_meta($pid, '_carspot_poster_name', sanitize_text_field($params['sb_user_name']));
        }
        //sb_contact_number
        if(isset($params['sb_contact_number'])){
        update_post_meta($pid, '_carspot_poster_contact', sanitize_text_field($params['sb_contact_number']));
        }
        //ad_mileage
        if(isset($params['ad_mileage'])){
        update_post_meta($pid, '_carspot_ad_mileage', sanitize_text_field($params['ad_mileage']));
        }
        //ad_price
        if(isset($params['ad_price'])){
        update_post_meta($pid, '_carspot_ad_price', sanitize_text_field($params['ad_price']));
        }
        //ad_map_lat
        if(isset($params['ad_map_lat'])){
        update_post_meta($pid, '_carspot_ad_map_lat', sanitize_text_field($params['ad_map_lat']));
        }
        //ad_map_long
        if(isset($params['ad_map_long'])){
        update_post_meta($pid, '_carspot_ad_map_long', sanitize_text_field($params['ad_map_long']));
        }
        //ad_bidding
        if(isset($params['ad_bidding'])){
        update_post_meta($pid, '_carspot_ad_bidding', sanitize_text_field($params['ad_bidding']));
        }
        //ad_price_type
        if(isset($params['ad_price_type'])){
        update_post_meta($pid, '_carspot_ad_price_type', sanitize_text_field($params['ad_price_type']));
        }
        //sb_user_address
        if(isset($params['sb_user_address'])){
        update_post_meta($pid, '_carspot_ad_map_location', sanitize_text_field($params['sb_user_address']));
        }
        //ad_avg_city
        if(isset($params['ad_avg_city'])){
        update_post_meta($pid, '_carspot_ad_avg_city', sanitize_text_field($params['ad_avg_city']));
        }
        //ad_avg_hwy
        if(isset($params['ad_avg_hwy'])){
        update_post_meta($pid, '_carspot_ad_avg_hwy', sanitize_text_field($params['ad_avg_hwy']));
        }
        //ad_time
        if(isset($params['ad_time'])){
        update_post_meta($pid, '_ad_time_key', sanitize_text_field($params['ad_time']));
        }
        //ad_min_bid
        if(isset($params['ad_min_bid'])){
        update_post_meta($pid, 'ad_min_bid_key', sanitize_text_field($params['ad_min_bid']));
        }
        //ad_dif_bid
        if(isset($params['ad_dif_bid'])){
        update_post_meta($pid, 'ad_dif_bid_key', sanitize_text_field($params['ad_dif_bid']));
        }

        //update_post_meta($pid, '_carspot_review_by_company', sanitize_text_field($params['review_by_company_url']));
        foreach ($params as $key => $val) {
            $pos = strpos($key, '_carspot_');
            if ($pos !== false) {
                $value = '';
                if ($val != "") {
                    $valueArr = explode('|', $val);
                    wp_set_post_terms($pid, $valueArr[0], 'ad_insurance');
                    $value = $valueArr[1];
                }
                update_post_meta($pid, $key, sanitize_text_field($value));
            }
        }
        if (isset($params['ad_yvideo']) && $params['ad_yvideo'] != "") {
            $video = explode("&t=", $params['ad_yvideo']);
            if (isset($video[0]) && $video[0] != "") {
                update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($video[0]));
            } else {
                update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
            }
        } else {
            update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
        }
        // Stroring Extra fileds in DB
        if ($params['sb_total_extra'] > 0) {
            for ($i = 1; $i <= $params['sb_total_extra']; $i++) {
                update_post_meta($pid, "_sb_extra_" . $params["title_$i"], sanitize_text_field($params["sb_extra_$i"]));
            }
        }

        //Add Dynamic Fields
        if (isset($params['cat_template_field']) && count($params['cat_template_field']) > 0) {
            foreach ($params['cat_template_field'] as $key => $data) {
                if (is_array($data)) {
                    $dataArr = array();
                    foreach ($data as $k) {
                        $dataArr[] = $k;
                    }
                    $data = stripslashes(json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                }
                update_post_meta($pid, $key, sanitize_text_field($data));
            }
        }
        /* ad features */
        $features = $params['ad_features'];
        if (count((array)$features) > 0) {
            $ad_features = '';
            foreach ($features as $feature) {
                $ad_features .= $feature . "|";
            }
            $ad_features = rtrim($ad_features, '|');
        }
        update_post_meta($pid, '_carspot_ad_features', sanitize_text_field($ad_features));
        if(isset($params['ad_time'])){
        update_post_meta($pid, '_ad_time_key', sanitize_text_field($params['ad_time']));
        }
        /* review stamp array */
        $review_stamp_val = isset($params['review_stamp_nme']) ? $params['review_stamp_nme'] : "";
        if ($review_stamp_val != '') {
            $arrays = explode('|', $review_stamp_val);
            update_post_meta($pid, '_carspot_ad_review_stamp', $arrays[1]);
            wp_set_post_terms($pid, $arrays[0], $term_type);


        }
        /* VIN Number vin_number */
        if (isset($params['vin_number'])) {
            update_post_meta($pid, 'carspot_ad_vin_number', sanitize_text_field($params['vin_number']));
        }
        //only for category based pricing
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based' && class_exists('WooCommerce')) {
            if (sizeof(WC()->cart->get_cart()) > 0) {
                $carts = WC()->cart->get_cart();

                WC()->session->set('_carspot_ad_id', $pid);
                if (isset($carspot_theme['sb_checkout_page']) && $carspot_theme['sb_checkout_page'] != '') {
                    $pid = $carspot_theme['sb_checkout_page'];
                }
            }
        }

        //only for category based pricing
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
            if (isset($_POST['is_update']) && $_POST['is_update'] == "") {
                $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
                if ($simple_ads > 0 && !is_super_admin(get_current_user_id())) {
                    $simple_ads = $simple_ads - 1;
                    update_user_meta(get_current_user_id(), '_sb_simple_ads', $simple_ads);
                }
            }

            // Making it featured ad
            if (isset($params['sb_make_it_feature']) && $params['sb_make_it_feature']) {
                // Uptaing remaining ads.
                $featured_ad = get_user_meta(get_current_user_id(), '_carspot_featured_ads', true);
                if ($featured_ad > 0 || $featured_ad == '-1') {
                    update_post_meta($pid, '_carspot_is_feature', '1');
                    update_post_meta($pid, '_carspot_is_feature_date', date('Y-m-d'));
                    $featured_ad = $featured_ad - 1;
                    update_user_meta(get_current_user_id(), '_carspot_featured_ads', $featured_ad);
                }
            }
            // Bumping it up
            if (isset($params['sb_bump_up']) && $params['sb_bump_up']) {
                // Uptaing remaining ads.
                $bump_ads = get_user_meta(get_current_user_id(), '_carspot_bump_ads', true);
                if ($bump_ads > 0 || $bump_ads == '-1') {
                    wp_update_post(
                        array(
                            'ID' => $pid, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                        )
                    );
                    if ($bump_ads != '-1') {
                        $bump_ads = $bump_ads - 1;
                    }
                    update_user_meta(get_current_user_id(), '_carspot_bump_ads', $bump_ads);
                }
            }
        }
        
        if ($_POST['is_update'] == "") {
           
            do_action('cs_duplicate_posts_lang_wpml', $pid, 'ad_post');
        }
        echo urldecode(get_the_permalink($pid));
        die();
    }

}

// Get sub cats
add_action('wp_ajax_sb_get_sub_cat_search', 'carspot_get_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_cat_search', 'carspot_get_sub_cats_search');
if (!function_exists('carspot_get_sub_cats_search')) {

    function carspot_get_sub_cats_search()
    {
        global $carspot_theme;
        $heading = '';
        if (isset($carspot_theme['cat_level_2']) && $carspot_theme['cat_level_2'] != "") {
            $heading = $carspot_theme['cat_level_2'];
        }
        $cat_id = $_POST['cat_id'];
        $filter_css_class = isset($_POST['filter_class']) ? $_POST['filter_class'] : 'search-select';
        $ad_cats = carspot_get_cats('ad_cats', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="' . $filter_css_class . " " . ' form-control" id="cats_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}

// Get sub cats Version
add_action('wp_ajax_sb_get_sub_sub_cat_search', 'carspot_get_sub_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_cat_search', 'carspot_get_sub_sub_cats_search');
if (!function_exists('carspot_get_sub_sub_cats_search')) {

    function carspot_get_sub_sub_cats_search()
    {
        global $carspot_theme;
        $heading = '';
        if (isset($carspot_theme['cat_level_3']) && $carspot_theme['cat_level_3'] != "") {
            $heading = $carspot_theme['cat_level_3'];
        }
        $cat_id = $_POST['cat_id'];
        $filter_css_class = isset($_POST['filter_class']) ? $_POST['filter_class'] : 'search-select';
        $ad_cats = carspot_get_cats('ad_cats', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="' . $filter_css_class . " " . ' form-control"  id="select_version">';
            $res .= '<option label="' . esc_html__('Select An Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}

// Get sub cats Version 4th Level
add_action('wp_ajax_sb_get_sub_sub_sub_cat_search', 'carspot_get_sub_sub_sub_cats_forth_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_sub_cat_search', 'carspot_get_sub_sub_sub_cats_forth_search');
if (!function_exists('carspot_get_sub_sub_sub_cats_forth_search')) {

    function carspot_get_sub_sub_sub_cats_forth_search()
    {
        global $carspot_theme;
        $heading = '';
        if (isset($carspot_theme['cat_level_4']) && $carspot_theme['cat_level_4'] != "") {
            $heading = $carspot_theme['cat_level_4'];
        }
        $cat_id = $_POST['cat_id'];
        $filter_css_class = isset($_POST['filter_class']) ? $_POST['filter_class'] : 'search-select';
        $ad_cats = carspot_get_cats('ad_cats', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="' . $filter_css_class . " " . ' form-control"  id="select_forth">';
            $res .= '<option label="' . esc_html__('Select An Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}


/*  Get sub cats */

add_action('wp_ajax_sb_get_sub_cat', 'carspot_get_sub_cats');
if (!function_exists('carspot_get_sub_cats')) {

    function carspot_get_sub_cats()
    {
        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_cats', $cat_id);
        if (count((array)$ad_cats) > 0) {

            $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">';
            $cats_html .= '<option label="' . esc_html__('Select Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo($cats_html);
            die();
        } else {
            return "";
            die();
        }
    }

}

if (!function_exists('carspot_check_author')) {

    function carspot_check_author($ad_id = '')
    {
        if (get_post_field('post_author', $ad_id) != get_current_user_id()) {
            return false;
        } else {
            return true;
        }
    }

}

add_action('wp_ajax_post_ad', 'carspot_post_ad_process');
if (!function_exists('carspot_post_ad_process')) {

    function carspot_post_ad_process()
    {
        if (isset($_POST['is_update']) && $_POST['is_update'] != "") {
            return '';
        }

        $title = (isset($_POST['title'])) ? $_POST['title'] : "-";
        if (get_current_user_id() == "") {
            die();
        }
        if (!isset($title)) {
            die();
        }

        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        if (get_post_status($ad_id) && $ad_id != "") {
            $my_post = array(
                'ID' => get_user_meta(get_current_user_id(), 'ad_in_progress', true),
                'post_title' => $title,
            );
            wp_update_post($my_post);

            return '';
        }
        // Gather post data.
        $my_post = array(
            'post_title' => sanitize_text_field($title),
            'post_status' => 'pending',
            'post_author' => get_current_user_id(),
            'post_type' => 'ad_post'
        );

        // Insert the post into the database.
        $id = wp_insert_post($my_post);
       // print_r($id);
       // exit;
        if ($id) {
            update_user_meta(get_current_user_id(), 'ad_in_progress', $id);
        }

        return '';
    }

}



add_action('wp_ajax_post_name', 'carspot_post_name_process');
if (!function_exists('carspot_post_name_process')) {

    function carspot_post_name_process()
    {
        if (isset($_POST['is_update']) && $_POST['is_update'] != "") {
            return '';
        }

        $name = (isset($_POST['name'])) ? $_POST['name'] : "-";
        if (get_current_user_id() == "") {
            die();
        }
        if (!isset($name)) {
            die();
        }

        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        if (get_post_status($ad_id) && $ad_id != "") {
            $my_post = array(
                'ID' => get_user_meta(get_current_user_id(), 'ad_in_progress', true),
                'post_title' => $name,
            );
            wp_update_post($my_post);

            return '';
        }
        // Gather post data.
        $my_post = array(
            'post_title' => sanitize_text_field($name),
            'post_status' => 'pending',
            'post_author' => get_current_user_id(),
            'post_type' => 'ad_post'
        );

        // Insert the post into the database.
        $id = wp_insert_post($my_post);
        if ($id) {
            update_user_meta(get_current_user_id(), 'ad_in_progress', $id);
        }

        return '';
    }

}

/* upload images with dropzone library and save it. */
add_action('wp_ajax_upload_ad_images', 'carspot_upload_ad_images');

if (!function_exists('carspot_upload_ad_images')) {
    function carspot_upload_ad_images()
    {
        global $carspot_theme;
        carspot_authenticate_check();
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        $size_arr = explode('-', $carspot_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        // Allow certain file formats
        $imageFileType = strtolower(end(explode('.', $_FILES['my_file_upload']['name'])));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '0|' . esc_html__("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'carspot');
            die();
        }

        // Check file size
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . esc_html__("Max allowd image size is", 'carspot') . " " . $display_size;
            die();
        }

        // Let WordPress handle the upload.
        // Remember, 'my_image_upload' is the name of our file input in our form above.
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        // Check max image limit
        $media = get_attached_media('image', $ad_id);
        if (count((array)$media) >= $carspot_theme['sb_upload_limit']) {
            echo '0|' . esc_html__("You can not upload more than ", 'carspot') . " " . $carspot_theme['sb_upload_limit'];
            die();
        }
        $attachment_id = media_handle_upload('my_file_upload', $ad_id);
        if (!is_wp_error($attachment_id)) {
            $imgaes = get_post_meta($ad_id, 'carspot_photo_arrangement_', true);
            if ($imgaes != "") {
                $imgaes = $imgaes . ',' . $attachment_id;
                update_post_meta($ad_id, 'carspot_photo_arrangement_', $imgaes);
            } else {
                update_post_meta($ad_id, 'carspot_photo_arrangement_', $attachment_id);
            }
            echo '' . $attachment_id;
            die();
        } else {
            echo '0|' . esc_html__("Something went wrong please try later", 'carspot');
            die();
        }
    }

}
/* Fetch images with dropzone library. */
add_action('wp_ajax_get_uploaded_ad_images', 'carspot_get_uploaded_ad_images');
if (!function_exists('carspot_get_uploaded_ad_images')) {

    function carspot_get_uploaded_ad_images()
    {
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        $result = array();
        $mid = '';
        $media = carspot_fetch_listing_media($ad_id, 'carspot_photo_arrangement_');
        if (count((array)$media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $image = wp_get_attachment_image_src($mid, 'carspot-ad-thumb');
                $img = isset($image[0]) ? $image[0] : "";
                $obj = array();
                $obj['display_name'] = basename(get_attached_file($mid));
                $obj['name'] = $img;
                $obj['size'] = filesize(get_attached_file($mid));
                $obj['id'] = $mid;
                $result[] = $obj;
            }
        }


        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
        die();
    }

}
/* Delete images with dropzone library. */
add_action('wp_ajax_delete_ad_image', 'carspot_delete_ad_image');
if (!function_exists('carspot_delete_ad_image')) {

    function carspot_delete_ad_image()
    {
        if (get_current_user_id() == "") {
            die();
        }


        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id()) {
            die();
        }


        $attachmentid = $_POST['img'];
        wp_delete_attachment($attachmentid, true);

        if (get_post_meta($ad_id, 'carspot_photo_arrangement_', true) != "") {
            $ids = get_post_meta($ad_id, 'carspot_photo_arrangement_', true);
            $res = str_replace($attachmentid, "", $ids);
            $res = str_replace(',,', ",", $res);
            $img_ids = trim($res, ',');
            update_post_meta($ad_id, 'carspot_photo_arrangement_', $img_ids);
        }
        echo "1";
        die();
    }

}

/*  */
if (!function_exists('carspot_delete_post_taxonomies')) {

    function carspot_delete_post_taxonomies($object_id = '', $taxonomy = '')
    {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = '$object_id'");
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                $rs = $wpdb->get_row("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id = '" . $row->term_taxonomy_id . "'");
                if ($rs->taxonomy == $taxonomy) {
                    echo "DELETE FROM $wpdb->term_relationships WHERE object_id = '$object_id' AND term_taxonomy_id = '" . $row->term_taxonomy_id . "'";

                    $wpdb->delete($wpdb->term_relationships, array(
                        'object_id' => $object_id,
                        'term_taxonomy_id' => $row->term_taxonomy_id
                    ));
                }
            }
        }
    }

}
if (!function_exists('carspot_get_ad_cats')) {

    function carspot_get_ad_cats($id = '', $by = 'name')
    {
        $terms = wp_get_post_terms($id, 'ad_cats');
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }

        return $cats;
        $post_categories = wp_get_object_terms($id, 'ad_cats', array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }

        return $cats;
    }

}
if (!function_exists('carspot_get_ad_country')) {

    function carspot_get_ad_country($id = '', $by = 'name')
    {
        $terms = wp_get_post_terms($id, 'ad_country');
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }

        return $cats;

        $post_countries = wp_get_object_terms($id, array('ad_country'), array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_countries as $country) {
            $related_result = get_term($country);
            $cats[] = array('name' => $related_result->name, 'id' => $related_result->term_id);
        }

        return $cats;
    }

}

// Get all messages of particular ad
add_action('wp_ajax_sb_get_messages', 'carspot_get_messages');
if (!function_exists('carspot_get_messages')) {

    function carspot_get_messages()
    {
        carspot_authenticate_check();

        $ad_id = $_POST['ad_id'];
        $user_id = $_POST['user_id'];
        $authors = array($user_id, get_current_user_id());

        // Mark as read conversation
        update_comment_meta(get_current_user_id(), $ad_id . "_" . $user_id, 1);


        $parent = $user_id;
        if ($_POST['inbox'] == 'yes') {
            $parent = get_current_user_id();
        }
        $args = array(
            'author__in' => $authors,
            'post_id' => $ad_id,
            'parent' => $parent,
            'orderby' => 'comment_date',
            'order' => 'ASC',
        );
        $comments = get_comments($args);
        $messages = '';
        $i = 1;
        $total = count((array)$comments);
        if (count((array)$comments) > 0) {
            foreach ($comments as $comment) {
                $user_pic = '';
                $class = 'friend-message';
                if ($comment->user_id == get_current_user_id()) {
                    $class = 'my-message';
                }
                $user_pic = carspot_get_user_dp($comment->user_id);
                $id = '';
                if ($i == $total) {
                    $id = 'id="last_li"';
                }
                $i++;
                $messages .= '<li class="' . $class . ' clearfix" ' . $id . '>
							 <figure class="profile-picture">
								<img src="' . $user_pic . '" class="img-circle" alt="' . esc_html__('Profile Pic', 'carspot') . '">
							 </figure>
							 <div class="message">
								' . $comment->comment_content . '
								<div class="time"><i class="fa fa-clock-o"></i> ' . carspot_timeago($comment->comment_date) . '</div>
							 </div>
						  </li>';
            }
        }
        echo($messages);
        die();
    }

}

if (!function_exists('carspot_authenticate_check')) {

    function carspot_authenticate_check()
    {
        if (get_current_user_id() == 0) {
            echo '0|' . esc_html__("You are not logged in.", 'carspot');
            die();
        }
    }

}


// Get States
add_action('wp_ajax_sb_get_sub_states', 'carspot_get_sub_states');
add_action('wp_ajax_nopriv_sb_get_sub_states_search', 'carspot_get_sub_states_search');
if (!function_exists('carspot_get_sub_states')) {

    function carspot_get_sub_states()
    {
        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_country', $cat_id);
        if (count((array)$ad_cats) > 0) {
            $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">';
            $cats_html .= '<option label="' . esc_html__('Select Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo($cats_html);
            die();
        } else {
            echo "";
            die();
        }
    }

}

// Get States Search
add_action('wp_ajax_sb_get_sub_states_search', 'carspot_get_sub_states_search');
add_action('wp_ajax_nopriv_sb_get_sub_states_search', 'carspot_get_sub_states_search');
if (!function_exists('carspot_get_sub_states_search')) {

    function carspot_get_sub_states_search()
    {

        $cat_id = $_POST['country_id'];
        $ad_cats = carspot_get_cats('ad_country', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res = '<label>' . carspot_get_taxonomy_parents($cat_id, 'ad_country', false) . '</label>';
            $res .= '<ul class="city-select-city" >';
            foreach ($ad_cats as $ad_cat) {
                $location_count = get_term($ad_cat->term_id);
                $count = $location_count->count;
                $id = 'ajax_states';
                $res .= '<li class="col-sm-3 col-md-4 col-xs-4"><a href="javascript:void(0);" data-country-id="' . esc_attr($ad_cat->term_id) . '" id="' . $id . '">' . $ad_cat->name . ' <span>(' . esc_html($count) . ')</span></a></li>';
            }
            $res .= '</ul>';
            echo($res);
        } else {
            echo "submit";
        }
        die();
    }

}

/* Top Most Term */
if (!function_exists('carspot_get_top_most_parents')) {

    function carspot_get_top_most_parents($id = '', $taxonomy = '')
    {
        $chain = '';
        $parent = get_term($id, $taxonomy);
        $parents = array();
        $name = $parent->name;
        if ($parent->parent && ($parent->parent != $parent->term_id)) {

            $term_id = $parent->term_id;
            $parents[] = array('name' => $name, 'id' => $term_id);
        }

        return $parents;
    }

}

/* Fields Values */
if (!function_exists('carspotCustomFieldsVals')) {

    function carspotCustomFieldsVals($post_id = '', $terms = array())
    {
        if ($post_id == "") {
            return;
        }
        /* $terms = wp_get_post_terms($post_id, 'ad_cats'); */
        $is_show = '';
        if (count((array)$terms) > 0) {

            foreach ($terms as $term) {
                $term_id = $term;
                $t = carspot_dynamic_templateID($term_id);
                if ($t) {
                    break;
                }
            }
            $templateID = carspot_dynamic_templateID($term_id);
            $result = get_term_meta($templateID, '_sb_dynamic_form_fields', true);

            $is_show = '';
            $html = '';

            if (isset($result) && $result != "") {
                $is_show = sb_custom_form_data($result, '_sb_default_cat_image_required');
            }
        }
        if ($is_show == 1) {
            return 1;
        } else {
            return 0;
        }
    }

}


// LOCATION DROPSOWN IN SEARCH PAGE
// Get sub cats
add_action('wp_ajax_sb_get_sub_loc_search', 'carspot_get_sub_loc_search');
add_action('wp_ajax_sb_get_sub_loc_search', 'carspot_get_sub_loc_search');
if (!function_exists('carspot_get_sub_loc_search')) {

    function carspot_get_sub_loc_search()
    {
        global $carspot_theme;
        if ($carspot_theme['sb_location_titles'] != "") {
            $titles_array = explode("|", $carspot_theme['sb_location_titles']);
            if (count((array)$titles_array) > 0) {
                if (isset($titles_array[1])) {
                    $heading = $titles_array[1];
                }
            }
        }
        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_country', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="search-select form-control" id="loc_first_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}

// Get sub cats Version
add_action('wp_ajax_sb_get_sub_sub_loc_search', 'carspot_get_sub_sub_loc_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_loc_search', 'carspot_get_sub_sub_loc_search');
if (!function_exists('carspot_get_sub_sub_loc_search')) {

    function carspot_get_sub_sub_loc_search()
    {
        global $carspot_theme;
        $heading = '';
        if ($carspot_theme['sb_location_titles'] != "") {
            $titles_array = explode("|", $carspot_theme['sb_location_titles']);
            if (count((array)$titles_array) > 0) {
                if (isset($titles_array[2])) {
                    $heading = $titles_array[2];
                }
            }
        }

        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_country', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="search-select form-control"  id="loc_second_response">';
            $res .= '<option label="' . esc_html__('Select An Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}

// Get sub cats Version 4th Level
add_action('wp_ajax_sb_get_sub_sub_sub_loc_search', 'carspot_get_sub_sub_sub_loc_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_sub_loc_search', 'carspot_get_sub_sub_sub_loc_search');
if (!function_exists('carspot_get_sub_sub_sub_loc_search')) {

    function carspot_get_sub_sub_sub_loc_search()
    {
        global $carspot_theme;
        $heading = '';
        if ($carspot_theme['sb_location_titles'] != "") {
            $titles_array = explode("|", $carspot_theme['sb_location_titles']);
            if (count((array)$titles_array) > 0) {
                if (isset($titles_array[3])) {
                    $heading = $titles_array[3];
                }
            }
        }
        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_country', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="search-select form-control"  id="loc_forth_response">';
            $res .= '<option label="' . esc_html__('Select An Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo($res);
        }
        die();
    }

}


/* ============================== */
/*    upload pdf brochure file    */
/* ============================== */
/* upload pdf brochure file with dropzone library and save it. */
add_action('wp_ajax_upload_pdf_brochure_file', 'carspot_upload_pdf_brochure_file');

if (!function_exists('carspot_upload_pdf_brochure_file')) {

    function carspot_upload_pdf_brochure_file()
    {
        global $carspot_theme;
        carspot_authenticate_check();
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        /* file details */
        $upload_file_name = $_FILES['my_pdf_brochure_file_upload']['name'];
        $upload_file_size = $_FILES['my_pdf_brochure_file_upload']['size'];
        $upload_convert_to_mb = ($upload_file_size / 1000000);
        $upload_file_format = explode('.', $upload_file_name);

        /* file option from theme options */
        $size_arr = explode('-', $carspot_theme['pdf_brochure_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];
        /* check file format */
        $get_uploaded_file_type = strtolower(end($upload_file_format));
        if ($get_uploaded_file_type != "pdf") {
            echo '0|' . esc_html__("Sorry, only PDF file is allowed.", 'carspot');
            die();
        }
        /* Check file size */
        if ($upload_convert_to_mb > $actual_size) {
            echo '0|' . esc_html__("Max allowd image size is", 'carspot') . " " . $display_size;
            die();
        }
        // Let WordPress handle the upload.
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        /* get already attachment ids */
        $store_pdf_ids = '';
        // $store_pdf_ids = get_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', true);
        // $store_pdf_ids_arr = explode(',', $store_pdf_ids);

        $store_pdf_ids_arr = get_attached_media('application/pdf', $ad_id);
        // Check max file limit
        if (count($store_pdf_ids_arr) > 0) {
            if (count($store_pdf_ids_arr) >= $carspot_theme['pdf_brochure_upload_limit']) {
                echo '0|' . esc_html__("You can not upload more than ", 'carspot') . " " . $carspot_theme['pdf_brochure_upload_limit'];
                die();
            }
        }
        $attachment_id = media_handle_upload('my_pdf_brochure_file_upload', $ad_id);
        if (!is_wp_error($attachment_id)) {
            $brochure_file = get_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', true);
            if ($brochure_file != "") {
                $brochure_file = $brochure_file . ',' . $attachment_id;
                update_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', $brochure_file);
            } else {
                update_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', $attachment_id);
            }
            echo '' . $attachment_id;
            die();
        } else {
            echo '0|' . esc_html__("Something went wrong please try later", 'carspot');
            die();
        }
    }

}

/*
 *  Fetch pdf brochure file ... 
 */

add_action('wp_ajax_get_uploaded_pdf_brochure_file', 'carspot_get_uploaded_pdf_brochure_file');
if (!function_exists('carspot_get_uploaded_pdf_brochure_file')) {

    function carspot_get_uploaded_pdf_brochure_file()
    {
        $result = array();
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        //$brochure_file = carspot_fetch_listing_media($ad_id, 'carspot_pdf_brochure_arrangement_');
        $brochure_file = get_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', true);

        $brochure_ids = (explode(",", $brochure_file));
        if (count($brochure_ids) > 0 && is_array($brochure_ids) && $brochure_ids[0] != "-1" && $brochure_ids[0] != '') {
            $mid = '';
            for ($i = 0; $i < count($brochure_ids); $i++) {
                $mid = $brochure_ids[$i];
                $pdf_brochure = wp_get_attachment_url($mid);
                $pdf_ = $pdf_brochure;
                $obj = array();
                $obj['pdf_display_name'] = basename(get_attached_file($mid));
                $obj['pdf_name'] = $pdf_;
                $obj['pdf_size'] = filesize(get_attached_file($mid));
                $obj['pdf_id'] = $mid;
                $result[] = $obj;
            }
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
        die();
    }

}

/* delete pdf brochure file */
add_action('wp_ajax_delete_pdf_brochure_file', 'carspot_delete_pdf_brochure_file');
if (!function_exists('carspot_delete_pdf_brochure_file')) {

    function carspot_delete_pdf_brochure_file()
    {
        if (get_current_user_id() == "") {
            die();
        }
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id()) {
            die();
        }
        $attachment_id = $_POST['pdf'];
        if ($attachment_id) {
            $ids = get_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', true);
            $res = str_replace($attachment_id, "", $ids);
            $res = str_replace(',,', ",", $res);
            $pdf_ids = trim($res, ',');
            wp_delete_attachment($attachment_id, true);
            update_post_meta($ad_id, 'carspot_pdf_brochure_arrangement_', $pdf_ids);
            echo '1';
        } else {
            //echo "1";
            echo '0|' . __("File not Deleted", 'carspot');
        }
        die();
    }
}
/* ========================= */
/*  deal with video upload   */
/* ========================= */

add_action('wp_ajax_upload_cs_single_video', 'carspot_upload_cs_single_video');

if (!function_exists('carspot_upload_cs_single_video')) {

    function carspot_upload_cs_single_video()
    {
        global $carspot_theme;
        carspot_authenticate_check();
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        /* get files information */
        $vid_file_name = $_FILES['my_single_video_upload']['name'];
        $vid_file_size = $_FILES['my_single_video_upload']['size'];
        $vid_convert_to_mb = ($vid_file_size / 1000000);
        $vid_file_format = end(explode('.', $vid_file_name));

        /* max upload size in MB */
        $vid_size_arr = explode('-', $carspot_theme['sb_upload_video_mb_limit']);
        $vid_display_size = $vid_size_arr[1];
        $vid_actual_size = $vid_size_arr[0];

        /* Check file size */
        if ($vid_convert_to_mb > $vid_actual_size) {
            echo '0|' . __("Max allowd video size in MB is", 'carspot') . " " . $vid_actual_size;
            die();
        }

        /* check ad is updating */
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        /* get already attachment ids */
        $store_vid_ids = '';
        $store_vid_ids_arr = array();
        $store_vid_ids = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);
        if ($store_vid_ids != '') {
            $store_vid_ids_arr = explode(',', $store_vid_ids);
        }
        // Check max file limit
        if (count($store_vid_ids_arr) > 0) {
            if (count($store_vid_ids_arr) >= $carspot_theme['sb_upload_video_limit']) {
                echo '0|' . esc_html__("You can not upload more than ", 'carspot') . " " . $carspot_theme['sb_upload_video_limit'];
                die();
            }
        }
        $attachment_id = media_handle_upload('my_single_video_upload', $ad_id);
        if (!is_wp_error($attachment_id)) {
            $video_attachment_id = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);
            if ($video_attachment_id != "") {
                $video_attachment_id = $video_attachment_id . ',' . $attachment_id;
                update_post_meta($ad_id, 'carspot_video_uploaded_attachment_', $video_attachment_id);
            } else {
                update_post_meta($ad_id, 'carspot_video_uploaded_attachment_', $attachment_id);
            }
            echo '' . $attachment_id;
            die();
        } else {
            echo '0|' . __("Something went wrong please try later", 'carspot');
            die();
        }
    }

}

/* Fetch uploaded video to display after upload ... */

add_action('wp_ajax_get_uploaded_video', 'carspot_get_uploaded_video');
if (!function_exists('carspot_get_uploaded_video')) {

    function carspot_get_uploaded_video()
    {
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        /* get record from db */
        $video_attachment_id = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);

        $video_ids_ = (explode(",", $video_attachment_id));

        $result = array();
        if (count($video_ids_) > 0 && is_array($video_ids_) && $video_ids_[0] != "-1" && $video_ids_[0] != '') {
            $mid = '';
            //if (isset($video_attachment_id) && !empty($video_attachment_id) && $video_attachment_id[0] != "-1") {
            //$image = wp_get_attachment_image_src($video_attachment_id, 'carspot-ad-thumb');
            for ($i = 0; $i < count($video_ids_); $i++) {
                $mid = $video_ids_[$i];
                $attach_video_details = wp_get_attachment_metadata($mid);
                $video_url = wp_get_attachment_url($mid);
                $obj = array();
                $obj['video_name'] = basename(get_attached_file($mid));
                $obj['video_url'] = $video_url;
                $obj['video_size'] = filesize(get_attached_file($mid));
                $obj['video_id'] = (int)$mid;
                $result[] = $obj;
            }
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        if ($result != '') {
            echo json_encode($result);
        }
        die();
    }

}

/* delete video */
add_action('wp_ajax_delete_upload_video', 'carspot_delete_upload_video');
if (!function_exists('carspot_delete_upload_video')) {

    function carspot_delete_upload_video()
    {
        if (get_current_user_id() == "") {
            die();
        }
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id()) {
            die();
        }

        $attachment_id_ = $_POST['video'];
        if ($attachment_id_) {
            $save_db = '';
            $ids = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);
            $ids_arr = explode(',', $ids);
            if (in_array($attachment_id_, $ids_arr)) {
                unset($ids_arr[array_search($attachment_id_, $ids_arr)]);
            }
            if (!empty($ids_arr) && $ids_arr[0] != '') {
                $ids_arr = array_values($ids_arr);
                $save_db = implode(',', $ids_arr);
            } else {
                $save_db = "";
            }
            $update_output = update_post_meta($ad_id, 'carspot_video_uploaded_attachment_', $save_db);
            if ($update_output != false) {
                wp_delete_attachment($attachment_id_, true);
            }
            echo '1';
            die();
        } else {
            echo '0|' . __("File not Deleted", 'carspot');
            die();
        }
    }

}


/*first character capital remaining small*/
if (!function_exists('first_chaar_capital_rest_small')) {
    function first_chaar_capital_rest_small($val = '')
    {
        return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($val))));
    }
}

/* perform action on result that get from  https://www.immatriculationapi.com/ API */
function insert_api_record_in_db($url = '')
{
    if ($url != '') {
        $result = $field_data = array();
        $response = file_get_contents($url);
        $xml = simplexml_load_string($response); // If retrieving from an external source, you can use file_get_contents to retrieve the data and populate this variable.
        $json = json_encode($xml); // convert the XML string to JSON
        $array = json_decode($json, TRUE);
        $obj = json_decode($array['vehicleJson'], TRUE);
        if (is_array($obj) && count($obj) > 0) {
            //=======================
            foreach ($obj as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        if ($key == "ExtendedData") {
                            $field_data["$k"] = $v;
                        } else {
                            $field_data["$key"] = $v;
                        }
                    }
                } else {
                    $field_data["$key"] = $val;
                }
            }

            $carMake = '';
            if ($field_data['CarMake'] != '') {
                $carMake = $field_data['CarMake'];
            }
            $carModel = '';
            if ($field_data['CarModel'] != '') {
                $carModel = $field_data['CarModel'];
            }
            /*insert record in db table*/
            foreach ($field_data as $keys => $values) {
                if ($keys == "RegistrationYear" && trim($values) != '') {
                    $result['ad_years'] = checkTermExist($values, 'ad_years', 'ad_years');
                }
                if ($keys == "CarMake" && trim($values) != '') {
                    $result['ad_cats'] = checkTermExist($values, 'ad_cats', 'ad_cats1');
                }
                if ($keys == "CarModel" && trim($values) != '') {
                    $carMaker2 = $carMake;
                    $result['ad_cats2'] = checkTermExist($values, 'ad_cats', 'ad_cats1', $carMaker2);
                }
                if ($keys == "libVersion" && trim($values) != '') {
                    $carMaker3 = $carMake;
                    $carModel3 = $carModel;
                    $result['ad_cats3'] = checkTermExist($values, 'ad_cats', 'ad_cats1', $carMaker3, $carModel3);
                }
                if ($keys == "EngineSize" && trim($values) != '') {
                    $result['ad_engine_capacities'] = checkTermExist($values, 'ad_engine_capacities', 'ad_engine_capacities');
                }
                if ($keys == "FuelType" && trim($values) != '') {
                    $result['ad_engine_types'] = checkTermExist($values, 'ad_engine_types', 'ad_engine_types');
                }
                if ($keys == "BodyStyle" && trim($values) != '') {
                    $result['ad_body_types'] = checkTermExist($values, 'ad_body_types', 'ad_body_types');
                }
                if ($keys == "boiteDeVitesse" && trim($values) != '') {
                    $result['ad_transmissions'] = checkTermExist($values, 'ad_transmissions', 'ad_transmissions');
                }
            }
            return $result;
        }
    }
}

/*check terms and taxonomy exist for 3party API*/
function checkTermExist($term_val = '', $taxo_name = '', $field_type_name = '', $car_make = '', $carModel = '')
{
    $inserted_term_id = '';
    if ($term_val != '' && $taxo_name != '') {
        if ($taxo_name == "ad_cats") {
            /*if we have 2 parameter then parent category add*/
            if ($car_make == '' && $carModel == '') {
                $term_value = term_exists($term_val, $taxo_name);
                if ($term_value == '') {
                    $inserted_term_ids = wp_insert_term($term_val, $taxo_name);
                    return $inserted_term_id = $inserted_term_ids['term_id'];
                } else {
                    return $inserted_term_id = $term_value['term_id'];
                }
            } else if ($car_make != '' && $carModel == '') {
                /*if 1st term exist*/
                $term_value_id_ = term_exists($car_make, $taxo_name);
                $term_value_child_id = term_exists($term_val, $taxo_name);
                if ($term_value_id_['term_id'] != '' && $term_value_child_id == '') {
                    $inserted_term_ids = wp_insert_term($term_val, $taxo_name, array(
                        'parent' => $term_value_id_['term_id'],
                    ));
                    return $inserted_term_id = $inserted_term_ids['term_id'];
                } else {
                    return $inserted_term_id = $term_value_child_id['term_id'];
                }
            } else if ($car_make != '' && $carModel != '') {
                /*if 2nd term exist*/
                $term_valu_id = term_exists($carModel, $taxo_name);
                $term_valu_child_id = term_exists($term_val, $taxo_name);
                if ($term_valu_id['term_id'] != '' && $term_valu_child_id == '') {
                    $inserted_term_ids = wp_insert_term($term_val, $taxo_name, array(
                        'parent' => $term_valu_id['term_id'],
                    ));
                    return $inserted_term_id = $inserted_term_ids['term_id'];
                } else {
                    return $inserted_term_id = $term_valu_child_id['term_id'];
                }
            }
        } else {
            $term_value = term_exists($term_val, $taxo_name);
            if ($term_value == '') {
                $inserted_term_ids = wp_insert_term($term_val, $taxo_name);
                return $inserted_term_id = $inserted_term_ids['term_id'] . "|" . $term_val;
            } else {
                $geting_term_name = get_term_by('id', absint($term_value['term_id']), $taxo_name);
                return $inserted_term_id = $term_value['term_id'] . "|" . $geting_term_name->name;
            }
        }
    }
}

/*ajax call for 3rd party api data geting */
add_action('wp_ajax_get_data_for_liveapi', 'carspot_get_data_for_liveapi');
if (!function_exists('carspot_get_data_for_liveapi')) {

    function carspot_get_data_for_liveapi()
    {
        global $carspot_theme;
        $apiOutput = array();
        $user_login = 'tomberapic';
        $regis_number = $_POST['title'];
        if ($carspot_theme['cs_allow_third_party_api_search'] == true) {
            /*get result from https://www.immatriculationapi.com/ API */
            $url = "https://www.immatriculationapi.com/api/reg.asmx/CheckFrance?RegistrationNumber=$regis_number&username=$user_login";
            $apiOutput = insert_api_record_in_db($url);
            $res = json_encode($apiOutput);
            echo $res;
        }
        die();
    }
}