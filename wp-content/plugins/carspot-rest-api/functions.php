<?php

/**
 * Modify url base from wp-json to 'api'
 */
/* Ads Loop Starts */
add_action('plugins_loaded', 'carspotAPI_add_new_image_size');

function carspotAPI_add_new_image_size()
{
    add_theme_support('post-thumbnails', array('post'));
    add_image_size('carspot-andriod-profile', 450, 450, true);
    add_image_size('carspot-single-post', 760, 410, true);
    add_image_size('carspot-category', 400, 300, true);
    add_image_size('carspot-single-small', 80, 80, true);
    add_image_size('carspot-ad-thumb', 120, 63, true);
    add_image_size('carspot-ad-related', 313, 234, true);
    add_image_size('carspot-user-profile', 300, 300, true);
    //add_image_size( 'carspot-app-thumb', 230, 230, true );
    add_image_size('carspot-app-thumb', 400, 250, true);
    add_image_size('carspot-app-full', 700, 400, true);
}

if (!function_exists('carspotAPI_convert_uniText')) {

    function carspotAPI_convert_uniText($string = '')
    {
        $string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);

        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

}
if (!function_exists('carspotAPI_getReduxValue')) {

    function carspotAPI_getReduxValue($param1 = '', $param2 = '', $vaidate = false)
    {
        global $carspotAPI;
        global $carspot_theme;
        $data = '';
        if ($param1 != "") {
            $data = (isset($carspotAPI["$param1"])) ? $carspotAPI["$param1"] : $carspot_theme["$param1"];

        }
        if ($param1 != "" && $param2 != "") {
            $data = (isset($carspotAPI["$param1"]["$param2"])) ? $carspotAPI["$param1"]["$param2"] : $carspot_theme["$param1"]["$param2"];
            
        }

        if ($vaidate == true) {
            $data = (isset($data) && $data != "") ? 1 : 0;
        }

        return $data;
    }

}


if (!function_exists('carspotAPI_appLogo')) {

    function carspotAPI_appLogo()
    {
        global $carspotAPI;
        $defaultLogo = CARSPOT_API_PLUGIN_URL . "images/logo.png";
        $app_logo = (isset($carspotAPI['app_logo'])) ? $carspotAPI['app_logo']['url'] : $defaultLogo;

        return $app_logo;
    }

}

if (!function_exists('carspotAPI_get_authors_notIn_list')) {

    function carspotAPI_get_authors_notIn_list($user_id = '')
    {
        global $carspotAPI;

        $allow_block = (isset($carspotAPI['sb_user_allow_block']) && $carspotAPI['sb_user_allow_block']) ? true : false;
        $author_not_in = array();
        if ($allow_block) {
            $get_current_user_id = ($user_id != "") ? $user_id : get_current_user_id();
            if ($get_current_user_id) {
                $blocked = get_user_meta($get_current_user_id, '_sb_carspot_block_users', true);
                if (isset($blocked) && count((array)$blocked) > 0) {
                    $author_not_in = $blocked;
                }
            }
        }
        return $author_not_in;
    }

}

if (!function_exists('carspotAPI_adsLoop')) {

    function carspotAPI_adsLoop($args, $userid = '', $is_profile = false, $is_fav = false, $is_pagination = false)
    {
        $adsArr = array();
        global $carspot_theme;
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $ad_id = get_the_ID();
                $postAuthor = get_the_author_meta('ID');
                if ($is_fav == false) {
                    if ($userid != "" && $postAuthor != $userid) {
                        continue;
                    }
                }
                /* Get Categories */
                $cats = carspotAPI_get_ad_terms($ad_id, 'ad_cats');
                $cats_name = carspotAPI_get_ad_terms_names($ad_id, 'ad_cats');
                /* Get Image */
                $thumb_img = '';
                $thumb_img = carspotAPI_get_ad_image($ad_id, 1, 'thumb');
                /* Strip tags and limit ad description */
                $words = wp_trim_words(strip_tags(get_the_content()), 3, '...');

                $location = carspotAPI_get_adAddress($ad_id);
                $milage_unit = isset($carspot_theme['sb_distance_unit']) ? $carspot_theme['sb_distance_unit'] : 'KM';
                $price = get_post_meta($ad_id, "_carspot_ad_price", true);
                $engine = get_post_meta($ad_id, '_carspot_ad_engine_types', true);
                $milage = get_post_meta($ad_id, '_carspot_ad_mileage', true) . " " . __($milage_unit, "carspot-rest-api");
                $ad_count = get_post_meta($ad_id, "sb_post_views_count", true);

                $priceFinal = carspotAPI_get_price($price, $ad_id);
                $ad_status = carspotAPI_adStatus($ad_id);


                $adsArr[] = array
                (
                    "ad_author_id" => $postAuthor,
                    "ad_id" => $ad_id,
                    "ad_date" => get_the_date("", $ad_id),
                    "ad_time" => get_the_time( '', $ad_id ),
                    "ad_title" => carspotAPI_convert_uniText(get_the_title()),
                    "ad_desc" => $words,
                    "ad_status" => $ad_status,
                    "ad_cats_name" => $cats_name,
                    "ad_cats" => $cats,
                    "ad_images" => $thumb_img,
                    "ad_location" => $location,
                    "ad_price" => $priceFinal,
                    "ad_engine" => $engine,
                    "ad_milage" => $milage,
                    "ad_views" => $ad_count,
                    "ad_video" => carspotAPI_get_adVideo($ad_id),
                    "ad_timer" => carspotAPI_get_adTimer($ad_id),
                    "ad_saved" => array("is_saved" => 0, "text" => __("Save Ad", "carspot-rest-api")),
                );
            }
            wp_reset_postdata();
        }
        if ($is_pagination == false) {
            return $adsArr;
        } else {
            return array(
                "ads" => $adsArr,
                "found_posts" => $the_query->found_posts,
                "max_num_pages" => $the_query->max_num_pages
            );
        }
    }

}


if (!function_exists('carspotAPI_get_adTimer')) {

    function carspotAPI_get_adTimer($ad_id = '')
    {

        $ad_bidding_time = get_post_meta($ad_id, '_carspot_ad_bidding_date', true);
        $myData = strtotime($ad_bidding_time);
        $current_data = strtotime(get_gmt_from_date('UTC', $format = 'Y-m-d H:i:s'));
        $differenceInSeconds = $myData - $current_data;
        $is_show = true;
        if ($myData <= $current_data && $ad_bidding_time == "") {
            $is_show = false;
            $timer['is_show'] = $is_show;
            $timer['timer'] = ''; /* Mili-seconds */
        } else {
            $timer['is_show'] = $is_show;
            $timer['timer'] = convert_seconds($differenceInSeconds); /* Mili-seconds */
        }

        return $timer;
    }

}

function convert_seconds($seconds)
{
    $dt1 = new DateTime("@0");
    $dt2 = new DateTime("@$seconds");
    $final_date = $dt1->diff($dt2)->format("%a,%h,%i,%s");

    return explode(",", $final_date);
}

/* Ads Loop Ends */
/* Ads Statuses Starts */
if (!function_exists('carspotAPI_adStatus')) {

    function carspotAPI_adStatus($ad_id = '')
    {

        $isFretured = get_post_meta($ad_id, "_carspot_is_feature", true);
        $ad_status = get_post_meta($ad_id, "_carspot_ad_status_", true);

        $feature_text = ($isFretured == 1) ? __("Featured", "carspot-rest-api") : '';

        $status_text = '';
        if ($ad_status == 'active') {
            $status_text = __("Active", "carspot-rest-api");
        } else if ($ad_status == 'expired') {
            $status_text = __("Expired", "carspot-rest-api");
        } else if ($ad_status == 'sold') {
            $status_text = __("Sold", "carspot-rest-api");
        }


        $ad_status = array(
            "status" => $ad_status,
            "status_text" => $status_text,
            "featured_type" => $isFretured,
            "featured_type_text" => $feature_text,
        );

        return $ad_status;
    }

}

/* Related Ads Starts */
if (!function_exists('carspotApi_related_ads')) {

    function carspotApi_related_ads($ad_id = '', $limit = 5)
    {
        $cats = wp_get_post_terms($ad_id, 'ad_cats');
        $categories = array();
        foreach ($cats as $cat) {
            $categories[] = $cat->term_id;
        }

        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $limit,
            'order' => 'DESC',
            'orderby' => 'date',
            'post__not_in' => array($ad_id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'id',
                    'terms' => $categories,
                    'operator' => 'IN'
                )
            )
        );
        $args = cs_wpml_show_all_posts_callback_rest_api($args);

        return carspotAPI_adsLoop($args);
    }

}
/* Related Ads Ends */


/* Category Specific Ads Starts */
if (!function_exists('carspotApi_catSpecific_ads')) {

    function carspotApi_catSpecific_ads($cat_id = '', $limit = 5)
    {

        $author_not_in = carspotAPI_get_authors_notIn_list();

        $categories = array($cat_id);
        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $limit,
            'order' => 'DESC',
            'orderby' => 'date',
            'author__not_in' => $author_not_in,
            /* 'post__not_in'	=> array( $ad_id ), */
            'tax_query' => array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'id',
                    'terms' => $categories,
                    'operator' => 'IN'
                )
            )
        );
        $args = cs_wpml_show_all_posts_callback_rest_api($args);
        return carspotAPI_adsLoop($args);
    }

}
/* Category Specific Ads Ends */


if (!function_exists('carspotAPI_get_ad_terms')) {

    function carspotAPI_get_ad_terms($post_id = '', $term_type = 'ad_cats', $only_parent = '', $name = '')
    {
        $ad_trms = wp_get_object_terms($post_id, $term_type);
        $termsArr = array();
        if (count((array)$ad_trms)) {
            foreach ($ad_trms as $ad_trm) {
                if (isset($ad_trm->term_id) && $ad_trm->term_id != "") {
                    $termsArr[] = array
                    (
                        "id" => $ad_trm->term_id,
                        "name" => htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES),
                        "slug" => $ad_trm->slug,
                        "count" => $ad_trm->count,
                        "taxonomy" => $ad_trm->taxonomy,
                    );
                }
            }
        }

        return ($name == "") ? $termsArr : array($name, $termsArr);
    }

}


if (!function_exists('carspotAPI_get_ad_terms_names')) {

    function carspotAPI_get_ad_terms_names($post_id = '', $term_type = 'ad_cats', $only_parent = '', $name = '', $separator = '>')
    {

        $terms = wp_get_post_terms($post_id, $term_type, array('orderby' => 'id', 'order' => 'DESC'));
        $deepestTerm = false;
        $maxDepth = -1;
        $c = 0;
        $catNames = array();
        if (count($terms) > 0) {
            foreach ($terms as $term) {
                $ancestors = get_ancestors($term->term_id, $term_type);
                $termDepth = count($ancestors);
                $deepestTerm[$c] = $term->name;
                $maxDepth = $termDepth;
                $c++;
            }
            $terms = (isset($deepestTerm) && count($deepestTerm) > 0 && $term_type != 'ad_tags') ? array_reverse($deepestTerm) : $deepestTerm;
            if (count($terms) > 0) {
                foreach ($terms as $tr) {
                    $trName = htmlspecialchars_decode($tr, ENT_NOQUOTES);
                    $catNames[] = $trName;
                }
            }
        }
        $catNames = @implode(" $separator ", $catNames);

        return ($name == "") ? $catNames : array($name, $catNames);
    }

}

if (!function_exists('carspotAPI_terms_seprates_by')) {

    function carspotAPI_terms_seprates_by($post_id, $taxonomy = 'ad_cats', $separator = '')
    {

        $terms = wp_get_post_terms($post_id, $taxonomy, array('orderby' => 'id', 'order' => 'DESC'));
        $deepestTerm = false;
        $maxDepth = -1;
        $c = 0;
        foreach ($terms as $term) {
            $ancestors = get_ancestors($term->term_id, $taxonomy);
            $termDepth = count($ancestors);
            $deepestTerm[$c] = $term->name;
            $maxDepth = $termDepth;
            $c++;
        }
        $terms = array_reverse($deepestTerm);
        $string = '';
        if (count($terms) > 0) {
            foreach ($terms as $tr) {
                $trName = htmlspecialchars_decode($tr, ENT_NOQUOTES);
                $string .= $trName . $separator;
            }
        }
        $string = rtrim($string, $separator);

        return $string;
    }

}

