<?php
/**
 * About us Classic
 */
if (!function_exists('cs_elementor_about_classic')) {

    function cs_elementor_about_classic($params)
    {
        $section_title_about = $sell_tagline = $section_description = $main_image = $img_postion = $revail_animation = '';
        $title = $img_left = $img_right = $left_column = '';
        $services_add_left = array();

        $section_title_about = $params['section_title_about'];
        $sell_tagline = $params['sell_tagline'];
        $section_description = $params['section_description'];
        $main_image_ = $params['main_image'];
        $img_postion = $params['img_postion'];
        $services_add_left = $params['services_add_left'];
        $revail_animation = $params['animation_effects'];

        /* title */
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<div class="title"><h3>' . carspot_color_text($section_title_about) . '</h3></div>';
        }
        /* image position left/right */
        $main_image = carspot_returnImgSrc($main_image_);
        if ($img_postion == 'left') {
            $img_left = '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><img src="' . $main_image . '" class="wow ' . $revail_animation . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        } else {
            $img_right = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . $main_image . '" class="wow ' . $revail_animation . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        }

        /* left columns */
        if ($services_add_left) {
            foreach ($services_add_left as $item) {
                $left_column .= '<div class="col-md-3 col-xs-12 col-sm-6">
                     <!-- services grid -->
                     <div class="services-grid">
                        <div class="icons"><i class="' . $item['icon'] . '"></i></div>
                        <h4>' . $item['serv_title'] . '</h4>
                       <p>' . $item['serv_desc'] . '</p>
                     </div>
                  </div>';
            }
        }


        return '<section class="custom-padding about-us">
            <div class="container">
               <div class="row">
			      ' . $img_left . '
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    ' . $title . '
                     <div class="content">
                        <p class="service-summary">' . $sell_tagline . '</p>
                        <p>' . $section_description . '</p>
                     </div>
                  </div>
                  ' . $img_right . '
               </div>
               <div class="row margin-top-20">
                 ' . $left_column . '
               </div>
            </div>
         </section>';
    }

}

/* About Us Fancy */
if (!function_exists('cs_elementor_about_fancy')) {

    function cs_elementor_about_fancy($params)
    {
        $title = $bg_img = $section_title_about = $section_description = $services_add_left = $content = $p_cols = $fun_facts = '';
        $left_column = $fun_html = $img_left = $main_img = '';
        /* getting values */
        $bg_img = $params['bg_img'];
        $section_title_about = $params['section_title_about'];
        $section_description = $params['section_description'];
        $services_add_left = $params['services_add_left'];
        $content = $params['content'];
        $p_cols = $params['p_cols'];
        $fun_facts = $params['fun_facts'];
        /* title */
        if (isset($section_title_about) && $section_title_about != '') {
            $title = carspot_color_text($section_title_about);
        }

        /* left column */
        if (is_array($services_add_left) && count($services_add_left) > 0) {
            foreach ($services_add_left as $row) {
                $left_column .= '<li><a href="javascript:void(0)">' . $row['services'] . '</a></li>';
            }
        }

        /* Fun Facts */
        if (count($fun_facts) > 0) {
            foreach ($fun_facts as $row) {
                if (isset($row['numbers']) && isset($row['title'])) {
                    $color_html = '';
                    if (isset($row['color_title']))
                        $color_html = '<span>' . $row['color_title'] . '</span>';
                    $icon_html = '';
                    if (isset($row['icon']))
                        $icon_html = '<div class="icons">
                        <i class="' . esc_attr($row['icon']) . '"></i>
                     </div>';
                    $fun_html .= '<div class="col-lg-' . esc_attr($p_cols) . ' col-md-' . esc_attr($p_cols) . ' col-sm-6 col-xs-6">
						' . $icon_html . '
                     <div class="number"><span class="timer" data-from="0" data-to="' . $row['numbers'] . '" data-speed="1500" data-refresh-interval="5">0</span></div>
                     <h4>' . $row['title'] . ' ' . $color_html . '</h4>
                  </div>';
                }
            }
        }

        /* image */
        if (wp_attachment_is_image($bg_img)) {
            $main_img = carspot_returnImgSrc($bg_img);
        } else {
            $main_img = get_template_directory_uri() . '/images/mechanic.png';
        }
        if (isset($main_img) && $main_img != '') {
            $img_left = '<img src="' . $main_img . '" class="center-block img-responsive" alt="' . esc_html__('Image Not Found', 'carspot') . '">';
        }
        return '<section class="custom-padding id="about-section-3">
            <div class="container">
               <div class="row">
                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                     <div class="about-title">
                        <h2>' . $title . '</h2>
                        <p>' . $section_description . '</p>
                        <ul class="custom-links">
                          ' . $left_column . '
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                     <div class="right-side">
                         ' . $content . '
                       ' . $img_left . '
                     </div>
                  </div>
               </div>
               <div class="row about-stats">
                  <div class="">
                    ' . $fun_html . '
                  </div>
               </div>
            </div>
         </section>';
    }

}

/**
 * About Us Simple
 */
if (!function_exists('cs_elementor_about_simple')) {

    function cs_elementor_about_simple($params)
    {
        $img_left = $img_right = $left_column = $title = $animation_effects = $main_img = '';
        $section_title_about = $section_description = $attach_image = $img_postion = '';
        $section_title_about = $params['section_title_about'];
        $section_description = $params['section_description'];
        $attach_image = $params['attach_image'];
        $img_postion = $params['img_postion'];
        $animation_effects = $params['animation_effects'];

        /* title */
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        /* image on left/right */
        $main_img = carspot_returnImgSrc($attach_image);
        if (isset($main_img) && $main_img != '') {
            if ($img_postion == 'left') {
                $img_left = '<div class="col-md-5 col-sm-12 col-xs-12"><div class="border-around"><img src="' . $main_img . '" class="wow ' . $animation_effects . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div></div>';
            } else {
                $img_right = '<div class="col-md-5 col-sm-12 col-xs-12"><div class="border-around"><img src="' . $main_img . '" class="wow ' . $animation_effects . ' center-block img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div></div>';
            }
        }

        return '<section class="section-padding" id="about">
         <div class="container">
            <div class="row clearfix">
               <!--Column-->
			   ' . $img_left . '
               <div class="col-md-7 col-sm-12 col-xs-12 ">
                  <div class="about-title">
                     ' . $title . '
                     <p>' . $section_description . '</p>
                  </div>
               </div>
               <!-- RIght Grid Form -->
			   ' . $img_right . '
            </div>
         </div>
      </section>';
    }

}

/*
 * Ad Post/Sell your Car
 */
if (!function_exists('cs_elementor_ad_post')) {

    function cs_elementor_ad_post($params)
    {
        global $carspot_theme;
        global $woocommerce;
        $_type = $params['_type'];
        $extra_section_title = $params['extra_section_title'];
        $tip_section_title = $params['tip_section_title'];
        $tips_description = $params['tips_description'];
        $fields = $params['fields'];
        $tips_ = $params['tips'];

        /* if sell your car switch off */
        $sell_car_switch = isset($carspot_theme['ad_in_menu']) ? $carspot_theme['ad_in_menu'] : true;
        $sell_your_car_flag = false;
        if (isset($sell_car_switch) && $sell_car_switch) {
            $sell_your_car_flag = true;
        } else if (current_user_can('administrator')) {
            $sell_your_car_flag = true;
        }
        if ($sell_your_car_flag) {
            /*
             * 1/yes mean category base form
             * 0/no mean default form
             * */
            $input__type = ($_type == "yes") ? 1 : 0;
            update_option('_carspot_current_ad_post_template', $_type);
// Making tips
//$rows = vc_param_group_parse_atts($atts['tips']);
            $tips = '';
            if (is_array($tips_) && count($tips_) > 0) {
                foreach ($tips_ as $row) {
                    if (isset($row['description'])) {
                        $tips .= '<li>' . $row['description'] . '</li>';
                    }
                }
            }

            $profile = new carspot_profile();
            $size_arr = explode('-', $carspot_theme['sb_upload_size']);
            $display_size = $size_arr[1];
            $actual_size = $size_arr[0];

            /* brochure upload size */
            $pdf_brochure_size_arr = explode('-', $carspot_theme['pdf_brochure_size']);
            $pdf_brochure_display_size = $pdf_brochure_size_arr[1];
            $pdf_brochure_actual_size = $pdf_brochure_size_arr[0];
            /* default pdf logo */
            $pdf_brochure_logo_url = get_template_directory_uri() . '/images/pdf-logo.png';
            die();
            carspot_user_not_logged_in();
            $cart_total = '';

//check payment type now only for category based
            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based') {
                if (isset($carspot_theme['show_cart_total']) && $carspot_theme['show_cart_total'] == 1) {
                    $cart_title = '';
                    $animation = '';
                    if (isset($carspot_theme['cart_float_text']) && $carspot_theme['cart_float_text'] != "") {
                        $cart_title = $carspot_theme['cart_float_text'];
                    }
                    if (isset($carspot_theme['cart_float_animation']) && $carspot_theme['cart_float_animation'] != "") {
                        $animation = $carspot_theme['cart_float_animation'];
                    }
                    $WC_CartData = new WC_Cart();
                    $cart_total = '
                            <a id="quick-cart-pay" class="wow ' . $animation . ' animated" data-wow-delay="300ms" data-wow-iteration="infinite" data-wow-duration="2s" href="javascript:void(0)">
				<span>
                                    <strong class="quick-cart-text">' . $WC_CartData->get_cart_total() . '<br></strong>
                                    <span id="sb-quick-cart-price">sdg</span>
				</span>
                            </a>';
                }
            }
            $description = '';
            $title = '';
            $price = '';
            $avg_city = '';
            $avg_hwy = '';
            $poster_name = '';
            $poster_ph = '';
            $ad_mapLocation = '';
            $ad_location = '';
            $ad_condition = '';
            $is_update = '';
            $level = '';

            $cats_html = '';
            $sub_cats_html = '';
            $sub_sub_cats_html = '';
            $sub_sub_sub_cats_html = '';

            $type_selected = '';
            $ad_type = '';
            $ad_warranty = '';
            $ad_year = '';
            $ad_body_type = '';
            $ad_transmission = '';
            $ad_engine_capacity = '';
            $ad_engine_type = '';
            $ad_assemble = '';
            $ad_color = '';
            $ad_insurance = '';
            $adfeatures = '';
            $ad_mileage = '';
            $tags = '';
            $id = '';
            $ad_yvideo = '';
            $ad_map_lat = '';
            $ad_map_long = '';
            $ad_bidding = '';
            $levelz = '';
            $country_html = '';
            $country_states = '';
            $country_cities = '';
            $country_towns = '';
            $ad_price_type = '';
            $is_feature_ad = 0;
            $is_bump_ad = 0;
            $heading1 = '';
//$review_by_company = '';
            if (isset($carspot_theme['cat_level_1']) && $carspot_theme['cat_level_1'] != "") {
                $heading1 = $carspot_theme['cat_level_1'];
            }
            $heading2 = '';
            if (isset($carspot_theme['cat_level_2']) && $carspot_theme['cat_level_2'] != "") {
                $heading2 = $carspot_theme['cat_level_2'];
            }
            $heading3 = '';
            if (isset($carspot_theme['cat_level_3']) && $carspot_theme['cat_level_3'] != "") {
                $heading3 = $carspot_theme['cat_level_3'];
            }
            $heading4 = '';
            if (isset($carspot_theme['cat_level_4']) && $carspot_theme['cat_level_4'] != "") {
                $heading4 = $carspot_theme['cat_level_4'];
            }
            if (isset($_GET['id']) && $_GET['id'] != "") {

                $id = $_GET['id'];
                $my_url = carspot_get_current_url();
                if (strpos($my_url, 'carspot.scriptsbundle.com') !== false && !is_super_admin(get_current_user_id())) {
                    echo carspot_redirect(home_url('/'));
                    exit;
                }
                if (get_post_field('post_author', $id) != get_current_user_id() && !is_super_admin(get_current_user_id())) {
                    echo carspot_redirect(home_url('/'));
                    exit;
                } else {
                    $post = get_post($id);
                    $description = $post->post_content;
                    $title = $post->post_title;
                    $price = get_post_meta($id, '_carspot_ad_price', true);
                    $avg_city = get_post_meta($id, '_carspot_ad_avg_city', true);
                    $avg_hwy = get_post_meta($id, '_carspot_ad_avg_hwy', true);
                    $poster_name = get_post_meta($id, '_carspot_poster_name', true);
                    $poster_ph = get_post_meta($id, '_carspot_poster_contact', true);
                    $ad_location = get_post_meta($id, '_carspot_ad_location', true);
                    $ad_condition = get_post_meta($id, '_carspot_ad_condition', true);
                    $ad_type = get_post_meta($id, '_carspot_ad_type', true);
                    $ad_warranty = get_post_meta($id, '_carspot_ad_warranty', true);
                    $ad_year = get_post_meta($id, '_carspot_ad_years', true);
                    $ad_body_type = get_post_meta($id, '_carspot_ad_body_types', true);
                    $ad_transmission = get_post_meta($id, '_carspot_ad_transmissions', true);
                    $ad_engine_capacity = get_post_meta($id, '_carspot_ad_engine_capacities', true);
                    $ad_engine_type = get_post_meta($id, '_carspot_ad_engine_types', true);
                    $ad_assemble = get_post_meta($id, '_carspot_ad_assembles', true);
                    $ad_color = get_post_meta($id, '_carspot_ad_colors', true);
                    $ad_insurance = get_post_meta($id, '_carspot_ad_insurance', true);
                    $adfeatures = get_post_meta($id, '_carspot_ad_features', true);
                    $ad_mileage = get_post_meta($id, '_carspot_ad_mileage', true);
                    $ad_yvideo = get_post_meta($id, '_carspot_ad_yvideo', true);
//$review_by_company = get_post_meta($id, '_carspot_review_by_company', true);
                    $ad_map_lat = get_post_meta($id, '_carspot_ad_map_lat', true);
                    $ad_map_long = get_post_meta($id, '_carspot_ad_map_long', true);
                    $ad_bidding = get_post_meta($id, '_carspot_ad_bidding', true);
                    $ad_price_type = get_post_meta($id, '_carspot_ad_price_type', true);
                    $is_feature_ad = get_post_meta($id, '_carspot_is_feature', true);
                    $is_bump_ad = get_post_meta($id, '_carspot_bump_ads', true);

                    $ad_mapLocation = get_post_meta($id, '_carspot_ad_map_location', true);
                    $tags_array = wp_get_object_terms($id, 'ad_tags', array('fields' => 'names'));
                    $tags = implode(',', $tags_array);

                    $is_update = $id;
                    $cats = carspot_get_ad_cats($id, 'ID');

                    $level = count($cats);
                    /* Make cats selected on update ad */
                    $ad_cats = carspot_get_cats('ad_cats', 0);
                    $cats_html = '';
                    foreach ($ad_cats as $ad_cat) {
                        $selected = '';
                        if ($level > 0 && $ad_cat->term_id == $cats[0]['id']) {
                            $selected = 'selected="selected"';
                        }
                        $cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '>' . $ad_cat->name . '</option>';
                    }

                    if ($level >= 2) {
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cats[0]['id']);
                        $sub_cats_html = '';
                        foreach ($ad_sub_cats as $ad_cat) {
                            $selected = '';
                            if ($level > 0 && $ad_cat->term_id == $cats[1]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '>' . $ad_cat->name . '</option>';
                        }
                    }

                    if ($level >= 3) {
                        $ad_sub_sub_cats = carspot_get_cats('ad_cats', $cats[1]['id']);
                        $sub_sub_cats_html = '';
                        foreach ($ad_sub_sub_cats as $ad_cat) {
                            $selected = '';
                            if ($level > 0 && $ad_cat->term_id == $cats[2]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $sub_sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '>' . $ad_cat->name . '</option>';
                        }
                    }


                    if ($level >= 4) {
                        $ad_sub_sub_sub_cats = carspot_get_cats('ad_cats', $cats[2]['id']);
                        $sub_sub_sub_cats_html = '';
                        foreach ($ad_sub_sub_sub_cats as $ad_cat) {
                            $selected = '';
                            if ($level > 0 && $ad_cat->term_id == $cats[3]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $sub_sub_sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '>' . $ad_cat->name . '</option>';
                        }
                    }

                    /* Countries */
                    $countries = carspot_get_ad_country($id, 'ID');
                    $levelz = count($countries);
                    /* Make cats selected on update ad */
                    $ad_countries = carspot_get_cats('ad_country', 0);

                    $country_html = '';
                    foreach ($ad_countries as $ad_country) {
                        $selected = '';
                        if ($levelz > 0 && $ad_country->term_id == $countries[0]['id']) {
                            $selected = 'selected="selected"';
                        }
                        $country_html .= '<option value="' . $ad_country->term_id . '" ' . $selected . '>' . $ad_country->name . '</option>';
                    }

                    if ($levelz >= 2) {
                        $ad_states = carspot_get_cats('ad_country', $countries[0]['id']);
                        $country_states = '';
                        foreach ($ad_states as $ad_state) {
                            $selected = '';
                            if ($levelz > 0 && $ad_state->term_id == $countries[1]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $country_states .= '<option value="' . $ad_state->term_id . '" ' . $selected . '>' . $ad_state->name . '</option>';
                        }
                    }

                    if ($levelz >= 3) {
                        $ad_country_cities = carspot_get_cats('ad_country', $countries[1]['id']);
                        $country_cities = '';
                        foreach ($ad_country_cities as $ad_city) {
                            $selected = '';
                            if ($levelz > 0 && $ad_city->term_id == $countries[2]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $country_cities .= '<option value="' . $ad_city->term_id . '" ' . $selected . '>' . $ad_city->name . '</option>';
                        }
                    }

                    if ($levelz >= 4) {
                        $ad_country_town = carspot_get_cats('ad_country', $countries[2]['id']);
                        $country_towns = '';
                        foreach ($ad_country_town as $ad_town) {
                            $selected = '';
                            if ($levelz > 0 && $ad_town->term_id == $countries[3]['id']) {
                                $selected = 'selected="selected"';
                            }
                            $country_towns .= '<option value="' . $ad_town->term_id . '" ' . $selected . '>' . $ad_town->name . '</option>';
                        }
                    }
                }
            } else {
                carspot_post_ad_process();
//only for Package based pricing
                if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based' && class_exists('WooCommerce')) {
                    if (is_super_admin(get_current_user_id())) {

                    } else {
                        if (get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) != '-1') {
                            if (get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) < date('Y-m-d')) {
                                wp_redirect(get_the_permalink($carspot_theme['sb_packages_page']));
                            }
                        }

                        if (!$carspot_theme['admin_allow_unlimited_ads']) {
                            carspot_check_validity();
                        }
                        if (!is_super_admin(get_current_user_id())) {
                            carspot_check_validity();
                        }
                    }
                }

                $poster_name = $profile->user_info->display_name;
                $poster_ph = $profile->user_info->_sb_contact;
                $ad_location = get_user_meta($profile->user_info->ID, '_sb_address', true);

                $ad_cats = carspot_get_cats('ad_cats', 0);
                $cats_html = '';
                foreach ($ad_cats as $ad_cat) {
                    $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
                }

//Countries
                $ad_country = carspot_get_cats('ad_country', 0);
                $country_html = '';
                foreach ($ad_country as $ad_count) {
                    $country_html .= '<option value="' . $ad_count->term_id . '">' . $ad_count->name . '</option>';
                }
            }
            $bump_ad_html = '';
            $simple_feature_html = '';
            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based' && class_exists('WooCommerce')) {
                if (isset($carspot_theme['sb_allow_featured_ads']) && $carspot_theme['sb_allow_featured_ads'] && $is_feature_ad == 0 && (get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) >= date('Y-m-d'))) {
                    if (get_user_meta(get_current_user_id(), '_carspot_featured_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_carspot_featured_ads', true) > 0) {
                        $simple_feature_html = '<div class="alert alert-info alert-featured">
			<span> ' . __('Do you want to make this ad <strong> featured </strong>!', 'carspot') . ' <span>
				<div class="skin-minimal">
				   <ul class="list">
					  <li>
						 <input name="sb_make_it_feature" id="sb_make_it_feature"   type="checkbox">
					  </li>
				   </ul>
				</div>
		   </div>';
                    } else {
                        $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
				' . __('This is a FREE ad. You may upgrade it now! See our PACKAGES', 'carspot') . ' 
				<a href="' . get_the_permalink($carspot_theme['sb_packages_page']) . '" class="sb_anchor" target="_blank">
				' . __('Packages. ', 'carspot') . '
                </a></div>';
                    }
                } else {
                    $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
			' . __('If you want to make it <strong>Featured</strong> then please have a look on', 'carspot') . ' 
			<a href="' . get_the_permalink($carspot_theme['sb_packages_page']) . '" class="sb_anchor" target="_blank">
			' . __('Packages. ', 'carspot') . '
			</a></div>';
                }

                if ($is_feature_ad == 1) {
                    $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
				' . __('This ad is already FEATURED', 'carspot') . '</div>';
                }

//bump up

                $bump_ad_html = '';
                if (isset($is_update) && $is_update != "") {
                    if ($is_bump_ad == 0 && (get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_carspot_expire_ads', true) >= date('Y-m-d'))) {
                        if (get_user_meta(get_current_user_id(), '_carspot_bump_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_carspot_bump_ads', true) > 0) {
                            $bump_ad_html = ' <div class="alert alert-warning alert-bumped">
	 <span>' . esc_html__('Bump it up on the top of the list!', 'carspot') . ' <span>
                                                                            <div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input type="checkbox" name="sb_bump_up" id="sb_bump_up">
						  </li>
					   </ul>
					</div>
				</div>';
                        }
                    }
                }
            }
            $loc_lvl_1 = esc_html__('Select Your Country', 'carspot');
            $loc_lvl_2 = esc_html__('Select Your State', 'carspot');
            $loc_lvl_3 = esc_html__('Select Your City', 'carspot');
            $loc_lvl_4 = esc_html__('Select Your Town', 'carspot');
            if ($carspot_theme['sb_location_titles'] != "") {
                $titles_array = explode("|", $carspot_theme['sb_location_titles']);
                if (count((array)$titles_array) > 0) {
                    if (isset($titles_array[0])) {
                        $loc_lvl_1 = $titles_array[0];
                    }
                    if (isset($titles_array[1])) {
                        $loc_lvl_2 = $titles_array[1];
                    }
                    if (isset($titles_array[2])) {
                        $loc_lvl_3 = $titles_array[2];
                    }
                    if (isset($titles_array[3])) {
                        $loc_lvl_4 = $titles_array[3];
                    }
                }
            }

            $dataFields = '';
            $averageFields = '';
            $customDynamicAdType = '';
            $customDynamicFields = '';

            /*
             * pdf brochure
             */
            $pdf_brochure = '';
            $upload_pdf_limit = isset($carspot_theme['pdf_brochure_upload_limit']) ? $carspot_theme['pdf_brochure_upload_limit'] : '';
            if ($carspot_theme['pdf_brochure_section'] == true) {
                $pdf_brochure = '<div class="row">
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <label class="control-label">' . esc_html__('PDF Brochure:', 'carspot') . ' <small>' . esc_html__('You can upload ', 'carspot') . $upload_pdf_limit . esc_html__(' pdf brochures with size ', 'carspot') . $pdf_brochure_display_size . '</small></label>
                                        <div id="pdf_brochure_dropzone" class="dropzone"></div>
                                    </div>
                                </div>';
            }
            /* if form type is 0/no mean default form */
            if ($_type == 'no') {
        /* Price Type */
        $priceTypeHTML = '';
        if (isset($carspot_theme['allow_price_type'])) {

            if ($carspot_theme['allow_price_type']) {
        
                $ad_price_type_strings = array('Fixed' => __('Fixed', 'carspot'), 'Negotiable' => __('Negotiable', 'carspot'), 'on_call' => __('Price on call', 'carspot'), 'auction' => __('Auction', 'carspot'), 'free' => __('Free', 'carspot'), 'no_price' => __('No price', 'carspot'));
                  
                if (isset($carspot_theme['ad_price_type']) && count($carspot_theme['ad_price_type']) > 0) {
                    $ad_price_type = $carspot_theme['ad_price_type'];
                   
                } else if (isset($carspot_theme['ad_price_type']) && count($carspot_theme['ad_price_type']) == 0 && isset($carspot_theme['ad_price_type_more']) && $carspot_theme['ad_price_type_more'] == "") {

                    $ad_price_type = array('Fixed', 'Negotiable', 'on_call', 'auction', 'free', 'no_price');

                }else{
    
                    $ad_price_type = array();
                   
                }
                $ad_price_type_selected = get_post_meta(get_the_ID(), '_carspot_ad_price_type', true);

                $ad_price_type_html = '';

                if (count($ad_price_type) > 0) {

                    foreach ($ad_price_type as $p_type) {

                        $p_selected = '';

                        if ($p_type == $ad_price_type_selected ){
                            $p_selected = 'selected="selected"';
                        }
    
                        $ad_price_type_html .= '<option value="' . $p_type . '" ' . $p_selected . '>' . $ad_price_type_strings[$p_type] . '</option>';
                      
                   }
                }

                if (isset($carspot_theme['ad_price_type_more']) && $carspot_theme['ad_price_type_more'] != "") {

                    $ad_price_type_more_array = explode('|', $carspot_theme['ad_price_type_more']);
                   
                   
                    foreach ($ad_price_type_more_array as $p_type_more) {

                        $p_selected = '';

                        if ($p_type_more == $ad_price_type)

                            $p_selected = 'selected="selected"';
    
                        $ad_price_type_html .= '<option value="' . $p_type_more . '" ' . $p_selected . '>' . $p_type_more . '</option>';
                        
                    }
                }
                $priceStaticHTML .= '<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6" >
    <label class="control-label">' . esc_html__('Price Type', 'carspot') . '</label>
        <select class="form-control" id="ad_price_type" name="ad_price_type">
              '.$ad_price_type_html.'
    </select>
    </div>';
         }
        }

                $dataFields = '<div class="row">
			  <!-- Price  -->
			  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
				 <label class="control-label">' . esc_html__('Price', 'carspot') . '<small>' . $carspot_theme['sb_currency'] . " " . esc_html__('only', 'carspot') . '</small></label>
				 <input class="form-control" type="text" id="ad_price" name="ad_price" data-parsley-required="true" data-parsley-type="integer" data-parsley-error-message="' . esc_html__('Can\'t be empty and only integers allowed.', 'carspot') . '" value="' . $price . '">
			  </div>
			  ' . $priceStaticHTML . '
	   </div>
	   <!-- Here we create form fields according to taxonomies -->
 	' . carspot_get_term_form($ad_cat->term_id, $id, "static") . '
			
		   <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Photos for your ad', 'carspot') . ' <small>' . esc_html__('Only allowed jpg, png and jpeg and max file will not more than', 'carspot') . " " . $display_size . '</small></label>
				 <div id="dropzone" class="dropzone"></div>
			  </div>
		   </div>
		   <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Youtube Video Link', 'carspot') . '</label>
				 <input class="form-control" type="text" name="ad_yvideo" value="' . $ad_yvideo . '">
			  </div>
		   </div>
		   <div class="row">
				<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
					 <label class="control-label">' . esc_html__('Tags', 'carspot') . ' <small>' . esc_html__('Comma(,) sepataed', 'carspot') . '</small></label>
					 <input class="form-control" name="tags" id="tags" value="' . $tags . '" >
					 
				</div>
			</div>';
            } else {
                $customDynamicFields = '<div id="dynamic-fields"> ' . carspot_returnHTML($id) . ' </div>';
            }
            $extra_fields_html = '';
// Making fields
//$rows = vc_param_group_parse_atts($fields);
            if (isset($fields) && count($fields) > 0) {
                $total_fileds = 1;
                $extra_fields_html .= '<div class="select-package">
			   <div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <h3 class="margin-bottom-10">' . $extra_section_title . '</h3>
				 <hr />
			  </div>
			</div>';
                foreach ($fields as $row) {
                    if (isset($row['title']) && isset($row['type']) && isset($row['slug'])) {
                        $extra_fields_html .= '<div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . $row['title'] . '</label>';
                        if ($row['type'] == 'text') {
                            $extra_fields_html .= '<input class="form-control" value="' . get_post_meta($id, '_sb_extra_' . $row['slug'], true) . '" type="text" name="sb_extra_' . $total_fileds . '" id="sb_extra_' . $total_fileds . '" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '"></div></div>';
                        }
                        if ($row['type'] == 'select' && isset($row['option_values']) && $row['option_values'] != '') {
                            $extra_fields_html .= '<select class="category form-control" id="sb_extra_' . $total_fileds . '" name="sb_extra_' . $total_fileds . '">';
                            $options = explode(',', $row['option_values']);
                            foreach ($options as $key => $value) {
                                $is_select = '';
                                if ($value == get_post_meta($id, '_sb_extra_' . $row['slug'], true)) {
                                    $is_select = 'selected';
                                }
                                $extra_fields_html .= '<option value="' . $value . '" ' . $is_select . '>' . $value . '</option>';
                            }
                            $extra_fields_html .= '</select></div></div>';
                        }
                        $extra_fields_html .= '<input type="hidden" name="title_' . $total_fileds . '" value="' . $row['slug'] . '">';
                        $total_fileds++;
                    }
                }
                $total_fileds = $total_fileds - 1;
                $extra_fields_html .= '<input type="hidden" name="sb_total_extra" value="' . $total_fileds . '">';
            }


            /* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */
            wp_enqueue_style('jquery-tagsinput', trailingslashit(get_template_directory_uri()) . 'css/jquery.tagsinput.min.css');
            wp_enqueue_style('jquery-te', trailingslashit(get_template_directory_uri()) . 'css/jquery-te.css');
            wp_enqueue_style('dropzone', trailingslashit(get_template_directory_uri()) . 'css/dropzone.css');
            carspot_load_search_countries(1);
            $mapType = carspot_mapType();

            if ($mapType == 'google_map') {
                wp_enqueue_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&libraries=places&callback=' . 'carspot_location', false, false, true);
            }

            $update_notice = '';
            if (isset($id) && $id != "") {
                $update_notice = '<div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				<div role="alert" class="alert alert-info alert-dismissible">
					<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
					' . $carspot_theme['sb_ad_update_notice'] . '
				</div>
			</div>
			</div>';
            }

            $lat_long_html = '';
            $lat_lon_script = '';
            $pin_lat = $ad_map_lat;
            $pin_long = $ad_map_long;
            if ($ad_map_lat == "" && $ad_map_long == "" && isset($carspot_theme['sb_default_lat']) && $carspot_theme['sb_default_lat'] && isset($carspot_theme['sb_default_long']) && $carspot_theme['sb_default_long']) {
                $pin_lat = $carspot_theme['sb_default_lat'];
                $pin_long = $carspot_theme['sb_default_long'];
            }
            $for_g_map = '<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <div id="dvMap" style="width: 700px; height: 300px"></div>
			  <em><small>' . esc_html__('Drag pin for your pin-point location.', 'carspot') . '</small></em>
			  </div></div>';
            if ($mapType == 'leafletjs_map') {
                $lat_lon_script = '<script type="text/javascript">	
var mymap = L.map(\'dvMap\').setView([' . $pin_lat . ', ' . $pin_long . '], 13);
	L.tileLayer(\'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png\', {
		maxZoom: 18,
		attribution: \'\'
	}).addTo(mymap);
	var markerz = L.marker([' . $pin_lat . ', ' . $pin_long . '],{draggable: true}).addTo(mymap);
	var searchControl 	=	new L.Control.Search({
		url: \'//nominatim.openstreetmap.org/search?format=json&q={s}\',
		jsonpParam: \'json_callback\',
		propertyName: \'display_name\',
		propertyLoc: [\'lat\',\'lon\'],
		marker: markerz,
		autoCollapse: true,
		autoType: true,
		minLength: 2,
	});
	searchControl.on(\'search:locationfound\', function(obj) {
		
		var lt	=	obj.latlng + \'\';
		var res = lt.split( "LatLng(" );
		res = res[1].split( ")" );
		res = res[0].split( "," );
		document.getElementById(\'ad_map_lat\').value = res[0];
		document.getElementById(\'ad_map_long\').value = res[1];
	});
	mymap.addControl( searchControl );
	
	markerz.on(\'dragend\', function (e) {
	  document.getElementById(\'ad_map_lat\').value = markerz.getLatLng().lat;
	  document.getElementById(\'ad_map_long\').value = markerz.getLatLng().lng;
	});
	

	
</script>';
            } else if ($mapType == 'google_map') {
                if (isset($carspot_theme['allow_lat_lon']) && !$carspot_theme['allow_lat_lon']) {

                } else {
                    $lat_lon_script = '<script type="text/javascript">
    var markers = [
        {
            "title": "",
            "lat": "' . $pin_lat . '",
            "lng": "' . $pin_long . '",
        },
    ];
    window.onload = function () {
        	my_g_map(markers);
        }
		function my_g_map(markers1)
		{
	
			var mapOptions = {
            center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var geocoder = geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            var data = markers1[0]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
                google.maps.event.addListener(marker, "dragend", function (e) {
					document.getElementById("sb_loading").style.display	= "block";
                    var lat, lng, address;
                    geocoder.geocode({ "latLng": marker.getPosition() }, function (results, status) {
						
                        if (status == google.maps.GeocoderStatus.OK) {
                            lat = marker.getPosition().lat();
                            lng = marker.getPosition().lng();
                            address = results[0].formatted_address;
							document.getElementById("ad_map_lat").value = lat;
							document.getElementById("ad_map_long").value = lng;
							document.getElementById("sb_user_address").value = address;
							document.getElementById("sb_loading").style.display	= "none";
                            //alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
                        }
                    });
                });
            })(marker, data);
            latlngbounds.extend(marker.position);
		}
        /*var bounds = new google.maps.LatLngBounds();
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);*/
</script>';
                }
            }

            $lat_long_html = $for_g_map . '<div class="row latlong-adpost">
			  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Latitude', 'carspot') . '</label>
				 <input class="form-control" type="text" name="ad_map_lat" id="ad_map_lat" value="' . $ad_map_lat . '">
			  </div>
			  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Longitude', 'carspot') . '</label>
				 <input class="form-control" name="ad_map_long" id="ad_map_long" value="' . $ad_map_long . '" type="text">
			  </div>
		   </div>';

// Check phone is required or not
            $phone_html = '<input class="form-control" name="sb_contact_number" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" value="' . $poster_ph . '" type="text">';
            if (isset($carspot_theme['sb_user_phone_required']) && !$carspot_theme['sb_user_phone_required']) {
                $phone_html = '<input class="form-control" name="sb_contact_number" value="' . $poster_ph . '" type="text">';
            }
            $bidable = '';

            if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer']) {
                if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user']) {
                    $bidable .= '<div class="select-package">
				   <div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
					 <h3 class="margin-bottom-10">' . $carspot_theme['sb_enable_comments_offer_user_title'] . '</h3>
					 <hr />
				  </div>
				</div>';
                    $bid_on = '';
                    $bid_off = '';
                    if ($ad_bidding == 1) {
                        $bid_on = 'selected=selected';
                    } else {
                        $bid_off = 'selected=selected';
                    }

                    $bidding_options = '<option value="1" ' . $bid_on . '>' . esc_html__('ON', 'carspot') . '</option>';
                    $bidding_options .= '<option value="0" ' . $bid_off . '>' . esc_html__('OFF', 'carspot') . '</option>';
                    $bidable .= '<div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <select class="form-control" name="ad_bidding" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '">
						' . $bidding_options . '
				</select>
			  </div></div>';
                }
            }

            /* ------------------------- */
            $extraFeatures = '';
            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based') {
                $extraFeatures = carspot_getPostAd_adons('ad_post');
            }
            /* - ------------  ------------ */

            /* For No Map  */

            $map_html = '';
            if ($mapType != 'no_map') {
                $allow_ad_adres = "false";
                if (isset($carspot_theme['allow_ad_address']) && $carspot_theme['allow_ad_address'] == true) {
                    $allow_ad_adres = "true";
                }
                $map_html = '<div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				  <label class="control-label">' . esc_html__('Address', 'carspot') . '</label>
				 <input data-parsley-required="' . $allow_ad_adres . '" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" class ="form-control" name="sb_user_address" placeholder="' . esc_html__('Search Location', 'carspot') . '"  id="sb_user_address" value="' . $ad_mapLocation . '" />
			  </div>
		   </div>' . $lat_long_html . $lat_lon_script . '';
            }

            $custom_location = '';
            if (isset($carspot_theme['enable_custom_locationz']) && $carspot_theme['enable_custom_locationz'] == true) {
                global $carspot_theme;
                $custom_location = ' <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_attr($loc_lvl_1) . '</label>
				 <select class="country form-control" id="ad_country" name="ad_country" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '">
					<option value="">Select Option</option>
					' . $country_html . '
				 </select>
				 <input type="hidden" name="ad_country_id" id="ad_country_id" value="" />
			  </div>
		   </div>
		   <div class="row" id="ad_country_sub_div">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" >
			  <label class="control-label">' . esc_attr($loc_lvl_2) . '</label>
				<select class="category form-control" id="ad_country_states" name="ad_country_states">
					' . $country_states . '
				</select>
			  </div>
			</div>
			 <div class="row" id="ad_country_sub_sub_div" >
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . esc_attr($loc_lvl_3) . '</label>
				<select class="category form-control" id="ad_country_cities" name="ad_country_cities">
					' . $country_cities . '
				</select>
			  </div>
			</div>
			 <div class="row" id="ad_country_sub_sub_sub_div">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . esc_attr($loc_lvl_4) . '</label>
				<select class="category form-control" id="ad_country_towns" name="ad_country_towns">
					' . $country_towns . '
				</select>
			  </div>
			</div>';
            }
            $top_padding = 'no-top';
            if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
                $top_padding = '';
            }
            /* max upload video size */
            $max_upload_vid_size_ = '';
            $video_logo_url = get_template_directory_uri() . '/images/video-logo.jpg';
            $max_upload_vid_limit_opt = $carspot_theme['sb_upload_video_limit'];
            $max_upload_vid_size = $carspot_theme['sb_upload_video_mb_limit'];
            $max_upload_vid_limit_arr = explode('-', $max_upload_vid_size);
            if (is_array($max_upload_vid_limit_arr) && !empty($max_upload_vid_limit_arr)) {
                $max_upload_vid_size_ = $max_upload_vid_limit_arr[1];
            }
            $upload_vid_html = '';
            if ($carspot_theme['allow_upload_video'] == true) {
                $upload_vid_html .= '<div class="row">
                            <div class="col-md-12 col-lg-12 col-xs-12  col-sm-12">
				 <label class="control-label">' . __('Upload Video: ', 'carspot') . ' <small>' . __('You can upload ', 'carspot') . $max_upload_vid_limit_opt . __(' videos (mp4, ogg, webm) with size ', 'carspot') . $max_upload_vid_size_ . '</small></label>
                            <div id="ad_vidoe_dropzone" class="dropzone upload-ad_video video_zone">
                              <span class="note needsclick">' . __('Drop video here or click to upload', 'carspot') . ' </span>
                        </div>
                    </div>
		    </div>';
            }

            /* Review Stamp */
