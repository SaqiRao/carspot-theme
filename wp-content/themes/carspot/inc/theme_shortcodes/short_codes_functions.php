<?php
if (!function_exists('carspot_color_text')) {

    function carspot_color_text($str='')
    {
        preg_match('~{color}([^{]*){/color}~i', $str, $match);
        if (isset($match[1])) {
            $search = "{color}" . $match[1] . "{/color}";
            $replace = '<span class="heading-color">' . $match[1] . '</span>';
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }
}

if (!function_exists('carspot_getHeader')) {

    function carspot_getHeader($sb_section_title='', $sb_section_description='', $style = 'classic')
    {
        if ($style != '') {
            $align_text = '';
            if ($style == 'classic') {
                $align_text = 'text-center';
            } else {
                $align_text = 'left-side';
            }
            $desc = '';
            if ($sb_section_description != '') {
                $desc = '<p class="heading-text">' . $sb_section_description . '</p>';
            }
            $main_title = carspot_color_text($sb_section_title);
            return '<div class="heading-panel">
				 <div class="col-xs-12 col-md-12 col-sm-12 ' . $align_text . '">
					<!-- Main Title -->
					<h2>' . $main_title . '</h2>
					<!-- Short Description -->
					' . $desc . '
				 </div>
			  </div>';
        }
    }
}

// Get param array
if (!function_exists('carspot_generate_type')) {

    function carspot_generate_type($heading = '', $type = '', $para_name = '', $description = '', $group = '', $values = array(), $default = '', $class = 'vc_col-sm-12 vc_column', $dependency = '', $holder = 'div')
    {

        $val = '';
        if (count((array) $values) > 0) {
            $val = $values;
        }

        return array(
            "group" => $group,
            "type" => $type,
            "holder" => $holder,
            "class" => "",
            "heading" => $heading,
            "param_name" => $para_name,
            "value" => $val,
            "description" => $description,
            "edit_field_class" => $class,
            "std" => $default,
            'dependency' => $dependency,
        );
    }
}

if (!function_exists('carspot_ThemeBtn')) {

    function carspot_ThemeBtn($section_btn = '', $class = '', $onlyAttr = false, $iconBefore = '', $iconAfter = '')
    {
        $buttonHTML = "";
        if (isset($section_btn) && $section_btn != "") {
            $button = carspot_extarct_link($section_btn);
            $class = ($class != "") ? 'class="' . esc_attr($class) . '"' : '';
            $rel = (isset($button["rel"]) && $button["rel"] != "") ? ' rel="' . esc_attr($button["rel"]) . ' "' : "";
            $href = (isset($button["url"]) && $button["url"] != "") ? ' href="' . esc_url($button["url"]) . ' "' : "javascript:void(0);";
            $title = (isset($button["title"]) && $button["title"] != "") ? ' title="' . esc_attr($button["title"]) . '"' : "";
            $target = (isset($button["target"]) && $button["target"] != "") ? ' target="' . esc_attr($button["target"]) . '"' : "";
            $titleText = (isset($button["title"]) && $button["title"] != "") ? esc_html($button["title"]) : "";
            if (isset($button["url"]) && $button["url"] != "") {
                $btn = ($onlyAttr == true) ? $href . $target . $class . $rel : '<a ' . $href . ' ' . $target . ' ' . $class . ' ' . $rel . '>' . $iconBefore . ' ' . esc_html__($titleText,'carspot') . ' ' . $iconAfter . '</a>';
                $buttonHTML = (isset($title)) ? $btn : "";
            }
        }
        return $buttonHTML;
    }
}

if (!function_exists('carspot_extarct_link')) {

    function carspot_extarct_link($string = '') {
        $arr = @explode('|', (string) $string);
        $rel = '';
        $target = '';
        $title = '';
        $url = '';
        if (isset($arr) && !empty($arr) && is_array($arr) && sizeof($arr) > 0) {
            foreach ($arr as $value) {
                $ext_val = carspot_themeGetExplode($value, ':');
                if (isset($ext_val[0]) && $ext_val[0] == 'url') {
                    $url = isset($ext_val[1]) && $ext_val[1] != '' ? urldecode($ext_val[1]) : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'title') {
                    $title = isset($ext_val[1]) && $ext_val[1] != '' ? urldecode($ext_val[1]) : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'target') {
                    $target = isset($ext_val[1]) && $ext_val[1] != '' ? $ext_val[1] : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'rel') {
                    $rel = isset($ext_val[1]) && $ext_val[1] != '' ? $ext_val[1] : '';
                }
            }
        }
        return array("url" => $url, "title" => $title, "target" => $target, "rel" => $rel);
    }

}

if (!function_exists('carspot_themeGetExplode')) {

    function carspot_themeGetExplode($string = "", $explod = "", $index = "")
    {
        $ar = '';
        if ($string != "") {
            $exp = explode($explod, $string);
            $ar = ($index != "") ? $exp[$index] : $exp;
        }
        return ($ar != "") ? $ar : "";
    }
}

// BG Color or Image
if (!function_exists('carspot_bg_func')) {

    function carspot_bg_func($sb_bg_color='', $sb_bg = '')
    {
        $bg = '';
        if ($sb_bg_color == 'bg_img') {
            $bgimg = wp_get_attachment_image_src($sb_bg, 'full');
            if ($bgimg[0] != "") {
                $bg = $bgimg[0];
            }
        }
        return array('url' => $bg, 'color' => $sb_bg_color);
    }
}

if (!function_exists('carspot_returnImgSrc')) {

    function carspot_returnImgSrc($id='', $size = 'full', $showHtml = false, $class = '', $alt = '')
    {
        global $carspot_theme;
        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                $img1 = wp_get_attachment_image_src($id, $size);
                if (wp_attachment_is_image($id)) {
                    $img = $img1[0];
                } else {
                    $img = esc_url($carspot_theme['default_related_image']['url']);
                }
            } else {
                $class = ($class != "") ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ($alt != "") ? 'alt="' . esc_attr($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }
}


if (!function_exists('carspot_VCImage')) {

    function carspot_VCImage($imgName = '')
    {
        $val = '';
        if ($imgName != "") {
            $path = esc_url(trailingslashit(get_template_directory_uri()) . 'vc_images/' . $imgName);
            $val = '<img src="' . esc_url($path) . '" style="width:100%" class="img-responsive">';
        }
        return $val;
    }
}

// Get cats
if (!function_exists('carspot_cats')) {

    function carspot_cats($taxonomy = 'ad_cats', $all = 'yes')
    {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = get_terms($taxonomy, array('hide_empty' => 0));
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }
}

if (!function_exists('carspot_get_parests')) {

    function carspot_get_parests($taxonomy='', $all = 'yes')
    {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = carspot_get_cats($taxonomy, 0);
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }
}

if (!function_exists('carspot_get_all')) {

    function carspot_get_all($taxonomy='', $all = 'yes')
    {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = carspot_get_cats($taxonomy, 0);
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name] = $cat->name;
                }
            }
            return $cats;
        }
    }
}