if (!function_exists('carspotAPI_listing_adSize')) {

    function carspotAPI_listing_adSize($thumbnail = '', $thumbFor = '')
    {
        if ($thumbnail != "") {
            return $thumbnail;
        }
        global $carspotAPI;
        if ($thumbFor == 'listing') {
            $images_sizes = (isset($carspotAPI['ads_images_sizes']) && $carspotAPI['ads_images_sizes'] != "") ? $carspotAPI['ads_images_sizes'] : 'default';
            if ($images_sizes == 'default') {
                $thumbnail = 'carspot-app-thumb';
            } else if ($images_sizes == 'size2') {
                $thumbnail = 'carspot-category';
            } else if ($images_sizes == 'size3') {
                $thumbnail = 'carspot-ad-related';
            } else if ($images_sizes == 'size4') {
                $thumbnail = 'carspot-app-thumb';
            } else if ($images_sizes == 'size5') {
                $thumbnail = 'carspot-app-full';
            }

            return $thumbnail;
        }
        if ($thumbFor == 'ad_detail') {
            $images_sizes = (isset($carspotAPI['ads_images_sizes_adDetils']) && $carspotAPI['ads_images_sizes_adDetils'] != "") ? $carspotAPI['ads_images_sizes_adDetils'] : 'default';

            if ($images_sizes == 'default') {
                $thumbnail = 'carspot-app-full';
            } else if ($images_sizes == 'size2') {
                $thumbnail = 'carspot-single-post';
            }

            return $thumbnail;
        }
    }

}
/*
 * get ad videos
 */
if (!function_exists('carspotAPI_get_ad_videos_')) {

    function carspotAPI_get_ad_videos_($post_id = '', $numOf = '')
    {
        $media = get_post_meta($post_id, 'carspot_video_uploaded_attachment_', true);
        if ($media != "") {
            $reslt = explode(',', $media);
        } else {
            global $wpdb;
            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $post_id . "'";
            $results = $wpdb->get_results($query, OBJECT);
            $reslt = $results;
        }
        if (count($reslt) > 0 && is_array($reslt)) {
            foreach ($reslt as $vid_ids) {
                $upload_video_[] = array(
                    "type" => "uploaded_video",
                    "uploaded_video_url" => wp_get_attachment_url($vid_ids),
                    "video_name" => get_the_title($vid_ids),
                    "video_id" => $vid_ids
                );
            }
        } else {
            $upload_video_ = array();
        }

        return $upload_video_;
    }

}


/*
 * get ad pdf brochure
 */
if (!function_exists('carspotAPI_get_ad_brochure')) {

    function carspotAPI_get_ad_brochure($post_id = '', $numOf = '')
    {
        $media = $brochure_arr = array();
        $media = get_post_meta($post_id, 'carspot_pdf_brochure_arrangement_', true);
        if ($media != "") {
            $reslt = explode(',', $media);
        } else {
            global $wpdb;
            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $post_id . "'";
            $results = $wpdb->get_results($query, OBJECT);
            $reslt = $results;
        }
        if (count($reslt) > 0 && is_array($reslt)) {
            foreach ($reslt as $m) {
                if (isset($m) && $m != '') {
                    $brochure_url_path = (wp_get_attachment_url($m));
                    $brochure_arr[] = array(
                        'brochure_url' => $brochure_url_path,
                        "pdf_brochure_id" => $m,
                        "brochure_name" => get_the_title($m),
                        "mesage" => ''
                    );
                }
            }
        } else {
            $brochure_arr = array();
        }

        return $brochure_arr;
    }

}

/*
 * get ad images
 */
if (!function_exists('carspotAPI_get_ad_image')) {

    function carspotAPI_get_ad_image($post_id = '', $numOf = '', $size = 'both', $show_default = true)
    {
        $media = array();
        $media = carspot_fetch_listing_gallery($post_id);
        $img_arr = array();
        if (count($media) > 0) {
            $re_order = get_post_meta($post_id, 'carspot_photo_arrangement_', true);
            if ($re_order != "") {
                $media = explode(",", $re_order);
            }
            $c = 1;
            $getThumbnailListing = carspotAPI_listing_adSize('', 'listing');
            $getThumbnailAdDetail = carspotAPI_listing_adSize('', 'ad_detail');
            foreach ($media as $m) {
                $mid = (isset($m->ID)) ? $m->ID : $m;
                if ($mid != '') {
                    $img = wp_get_attachment_image_src($mid, $getThumbnailListing);
                    $full_img = wp_get_attachment_image_src($mid, 'full');
                    if (isset($img[0]) && isset($full_img[0])) {
                        if ($size == 'full') {
                            $img_arr[] = array('full' => $full_img[0], "img_id" => $mid);
                        } else if ($size == 'thumb') {
                            $img_arr[] = array('thumb' => $img[0], "img_id" => $mid);
                        } else {
                            $img_arr[] = array('full' => $full_img[0], 'thumb' => $img[0], "img_id" => $mid);
                        }
                    } else {
                        $img_arr[] = CARSPOT_API_PLUGIN_URL . "images/default-img.png";
                    }
                }
            }
        } else {
            if ($show_default == true) {
                /* Need to add images from backend *********** */
                global $carspotAPI;
                $default_img = CARSPOT_API_PLUGIN_URL . "images/default-img.png";
                $default_img = (isset($carspotAPI['default_related_image'])) ? $carspotAPI['default_related_image']['url'] : $default_img;

                $full_img = $default_img;
                $thumb_img = $default_img;
                if ($size == 'full') {
                    $img_arr[] = array('full' => $full_img);
                } else if ($size == 'thumb') {
                    $img_arr[] = array('thumb' => $thumb_img);
                } else {
                    $img_arr[] = array('full' => $full_img, 'thumb' => $thumb_img);
                }
            } else {
                $img_arr = array();
            }
        }

        return $img_arr;
    }

}

if (!function_exists('carspotAPI_get_ad_image_slider')) {

    function carspotAPI_get_ad_image_slider($post_id = '')
    {
        $media = get_attached_media('image', $post_id);
        $img_arr = array();
        if (count($media) > 0) {
            $re_order = get_post_meta($post_id, 'carspot_photo_arrangement_', true);
            if ($re_order != "") {
                $media = explode(",", $re_order);
            }
            foreach ($media as $m) {
                $mid = (isset($m->ID)) ? $m->ID : $m;
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (isset($full_img[0])) {
                    $img_arr[] = $full_img[0];
                }
            }
        }

        return $img_arr;
    }

}


if (!function_exists('carspotAPI_get_price')) {

    function carspotAPI_get_price($price = '', $ad_id = '', $ad_currency_id = '')
    {

        $price_type = $ad_currency = $price_typeValue = '';
        if ($ad_id != "") {
            $price_type = get_post_meta($ad_id, '_carspot_ad_price_type', true);

            $price = get_post_meta($ad_id, '_carspot_ad_price', true);
          

            $ad_currency = get_post_meta($ad_id, '_carspot_ad_currency', true);


            $price_typeValue = ($price_type) ? carspotAPI_adPrice_typesValue($price_type) : '';
             

            if ($price == "" && $price_type == "on_call") {
                $priceData = __("Price On Call", 'carspot-rest-api');

                return array("price" => $priceData, "price_type" => $price_typeValue);
            }
            if ($price == "" && $price_type == "free") {
                $priceData = __("Free", 'carspot-rest-api');

                return array("price" => $priceData, "price_type" => $price_typeValue);
            }

            if ($price == "" || $price_type == "no_price") {
                $priceData = '';

                return array("price" => $priceData, "price_type" => $price_typeValue);
            }
        }

        if ($ad_currency_id != "") {
            $ad_currency = get_post_meta($ad_currency_id, '_carspot_ad_currency', true);
           
        }
        /* Get Direction */
        $position = 'left';
        if (carspotAPI_getReduxValue('sb_price_direction', '', true)) {
            $position = carspotAPI_getReduxValue('sb_price_direction', '', false);
          // 
        }
        /* Get Symbol */
        $symbol = carspotAPI_getReduxValue('sb_currency', '', false);





        if ($ad_currency != "") {
            $symbol = $ad_currency;

        }
        /* Get And Set Price Formate */
        $thousands_sep = ",";
        if (carspotAPI_getReduxValue('sb_price_separator', '', true)) {
            $thousands_sep = carspotAPI_getReduxValue('sb_price_separator', '', false);

        }
        $decimals = 0;
        if (carspotAPI_getReduxValue('sb_price_decimals', '', true)) {
            $decimals = carspotAPI_getReduxValue('sb_price_decimals', '', false);
         
        }
        $decimals_separator = ".";
        if (carspotAPI_getReduxValue('sb_price_decimals_separator', '', true)) {
            $decimals_separator = carspotAPI_getReduxValue('sb_price_decimals_separator', '', false);
            
        }
        $price = @number_format($price, $decimals, $decimals_separator, $thousands_sep);
        $price = (isset($price) && $price != "") ? $price : 0;
        
       
        /* Get And Set Price Formate  Ends */

        $pos = ($position != 'left') ? $price . ' ' . $symbol : $symbol . ' ' . $price;
       

        return array("price" => $pos, "price_type" => $price_typeValue);
    }

}

if (!function_exists('carspotAPI_get_adPrice')) {

    function carspotAPI_get_adPrice($ad_id = '', $symbol = '$')
    {
        $arr = array();
        $ad_price = get_post_meta($ad_id, '_carspot_ad_price', true);
        $price_type = get_post_meta($ad_id, '_carspot_ad_price_type', true);

        $price_typeValue = ($price_type) ? carspotAPI_adPrice_typesValue($price_type) : '';

        /* $symbol = "$"; */
        $symbol = carspotAPI_getReduxValue('sb_currency', '', false);
        $ad_currency = get_post_meta($ad_id, '_carspot_ad_currency', true);
        if ($ad_currency != "") {
            $symbol = $ad_currency;
        }

        $arr = array("price" => $ad_price, "type" => $price_typeValue, "symbol" => $symbol);

        return $arr;
    }

}


if (!function_exists('carspotAPI_get_adAddress')) {

    function carspotAPI_get_adAddress($ad_id = '')
    {
        $location_arr = array();
        $poster_location = get_post_meta($ad_id, '_carspot_ad_map_location', true);
        $map_lat = get_post_meta($ad_id, '_carspot_ad_map_lat', true);
        $map_long = get_post_meta($ad_id, '_carspot_ad_map_long', true);
        $map_lat = (is_float($map_lat) || is_numeric($map_lat)) ? $map_lat : '';
        $map_long = (is_float($map_long) || is_numeric($map_long)) ? $map_long : '';
        $ad_locs = wp_get_object_terms($ad_id, 'ad_country', array('fields' => 'names'));
        if (isset($ad_locs) && count($ad_locs) > 0) {
            $poster_location = implode(", ", $ad_locs);
        }
        $location_arr = array(
            "title" => __("Location", "carspot-rest-api"),
            "address" => $poster_location,
            "lat" => $map_lat,
            "long" => $map_long
        );

        return $location_arr;
    }

}

if (!function_exists('carspotAPI_get_adVideo')) {

    function carspotAPI_get_adVideo($ad_id = '')
    {
        $vid_arr = array();
        $ad_video = get_post_meta($ad_id, '_carspot_ad_yvideo', true);
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ad_video, $match);
        $vID = (isset($match[1]) && $match[1] != "") ? $match[1] : '';
        $vid_arr = array("video_url" => $ad_video, "video_id" => $vID);

        return $vid_arr;
    }

}