//============
            $enable_rev_stamp_html = $enable_vin_num_html = $review_option_html = $vin_num_db = '';
            if ($carspot_theme['enable_review_stamp'] == true) {
                $review_stamp_nme = carspot_get_cats('ad_review_stamp', 0);
                /* VIN Number */
                $vin_num_db = get_post_meta($id, 'carspot_ad_vin_number', true);
                if (is_array($review_stamp_nme) && count($review_stamp_nme) > 0) {
                    $enable_vin_num_html .= '
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <label class="control-label">' . __('VIN Number', 'carspot') . '</label>
                        <input class="form-control" placeholder="VIN number" type="text" name="vin_number" id="vin_number" data-parsley-required="false" data-parsley-error-message="This field is required." value="' . $vin_num_db . '">
                    </div>
                ';
                }
                /* Review Stamp */
                $output = array();
                if (is_array($review_stamp_nme) && count($review_stamp_nme) > 0) {
                    $review_stamp_db = get_post_meta($id, '_carspot_ad_review_stamp', true);
                    if ($review_stamp_db != "") {
                        $output = explode('|', $review_stamp_db);
                    }
                    foreach ($review_stamp_nme as $review_stamp) {
                        $selected_stamp = ($review_stamp_db == $review_stamp->term_id) ? 'selected' : '';
                        $review_option_html .= '<option value="' . $review_stamp->term_id . '|' . $review_stamp->name . '" ' . $selected_stamp . '>' . $review_stamp->name . '</option>';
                    }
                }
//============
                if (is_array($review_stamp_nme) && count($review_stamp_nme) > 0) {
                    $enable_rev_stamp_html .= '
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <label class="control-label">' . __('Choose Stamp', 'carspot') . '</label>
                        <select id="review_stamp_nme" name="review_stamp_nme">
                                ' . $review_option_html . '
                        </select>
                    </div>
                ';
                }
            }

	        /* get optioin if image required */
	        $vid_require = false;
	        if ( isset( $carspot_theme['cs_video_requir'] ) && $carspot_theme['cs_video_requir'] != '' ) {
		        $vid_require = true;
	        }

            return ' 
  <section class="section-padding ' . carspot_returnEcho($top_padding) . ' gray">

<div class="container">
' . $update_notice . '
<!-- Row -->
<div class="row">
  <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
	 <!-- end post-padding -->
	 <div class="post-ad-form postdetails">
		<form  class="submit-form" id="ad_post_form">
		   <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Title', 'carspot') . '</label>
				 <input class="form-control" placeholder="' . esc_html__('Enter title', 'carspot') . '" type="text" name="ad_title" id="ad_title" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" value="' . $title . '">
				 <input type="hidden" id="is_update" name="is_update" value="' . $is_update . '" />
				 <input type="hidden" id="is_level" name="is_level" value="' . $level . '" />
				 <input type="hidden" id="country_level" name="country_level" value="' . $levelz . '" />
			  </div>
		   </div>
		   <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . $heading1 . ' <small>' . esc_html__('Select suitable category for your ad', 'carspot') . '</small></label>
				 <select class="category form-control" id="ad_cat" name="ad_cat" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '">
					<option value="">' . esc_html__("Select Option", "carspot") . '</option>
					' . $cats_html . '
				 </select>
				 <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
			  </div>
		   </div>
		   <div class="row" id="ad_cat_sub_div">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" >
			  <label class="control-label">' . $heading2 . '</label>
				<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">
					' . $sub_cats_html . '
				</select>

			  </div>
			</div>
		   <div class="row" id="ad_cat_sub_sub_div" >
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . $heading3 . '</label>
				<select class="category form-control" id="ad_cat_sub_sub" name="ad_cat_sub_sub">
					' . $sub_sub_cats_html . '
				</select>
			  </div>
			</div>
		   <div class="row" id="ad_cat_sub_sub_sub_div">
			  <!-- Category  -->
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . $heading4 . '</label>
				<select class="category form-control" id="ad_cat_sub_sub_sub" name="ad_cat_sub_sub_sub">
					' . $sub_sub_sub_cats_html . '
				</select>
			  </div>
			</div>
				' . $dataFields . '
				' . $customDynamicFields . '
		   <div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12  col-sm-12">
				 <label class="control-label">' . esc_html__('Ad Description', 'carspot') . ' <small>' . esc_html__('Enter long description for your project', 'carspot') . '</small></label>
				 <textarea rows="12" class="form-control" name="ad_description" id="ad_description">' . esc_textarea($description) . '</textarea>
			  </div>
		   </div>
                                ' . $upload_vid_html . '
                                ' . $pdf_brochure . '
                                ' . $enable_rev_stamp_html . '
                                ' . $enable_vin_num_html . '
				' . $extra_fields_html . '
				' . $bidable . '			
			<div class="select-package">
			   <div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <h3 class="margin-bottom-10">' . esc_html__('User Information', 'carspot') . '</h3>
				 <hr />
			  </div>
			</div>
			' . $custom_location . '
		   <div class="row">
			  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Your Name', 'carspot') . '</label>
				 <input class="form-control" type="text" name="sb_user_name" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" value="' . $poster_name . '">
			  </div>
			  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
				 <label class="control-label">' . esc_html__('Mobile Number', 'carspot') . '</label>
				 <input class="form-control" name="sb_contact_number" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '" value="' . $poster_ph . '" type="text">
			  </div>
		   </div>
		   
		   ' . $map_html . '
			' . $extraFeatures . '
		   <!-- end row -->
			   <div class="ad_post_alerts">
			   ' . $simple_feature_html . '
				' . $bump_ad_html . '
				</div>
		   <button class="btn btn-theme pull-right" id="ad_submit">' . esc_html__('Post My Ad', 'carspot') . '</button>
		   <input type="hidden" id="ad_post_nonce" value="' . wp_create_nonce('carspot_ad_post_secure') . '"  />
		</form>
	 </div>
	 <!-- end post-ad-form-->
  </div>
  <div class="col-md-4 col-xs-12 col-sm-12">
	 <div class="blog-sidebar">
		<div class="widget">
		   <div class="widget-heading">
			  <h4 class="panel-title"><a>' . $tip_section_title . '</a></h4>
		   </div>
		   <div class="widget-content">
			  <p class="lead">' . $tips_description . '</p>
			  <ol>
				 ' . $tips . '
			  </ol>
		   </div>
		</div>
	 </div>
  </div>
</div>
</div>
    
<input type="hidden" id="dictDefaultMessage" value="' . esc_html__('Drop files here to upload', 'carspot') . '" />
<input type="hidden" id="dictFallbackMessage" value="' . esc_html__('Your browser does not support drag\'n\'drop file uploads.', 'carspot') . '" />
<input type="hidden" id="dictFallbackText" value="' . esc_html__('Please use the fallback form below to upload your files like in the olden days.', 'carspot') . '" />
<input type="hidden" id="dictFileTooBig" value="' . esc_html__('File is too big ({{ filesize }}MiB). Max filesize: {{ maxFilesize }}MiB.', 'carspot') . '" />
<input type="hidden" id="dictInvalidFileType" value="' . esc_html__('You can\'t upload files of this type.', 'carspot') . '" />
<input type="hidden" id="dictResponseError" value="' . esc_html__('Server responded with {{ statusCode }} code.', 'carspot') . '" />
<input type="hidden" id="dictCancelUpload" value="' . esc_html__('Cancel upload', 'carspot') . '" />
<input type="hidden" id="dictCancelUploadConfirmation" value="' . esc_html__('Are you sure you want to cancel this upload?', 'carspot') . '" />
<input type="hidden" id="dictRemoveFile" value="' . esc_html__('Remove file', 'carspot') . '" />
<input type="hidden" id="dictMaxFilesExceeded" value="' . esc_html__('You can not upload any more files.', 'carspot') . '" />
<input type="hidden" id="required_images" value="' . esc_html__('Images are required.', 'carspot') . '" />
<input type="hidden" id="required_stamp_logo" value="' . esc_html__('Logo is required.', 'carspot') . '" />
<input type="hidden" id="input__type" value="' . $input__type . '" />
<!--video-->
<input type="hidden" id="max_upload_video_size" value="' . $max_upload_vid_size_ . '" />
<input type="hidden" id="sb_upload_video_limit" value="' . $max_upload_vid_limit_opt . '" />
<input type="hidden" id="video_logo_url" value="' . $video_logo_url . '" />
<input type="hidden" id="required_vidoes_" value="' . esc_html__( 'Videos are required.', 'carspot' ) . '" />
<input type="hidden" id="required_vidoes_value" value="' . $vid_require . '" />
<!--pdf brochure-->
<input type="hidden" id="pdf_brochure_upload_limit" value="' . esc_attr($carspot_theme['pdf_brochure_upload_limit']) . '" />
<input type="hidden" id="pdf_brochure_size" value="' . $pdf_brochure_actual_size . '" />
<input type="hidden" id="pdf_brochure_logo_url" value="' . $pdf_brochure_logo_url . '" />


    

<!-- Main Container End -->
</section>
' . $cart_total . '';
        } else {
            wp_redirect(home_url());
            exit;
        }
    }

}

/*
 * Ads
 */

if (!function_exists('cs_elementor_ads')) {

    function cs_elementor_ads($params)
    {
        $button_one = '';
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $all_cat_ads = $params['all_cat_ads'];
        $cats = $params['cats'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-lg  btn-theme', 'fa fa-refresh');
        }

        $is_all = false;
        $html = '';
        if ($all_cat_ads == 'no') {
            if (!isset($cats)) {
                return $html;
            }
        }
        $category = '';
        if (is_array($cats) && count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'slug',
                    'terms' => $cats,
                ),
            );
        }
        $is_feature = "";
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => '_carspot_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        }

        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }


        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature,
            ),
            'tax_query' => array(
                $category,
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $ads = new ads();
        $html = '';
        $s_title = '';
        if ($layout_type == 'slider') {
            $html = $ads->carspot_get_ads_grid_slider($args, $s_title, 4);
        } else {

            $results = new WP_Query($args);
          
            $layouts = array('list_1', 'list_2', 'list_3');
            if ($results->have_posts()) {
                $type = $layout_type;

                $col = 4;
                if (isset($no_title)) {
                    $col = 6;
                }
                if (in_array($layout_type, $layouts)) {
                    require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-list.php";
                } else if ($layout_type == 'list') {
                    $list_html = '';
                    while ($results->have_posts()) {
                        $results->the_post();
                        $pid = get_the_ID();
                        $list_html .= $ads->carspot_search_layout_list($pid);
                    }
                    $out = '<div class="posts-masonry">
                           <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <ul class="list-unstyled">
							  		' . $list_html . '
							  </ul>
                           </div>
                        </div>
                        <div class="clearfix"></div>';
                } else if ($layout_type == 'list_4') {
                    $list_html = '';
                    while ($results->have_posts()) {
                        $results->the_post();
                        $pid = get_the_ID();
                        $list_html .= $ads->carspot_search_layout_list_4($pid);
                    }
                    $out = '<div class="posts-masonry">
                           <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <div class="row">
								<div class="trending-ads">
							  		' . $list_html . '
							  </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>';
                } else {
                    $out = '';
                    if ($layout_type == 'grid_1') {
                        $out .= '<div class="grid-style-2">';
                    }
                    if ($layout_type == 'grid_5') {
                        $out .= '<div class="grid-style-1">';
                    }
                    if ($layout_type == 'grid_6') {
                        $out .= '<div class="grid-style-2 grid-style-3">';
                    }
                    if ($layout_type == 'grid_7') {
                        $out .= '<div class="grids-style-4">';
                    }
                    $c = 6;
                    if (isset($col)) {
                        $c = $col;
                    }
                    $out .= '<div class="posts-masonry ads-for-home">';
                    while ($results->have_posts()) {
                        $results->the_post();
                        $pid = get_the_ID();
                        $ads = new ads();
                        $option = $layout_type;
                        $function = "carspot_search_layout_$option";
                        $out .= $ads->$function($pid, $c);
                    }
                    $out .= '</div>';
                    if ($layout_type == 'grid_1') {
                        $out .= '</div>';
                    }
                    if ($layout_type == 'grid_5') {
                        $out .= '</div>';
                    }
                    if ($layout_type == 'grid_6') {
                        $out .= '</div>';
                    }
                    if ($layout_type == 'grid_7') {
                        $out .= '</div>';
                    }
                }
                wp_reset_postdata();
                $heading = '';
                if ($s_title != "") {
                    $heading = '<div class="heading-panel">
                              <div class="col-xs-12 col-md-12 col-sm-12">
                                 <h3 class="main-title text-left">
                                   ' . $s_title . '
                                 </h3>
                              </div>
                           </div>';
                }

                $html = '
                           ' . $heading . '
                              <div class="col-md-12 col-xs-12 col-sm-12">
							  	<div class="row"> ' . $out . ' </div>
							  </div>';
            }
        }


        return '<section class="custom-padding">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    ' . $header . '
                    ' . $html . '
                    <div class="text-center">
                        <div class="load-more-btn">
                            ' . $button_one . '
                        </div>
                    </div>

                </div>
            </div>
        </section>';
    }

}