// Get Products
if (!function_exists('carspot_get_products')) {

    function carspot_get_products()
    {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
        }
        return $products;
    }
}

if (!function_exists('carspot_get_location')) {

    function carspot_get_location($call_back = '')
    {
        global $carspot_theme;
        $api_key = $carspot_theme['gmap_api_key'];
        return $snippnet = '<script src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&callback=' . $call_back . '" type="text/javascript"></script>';
    }
}

// get latitude and longitude
if (!function_exists('carspot_lat_long')) {

    function carspot_lat_long($address='')
    {
        global $carspot_theme;
        $api_key = $carspot_theme['gmap_api_key'];

        $param = "?address=" . $address . "&key=" . $api_key;
        $url = esc_url("https://maps.googleapis.com/maps/api/geocode/json") . $param;
        $json = wp_remote_get($url);
        $res = $data = json_decode($json['body'], true);

        $latitude = $res['results'][0]['geometry']['location']['lat'];
        $longitude = $res['results'][0]['geometry']['location']['lng'];

        $send_data = array();
        $send_data[] = $latitude;
        $send_data[] = $longitude;

        return $send_data;
    }
}
if (!function_exists('carspot_add_location')) {

    function carspot_add_location($country = '', $state = '', $city = '')
    {
        global $wpdb;
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");

        $country_id = $country_data->ID;

        $table_name = $wpdb->prefix . 'carspot_locations';


        $state_id = 0;

        $is_state = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'state'  AND name = '$state'");
        if (!isset($is_state->lid)) {
            $res = carspot_lat_long($state . $country);

            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $state . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','state')");
            $state_id = $wpdb->insert_id;
        } else {
            $state_id = $is_state->lid;
        }

        $is_city = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (!isset($is_city->lid)) {
            $res = carspot_lat_long($city . $country);

            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $city . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','city')");
        }
    }
}

// Get lat lon by location
if (!function_exists('carspot_get_latlon')) {

    function carspot_get_latlon($location = '')
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'carspot_locations';
        // Explode location
        $address = explode(',', $location);
        if (count((array) $address) == 1) {
            return array();
        }
        if (count((array) $address) == 3) {
            $country = trim($address[2]);
            $state = trim($address[1]);
            $city = trim($address[0]);
        } else if (count((array) $address) == 2) {
            $country = trim($address[1]);
            $city = trim($address[0]);
        }
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");
        if (count((array) $country_data) == 0) {
            return array();
        }
        $country_id = $country_data->ID;
        $arr = $wpdb->get_row("SELECT latitude,longitude FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (count((array) $arr) > 0) {
            if ($arr->latitude != "" && $arr->longitude != "") {
                return array($arr->latitude, $arr->longitude);
            }
        }
        return array();
    }
}

// Making shortcode function
if (!function_exists('carspot_clean_shortcode')) {

    function carspot_clean_shortcode($string = '')
    {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }
}

// Get Reviews cats
if (!function_exists('carspot_reviews_cats')) {

    function carspot_reviews_cats($taxonomy = 'reviews_cats', $all = 'yes')
    {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = get_terms($taxonomy, array('hide_empty' => 0));
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0) {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }
}