/* Custom Fields Starts */
if (!function_exists('carspotAPI_get_customFields')) {

    function carspotAPI_get_customFields($ad_id = '')
    {
        $result = carspotAPI_categoryForm_data($ad_id);
        //Static Iteams starts

        $type = sb_custom_form_data($result, '_sb_default_cat_ad_type_show');
        $price = sb_custom_form_data($result, '_sb_default_cat_price_show');
        $priceType = sb_custom_form_data($result, '_sb_default_cat_price_type_show');

        $condition = sb_custom_form_data($result, '_sb_default_cat_condition_show');
        $warranty = sb_custom_form_data($result, '_sb_default_cat_warranty_show');

        $dynamicData = array();

        $ad_cats = carspotAPI_get_ad_terms_names($ad_id, 'ad_cats', '', '', $separator = ',');
        //carspotAPI_terms_seprates_by($ad_id , 'ad_cats',  ', ');

        $dynamicData[] = array("key" => __("Category", "carspot-rest-api"), "value" => $ad_cats, "type" => '');
        $dynamicData[] = array(
            "key" => __("Date", "carspot-rest-api"),
            "value" => get_the_date("", $ad_id),
            "type" => ''
        );
        $dynamicData[] = array(
            "key" => __("Mileage", "carspot-rest-api"),
            "value" => carspot_numberFormat($ad_id),
            "type" => ''
        );


        $taxonomy_objects = get_object_taxonomies('ad_post', 'objects');
        $countNum = 0;
        foreach ($taxonomy_objects as $taxonomy_object) {
            if ('ad_cats' == $taxonomy_object->name) {
                continue;
            }
            if ('sb_dynamic_form_templates' == $taxonomy_object->name) {
                continue;
            }
            if ('ad_tags' == $taxonomy_object->name) {
                continue;
            }
            if ('ad_country' == $taxonomy_object->name) {
                continue;
            }
            if ('ad_features' == $taxonomy_object->name) {
                continue;
            }

            $custom_val = get_post_meta($ad_id, '_carspot_' . $taxonomy_object->name, true);
            if ($custom_val != "") {
                $dynamicData[] = array(
                    "key" => esc_html__($taxonomy_object->label,'carspot-rest-api'),
                    "value" => esc_html__($custom_val,'carspot-rest-api'),
                    "type" => ''
                );
            }
        }
        //Dynamic Cats
        $formData = sb_dynamic_form_data($result);
        if (count($formData) > 0) {

            foreach ($formData as $data) {
                if ($data['titles'] != "") {
                    $values = get_post_meta($ad_id, "_carspot_tpl_field_" . $data['slugs'], true);
                    $value = json_decode($values);
                    $value = (is_array($value)) ? implode($value, ", ") : $values;

                    $titles = ($data['titles']);
                    $status = ($data['status']);
                    if ($value != "" && $status == 1) {
                        $type = 'textfield';
                        if ($data['types'] == '1') {
                            $type = 'textfield';
                        }
                        if ($data['types'] == '2') {
                            $type = 'select';
                        }
                        if ($data['types'] == '3') {
                            $type = 'checkbox';
                        }
                        $dynamicData[] = array(
                            "key" => esc_html($titles),
                            "value" => esc_html($value),
                            "type" => $type
                        );
                    }
                }
            }
        }


        global $wpdb;
        $rows = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND meta_key LIKE '_sb_extra_%'");
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $caption = explode('_', $row->meta_key);

                $name = ucfirst($caption[3]);
                if ($row->meta_value == "") {
                    continue;
                }
                $dynamicData[] = array(
                    "key" => esc_html($name),
                    "value" => esc_html($row->meta_value),
                    "type" => ''
                );
            }
        }

        return ($dynamicData);
    }

}

if (!function_exists('carspot_randomString')) {

    function carspot_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }

}


// Get user profile PIC
if (!function_exists('carspotAPI_user_dp')) {

    function carspotAPI_user_dp($user_id, $size = 'carspot-andriod-profile')
    {

        $user_pic = CARSPOT_API_PLUGIN_URL . "images/user.jpg";
        if (carspotAPI_getReduxValue('sb_user_dp', 'url', true)) {
            $user_pic = carspotAPI_getReduxValue('sb_user_dp', 'url', false);
        }

        $image_link = array();
        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
            if ($attach_id) {
                $image_link = wp_get_attachment_image_src($attach_id, $size);
            }
        }

        return (isset($image_link) && !empty($image_link) && $image_link != "") ? $image_link[0] : $user_pic;
    }

}


if (!function_exists('carspotAPI_check_username')) {

    function carspotAPI_check_username($username = '')
    {
        if (username_exists($username)) {
            $random = rand();
            $username = $username . '-' . $random;
            carspotAPI_check_username($username);
        }

        return $username;
    }

}

/* User ads starts */
if (!function_exists('carspotApi_userAds')) {

    function carspotApi_userAds($userid = '', $status = '', $adType = '', $limit = 1, $adStatus = 'publish', $other = '')
    {
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (isset($limit)) {
            $paged = $limit;
        } else {
            $paged = 1;
        }
        $adType = ($adType != "") ? array(
            'key' => '_carspot_is_feature',
            'value' => $adType,
            'compare' => '='
        ) : array();
        $status = ($status != "") ? array(
            'key' => '_carspot_ad_status_',
            'value' => $status,
            'compare' => '='
        ) : array();


        $lat_lng_meta_query = array();
        if ($other == 'near_me') {

            $lats_longs = carspotAPI_determine_minMax_latLong();
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


        $posts_per_page = get_option('posts_per_page');
        if ($userid != "") {
            $args = array(
                'author' => $userid,
                'post_type' => 'ad_post',
                'post_status' => $adStatus,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'order' => 'DESC',
                'orderby' => 'date',
                'meta_query' => array($status, $adType, $lat_lng_meta_query),
            );
        } else {
            $args = array(
                'post_type' => 'ad_post',
                'post_status' => $adStatus,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'order' => 'DESC',
                'orderby' => 'date',
                'meta_query' => array($status, $adType, $lat_lng_meta_query),
            );
        }
        $args = cs_wpml_show_all_posts_callback_rest_api($args);

        $ad_data = carspotAPI_adsLoop($args, $userid, true, false, true);

        $found_posts = $ad_data['found_posts'];
        $max_num_pages = $ad_data['max_num_pages'];

        $nextPaged = $paged + 1;
        $has_next_page = ($nextPaged <= (int)$max_num_pages) ? true : false;
        $adData = array();
        $adData['ads'] = $ad_data['ads'];
        $count_ads = count($ad_data['ads']);
        if ($count_ads == 0) {
            $adData['has_list'] = false;
            $adData['msg'] = __("No ads found", "carspot-rest-api");
        } else {
            $adData['has_list'] = true;
        }
        $adData['pagination'] = array(
            "max_num_pages" => (int)$max_num_pages,
            "current_page" => (int)$paged,
            "next_page" => (int)$nextPaged,
            "increment" => (int)$posts_per_page,
            "current_no_of_ads" => (int)$found_posts,
            "has_next_page" => $has_next_page
        );

        return $adData;
    }

}
/* User ads starts */


/* User ads starts */
if (!function_exists('carspotApi_userAds_fav')) {

    function carspotApi_userAds_fav($userid = '', $status = '', $adType = '', $limit = 1, $adStatus = 'publish')
    {
        $adType = ($adType != "") ? array(
            'key' => '_carspot_is_feature',
            'value' => $adType,
            'compare' => '='
        ) : array();
        $status = ($status != "") ? array(
            'key' => '_carspot_ad_status_',
            'value' => $status,
            'compare' => '='
        ) : array();

        global $wpdb;
        $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$userid' AND meta_key LIKE '_sb_fav_id_%'");


        $pids = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $pids[] = (int)$row->meta_value;
            }
        } else {
            $pids = array(0);
        }

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (isset($limit)) {
            $paged = $limit;
        } else {
            $paged = 1;
        }

        $posts_per_page = get_option('posts_per_page');
        $args = array(
            'post__in' => $pids,
            'post_type' => 'ad_post',
            'post_status' => $adStatus,
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date',
        );

        $args = cs_wpml_show_all_posts_callback_rest_api($args);
        $ad_data = carspotAPI_adsLoop($args, $userid, true, true, true);


        $found_posts = $ad_data['found_posts'];
        $max_num_pages = $ad_data['max_num_pages'];
        $nextPaged = $paged + 1;
        $has_next_page = ($nextPaged <= (int)$max_num_pages) ? true : false;
        $adData = array();
        $adData['ads'] = $ad_data['ads'];
        $count_ads = count($ad_data['ads']);
        if ($count_ads == 0) {
            $adData['has_list'] = false;
            $adData['msg'] = __("No ads found", "carspot-rest-api");
        } else {
            $adData['has_list'] = true;
        }
        $adData['pagination'] = array(
            "max_num_pages" => (int)$max_num_pages,
            "current_page" => (int)$paged,
            "next_page" => (int)$nextPaged,
            "increment" => (int)$posts_per_page,
            "current_no_of_ads" => (int)$found_posts,
            "has_next_page" => $has_next_page
        );

        return $adData;
    }

}
/* User ads starts */


/* featured ad slider starts */
if (!function_exists('carspotApi_featuredAds_slider')) {

    function carspotApi_featuredAds_slider($userid = '', $status = '', $adType = '', $limit = -1, $term_id = '', $adStatus = 'publish', $other = '', $only_simple = '')
    {
        if ($only_simple != "" && $only_simple == 'only_simple' && $status == 'active') {
            $adType = array('key' => '_carspot_is_feature', 'value' => 0, 'compare' => '=');
        } else {
            $adType = ($adType != "") ? array(
                'key' => '_carspot_is_feature',
                'value' => $adType,
                'compare' => '='
            ) : array();
        }
        $status = ($status != "") ? array(
            'key' => '_carspot_ad_status_',
            'value' => $status,
            'compare' => '='
        ) : array();

        $lat_lng_meta_query = array();
        if ($other == 'nearby') {
            $lats_longs = carspotAPI_determine_minMax_latLong();
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
            } else {

                return array();
            }
        }

        $category = '';
        if ($term_id != "") {

            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => $term_id,
                ),
            );
        }

        $author_not_in = carspotAPI_get_authors_notIn_list();

        $args = array(
            'post_type' => 'ad_post',
            'post_status' => $adStatus,
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array($category),
            'meta_query' => array($status, $adType, $lat_lng_meta_query),
            'author__not_in' => $author_not_in,
        );
        $args = cs_wpml_show_all_posts_callback_rest_api($args);
        return carspotAPI_adsLoop($args, $userid, true);
    }

}
/* featured ad slider  starts */

/* site ads starts */
if (!function_exists('carspotApi_siteAds')) {

    function carspotApi_siteAds($userid = '', $status = '', $adType = '', $limit = -1, $adStatus = 'publish')
    {

        $adType = ($adType != "") ? array(
            'key' => '_carspot_is_feature',
            'value' => $adType,
            'compare' => '='
        ) : array();
        $status = ($status != "") ? array(
            'key' => '_carspot_ad_status_',
            'value' => $status,
            'compare' => '='
        ) : array();

        $args = array(
            'post_type' => 'ad_post',
            'post_status' => $adStatus,
            'posts_per_page' => $limit,
            'order' => 'DESC',
            'orderby' => 'date',
            'meta_query' => array($status, $adType),
        );
        $args = cs_wpml_show_all_posts_callback_rest_api($args);
        return carspotAPI_adsLoop($args, $userid, true);
    }

}
/* site ads starts */

add_action('rest_api_init', 'add_thumbnail_to_JSON');