/*
 * Ads by Location
 */
if (!function_exists('cs_elementor_ads_by_locatioin')) {

    function cs_elementor_ads_by_locatioin($params)
    {
        global $carspot_theme;
        $locations_html = $header = $cat_link_page = $header_style = $section_title = $section_description = $select_locations = '';

        $cat_link_page = $params['cat_link_page'];
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $select_locations = $params['select_locations'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        /* Selected locations */
        if (count((array)$select_locations) > 0) {
            foreach ($select_locations as $r) {
                if ($r != '') {
                    $img_thumb = '';
                    $img = (isset($r['img']['id'])) ? $r['img']['id'] : '';
                    $id = (isset($r['name'])) ? $r['name'] : '';
                    if (wp_attachment_is_image($img)) {
                        $img_url = wp_get_attachment_image_src($img, 'carspot-reviews-thumb');
                        $img_thumb = $img_url[0];
                    } else {
                        $img_thumb = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $term = get_term_by('slug', $id, 'ad_country');
                    if (isset($term->name)) {
                        $id_get = $term->term_id;
                        $slug = $term->slug;
                        $name = $term->name;
                        $count = $term->count;
                        $link = get_term_link($slug, 'ad_country');
// If there was an error, continue to the next term.
                        if (is_wp_error($link)) {
                            continue;
                        }
                        $parent = $term->parent;
                        $innerHTML = '';
                        if ($parent == 0) {

                            $innerHTML = '<h2 class="country-name">' . esc_html($name) . ' <span> (' . $count . ') </span></h2>
						 <p class="country-ads"></p>';
                        } else {
                            $term = get_term($parent, 'ad_country');
                            $parent_name = $term->name;
                            $innerHTML = '<h2 class="country-name">' . esc_html($name) . ' <span> (' . $count . ') </span></h2>
							<p class="country-ads">' . esc_html($parent_name) . '</p>';
                        }
                        $locations_html .= '<div class="col-sm-6 col-xs-12 col-md-4">
					<a href="' . carspot_location_page_link($id_get, $cat_link_page) . '">
					 <div class="country-box">
						<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr($name) . '">
						<div class="country-description"> ' . $innerHTML . '</div>
					 </div>
					</a>
					</div>	';
                    }
                }
            }
        }


        return '<section class="custom-padding cities-section">
         <div class="container">
			' . $header . '
            <div class="row">
                 <div class="cities-grid-area posts-masonry">
				   ' . $locations_html . '
               </div>
            </div>
         </div>
      </section>';
    }

}

/*
 * Ads by Make
 */
if (!function_exists('cs_elementor_ads_by_make')) {

    function cs_elementor_ads_by_make($params)
    {
        $categories_html = $cat_link_page = $header_style = $section_title = $section_description = $header = $bgImageURL = '';
        $cats = array();
        $cat_link_page = $params['cat_link_page'];
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $cats = $params['cats'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        /* categories */
        if (count((array)$cats) > 0) {
            $counter = 0;
            foreach ($cats as $row) {
                if (isset($row['cat']) && isset($row['img']['id']) && $row['cat'] != "") {
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    $bgImageURL = carspot_returnImgSrc($row['img']['id']);
                    if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
                        $categories_html .= '<div class="sigle-clients-brand">
					 <a href="' . esc_url(carspot_cat_link_page($category->term_id, $cat_link_page)) . '">
                         <img alt="' . esc_attr($category->name) . '" src="' . esc_url($bgImageURL) . '">
                       </a> 
                     </div>';
                        if (++$counter % 5 == 0) {
                            $categories_html .= '<div class="clearfix"></div>';
                        }
                    }
                }
            }
        }

        return '<section class="happy-clients-area">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="client-brand-list">
                                ' . $categories_html . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Ads google map
 */
if (!function_exists('cs_elementor_ads_google_map')) {

    function cs_elementor_ads_google_map($params)
    {
        global $carspot_theme;
        $ad_type = $params['ad_type'];
        $no_of_ads = $params['no_of_ads'];
        $map_zoom = $params['map_zoom'];
        $map_latitude = $params['map_latitude'];
        $map_longitude = $params['map_longitude'];
        $cats = $params['cats'];

        /* check map type */
        $mapType = carspot_mapType();
        if ($mapType == 'leafletjs_map') {

        } else if ($mapType == 'google_map') {

        }
        if ($mapType == 'leafletjs_map') {
            $listing_json = '<script>var listing_markers = [';
        } else if ($mapType == 'google_map') {

            $listing_json = '<script>  var locations = [';
        }
        if (count((array)$cats) > 0) {
            foreach ($cats as $row) {
                if (isset($row['cat'])) {
                    $marker = '';
                    if (isset($row['img']['id'])) {
                        $marker = carspot_returnImgSrc($row['img']['id']);
                    } else {
                        $marker = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
                    }
                    $category = array(
                        array(
                            'taxonomy' => 'ad_cats',
                            'field' => 'slug',
                            'terms' => $row['cat'],
                        ),
                    );
                    $is_feature = '';
                    if ($ad_type == 'feature') {
                        $is_feature = array(
                            'key' => '_carspot_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else {
                        $is_feature = array(
                            'key' => '_carspot_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }

                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status ' => 'publish',
                        'posts_per_page' => $no_of_ads,
                        'meta_query' => array(
                            $is_feature,
                        ),
                        'tax_query' => array(
                            $category,
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',
                    );
                    $results = new WP_Query($args);

                    if ($results->have_posts()) {
                        $count1 = 1;
                        $ad_class = '';
                        while ($results->have_posts()) {
                            $results->the_post();
                            $pid = get_the_ID();
                            $title = get_the_title();
                            $img = '';
                            $media = carspot_fetch_listing_gallery($pid);
                            if (count((array)$media) > 0) {
                                foreach ($media as $m) {
                                    $mid = '';
                                    if (isset($m->ID)) {
                                        $mid = $m->ID;
                                    } else {
                                        $mid = $m;
                                    }

                                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                    if ($image != '') {
                                        $img = $image[0];
                                        break;
                                    }
                                }
                            } else {
                                $img = $carspot_theme['default_related_image']['url'];
                            }
                            $price = carspot_adPrice(get_the_ID());
                            $p_date = get_the_date(get_option('date_format'), get_the_ID());


                            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                            $cat_name = '';
                            $cat_link = '';
                            foreach ($post_categories as $c) {
                                $cat = get_term($c);
                                $cat_name = $cat->name;
                                $cat_link = get_term_link($cat->term_id);
                            }

                            $flip_it = '';
                            $ribbion = 'featured-ribbon';
                            if (is_rtl()) {
                                $flip_it = 'flip';
                                $ribbion = 'featured-ribbon-rtl';
                            }
                            $is_feature = '';
                            if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
                            }
                            $lat = '';
                            $lon = '';
                            $lat = get_post_meta($pid, '_carspot_ad_map_lat', true);
                            $lon = get_post_meta($pid, '_carspot_ad_map_long', true);
                            if ($lat == "" || $lon == "") {
                                continue;
                            }
                            if ($mapType == 'leafletjs_map') {
                                $price = strip_tags($price);
                                $listing_json .= '{
						"img":"' . esc_url($img) . '",
						"price":"' . ($price) . '",
						"ad_class":"' . ($ad_class) . '",
						"cat_link":"' . ($cat_link) . '",
						"cat_name":"' . ($cat_name) . '",
						"title":"' . ($title) . '",
						"location":"",
						"ad_link":"' . get_the_permalink($pid) . '",
						"p_date":"' . ($p_date) . '",
						"lat":"' . ($lat) . '",
						"lon":"' . ($lon) . '",
						"marker_counter":"' . ($count1) . '",
						"marker2":"' . $marker . '",
						"imageUrl":"",
					},';
                            } else if ($mapType == 'google_map') {

                                $func = '<div class="category-grid-box-1"><div class="image"><img alt="' . $title . '" src="' . esc_url($img) . '" class="img-responsive">' . $is_feature . '<div class="price-tag"><div class="price"><span>' . $price . ' </span></div></div></div><div class="short-description-1 clearfix"><div class="category-title"> <span><a href="' . esc_url($cat_link) . ' ">' . $cat_name . '</a></span> </div><h3><a href="' . get_the_permalink($pid) . '">' . $title . '</a></h3></div><div class="ad-info-1"><p><i class="flaticon-calendar"></i> &nbsp;<span></span>' . $p_date . ' </p></div></div>';

                                $listing_json .= "['$func', $lat, $lon, $count1, '$marker'],";
                            }

                            $count1++;
                        }
                    }
                }
            }
        }
        if ($mapType == 'leafletjs_map') {
            $listing_json .= '];</script>';
        } else if ($mapType == 'google_map') {

            $listing_json .= ']; var map_lat = "' . $map_latitude . '"; var map_lon = "' . $map_longitude . '"; var zoom_option = ' . $map_zoom . '</script>';
        }
        wp_reset_postdata();

        $leaflet_jsJS = $prev_next_html = '';
        if ($mapType == 'leafletjs_map') {

            $marker_url = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
            if ($marker != "") {
                $marker_url = $marker;
            }

            $leaflet_jsJS = '<script type="text/javascript">
			
			var map_lat = "' . $map_latitude . '";
			var map_long = "' . $map_longitude . '";
			if(map_lat  &&  map_long )
			{	
			var my_icons = "' . $marker_url . '";
			if(jQuery("#map").length){
			var map = L.map("map").setView([map_lat, map_long], "' . $map_zoom . '");
			L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png").addTo( map );
			var myIcon = L.icon({
				  iconUrl:  my_icons,
				  iconRetinaUrl:   my_icons,
				  iconSize: [25, 40],
				  iconAnchor: [10, 30],
				  popupAnchor: [0, -35]
			});
				carspot_mapCluster();
			}
			}
			function carspot_mapCluster()
			{
				var markerClusters = L.markerClusterGroup();
				var popup = "";
				for ( var i = 0; i < listing_markers.length; ++i )
				{
						
						if(listing_markers[i].lat && listing_markers[i].lon ){
						
						
						var popup = \'<div class="category-grid-box-1"><div class="image"><img alt="\' + listing_markers[i].title + \'" src="\' + listing_markers[i].img + \'" class="img-responsive">\' + listing_markers[i].ad_class + \'<div class="price-tag"><div class="price"><span>\' + listing_markers[i].price + \' </span></div></div></div><div class="short-description-1 clearfix"><div class="category-title"> <span><a href="\' + listing_markers[i].cat_link + \'">\' + listing_markers[i].cat_name + \'</a></span> </div><h3><a href="\' + listing_markers[i].ad_link + \'">\' + listing_markers[i].title + \'</a></h3></div><div class="ad-info-1"><p><i class="flaticon-calendar"></i> &nbsp;<span></span>\' + listing_markers[i].p_date + \' </p></div>\';
						
						}
					  var m = L.marker( [listing_markers[i].lat, listing_markers[i].lon], {icon: myIcon} ).bindPopup(popup,{minWidth:270,maxWidth:270});
					  markerClusters.addLayer( m );
					  map.addLayer( markerClusters );
					  map.fitBounds(markerClusters.getBounds());
				}				
				map.scrollWheelZoom.disable();
				map.invalidateSize();
		    }    
		    
        </script>';


            $prev_next_html = '';
        } else if ($mapType == 'google_map') {
            if ($carspot_theme['gmap_api_key'] != "") {
                /* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */
                wp_enqueue_script('google-map');
                wp_enqueue_script('infobox', trailingslashit(get_template_directory_uri()) . 'js/infobox.js', array('google-map'), false, false);
                wp_enqueue_script('marker-clusterer', trailingslashit(get_template_directory_uri()) . 'js/markerclusterer.js', false, false, false);
                wp_enqueue_script('marker-map', trailingslashit(get_template_directory_uri()) . 'js/markers-map.js', false, false, false);
            }

            $prev_next_html = '<ul id="google-map-btn">
         <li><a href="#" id="prevpoint" title="' . esc_html__('Previous point on map', 'carspot') . '">' . esc_html__('Prev', 'carspot') . '</a></li>
         <li><a href="#" id="nextpoint" title="' . esc_html__('Next point on map', 'carspot') . '">' . esc_html__('Next', 'carspot') . '</a></li>
      </ul>';
        }

        return $listing_json . '<div id="map"></div>
      <!-- Map Navigation -->
      ' . $prev_next_html
            . $leaflet_jsJS;
    }

}

/*
 * Ads Slider
 */
if (!function_exists('cs_elementor_ads_slider')) {

    function cs_elementor_ads_slider($params)
    {
        $header_style = $section_title = $section_description = $ad_type = $layout_type = $no_of_ads = $cats = '';
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $cats = $params['cats'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else {
            $is_type = 0;
        }
//$cats = array();

        $category = '';
        if (count((array)$cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'slug',
                    'terms' => $cats,
                ),
            );
        }
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => '_carspot_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else {
            $is_feature = array(
                'key' => '_carspot_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }


        $args = array(
            'post_type' => 'ad_post',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature,
            ),
            'tax_query' => array(
                $category,
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $ads_html = '';
        $class = '';
        $ads = new ads();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            if ($layout_type == "grid_1") {
                $class = 'grid-style-2';
            }
            if ($layout_type == "grid_5") {
                $class = 'grid-style-1';
            }
            while ($results->have_posts()) {
                $results->the_post();
                $ads_html .= '<div class="item">';
                $function = "carspot_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 12, 12, 'slider-');
                $ads_html .= '</div>';
            }

            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
        }
        wp_reset_postdata();


        return '<section class="custom-padding over-hidden">
            <div class="container">
               <div class="row ' . esc_attr($class) . '">
                  ' . $header . '
                  <!-- Middle Content Box -->
                  <div class="col-md-12 col-xs-12 col-sm-12 ads-for-home">
                     <div class="row">
                        <div class="featured-slider container owl-carousel owl-theme">
                           	' . $ads_html . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * Advertisement
 */
if (!function_exists('ad_720_short_base_func')) {

    function ad_720_short_base_func($params)
    {
        $header_style = $section_title = $section_description = '';
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_720_90 = $params['ad_720_90'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        return '<section class="advertizing">
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <div class="banner">
                        ' . urldecode(carspot_decode($ad_720_90)) . '
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}
/*
 * Apps - Simple
 */
if (!function_exists('cs_elementor_apps_short')) {

    function cs_elementor_apps_short($params)
    {
        $section_title = $a_title = $a_tag_line = $a_link = $off_set = '';
        $i_title = $i_tag_line = $i_link = '';
        $w_title = $w_tag_line = $w_link = '';
        $apps = '';
        $count = 0;

        $section_title = $params['section_title'];
        $a_title = $params['a_title'];
        $a_tag_line = $params['a_tag_line'];
        $a_link = $params['a_link'];
        $i_title = $params['i_title'];
        $i_tag_line = $params['i_tag_line'];
        $i_link = $params['i_link'];
        $w_title = $params['w_title'];
        $w_tag_line = $params['w_tag_line'];
        $w_link = $params['w_link'];


        if ($count == 1) {
            $off_set = 'col-md-offset-4';
        } else if ($count == 2) {
            $off_set = 'col-md-offset-2';
        } else if ($count == 3) {
            $off_set = '';
        }

        if ($a_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($a_link) . '" title="' . esc_attr($a_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-android"></i>
                           <span>
                           <span>' . esc_html($a_tag_line) . '</span> <span>' . esc_html($a_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }
        if ($i_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($i_link) . '" title="' . esc_attr($i_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-apple"></i>
                           <span>
                           <span>' . esc_html($i_tag_line) . '</span> <span>' . esc_html($i_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }
        if ($w_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($w_link) . '" title="' . esc_attr($w_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-windows"></i>
                           <span>
                           <span>' . esc_html($w_tag_line) . '</span> <span>' . esc_html($w_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }


        return '<div class="app-download-section parallex">
            <div class="app-download-section-wrapper">
                <div class="app-download-section-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-title"> <span>' . $section_title . '</span></div>
                            </div>
                            <div class="col-md-12 ' . $off_set . '">
                                ' . $apps . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}
/*
 * App Classic
 */
if (!function_exists('cs_elementor_apps_classic')) {

    function cs_elementor_apps_classic($params)
    {
        $img_html = $point_html = $apps = '';
        $app_img = $section_tag_line = $section_title = $points = $a_title = $a_tag_line = $a_link = $i_title = $i_tag_line = $i_link = '';

        $app_img = $params['app_img'];
        $section_tag_line = $params['section_tag_line'];
        $section_title = $params['section_title'];
        $points = $params['points'];
        $a_title = $params['a_title'];
        $a_tag_line = $params['a_tag_line'];
        $a_link = $params['a_link'];
        $i_title = $params['i_title'];
        $i_tag_line = $params['i_tag_line'];
        $i_link = $params['i_link'];

        /* main image */
        if ($app_img != "") {
            $img_html = '<div class="mobile-image-content">
                <img src="' . carspot_returnImgSrc($app_img) . '" alt="' . __('app image', 'carspot') . '">
            </div>';
        }

        /* points */
        if (count((array)$points) > 0) {
            $point_html .= '<ul>';
            foreach ($points as $row) {
                if (isset($row['points_sec'])) {
                    $point_html .= '<li>' . $row['points_sec'] . '</li>';
                }
            }
            $point_html .= '</ul>';
        }


        if ($a_link != "") {
            $apps .= '<div class="col-md-6">
                           <a href="' . esc_url($a_link) . '" title="' . esc_attr($a_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-android"></i>
                           <span>
                           <span>' . esc_html($a_tag_line) . '</span> <span>' . esc_html($a_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }
        if ($i_link != "") {
            $apps .= '<div class="col-md-6">
                           <a href="' . esc_url($i_link) . '" title="' . esc_attr($i_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-apple"></i>
                           <span>
                           <span>' . esc_html($i_tag_line) . '</span> <span>' . esc_html($i_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }


        return '<div class="app-download-section style-2">
            <div class="parallex">
                <div class="app-download-section-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                ' . $img_html . '
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="app-text-section">
                                    <h5>' . esc_html($section_tag_line) . '</h5>
                                    <h3>' . esc_html($section_title) . '</h3>
                                    ' . $point_html . '
                                    <div class="app-download-btn">
                                        <div class="row">
                                            ' . $apps . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}

/*
 * Blog
 */
if (!function_exists('cs_elementor_blog')) {

    function cs_elementor_blog($params)
    {
        global $carspot_theme;
        $button = $header_style = $section_title = $section_description = $btn_title = $btn_link = $target_one = $nofollow_one = $header = '';
        $cats_ = array();
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $max_limit = $params['max_limit'];
        $cats = $params['cat'];

        if (count((array)$cats) > 0) {
            for ($i = 0; $i < count($cats); $i++) {
                if (isset($cats[$i])) {
                    $blog_category = get_term_by('slug', $cats[$i], 'category');
                    if (!empty($blog_category)) {
                        if (count((array)$blog_category) == 0)
                            continue;
                        $blog_category->term_id;
                        $cats_[] = $blog_category->term_id;
                    }
                }
            }
        }
        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $max_limit,
            'post_status' => 'publish',
            'category__in' => $cats_,
            'orderby' => 'ID',
            'order' => 'DESC',
        );
        $posts = new WP_Query($args);
        $html = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = get_the_ID();
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-category');
                    $img_header = '';
                    if ($image[0] != "") {
                        $img_header = '<div class="post-img"><a href="' . get_the_permalink() . '"><img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '"></a></div>';
                    }
                } else {
                    $img_header = '<div class="post-img"><a href="' . get_the_permalink() . '"><img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '"></a></div>';
                }
                $user_pic = '';
                $img = '';
                $user_pic = carspot_get_user_dp(get_current_user_id(), 'carspot-single-small');

                $img = '<img class="img-circle resize" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url($user_pic) . '" />';
                $html .= '<div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="blog-post">
                        ' . $img_header . '
                        <div class="blog-content">
                            <div class="user-preview">
                                <a href="' . esc_attr(get_author_posts_url(get_the_author_meta('ID'))) . '"> ' . $img . '</a>
                            </div>
                            <div class="post-info">
                                <a href="javascript:void(0);">' . get_the_date(get_option('date_format'), $pid) . '</a>
                                <a href="javascript:void(0);">' . get_comments_number() . ' ' . esc_html__('comments', 'carspot') . '</a>
                            </div>
                            <h3 class="post-title">
                                <a href="' . get_the_permalink() . '">' . get_the_title() . '</a> </h3>
                            <p class="post-excerpt"> ' . carspot_words_count(get_the_excerpt(), 140) . '
                                <a href="' . get_the_permalink() . '"> <strong> ' . esc_html__('Read More', 'carspot') . ' </strong></a>
                            </p>
                        </div>
                    </div></div>';
            }
        }


        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-lg btn-theme', 'fa fa-refresh');
        }


        return '<section class="custom-padding">
            <!-- Main Container -->
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            ' . $html . '
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <div class="load-more-btn">' . $button . '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}
/*
 * Buy Or Sell
 */
if (!function_exists('cs_elementor_buy_or_sell')) {

    function cs_elementor_buy_or_sell($params)
    {
        $button_one = $button_two = $style = $style2 = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $bg_img = $params['bg_img'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        $sell_tagline = $params['sell_tagline'];
        $main_description1 = $params['main_description1'];
        $main_image1 = $params['main_image1'];
        $btn_title1 = $params['btn_title1'];
        $btn_link1 = $params['btn_link1'];
        $target_one1 = $params['target_one1'];
        $nofollow_one1 = $params['nofollow_one1'];

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn-theme btn-lg btn', '');
        }

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_two = cs_elementor_button_link($target_one1, $nofollow_one1, $btn_title1, $btn_link1, 'btn-primary btn-lg btn', '');
        }

//left Image
        $bgImageURL = carspot_returnImgSrc($bg_img);
        $style = ($bgImageURL != "") ? ' style="background-image: url(' . $bgImageURL . ');background-position: center center;background-repeat: no-repeat;background-size: cover;"' : "";

//Right Image
        $bgImageURL2 = carspot_returnImgSrc($main_image1);
        $style2 = ($bgImageURL2 != "") ? ' style="background-image: url(' . $bgImageURL2 . ');background-position: center center;background-repeat: no-repeat;background-size: cover;"' : "";


        return '<section class="buysell-section">
            <div class="background-3"  ' . $style . '></div>
            <div class="background-4" ' . $style2 . '></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                        <div class="section-container-left">
                            <h1>' . $section_title . '</h1>
                            <p>' . $section_description . '</p>
                            ' . $button_one . '
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                        <div class="section-container-right">
                            <h1>' . $sell_tagline . '</h1>
                            <p>' . $main_description1 . '</p>
                            ' . $button_two . '
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}
/*
 * Buy Or Sell
 */
if (!function_exists('cs_elementor_buy_sale')) {

    function cs_elementor_buy_sale($params)
    {
        $buy = $sell = $client_tagline = $animation_effects = $btn_title = $btn_link = $target_one = $nofollow_one = $section_description = $main_image = '';
        $sell_tagline = $animation_effects2 = $btn_title1 = $btn_link1 = $target_one1 = $nofollow_one1 = $section_description1 = $main_image1 = '';
        $button_one = $button_two = $revail_animation = $revail_animation2 = $buy = $sell = '';

        $client_tagline = $params['client_tagline'];
        $animation_effects = $params['animation_effects'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $section_description = $params['section_description'];
        $main_image = $params['main_image'];

        $sell_tagline = $params['sell_tagline'];
        $animation_effects2 = $params['animation_effects2'];
        $btn_title1 = $params['btn_title1'];
        $btn_link1 = $params['btn_link1'];
        $target_one1 = $params['target_one1'];
        $nofollow_one1 = $params['nofollow_one1'];
        $section_description1 = $params['section_description1'];
        $main_image1 = $params['main_image1'];

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, '', '');
        }

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_two = cs_elementor_button_link($target_one1, $nofollow_one1, $btn_title1, $btn_link1, '', '');
        }

//animation
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }
//animation
        $revail_animation2 = '';
        if (isset($animation_effects2) && $animation_effects2 != "") {
            $revail_animation2 = $animation_effects2;
        }

        $main_img = carspot_returnImgSrc($main_image);
        if (isset($main_img) && ($main_img != "")) {

            $buy = '<div class="text-center"><img class="img-responsive wow ' . $revail_animation . ' center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . esc_url($main_img) . '" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        }

        $main_img1 = carspot_returnImgSrc($main_image1);
        if (isset($main_image1) && ($main_image1 != "")) {

            $sell = '<div class="text-center"><img class="img-responsive wow ' . $revail_animation2 . ' center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . esc_url($main_img1) . '" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
        }


        return '<section class="sell-box padding-top-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                        <div class="sell-box-grid">
                            <div class="short-info">
                                <h3>' . $client_tagline . '</h3>
                                <h2>' . $button_one . '</h2>
                                <p>' . $section_description . '</p>
                            </div>
                            ' . $buy . '
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                        <div class="sell-box-grid">
                            <div class="short-info">
                                <h3>' . $sell_tagline . '</h3>
                                <h2>' . $button_two . '</h2>
                                <p>' . $section_description1 . '</p>
                            </div>
                            ' . $sell . '
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Call to Action
 */
if (!function_exists('cs_elementor_call_to_action')) {

    function cs_elementor_call_to_action($params)
    {
        $button_one = $title = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $title = $params['title'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-lg btn-theme', 'fa fa-angle-double-right');
        }

        return '<div class="parallex-small ">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12 col-sm-8">
                        <div class="parallex-text">
                            <h4>' . esc_html($title) . '</h4>
                        </div>
                    </div>
                    <div class="col-md-4 col-sx-12 col-sm-4">
                        <div class="parallex-button">
                            ' . $button_one . '
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}

/*
 * Call to Action two
 */
if (!function_exists('cs_elementor_call_to_action_two')) {

    function cs_elementor_call_to_action_two($params)
    {
        $button_one = $title = $description = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $button_two = $btn_title1 = $btn_link1 = $target_two = $nofollow_two = '';
        $title = $params['title'];
        $description = $params['description'];

        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        $btn_title1 = $params['btn_title1'];
        $btn_link1 = $params['btn_link1'];
        $target_two = $params['target_two'];
        $nofollow_two = $params['nofollow_two'];


        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', '');
        }
        /* Buttons with link */
        if ($btn_title1 != '' && $btn_title1 != '') {
            $button_two = cs_elementor_button_link($target_two, $nofollow_two, $btn_title1, $btn_link1, 'btn btn-clean', '');
        }


        return '<div class="parallex section-padding about-us text-center">
            <div class="container">
                <div class="row">
                    <!-- countTo -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="parallex-text">
                            <h5>' . esc_html($title) . '</h5>
                            <h4>' . esc_html($description) . '</h4>
                            ' . $button_one . '
                            ' . $button_two . '
                        </div>
                    </div>
                    <!-- end col-xs-6 col-sm-3 col-md-3 -->
                </div>
                <!-- End row -->
            </div>
        </div>';
    }

}

/*
 * call to action three
 */
if (!function_exists('cs_elementor_call_to_action_three')) {

    function cs_elementor_call_to_action_three($params)
    {
        $tagline_left = $title_left = $desc_left = $btn_title = $btn_link = $target_one = $nofollow_one = $left_car_img = '';
        $tagline_right = $title_right = $desc_right = $btn_title1 = $btn_link1 = $target_two = $nofollow_two = $right_car_img = '';
        $left_image_full = $right_image_full = '';

        $tagline_left = $params['tagline_left'];
        $title_left = $params['title_left'];
        $desc_left = $params['desc_left'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $left_car_img = $params['left_car_img'];

        $tagline_right = $params['tagline_right'];
        $title_right = $params['title_right'];
        $desc_right = $params['desc_right'];
        $btn_title1 = $params['btn_title1'];
        $btn_link1 = $params['btn_link1'];
        $target_two = $params['target_two'];
        $nofollow_two = $params['nofollow_two'];
        $right_car_img = $params['right_car_img'];
        $bg_img = $params['bg_img'];

        /* Buttons with link */
	    $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', '');
        }
        /* Buttons with link */
	    $button_two = '';
        if ($btn_title1 != '' && $btn_title1 != '') {
            $button_two = cs_elementor_button_link($target_two, $nofollow_two, $btn_title1, $btn_link1, 'btn btn-clean', '');
        }

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = carspot_returnImgSrc($bg_img);
            $style = ($bgImageURL != "") ? ' style=" background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center;background-size: cover;-moz-background-size: cover;-ms-background-size: cover;-o-background-size: cover;-webkit-background-size: cover;"' : "";
        } else {
            $black_text = 'black_text';
        }

        if ($left_car_img != "") {
            if (wp_attachment_is_image($left_car_img)) {
                $left_car_imgURL = carspot_returnImgSrc($left_car_img);
                $left_image_full = '<div class="text-center"><img class="img-responsive wow slideInLeft center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . $left_car_imgURL . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
            } else {
                $left_image_full = '<div class="text-center"><img class="img-responsive wow slideInLeft center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . get_template_directory_uri() . '/images/sell.png' . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
            }
        }
        if ($right_car_img != "") {
            if (wp_attachment_is_image($right_car_img)) {
                $right_car_imgURL = carspot_returnImgSrc($right_car_img);
                $right_image_full = '<div class="text-center"><img class="img-responsive wow slideInRight center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . $right_car_imgURL . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
            } else {
                $right_image_full = '<div class="text-center"><img class="img-responsive wow slideInRight center-block" data-wow-delay="0ms" data-wow-duration="2000ms" src="' . get_template_directory_uri() . '/images/sell-1.png' . '" alt="' . esc_html__("car image", 'carspot') . '"></div>';
            }
        }

        return '<section class="sell-box sell-box-2 section-padding "' . $style . '>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                        <div class="sell-box-grid">
                            <div class="short-info">
                                <h3>' . $tagline_left . '</h3>
                                <a href="javascript:void()" class="headings">' . $title_left . '</a>
                                <p>' . $desc_left . ' </p>
                                ' . $button_one . '
                            </div>

                            ' . $left_image_full . '
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                        <div class="sell-box-grid right">
                            <div class="short-info">
                                <h3> ' . $tagline_right . '</h3>
                                <a href="javascript:void()" class="headings">' . $title_right . '</a>
                                <p>' . $desc_right . ' </p>
                                ' . $button_two . '
                            </div>
                            ' . $right_image_full . '
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}


/*
 * Car Inspection
 */
if (!function_exists('cs_elementor_car_inspection')) {

    function cs_elementor_car_inspection($params)
    {
        $inspection_list = $img_left = $img_right = $revail_animation = $button_one = $inspection_list_ = '';
        $client_tagline = $client_heading = $section_description = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $main_image = $img_postion = $revail_animation = '';

        $client_tagline = $params['client_tagline'];
        $client_heading = $params['client_heading'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $main_image = $params['main_image'];
        $inspection_list = $params['inspection_list'];
        $img_postion = $params['img_postion'];
        $animation_effects = $params['animation_effects'];

        if (count((array)$inspection_list) > 0) {
            foreach ($inspection_list as $row) {
                if (isset($row['inspection'])) {
                    $inspection_list_ .= '<li class="col-sm-4"> <i class="fa fa-check"></i> ' . $row['inspection'] . '</li>';
                }
            }
        }

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn-theme btn-lg btn', 'fa fa-angle-right');
        }

        $main_img = carspot_returnImgSrc($main_image);
        if (isset($main_img)) {
            if ($img_postion == 'left') {
                $img_left = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . esc_url($main_img) . '" class="wow ' . $revail_animation . ' img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            } else {
                $img_right = '<div class="col-md-6 col-sm-6 col-xs-12 nopadding hidden-sm"><img src="' . esc_url($main_img) . '" class="wow ' . $revail_animation . ' img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>';
            }
        }

//animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }

        return '<section class="car-inspection section-padding">
            <div class="container">
                <div class="row">
                    ' . $img_left . '
                    <div class="col-md-6 col-sm-12 col-xs-12 nopadding">
                        <div class="call-to-action-detail-section">
                            <div class="heading-2">
                                <h3>' . $client_tagline . '</h3>
                                <h2>' . $client_heading . '</h2>
                            </div>
                            <p>' . $section_description . ' </p>
                            <div class="row">
                                <ul>
                                    ' . $inspection_list_ . '
                                </ul>
                            </div>
                            ' . $button_one . '
                        </div>
                    </div>
                    ' . $img_right . '
                </div>
            </div>
        </section>';
    }

}

/*
 * Car Inspection Two
 */
if (!function_exists('cs_elementor_car_inspection_two')) {

    function cs_elementor_car_inspection_two($params)
    {
        $inspection_list_ = $main_img = $small_img = '';
        $client_tagline = $client_heading = $section_description = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $bg_img = $main_image = $inspection_list = $img_postion = $animation_effects = '';

        $client_tagline = $params['client_tagline'];
        $client_heading = $params['client_heading'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        $bg_img = $params['bg_img'];
        $main_image = $params['main_image'];
        $inspection_list = $params['inspection_list'];
        $img_postion = $params['img_postion'];
        $animation_effects = $params['animation_effects'];


        if (count((array)$inspection_list) > 0) {
            foreach ($inspection_list as $row) {
                if (isset($row['inspection'])) {
                    $inspection_list_ .= '<li> <i class="fa fa-check"></i> ' . $row['inspection'] . '</li>';
                }
            }
        }

        $offset = '';
        $right_images_class = '';
        if ($img_postion == 'right') {
            $offset = 'col-lg-offset-4';
            $right_images_class = 'images-right';
        }


        $img_left = $img_right = $small_img = '';
        if (wp_attachment_is_image($main_image)) {
            $main_img = carspot_returnImgSrc($main_image);
        } else {
            $main_img = get_template_directory_uri() . '/images/s6.png';
        }

        if (wp_attachment_is_image($bg_img)) {
            $small_img = carspot_returnImgSrc($bg_img);
        } else {
            $small_img = get_template_directory_uri() . '/images/Rim.png';
        }

//animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }


        return '<section class="carspot-dealership-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-xs-12 col-md-8 ' . $offset . '">
                        <div class="carspot-main-section">
                            <div class="carspot-new-text-section">
                                <h3>' . $client_tagline . '</h3>
                                <h2>' . $client_heading . '</h2>
                            </div>
                            <div class="carspot-short-text-section">
                                <p> ' . $section_description . ' </p>
                            </div>
                            <div class="new-cars-detail-section">
                                <ul class="list-inline count-setion">
                                    ' . $inspection_list_ . '
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cars-alloy-rims ' . $right_images_class . '"> <img src="' . esc_url($small_img) . '" alt="' . esc_html__('Image Not Found', 'carspot') . '" class="img-responsive"> </div>
                    <div class="cars-images ' . $right_images_class . '"><img src="' . esc_url($main_img) . '" class="wow ' . $revail_animation . ' img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms" alt="' . esc_html__('Image Not Found', 'carspot') . '"></div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Categories - Classic
 */
if (!function_exists('cs_elementor_cat_classic')) {

    function cs_elementor_cat_classic($params)
    {
        $cat_link_page = $header_style = $section_title = $section_description = $sub_limit = $header = '';
        $cats = array();


        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $sub_limit = $params['sub_limit'];
        $cats = $params['cats'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $categories_html = '';
        if (isset($cats)) {
            $rows = $cats;
            $counter = 1;
            if (count((array)$rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cs_cats']) && isset($row['cs_cats']) && $row['cs_cats'] != "") {
                        $category = get_term_by('slug', $row['cs_cats'], 'ad_cats');
                        if (count((array)$category) == 0)
                            continue;
                        $sub_cat_html = '';
                        $ad_sub_cats = carspot_get_cats('ad_cats', $category->term_id);
                        $i = 1;
                        if ($sub_limit != 0) {
                            foreach ($ad_sub_cats as $sub_cat) {
                                $sub_cat_html .= '<li>
							<a href="' . carspot_cat_link_page($sub_cat->term_id, $cat_link_page) . '">
							' . $sub_cat->name . '<span>' . $sub_cat->count . '</span>
							</a>
							</li>';
                                if ($i == $sub_limit) {
                                    break;
                                }
                                $i++;
                            }
                        }
                        $categories_html .= '
					<div class="col-md-3 col-sm-6">
                        <div class="category-classic">
                           <div class="category-classic-icon">
                              <i class="' . $row['icon'] . '"></i>
                              <div class="category-classic-title">
                                 <h5>
								 <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
								 ' . $category->name . '
								 </a>
								 </h5>
                              </div>
                           </div>
                           <ul class="category-classic-data">
                              ' . $sub_cat_html . '
                           </ul>
						   <div class="clearfix"></div>
                           <div class="traingle"></div>
                           <div class="post-tag-section clearfix">
						   <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
						   <div class="cat-all">' . __('View All', 'carspot') . '</div>
						   </a>
						   </div>
                        </div>
                     </div>';
                        if ($counter % 4 == 0) {
                            $categories_html .= '<div class="clearfix"></div>';
                        }
                        $counter++;
                    }
                }
            }
        }

        return '<section class="custom-padding categories">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            ' . $categories_html . '
                        </div>	
                    </div>
                </div>
            </div>
        </section>';
    }

}
/*
 * Ads By Make
 */
if (!function_exists('cs_elementor_cats_fancy')) {

    function cs_elementor_cats_fancy($params)
    {
        $header_style = $section_title = $section_description = $hover_anim = $cat_link_page = $cats = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $hover_anim = $params['hover_anim'];
        $cat_link_page = $params['cat_link_page'];
        $cats = $params['cats'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $hover_animation = '';
        if ($hover_anim == 'yes') {
            $hover_animation = 'hover-animation';
        }

        $categories_html = '';
        if (isset($cats)) {
            $rows = $cats;

            if (count((array)$rows) > 0) {
                $counter = 0;
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['img']['id']) && $row['cat'] != "") {
                        $category = get_term_by('slug', $row['cat'], 'ad_cats');
                        if (count((array)$category) == 0)
                            continue;
                        $bgImageURL = carspot_returnImgSrc($row['img']['id']);
                        if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
                            $categories_html .= '<div class="col-md-2 col-sm-4">
                                <div class="box">
                                    <a href="' . esc_url(carspot_cat_link_page($category->term_id, $cat_link_page)) . '">
                                        <img alt="' . esc_attr($category->name) . '" src="' . esc_url($bgImageURL) . '">
                                        <h4>
                                            ' . $category->name . '
                                        </h4>
                                    </a> 
                                </div>
                            </div>';
                            if (++$counter % 6 == 0) {
                                $categories_html .= '<div class="clearfix"></div>';
                            }
                        }
                    }
                }
            }
        }

        return '<section class="custom-padding categories ' . $hover_animation . '">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="row">' . $categories_html . '</div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Clients Slider
 */
if (!function_exists('cs_elementor_clients_slider')) {

    function cs_elementor_clients_slider($params)
    {

        $client_tagline = $params['client_tagline'];
        $client_heading = $params['client_heading'];
        $my_clients = $params['my_clients'];


        $testimonials_loop = '';
        $rows = $my_clients;
        if (count((array)$rows) > 0) {
            $clients_thumb = '';
            $client_url = '';
            foreach ($rows as $row) {
                if (isset($row['clients_thumb'])) {
                    $clients_logo = carspot_returnImgSrc($row['clients_thumb']['id']);
                    if (isset($row['client_url']) && $row['client_url'] != '') {
                        $testimonials_loop .= '<div class="client-logo">
                              <a href="' . esc_url($row['client_url']) . '" target="_blank"><img src="' . esc_url($clients_logo) . '" class="img-responsive" alt="' . esc_html__("clients", "carspot") . '" /></a>
                           </div>';
                    } else {
                        $testimonials_loop .= '<div class="client-logo">
								  <img src="' . esc_url($clients_logo) . '" class="img-responsive" alt="' . esc_html__("clients", "carspot") . '" />
							   </div>';
                    }
                }
            }
        }

        return '<section class="client-section">
            <div class="container">
               <div class="row">
                  <div class="col-md-4 col-sm-12 col-xs-12">
                     <div class="margin-top-10">
                        <h3>' . $client_tagline . '</h3>
                        <h2>' . $client_heading . '</h2>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <div class="brand-logo-area clients-bg">
                        <div class="clients-list owl-carousel owl-theme">
                           ' . $testimonials_loop . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * Compare Post
 */
if (!function_exists('cs_elementor_compare_post')) {

    function cs_elementor_compare_post($params)
    {
        global $carspot_theme;
        $header_style = $section_title = $section_description = $btn_title = $btn_link = '';
        $target_one = $nofollow_one = $sidebar_position = $comparison_loop = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $sidebar_position = $params['sidebar_position'];
        $comparison_loop = $params['comparison_loop'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        /* Buttons with link */
        $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-lg  btn-theme', '');
        }

        $columnsize = '';
        if ($sidebar_position == '3') {
            $columnsize = 'col-md-12';
            $inner_column = 'col-md-6';
        } else {
            $columnsize = 'col-md-8';
            $inner_column = 'col-md-12';
        }
        $leftside = '';
        if ($sidebar_position == 1) {
            $leftside = carspot_review_sidebar_shortcode();
        }
        $rightside = '';
        if ($sidebar_position == 2) {
            $rightside = carspot_review_sidebar_shortcode();
        }

//Loop the data
        $comparison_loop = $comparison_loop;
        if (count((array)$comparison_loop) > 0) {
            $compare_page = '';
            if (isset($carspot_theme['carspot_compare_page']) && $carspot_theme['carspot_compare_page'] != "") {
                $compare_page = $carspot_theme['carspot_compare_page'];
            }
            $page_link = get_the_permalink($compare_page);
            $final_img = $compare_grid = '';
            foreach ($comparison_loop as $comparison) {
                $id1 = $comparison['first_car'];
                $id2 = $comparison['second_car'];
                if ($id1 != '' && $id2 != '') {
                    $response1 = carspot_get_feature_image($id1, 'carspot-comparison_thumb');
                    if (wp_attachment_is_image(get_post_thumbnail_id($id1))) {
                        $final_img = $response1[0];
                    } else {
                        $final_img = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $response2 = carspot_get_feature_image($id2, 'carspot-comparison_thumb');
                    if (wp_attachment_is_image(get_post_thumbnail_id($id2))) {
                        $final_img2 = $response2[0];
                    } else {
                        $final_img2 = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $compare_grid .= ' <li class="' . esc_attr($inner_column) . ' col-sm-6 col-xs-12"><div class="comparison-box"><a href="' . $page_link . '?id1=' . $id1 . '&id2=' . $id2 . '">
							 <div class="col-md-6 col-sm-12 col-xs-12">
								   <div class="compare-grid">
									<img src="' . esc_url($final_img) . '" alt="' . __('imag not found', 'carspot') . '" class="img-responsive">
								   <h2>' . get_the_title($id1) . '</h2>
								   <div class="rating">
									  ' . carspot_get_comparison_rating($id1) . '
								   </div>
								</div>
							 </div>';
                    $compare_grid .= ' <div class="vsbox">' . esc_html__('vs', 'carspot') . '</div>';
                    $compare_grid .= ' <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="compare-grid">
                                      <img src="' . esc_url($final_img2) . '" alt="' . __('imag not found', 'carspot') . '" class="img-responsive">
                                       <h2>' . get_the_title($id2) . '</h2>
                                       <div class="rating">
									    ' . carspot_get_comparison_rating($id2) . '
                                       </div>
                                    </div>
                                 </div>';
                    $compare_grid .= '</a></div><li>';
                }
            }
        }


        return '<section class="custom-padding">
            <div class="container">
                ' . $header . '
                <div class="row">
                    ' . $leftside . '
                    <div class="' . esc_attr($columnsize) . ' col-xs-12 col-sm-12">
                        <div class="row">
                            <!-- Car Comparison Archive -->
                            <ul class="compare-masonry text-center">
                                ' . $compare_grid . '
                            </ul>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <div class="load-more-btn">
                                    ' . $button_one . '
                                </div>
                            </div>
                        </div>
                    </div>
                    ' . $rightside . '
                </div>
            </div>
        </section>';
    }

}

/*
 * Contact Us
 */
if (!function_exists('cs_elementor_contact_us')) {

    function cs_elementor_contact_us($params)
    {
        $contact_short_code = $address = $phone = $email = '';

        $contact_short_code = $params['contact_short_code'];
        $address = $params['address'];
        $phone = $params['phone'];
        $email = $params['email'];

        /* adress html */
        $address_html = '';
        if ($address != '') {
            $address_html = '<div class="singleContadds">
                              <i class="fa fa-map-marker"></i>
                              <p>
                                 ' . $address . '
                              </p>
                           </div>';
        }

        /* email html */
        $email_html = '';
        if ($email != '') {
            $email_html = '<div class="singleContadds">
                              <i class="fa fa-envelope"></i>
                              ' . $email . '
                           </div>';
        }
        /* phone html */
        $phone_html = '';
        if ($phone != '') {
            $phone_html = ' <div class="singleContadds phone">
                              <i class="fa fa-phone"></i>
                              <p>' . $phone . ' </p>
                           </div>';
        }

        return '<section class="section-padding gray">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 no-padding commentForm">
                     <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                           ' . do_shortcode(carspot_clean_shortcode($contact_short_code)) . '
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="contactInfo">
                          ' . $address_html . '
                           ' . $phone_html . '
                           ' . $email_html . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * Expert Reviews
 */
if (!function_exists('cs_elementor_expert_reviews')) {

    function cs_elementor_expert_reviews($params)
    {
        global $carspot_theme;
        $header_style = $section_title = $section_description = $max_limit = $cats = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $max_limit = $params['max_limit'];
        $cats = $params['cats'];
        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $args = '';
        $args = array(
            'post_type' => 'reviews',
            'posts_per_page' => $max_limit,
            'tax_query' => array(
                array(
                    'taxonomy' => 'reviews_cats',
                    'field' => 'slug',
                    'terms' => $cats
                )
            ),
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order' => 'DESC',
        );

        $posts = new WP_Query($args);
        $html = '';
        $big_img = '';

        if ($posts->have_posts()) {
            $counter = 0;
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = get_the_ID();

                //Large Thumb
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-reviews-large-shortcode');
                    $img_header = '';
                    if ($image[0] != "") {
                        $img_header = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '">';
                    }
                } else {
                    $img_header = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '">';
                }

                //Small Thumb
                if (wp_attachment_is_image(get_post_thumbnail_id($pid))) {
                    $small_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-reviews-thumb-shortcode');
                    $img_header1 = '';
                    if ($small_thumb[0] != "") {
                        $img_header1 = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($small_thumb[0]) . '">';
                    }
                } else {
                    $img_header1 = '<img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '">';
                }

                if (++$counter == 1) {
                    $big_img .= '<div class="mainimage">
                        <a href="' . get_the_permalink() . '">
                           ' . $img_header . '
                           <div class="overlay">
                              <h2>' . get_the_title() . '</h2>
                           </div>
                        </a>
                        <div class="clearfix"></div>
                     </div>';
                } else {
                    $html .= '<li>
					  <div class="imghold"> <a href="' . get_the_permalink() . '">' . $img_header1 . '</a> </div>
					  <div class="texthold">
						 <h4><a  href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
						 <p>' . carspot_words_count(get_the_excerpt(), 80) . '</p>
					  </div>
					  <div class="clear"></div>
				   </li>';
                }
            }
        }


        return '<section class="news section-padding">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        ' . $big_img . '
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="newslist">
                            <ul> ' . $html . ' </ul>
                        </div>
                    </div>	 
                </div>
            </div>
        </section>';
    }

}

/*
 * FAQ
 */
if (!function_exists('cs_elementor_faq')) {

    function cs_elementor_faq($params)
    {
        $header_style = $section_title = $section_description = $cats = '';
        $tip_section_title = $tips_description = $tips = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $cats = $params['cats'];

        $tip_section_title = $params['tip_section_title'];
        $tips_description = $params['tips_description'];
        $tips = $params['tips'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $bg_bootom = 'yes';
        $rows = $cats;
        $faq_html = '';
        if (count((array)$rows) > 0 && !empty($rows)) {
            $faq_html .= '<ul class="accordion">';
            foreach ($rows as $row) {
                if ($row['title'] != '' && $row['description'] != '') {
                    $faq_html .= '<li>
                           <h3 class="accordion-title"><a href="#">' . esc_html($row['title']) . '</a></h3>
                           <div class="accordion-content">
                              <p>' . esc_html($row['description']) . '</p>
                           </div>
                        </li>';
                }
            }
            $faq_html .= '</ul>';
        }

        // Making tips
        $rows = $tips;
        $tips = '';
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if ($row['tip'] != '') {
                    $tips .= '<li>' . $row['tip'] . '</li>';
                }
            }
        }

        return '<section class="section-padding">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-md-8 col-xs-12 col-sm-12">
                        ' . $faq_html . '
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <div class="blog-sidebar">
                            <div class="widget">
                                <div class="widget-heading">
                                    <h4 class="panel-title"><a>' . $tip_section_title . ' </a></h4>
                                </div>
                                <div class="widget-content">
                                    <p class="lead">' . $tips_description . '</p>
                                    <ol>' . $tips . ' </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}
/*
 * Fun Facts
 */
if (!function_exists('cs_elementor_fun_facts')) {

    function cs_elementor_fun_facts($params)
    {
        $p_cols = $params['p_cols'];
        $fun_facts = $params['fun_facts'];

        $fun_html = '';
        $rows = $fun_facts;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['numbers']) && isset($row['title'])) {
                    $color_html = '';
                    if (isset($row['color_title']))
                        $color_html = '<span>' . $row['color_title'] . '</span>';

                    $icon_html = '';
                    if (isset($row['icon']))
                        $icon_html = '<div class="icons">
                        <i class="' . esc_attr($row['icon']) . '"></i>
                     </div>';

                    $fun_html .= '<div class="col-lg-' . esc_attr($p_cols) . ' col-md-' . esc_attr($p_cols) . ' col-sm-6 col-xs-6">
						' . $icon_html . '
                     <div class="number"><span class="timer" data-from="0" data-to="' . $row['numbers'] . '" data-speed="1500" data-refresh-interval="5">0</span></div>
                     <h4>' . $row['title'] . ' ' . $color_html . '</h4>
                  </div>';
                }
            }
        }

        return '<div class="funfacts custom-padding parallex">
            <div class="container">
               <div class="row">' . $fun_html . '</div>
            </div>
         </div> ';
    }

}
/*
 * Our Team
 */
if (!function_exists('cs_elementor_our_team')) {

    function cs_elementor_our_team($params)
    {

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $add_team = $params['add_team'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $rows = $add_team;
        if (count((array)$rows) > 0) {
            $counter = 0;
            foreach ($rows as $row) {
                $img = wp_get_attachment_image_src($row['team_img']['id'], 'gofinance_teammember');
                if (isset($row['member_name'])) {
                    $social_link = '';
                    if (isset($row['fb'])) {
                        $social_link .= '<li><a target="_blank" class="facebook" href="' . $row['fb'] . '"><i class="fa fa-facebook"></i></a></li>';
                    }
                    if (isset($row['twitter'])) {
                        $social_link .= '<li><a target="_blank" class="twitter" href="' . $row['twitter'] . '"><i class="fa fa-twitter"></i></a></li>';
                    }
                    if (isset($row['google_plus'])) {
                        $social_link .= '<li><a target="_blank" class="google" href="' . $row['google_plus'] . '"><i class="fa fa-google-plus"></i></a></li>';
                    }
                    if (isset($row['LinkedIn'])) {
                        $social_link .= '<li><a target="_blank" class="linkedin" href="' . $row['LinkedIn'] . '"><i class="fa fa-linkedin"></i></a></li>';
                    }
                    $social_media = '<ul class="socials">' . $social_link . '</ul>';
                    $html .= '<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="team">
							<div class="avatar">
								<img alt="' . $row['member_name'] . '" class="img-responsive" src="' . $img[0] . '">
							</div>
							<div class="team-info">
								<h3 class="team-name">' . $row['member_name'] . '</h3>
								<span class="team-job">' . $row['member_desgination'] . '</span>
								' . $social_media . '
							</div>
						</div>
					</div>';
                    if (++$counter % 4 == 0) {
                        $html .= '<div class="clearfix"></div>';
                    }
                }
            }
        }


        return '<section class="custom-padding">
         <div class="container">
		   ' . $header . '
               <div class="row">
                 ' . $html . ' 
               </div>
            </div>
         </section>';
    }

}

/*
 * Packages Style Two
 */
if (!function_exists('cs_elementor_packages_two')) {

    function cs_elementor_packages_two($params)
    {
        $html = $header_style = $section_title = $section_description = '';
        $woo_products_ = array();
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $woo_products_ = $params['woo_products'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }
        $p_b_style = '';
        $pricing_bg_url = '';
        $pricing_bg_url = trailingslashit(get_template_directory_uri()) . "images/price-2-bg.png";
        $p_b_style = ($pricing_bg_url != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $pricing_bg_url . ') "' : "";

        $rows = $woo_products_;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['product']) && $row['product'] != '') {
                    $product_satus = get_post_status($row['product']);
                    if ($product_satus == false || $product_satus != 'publish') {
                        continue;
                    }

                    if (class_exists('WooCommerce')) {
                        $product = wc_get_product($row['product']);
                        $li = '';
                        if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                            $li .= '<li><span>' . __('Package Validity', 'carspot') . '</span>: ' . __('Lifetime', 'carspot') . '</li>';
                        } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {
                            $li .= '<li><span>' . __('Package Validity', 'carspot') . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'carspot') . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_free_ads', true) != "") {
                            $free_ads = get_post_meta($row['product'], 'package_free_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_free_ads', true);
                            $li .= '<li><span>' . __('Simple Ads', 'carspot') . '</span>: ' . $free_ads . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_featured_ads', true) != "") {
                            $feature_ads = get_post_meta($row['product'], 'package_featured_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_featured_ads', true);
                            $li .= '<li><span>' . __('Featured Ads', 'carspot') . '</span>: ' . $feature_ads . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_bump_ads', true) != "") {
                            $bump_ads = get_post_meta($row['product'], 'package_bump_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_bump_ads', true);
                            $li .= '<li><span>' . __('Bump-up Ads', 'carspot') . '</span>: ' . $bump_ads . '</li>';
                        }

                        if ($product) {
                            /* currency position */
                            $currency_pos = $currency_lft = $currency_rght = '';
                            $currency_position = get_option('woocommerce_currency_pos');
                            if ($currency_position == 'left') {
                                $currency_lft = '<span>' . get_woocommerce_currency_symbol() . '</span>';
                            } else if ($currency_position == 'right') {
                                $currency_rght = '<span>' . get_woocommerce_currency_symbol() . '</span>';
                            } elseif ($currency_position == 'left_space') {
                                $currency_lft = '<span>' . get_woocommerce_currency_symbol() . '</span>';
                            } elseif ($currency_position == 'right_space') {
                                $currency_rght = '<span>' . get_woocommerce_currency_symbol() . '</span>';
                            }
                            $prod_price_html = '';
                            $strike_strt = '';
                            $strike_end = '';
                            if ($product->is_on_sale()) {
                                $prod_price_html .= '<h3>' . $currency_lft . $product->get_sale_price() . $currency_rght . '</h3>';
                                $prod_price_html .= '<h4>' . $currency_lft . "<s class='strike-price'>" . $product->get_regular_price() . "</s>" . $currency_rght . '</h4>';
                            } else {
                                $prod_price_html .= '<h3>' . $currency_lft . $product->get_regular_price() . $currency_rght . '</h3>';
                            }
                            $html .= '<div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
								  <div class="pricing-table-box">
									<div class="pricing-section-images" ' . $p_b_style . ' >
									  <div class="pricing-standard-plan">
										<h2>' . $product->get_name() . '</h2>
										<p>' . $product->get_description() . '</p>
									  </div>
									  <div class="price-section">
										' . $prod_price_html . '
									  </div>
									</div>
									<div class="price-main-section">
									  <div class="price-add-section">
										<ul class="price-feature-add">
										  ' . $li . '
										</ul>
									  </div>
									  <div class="price-select-buttons"> <a href="javascript:void(0)" class="btn btn-theme sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1" ><input type="hidden" id="package_nonce" value="' . wp_create_nonce('carspot_package_secure') . '"  />
										' . __('Select Plan', 'carspot') . '
										</a> </div>
									</div>
								  </div>
								</div>';
                        }
                    } else {
                        return '';
                    }
                }
            }
        }

        return '<section class="pricing-table">
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        ' . $html . '
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Packages
 */

if (!function_exists('cs_elementor_packages')) {

    function cs_elementor_packages($params)
    {
        $html = $header_style = $section_title = $section_description = '';
        $woo_products_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $woo_products_ = $params['woo_products'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $rows = $woo_products_;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['product']) && $row['product'] != '') {
                    $product_satus = get_post_status($row['product']);
                    if ($product_satus == false || $product_satus != 'publish') {
                        continue;
                    }
                    if (class_exists('WooCommerce')) {
                        $product = wc_get_product($row['product']);
                        $li = '';
                        if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                            $li .= '<li><span>' . __('Package Validity', 'carspot') . '</span>: ' . __('Lifetime', 'carspot') . '</li>';
                        } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {
                            $li .= '<li><span>' . __('Package Validity', 'carspot') . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'carspot') . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_free_ads', true) != "") {
                            $free_ads = get_post_meta($row['product'], 'package_free_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_free_ads', true);
                            $li .= '<li><span>' . __('Simple Ads', 'carspot') . '</span>: ' . $free_ads . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_featured_ads', true) != "") {
                            $feature_ads = get_post_meta($row['product'], 'package_featured_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_featured_ads', true);
                            $li .= '<li><span>' . __('Featured Ads', 'carspot') . '</span>: ' . $feature_ads . '</li>';
                        }

                        if (get_post_meta($row['product'], 'package_bump_ads', true) != "") {
                            $bump_ads = get_post_meta($row['product'], 'package_bump_ads', true) == '-1' ? __('Unlimited', 'carspot') : get_post_meta($row['product'], 'package_bump_ads', true);
                            $li .= '<li><span>' . __('Bump-up Ads', 'carspot') . '</span>: ' . $bump_ads . '</li>';
                        }
                        $prod_price_html = '';
                        $strike_strt = '';
                        $strike_end = '';
                        if ($product->is_on_sale()) {
                            $prod_price_html .= '<p class="price"><sup>' . get_woocommerce_currency_symbol() . '</sup><span>' . $product->get_sale_price() . '</span></p>';
                            $prod_price_html .= '<p class=" regulr-price"><sup>' . get_woocommerce_currency_symbol() . '</sup><span>' . "<s class='strike-price'>" . $product->get_regular_price() . "</s>" . '</span></p>';
                        } else {
                            $prod_price_html .= '<p class="price"><sup>' . get_woocommerce_currency_symbol() . '</sup><span>' . $product->get_regular_price() . '</span></p>';
                        }
                        $html .= '<div class="col-sm-6 col-lg-4 col-md-4 col-xs-12">
                           <div class="carspot-price-card">
					<h2>' . $product->get_name() . '</h2>
					<p>' . $product->get_description() . '</p>
					' . $prod_price_html . '
						<ul class="pricing-offers">
							 ' . $li . '
						</ul>
					<a href="javascript:void(0)" class="btn btn-theme sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1" >' . __('Select Plan', 'carspot') . '</a><input type="hidden" id="package_nonce" value="' . wp_create_nonce('carspot_package_secure') . '"  />
				</div>
                        </div>';
                    } else {
                        return '';
                    }
                }
            }
        }


        return '<section class="custom-padding">
			<div class="loading" id="sb_loading">…</div>
			<!-- Main Container -->
			<div class="container">
			   <div class="row">
			   ' . $header . '
			   <div class="col-md-12 col-xs-12 col-sm-12">
				   <div class="row">
					' . $html . '
				   </div>
			</div>
		   </div>
		</div>
		</section>';
    }

}


/*
 * Populr Cats
 */

if (!function_exists('cs_elementor_popular_cats')) {

    function cs_elementor_popular_cats($params)
    {
        global $carspot_theme;
        $header_style = $section_title = $section_description = '';
        $cats = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $cats = $params['cats'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $rows = $cats;
        $categories_html = '';
        if (count((array)$rows) > 0) {
            $categories_html .= '<ul class="nav nav-tabs">';
            foreach ($rows as $row) {
                if (isset($row['cat']) && isset($row['icon'])) {
                    $categories_html .= '<li class="clearfix">
                     <a href="' . get_the_permalink($carspot_theme['sb_search_page']) . '?cat_id=' . $row['cat'] . '"> <i class="' . esc_attr($row['icon']) . '"></i> <span class="hidden-xs">' . get_cat_name($row['cat']) . '</span></a>
                  </li>';
                }
            }
            $categories_html .= '</ul>';
        }

        return '<section id="hero" class="hero">
         <div class="content">
            <p>' . carspot_color_text($section_title) . '</p>
            <h1>' . esc_html($section_description) . '</h1>
            <div class="search-holder">
			' . $categories_html . '
            </div>
         </div>
      </section>';
    }

}

/*
 * Process Cycle
 */
if (!function_exists('cs_elementor_process_cycle')) {

    function cs_elementor_process_cycle($params)
    {
        $header_style = $section_title = $section_description = $s1_icon = $s1_title = $s1_description = '';
        $s2_icon = $s2_title = $s2_description = $s3_icon = $s3_title = $s3_description = '';


        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];

        $s1_icon = $params['s1_icon'];
        $s1_title = $params['s1_title'];
        $s1_description = $params['s1_description'];

        $s2_icon = $params['s2_icon'];
        $s2_title = $params['s2_title'];
        $s2_description = $params['s2_description'];

        $s3_icon = $params['s3_icon'];
        $s3_title = $params['s3_title'];
        $s3_description = $params['s3_description'];

        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        return '<section class="section-padding">
            <div class="container">
               <div class="row">
                  ' . $header . '
                  <div class="col-xs-12 col-md-12 col-sm-12 ">
                     <div class="row">
                        <div class="how-it-work text-center">
                           <div class="how-it-work-icon"> <i class="' . esc_attr($s1_icon) . '"></i> </div>
                           <h4>' . esc_html($s1_title) . '</h4>
                           <p>' . esc_html($s1_description) . '</p>
                        </div>
                        <div class="how-it-work text-center ">
                           <div class="how-it-work-icon"> <i class="' . esc_attr($s2_icon) . '"></i> </div>
                           <h4>' . esc_html($s2_title) . '</h4>
                           <p>' . esc_html($s2_description) . '</p>
                        </div>
                        <div class="how-it-work text-center">
                           <div class="how-it-work-icon "> <i class="' . esc_attr($s3_icon) . '"></i></div>
                           <h4>' . esc_html($s3_title) . '</h4>
                           <p>' . esc_html($s3_description) . '</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * User Profile
 */
if (!function_exists('cs_elementor_profile_user')) {

    function cs_elementor_profile_user($params)
    {
        $profile_layout = '';
        $profile_layout = $params['profile_layout'];

        $profile = new carspot_profile();

        return '<section class="section-padding gray" >
            <div class="container">
               ' . $profile->carspot_profile_full_top() . '
               <br>
               ' . $profile->carspot_profile_full_body() . '
            </div>
         </section>';
    }

}

/*
 * Quote Form
 */
if (!function_exists('cs_elementor_quote')) {

    function cs_elementor_quote($params)
    {

        $form_7 = $params['form_7'];
        $attach_image = $params['attach_image'];
        $img_src = '';
        $main_img = '';
        $main_img = carspot_returnImgSrc($attach_image);
        if (isset($main_img) && $main_img != '') {
            $img_src = ' <img src="' . $main_img . '" class="center-block img-responsive" alt="' . esc_html__('Image Not Found', 'carspot') . '">';
        }

        return '<section class="section-padding no-bottom gray no-top ">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 no-padding commentForm">
                     <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                           ' . do_shortcode(carspot_clean_shortcode($form_7)) . '
                     </div>
                     <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					   ' . $img_src . '
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * Review Posts
 */
if (!function_exists('cs_elementor_reviews_post')) {

    function cs_elementor_reviews_post($params)
    {
        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $max_limit = $params['max_limit'];
        $cats = $params['cats'];
        /* header */
        $header = '';
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $cats = array();
        $rows = $cats;
        $is_all = false;
        if ($max_limit != '') {
            $max_limit = $max_limit;
        } else {
            $max_limit = '8';
        }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'reviews',
            'posts_per_page' => $max_limit,
            'paged' => $paged,
            'post_status' => 'publish',
            'category__in' => $cats,
            'orderby' => 'ID',
            'order' => 'DESC',
        );
        $posts = new WP_Query($args);
        $html = '';
        $response = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $pid = get_the_ID();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'carspot-category');
                if ($image != '') {
                    $img_header = '';
                    if ($image[0] != "") {
                        $response = $image[0];
                        $img_header = '<div class="post-img">
                                 <a href="' . get_the_permalink() . '">
								 <img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($image[0]) . '">
								 </a>
                              </div>';
                    } else {
                        $response = $carspot_theme['default_related_image_review']['url'];
                    }
                }
                $terms = get_the_terms($pid, 'reviews_cats');
                $cat_name = '';
                if ($terms != null) {
                    foreach ($terms as $term) {
                        $cat_name .= ' <span class="badge text-uppercase badge-overlay badge-tech"><a href="' . esc_url(get_term_link($term)) . '"> ' . esc_html($term->name) . ' </a></span>';
                    }
                }
                $html .= '<div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="mainimage">
                                 ' . $cat_name . '
                                 <a href="' . get_the_permalink() . '">
                                    <img class="img-responsive" alt="' . get_the_title() . '" src="' . esc_url($response) . '">
                                    <div class="overlay small-font">
                                       <h2>' . get_the_title() . '</h2>
                                    </div>
                                 </a>
                                 <div class="clearfix"></div>
                              </div>
                           </div>';
            }
        }

        $paginationz = '';
        if (function_exists('carspot_shortcodes_pagination')) {
            $paginationz = carspot_shortcodes_pagination($posts->max_num_pages, "", $paged);
        }

        return '<section class="custom-padding reviews">
            <!-- Main Container -->
            <div class="container">
                <div class="row">
                    ' . $header . '
                    <div class="col-md-8 col-xs-12 col-sm-12 news">
                        <div class="row">
                            ' . $html . '
                        </div>
                        <div class="cleaxfix"></div>
                        ' . $paginationz . '
                    </div>
                    ' . carspot_review_sidebar_shortcode() . '
                </div>
            </div>
        </section>';
    }

}

/*
 * search bar minimal
 */

if (!function_exists('cs_elementor_search_bar_minimal')) {

    function cs_elementor_search_bar_minimal($params)
    {
        global $carspot_theme;
        $field_heading = $params['field_heading'];
        $place_title = $params['place_title'];
        $want_to_show = $params['want_to_show'];
        $cats_ = $params['cats'];
        $years_ = $params['years'];
        $body_types_ = $params['body_types'];

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }
        //For Categories
        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count($rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }

        //For Years
        $rows_years = $years_;
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == '') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }

        //For Body Types
        $rows_body = $body_types_;
        $body_cats = false;
        $get_body = '';
        $body_html = '';
        if (count((array)$rows_body) > 0) {
            $body_html .= '';
            foreach ($rows_body as $rows_bodytype) {
                if (isset($rows_bodytype['body_type'])) {
                    if ($rows_bodytype['body_type'] == '') {
                        $body_cats = true;
                        $body_html = '';
                        break;
                    }
                    $get_body = get_term_by('slug', $rows_bodytype['body_type'], 'ad_body_types');
                    if (count((array)$get_body) == 0)
                        continue;
                    $body_html .= '<option value="' . $get_body->name . '">' . $get_body->name . '</option>';
                }
            }

            if ($body_cats) {
                $all_types = carspot_get_cats('ad_body_types', 0);
                foreach ($all_types as $all_type) {
                    $body_html .= '<option value="' . $all_type->name . '">' . $all_type->name . '</option>';
                }
            }
        }

        /* Search page link */
        $serch_page_link = '';
        $serch_page_link = ($carspot_theme['sb_search_page'] != '') ? get_the_permalink($carspot_theme['sb_search_page']) : '';

        return '<div class="search-bar">
            <div class="section-search search-style-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <div class="clearfix">
                                <form method="get" action="' . $serch_page_link . '">
                                    <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                        <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                            <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                                <div class="form-group">
                                                    <label>' . $field_heading . '</label>
                                                    <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . $place_title . '" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                                <div class="form-group">
                                                    <label>' . esc_html__('Select Make', 'carspot') . '</label>
                                                    <select class="form-control" name="cat_id">
                                                        <option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>
                                                        ' . $cats_html . '
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                                <div class="form-group">
                                                    <label>' . esc_html__('Select Year', 'carspot') . '</label>
                                                    <select class=" form-control" name="year_from">
                                                        <option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
                                                        ' . $years_html . '
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                                <div class="form-group">
                                                    <label>' . esc_html__('Body Type', 'carspot') . '</label>
                                                    <select class=" form-control" name="body_type">
                                                        <option label="' . esc_html__('Select Body Type', 'carspot') . '" value="">' . esc_html__('Select Body Type', 'carspot') . '</option>
                                                        ' . $body_html . '
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group pull-right ' . esc_attr($flip_it) . '">
                                            <button type="submit" id="submit_loader" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}

/*
 * Search Simple
 */
if (!function_exists('cs_elementor_search_simple')) {

    function cs_elementor_search_simple($params)
    {
        global $carspot_theme;
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];


        $count_posts = wp_count_posts('ad_post');
        $main_title = str_replace('%count%', '<b>' . $count_posts->publish . '</b>', $section_title);

        /* Search page link */
        $serch_page_link = '';
        $serch_page_link = ($carspot_theme['sb_search_page'] != '') ? get_the_permalink($carspot_theme['sb_search_page']) : '';

        return '<section class="simple-search">
            <div class="container">
                <h1>' . $main_title . '</h1>
                <p>' . esc_html($section_tag_line) . '</p>
                <div class="search-holder">
                    <div id="custom-search-input">
                        <form method="get" action="' . $serch_page_link . '">
                            <div class="col-md-11 col-sm-11 col-xs-11 no-padding">
                                <input type="text" autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control " placeholder="' . esc_html__('What Are You Looking For...', 'carspot') . '" />
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-1 no-padding">	 
                                <button class="btn btn-theme" type="submit"> <span class=" glyphicon glyphicon-search"></span> </button>
                            </div>	 
                        </form>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Search by Modern
 */
if (!function_exists('cs_elementor_search_modern')) {

    function cs_elementor_search_modern($params)
    {
        global $carspot_theme;
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $want_to_show = $params['want_to_show'];
        $cats_ = $params['cats'];
        $years = $params['years'];

        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    if (isset($want_to_show) && $want_to_show == "yes") {

                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {

                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }

        //For Years
        $rows_years = $years;
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == '') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }
        $count_posts = wp_count_posts('ad_post');
        return '<section class="main-search parallex ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-search-title">
                            <h1>' . esc_html($section_title) . '</h1>
                            <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                        </div>
                        <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                            <div class="search-section">
                                <div id="form-panel">
                                    <ul class="list-unstyled search-options clearfix">
                                        <li>
                                            <select class="category form-control" name="cat_id">
                                                <option label="' . esc_html__('Select Make : Any make', 'carspot') . '" value="">' . esc_html__('Select Make : Any make', 'carspot') . '</option>
                                                ' . $cats_html . '
                                            </select>	
                                        </li>
                                        <li>
                                            <input type="text" autocomplete="off" id="autocomplete-dynamic" class="form-control banner-icon-search" name="ad_title" placeholder="' . esc_html__('Audi A4 For Sale....', 'carspot') . '">
                                        </li>
                                        <li>
                                            <select class="form-control" name="year_from">
                                                <option label="' . esc_html__('Select Year : Any Year', 'carspot') . '" value="">' . esc_html__('Select Year : Any Year', 'carspot') . '</option>
                                                ' . $years_html . '
                                            </select>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-danger btn-lg btn-block">' . esc_html__('Search', 'carspot') . '</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * search Fancy
 */
if (!function_exists('cs_elementor_search_fancy')) {

    function cs_elementor_search_fancy($params)
    {
        $section_title = $section_tag_line = $want_to_show = $slides = '';

        global $carspot_theme;
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $want_to_show = $params['want_to_show'];
        $slides = $params['slides'];
        $cats_ = $params['cats'];
        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }
            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }

        // Getting Slides
        $slides = $slides;
        $slider_html = '';
        if (count((array)$slides) > 0) {
            foreach ($slides as $slide) {
                if (isset($slide['img'])) {
                    $slider_html .= '<div class="item linear-overlay"><img src="' . carspot_returnImgSrc($slide['img']['id']) . '" alt="' . esc_html__('image', 'carspot') . '"></div>';
                }
            }
        }
        $count_posts = wp_count_posts('ad_post');

        return '<div class="background-rotator">
         <!-- slider start-->
         <div class="owl-carousel owl-theme background-rotator-slider">
            ' . $slider_html . '
         </div>
         <div class="search-section">
            <!-- Find search section -->
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <!-- Heading -->
                     <div class="content">
                     <div class="heading-caption">
                        <h1>' . esc_html($section_title) . '</h1>
                        <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                     </div>
                     <div class="search-form">
                        <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                           <div class="row">
                              <div class="col-md-4 col-xs-12 col-sm-4">
                        <select class="category form-control" name="cat_id">
							<option label="' . esc_html__('Select Category', 'carspot') . '" value="">' . esc_html__('Select Category', 'carspot') . '</option>
				  		' . $cats_html . '
                        </select>
                              </div>
                              <!-- Input Field -->
                              <div class="col-md-4 col-xs-12 col-sm-4">
                                 <input type="text" id="autocomplete-dynamic" autocomplete="off" name="ad_title" class="form-control banner-icon-search" placeholder="' . esc_html__('Eg Honda Civic , Audi , Ford...', 'carspot') . '" />
                              </div>
                              <!-- Search Button -->
                              <div class="col-md-4 col-xs-12 col-sm-4">
                                 <button type="submit" class="btn btn-theme btn-block">' . esc_html__('Search', 'carspot') . ' <i class="fa fa-search" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </form>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>';
    }

}

/*
 * Search Tab Advanced
 */

if (!function_exists('cs_elementor_search_tab_advance')) {

    function cs_elementor_search_tab_advance($params)
    {

        global $carspot_theme;
        $cat_link_page = '';
        $section_title = $params['section_title'];
        $want_to_show = $params['want_to_show'];
        $cats_ = $params['cats'];
        $years_ = $params['years'];
        $body_types_ = $params['body_types'];

        if (isset($want_to_show) && $want_to_show == "yes") {

        }

        //For Make
        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {
                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }

        //For Years
        $rows_years = $years_;
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == '') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }

        $body_html = '';
        if (isset($body_types_)) {
            $rows_body = $body_types_;

            if (count((array)$rows_body) > 0) {
                foreach ($rows_body as $row_bodytypes) {
                    if (isset($row_bodytypes['body_type']) && isset($row_bodytypes['img']) && $row_bodytypes['body_type'] != '') {
                        $category = get_term_by('slug', $row_bodytypes['body_type'], 'ad_body_types');
                        if (count((array)$category) == 0)
                            continue;
                        $bgImageURL = carspot_returnImgSrc($row_bodytypes['img']['id']);
                        if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
                            $body_html .= '<div class="col-md-2 col-sm-4 col-xs-6">
                     <div class="box">
					 <a href="' . carspot_texnomy_link_page($category->name, $cat_link_page) . '">
                         <img alt="' . $category->name . '" src="' . $bgImageURL . '">
                        <h4>' . $category->name . '</h4>
                       </a> 
                     </div>
                  </div>';
                        }
                    }
                }
            }
        }

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        return '<div class="advance-search">
            <div class="section-search search-style-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" href="#tab1">' . esc_html__('Search Car In Details', 'carspot') . ' </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab2" >' . esc_html__('Search Car By Type', 'carspot') . '</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content clearfix">
                                <div class="tab-pane fade in active" id="tab1">
                                    <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                                        <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                            <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                                <div class="col-md-4 no-padding">
                                                    <div class="form-group">
                                                        <label>' . esc_html__('Keyword', 'carspot') . '</label>
                                                        <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . esc_html__('What Are You Looking For...', 'carspot') . '" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 no-padding">
                                                    <div class="form-group">
                                                        <label>' . esc_html__('Select Make', 'carspot') . '</label>
                                                        <select class="form-control select-make" name="cat_id">
                                                            <option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>
                                                            ' . $cats_html . '
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4 no-padding">
                                                    <div class="form-group">
                                                        <label>' . esc_html__('Select Year', 'carspot') . '</label>
                                                        <select class=" orm-control" name="year_from">
                                                            <option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
                                                            ' . $years_html . '
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group pull-right ' . esc_attr($flip_it) . '">
                                                <button type="submit" id="submit_loader" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="tab2" >
                                    <form>
                                        <div class="search-form">
                                            <div class="search-form-inner-type">                                  
                                                ' . $body_html . '                                   
                                            </div>                                 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}

/*
 * Search Tab Classified
 */
if (!function_exists('cs_elementor_search_tab_classified')) {

    function cs_elementor_search_tab_classified($params)
    {
        $first_tab = $second_tab = $section_title = $category_title = $want_to_show = $price_title = $pricing_start = $pricing_end = '';
        $cats_ = $category_types_ = array();
        global $carspot_theme;
        $first_tab = $params['first_tab'];
        $second_tab = $params['second_tab'];
        $section_title = $params['section_title'];
        $category_title = $params['category_title'];
        $want_to_show = $params['want_to_show'];
        $cats_ = $params['cats'];
        $price_title = $params['price_title'];
        $pricing_start = (int)$params['pricing_start'];
        $pricing_end = (int)$params['pricing_end'];
        $category_types_ = $params['category_types'];

        //For Category
        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;

                    if (isset($want_to_show) && $want_to_show == "yes") {

                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {

                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }


        $catz_html = $cat_link_page = '';
        if (isset($category_types_)) {
            $rows_cat = $category_types_;

            if (count((array)$rows_cat) > 0) {
                $counter = 0;
                foreach ($rows_cat as $rows_cats) {
                    if (isset($rows_cats['cat']) && isset($rows_cats['img']['id']) && $rows_cats['cat'] != '') {
                        $category = get_term_by('slug', $rows_cats['cat'], 'ad_cats');
                        if (count((array)$category) == 0)
                            continue;
                        $bgImageURL = carspot_returnImgSrc($rows_cats['img']['id']);
                        if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
                            $catz_html .= '<div class="col-md-2 col-sm-4 col-xs-6">
                     <div class="box">
					 <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
                         <img alt="' . $category->name . '" src="' . $bgImageURL . '">
                        <h4>' . $category->name . '</h4>
                       </a> 
                     </div>
                  </div>';
                            if (++$counter % 6 == 0) {
                                $catz_html .= "<div class='clearfix visible-md visible-lg'></div>";
                            }
                        }
                    }
                }
            }
        }

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        wp_enqueue_script('price-slider-custom', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array(), false, true);

        $price_html = '<input type="hidden" id="min_price" value="' . esc_attr($pricing_start) . '" />
          <input type="hidden" id="max_price" value="' . esc_attr($pricing_end) . '" />
          <input type="hidden" name="min_price" id="min_selected" value="" />
          <input type="hidden" name="max_price" id="max_selected" value="" />';

        return '<div class="advance-search">
            <div class="section-search search-style-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" href="#classified_tab1">' . $first_tab . '</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#classified_tab2" >' . $second_tab . '</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content clearfix">
                                <div class="tab-pane fade in active" id="classified_tab1">
                                    <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                                        ' . $price_html . '
                                        <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                            <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                                <div class="col-md-4 no-padding">
                                                    <div class="form-group">
                                                        <label>' . $section_title . '</label>
                                                        <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . esc_html__('What Are You Looking For...', 'carspot') . '" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 no-padding">
                                                    <div class="form-group">
                                                        <label>' . $category_title . '</label>
                                                        <select class="form-control" name="cat_id">
                                                            <option label="' . esc_html__('Select Option', 'carspot') . '" value="">' . esc_html__('Select Option', 'carspot') . '</option>
                                                            ' . $cats_html . '
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <span class="price-slider-value">' . $price_title . ' (' . $carspot_theme['sb_currency'] . ') <span id="price-min"></span> - <span id="price-max"></span></span>
                                                        <div id="price-slider"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group pull-right ' . esc_attr($flip_it) . '">
                                                <button type="submit" id="submit_loader" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="classified_tab2" >
                                    <div class="search-form">
                                        <div class="search-form-inner-type">                                  
                                            ' . $catz_html . '                                   
                                        </div>                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

}

/*
 * Search Make Model Year
 */
if (!function_exists('cs_elementor_search_make_model_year')) {

    function cs_elementor_search_make_model_year($params)
    {
        $section_title = $section_tag_line = '';
        $cats_ = $years_ = array();
        global $carspot_theme;

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $cats_ = $params['cats'];
        $years_ = $params['years'];

        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                }
            }
            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {
                    $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                }
            }
        }

        //For Years
        $rows_years = $years_;
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == '') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }
            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }

        $count_posts = wp_count_posts('ad_post');

        return '<section class="main-search parallex">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-search-title">
                            <h1>' . esc_html($section_title) . '</h1>
                            <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                        </div>
                        <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                            <div class="loading" id="sb_loading"></div>
                            <div class="search-section">
                                <div id="form-panel">
                                    <ul class="list-unstyled search-options clearfix">
                                        <li>
                                            <select class="category form-control" id="parent_make">
                                                <option label="' . esc_html__('Select Make : Any make', 'carspot') . '" value="">' . esc_html__('Select Make : Any make', 'carspot') . '</option>
                                                ' . $cats_html . '
                                            </select>	
                                        </li>
                                        <li>
                                            <select class="category form-control" id="make_select"></select>	
                                        </li>
                                        <li>
                                            <select class="form-control" name="year_from">
                                                <option label="' . esc_html__('Select Year : Any Year', 'carspot') . '" value="">' . esc_html__('Select Year : Any Year', 'carspot') . '</option>
                                                ' . $years_html . '
                                            </select>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-danger btn-lg btn-block">' . esc_html__('Search', 'carspot') . '</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="cat_id" id="get_id" value="" >
                        </form>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Search Side Form One
 */
if (!function_exists('cs_elementor_search_side_form')) {

    function cs_elementor_search_side_form($params)
    {
        $section_title = $section_tag_line = $btn_title = $btn_link = $target_one = '';
        $nofollow_one = $float_car_img = $no_of_ads = $form_text = $form_text = $want_to_show = '';
        $cats_ = $years_ = $rows_years = $feature_list = array();

        global $carspot_theme;
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $feature_list = $params['feature_list'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $float_car_img = $params['float_car_img'];
        $bg_img = $params['bg_img'];
        $no_of_ads = $params['no_of_ads'];
        $form_text = $params['form_text'];
        $want_to_show = $params['want_to_show'];
        $cats_ = $params['cats'];
        $years_ = $params['years'];

        /* Buttons with link */
        $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', '');
        }

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = carspot_returnImgSrc($bg_img);
            $style = 'style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"';
        }

        $single_feature = '';
        $rows = $feature_list;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['single_feature'])) {
                    $single_feature .= '<li> <i class="fa fa-hand-o-right"></i> ' . $row['single_feature'] . '</li>';
                }
            }
        }

        $floatCarImgURL = '';
        if ($float_car_img != "") {
            if (wp_attachment_is_image($float_car_img)) {
                $floatCarImgURL = carspot_returnImgSrc($float_car_img);
            } else {
                $floatCarImgURL = get_template_directory_uri() . '/images/hero-car.png';
            }
        }

        //For Years
        $rows_years = $years_;
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == '') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }

        $rows = $cats_;
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == '') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;
                    if (isset($want_to_show) && $want_to_show == "yes") {

                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {

                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }


        return '<section class="hero-section section-style" ' . $style . '>
         <div class="container">
            <div class="row">
               <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
               		<div class="hero-text">
                    	<h1> ' . esc_html($section_title) . '</h1>
                        <p> ' . esc_html($section_tag_line) . '</p>
						<ul>
							' . $single_feature . '
						</ul>
						' . $button_one . '
                    </div>
               </div>
               <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
               		<img src="' . trailingslashit(get_template_directory_uri()) . 'images/hero-form-shedow.png" class="hero-form-top-style" alt="' . esc_attr__('image not found', 'carspot') . '">
                  	<div class="hero-form">
                    	<div class="hero-form-heading">
                        	<h2> ' . esc_html($no_of_ads) . '</h2>
                            <p>' . esc_html($form_text) . '</p>
                        </div>
                    	<form action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                        	<div class="form-group">
                              <label>' . esc_html__('Keyword', 'carspot') . '</label>
                              <input type="text" class="form-control" autocomplete="off" id="autocomplete-dynamic" name="ad_title"  placeholder="' . esc_html__('What are you looking for...', 'carspot') . '" />
                           </div>
                            <div class="form-group">
                                    <label>' . esc_html__('Select Make : Any make', 'carspot') . '</label>
                                      <select class=" form-control make" name="cat_id">
                                         <option label="' . esc_html__('Select Make : Any make', 'carspot') . '" value="">' . esc_html__('Select Make : Any make', 'carspot') . '</option>
											' . $cats_html . '
                                      </select>
                                </div>
                        	<div class="form-group">
                            	<label>' . esc_html__('Select Manufacturing Year', 'carspot') . '</label>
                                  <select class=" form-control make" name="year_from">
                                     <option label="' . esc_html__('Select Year : Any Year', 'carspot') . '" value="">' . esc_html__('Select Year : Any Year', 'carspot') . '</option>
										' . $years_html . '
                                  </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-theme btn-block" >' . esc_html__('Search Now', 'carspot') . '</button>
                             </div>
                        </form>
                    </div>
               </div>
               <img src="' . $floatCarImgURL . '" class="hero-car wow slideInLeft img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms"  alt="' . __('Image not found', 'carspot') . '">
            </div>
         </div>
      </section>';
    }

}