if (!function_exists('carspot_cat_link_page')) {

    function carspot_cat_link_page($category_id = '', $type = '')
    {
        global $carspot_theme;

        $sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);
        $link = carspot_set_url_params_multi(get_the_permalink($sb_search_page), array('cat_id' => $category_id));
        if ($type == 'category') {
            $link = get_term_link((int) $category_id);
        }
        return $link;
    }
}

if (!function_exists('carspot_texnomy_link_page')) {

    function carspot_texnomy_link_page($texnomy_type = '', $type = '')
    {
        global $carspot_theme;
        $sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);
        $link = carspot_set_url_params_multi(get_the_permalink($sb_search_page), array('body_type' => $texnomy_type));
        if ($type == 'category') {
            $link = get_term_link($category_id);
        }
        return $link;
    }
}

if (!function_exists('carspot_location_page_link')) {

    function carspot_location_page_link($location_id = '', $type = '')
    {
        global $carspot_theme;

        $sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);
        $link = carspot_set_url_params_multi(get_the_permalink($sb_search_page), array('country_id' => $location_id));
        if ($type == 'category') {
            $link = get_term_link($location_id);
        }
        return $link;
    }
}

if (!function_exists('carspot_revial_animations')) {

    function carspot_revial_animations()
    {
        $animations = array('bounce' => 'bounce', 'flash' => 'flash', 'pulse' => 'pulse', 'rubberBand' => 'rubberBand', 'shake' => 'shake', 'swing' => 'swing', 'tada' => 'tada', 'wobble' => 'wobble', 'jello' => 'jello', 'bounceIn' => 'bounceIn', 'bounceInDown' => 'bounceInDown', 'bounceInUp' => 'bounceInUp', 'bounceOut' => 'bounceOut', 'bounceOutDown' => 'bounceOutDown', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'bounceOutUp' => 'bounceOutUp', 'fadeIn' => 'fadeIn', 'fadeInDown' => 'fadeInDown', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeft' => 'fadeInLeft', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeInUp' => 'fadeInUp', 'fadeInUpBig' => 'fadeInUpBig', 'fadeOut' => 'fadeOut', 'fadeOutDown' => 'fadeOutDown', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutLeftBig' => 'fadeOutLeftBig', 'fadeOutRightBig' => 'fadeOutRightBig', 'fadeOutUp' => 'fadeOutUp', 'fadeOutUpBig' => 'fadeOutUpBig', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipInY' => 'flipInY', 'flipOutX' => 'flipOutX', 'flipOutY' => 'flipOutY', 'fadeOutDown' => 'fadeOutDown', 'lightSpeedIn' => 'lightSpeedIn', 'lightSpeedOut' => 'lightSpeedOut', 'rotateIn' => 'rotateIn', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInDownRight' => 'rotateInDownRight', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateOut' => 'rotateOut', 'rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutDownRight' => 'rotateOutDownRight', 'rotateOutUpLeft' => 'rotateOutUpLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'slideInUp' => 'slideInUp', 'slideInDown' => 'slideInDown', 'slideInLeft' => 'slideInLeft', 'slideInRight' => 'slideInRight', 'slideOutUp' => 'slideOutUp', 'slideOutDown' => 'slideOutDown', 'slideOutLeft' => 'slideOutLeft', 'slideOutRight' => 'slideOutRight', 'zoomIn' => 'zoomIn', 'zoomInDown' => 'zoomInDown', 'zoomInLeft' => 'zoomInLeft', 'zoomInRight' => 'zoomInRight', 'zoomInUp' => 'zoomInUp', 'zoomOut' => 'zoomOut', 'zoomOutDown' => 'zoomOutDown', 'zoomOutLeft' => 'zoomOutLeft', 'zoomOutUp' => 'zoomOutUp', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut');
        return $animations;
    }
}

if (!function_exists('carspot_video_icon')) {

    function carspot_video_icon()
    {
        global $carspot_theme;
        $video_img = '';
        if (isset($carspot_theme['video_icon']['url']) && $carspot_theme['video_icon']['url'] != "") {
            $video_img = '<img src="' . esc_url($carspot_theme['video_icon']['url']) . '" alt="' . esc_html__('Icon', 'carspot') . '">';
        } else {
            $video_img = '<img src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'images/youtube-flat.png' . '" alt="' . esc_html__('Icon', 'carspot') . '">';
        }

        if (isset($carspot_theme['sb_video_icon']) && $carspot_theme['sb_video_icon'] && get_post_meta(get_the_ID(), '_carspot_ad_yvideo', true)) {
            return '<a href="' . get_post_meta(get_the_ID(), '_carspot_ad_yvideo', true) . '" class="play-video">' . $video_img . '</a>';
        }
    }
}


// Get Products
if (!function_exists('carspot_get_packages')) {

    function carspot_get_packages()
    {
        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_packages_pricing'
                ),
            ),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
        }
        return $products;
    }
}

// edit pages as front-end with vc-composer

if (!function_exists('carspot_vc_forntend_edit')) {

    function carspot_vc_forntend_edit()
    {
        return function_exists('vc_is_inline') && vc_is_inline() ? true : false;
    }
}