function add_thumbnail_to_JSON()
{
    register_rest_field('post',
        'featured_image_src', array(
            'get_callback' => 'get_image_src',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

function get_image_src($object, $field_name, $request)
{
    $feat_img_array = wp_get_attachment_image_src($object['featured_media'], 'carspot-single-post', true);

    return $feat_img_array[0];
}

add_action('rest_api_init', 'add_post_comment_count');

function add_post_comment_count()
{
    register_rest_field('post', 'post_comment_count', array(
            'get_callback' => 'add_post_comment_count_func',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

function add_post_comment_count_func($object, $field_name, $request)
{

    return 100;
}

/* Get login time */
if (!function_exists('carspotAPI_getLastLogin')) {

    function carspotAPI_getLastLogin($uid, $show_text = false)
    {
        $from = get_user_meta($uid, '_sb_last_login', true);
        if ($from != "") {
            /* DO Somethings */
        } else {
            $from = time();
        }
        $showText = ($show_text) ? __("Last Login:", "carspot-rest-api") : '';

        return $showText . ' ' . human_time_diff($from, time());
    }

}


/* Input */
if (!function_exists('carspotAPI_get_ad_terms_names_vals')) {

    function carspotAPI_get_ad_terms_names_vals($term_type = 'ad_cats', $only_parent = 0, $name = '', $placeholder = '')
    {
        $terms = get_terms(array('taxonomy' => $term_type, 'hide_empty' => false, 'parent' => $only_parent,));
        $termsArr = array();
        $catNames = '';
        $catIDS = '';
        $values = '';
        if (count($terms)) {
            foreach ($terms as $ad_trm) {
                $catIDS[] = $ad_trm->term_id;
                $catNames[] = htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES);
            }
        }

        return $arr = array("ids" => $catIDS, "names" => $catNames, "title" => $name, "placeholder" => $placeholder);
    }

}
if (!function_exists('carspotAPI_get_search_inputs')) {

    function carspotAPI_get_search_inputs($title = '', $placeholder = '')
    {
        return $arr = array("title" => $title, "placeholder" => $placeholder);
    }

}


if (!function_exists('carspotAPI_getSubCats')) {

    function carspotAPI_getSubCats($field_type = '', $field_type_name = '', $term_type = 'ad_cats', $only_parent = 0, $name = '', $mainTitle = '', $show_count = true)
    {
        global $carspotAPI;
        $hasShow_template = false;
        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true && $term_type == "ad_cats") {
            $hasShow_template = true;
        }

        $terms = get_terms(array('taxonomy' => $term_type, 'hide_empty' => false, 'parent' => $only_parent,));
        $termsArr = array();
        $values = '';
        if (count($terms) > 0) {
            foreach ($terms as $ad_trm) {

                $term_children = get_term_children(filter_var($ad_trm->term_id, FILTER_VALIDATE_INT), filter_var($term_type, FILTER_SANITIZE_STRING));
                $has_sub = (empty($term_children) || is_wp_error($term_children)) ? false : true;

                $result = carspot_dynamic_templateID($ad_trm->term_id);
                $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);
                $has_template = (isset($templateID) && $templateID != "") ? true : false;
                if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true && $term_type == "ad_cats") {
                    $has_template = true;
                }
                if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
                    $has_template = false;
                }
                $counts = ($show_count == true) ? ' (' . $ad_trm->count . ')' : "";

                $termsArr[] = array
                (
                    "id" => $ad_trm->term_id,
                    "name" => htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES) . $counts,
                    "has_sub" => $has_sub,
                    "has_template" => $has_template,
                );
            }

            $values = $termsArr;
        }

        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
            $has_template = false;
        }

        return array(
            "main_title" => $mainTitle,
            "field_type" => $field_type,
            "field_type_name" => $field_type_name,
            "field_val" => "",
            "field_name" => "",
            "title" => $name,
            "values" => $values,
            "has_cat_template" => $has_template
        );
    }

}


if (!function_exists('carspotAPI_is_multiArr')) {

    function carspotAPI_is_multiArr($a)
    {
        $rv = array_filter($a, 'is_array');
        if (count($rv) > 0) {
            return true;
        }

        return false;
    }

}


add_action('rest_api_init', 'carspotAPI_some_test', 0);

function carspotAPI_some_test()
{

    register_rest_route(
        'carspot/v1', '/sometest/', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'carspotAPI_adPrice_types',
            'permission_callback' => function () {
                return carspotAPI_basic_auth();
            },
        )
    );
}

if (!function_exists('carspotAPI_adPrice_typesValue')) {

    function carspotAPI_adPrice_typesValue($selectVal = '')
    {
        $array = array();
        $priceTypes = array(
            'Fixed' => __('Fixed', 'carspot-rest-api'),
            '',
            'Negotiable' => __('Negotiable', 'carspot-rest-api'),
            'on_call' => __('Price on call', 'carspot-rest-api'),
            'auction' => __('Auction', 'carspot-rest-api'),
            'free' => __('Free', 'carspot-rest-api'),
            'no_price' => __('No price', 'carspot-rest-api'),
        );
        $returnValue = (isset($priceTypes[$selectVal]) && $priceTypes[$selectVal] != "") ? $priceTypes[$selectVal] : '';

        return $returnValue;
    }

}

if (!function_exists('carspotAPI_adPrice_types')) {

    function carspotAPI_adPrice_types($selectVal = '')
    {
        global $carspotAPI;
        $array = array();
        $priceTypes = array(
            'Fixed' => __('Fixed', 'carspot-rest-api'),
            '',
            'Negotiable' => __('Negotiable', 'carspot-rest-api'),
            'on_call' => __('Price on call', 'carspot-rest-api'),
            'auction' => __('Auction', 'carspot-rest-api'),
            'free' => __('Free', 'carspot-rest-api'),
            'no_price' => __('No price', 'carspot-rest-api'),
        );
        if (isset($carspotAPI['sb_price_types']) && $carspotAPI['sb_price_types'] && count($carspotAPI['sb_price_types']) > 0) {
            foreach ($carspotAPI['sb_price_types'] as $val) {
                $is_show = ($val == "on_call" || $val == "free" || $val == "no_price") ? false : true;
                if (isset($priceTypes[$val]) && $priceTypes[$val] != "" && $val != "") {
                    $value = $priceTypes[$val];
                    $array[] = array("key" => $val, "val" => $value, "is_show" => $is_show);
                }
            }
        } else {

            foreach ($priceTypes as $p_key => $p_val) {
                if ($p_key != "" && $p_val != "") {
                    $is_show = ($p_key == "on_call" || $p_key == "free" || $p_key == "no_price") ? false : true;
                    $array[] = array("key" => $p_key, "val" => $p_val, "is_show" => $is_show);
                }
            }
        }
        if (isset($carspotAPI['sb_price_types_more']) && $carspotAPI['sb_price_types_more'] != "") {
            $types = @explode("|", $carspotAPI['sb_price_types_more']);
            if (count($types) > 0) {
                foreach ($types as $t) {
                    $custom_key = str_replace(' ', '_', $t);
                    $array[] = array("key" => $custom_key, "val" => $t, "is_show" => true);
                }
            }
        }
        if ($selectVal != "") {
            $newKey = array();
            foreach ($array as $key => $value) {
                if ($selectVal == $value['key']) {
                    $arrIndex = $value;
                    $newKey = $arrIndex;
                    unset($array[$key]);
                    array_unshift($array, $newKey);
                }
            }
        }

        return $array;
    }

}

if (!function_exists('carspotAPI_arraySearch')) {

    function carspotAPI_arraySearch($array, $index, $value)
    {
        if ($value != "") {
            $arr = array();
            $count = 0;
            foreach ($array as $key => $val) {
                $data = ($index != "") ? $val["$index"] : $val;
                if ($data == $value) {

                    $arr = ($val);
                    unset($array[$count]);
                }
                $count++;
            }
            $array = array_merge(array($arr), $array);
        }

        return $array;
    }

}

if (!function_exists('carspotAPI_objArraySearch')) {

    function carspotAPI_objArraySearch($array, $index, $value, $newIndex = array())
    {
        $extractedKey = array();
        if (isset($array) && count($array) > 0) {
            foreach ($array as $key => $arrayInf) {
                if ($arrayInf->{$index} == $value) {
                    unset($array[$key]);
                    $extractedKey = $arrayInf;
                    //return $arrayInf;
                }
            }
        }

        return (isset($newIndex) && count((array)$newIndex) > 0 && $newIndex != "") ? array_merge(array($newIndex), $array) : $array;
    }

}

if (!function_exists('carspotAPI_getPostAdFields')) {

    function carspotAPI_getPostAdFields($field_type = '', $field_type_name = '', $term_type = 'ad_cats', $only_parent = 0, $name = '', $mainTitle = '', $defaultValue = '', $has_page_number = "1", $is_required = false, $update_val = '', $ad_id = '', $api_placeholder = '')
    {
        global $carspotAPI;
        $values = '';
        $returnType = 1;
        $values_arr = array();
        $has_cat_template = false;
        $has_template = false;
        if ($field_type == "select" || $field_type == "checkbox") {
            $termsArr = array();
            if (is_array($term_type)) {
                $is_multiArr = carspotAPI_is_multiArr($term_type);
                if ($is_multiArr == true) {
                    $term_type = carspotAPI_arraySearch($term_type, "key", $update_val);
                    foreach ($term_type as $val) {
                        $termsArr[] = array
                        (
                            "id" => (string)$val['key'],
                            "name" => $val['val'],
                            "has_sub" => false,
                            "has_template" => false,
                            "is_show" => $val['is_show'],
                        );
                    }
                } else {

                    foreach ($term_type as $key => $val) {
                        $termsArr[] = array
                        (
                            "id" => (string)$key,
                            "name" => $val,
                            "has_sub" => false,
                            "has_template" => false,
                            "is_show" => true,
                        );
                    }
                }
            } else {
                $has_cat_template = ($term_type == "ad_cats") ? true : false;
                $terms = get_terms(array(
                    'taxonomy' => $term_type,
                    'hide_empty' => false,
                    'parent' => $only_parent
                ));
                $ad_cats = array();
                if ($ad_id != "") {
                    $ad_cats = wp_get_object_terms($ad_id, $term_type, array('fields' => 'ids'));

                    if ($term_type == "ad_country") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_country', true);
                    }
                    /* Review Stamp */
                    if ($term_type == "ad_review_stamp") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_review_stamp', true);
                    }
                    /* Condition */
                    if ($term_type == "ad_condition") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_condition', true);
                    }
                    /* Type */
                    if ($term_type == "ad_type") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_type', true);
                    }
                    /* Warranty */
                    if ($term_type == "ad_warranty") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_warranty', true);
                    }
                    /* Years */
                    if ($term_type == "ad_years") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_years', true);
                    }
                    /* Body Types */
                    if ($term_type == "ad_body_types") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_body_types', true);
                    }
                    /* Transmissions */
                    if ($term_type == "ad_transmissions") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_transmissions', true);
                    }
                    /* Engine Capacities */
                    if ($term_type == "ad_engine_capacities") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_engine_capacities', true);
                    }
                    /* Engine Type */
                    if ($term_type == "ad_engine_types") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_engine_types', true);
                    }
                    /* Assembles */
                    if ($term_type == "ad_assembles") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_assembles', true);
                    }
                    /* Colors */
                    if ($term_type == "ad_colors") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_colors', true);
                    }
                    /* Insurance */
                    if ($term_type == "ad_insurance") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_insurance', true);
                    }


                    if (count($ad_cats) > 0) {
                        $count_update_val = count($ad_cats) - 1;
                        $finalCatID = $ad_cats[$count_update_val];
                        $term_data = get_term_by('id', $finalCatID, $term_type);
                        $terms = carspotAPI_objArraySearch($terms, 'term_id', $finalCatID, $term_data);
                        if ($term_type != 'ad_cats') {
                            $update_val = $terms[0]->term_id . "|" . $terms[0]->name;
                        }
                    }
                }
                if ($term_type == "ad_country") {
                    $termsArr = array();
                }
                $catNames = '';
                $catIDS = '';
                if (count($terms)) {
                    if (count($ad_cats) == 0) {
                        if ($field_type != "checkbox") {
                            $termsArr[] = array
                            (
                                "id" => "",
                                "name" => esc_html__("Select Option", "carspot"),
                                "has_sub" => false,
                                "has_template" => false,
                                "is_show" => true,
                            );
                        }
                    }
                    foreach ($terms as $ad_trm) {
                        $result = carspot_dynamic_templateID(@$ad_trm->term_id);
                        $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);

                        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true && $term_type == "ad_cats") {
                            $has_template = (isset($templateID) && $templateID != "") ? true : false;
                            //$has_template = true;
                        }
                        $term_children = get_term_children(filter_var(@$ad_trm->term_id, FILTER_VALIDATE_INT), filter_var($term_type, FILTER_SANITIZE_STRING));
                        $has_sub = (empty($term_children) || is_wp_error($term_children)) ? false : true;

                        /* Ad features start */
                        $selected = '';
                        if ($term_type == 'ad_features') {
                            $frs = array();
                            $ad_features = carspot_get_cats('ad_features', 0);
                            $count = 1;
                            $adfeatures = get_post_meta($ad_id, '_carspot_' . $term_type, true);
                            if ($adfeatures != "") {
                                $frs = explode('|', $adfeatures);
                            }
                            foreach ($ad_features as $feature) {
                                $selected = (in_array($ad_trm->name, $frs)) ? true : false;
                            }
                        }
                        /* Ad features end */
                        $termsArr[] = array
                        (
                            "id" => (string)$ad_trm->term_id,
                            "name" => htmlspecialchars_decode(@$ad_trm->name, ENT_NOQUOTES),
                            /* "value"			=>  (string)$ad_trm->term_id.'|'.htmlspecialchars_decode(@$ad_trm->name, ENT_NOQUOTES), */
                            "value" => (string)$ad_trm->term_id . '|' . htmlspecialchars_decode(@$ad_trm->name, ENT_NOQUOTES),
                            "has_sub" => $has_sub,
                            "has_template" => $has_template,
                            "is_show" => true,
                            "is_checked" => $selected
                            /* "count" => $ad_trm->count, */
                        );
                    }
                }
            }
            /* Ad features end */
            $values = $termsArr;
            $values_arr = $termsArr;
        }

        if ($field_type == "textfield" || "glocation_textfield" == $field_type || "textarea" == $field_type) {
            $values = $defaultValue;
            $values_arr = ($defaultValue != "") ? array($defaultValue) : array();
            if ($term_type != "") {
                $update_val = get_post_meta($ad_id, "_carspot_" . $term_type, true);
            }
        }

        if ($field_type == "image") {
            $values_arr = ($defaultValue != "") ? array($defaultValue) : array();
            $values = $defaultValue;
        }
        if ($field_type == "map") {
            $values_arr = ($defaultValue != "") ? array($defaultValue) : array();
            $values = $defaultValue;
        }

        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
            $has_cat_template = false;
        }

        $values_data = $values;


        return array(
            "main_title" => $mainTitle,
            "field_type" => $field_type,
            "field_type_name" => $field_type_name,
            "field_val" => $update_val,
            "field_name" => "",
            "title" => $name,
            "values" => $values_data,
            "has_page_number" => (string)$has_page_number,
            "is_required" => $is_required,
            "has_cat_template" => $has_cat_template,
            "placeholder" => $api_placeholder
        );
    }

}
if (!function_exists('carspotAPI_getCats_idz')) {

    function carspotAPI_getCats_idz($postId, $term_name, $reverse_arr = false)
    {
        $terms = wp_get_post_terms($postId, $term_name, array('orderby' => 'id', 'order' => 'DESC'));
        $deepestTerm = false;
        $maxDepth = -1;
        $c = 0;
        if (isset($terms) && count($terms) > 0) {
            foreach ($terms as $term) {
                $ancestors = get_ancestors($term->term_id, $term_name);
                $termDepth = count($ancestors);
                $deepestTerm[$c] = $term->term_id;
                $maxDepth = $termDepth;
                $c++;
            }

            return ($reverse_arr == false) ? $deepestTerm : array_reverse($deepestTerm);
        } else {
            return array();
        }
    }

}