/*
 * Search Side Form Two
 */
if (!function_exists('cs_elementor_search_side_form_two')) {

    function cs_elementor_search_side_form_two($params)
    {
        $section_title = $section_tag_line = $feature_list = $btn_title = $btn_link = $target_one = $nofollow_one = $float_car_img = $no_of_ads = $form_text = '';
        $year_show_form = $label_year_field = $tag_show_form = $label_tag_field = $condition_show_form = $label_condition_field = '';
        $type_show_form = $label_type_field = $warranty_show_form = $label_warranty_field = '';
        $body_type_show_form = $label_body_type_field = $transmission_show_form = $label_transmission_field = $engine_size_show_form = $label_engine_size_field = '';
        $engine_type_show_form = $label_engine_type_field = $assembly_show_form = $label_assembly_field = $color_show_form = $label_color_field = '';
        $insurance_show_form = $label_insurance_field = $features_show_form = $label_feature_field = $countries_show_form = $label_country_field = '';
        $price_show_form = $label_price_field = $radius_show_form = $radius_distance_unit = $label_radius_field = '';
        global $carspot_theme;

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $feature_list = $params['feature_list'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $float_car_img = $params['float_car_img'];
        $no_of_ads = $params['no_of_ads'];
        $form_text = $params['form_text'];

        $year_show_form = $params['year_show_form'];
        $label_year_field = $params['label_year_field'];

        $tag_show_form = $params['tag_show_form'];
        $label_tag_field = $params['label_tag_field'];

        $condition_show_form = $params['condition_show_form'];
        $label_condition_field = $params['label_condition_field'];

        $type_show_form = $params['type_show_form'];
        $label_type_field = $params['label_type_field'];

        $warranty_show_form = $params['warranty_show_form'];
        $label_warranty_field = $params['label_warranty_field'];

        $body_type_show_form = $params['body_type_show_form'];
        $label_body_type_field = $params['label_body_type_field'];

        $transmission_show_form = $params['transmission_show_form'];
        $label_transmission_field = $params['label_transmission_field'];

        $engine_size_show_form = $params['engine_size_show_form'];
        $label_engine_size_field = $params['label_engine_size_field'];

        $engine_type_show_form = $params['engine_type_show_form'];
        $label_engine_type_field = $params['label_engine_type_field'];

        $assembly_show_form = $params['assembly_show_form'];
        $label_assembly_field = $params['label_assembly_field'];

        $color_show_form = $params['color_show_form'];
        $label_color_field = $params['label_color_field'];

        $insurance_show_form = $params['insurance_show_form'];
        $label_insurance_field = $params['label_insurance_field'];

        $features_show_form = $params['features_show_form'];
        $label_feature_field = $params['label_feature_field'];

        $countries_show_form = $params['countries_show_form'];
        $label_country_field = $params['label_country_field'];

        $price_show_form = $params['price_show_form'];
        $label_price_field = $params['label_price_field'];

        $radius_show_form = $params['radius_show_form'];

        $categ_show_form = $params['categ_show_form'];
        $label_catego_field = $params['label_catego_field'];

        $radius_distance_unit = $params['radius_distance_unit'];
        $label_radius_field = $params['label_radius_field'];

        /* Buttons with link */
        $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', '');
        }

        /* make/category field label */
        $label_catego_field_ = __('Select Make : Any make', 'carspot');
        if (isset($label_catego_field) && $label_catego_field != '') {
            $label_catego_field_ = $label_catego_field;
        }

        /* year field label */
        $label_year_field_ = __('Select Manufacturing Year', 'carspot');
        if (isset($label_year_field) && $label_year_field != '') {
            $label_year_field_ = $label_year_field;
        }

        /* Condition field label */
        $label_condition_field_ = __('Select Condition', 'carspot');
        if (isset($label_condition_field) && $label_condition_field != '') {
            $label_condition_field_ = $label_condition_field;
        }

        /* Tag field label */
        $label_tag_field_ = __('Select Tag', 'carspot');
        if (isset($label_tag_field) && $label_tag_field != '') {
            $label_tag_field_ = $label_tag_field;
           
        }

        /* Ad Type field label */
        $label_type_field_ = __('Select Ad Type', 'carspot');
        if (isset($label_type_field) && $label_type_field != '') {
            $label_type_field_ = $label_type_field;
        }

        /* Warranty field label */
        $label_warranty_field_ = __('Select Warranty', 'carspot');
        if (isset($label_warranty_field) && $label_warranty_field != '') {
            $label_warranty_field_ = $label_warranty_field;
        }

        /* Body Type field label */
        $label_body_type_field_ = __('Select Body Type', 'carspot');
        if (isset($label_body_type_field) && $label_body_type_field != '') {
            $label_body_type_field_ = $label_body_type_field;
        }

        /* Transmission field label */
        $label_transmission_field_ = __('Select Transmission', 'carspot');
        if (isset($label_transmission_field) && $label_transmission_field != '') {
            $label_transmission_field_ = $label_transmission_field;
        }

        /* Engine Size field label */
        $label_engine_size_field_ = __('Select Engine Size', 'carspot');
        if (isset($label_engine_size_field) && $label_engine_size_field != '') {
            $label_engine_size_field_ = $label_engine_size_field;
        }

        /* Engine Type field label */
        $label_engine_type_field_ = __('Select Engine Type', 'carspot');
        if (isset($label_engine_type_field) && $label_engine_type_field != '') {
            $label_engine_type_field_ = $label_engine_type_field;
        }

        /* Assemble field label */
        $label_assembly_field_ = __('Select Assemble', 'carspot');
        if (isset($label_assembly_field) && $label_assembly_field != '') {
            $label_assembly_field_ = $label_assembly_field;
        }

        /* Color field label */
        $label_color_field_ = __('Select Color', 'carspot');
        if (isset($label_color_field) && $label_color_field != '') {
            $label_color_field_ = $label_color_field;
        }

        /* Insurance field label */
        $label_insurance_field_ = __('Select Insurance', 'carspot');
        if (isset($label_insurance_field) && $label_insurance_field != '') {
            $label_insurance_field_ = $label_insurance_field;
        }

        /* Feature field label */
        $label_feature_field_ = __('Select Feature', 'carspot');
        if (isset($label_feature_field) && $label_feature_field != '') {
            $label_feature_field_ = $label_feature_field;
        }

        /* Country field label */
        $label_country_field_ = __('Select Country', 'carspot');
        if (isset($label_country_field) && $label_country_field != '') {
            $label_country_field_ = $label_country_field;
        }

        /* Price field label */
        $label_price_field_ = __('Choose Price', 'carspot');
        if (isset($label_price_field) && $label_price_field != '') {
            $label_price_field_ = $label_price_field;
        }

        /* Radius field label */
        $label_radius_field_ = __('Choose Location With Radius', 'carspot');
        if (isset($label_radius_field) && $label_radius_field != '') {
            $label_radius_field_ = $label_radius_field;
        }

        /* Radius Unit */
        $radius_distance_unit_ = __('KM', 'carspot');
        if (isset($radius_distance_unit) && $radius_distance_unit != '') {
            $radius_distance_unit_ = __('Miles', 'carspot');
        }


        /* ====================
         *  for category 
          ===================== */
        $cats_html = '';
        $heading = '';
        if (isset($carspot_theme['cat_level_1']) && $carspot_theme['cat_level_1'] != "") {
            $heading = $carspot_theme['cat_level_1'];
        }
       if (isset($categ_show_form) && $categ_show_form == "yes") {
        $catego_option = '';
        $all_cats = carspot_get_cats('ad_cats', 0);
        if (is_array($all_cats) && count($all_cats) > 0) {
            foreach ($all_cats as $all_cat) {
                $catego_option .= '<option value="' . $all_cat->term_id . '">' . $all_cat->name . '</option>';
            }
        }

        /* cats html */
        $cats_html .= '<div class="form-group">
                                    <label>' . $label_catego_field_. '</label>
                                        <select class="form-control make" id="make_id_2">
                                            <option label="' . $label_catego_field_ . '" value="">' . $label_catego_field_ . '</option>
										' . $catego_option . '
                                        </select>
                                        <input type="hidden" name="cat_id" id="cat_id_2" value="" />
                                </div>';
        }
        /* ====================
         *  for years 
          ===================== */
        $years_html = '';
        if (isset($year_show_form) && $year_show_form == "yes") {
            $year_option = '';
            $ad_years = carspot_get_cats('ad_years', 0);
            if (is_array($ad_years) && count($ad_years) > 0) {
                foreach ($ad_years as $ad_year) {
                    $year_option .= '<option value="' . $ad_year->name . '">' . $ad_year->name . '</option>';
                }
            }
            /* year html */
            $years_html .= '<div class="form-group">
                                <label>' . $label_year_field_ . '</label>
                                <div class="input-group">
                                    <span class="input-group-addon">' . __("From", "carspot") . '</span>
                                        <select id="year_from" name="year_from" class="form-control">
                                            <option label="' . __('Year From', 'carspot') . '" value="">' . __('Year From', 'carspot') . '</option>
						' . $year_option . '
                                        </select>
                                    <span class="input-group-addon">' . __("To", "carspot") . '</span>
                                        <select id="year_to" name="year_to" class="form-control">
                                            <option label="' . __('Year To', 'carspot') . '" value="">' . __('Year To', 'carspot') . '</option>
                                                ' . $year_option . '
                                        </select>
                                </div>
                            </div>';
        }


        /* ====================
         *  for tags 
          ===================== */
        $tag_html = '';
        if (isset($tag_show_form) && $tag_show_form == "yes") {
            $tag_option = '';
            $all_tags = carspot_get_cats('ad_tags', 0);
            if (is_array($all_tags) && count($all_tags) > 0) {
                foreach ($all_tags as $all_tag) {
                    $tag_option .= '<option value="' . $all_tag->term_id . '">' . $all_tag->name . '</option>';
                }
            }
            /* tags html */
            $tag_html .= '<div class="form-group">
                                    <label>' . $label_tag_field_ . '</label>
                                        <select class=" form-control make" name="ad_tag">
                                            <option label="' . $label_tag_field_ . '" value="">' . $label_tag_field_ . '</option>
										' . $tag_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for condition 
          ===================== */
        $condition_html = '';
        if (isset($condition_show_form) && $condition_show_form == "yes") {
            $condition_option = '';
            $all_conditions = carspot_get_cats('ad_condition', 0);
            if (is_array($all_conditions) && count($all_conditions) > 0) {
                foreach ($all_conditions as $all_condition) {
                    $condition_option .= '<option value="' . $all_condition->name . '">' . $all_condition->name . '</option>';
                }
            }
            /* condition html */
            $condition_html .= '<div class="form-group">
                                    <label>' . $label_condition_field_ . '</label>
                                        <select class=" form-control make" name="condition">
                                            <option label="' . $label_condition_field_ . '" value="">' . $label_condition_field_ . '</option>
										' . $condition_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Type 
          ===================== */
        $type_html = '';
        if (isset($type_show_form) && $type_show_form == "yes") {
            $type_option = '';
            $all_types = carspot_get_cats('ad_type', 0);
            if (is_array($all_types) && count($all_types) > 0) {
                foreach ($all_types as $all_type) {
                    $type_option .= '<option value="' . $all_type->name . '">' . $all_type->name . '</option>';
                }
            }
            /* Type html */
            $type_html .= '<div class="form-group">
                                    <label>' . $label_type_field_ . '</label>
                                        <select class=" form-control make" name="ad_type">
                                            <option label="' . $label_type_field_ . '" value="">' . $label_type_field_ . '</option>
										' . $type_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Warranty 
          ===================== */
        $warranty_html = '';
        if (isset($warranty_show_form) && $warranty_show_form == "yes") {
            $warranty_option = '';
            $all_warranties = carspot_get_cats('ad_warranty', 0);
            if (is_array($all_warranties) && count($all_warranties) > 0) {
                foreach ($all_warranties as $all_warranty) {
                    $warranty_option .= '<option value="' . $all_warranty->name . '">' . $all_warranty->name . '</option>';
                }
            }
            /* Warranty html */
            $warranty_html .= '<div class="form-group">
                                    <label>' . $label_warranty_field_ . '</label>
                                        <select class=" form-control make" name="warranty">
                                            <option label="' . $label_warranty_field_ . '" value="">' . $label_warranty_field_ . '</option>
										' . $warranty_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Body Type 
          ===================== */
        $body_type_html = '';
        if (isset($body_type_show_form) && $body_type_show_form == "yes") {
            $body_type_option = '';
            $all_body_types = carspot_get_cats('ad_body_types', 0);

            if (is_array($all_body_types) && count($all_body_types) > 0) {
                foreach ($all_body_types as $all_body_type) {
                    $body_type_option .= '<option value="' . $all_body_type->name . '">' . $all_body_type->name . '</option>';
                }
            }
            /* Body Type html */
            $body_type_html .= '<div class="form-group">
                                    <label>' . $label_body_type_field_ . '</label>
                                        <select class=" form-control make" name="body_type">
                                            <option label="' . $label_body_type_field_ . '" value="">' . $label_body_type_field_ . '</option>
										' . $body_type_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Transmission 
          ===================== */
        $transmission_html = '';
        if (isset($transmission_show_form) && $transmission_show_form == "yes") {
            $transmission_option = '';
            $all_transmissions = carspot_get_cats('ad_transmissions', 0);
            if (is_array($all_transmissions) && count($all_transmissions) > 0) {
                foreach ($all_transmissions as $all_transmission) {
                    $transmission_option .= '<option value="' . $all_transmission->name . '">' . $all_transmission->name . '</option>';
                }
            }
            /* Transmission html */
            $transmission_html .= '<div class="form-group">
                                    <label>' . $label_transmission_field_ . '</label>
                                        <select class=" form-control make" name="transmission">
                                            <option label="' . $label_transmission_field_ . '" value="">' . $label_transmission_field_ . '</option>
										' . $transmission_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Engine Size 
          ===================== */
        $engineSize_html = '';
        if (isset($engine_size_show_form) && $engine_size_show_form == "yes") {
            $engineSize_option = '';
            $all_engineSizes = carspot_get_cats('ad_engine_capacities', 0);
            if (is_array($all_engineSizes) && count($all_engineSizes) > 0) {
                foreach ($all_engineSizes as $all_engineSize) {
                    $engineSize_option .= '<option value="' . $all_engineSize->name . '">' . $all_engineSize->name . '</option>';
                }
            }
            /* Engine Size html */
            $engineSize_html .= '<div class="form-group">
                                    <label>' . $label_engine_size_field_ . '</label>
                                        <select class=" form-control make" name="engine_capacity">
                                            <option label="' . $label_engine_size_field_ . '" value="">' . $label_engine_size_field_ . '</option>
										' . $engineSize_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Engine Type 
          ===================== */
        $engineType_html = '';
        if (isset($engine_type_show_form) && $engine_type_show_form == "yes") {
            $engineType_option = '';
            $all_engineTypes = carspot_get_cats('ad_engine_types', 0);
            if (is_array($all_engineTypes) && count($all_engineTypes) > 0) {
                foreach ($all_engineTypes as $all_engineType) {
                    $engineType_option .= '<option value="' . $all_engineType->name . '">' . $all_engineType->name . '</option>';
                }
            }
            /* Engine Type html */
            $engineType_html .= '<div class="form-group">
                                    <label>' . $label_engine_type_field_ . '</label>
                                        <select class=" form-control make" name="engine_type">
                                            <option label="' . $label_engine_type_field_ . '" value="">' . $label_engine_type_field_ . '</option>
										' . $engineType_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Assembly 
          ===================== */
        $assembly_html = '';
        if (isset($assembly_show_form) && $assembly_show_form == "yes") {
            $assembly_option = '';
            $all_assembles = carspot_get_cats('ad_assembles', 0);
            if (is_array($all_assembles) && count($all_assembles) > 0) {
                foreach ($all_assembles as $all_assemble) {
                    $assembly_option .= '<option value="' . $all_assemble->name . '">' . $all_assemble->name . '</option>';
                }
            }
            /* asemble html */
            $assembly_html .= '<div class="form-group">
                                    <label>' . $label_assembly_field_ . '</label>
                                        <select class=" form-control make" name="assembly">
                                            <option label="' . $label_assembly_field_ . '" value="">' . $label_assembly_field_ . '</option>
										' . $assembly_option . '
                                        </select>
                                </div>';
        }
        /* ====================
         *  for Color 
          ===================== */
        $color_html = '';
        if (isset($color_show_form) && $color_show_form == "yes") {
            $color_option = '';
            $all_colors = carspot_get_cats('ad_colors', 0);
            if (is_array($all_colors) && count($all_colors) > 0) {
                foreach ($all_colors as $all_color) {
                    $color_option .= '<option value="' . $all_color->name . '">' . $all_color->name . '</option>';
                }
            }
            /* color html */
            $color_html .= '<div class="form-group">
                                    <label>' . $label_color_field_ . '</label>
                                        <select class=" form-control make" name="color_family">
                                            <option label="' . $label_color_field_ . '" value="">' . $label_color_field_ . '</option>
										' . $color_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Insurance 
          ===================== */
        $insurance_html = '';
        if (isset($insurance_show_form) && $insurance_show_form == "yes") {
            $insurance_option = '';
            $all_insurances = carspot_get_cats('ad_insurance', 0);
            if (is_array($all_insurances) && count($all_insurances) > 0) {
                foreach ($all_insurances as $all_insurance) {
                    $insurance_option .= '<option value="' . $all_insurance->name . '">' . $all_insurance->name . '</option>';
                }
            }
            /* Insurance html */
            $insurance_html .= '<div class="form-group">
                                    <label>' . $label_insurance_field_ . '</label>
                                        <select class=" form-control make" name="insurance">
                                            <option label="' . $label_insurance_field_ . '" value="">' . $label_insurance_field_ . '</option>
										' . $insurance_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Features 
          ===================== */
        $feature_html = '';
        if (isset($features_show_form) && $features_show_form == "yes") {
            $feature_option = '';
            $all_features = carspot_get_cats('ad_features', 0);
            if (is_array($all_features) && count($all_features) > 0) {
                foreach ($all_features as $all_feature) {
                    $feature_option .= '<option value="' . $all_feature->name . '">' . $all_feature->name . '</option>';
                }
            }
            /* feature html */
            $feature_html .= '<div class="form-group">
                                    <label>' . $label_feature_field_ . '</label>
                                        <select class=" form-control make" name="ad_feature">
                                            <option label="' . $label_feature_field_ . '" value="">' . $label_feature_field_ . '</option>
										' . $feature_option . '
                                        </select>
                                </div>';
        }

        /* ====================
         *  for Countries 
          ===================== */
        $countries_html = '';
        if (isset($countries_show_form) && $countries_show_form == "yes") {
            $countries_option = '';
            $all_countries = carspot_get_cats('ad_country', 0);
            if (is_array($all_countries) && count($all_countries) > 0) {
                foreach ($all_countries as $all_countrie) {
                    $countries_option .= '<option value="' . $all_countrie->term_id . '">' . $all_countrie->name . '</option>';
                }
            }
            /* Countries html */
            $countries_html .= '<div class="form-group">
                                    <label>' . $label_country_field_ . '</label>
                                        <select class="form-control make" name="country_id">
                                            <option label="' . $label_country_field_ . '" value="">' . $label_country_field_ . '</option>
										' . $countries_option . '
                                        </select>
                                </div>';
        }

        /* ==================== */
        /* for Price */
        /* ===================== */
        wp_enqueue_script('price-slider-custom2', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array(), false, true);
        global $carspot_theme;
        $min_price = 50;
        $max_price = 100000;
        $price_html = '';
        if (isset($price_show_form) && $price_show_form == "yes") {
            $price_html .= '<div class="form-group">
                <label>' . $label_price_field_ . '</label>
                <div class="panel panel-default" id="red-price">
                        <div id = "collapsefour" class = "panel-collapse" role = "tabpanel" aria-labelledby = "headingfour">
                            <div class = "panel-body">
                                <span class = "price-slider-value">' . $label_price_field_ . '
                                    (' . esc_html($carspot_theme['sb_currency']) . ') 
                                    <span id="price-min"></span>
                                    - 
                                    <span id="price-max"></span>
                                </span>
                                <div id="price-slider"></div>
                                <div class="input-group margin-top-10">
                                    <input type="text" class="form-control" name="min_price" id="min_selected" value="' . esc_attr($min_price) . '"  autocomplete="off"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="max_price" id="max_selected" value="' . esc_attr($max_price) . '" autocomplete="off"/>
                                </div>
                                <input type="hidden" id="min_price" value="' . $min_price . '" />
                                <input type="hidden" id="max_price" value="' . $max_price . '" />
                            </div>
                        </div>
                        ' . carspot_search_params('min_price', 'max_price') . '
                </div>
            </div>';
        }

        /* ==================== */
        /*     for Radius        */
        /* ===================== */
        $mapType = carspot_mapType();
        if ($mapType == 'google_map') {
            wp_enqueue_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&libraries=places&callback=', false, false, true);
        }
        $radius_html = '';
        if (isset($radius_show_form) && $radius_show_form == 'yes') {
            $heading_html = '';
            $heading_html .= '<label>' . $label_radius_field_ . '</label>';
            //==================
            $stricts = '';
            if (isset($carspot_theme['sb_location_allowed']) && !$carspot_theme['sb_location_allowed'] && isset($carspot_theme['sb_list_allowed_country'])) {
                $stricts = "componentRestrictions: {country: " . json_encode($carspot_theme['sb_list_allowed_country']) . "}";
            }
            //=============
            $map_js_code = '';
            if ($mapType == 'google_map') {
                $map_js_code .= "<script>
			(function ($) {
				'use strict';
				$( document ).ready(function() {
					function initMap() {
						var options = {
						  types: ['(regions)'],
						  " . $stricts . "
						  //componentRestrictions: {country: ['NL','BE']} 
						 };
						var input = document.getElementById('searchMapInput');
						var autocomplete = new google.maps.places.Autocomplete(input, options);
						autocomplete.addListener('place_changed', function() {
							var place = autocomplete.getPlace();
							$('#location-snap').val(place.formatted_address); 
							$('#loc_lat').val(place.geometry.location.lat());
							$('#loc_long').val(place.geometry.location.lng());
						});
					}
					initMap();
				});
				})(jQuery);
            
            </script>";
            }
            $radius_html .= '
                <div class="form-group">
                    ' . $heading_html . '
                    <div class="panel panel-default" id="red-radius">
                    ' . $map_js_code . '
                        <div class="panel-body">
                            <input id="searchMapInput" class="form-control" type="text" name="radius_address" placeholder="' . esc_html__('Search location', 'carspot') . '" value="">
                            <select class="form-control make" id="radius_number" name="radius" data-placeholder="' . esc_html__('Select Radius', 'carspot') . '">
                                <option value="">' . esc_html__("Radius in $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('5', 'carspot') . '">' . esc_html__("5 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('10', 'carspot') . '">' . esc_html__("10 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('15', 'carspot') . '">' . esc_html__("15 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('20', 'carspot') . '">' . esc_html__("20 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('25', 'carspot') . '">' . esc_html__("25 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('35', 'carspot') . '">' . esc_html__("35 $radius_distance_unit_", 'carspot') . ' </option>
                                <option value="' . esc_html__('50', 'carspot') . '">' . esc_html__("50 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('100', 'carspot') . '">' . esc_html__("100 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('150', 'carspot') . '">' . esc_html__("150 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('200', 'carspot') . '">' . esc_html__("200 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('300', 'carspot') . '">' . esc_html__("300 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('500', 'carspot') . '">' . esc_html__("500 $radius_distance_unit_", 'carspot') . ' </option>
                                <option  value="' . esc_html__('1000', 'carspot') . '">' . esc_html__("1000 $radius_distance_unit_", 'carspot') . ' </option>
                            </select>
                            <input type="hidden" name="loc_long" id="loc_long" value="" />
                            <input type="hidden" name="loc_lat" id="loc_lat" value="" />
                            <input type="hidden" name="radius_unit" id="radius_unit" value="' . $radius_distance_unit_ . '" />
                            <input type="hidden" id="location-snap" value="">
                        </div>
                        ' . carspot_search_params('radius', 'loc_long', 'loc_lat', 'radius_address') . '
                    </div>
                </div>';
        }

        /* =============== */
        $floatCarImgURL = '';
        $floatCarImgURL = get_template_directory_uri() . '/images/hero-car.png';
        if ($float_car_img != "") {
            if (wp_attachment_is_image($float_car_img)) {
                $floatCarImgURL = carspot_returnImgSrc($float_car_img);
            }
        }
        $single_feature = '';
        $rows = $feature_list;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['single_feature'])) {
                    $single_feature .= '<li> <i class = "fa fa-hand-o-right"></i> ' . $row['single_feature'] . '</li>';
                }
            }
        }
        $count_posts = wp_count_posts('ad_post');
        return '<section class = "hero-section section-style">
            <div class = "container">
            <div class = "row">
            <div class = "col-lg-7 col-md-7 col-sm-6 col-xs-12">
            <div class = "hero-text">
            <h1> ' . esc_html($section_title) . '</h1>
            <p> ' . esc_html($section_tag_line) . '</p>
            <ul>
            ' . $single_feature . '
            </ul>
            ' . $button_one . '
            </div>
            </div>
            <div class = "col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <img src = "' . trailingslashit(get_template_directory_uri()) . 'images/hero-form-shedow.png" class = "hero-form-top-style" alt = "' . esc_attr__('image not found', 'carspot') . '">
            <div class = "hero-form">
            <div class = "hero-form-heading">
            <h2> ' . esc_html($no_of_ads) . '</h2>
            <p>' . esc_html($form_text) . '</p>
            </div>
            <form action = "' . get_the_permalink($carspot_theme['sb_search_page']) . '">
            <div class = "form-group">
            <label>' . esc_html__('Keyword', 'carspot') . '</label>
            <input type = "text" class = "form-control" autocomplete = "off" id = "autocomplete-dynamic" name = "ad_title" placeholder = "' . esc_html__('What are you looking for...', 'carspot') . '" />
            </div>
            ' . $cats_html . '
                <div id="select_modal_2" class="margin-top-10"></div>
                <div id="select_modals_2" class="margin-top-10"></div>
                <div id="select_forth_div_2" class="margin-top-10"></div>
            
            ' . $years_html . '
            ' . $condition_html . '
            ' . $tag_html . '
            ' . $type_html . '
            ' . $warranty_html . '
            ' . $body_type_html . '
            ' . $transmission_html . '
            ' . $engineSize_html . '
            ' . $engineType_html . '
            ' . $assembly_html . '
            ' . $color_html . '
            ' . $insurance_html . '
            ' . $feature_html . '
            ' . $countries_html . '
            ' . $price_html . '
            ' . $radius_html . '
            <div class = "form-group">
            <button type = "submit" class = "btn btn-lg btn-theme btn-block" >' . esc_html__('Search Now', 'carspot') . '</button>
            </div>
            </form>
            </div>
            </div>
            <img src = "' . $floatCarImgURL . '" class = "hero-car wow slideInLeft img-responsive" data-wow-delay = "0ms" data-wow-duration = "3000ms" alt = "' . __('Image not found', 'carspot') . '">
            </div>
            </div>
            </section>';
    }

}

/*
 * Modern Home Two
 */

if (!function_exists('cs_elementor_search_modern_home_two')) {

    function cs_elementor_search_modern_home_two($params)
    {
        $section_tag_line = $section_title = $car_img = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        global $carspot_theme;

        $section_tag_line = $params['section_tag_line'];
        $section_title = $params['section_title'];
        $car_img = $params['car_img'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        /* Buttons with link */
        $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', '');
        }

        $car_imgURL = '';
        if ($car_img != "") {
            if (wp_attachment_is_image($car_img)) {
                $car_imgURL = carspot_returnImgSrc($car_img);
            } else {
                $car_imgURL = get_template_directory_uri() . '/images/hero-cars-2.png';
            }
        }

        $count_posts = wp_count_posts('ad_post');
        return '<section class="hero-section-2 section-style-3 opacity-color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                        <div class="hero-section-2-text">
                            <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                            <h1> ' . $section_title . '</h1>
                            ' . $button_one . '
                        </div>
                    </div>
                    <img src="' . esc_url($car_imgURL) . '" class="hero-car wow zoomIn img-responsive" data-wow-delay="0ms" data-wow-duration="3000ms"  alt="' . esc_html__("image not found", 'carspot') . '"> </div>
            </div>
        </section>';
    }

}

/*
 * Services
 */

if (!function_exists('cs_elementor_services')) {

    function cs_elementor_services($params)
    {
        $header_style = $section_title = $section_description = $services_add_left = $services_add_right = '';
        $service_img = $animation_effects = $header = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];

        $services_add_left = $params['services_add_left'];
        $services_add_right = $params['services_add_right'];

        $service_img = $params['service_img'];
        $animation_effects = $params['animation_effects'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        //animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }

        //Service Image
        $main_img = '';
        $img_src = carspot_returnImgSrc($service_img);
        if (isset($img_src) && ($img_src != "")) {
            $main_img .= '<figure class="wow ' . $revail_animation . '  animated" data-wow-delay="0ms" data-wow-duration="3500ms" >
                        <img class="center-block" src="' . $img_src . '" alt="' . esc_html__('Image Not Available', 'carspot') . '">
                     </figure>';
        }

        $left_column = '';
        $right_column = '';
        //Left Services Column
        $rows = $services_add_left;
        if (count((array)$rows) > 0) {

            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $left_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row['icon'] . '"></i></div>
                        <h4>' . $row['serv_title'] . '</h4>
                        <p>' . $row['serv_desc'] . '</p>
                     </div>';
                }
            }
        }

        //Right Services Column
        $rows2 = $services_add_right;
        if (count((array)$rows) > 0) {

            foreach ($rows2 as $row1) {
                if (isset($row1['serv_title_right']) && isset($row1['serv_desc_right'])) {
                    $right_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row1['icon_right'] . '"></i></div>
                        <h4>' . $row1['serv_title_right'] . '</h4>
                        <p>' . $row1['serv_desc_right'] . '</p>
                     </div>';
                }
            }
        }

        return '<section class="section-padding services-center">
            <div class="container">
                ' . $header . '
                <div class="row clearfix">
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-left ' . $flip_it . '">' . $left_column . '</div>
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-right ' . $flip_it . '">' . $right_column . '</div>
                    <div class="col-md-4 col-sm-12 col-xs-12">' . $main_img . '</div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Services Two
 */
if (!function_exists('cs_elementor_services_two')) {

    function cs_elementor_services_two($params)
    {
        $header_style = $section_title = $section_description = $services_add_left = $services_add_right = $service_img = $animation_effects = $header = '';


        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];

        $services_add_left = $params['services_add_left'];
        $services_add_right = $params['services_add_right'];

        $service_img = $params['service_img'];
        $animation_effects = $params['animation_effects'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }

        $left_column = '';
        $right_column = '';
        //Left Services Column
        $rows = $services_add_left;
        if (count((array)$rows) > 0) {

            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $left_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row['icon'] . '"></i></div>
                        <h4>' . $row['serv_title'] . '</h4>
                        <p>' . $row['serv_desc'] . '</p>
                     </div>';
                }
            }
        }

        //Right Services Column
        $rows2 = $services_add_right;
        if (count((array)$rows) > 0) {

            foreach ($rows2 as $row1) {
                if (isset($row1['serv_title_right']) && isset($row1['serv_desc_right'])) {
                    $right_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row1['icon_right'] . '"></i></div>
                        <h4>' . $row1['serv_title_right'] . '</h4>
                        <p>' . $row1['serv_desc_right'] . '</p>
                     </div>';
                }
            }
        }

        //Service Image
        $main_img = '';
        $img_src = carspot_returnImgSrc($service_img);
        if (isset($img_src) && ($img_src != "")) {
            $main_img .= '<figure class="wow ' . $revail_animation . '  animated" data-wow-delay="0ms" data-wow-duration="3500ms" >
                        <img class="center-block" src="' . $img_src . '" alt="' . esc_html__('Image Not Available', 'carspot') . '">
                     </figure>';
        }

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        return '<section class="padding-top-90 services-center">
            <div class="container">
                ' . $header . '
                <div class="row clearfix">
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-left ' . $flip_it . '">
                        ' . $left_column . '
                    </div>

                    <!--Right Column-->
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-right ' . $flip_it . '">
                        ' . $right_column . '
                    </div>
                    <!--Image Column-->
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        ' . $main_img . '
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Services Three
 */
if (!function_exists('cs_elementor_services_three')) {

    function cs_elementor_services_three($params)
    {
        $header_style = $section_title = $section_description = $services = $header = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $services = $params['services'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);

        $rows = $services;
        $ext_single_serv = '';
        if (count((array)$rows) > 0) {

            foreach ($rows as $row1) {
                if (isset($row1['serv_title']) && isset($row1['serv_desc'])) {
                    $serImageURL = carspot_returnImgSrc($row1['service_img']['id']);
                    $ext_single_serv .= '<div class="col-lg-3 col-xs-12 col-md-3 col-sm-3">
            <div class="services-box-section">
              <div class="services-main-content">
                <div class="services-icons-section">
				<img src="' . $serImageURL . '" alt="' . __('image not found', 'carspot') . '" class="img-responsive"> </div>
                <h3>' . $row1['serv_title'] . '</h3>
                <p>' . $row1['serv_desc'] . '</p>
              </div>
            </div>
          </div>';
                }
            }
        }

        return '<section class="our-best-services section-style-divider-2 opacity-color parallex">
            <div class="container">
                ' . $header . '
                <div class="row clearfix">
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <div class="services-wrapped-section">
                            ' . $ext_single_serv . '
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Services Modern
 */
if (!function_exists('cs_elementor_services_modern')) {

    function cs_elementor_services_modern($params)
    {
        $section_title_about = $section_description = $img_postion = $animation_effects = $animation_effects2 = '';
        $bg_img1 = $bg_img2 = $main_image = $services_add_left = '';
        $img_left = $img_right = $left_column = $bgImageURL = $background_img1 = $background_img2 = $bgImageURL2 = $client_tagline = '';


        $section_title_about = $params['section_title'];
        $section_description = $params['section_description'];
        $img_postion = $params['img_postion'];
        $animation_effects = $params['animation_effects'];
        $animation_effects2 = $params['animation_effects2'];
        $bg_img1 = $params['bg_img1'];
        $bg_img2 = $params['bg_img2'];
        $main_image = $params['main_image'];
        $services_add_left = $params['services_add_left'];


        //animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }
        //animation
        $revail_animation2 = '';
        if (isset($animation_effects2) && $animation_effects2 != "") {
            $revail_animation2 = $animation_effects2;
        }

        if (wp_attachment_is_image($main_image)) {
            $main_img = carspot_returnImgSrc($main_image);
        } else {
            $main_img = get_template_directory_uri() . '/images/sell-1.png';
        }
        if (isset($main_img) && $main_img != '') {
            if ($img_postion == 'left') {
                $img_left = '<img alt="' . esc_html__('Image Not Found', 'carspot') . '" src="' . $main_img . '" class="img-responsive wow ' . $revail_animation . ' custom-img-left" data-wow-delay="0ms" data-wow-duration="2000ms">';
            } else {
                $img_right = '<img alt="' . esc_html__('Image Not Found', 'carspot') . '" src="' . $main_img . '" class="img-responsive wow ' . $revail_animation . ' custom-img" data-wow-delay="0ms" data-wow-duration="2000ms">';
                $column_left = '';
            }
        }

        if (isset($bg_img1) && $bg_img1 != '') {
            $bgImageURL = carspot_returnImgSrc($bg_img1);
            $background_img1 = 'style="background-image: url(' . $bgImageURL . ');background-position: center top;background-repeat: no-repeat;background-size: cover;height: 100%;left: 0;margin-left: -10%;position: absolute;top: 0;width: 50%;z-index: 1;"';
        }

        if (isset($bg_img2) && $bg_img2 != '') {
            $bgImageURL2 = carspot_returnImgSrc($bg_img2);
            $background_img2 = 'style=" background-image: url(' . $bgImageURL2 . ');background-position: center center;background-repeat: no-repeat;background-size: cover;height: 100%;position: absolute;right: 0;top: 0;width: 80%;"';
        }

        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . ($section_title_about) . '</h2>';
        }

        $rows = $services_add_left;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    if (isset($row['client_tagline'])) {
                        $client_tagline = $row['client_tagline'];
                    }
                    $left_column .= '
				 <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="services-grid-3">
                          <div class="content-area">
						        <h1>' . $client_tagline . '</h1>
								<a href="javascript:void(0)">
								   <h4>' . $row['serv_title'] . '</h4>
								</a>
                                <p>' . $row['serv_desc'] . '</p>
								<div class="service-icon">
                                      <i class="' . $row['icon'] . '"></i>
                                </div>
						</div>
				   </div>
				 </div>';
                }
            }
        }

        return '<section class="section-padding-120 our-services">
            <div class="background-1" ' . $background_img1 . '></div>
            <div class="background-2" ' . $background_img2 . '></div>
            ' . $img_left . '
            ' . $img_right . '
            <div class="container">
                <div class="row clearfix">
                    <div class="left-column col-lg-4 col-md-4 col-md-12">
                        <div class="inner-box">
                            ' . $title . '
                            <div class="text">' . $section_description . '</div>
                        </div>
                    </div>
                    <div class="service-column col-lg-8 col-md-12">
                        <div class="inner-box wow ' . $revail_animation2 . ' animated" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="row clearfix">
                                ' . $left_column . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Services Simple 
 */

if (!function_exists('cs_elementor_services_simple')) {

    function cs_elementor_services_simple($params)
    {
        $header_style = $section_title = $section_description = $section_description = $services_add_left = '';
        $services_add_right = $service_img = $animation_effects = $header = '';


        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $services_add_left = $params['services_add_left'];
        $services_add_right = $params['services_add_right'];
        $service_img = $params['service_img'];
        $animation_effects = $params['animation_effects'];
        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        //animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }

        //Service Image
        $main_img = '';
        $img_src = carspot_returnImgSrc($service_img);
        if (isset($img_src) && ($img_src != "")) {
            $main_img .= '<figure class="wow ' . $revail_animation . '  animated" data-wow-delay="0ms" data-wow-duration="3500ms" >
                        <img class="center-block" src="' . $img_src . '" alt="' . esc_html__('Image Not Available', 'carspot') . '">
                     </figure>';
        }

        $left_column = '';
        $right_column = '';
        //Left Services Column
        $rows = $services_add_left;
        if (count((array)$rows) > 0) {

            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $left_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row['icon'] . '"></i></div>
                        <h4>' . $row['serv_title'] . '</h4>
                        <p>' . $row['serv_desc'] . '</p>
                     </div>';
                }
            }
        }

        //Right Services Column
        $rows2 = $services_add_right;
        if (count((array)$rows) > 0) {

            foreach ($rows2 as $row1) {
                if (isset($row1['serv_title_right']) && isset($row1['serv_desc_right'])) {
                    $right_column .= '
                    <!--Service Block -->
                     <div class="services-grid">
                        <div class="icons icon-right"><i class="' . $row1['icon_right'] . '"></i></div>
                        <h4>' . $row1['serv_title_right'] . '</h4>
                        <p>' . $row1['serv_desc_right'] . '</p>
                     </div>';
                }
            }
        }

        return '<section class="section-padding services-center">
            <div class="container">
                ' . $header . '
                <div class="row clearfix">
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-left ' . $flip_it . '">' . $left_column . '</div>
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-right ' . $flip_it . '">' . $right_column . '</div>
                    <div class="col-md-4 col-sm-12 col-xs-12">' . $main_img . '</div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Service Classic
 */
if (!function_exists('cs_elementor_services_classic')) {

    function cs_elementor_services_classic($params)
    {
        $sell_tagline = $section_title_about = $section_description = $main_image = $img_postion = $services_add_left = $animation_effects = '';

        $sell_tagline = $params['sell_tagline'];
        $section_title_about = $params['section_title'];
        $section_description = $params['section_description'];
        $main_image = $params['main_image'];
        $img_postion = $params['img_postion'];
        $services_add_left = $params['services_add_left'];
        $animation_effects = $params['animation_effects'];

        //animation
        $revail_animation = '';
        if (isset($animation_effects) && $animation_effects != "") {
            $revail_animation = $animation_effects;
        }

        $img_left = '';
        $img_right = '';
        $left_column = '';
        $column_left = '';

        if (wp_attachment_is_image($main_image)) {
            $main_img = carspot_returnImgSrc($main_image);
        } else {
            $main_img = get_template_directory_uri() . '/images/car.png';
        }
        if (isset($main_img) && $main_img != '') {
            if ($img_postion == 'left') {
                $img_left = '<div class="absolute-img"><img alt="' . esc_html__('Image Not Found', 'carspot') . '" src="' . $main_img . '" class="img-responsive wow ' . $revail_animation . '" data-wow-delay="0ms" data-wow-duration="2000ms"></div>';
                $column_left = '<div class="col-md-5"></div>';
            } else {
                $img_right = '<div class="absolute-img-right"><img alt="' . esc_html__('Image Not Found', 'carspot') . '" src="' . $main_img . '" class="img-responsive wow ' . $revail_animation . '" data-wow-delay="0ms" data-wow-duration="2000ms"></div>';
                $column_left = '';
            }
        }

        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $rows = $services_add_left;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $left_column .= '
				<li class="col-md-6 col-xs-12 col-sm-6">
					<div class="services-grid">
						 <div class="icons"><i class="' . $row['icon'] . '"></i></div>
						<h4>' . $row['serv_title'] . '</h4>
						 <p>' . $row['serv_desc'] . '</p>
					</div>
				</li>';
                }
            }
        }

        return '<section class="custom-padding services-2">
           ' . $img_left . '
		   ' . $img_right . '
            <div class="container">
               <div class="row">
                  ' . $column_left . '
                  <div class="col-md-7 col-sm-12 col-xs-12 ">
                     <div class="choose-title">
                        <h3>' . $sell_tagline . '</h3>
                             ' . $title . '
                        <p>' . $section_description . '</p>
                     </div>
                     <div class="choose-services">
                        <ul class="choose-list">
                              ' . $left_column . '
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}

/*
 * Services With Facts
 */

if (!function_exists('cs_elementor_services_facts')) {

    function cs_elementor_services_facts($params)
    {
        $fact_count = $fact_text = $funfact_detaisl = $fact_color_text = $funfact_all = $header = '';
        $header_style = $section_title = $section_description = $services_with_img = $funfact_show_hide = $funfact_detaisl = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $services_with_img = $params['services_with_img'];
        $bg_img = $params['bg_img'];
        $funfact_show_hide = $params['funfact_show_hide'];
        $funfact_detaisl = $params['funfact_detaisl'];


        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = carspot_returnImgSrc($bg_img);
            $style = 'style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"';
        }

        $services_all = '';
        $rows = $services_with_img;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['serv_title']) && isset($row['serv_desc'])) {
                    $icon_imgURL = carspot_returnImgSrc($row['icon']['id']);
                    $services_all .= '
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="services-3-box">
                            <div class="icon-area"><img src="' . $icon_imgURL . '" alt="' . __('image not found', 'carspot') . '"></div>
                            <span class="counts">' . $row['serv_count'] . '</span>
                            <h3>' . $row['serv_title'] . '</h3>
                            <p>' . $row['serv_desc'] . '</p>
                        </div>
                      </div>';
                }
            }
        }

        /* FUNFACTS COUNTER */

        if (!empty($funfact_detaisl)) {
            $rows = $funfact_detaisl;
            if (count((array)$rows) > 0) {
                $funfact_all .= '<div class="row"><div class="funfacts with-services">';
                foreach ($rows as $row) {
                    if (isset($row['fact_count']) && isset($row['fact_text'])) {
                        $colored_html = '';
                        if (isset($row['fact_color_text']))
                            $colored_html = '<span>' . $row['fact_color_text'] . '</span>';

                        $funfact_all .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                         <div class="number"><span class="timer" data-from="0" data-to="' . $row['fact_count'] . '" data-speed="1500" data-refresh-interval="5">0</span>+</div>
                         <h4>' . $row['fact_text'] . ' ' . $colored_html . ' </h4>
                      </div>';
                    }
                }
                $funfact_all .= '</div></div>';
            }
        }
        return '<section class="section-padding services-3 section-style-2 parallex " ' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                  	<div class="row">
                      ' . $services_all . '
                    </div>
                 </div>
               </div>
			  ' . $funfact_all . '
            </div>
         </section>';
    }

}
/*
 * Shop Classic/Products
 */
if (!function_exists('cs_elementor_shop_classic')) {

    function cs_elementor_shop_classic($params)
    {
        $header_style = $section_title = $section_description = $no_of_ads = $ad_order = $header = '';
        $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $cat_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $no_of_ads = $params['no_of_ads'];
        $ad_order = $params['ad_order'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $cat_ = $params['cat'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }


        /* Buttons with link */
        $button_one = '';
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-lg  btn-theme', 'fa fa-refresh');
        }


        $rows = $cat_;
        $is_all = false;
        $html = '';
        $cats = array();
        if (!isset($cat_))
            return $html;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cats'])) {
                    if ($row['cats'] != '') {
                        $cats[] = $row['cats'];
                    }
                }
            }
        }

        $category = '';
        if (count((array)$cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $cats,
                ),
            );
        }

        $ordering = 'DESC';
        $order_by = 'ID';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_packages_pricing',
                    'operator' => 'NOT IN'
                ),
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing',
                    'operator' => 'NOT IN'
                ),
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $results = new WP_Query($args);
        if (count((array)$results) > 0) {
            $counter = 0;
            while ($results->have_posts()) {
                $results->the_post();
                $product = wc_get_product(get_the_ID());
                if ($product->get_type() == 'carspot_category_pricing')
                    continue;
                $img = $product->get_image_id();
                $photo = wp_get_attachment_image_src($img, 'medium');
                $final_img = '';
                if ($photo != '' && is_array($photo)) {
                    if ($photo[0] != "") {
                        $final_img = '<img class="img-responsive" alt="' . get_the_title(get_the_ID()) . '" src="' . esc_url($photo[0]) . '">';
                    }
                } else {
                    $final_img = '<img class="img-responsive custom_holder" alt="' . get_the_title(get_the_ID()) . '" src="' . wc_placeholder_img_src() . '">';
                }
                // Start Ratiing
                $ratting = $product->get_average_rating();
                $ratting_html = '';
                for ($star = 1; $star <= 5; $star++) {
                    $is_filled = '';
                    if ($star <= $ratting) {
                        $is_filled = 'filled';
                    }
                    $ratting_html .= '<i class="fa fa-star-o ' . esc_html($is_filled) . '"></i>';
                }
                // Price
                $pricing = '';
                if ($product->get_type() != 'grouped') {
                    if ($product->get_type() == 'variable') {
                        $pricing = wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
                        $pricing .= '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
                    } else {
                        $pricing = wc_price($product->get_sale_price());
                    }
                }
                $reviews = '';
                $reviews = $product->get_review_count() . " " . esc_html__('Reviews', 'carspot');


                $html .= '<div class="col-md-3 col-sm-6 col-xs-12 ">
                     <div class="shop-grid">
                        <div class="shop-product"> 
						' . $final_img . '
                        <div class="shop-product-description">
                           <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                           <div class="rating-stars">' . $ratting_html . '
						   <a href="javascript:void(0)">(' . esc_html($reviews) . ')</a>
						   </div>
						   		<span>' . $pricing . '</span>
						   </div>

                     		</div>
					 </div>
					 </div>';
                if (++$counter % 4 == 0) {
                    $html .= '<div class="clearfix"></div>';
                }
            }
            wp_reset_postdata();
        }

        return '<section class="custom-padding">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    ' . $header . '
                    ' . $html . '
                    <div class="text-center">
                        <div class="load-more-btn">
                            ' . $button_one . '
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}
/*
 * Shop Slider
 */
if (!function_exists('cs_elementor_shop_slider')) {

    function cs_elementor_shop_slider($params)
    {
        $header_style = $section_title = $section_description = $no_of_ads = $ad_order = '';
        $btn_title = $btn_link = $target_one = $nofollow_one = $header = '';
        $cat_ = array();


        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $no_of_ads = $params['no_of_ads'];
        $ad_order = $params['ad_order'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $cat_ = $params['cat'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $rows = $cat_;
        $cats = array();
        $is_all = false;
        $html = '';
        if (!isset($cat_))
            return $html;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cats'])) {
                    if ($row['cats'] != '') {
                        $cats[] = $row['cats'];
                    }
                }
            }
        }

        $category = '';
        if (count((array)$cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $cats,
                ),
            );
        }

        $ordering = 'DESC';
        $order_by = 'ID';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_packages_pricing',
                    'operator' => 'NOT IN'
                ),
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing',
                    'operator' => 'NOT IN'
                ),
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $results = new WP_Query($args);
        if (count((array)$results) > 0) {
            while ($results->have_posts()) {
                $results->the_post();
                $product = wc_get_product(get_the_ID());
                $img = $product->get_image_id();
                $photo = wp_get_attachment_image_src($img, 'medium');
                $final_img = '';
                if ($photo != '') {
                    if ($photo[0] != "") {
                        $final_img = '<img class="img-responsive" alt="' . get_the_title(get_the_ID()) . '" src="' . esc_url($photo[0]) . '">';
                    }
                } else {
                    $final_img = '<img class="img-responsive custom_holder" alt="' . get_the_title(get_the_ID()) . '" src="' . wc_placeholder_img_src() . '">';
                }
                // Start Ratiing
                $ratting = $product->get_average_rating();
                $ratting_html = '';
                for ($star = 1; $star <= 5; $star++) {
                    $is_filled = '';
                    if ($star <= $ratting) {
                        $is_filled = 'filled';
                    }
                    $ratting_html .= '<i class="fa fa-star-o ' . esc_html($is_filled) . '"></i>';
                }
                // Price
                $pricing = '';
                if ($product->get_type() != 'grouped') {
                    if ($product->get_type() == 'variable') {
                        $pricing = wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
                        $pricing .= '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
                    } else {
                        $pricing = wc_price($product->get_sale_price());
                    }
                }
                $reviews = '';
                $reviews = $product->get_review_count() . " " . esc_html__('Reviews', 'carspot');
                $html .= '<div class="item">
                     <div class="shop-grid">
                        <div class="shop-product"> 
						' . $final_img . '
                        <div class="shop-product-description">
                           <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                           <div class="rating-stars">' . $ratting_html . '
						   <a href="javascript:void(0)">(' . esc_html($reviews) . ')</a>
						   </div>
						   		<span>' . $pricing . '</span>
						   </div>

                     		</div>
					 </div>
					 </div>';
            }
            wp_reset_postdata();
        }

        return '<section class="custom-padding over-hidden">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    ' . $header . '
                    <div class="featured-slider-shop container owl-carousel owl-theme">
                        ' . $html . '
                    </div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Shop Tabs
 */