if (!function_exists('carspotAPI_getUnreadMessageCount')) {

    function carspotAPI_getUnreadMessageCount()
    {

        global $wpdb;
        $user_id = get_current_user_id();
        $unread_msgs = 0;
        if ($user_id) {
            $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
        }

        return $unread_msgs;
    }

}

if (!function_exists('carspotAPI_getSearchFields')) {

    function carspotAPI_getSearchFields($field_type = '', $field_type_name = '', $term_type = 'ad_cats', $only_parent = 0, $name = '', $mainTitle = '', $defaultValue = '', $is_id = true)
    {
        global $carspotAPI;
        $values = '';
        $returnType = 1;
        $has_cat_template = false;
        if ($field_type == "select") {
            $termsArr = array();
            if (is_array($term_type)) {

                foreach ($term_type as $key => $val) {
                    $termsArr[] = array
                    (
                        "id" => (string)$key,
                        "name" => $val,
                        "has_sub" => false,
                        "has_template" => false,
                        /* "count" => $ad_trm->count, */
                    );
                }
            } else {

                $has_cat_template = ($term_type == "ad_cats") ? true : false;

                $show_counts = ($term_type == "ad_cats") ? true : false;

                $terms = get_terms(array(
                    'taxonomy' => $term_type,
                    'hide_empty' => false,
                    'parent' => $only_parent,
                ));
                $termsArr = array();
                $catNames = '';
                $catIDS = '';
                if (count($terms)) {

                    if ($term_type == 'ad_cats' || $term_type == 'ad_country') {
                        $termsArr[] = array
                        (
                            "id" => "",
                            "name" => __("Select Option", "carspot-rest-api"),
                            "has_sub" => false,
                            "has_template" => false,
                        );
                    }

                    foreach ($terms as $ad_trm) {
                        $result = carspot_dynamic_templateID($ad_trm->term_id);
                        $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);
                        $has_template = (isset($templateID) && $templateID != "") ? true : false;

                        if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == true) {
                            if ($term_type == "ad_cats") {
                                $has_template = true;
                            }
                        }
                        $countsNumber = ($show_counts == true) ? ' (' . $ad_trm->count . ')' : '';
                        $countsNumber = ''; /* Tempraroty Off */
                        $term_children = get_term_children(filter_var($ad_trm->term_id, FILTER_VALIDATE_INT), filter_var($term_type, FILTER_SANITIZE_STRING));
                        $has_sub = (empty($term_children) || is_wp_error($term_children)) ? false : true;

                        $idVal = ($is_id == true) ? $ad_trm->term_id : htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES);
                        //(string)$ad_trm->term_id.'|'.htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES)
                        $termsArr[] = array
                        (
                            "id" => (string)$ad_trm->term_id,
                            "name" => htmlspecialchars_decode($ad_trm->name, ENT_NOQUOTES) . $countsNumber,
                            "has_sub" => $has_sub,
                            "has_template" => $has_template,
                            /* "count" => $ad_trm->count, */
                        );
                    }
                }
            }
            $values = $termsArr;
        }

        if ($field_type == "textfield" || "glocation_textfield" == $field_type || "textarea" == $field_type) {
            $values = $defaultValue;
        }

        if ($field_type == "seekbar") {
            $values = $defaultValue;
        }
        if ($field_type == "image") {
            $values = $defaultValue;
        }
        if ($field_type == "map") {
            $values = $defaultValue;
        }

        if ("range_textfield" == $field_type) {
            $title1 = $name[0];
            $title2 = $name[1];
            $array[] = array("title" => $title1);
            $array[] = array("title" => $title2);
            $returnType = 2;
            $values = '';
        }


        if ($returnType == 2) {
            return array(
                "title" => $mainTitle,
                "field_type_name" => $field_type_name,
                "field_type" => $field_type,
                "data" => $array
            );
        } else {

            if (isset($carspotAPI['adpost_cat_template']) && $carspotAPI['adpost_cat_template'] == false) {
                $has_cat_template = false;
            }

            return array(
                "main_title" => $mainTitle,
                "field_type" => $field_type,
                "field_type_name" => $field_type_name,
                "field_val" => "",
                "field_name" => "",
                "title" => $name,
                "values" => $values,
                "has_cat_template" => $has_cat_template
            );
        }
    }

}

function carspotAPI_categoryForm_data($postId)
{
    $resultD = '';
    $terms = wp_get_post_terms($postId, 'ad_cats', array('orderby' => 'id', 'order' => 'DESC'));
    $deepestTerm = false;
    $maxDepth = -1;
    $c = 0;
    foreach ($terms as $term) {
        $ancestors = get_ancestors($term->term_id, 'ad_cats');
        $termDepth = count($ancestors);
        $deepestTerm[$c] = $term;
        $maxDepth = $termDepth;
        $c++;
    }
    $term_id = '';
    if (isset($deepestTerm) && is_array($deepestTerm) && count($deepestTerm) > 0) {

        foreach ($deepestTerm as $term) {
            $term_id = $term->term_id;
            $t = carspot_dynamic_templateID($term_id);
            if ($t) {
                break;
            }
        }
        $templateID = carspot_dynamic_templateID($term_id);
        $resultD = get_term_meta($templateID, '_sb_dynamic_form_fields', true);
    }

    return $resultD;
}

function carspotAPI_getCats_template($postId)
{

    $result = carspotAPI_categoryForm_data($postId);
    $formData = sb_dynamic_form_data($result);
    $dynamicData = array();
    if (count($formData) > 0) {

        foreach ($formData as $data) {
            if ($data['titles'] != "") {
                $values = get_post_meta($postId, "_carspot_tpl_field_" . $data['slugs'], true);
                $value = json_decode($values);
                $value = (is_array($value)) ? implode($value, ", ") : $values;

                $titles = ($data['titles']);
                $status = ($data['status']);
                if ($value != "" && $status == 1) {
                    $type = 'textfield';
                    if ($data['types'] == '1') {
                        $type = 'textfield';
                    }
                    if ($data['types'] == '2') {
                        $type = 'select';
                    }
                    if ($data['types'] == '3') {
                        $type = 'checkbox';
                    }
                    $dynamicData[] = array(
                        "key" => esc_html($titles),
                        "value" => esc_html($value),
                        "type" => $type
                    );
                }
            }
        }
    }

    return ($dynamicData);
}

function carspotAPI_get_posts_count()
{
    global $wp_query;

    return $wp_query->post_count;
}

if (!function_exists('carspotAPI_get_customAdPostFields')) {

    function carspotAPI_get_customAdPostFields($form_type = '', $fieldsData = '', $extra_section_title = '')
    {

        $appArr['form_type'] = $form_type;
        $arr = array();
        if (isset($fieldsData) && count($fieldsData) > 0) {
            $rows = $fieldsData;
            if (count($rows[0]) > 0 && count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['title']) && isset($row['type']) && isset($row['slug'])) {
                        $option_values = (isset($row['option_values']) && $row['option_values'] != "") ? $row['option_values'] : '';
                        $arr[] = array(
                            "section_title" => $extra_section_title,
                            "type" => $row['type'],
                            "title" => $row['title'],
                            "slug" => $row['slug'],
                            "option_values" => $option_values
                        );
                    }
                }
            }
        }
        $appArr['custom_fields'] = $arr;
        $data = json_encode($appArr, true);
        update_option("_carspotAPI_customFields", $data);
    }

}
/* Time Ago */
if (!function_exists('carspotAPI_timeago')) {

    function carspotAPI_timeago($date)
    {
        $timestamp = strtotime($date);

        $strTime = array(
            __('second', 'carspot-rest-api'),
            __('minute', 'carspot-rest-api'),
            __('hour', 'carspot-rest-api'),
            __('day', 'carspot-rest-api'),
            __('month', 'carspot-rest-api'),
            __('year', 'carspot-rest-api')
        );
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = strtotime(current_time('mysql'));
        if ($currentTime >= $timestamp) {
            $diff = $currentTime - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);

            return $diff . " " . $strTime[$i] . __('(s) ago', 'carspot-rest-api');
        }
    }

}

// Time difference n days
if (!function_exists('carspotAPI_days_diff')) {

    function carspotAPI_days_diff($now, $from)
    {
        $datediff = $now - $from;

        return floor($datediff / (60 * 60 * 24));
    }

}

if (!function_exists('carspotAPI_do_register')) {

    function carspotAPI_do_register($email = '', $password = '')
    {
        global $carspotAPI;
        global $carspot_theme;

        $user_name = explode('@', $email);
        $u_name = carspotAPI_check_user_name($user_name[0]);
        $uid = wp_create_user($u_name, $password, $email);

        wp_update_user(array('ID' => $uid, 'display_name' => $u_name));
        //carspotAPI_auto_login($email, $password, true );

        $sb_allow_ads = Redux::getOption('carspot_theme', 'sb_allow_ads');
        if (isset($sb_allow_ads) && $sb_allow_ads == true) {
            $free_ads = Redux::getOption('carspot_theme', 'sb_free_ads_limit');
            $featured_ads = Redux::getOption('carspot_theme', 'sb_featured_ads_limit');
            $bump_ads = Redux::getOption('carspot_theme', 'sb_bump_ads_limit');
            $package_validity = Redux::getOption('carspot_theme', 'sb_package_validity');
            $allow_featured_ads = Redux::getOption('carspot_theme', 'sb_allow_featured_ads');
            $allow_bump_ads = Redux::getOption('carspot_theme', 'sb_allow_bump_ads');

            $free_ads = (isset($free_ads) && $free_ads != "") ? $free_ads : 0;
            $featured_ads = (isset($featured_ads) && $featured_ads != "") ? $featured_ads : 0;
            $bump_ads = (isset($bump_ads) && $bump_ads != "") ? $bump_ads : 0;
            $package_validity = (isset($package_validity) && $package_validity != "") ? $package_validity : '';

            update_user_meta($uid, '_sb_simple_ads', $free_ads);
            if (isset($allow_featured_ads) && $allow_featured_ads == true) {
                update_user_meta($uid, '_carspot_featured_ads', $featured_ads);
            }

            if (isset($allow_bump_ads) && $allow_bump_ads == true) {
                update_user_meta($uid, '_carspot_bump_ads', $bump_ads);
            }


            if ($package_validity == '-1') {
                update_user_meta($uid, '_carspot_expire_ads', $package_validity);
            } else {
                $days = $package_validity;
                $expiry_date = date('Y-m-d', strtotime("+$days days"));
                update_user_meta($uid, '_carspot_expire_ads', $expiry_date);
            }
        } else {
            update_user_meta($uid, '_sb_simple_ads', 0);
            update_user_meta($uid, '_carspot_featured_ads', 0);
            update_user_meta($uid, '_carspot_bump_ads', 0);
            update_user_meta($uid, '_carspot_expire_ads', date('Y-m-d'));
        }
        update_user_meta($uid, '_sb_pkg_type', 'free');

        return $uid;
    }

}
if (!function_exists('carspotAPI_check_user_name')) {

    function carspotAPI_check_user_name($username = '')
    {

        if (username_exists($username)) {
            $random = mt_rand();
            $username = $username . '-' . $random;
            carspotAPI_check_user_name($username);
        }

        return $username;
    }

}