if (!function_exists('cs_elementor_shop_tabs')) {

    function cs_elementor_shop_tabs($params)
    {
        $header_style = $section_title = $section_description = $no_of_ads = $ad_order = $btn_title = $btn_link = $target_one = $nofollow_one = $header = '';
        $cat_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $no_of_ads = $params['no_of_ads'];
        $ad_order = $params['ad_order'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $cat_ = $params['cat'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }
        $cats = array();
        $rows = $cat_;
        $categories_html = '';
        $categories_contents = '';
        $counnt = 1;
        $is_all = false;
        $html = '';
        if (!isset($cat_))
            return $html;
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cats'])) {
                    $is_active = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $counnt++;
                    }
                    $category = get_term_by('slug', $row['cats'], 'product_cat');
                    if (count((array)$category) == 0)
                        continue;
                    if ($category != '') {
                        $categories_html .= ' <li role="presentation" class="' . esc_attr($is_active) . '">
                              <a data-toggle="tab" title="' . $category->name . '" role="tab" href="#' . $category->slug . '" aria-expanded="true">' . $category->name . '</a>
                           </li>';
                        $categories_contents .= '<div id="' . $category->slug . '" role="tabpanel" class="tab-pane in fade ' . esc_attr($is_active) . '">';
                    }
                }
                $category = '';
                if (count((array)$row['cats']) > 0) {
                    $category = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $row['cats'],
                        ),
                    );
                }
                $ordering = 'DESC';
                $order_by = 'date';
                if ($ad_order == 'asc') {
                    $ordering = 'ASC';
                } else if ($ad_order == 'desc') {
                    $ordering = 'DESC';
                } else if ($ad_order == 'rand') {
                    $order_by = 'rand';
                }
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => $no_of_ads,
                    'tax_query' => array(
                        $category,
                        array(
                            'taxonomy' => 'product_type',
                            'field' => 'slug',
                            'terms' => 'carspot_packages_pricing',
                            'operator' => 'NOT IN'
                        ),
                        array(
                            'taxonomy' => 'product_type',
                            'field' => 'slug',
                            'terms' => 'carspot_category_pricing',
                            'operator' => 'NOT IN'
                        ),
                    ),
                    'orderby' => $order_by,
                    'order' => $ordering,
                );
                $results = new WP_Query($args);
                if (count((array)$results) > 0) {
                    $counter = 0;
                    while ($results->have_posts()) {
                        $results->the_post();
                        $product = wc_get_product(get_the_ID());
                        $img = $product->get_image_id();
                        $photo = wp_get_attachment_image_src($img, 'medium');
                        $final_img = '';
                        if ($photo != '') {
                            if ($photo[0] != "") {
                                $final_img = '<img class="img-responsive" alt="' . get_the_title(get_the_ID()) . '" src="' . esc_url($photo[0]) . '">';
                            }
                        } else {
                            $final_img = '<img class="img-responsive custom_holder" alt="' . get_the_title(get_the_ID()) . '" src="' . wc_placeholder_img_src() . '">';
                        }
                        // Start Ratiing
                        $ratting = $product->get_average_rating();
                        $ratting_html = '';
                        for ($star = 1; $star <= 5; $star++) {
                            $is_filled = '';
                            if ($star <= $ratting) {
                                $is_filled = 'filled';
                            }
                            $ratting_html .= '<i class="fa fa-star-o ' . esc_html($is_filled) . '"></i>';
                        }
                        // Price
                        $pricing = '';
                        if ($product->get_type() != 'grouped') {
                            if ($product->get_type() == 'variable') {
                                $pricing = wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
                                $pricing .= '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
                            } else {
                                $pricing = wc_price($product->get_sale_price());
                            }
                        }
                        $reviews = '';
                        $reviews = $product->get_review_count() . " " . esc_html__('Reviews', 'carspot');
                        $categories_contents .= '<div class="col-md-3 col-sm-6 col-xs-12 ">
                     <div class="shop-grid">
                        <div class="shop-product"> 
						' . $final_img . '
                        <div class="shop-product-description">
                           <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                           <div class="rating-stars">' . $ratting_html . '
						   <a href="javascript:void(0)">(' . esc_html($reviews) . ')</a>
						   </div>
						   		<span>' . $pricing . '</span>
						   </div>

                     		</div>
					 </div>
					 </div>';
                        if (++$counter % 4 == 0) {
                            $categories_contents .= '<div class="clearfix"></div>';
                        }
                    }
                    wp_reset_postdata();
                }
                $categories_contents .= '</div>';
            }
        }
        return '<section class="custom-padding">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    ' . $header . '
                    <div class="recent-tab">	
                        <ul class="nav nav-tabs" role="tablist">' . $categories_html . '</ul>
                    </div>
                    <div class="tab-content">
                        ' . $categories_contents . '
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>';
    }

}

/*
 * Sing In
 */
if (!function_exists('cs_elementor_sign_in')) {

    function cs_elementor_sign_in()
    {
        global $carspot_theme;
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
        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
            $top_padding = '';
        }

        return '<div class="main-content-area clearfix ">
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

/*
 * SingUp
 */
if (!function_exists('cs_elementor_sign_up')) {

    function cs_elementor_sign_up($params)
    {
        global $carspot_theme;
        $btn_title = $btn_link = $target_one = $nofollow_one = $terms_title = $is_captcha = $register_process = '';
        $terms_link = array();

        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        $terms_title = $params['terms_title'];
        $is_captcha = $params['is_captcha'];

        $terms_link['url'] = $btn_link;
        $terms_link['title'] = $btn_title;
        $terms_link['target'] = $target_one;
        $terms_link['rel'] = $nofollow_one;

        $register_process = isset($carspot_theme['cs_register_proces']) ? $carspot_theme['cs_register_proces'] : true;

        $singnup_flag = false;
        if (isset($register_process) && $register_process) {
            $singnup_flag = true;
        } else if (current_user_can('administrator')) {
            $singnup_flag = true;
        }
        if ($singnup_flag) {
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
            return '<div class="main-content-area clearfix">
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
                                    ' . $authentication->carspot_sign_up_form($terms_link, $terms_title, $carspot_theme['google_api_key'], $is_captcha, $code, 'elementor') . '
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        } else {
            wp_redirect(home_url());
            exit;
        }
    }

}

/*
 * Testimonials
 */
if (!function_exists('cs_elementor_testimonial')) {

    function cs_elementor_testimonial($params)
    {
        $header_style = $section_title = $section_description = $header = '';
        $testimonials_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $testimonials_ = $params['testimonials'];
        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $testimonials = '';
        //Left Services Column
        $rows = $testimonials_;
        if (count((array)$rows) > 0) {
            $testi_thumb = '';
            $user_name = '';
            $user_desg = '';
            $rating_val = '';
            foreach ($rows as $row) {
                if (isset($row['testi_user_img'])) {
                    $testi_thumb = carspot_returnImgSrc($row['testi_user_img']['id'], 'carspot-testimonial-thumb');
                }
                if (isset($row['testi_user_name'])) {
                    $user_name = $row['testi_user_name'];
                }
                if (isset($row['testi_user_desg'])) {
                    $user_desg = $row['testi_user_desg'];
                }

                if (isset($row['testi_rating'])) {
                    $rating = $row['testi_rating'];
                    $rating_val = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $star = "";
                        if (!empty($rating) && $i <= $rating) {
                            $star = "fa fa-star";
                        }
                        $rating_val .= '<i class="fa fa-star-o' . $star . '"></i>';
                    }
                }
                if (isset($row['testi_title']) && isset($row['testi_desc'])) {
                    $testimonials .= '
                    <!--Testimonial Column-->
                     <div class="single_testimonial">
                        <div class="textimonial-content">
                           <h4>' . $row['testi_title'] . '</h4>
                           <p>' . $row['testi_desc'] . '</p>
                        </div>
                        <div class="testimonial-meta-box">
                           <img src="' . esc_url($testi_thumb) . '" alt="' . esc_attr($user_name) . '">
                           <div class="testimonial-meta">
                              <h3>' . $user_name . '</h3>
                              <p>' . $user_desg . '</p>
                                ' . $rating_val . '
                           </div>
                        </div>
                     </div>';
                }
            }
        }


        return '
	 <section class="section-padding">
            <!-- Main Container -->
            <div class="container">
			   ' . $header . '
				<div class="row">
                  	<div class="owl-testimonial-2  owl-carousel owl-theme">' . $testimonials . '</div>	 
				</div>
			</div>
	</section>';
    }

}