if (!function_exists('carspotAPI_get_all_ratings')) {

    function carspotAPI_get_all_ratings($user_id)
    {
        global $wpdb;
        $ratings = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = '$user_id' AND  meta_key like  '_user_%' ORDER BY umeta_id DESC", OBJECT);

        return $ratings;
    }

}


// Email on ad publish
add_action('transition_post_status', 'carspotAPI_send_mails_on_publish', 10, 3);

function carspotAPI_send_mails_on_publish($new_status, $old_status, $post)
{
    if ('publish' !== $new_status or 'publish' === $old_status or 'ad_post' !== get_post_type($post)) {
        return;
    }

    global $carspot_theme;
    if (isset($carspot_theme['email_on_ad_approval']) && $carspot_theme['email_on_ad_approval'] == true) {
        carspot_get_notify_on_ad_approval($post);
    }
}

// check permission for ad posting
if (!function_exists('carspotAPI_check_ads_validity')) {

    function carspotAPI_check_ads_validity()
    {
        global $carspotAPI;
        global $carspot_theme;

        $user = wp_get_current_user();
        $user_id = $user->ID;
        $uid = $user_id;
        if (get_user_meta($user_id, '_sb_simple_ads', true) == 0 || get_user_meta($uid, '_sb_simple_ads', true) == "") {
            return $message = __('Please subscribe package for ad posting.', 'carspot-rest-api');
        } else {
            if (get_user_meta($user_id, '_carspot_expire_ads', true) != '-1') {
                if (get_user_meta($user_id, '_carspot_expire_ads', true) < date('Y-m-d')) {
                    update_user_meta($user_id, '_sb_simple_ads', 0);
                    update_user_meta($user_id, '_carspot_featured_ads', 0);
                    return $message = __('Your package has been expired.', 'carspot-rest-api');
                }
            }
        }
    }

}

/*
 * Get user profile data
 */
if (!function_exists('carspotAPI_get_user_profile_data_')) {
    function carspotAPI_get_user_profile_data_()
    {
        global $carspotAPI;
        global $carspot_theme;
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $uid = $user_id;
        $data = array();
        $is_update = '';
        //===========
        $display_name = $user->data->display_name;
        $sb_contact = get_user_meta($user_id, '_sb_contact', true);
        $sb_location = get_user_meta($user_id, '_sb_address', true);
        $customFields = get_option("_carspotAPI_customFields");
        $customFields = json_decode($customFields, true);
        //===========
        $data['profile']['name'] = carspotAPI_getPostAdFields('textfield', 'name', '', 0, __("Name", "carspot-rest-api"), '', $display_name, '4', true, $display_name);
        $sb_change_ph = (isset($carspotAPI['sb_change_ph']) && $carspotAPI['sb_change_ph'] == false) ? false : true;
        $is_verification_on = (isset($carspotAPI['sb_phone_verification']) && $carspotAPI['sb_phone_verification']) ? true : false;

        $data['profile']['is_phone_verification_on'] = $is_verification_on;
        $data['profile']['phone_editable'] = $sb_change_ph;
        $data['profile']['phone'] = carspotAPI_getPostAdFields('textfield', 'ad_phone', '', 0, __("Phone Number", "carspot-rest-api"), '', $sb_contact, '4', true, $sb_contact);

        /* Start Editing Here */
        $data['profile']['ad_country_show'] = false;
        $is_show_location = wp_count_terms('ad_country');
        if (isset($carspot_theme['enable_custom_locationz']) && $carspot_theme['enable_custom_locationz'] == 1) {
            if (isset($is_show_location) && (int)$is_show_location > 0) {
                $data['profile']['ad_country_show'] = true;
                $data['profile']['ad_country'] = carspotAPI_getPostAdFields('select', 'ad_country', 'ad_country', 0, __("Location", "carspot-rest-api"), '', '', '4', true, '', $is_update);
            }
            /* ad_country */
        }
        $map_lat = $map_long = '';
        if ($map_lat == "" && $map_long == "") {
            $current_user = wp_get_current_user();
            $ad_usr_map_lat = get_user_meta($current_user->ID, '_sb_user_address_lat', true);
            $ad_usr_map_long = get_user_meta($current_user->ID, '_sb_user_address_long', true);
            if ($ad_usr_map_lat != "" && $ad_usr_map_long != "") {
                $pin_lat = $ad_usr_map_lat;
                $pin_long = $ad_usr_map_long;
                /* for lat long field */
                $map_lat = $ad_usr_map_lat;
                $map_long = $ad_usr_map_long;
            } else {
                $map_lat = $carspot_theme['sb_default_lat'];
                $map_long = $carspot_theme['sb_default_long'];
            }
        }
        $data['profile']['location'] = carspotAPI_getPostAdFields('glocation_textfield', 'ad_location', '', 0, __("Address", "carspot-rest-api"), '', $sb_location, '4', true, $sb_location);

        $map_on_off = (isset($carspot_theme['allow_lat_lon']) && $carspot_theme['allow_lat_lon'] == true) ? true : false;
        $data['profile']['map']['on_off'] = $map_on_off;
        $data['profile']['map']['location_lat'] = carspotAPI_getPostAdFields('textfield', 'location_lat', '', 0, __("Latitude", "carspot-rest-api"), '', $map_lat, '4', true, $map_lat);
        $data['profile']['map']['location_long'] = carspotAPI_getPostAdFields('textfield', 'location_long', '', 0, __("Longitude", "carspot-rest-api"), '', $map_long, '4', true, $map_long);

        return $data;
    }
}


if (!function_exists('carspotAPI_make_link')) {

    function carspotAPI_make_link($url, $text)
    {
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", carspotAPI_required_tags()) . $text . wp_kses('</a>', carspotAPI_required_tags());
    }

}

if (!function_exists('carspotAPI_required_attributes')) {

    function carspotAPI_required_attributes()
    {
        return $default_attribs = array(
            'id' => array(),
            'src' => array(),
            'href' => array(),
            'target' => array(),
            'class' => array(),
            'title' => array(),
            'type' => array(),
            'style' => array(),
            'data' => array(),
            'role' => array(),
            'aria-haspopup' => array(),
            'aria-expanded' => array(),
            'data-toggle' => array(),
            'data-hover' => array(),
            'data-animations' => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-href' => array(),
            'data-tabs' => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-height' => array(),
            'data-hide-cover' => array(),
            'data-show-facepile' => array(),
        );
    }

}

if (!function_exists('carspotAPI_required_tags')) {

    function carspotAPI_required_tags()
    {
        return $allowed_tags = array(
            'div' => carspotAPI_required_attributes(),
            'span' => carspotAPI_required_attributes(),
            'p' => carspotAPI_required_attributes(),
            'a' => array_merge(carspotAPI_required_attributes(), array(
                'href' => array(),
                'target' => array('_blank', '_top'),
            )),
            'u' => carspotAPI_required_attributes(),
            'br' => carspotAPI_required_attributes(),
            'i' => carspotAPI_required_attributes(),
            'q' => carspotAPI_required_attributes(),
            'b' => carspotAPI_required_attributes(),
            'ul' => carspotAPI_required_attributes(),
            'ol' => carspotAPI_required_attributes(),
            'li' => carspotAPI_required_attributes(),
            'br' => carspotAPI_required_attributes(),
            'hr' => carspotAPI_required_attributes(),
            'strong' => carspotAPI_required_attributes(),
            'blockquote' => carspotAPI_required_attributes(),
            'del' => carspotAPI_required_attributes(),
            'strike' => carspotAPI_required_attributes(),
            'em' => carspotAPI_required_attributes(),
            'code' => carspotAPI_required_attributes(),
            'style' => carspotAPI_required_attributes(),
            'script' => carspotAPI_required_attributes(),
            'img' => carspotAPI_required_attributes(),
        );
    }

}


if (!function_exists('carspotAPI_CustomFieldsVals')) {

    function carspotAPI_CustomFieldsVals($post_id = '', $terms = array())
    {
        if ($post_id == "") {
            return;
        }
        /* $terms = wp_get_post_terms($post_id, 'ad_cats'); */
        $is_show = '';
        if (isset($terms) && $terms && count($terms) > 0) {

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

        return ($is_show == 1) ? 1 : 0;
    }

}

// Bad word filter
if (!function_exists('carspotAPI_badwords_filter')) {

    function carspotAPI_badwords_filter($words = array(), $string = '', $replacement = '')
    {
        foreach ($words as $word) {
            $string = str_replace($word, $replacement, $string);
        }

        return $string;
    }

}

function increase_timeout_for_api_requests_27091($r = '', $url = '')
{
    if (false !== strpos($url, '//api.wordpress.org/')) {
        $r['timeout'] = 300;
    }
    return $r;
}

add_filter('http_request_args', 'increase_timeout_for_api_requests_27091', 10, 2);


// ------------------------------------------------ //
// Get and Set Post Views //
// ------------------------------------------------ //
if (!function_exists('carspotAPI_getPostViews')) {

    function carspotAPI_getPostViews($postID)
    {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }

        return $count;
    }

}

if (!function_exists('carspotAPI_setPostViews')) {

    function carspotAPI_setPostViews($postID)
    {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

}
if (!function_exists('carspotAPI_updateUser_onRegister')) {

    function carspotAPI_updateUser_onRegister($uid = '')
    {

        if (carspotAPI_getReduxValue('sb_allow_ads', '', true)) {
            $freeAds = carspotAPI_getReduxValue('sb_free_ads_limit', '', false);
            $featured = carspotAPI_getReduxValue('sb_featured_ads_limit', '', false);
            $validity = carspotAPI_getReduxValue('sb_package_validity', '', false);

            update_user_meta($uid, '_sb_simple_ads', $freeAds);
            update_user_meta($uid, '_carspot_featured_ads', $featured);

            if ($validity == '-1') {
                update_user_meta($uid, '_carspot_expire_ads', $validity);
            } else {
                $expiry_date = date('Y-m-d', strtotime("+$validity days"));
                update_user_meta($uid, '_carspot_expire_ads', $expiry_date);
            }
        } else {
            update_user_meta($uid, '_sb_simple_ads', 0);
            update_user_meta($uid, '_carspot_featured_ads', 0);
            update_user_meta($uid, '_carspot_expire_ads', date('Y-m-d'));
        }

        update_user_meta($uid, '_sb_pkg_type', 'free');
    }

}


if (!function_exists('carspotAPI_firebase_notify_func')) {

    function carspotAPI_firebase_notify_func($firebase_id = '', $message_data = array())
    {
        global $carspotAPI;
        if (isset($carspotAPI['api_firebase_id']) && $carspotAPI['api_firebase_id'] != "") {
            $api_firebase_id = $carspotAPI['api_firebase_id'];
            define('API_ACCESS_KEY', $api_firebase_id);
            $registrationIds = array($firebase_id);

            $msg = (isset($message_data) && count($message_data) > 0) ? $message_data : '';
            if ($msg == "") {
                return '';
            }
            $fields = array('registration_ids' => $registrationIds, 'data' => $msg, 'notification' => $msg);
            $headers = array('Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }

}


if (!function_exists('carspotAPI_social_profiles')) {

    function carspotAPI_social_profiles()
    {
        global $carspotAPI;
        $social_netwroks = array();
        if (isset($carspotAPI['sb_enable_social_links']) && $carspotAPI['sb_enable_social_links']) {
            $social_netwroks = array(
                'facebook' => __('Facebook', 'carspot-rest-api'),
                'twitter' => __('Twitter', 'carspot-rest-api'),
                'linkedin' => __('Linkedin', 'carspot-rest-api'),
                'google-plus' => __('Google+', 'carspot-rest-api')
            );
        }

        return $social_netwroks;
    }

}

if (!function_exists('carspotAPI_after_payment')) {

    function carspotAPI_payment_types($key = '', $type = '')
    {

        global $carspotAPI;
        $paypalKey = (isset($carspotAPI['appKey_paypalKey']) && $carspotAPI['appKey_paypalKey'] != "") ? $carspotAPI['appKey_paypalKey'] : '';
        $stripeSKey = (isset($carspotAPI['appKey_stripeSKey']) && $carspotAPI['appKey_stripeSKey'] != "") ? $carspotAPI['appKey_stripeSKey'] : '';
        $arr = array();

        if ($type != "ios") {
            $arr['stripe'] = __('Stripe', 'carspot-rest-api');
            $arr['paypal'] = __('PayPal', 'carspot-rest-api');
            $arr['bank_transfer'] = __('Bank Transfer', 'carspot-rest-api');
            $arr['cash_on_delivery'] = __('Cash On Delivery', 'carspot-rest-api');
            $arr['cheque'] = __('Payment By Check', 'carspot-rest-api');
        }
        $arr['app_inapp'] = __('InApp Purchase', 'carspot-rest-api');

        return (isset($arr[$key]) && $key != "") ? $arr[$key] : $arr;
    }

}


if (!function_exists('carspotAPI_determine_minMax_latLong')) {

    function carspotAPI_determine_minMax_latLong($data_arr = array(), $check_db = true)
    {

        $data = array();
        $user_id = get_current_user_id();
        $success = false;

        if (isset($data_arr) && !empty($data_arr)) {
            $nearby_data = $data_arr;
        } else if ($user_id && $check_db) {
            $nearby_data = get_user_meta($user_id, '_sb_user_nearby_data', true);
        }

        if (isset($nearby_data) && $nearby_data != "") {

            $original_lat = $nearby_data['latitude'];
            $original_long = $nearby_data['longitude'];
            $distance = $nearby_data['distance'];

            $lat = $original_lat; //latitude
            $lon = $original_long; //longitude
            $distance = $distance; //your distance in KM
            $R = 6371; //constant earth radius. You can add precision here if you wish

            $maxLat = $lat + rad2deg($distance / $R);
            $minLat = $lat - rad2deg($distance / $R);
            $maxLon = $lon + rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));
            $minLon = $lon - rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));

            $data['radius'] = $R;
            $data['distance'] = $distance;
            $data['lat']['original'] = $original_lat;
            $data['long']['original'] = $original_long;

            $data['lat']['min'] = $minLat;
            $data['lat']['max'] = $maxLat;

            $data['long']['min'] = $minLon;
            $data['long']['max'] = $maxLon;
        }


        return $data;
    }
}