/*
 * Testimonials Two
 */
if (!function_exists('cs_elementor_testimonial_two')) {

    function cs_elementor_testimonial_two($params)
    {
        $header_style = $section_title = $section_description = '';
        $testimonials_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];

        $testimonials_ = $params['testimonials'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $testimonials = '';
        //Left Services Column
        $rows = $testimonials_;
        if (count((array)$rows) > 0) {
            $testi_thumb = '';
            $user_name = '';
            $user_desg = '';
            $rating_val = '';
            foreach ($rows as $row) {
                if (isset($row['testi_user_img'])) {
                    $testi_thumb = carspot_returnImgSrc($row['testi_user_img']['id'], 'carspot-testimonial-thumb');
                }
                if (isset($row['testi_user_name'])) {
                    $user_name = $row['testi_user_name'];
                }
                if (isset($row['testi_user_desg'])) {
                    $user_desg = $row['testi_user_desg'];
                }

                if (isset($row['testi_rating'])) {
                    $rating = $row['testi_rating'];
                    $rating_val = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $star = "";
                        if (!empty($rating) && $i <= $rating) {
                            $star = "fa fa-star";
                        }
                        $rating_val .= '<i class="fa fa-star-o' . $star . '"></i>';
                    }
                }


                if (isset($row['testi_title']) && isset($row['testi_desc'])) {
                    $testimonials .= '<div class="single_testimonial">
                        <div class="textimonial-content">
                           <h4>' . $row['testi_title'] . '</h4>
                           <p>' . $row['testi_desc'] . '</p>
                        </div>
                        <div class="testimonial-meta-box">
                           <img src="' . esc_url($testi_thumb) . '" alt="' . esc_attr($user_name) . '">
                           <div class="testimonial-meta">
                              <h3>' . $user_name . '</h3>
                              <p>' . $user_desg . '</p>
                                ' . $rating_val . '
                           </div>
                        </div>
                     </div>';
                }
            }
        }

        return '
	 <section class="section-padding">
            <!-- Main Container -->
            <div class="container">
			   ' . $header . '
				<div class="col-md-12 col-xs-12 col-sm-12">
                  <div class="row">
                  	<div class="owl-testimonial-1 owl-carousel owl-theme"> ' . $testimonials . '  </div>	 
				</div>
				</div>
			</div>
	</section>';
    }

}

/*
 * Text Block
 */

if (!function_exists('cs_elementor_textblock')) {

    function cs_elementor_textblock($params)
    {
        $header_style = $section_title = $make = $section_description = $content = $header = $title = '';

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];

        $content = $params['content'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        return '<section class="advertizing">
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-md-12 col-xs-12 col-sm-12 post-excerpt post-desc">' . $content . '</div>
               </div>
            </div>
         </section>';
    }

}

/*
 * why choose us
 */
if (!function_exists('cs_elementor_why_us')) {

    function cs_elementor_why_us($params)
    {
        $header_style = $section_title = $section_description = $header = $title = '';
        $facts_ = array();

        $header_style = $params['header_style'];
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $facts_ = $params['facts'];

        /* header */
        $header = carspot_getHeader($section_title, $section_description, $header_style);
        $icon_imgURL = '';
        $title = '';
        if (isset($section_title_about) && $section_title_about != '') {
            $title = '<h2>' . carspot_color_text($section_title_about) . '</h2>';
        }

        $rows = $facts_;
        $facts_html = '';
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['title']) && isset($row['description'])) {
                    $read_more = '';
                    if (isset($row['link']))
                        $read_more = carspot_ThemeBtn($row['link'], '', false);
                    $facts_html .= '<div class="col-sm-12 col-md-4 col-xs-12 no-padding">
                        <div class="why-us border-box text-center">
                           <h5>' . $row['title'] . '</h5>
                           <p>' . $row['description'] . '
						   ' . $read_more . '
						   </p>
                        </div>
                     </div>';
                }
            }
        }

        return '<section class="about-us">
            <div class="container-fluid">
               <div class="row">
			   ' . $header . '
                  <div class="col-md-12 no-padding"> ' . $facts_html . ' </div>
				</div>
			</div>
			</section>';
    }

}

/*
 *Home - Hero Section
 */
if (!function_exists('cs_elementor_search_creative')) {
    function cs_elementor_search_creative($params)
    {
        $button_one = '';
        $section_title = $params['section_title_inspection'];
        $section_tag_line = $params['section_tag_line'];

        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = cs_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', 'fa fa-refresh');
        }

        $count_posts = wp_count_posts('ad_post');
        return ' <div id="banner">
         <div class="container">
            <div class="search-container">
               <h2>' . esc_html($section_title) . '</h2>
               <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
              ' . $button_one . '
            </div>
         </div>
      </div>';
    }
}


if (!function_exists('cs_elementor_inspection_classic')) {

    function cs_elementor_inspection_classic($params)
    {
        $section_title_inspection = $make = $btn_title =  '';
        

        $section_title_inspection = $params['section_title_inspection'];
        $btn_title = $params['btn_title'];
         $post =get_post('inspection');
   // Add Country       

        /* title */
        if (isset($section_title_inspection) && $section_title_inspection != '') {
            $title = '<div class="title"><h3>' . carspot_color_text($section_title_inspection) . '</h3></div>';
        }

        return '<section class="section-padding  gray">
        <div class="container">
         <div class="row">
         <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
          <div class="postdetails">
          <form id="ad_inpection" name="ad_inpection" >

          <div class="row">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Your Name', 'carspot') . '</label>
                  <input class="form-control" type="text" id="inspection_title" name="inspection_title" value="" required>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                  <label class="control-label">' . esc_html__('Mobile Number', 'carspot') . '</label>
                    <input class="form-control" name="contact_number" value="" type="text" required>
                </div>
           </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label"> ' . esc_html__('Location', 'carspot') . '</label>
                  <select class="category form-control" id="location" name="location" required >
                    '.carspot_framework_terms_options('ad_location' , $make ).'
                   
                 </select>
                
              </div>
           </div>
           <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Address', 'carspot') . '</label>
                   <input class="form-control" type="text" name="address" value="" required>
                </div>
           </div>
             <div class="row">
              <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Make/Model', 'carspot') . '</label>
                 <select class="category form-control" id="make" name="make" required>
                    '.carspot_framework_terms_options('ad_make' , $make ).'
                   
                 </select>
               
              </div>
           </div>
            <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
            <label class="control-label">' . esc_html__('Time Slot', 'carspot') . '</label>
           <input type="datetime" class="form-control date_time" value="" id="ad_time" name="ad_time" placeholder="Select Date $ Time" required>
               </div>

               <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
            <label class="control-label">' . esc_html__('Email address', 'carspot') . '</label>
           <input type="email" class="form-control" value="" id="ad_email" name="ad_email" placeholder="Enter your enail address" required>
               </div>
           </div>
           
           <button class="btn btn-theme pull-right" id="inspection" class="inspection" type="submit">' . esc_html__('submitt', 'carspot') . '</button>
      </form>
     </div>
   </div>  
 </div>
</div>

</section>';
    }

}

// Fetch Terms
if ( ! function_exists( 'carspot_framework_terms_options' ) )
{
    $make = "";
    function carspot_framework_terms_options($tax_name, $selected_val = false)
    {
        $make = "";
        $term_arg = get_terms( array(
            'taxonomy'   => $tax_name,
            'hide_empty' => false,
            'parent'     => 0
        ));
       $make .='<option value="">' .esc_html__('Select an option','propertya-framework').'</option>';
        // Generate options
       $make .= carspot_framework_terms_hierarchy($tax_name,$term_arg,$selected_val);
        
        return $make;
    }

}
if ( ! function_exists( 'carspot_framework_terms_hierarchy' ) )
{
    function carspot_framework_terms_hierarchy( $term_name, $term_arg, $selected_val, $separator = " " )
    {

        $make   = "";
        if (!empty($term_arg) && count($term_arg) > 0)
        {
            foreach ($term_arg as $term)
            {
                if ($selected_val == $term->term_id)
                {
                  $make .= '<option value="' . $term->term_id . '" selected="selected">' . $separator . $term->name . '</option>';
                }
                else
                {
                  $make .= '<option value="' . $term->term_id . '">' . $separator . $term->name . '</option>';
                }
                $check_childs = get_terms( array(
                    'taxonomy'   => $term_name,
                    'hide_empty' => false,
                    'parent'     => $term->term_id
                ) );
                if (!empty($check_childs) )
                {
                    // recursive call if children found
                $make .= carspot_framework_terms_hierarchy( $term_name, $check_childs, $selected_val, "- " . $separator );
                    
                }
            }

            return $make; 
        }
    }
}