if (!function_exists('carspotAPI_get_all_countries')) {

    function carspotAPI_get_all_countries()
    {
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => '_sb_country',
            'post_status' => 'publish',
        );

        $countries = get_posts($args);
        $res = array();
        foreach ($countries as $country) {
            $res[$country->post_excerpt] = $country->post_title;
        }

        return $res;
    }

}
if (!function_exists('carspotAPI_randomString')) {

    function carspotAPI_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }

}
if (!function_exists('carspotAPI_authorization_htaccess_contents')) {

    function carspotAPI_authorization_htaccess_contents($rules)
    {
        $my_content = <<<EOD
\n# BEGIN ADDING CARSPOT Authorization
SetEnvIf Authorization .+ HTTP_AUTHORIZATION=$0
# END ADDING CARSPOT Authorization\n
EOD;

        return $rules . $my_content;
    }

}
add_filter('mod_rewrite_rules', 'carspotAPI_authorization_htaccess_contents');

/* * ************************ */
/* Home Screen Get BG Image */
/* * ************************ */
if (!function_exists('carspotAPI_home_secreen_bg')) {

    function carspotAPI_home_secreen_bg()
    {
        global $carspotAPI;
        $defaultsecreen = CARSPOT_API_PLUGIN_URL . "images/home-secreen.jpg";
        $home_secreen = (isset($carspotAPI['hom_sec_bg'])) ? $carspotAPI['hom_sec_bg']['url'] : $defaultsecreen;

        return $home_secreen;
    }

}
// get post description as per need.
if (!function_exists('carspotAPI_words_count')) {

    function carspotAPI_words_count($contect = '', $limit = 180)
    {
        $string = '';
        $contents = strip_tags(strip_shortcodes($contect));
        $contents = carspot_removeURL($contents);
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $limit) {
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }

}

class carspotAPI_save_term_inapp_extras
{

    public function __construct()
    {

        if (is_admin()) {
            if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'ad_cats' && isset($_GET['post_type']) && $_GET['post_type'] == 'ad_post') {
                add_action('ad_cats_add_form_fields', array(
                    $this,
                    'carspotAPI_save_term_inapp_create_screen_fields'
                ), 10, 1);
                add_action('ad_cats_edit_form_fields', array(
                    $this,
                    'carspotAPI_save_term_inapp_edit_screen_fields'
                ), 10, 2);
                add_action('created_ad_cats', array($this, 'carspotAPI_save_term_inapp_data'), 10, 1);
                add_action('edited_ad_cats', array($this, 'carspotAPI_save_term_inapp_data'), 10, 1);
            }
        }
    }

    public function carspotAPI_save_term_inapp_create_screen_fields($taxonomy)
    {

        // Set default values Android
        $carspot_inapp_android = '';
        $carspot_inapp_ios = '';

        // Form fields.
        $html = '';
        $html .= '<div class="form-field term-carspot-inapp-android-wrap">';
        $html .= '	<label for="carspot-inapp-android">' . __('InApp Code (Android)', 'carspot-rest-api') . '</label>';
        $html .= '	<input type="text" id="carspot-inapp-android" name="carspot-inapp-android" placeholder="" value="' . esc_attr($carspot_inapp_android) . '">';
        $html .= '	<p class="description">' . __('Put your android inapp product code for innapp purchase for Category Based Procing', 'carspot-rest-api') . '</p>';
        $html .= '</div>';
        // Form fields.
        $html .= '<div class="form-field term-carspot-inapp-ios-wrap">';
        $html .= '	<label for="carspot-inapp-ios">' . __('InApp Code (ios)', 'carspot-rest-api') . '</label>';
        $html .= '	<input type="text" id="carspot-inapp-ios" name="carspot-inapp-ios" placeholder="" value="' . esc_attr($carspot_inapp_ios) . '">';
        $html .= '	<p class="description">' . __('Put your ios inapp product code for innapp purchase for Category Based Procing', 'carspot-rest-api') . '</p>';
        $html .= '</div>';

        echo $html;
    }

    public function carspotAPI_save_term_inapp_screen_fields($term, $taxonomy)
    {

        // Retrieve an existing value from the database. Android
        $carspot_inapp_android = get_term_meta($term->term_id, 'carspot-inapp-android', true);
        $carspot_inapp_ios = get_term_meta($term->term_id, 'carspot-inapp-ios', true);

        // Set default values.
        if (empty($carspot_inapp_android)) {
            $carspot_inapp_android = '';
        }
        if (empty($carspot_inapp_ios)) {
            $carspot_inapp_ios = '';
        }

        // Form fields.
        $html = '';
        $html .= '<tr class="form-field term-carspot-inapp-android-wrap">';
        $html .= '<th scope="row">';
        $html .= '	<label for="carspot-inapp-android">' . __('InApp Code (Android)', 'carspot-rest-api') . '</label>';
        $html .= '</th>';
        $html .= '<td>';
        $html .= '	<input type="text" id="carspot-inapp-android" name="carspot-inapp-android" placeholder="" value="' . esc_attr($carspot_inapp_android) . '">';
        $html .= '	<p class="description">' . __('Put your android inapp product code for innapp purchase for Category Based Procing', 'carspot-rest-api') . '</p>';
        $html .= '</td>';
        $html .= '</tr>';


        // Form fields.
        $html .= '<tr class="form-field term-carspot-inapp-ios-wrap">';
        $html .= '<th scope="row">';
        $html .= '	<label for="carspot-inapp-ios">' . __('InApp Code (ios)', 'carspot-rest-api') . '</label>';
        $html .= '</th>';
        $html .= '<td>';
        $html .= '	<input type="text" id="carspot-inapp-ios" name="carspot-inapp-ios" placeholder="" value="' . esc_attr($carspot_inapp_ios) . '">';
        $html .= '	<p class="description">' . __('Put your ios inapp product code for innapp purchase for Category Based Procing', 'carspot-rest-api') . '</p>';
        $html .= '</td>';
        $html .= '</tr>';

        echo $html;
    }

    public function carspotAPI_save_term_inapp_data($term_id)
    {
        // Sanitize user input.
        $new_carspot_inapp_android = isset($_POST['carspot-inapp-android']) ? sanitize_text_field($_POST['carspot-inapp-android']) : '';
        update_term_meta($term_id, 'carspot-inapp-android', $new_carspot_inapp_android);
        // Sanitize user input. IOS
        $new_carspot_inapp_ios = isset($_POST['carspot-inapp-ios']) ? sanitize_text_field($_POST['carspot-inapp-ios']) : '';
        update_term_meta($term_id, 'carspot-inapp-ios', $new_carspot_inapp_ios);
    }

}

if (!function_exists('carspotAPI_get_ad_image_with_arrangment')) {

    function carspotAPI_get_ad_image_with_arrangment($post_id = '', $size = 'both', $media_type = '')
    {
        global $carspot_theme;
        $media = array();
        $img_arr = array();
        if ($post_id != '' && $media_type == 'image') {
            $media = get_attached_media('image', $post_id);
        } else {
            $media = carspot_fetch_listing_gallery($post_id);
        }
        if (count((array)$media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $img = wp_get_attachment_image_src($mid, 'carspot-category');
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (wp_attachment_is_image($mid)) {
                    $img_arr[] = array('full' => $full_img[0], 'thumb' => $img[0], "img_id" => $mid);
                } else {
                    $default_img = esc_url($carspot_theme['default_related_image']['url']);
                    $img_arr[] = array('full' => $default_img, 'thumb' => $default_img, "img_id" => $mid);
                }
            }
        }

        return $img_arr;
    }

}

/* combine videos and images for slider */
if (!function_exists('carspotAPI_get_ad_videos_images_with_arrangment')) {

    function carspotAPI_get_ad_videos_images_with_arrangment($post_id = '', $size = 'both', $media_type = '')
    {
        global $carspot_theme;
        global $carspotAPI;
        $media = array();
        $video_img_arr = array();
        if ($post_id != '' && $media_type == 'image') {
            //$media = get_attached_media('image', $post_id); 23-sep-2020
            $media = carspot_fetch_listing_gallery($post_id);
        } else {
            $media = carspot_fetch_listing_gallery($post_id);
        }
        if ($post_id != "") {
            if (isset($carspotAPI['allow_video_on_ad']) && $carspotAPI['allow_video_on_ad'] == true) {
                $video_attachment_id = get_post_meta($post_id, 'carspot_video_uploaded_attachment_', true);
                if ($video_attachment_id != '' && $video_attachment_id != '-1') {
                    $video_attachment_id = explode(",", $video_attachment_id);
                    if (is_array($video_attachment_id) && $video_attachment_id != '' && $video_attachment_id[0] != '') {
                        foreach ($video_attachment_id as $vid_ids) {
                            if ($vid_ids != '-1') {
                                $video_img_arr[] = array(
                                    "type" => "video",
                                    "vid_url" => wp_get_attachment_url($vid_ids),
                                    "video_name" => get_the_title($vid_ids),
                                    "vid_id" => $vid_ids
                                );
                            }
                        }
                    }
                }
            }
        }
        if (count((array)$media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $img = wp_get_attachment_image_src($mid, 'carspot-category');
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (wp_attachment_is_image($mid)) {
                    $video_img_arr[] = array(
                        "type" => "image",
                        'full' => $full_img[0],
                        'thumb' => $img[0],
                        "img_id" => $mid
                    );
                } else {
                    $default_img = esc_url($carspot_theme['default_related_image']['url']);
                    $video_img_arr[] = array(
                        "type" => "image",
                        'full' => $default_img,
                        'thumb' => $default_img,
                        "img_id" => $mid
                    );
                }
            }
        }

        return $video_img_arr;
    }

}

/* check terms and taxonomy exist for 3party API */
if (!function_exists('APIcheckTermExist')) {

    function APIcheckTermExist($term_val = '', $taxo_name = '', $field_type_name = '', $title = '', $car_make = '')
    {
        $output = $inserted_id = array();
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $ad_pid = get_user_meta($user_id, 'ad_in_progress', true);
        $is_update = '';
        //===============
        if ($term_val != '' && $taxo_name != '') {
            if ($taxo_name == "ad_cats") {
                /* if we have 2 parameter then parent category add */
                if ($car_make == '') {
                    $output = array("success" => false, "term_value" => $term_val, "taxonomy" => $taxo_name);
                    $term_value = term_exists($term_val, $taxo_name);
                    if ($term_value == '') {
                        $inserted_term_ids = wp_insert_term($term_val, $taxo_name);
                        $inserted_term_id = $inserted_term_ids['term_id'];
                        $output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $inserted_term_id, 0, $title, '', '', '1', true, '', $is_update);
                    } else {
                        $inserted_term_id = $term_value['term_id'];
                        $output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $inserted_term_id, 0, $title, '', '', '1', true, '', $is_update);
                    }

                    return $output;
                } else {
                    $output = array("success" => false, "term_value" => $term_val, "taxonomy" => $taxo_name);
                    /* if parent exist */
                    $term_value_id = term_exists($car_make, $taxo_name);
                    $term_value_child_id = term_exists($term_val, $taxo_name);

                    if ($term_value_id['term_id'] != '' && $term_value_child_id == '') {
                        $inserted_term_ids = wp_insert_term($term_val, $taxo_name, array(
                            'parent' => $term_value_id['term_id'],
                        ));
                        $inserted_term_id = $inserted_term_ids['term_id'];
                        $parent_term_id = $term_value_id['term_id'];
                        //$output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $parent_term_id, 0, $title, '', '', '1', true, '', $is_update);
                        $output = array(
                            "success" => true,
                            "term_value" => $term_val,
                            "taxonomy" => $taxo_name,
                            "message" => "added",
                            "sub_cat_id" => $inserted_term_id
                        );
                    } else {
                        $inserted_term_id = $term_value_child_id['term_id'];
                        $parent_term_id = $term_value_id['term_id'];
                        //$output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $parent_term_id, 0, $title, '', '', '1', true, '', $is_update);
                        $output = array(
                            "success" => true,
                            "term_value" => $term_val,
                            "taxonomy" => $taxo_name,
                            "message" => "added",
                            "sub_cat_id" => $inserted_term_id
                        );
                    }

                    return $output;
                }
            } else {
                //=====
                $output = array(
                    "success" => false,
                    "term_value" => $term_val,
                    "taxonomy" => $taxo_name,
                    "message" => ''
                );
                $term_value = term_exists($term_val, $taxo_name);
                if ($term_value == '') {
                    $inserted_term_ids = wp_insert_term($term_val, $taxo_name);
                    $inserted_term_id = $inserted_term_ids['term_id'];
                    $output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $inserted_term_id, 0, $title, '', '', '2', true, '', $is_update);
                } else {
                    $inserted_term_id = $term_value['term_id'];
                    $output = API_carspotAPI_getPostAdFields('select', $field_type_name, $taxo_name, $inserted_term_id, 0, $title, '', '', '2', true, '', $is_update);
                }

                return $output;
            }
        } else {
            return $output = array("success" => false, "term_value" => $term_val, "taxonomy" => $taxo_name);
        }
        //===============
    }

}

if (!function_exists('API_carspotAPI_getPostAdFields')) {

    function API_carspotAPI_getPostAdFields($field_type = '', $field_type_name = '', $term_type = 'ad_cats', $inserted_term_id = '', $only_parent = 0, $name = '', $mainTitle = '', $defaultValue = '', $has_page_number = "1", $is_required = false, $update_val = '', $ad_id = '')
    {
        global $carspotAPI;
        $inserted_term_id_ = $inserted_term_id;
        $count = 0;
        $values = '';
        $returnType = 1;
        $values_arr = $new_arr = array();
        $has_cat_template = false;
        $has_template = false;
        if ($field_type == "select" || $field_type == "checkbox") {
            $termsArr = array();
            if (is_array($term_type)) {
                $is_multiArr = carspotAPI_is_multiArr($term_type);
                if ($is_multiArr == true) {
                    $term_type = carspotAPI_arraySearch($term_type, "key", $update_val);
                    foreach ($term_type as $val) {
                        $termsArr[] = array
                        (
                            "id" => (string)$val['key'],
                            "name" => $val['val'],
                            "has_sub" => false,
                            "has_template" => false,
                            "is_show" => $val['is_show'],
                        );
                    }
                } else {
                    foreach ($term_type as $key => $val) {
                        $termsArr[] = array
                        (
                            "id" => (string)$key,
                            "name" => $val,
                            "has_sub" => false,
                            "has_template" => false,
                            "is_show" => true,
                        );
                    }
                }
            } else {
                $has_cat_template = ($term_type == "ad_cats") ? true : false;
                $terms = get_terms(array(
                    'taxonomy' => $term_type,
                    'hide_empty' => false,
                    'parent' => $only_parent,
                ));
                $ad_cats = array();
                //when we value update
                if ($ad_id != "") {
                    $ad_cats = wp_get_object_terms($ad_id, $term_type, array('fields' => 'ids'));

                    /* Years */
                    if ($term_type == "ad_years") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_years', true);
                    }
                    /* Body Types */
                    if ($term_type == "ad_body_types") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_body_types', true);
                    }
                    /* Engine Capacities */
                    if ($term_type == "ad_engine_capacities") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_engine_capacities', true);
                    }
                    /* Engine Type */
                    if ($term_type == "ad_engine_types") {
                        $ad_cats = carspotAPI_getCats_idz($ad_id, 'ad_engine_types', true);
                    }
                    if (count($ad_cats) > 0) {
                        $count_update_val = count($ad_cats) - 1;
                        $finalCatID = $ad_cats[$count_update_val];
                        $term_data = get_term_by('id', $finalCatID, $term_type);
                        $terms = carspotAPI_objArraySearch($terms, 'term_id', $finalCatID, $term_data);
                        if ($term_type != 'ad_cats') {
                            $update_val = $terms[0]->term_id . "|" . $terms[0]->name;
                        }
                    }
                }

                $catNames = '';
                $catIDS = '';
                if (count($terms)) {
//                    if (count($ad_cats) == 0) {
//                        if ($field_type != "checkbox") {
//                            $termsArr[] = array
//                            (
//                                "id" => "",
//                                "name" => __("Select Option", "carspot-rest-api"),
//                                "has_sub" => false,
//                                "has_template" => false,
//                                "is_show" => true,
//                            );
//                        }
//                    }
                    /* work for moving new added index to top */
                    $new_arr = $new_arr_val = array();
                    foreach ($terms as $ad_trm) {
                        if ($inserted_term_id_ != $ad_trm->term_id) {
                            $new_arr[$count++] = $ad_trm->term_id;
                        }
                    }
                    $arr_temp_id = array($inserted_term_id_);
                    $new_arr_val = array_merge($arr_temp_id, $new_arr);
                    $terms = $new_arr_val;
                    /* END work for moving new added index to top */
                    foreach ($terms as $ad_trm) {
                        $term_detail = (get_term($ad_trm));
                        if ($term_detail != '') {

                            $term_children = get_term_children(filter_var(@$term_detail->term_id, FILTER_VALIDATE_INT), filter_var($term_type, FILTER_SANITIZE_STRING));
                            $has_sub = (empty($term_children) || is_wp_error($term_children)) ? false : true;
                            $selected = ($term_detail->term_id == $inserted_term_id) ? true : false;
                            $termsArr[] = array
                            (
                                "id" => (string)$term_detail->term_id,
                                "name" => htmlspecialchars_decode(@$term_detail->name, ENT_NOQUOTES),
                                "value" => (string)$term_detail->term_id . '|' . htmlspecialchars_decode(@$term_detail->name, ENT_NOQUOTES),
                                "has_sub" => $has_sub,
                                "has_template" => $has_template,
                                "is_show" => true,
                                "is_checked" => $selected,
                                "count" => $term_detail->count,
                            );
                        }
                    }
                }
            }
            $values = $termsArr;
        }
        $values_data = $values;

        return array(
            "main_title" => $mainTitle,
            "field_type" => $field_type,
            "field_type_name" => $field_type_name,
            "field_val" => $update_val,
            "field_name" => "",
            "title" => $name,
            "values" => $values_data,
            "has_page_number" => (string)$has_page_number,
            "is_required" => $is_required,
            "has_cat_template" => $has_cat_template
        );
    }

}

// remove space if variable have space
if (!function_exists('carspot_api_remove_space')) {

    function carspot_api_remove_space($contect = '')
    {
        if ($contect === " ") {
            return str_replace(" ", "", $contect);
        } else {
            return $contect;
        }
    }

}

if (!function_exists('API_carspot_get_formated_description')) {
    function API_carspot_get_formated_description($content)
    {
        $allow_tags = array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'ul' => carspot_required_attributes(),
            'ol' => carspot_required_attributes(),
            'p' => carspot_required_attributes(),
            'b' => array(),
            'i' => array(),
            'u' => array(),
            'li' => array(),
        );
        $string = wp_kses($content, $allow_tags);

        return nl2br($string);
    }
}
/*
 * get only parent terms
 */
if (!function_exists('carspot_all_get_terms')) {
    function carspot_all_get_terms($taxonomy, $parent = 0)
    {
        $args = array(
            'taxonomy' => array($taxonomy), // taxonomy name
            'orderby' => 'id',
            'order' => 'ASC',
            'hide_empty' => true,
            'fields' => 'all',
            'parent' => $parent
        );
        $terms_get = get_terms($args);
        $count = count($terms_get);
        if ($count > 0) {
            foreach ($terms_get as $term) {
                $term_imgUrl = carspotAPI_taxonomy_image_url($term->term_id, NULL, TRUE);
                $data[] = array('id' => $term->term_id, 'name' => $term->name, 'slug' => $term->slug, 'term_img' => $term_imgUrl, 'term_count' => $term->count);
            }
        } else {
            $data = [];
        }
        return $data;
    }
}

/* ========*****======= */
/*    WPML Functions   */
/*=========*****======= */
/*
 * wpml
 * get language code for app
 * used in api options
 */

function cs_app_languages()
{
    global $sitepress;
    if (function_exists('icl_object_id')) {
        $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
        $langs = array();

        if (!empty($languages)) {
            foreach ($languages as $lng) {
                $langs[$lng['code']] = esc_html__($lng['native_name'], 'carspot-rest-api');
            }
        }
        return $langs;
    }
}

/*
 * get language details
 */
function get_language_details($code = '')
{
    global $sitepress;
    $lang_details = array();
    if (function_exists('icl_object_id')) {
        $all_languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
        foreach ($all_languages as $key => $each_lang) {
            if ($code == $key) {
                //$languages = $each_lang;
                $lang_details['code'] = $each_lang['code'];
                $lang_details['native_name'] = $each_lang['native_name'];
                $lang_details['english_name'] = $each_lang['translated_name'];
                $lang_details['lang_flag'] = $each_lang['country_flag_url'];
                break;
            }
        }
        return $lang_details;
    }
}

/*
 * Change App Direction
 */
if (!function_exists('csAPI_app_direction_callbacks')) {
    function csAPI_app_direction_callbacks($app_dir = 'ltr')
    {
        if (function_exists('icl_object_id')) {
            if (apply_filters('wpml_is_rtl', NULL)) {
                $app_dir = 'rtl';
            } else {
                $app_dir = 'ltr';
            }
        }
        return $app_dir;
    }
}

/* == wpml ( display result within all language or only current language.)  == */
if (!function_exists('cs_wpml_show_all_posts_callback_rest_api')) {

    function cs_wpml_show_all_posts_callback_rest_api($query_args = array(), $option_name = 'carspotAPI', $option_key_name = 'display_all_wpml_app_posts')
    {
        if (carspot_Api_check_wpml_installed() && $query_args != '') {
            global $sitepress;
            $cs_show_posts = false;
            $cs_theme_option = get_option($option_name);
            $cs_display_post = ($cs_theme_option[$option_key_name]);
            if (!is_admin()) {
                if (class_exists('Redux')) {
                    $cs_show_posts = $cs_display_post;
                }
                if ($cs_show_posts == true) {
                    do_action('cs_wpml_terms_filters');
                    $query_args['suppress_filters'] = $cs_show_posts;
                }
            }
        }
        return $query_args;
    }

}

/* ======================
 * check wpml installed
 * and activated
 * (used)
 ======================= */
if (!function_exists('carspot_Api_check_wpml_installed')) {
    function carspot_Api_check_wpml_installed()
    {
        if (function_exists('icl_object_id')) {
            return true;
        } else {
            return false;
        }
    }
}