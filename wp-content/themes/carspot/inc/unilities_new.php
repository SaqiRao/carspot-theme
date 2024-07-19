<?php
// Custom Fields Fetching Tables
if (!function_exists('carspot_get_meta')) {

    function carspot_get_meta()
    {
        $table = '';
        $clean_string = '';
        $pid = get_the_ID();
        $c_terms = get_terms('custom_fields', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        if (count((array)$c_terms) > 0) {
            $table .= '<table class="table"><tbody>';
            foreach ($c_terms as $c_term) {
                $meta_name = 'car_features_' . $c_term->slug;
                $meta_value = get_post_meta($pid, $meta_name, true);
                if ($meta_value != "") {
                    $table .= '<tr><th>' . $c_term->name . ':</th><td>' . $meta_value . '</td></tr>';
                }
            }
            $table .= '</tbody></table>';
        }
        return $table;
    }

}


if (!function_exists('carspot_get_meta_verdict')) {

    function carspot_get_meta_verdict()
    {
        global $post;
        $table = '';
        $clean_string = '';
        $pid = get_the_ID();
        $title = $post->verdict_title;
        $summary = $post->verdict_sunnmry;
        $verdict = '';
        $verdict .= '<div class="post-review">';
        $verdict .= '<h3>' . $title . '</h3>';
        $c_terms = get_terms('verdict', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        if (count((array)$c_terms) > 0) {
            foreach ($c_terms as $c_term) {
                $meta_name = 'car_verdict_' . $c_term->slug;
                $meta_value = get_post_meta($pid, $meta_name, true);
                if ($meta_value != "") {
                    $verdict .= '<div class="progress-bar-review">
					<div class="row">
					   <div class="col-sm-12 col-md-3">
						  <span class="progress-title">' . $c_term->name . '</span>
					   </div>
					   <div class="col-sm-12 col-md-8">
						  <div class="progress">
							 <div class="progress-bar">
								<span data-percent="' . $meta_value . '"></span>
							 </div>
						  </div>
					   </div>
					   <div class="col-sm-12 col-md-1">
						  <span class="progress-title">' . $meta_value . '%</span>
					   </div>
					</div>
				 </div>';
                }
            }
        }
        if ($summary == '') {
            $summary_final = '';
        } else {
            $summary_final = "<div class='text-summary'>
	   <h5>" . esc_html__('Summary', 'carspot') . "</h5>
	   <p>" . $summary . "</p>
		</div>";
        }
        $verdict .= '<div class="summary-review">
	  ' . $summary_final . '
	 </div>';
        $verdict .= '</div>';
        return $verdict;
    }
}

if (!function_exists('carspot_compare_values')) {

    function carspot_compare_values()
    {
        $select = '';
        $args = array('post_type' => 'reviews', 'orderby' => 'ID', 'order' => 'DESC');
        $recent_posts = get_posts($args);
        if (count($recent_posts) > 0) {
            $select .= '<select class="form-control">';
            foreach ($recent_posts as $recent) {
                if ($recent->car_name != '') {
                    $select .= '<option value="' . $recent->ID . '">' . $recent->car_name . '</option>';
                }
            }
            $select .= '</select>';
        }
        echo "" . ($select);
    }
}

add_filter('the_content', 'carspot_shortcode_gallery');
if (!function_exists('carspot_shortcode_gallery')) {

    function carspot_shortcode_gallery($content = '')
    {
        preg_match_all('/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            foreach ($matches as $shortcode) {
                $post_type = get_post_format(get_the_ID());
                if ('gallery' === $shortcode[2] && $post_type == 'gallery') {
                    $pos = strpos($content, $shortcode[0]);
                    if ($pos !== false)
                        return substr_replace($content, '', $pos, strlen($shortcode[0]));
                }
            }
        }
        return $content;
    }

}


if (!function_exists('carspot_numberFormat')) {

    function carspot_numberFormat($id = '')
    {
        $number = 0;
        if ($id != "") {
            $number = number_format((int)get_post_meta($id, '_carspot_ad_mileage', true));
            $number = (isset($number) && $number != "") ? $number : 0;
        }
        return $number;
    }

}


if (!function_exists('carspot_convert_uniText')) {

    function carspot_convert_uniText($string = '')
    {
        $string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

}

add_action('wp_ajax_data_fetch', 'carspot_data_fetch_live');
add_action('wp_ajax_nopriv_data_fetch', 'carspot_data_fetch_live');
if (!function_exists('carspot_data_fetch_live')) {

    function carspot_data_fetch_live()
    {
        $tax_query = '';
        $searched = carspot_convert_uniText($_REQUEST['query']);
        $args = array('posts_per_page' => 10, 's' => $searched, 'post_type' => 'ad_post', 'post_status' => 'publish');
        $args = carspot_wpml_show_all_posts_callback($args);
        $the_query = new WP_Query($args);
        $resp = array();
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()): $the_query->the_post();
                $resp[] = array("value" => carspot_convert_uniText(get_the_title()), "data" => get_the_ID());
            endwhile;
            wp_reset_postdata();
        endif;
        $suggestions['suggestions'] = $resp;
        echo json_encode($suggestions);
        die();
        exit;
    }
}

if (!function_exists('carspot_get_user_dp')) {

    function carspot_get_user_dp($user_id = '', $size = 'carspot-single-small')
    {
        global $carspot_theme;
        $user_pic = trailingslashit(get_template_directory_uri()) . 'images/users/1.jpg';
        if (isset($carspot_theme['sb_user_dp']['url']) && $carspot_theme['sb_user_dp']['url'] != "") {
            $user_pic = $carspot_theme['sb_user_dp']['url'];
        }

        $image_link = array();
        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }
        if (isset($image_link[0]) && $image_link[0] != "") {
            return $image_link[0];
        } else {
            return $user_pic;
        }
    }

}

if (!function_exists('carspot_get_dealer_logo')) {

    function carspot_get_dealer_logo($user_id = '', $size = 'full')
    {
        global $carspot_theme;
        $user_pic = trailingslashit(get_template_directory_uri()) . 'images/users/1.jpg';
        if (isset($carspot_theme['sb_user_dp']['url']) && $carspot_theme['sb_user_dp']['url'] != "") {
            $user_pic = $carspot_theme['sb_user_dp']['url'];
        }

        $image_link = array();
        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }
        if (isset($image_link[0]) && $image_link[0] != "") {
            return $image_link[0];
        } else {
            return $user_pic;
        }
    }

}
if (!function_exists('carspot_get_dealer_store_front')) {

    function carspot_get_dealer_store_front($user_id = '', $size = 'full')
    {
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

/*
 * Pagination for custom post types
 * */

if (!function_exists('carspot_shortcodes_pagination')) {

    function carspot_shortcodes_pagination($numpages = '', $pagerange = '', $paged = '')
    {

        if (empty($pagerange)) {
            $pagerange = 2;
        }
        global $paged;
        if (empty($paged)) {
            $paged = 1;
        }
        if ($numpages == '') {
            global $wp_query;
            $numpages = $wp_query->max_num_pages;
            if (!$numpages) {
                $numpages = 1;
            }
        }

        $pagination_args = array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'total' => $numpages,
            'current' => $paged,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => $pagerange,
            'prev_next' => false,
            'prev_text' => ('&laquo;'),
            'next_text' => ('&raquo;'),
            'type' => 'plain',
            'add_args' => false,
            'add_fragment' => ''
        );
        $paginate_links = paginate_links($pagination_args);
        if ($paginate_links) {
            $html = '';
            $html .= "<nav class='custom-pagination'>";
            $html .= $paginate_links;
            $html .= "</nav>";
            return $html;
        }
    }

}

if (!function_exists('carspot_remove_empty_p')) {
    function carspot_remove_empty_p($content = '')
    {
        $content = force_balance_tags($content);
        $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
        $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
        return $content;
    }
}
add_filter('the_content', 'carspot_remove_empty_p', 20, 1);

// the ajax function call
if (!function_exists('carspot_fetch_compariosn')) {

    function carspot_fetch_compariosn($id = '')
    {
        $args = array('post_type' => 'comparison', 'post_status' => 'publish', 'posts_per_page' => -1);
        $results = new WP_Query($args);
        $options = '';
        $selected = '';
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $selected = (get_the_ID() == $id) ? 'selected="selected"' : '';
                $options .= '<option value="' . get_the_ID() . '" ' . $selected . '>' . get_the_title() . '</option>';
            }
            wp_reset_postdata();
        }
        return ($options);
    }

}

//Populate Comparison
add_action('wp_ajax_comparison_data_fetch', 'carspot_popular_compariosn');
add_action('wp_ajax_nopriv_comparison_data_fetch', 'carspot_popular_compariosn');
if (!function_exists('carspot_popular_compariosn')) {

    function carspot_popular_compariosn()
    {
        $id1 = isset($_POST['keyword1']) ? $_POST['keyword1'] : '';
        $id2 = isset($_POST['keyword2']) ? $_POST['keyword2'] : '';
        $table = "";
        $table .= carspot_comparison_img($id1, $id2);
        $table .= '<ul class="accordion">';
        $terms = get_terms(array('taxonomy' => 'comparison_by', 'hide_empty' => false, 'parent' => 0, 'meta_key' => 'order', 'orderby' => 'order', 'order' => 'ASC'));
        $is_first = 1;
        foreach ($terms as $term) {
            $first_id = '';
            $name = esc_attr($term->name);
            if ($is_first == 1) {
                $first_id = "id='first_accor'";
            }
            $table .= '<li ' . $first_id . '><h3 class="accordion-title"><a href="#">' . $name . '</a></h3><div class="accordion-content"><table><tbody>';
            $subterms = get_terms(array('taxonomy' => 'comparison_by', 'child_of' => $term->term_id, 'parent' => $term->term_id, 'hide_empty' => false, 'orderby' => 'order', 'order' => 'ASC'));
            $val = '';
            $val2 = '';
            foreach ($subterms as $subterm) {
                $first_id++;
                $table .= '<tr>
					   <td> ' . $subterm->name . ' </td>
					   <td> ' . carspot_get_metavalue($id1, $subterm->slug, $subterm->term_id) . '</td>
					   <td> ' . carspot_get_metavalue($id2, $subterm->slug, $subterm->term_id) . '</td>
					 </tr> ';
            }
            $table .= '</tbody></table></div></li>';
        }
        $table .= '</ul>';
        echo "" . ($table);
        die();
    }

}

if (!function_exists('carspot_comparison_img')) {

    function carspot_comparison_img($id1 = '', $id2 = '')
    {
        $response1 = '';
        $response2 = '';
        $table = '';
        $table = '<table id="reviews-data"><tbody>';
        $response1 = carspot_get_feature_image($id1, '');
        if ($response1[0] != '') {
            $img_html1 = '<img class="img-responsive" alt="' . __('image not found', 'carspot') . '" src="' . esc_url($response1[0]) . '">';
        }
        $response2 = carspot_get_feature_image($id2, '');
        if ($response2[0] != '') {
            $img_html2 = '<img class="img-responsive" alt="' . __('image not found', 'carspot') . '" src="' . esc_url($response2[0]) . '">';
        }
        $table .= '<tr>
					  <td>' . esc_html__('Images', 'carspot') . '</td>
					  <td> ' . $img_html1 . '
					   <h4>' . get_the_title($id1) . '</h4>
					   ' . carspot_get_comparison_rating($id1) . '
					  </td>
					  <td>'.$img_html2.'
					  <h4>' . get_the_title($id2) . '</h4>
					  ' . carspot_get_comparison_rating($id2) . '
					  </td>
					</tr>';

        $table .= '</tbody></table>';
        return $table;
    }

}

if (!function_exists('carspot_get_metavalue')) {

    function carspot_get_metavalue($post_id = '', $term_slug = '', $term_id = '')
    {
        $valHtml = '';
        if (get_post_meta($post_id, 'car_comparison_' . $term_slug, true) != "") {
            $val = get_post_meta($post_id, 'car_comparison_' . $term_slug, true);
            $type = get_term_meta($term_id, '_carspot_comparison_field_type', true);

            if ($type == 1) {
                if ($val == 1) {
                    $valHtml = '<i class="fa fa-check"></i>';
                } else {
                    $valHtml = '<i class="fa fa-times"></i>';
                }
            } else {
                $valHtml = $val;
            }
        }
        return $valHtml;
    }

}

if (!function_exists('carspot_get_comparison_rating')) {

    function carspot_get_comparison_rating($post_id = '')
    {
        $comp_rating = '';
        $get_values = '';
        $star = '';
        $star1 = "";
        if (get_post_meta($post_id, 'comparison_rating', true) != "") {

            $get_values = get_post_meta($post_id, 'comparison_rating', true);

            for ($i = 1; $i <= 5; $i++) {
                $star1 = "";
                if (!empty($get_values) && $i <= $get_values) {
                    $star1 = "fa fa-star";
                }
                $star .= '<i class="fa fa-star-o' . $star1 . '"></i>';
            }
            $star .= ' <span class="star-score"> (<strong>' . $get_values . '</strong>)</span>';
        }
        return $star;
    }

}

add_action('do_meta_boxes', 'remove_meta', 0);
if (!function_exists('remove_meta')) {
    function remove_meta()
    {
        /* first remove the current metaboxes */
        remove_meta_box('comparison_bydiv', 'comparison', 'side');
    }

}

if (!function_exists('carspot_current_url')) {

    function carspot_current_url()
    {
        $current_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        return $current_url;
    }

}

if (!function_exists('carspot_currenturl_without_queryparam')) {

    function carspot_currenturl_without_queryparam($queryparamkey = '')
    {
        $current_url = carspot_current_url();
        $parsed_url = parse_url($current_url);
        if (array_key_exists('query', $parsed_url)) {
            $query_portion = $parsed_url['query'];
        } else {
            return $current_url;
        }

        parse_str($query_portion, $query_array);

        if (array_key_exists($queryparamkey, $query_array)) {
            unset($query_array[$queryparamkey]);
            $q = (count($query_array) === 0) ? '' : '?';
            return $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . $q . http_build_query($query_array);
        } else {
            return $current_url;
        }
    }

}

if (!function_exists('carspot_search_layouts_demo')) {

    function carspot_search_layouts_demo($is_arr = '1')
    {
        $carspot_layout_type = (isset($_GET['carspot_layout_type']) && $_GET['carspot_layout_type'] != "") ? $_GET['carspot_layout_type'] : '';
        $val = '';
        if ($carspot_layout_type == "1")
            $val = 'list_1';
        if ($carspot_layout_type == "2")
            $val = 'list_2';
        if ($carspot_layout_type == "3")
            $val = 'list_3';
        if ($carspot_layout_type == "4")
            $val = 'grid_1';
        if ($carspot_layout_type == "5")
            $val = 'grid_2';
        if ($carspot_layout_type == "6")
            $val = 'grid_3';
        if ($carspot_layout_type == "7")
            $val = 'grid_4';
        if ($carspot_layout_type == "8")
            $val = 'grid_5';
        return $val;
    }
}

if (!function_exists('carspot_display_key_features')) {

    function carspot_display_key_features($pid = '', $length = '', $no_icons = '')
    {
        global $carspot_theme;
        $keyfeatures = '';
        $keyfeatures .= '<ul class="list-unstyled">';
        if ($no_icons != "") {
            if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") {
                $keyfeatures .= '<li>' . get_post_meta($pid, '_carspot_ad_engine_types', true) . '</li>';
            }

            if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") {
                $keyfeatures .= '<li>' . carspot_numberFormat_pattern($pid, '_carspot_ad_mileage') . ' ' . $carspot_theme['sb_distance_unit'] . '</li>';
            }

            if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") {
                $keyfeatures .= '<li>' . carspot_numberFormat_pattern($pid, '_carspot_ad_engine_capacities') . ' ' . $carspot_theme['sb_power_unit'] . '</li>';
            }

            if (get_post_meta($pid, '_carspot_ad_body_types', true) != "") {
                $keyfeatures .= '<li>' . get_post_meta($pid, '_carspot_ad_body_types', true) . '</li>';
            }

            if (get_post_meta($pid, '_carspot_ad_colors', true) != "") {
                $keyfeatures .= '<li>' . get_post_meta($pid, '_carspot_ad_colors', true) . '</li>';
            }
        } else {
            if ($length == '5') {
                if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-gas-station-1"></i>' . get_post_meta($pid, '_carspot_ad_engine_types', true) . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-dashboard"></i>' . carspot_numberFormat_pattern($pid, '_carspot_ad_mileage') . ' ' . $carspot_theme['sb_distance_unit'] . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-engine-2"></i>' . get_post_meta($pid, '_carspot_ad_engine_capacities', true) . ' ' . $carspot_theme['sb_power_unit'] . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_body_types', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-car-2"></i>' . get_post_meta($pid, '_carspot_ad_body_types', true) . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_colors', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-cogwheel-outline"></i>' . get_post_meta($pid, '_carspot_ad_colors', true) . '</li>';
                }
            } else {
                if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-gas-station-1"></i>' . get_post_meta($pid, '_carspot_ad_engine_types', true) . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-dashboard"></i>' . carspot_numberFormat_pattern($pid, '_carspot_ad_mileage') . ' ' . $carspot_theme['sb_distance_unit'] . '</li>';
                }

                if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") {
                    $keyfeatures .= '<li><i class="flaticon-engine-2"></i>' . carspot_numberFormat_pattern($pid, '_carspot_ad_engine_capacities') . ' ' . $carspot_theme['sb_power_unit'] . '</li>';
                }
            }
        }
        $keyfeatures .= '</ul>';

        return $keyfeatures;
    }

}

if (!function_exists('carspot_numberFormat_pattern')) {

    function carspot_numberFormat_pattern($id = '', $type = '')
    {
        $number = 0;
        if ($id != "") {
            $number = number_format((int)get_post_meta($id, $type, true));
            $number = (isset($number) && $number != "") ? $number : 0;
        }
        return $number;
    }

}

/* Input For More Custom Inputs */
if (!function_exists('carspot_more_inputs')) {

    function carspot_more_inputs()
    {
        global $carspot_theme;
        if (isset($carspot_theme['allow_ad_economy']) && $carspot_theme['allow_ad_economy'] == true) {
            $r['ad_avg_hwy']['name'] = __('Average in Highway', 'carspot');
            $r['ad_avg_hwy']['slug'] = 'ad_avg_hwy';
            $r['ad_avg_hwy']['is_show'] = '1';
            $r['ad_avg_hwy']['is_req'] = '1';
            $r['ad_avg_hwy']['is_search'] = '1';
            $r['ad_avg_hwy']['is_type'] = 'textfield';

            $r['ad_avg_city']['name'] = __('Average in City', 'carspot');
            $r['ad_avg_city']['slug'] = 'ad_avg_city';
            $r['ad_avg_city']['is_show'] = '1';
            $r['ad_avg_city']['is_req'] = '1';
            $r['ad_avg_city']['is_search'] = '1';
            $r['ad_avg_city']['is_type'] = 'textfield';
        }

        $r['ad_mileage']['name'] = __('Mileage', 'carspot');
        $r['ad_mileage']['slug'] = 'ad_mileage';
        $r['ad_mileage']['is_show'] = '1';
        $r['ad_mileage']['is_req'] = '1';
        $r['ad_mileage']['is_search'] = '1';
        $r['ad_mileage']['is_type'] = 'textfield';

        return $r;
    }

}

if (!function_exists('carspot_show_keyfeatures_excluding')) {

    function carspot_show_keyfeatures_excluding($slug = '')
    {

        $retuen = true;
        if ($slug == 'ad_avg_city') {
            $retuen = false;
        }
        if ($slug == 'ad_avg_hwy') {
            $retuen = false;
        }
        return $retuen;
    }

}

if (!function_exists('carspot_GetImageUrlsByProductId')) {

    function carspot_GetImageUrlsByProductId($productId = '')
    {
        $product = wc_get_product($productId);
        $attachmentIds = $product->get_gallery_image_ids();
        $attachmentIds[] = $product->get_image_id();
        return $attachmentIds;
    }

}


add_filter('woocommerce_account_menu_items', 'carspot_remove_my_account_links');
if (!function_exists('carspot_remove_my_account_links')) {

    function carspot_remove_my_account_links($menu_links = '')
    {
        //unset( $menu_links['edit-address'] ); // Addresses
        //unset( $menu_links['dashboard'] ); // Dashboard
        //unset( $menu_links['payment-methods'] ); // Payment Methods
        //unset( $menu_links['orders'] ); // Orders
        unset($menu_links['edit-account']); // Account details
        unset($menu_links['downloads']); // Downloads
        unset($menu_links['customer-logout']); // Logout
        return $menu_links;
    }

}


// Store package
if (!function_exists('carspot_store_user_package')) {

    function carspot_store_user_package($user_id = '', $product_id = '', $order_id = '')
    {
        if ($user_id != "" && $product_id != "") {

            $ads = get_post_meta($product_id, 'package_free_ads', true);
            $featured_ads = get_post_meta($product_id, 'package_featured_ads', true);
            $bump_ads = get_post_meta($product_id, 'package_bump_ads', true);
            $days = get_post_meta($product_id, 'package_expiry_days', true);
            update_user_meta($user_id, '_carspot_pkg_type', get_the_title($product_id));
            update_user_meta($user_id, '_carspot_order_id', $order_id);
            if ($ads == '-1') {
                update_user_meta($user_id, '_sb_simple_ads', '-1');
                //wc_update_order_item_meta( $order_id, '_sb_simple_ads', '-1' );
            } else if (is_numeric($ads) && $ads != 0) {
                $simple_ads = get_user_meta($user_id, '_sb_simple_ads', true);
                $simple_ads = (int)$simple_ads;
                $new_ads = $ads + $simple_ads;
                update_user_meta($user_id, '_sb_simple_ads', $new_ads);

                /* ORDER META STORE FOR DASHBOARD PACKAGE GRAPH */
                //$total_simple_ads = get_user_meta( $user_id, '_total_simple_ads', true );
                //$total_simple_ads	=	 (int)$total_simple_ads;
                //$new_total_simple_ads = $ads+$total_simple_ads;
                //update_user_meta( $user_id, '_total_simple_ads', $new_total_simple_ads );
                //wc_update_order_item_meta( $order_id, '_sb_simple_ads', $ads );
            }
            if ($featured_ads == '-1') {
                update_user_meta($user_id, '_carspot_featured_ads', '-1');
                //wc_update_order_item_meta( $order_id, '_carspot_featured_ads', '-1' );	
            } else if (is_numeric($featured_ads) && $featured_ads != 0) {
                $f_ads = get_user_meta($user_id, '_carspot_featured_ads', true);
                $f_ads = (int)$f_ads;
                $new_f_fads = $featured_ads + $f_ads;
                update_user_meta($user_id, '_carspot_featured_ads', $new_f_fads);

                /* ORDER META STORE FOR DASHBOARD PACKAGE GRAPH */
                //$total_featured_ads = get_user_meta( $user_id, '_total_featured_ads', true );
                //$total_featured_ads	=	 (int)$total_featured_ads;
                //$new_total_featured_ads = $featured_ads+$total_featured_ads;
                //update_user_meta( $user_id, '_total_featured_ads', $new_total_featured_ads );
                //wc_update_order_item_meta( $order_id, '_carspot_featured_ads', $featured_ads );
            }

            if ($bump_ads == '-1') {
                update_user_meta($user_id, '_carspot_bump_ads', '-1');
                //wc_update_order_item_meta( $order_id, '_carspot_bump_ads', '-1' );	
            } else if (is_numeric($bump_ads) && $bump_ads != 0) {
                $b_ads = get_user_meta($user_id, '_carspot_bump_ads', true);
                $b_ads = (int)$b_ads;
                $new_b_fads = $bump_ads + $b_ads;
                update_user_meta($user_id, '_carspot_bump_ads', $new_b_fads);

                /* ORDER META STORE FOR DASHBOARD PACKAGE GRAPH */
                //$total_bump_ads = get_user_meta( $user_id, '_total_bump_ads', true );
                //$total_bump_ads	=	 (int)$total_bump_ads;
                //$new_total_bump_ads = $bump_ads+$total_bump_ads;
                //update_user_meta( $user_id, '_total_bump_ads', $new_total_bump_ads );
                //wc_update_order_item_meta( $order_id, '_carspot_bump_ads', $bump_ads );
            }
            if ($days == '-1') {
                update_user_meta($user_id, '_carspot_expire_ads', '-1');
                //update_user_meta( $user_id, '_total_expire_ads', '-1' );
                //wc_update_order_item_meta( $order_id, '_carspot_expire_ads', '-1' );
            } else {
                $expiry_date = get_user_meta($user_id, '_carspot_expire_ads', true);
                $e_date = strtotime($expiry_date);
                $today = strtotime(date('Y-m-d'));
                if ($today > $e_date) {
                    $new_expiry = date('Y-m-d', strtotime("+$days days"));
                } else {
                    $date = date_create($expiry_date);
                    date_add($date, date_interval_create_from_date_string("$days days"));
                    $new_expiry = date_format($date, "Y-m-d");
                }
                /* $total_expiry_date	=	get_user_meta( $user_id, '_total_expire_ads', true );
                  $total_expire_ads = date_create($total_expiry_date);
                  date_add($total_expire_ads, date_interval_create_from_date_string($days.' days'));
                  $new_total_expire_ads = date_format($total_expire_ads, 'Y-m-d'); */

                update_user_meta($user_id, '_carspot_expire_ads', $new_expiry);

                /* ORDER META STORE FOR DASHBOARD PACKAGE GRAPH */
                //update_user_meta( $user_id, '_total_expire_ads', $new_total_expire_ads  );
                //wc_update_order_item_meta( $order_id, '_carspot_expire_ads', $days );
            }
        }
    }

}


//Mark as Featured Listing
if (!function_exists('carspot_mark_listing_featured')) {

    function carspot_mark_listing_featured($ad_id = '')
    {
        ?>
        <div class="sticky-button-feature">
            <a class="btn-confirm" href="javascript:void(0)" data-btn-ok-label="<?php echo __('Yes', 'carspot'); ?>"
               data-btn-cancel-label="<?php echo __('No', 'carspot'); ?>" data-toggle="confirmation"
               data-singleton="true" data-title="<?php echo __('Are you sure?', 'carspot'); ?>"
               data-id="<?php echo esc_attr($ad_id); ?>"><?php echo esc_html__('Mark As Featured', 'carspot'); ?></a>
        </div>
        <?php
    }

}


if (!function_exists('carspot_woocomerce_count')) {

    function carspot_woocomerce_count()
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => get_option('posts_per_page'),
            'tax_query' => array(
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
            'orderby' => 'date',
            'order' => 'desc',
        );
        $results = new WP_Query($args);
        return count((array)$results);
    }

}

if (!function_exists('carspot_mapType')) {

    function carspot_mapType()
    {
        global $carspot_theme;
        $mapType = 'google_map';
        if (isset($carspot_theme['map-setings-map-type']) && $carspot_theme['map-setings-map-type'] != '') {
            $mapType = $carspot_theme['map-setings-map-type'];
        }
        return $mapType;
    }

}

// carspot Js Static Strings
if (!function_exists('carspot_static_strings')) {

    function carspot_static_strings()
    {
        $mapType = carspot_mapType();
        wp_localize_script(
            'carspot-custom', // name of js file
            'get_strings', array(
                'carspot_map_type' => $mapType,
            )
        );
    }

    add_action('wp_enqueue_scripts', 'carspot_static_strings', 100);
}


//sonu new code here 23th Nov 2018
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
    /* Shop Settings */
    add_action('pre_get_posts', 'dwt_listing_shop_filter_cat');

    function dwt_listing_shop_filter_cat($query = '')
    {
        if (!is_admin() && is_post_type_archive('product') && $query->is_main_query()) {
            $query->set('tax_query', array('relation' => 'AND', array('taxonomy' => 'product_type', 'relation' => 'AND', 'field' => 'slug', 'terms' => 'carspot_category_pricing', 'operator' => 'NOT IN'), array('taxonomy' => 'product_type', 'relation' => 'AND', 'field' => 'slug', 'terms' => 'carspot_packages_pricing', 'operator' => 'NOT IN')));
        }
    }

}

if (!function_exists('carspot_hide_package_quantity')) {

    function carspot_hide_package_quantity($return = '', $product = '')
    {
        if ($product->get_type() == 'carspot_category_pricing' || $product->get_type() == 'carspot_packages_pricing') {
            return true;
        } else {
            return false;
        }
    }

}
add_filter('woocommerce_is_sold_individually', 'carspot_hide_package_quantity', 10, 2);

//if (!function_exists('carspot_fetch_listing_gallery')) {
//
//    function carspot_fetch_listing_gallery($pid) {
//        global $dwt_listing_options;
//        $re_order = get_post_meta($pid, 'carspot_photo_arrangement_', true);
//        if ($re_order != "") {
//            return explode(',', $re_order);
//        } else {
//            global $wpdb;
//            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $pid . "'";
//            $results = $wpdb->get_results($query, OBJECT);
//            return $results;
//        }
//    }
//
//}
// Sort Listing Images
add_action('wp_ajax_carspot_sort_listing_images', 'carspot_sort_listing_images_updated');
if (!function_exists('carspot_sort_listing_images_updated')) {

    function carspot_sort_listing_images_updated()
    {
        check_ajax_referer('carspot_sort_images_secure', 'security');
        update_post_meta($_POST['ad_id'], 'carspot_photo_arrangement_', $_POST['ids']);
        die();
    }

}

// Ajax handler for test drive
add_action('wp_ajax_test_drive', 'carspot_test_drive');
add_action('wp_ajax_nopriv_test_drive', 'carspot_test_drive');
if (!function_exists('carspot_test_drive')) {

    function carspot_test_drive()
    {
        check_ajax_referer('carspot_register_secure', 'security');
        global $carspot_theme;
        $send_email_params = array();
        parse_str($_POST['test_drive_data'], $test_drive_params);

        if (isset($carspot_theme['google_api_secret']) && isset($carspot_theme['google_api_key']) && $carspot_theme['google_api_secret'] != '' && $carspot_theme['google_api_key'] != '') {
            if (carspot_recaptcha_verify($carspot_theme['google_api_secret'], $test_drive_params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $test_drive_params['test_drive_captcha'])) {
                $name = $test_drive_params['name'];
                $email = $test_drive_params['email'];
                $contact = $test_drive_params['phone'];
                $date_time = $test_drive_params['date_time'];
                $message = $test_drive_params['message'];
                $post_id = $test_drive_params['ad_post_id'];
                carspot_send_email_test_drives($name, $email, $contact, $date_time, $message, $post_id);
            } else {
                echo '0|' . __("please verify captcha code.", 'carspot');
                die();
            }
        } else {
            $name = $test_drive_params['name'];
            $email = $test_drive_params['email'];
            $contact = $test_drive_params['phone'];
            $date_time = $test_drive_params['date_time'];
            $message = $test_drive_params['message'];
            $post_id = $test_drive_params['ad_post_id'];
            carspot_send_email_test_drives($name, $email, $contact, $date_time, $message, $post_id);
        }
    }

}

// Ajax handler for make offer
add_action('wp_ajax_make_offer', 'carspot_make_offer');
add_action('wp_ajax_nopriv_make_offer', 'carspot_make_offer');
if (!function_exists('carspot_make_offer')) {

    function carspot_make_offer()
    {
        global $carspot_theme;
        check_ajax_referer('carspot_register_secure', 'security');
        $send_email_params = array();
        parse_str($_POST['make_offer_data'], $make_offer_params);

        if (isset($carspot_theme['google_api_secret']) && isset($carspot_theme['google_api_key']) && $carspot_theme['google_api_secret'] != '' && $carspot_theme['google_api_key'] != '') {
            if (carspot_recaptcha_verify($carspot_theme['google_api_secret'], $make_offer_params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $make_offer_params['make_offer_captcha'])) {
                $name = $make_offer_params['name'];
                $email = $make_offer_params['email'];
                $contact = $make_offer_params['phone'];
                $price = $make_offer_params['price'];
                $message = $make_offer_params['message'];
                $post_id = $make_offer_params['ad_post_id'];
                carspot_send_email_make_offer($name, $email, $contact, $price, $message, $post_id);
            } else {
                echo '0|' . __("please verify captcha code.", 'carspot');
                die();
            }
        } else {
            $name = $make_offer_params['name'];
            $email = $make_offer_params['email'];
            $contact = $make_offer_params['phone'];
            $price = $make_offer_params['price'];
            $message = $make_offer_params['message'];
            $post_id = $make_offer_params['ad_post_id'];
            carspot_send_email_make_offer($name, $email, $contact, $price, $message, $post_id);
        }
    }

}
// Ajax handler for DEALER CONTACT FORM
add_action('wp_ajax_dealer_contact', 'carspot_dealer_contact');
add_action('wp_ajax_nopriv_dealer_contact', 'carspot_dealer_contact');
if (!function_exists('carspot_dealer_contact')) {

    function carspot_dealer_contact()
    {
        check_ajax_referer('carspot_user_contact_secure', 'security');
        global $carspot_theme;
        $send_email_params = array();
        parse_str($_POST['dealer_contact_data'], $dealer_contact_params);

        if (isset($carspot_theme['google_api_secret']) && isset($carspot_theme['google_api_key']) && $carspot_theme['google_api_secret'] != '' && $carspot_theme['google_api_key'] != '') {
            if (carspot_recaptcha_verify($carspot_theme['google_api_secret'], $dealer_contact_params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $dealer_contact_params['dealer_contact_captcha'])) {
                $name = $dealer_contact_params['name'];
                $email = $dealer_contact_params['email'];
                $contact = $dealer_contact_params['phone'];
                $message = $dealer_contact_params['message'];
                $dealer_id = $dealer_contact_params['ad_dealer_id'];
                carspot_send_email_dealer_contact($name, $email, $contact, $message, $dealer_id);
            } else {
                echo '0|' . __("please verify captcha code.", 'carspot');
                die();
            }
        } else {
            $name = $dealer_contact_params['name'];
            $email = $dealer_contact_params['email'];
            $contact = $dealer_contact_params['phone'];
            $message = $dealer_contact_params['message'];
            $dealer_id = $dealer_contact_params['ad_dealer_id'];
            carspot_send_email_dealer_contact($name, $email, $contact, $message, $dealer_id);
        }
    }

}

// Ajax handler for SAVE OLD USER TYPE
add_action('wp_ajax_save_user_type_old_users', 'carspot_save_user_type_old_users');
add_action('wp_ajax_nopriv_save_user_type_old_users', 'carspot_save_user_type_old_users');
if (!function_exists('carspot_save_user_type_old_users')) {

    function carspot_save_user_type_old_users()
    {
        check_ajax_referer('carspot_user_type_secure', 'security');
        global $carspot_theme;
        parse_str($_POST['dealer_contact_data'], $user_type_params);

        $user_type = $user_type_params['sb_user_type'];
        $uid = get_current_user_id();

        update_user_meta($uid, '_sb_user_type', $user_type);

        echo '1|' . __("User type updated.", 'carspot');
        die();
    }

}

function new_modify_user_table($column = '')
{
    $column['ad_posts'] = __("Ads Posted", 'carspot');
    $column['package'] = __("Package", 'carspot');
    return $column;
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val = '', $column_name = '', $user_id = '')
{
    if ($column_name == 'ad_posts') {
        return carspot_get_all_ads($user_id);
    }
    if ($column_name == 'package') {
        $package = get_user_meta($user_id, '_carspot_pkg_type', true);
        return $package;
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);


/* RADIUS SEARCH ON SEARCH PAGE */

if (!function_exists('carspot_radius_search')) {

    function carspot_radius_search($data_arr = array(), $check_db = true, $radius_unit = '')
    {
        $data = array();
        $user_id = get_current_user_id();
        $success = false;

        if (isset($data_arr) && !empty($data_arr)) {
            $nearby_data = $data_arr;
        }

        if (isset($nearby_data) && $nearby_data != "") {

            //array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance );
            $original_lat = $nearby_data['latitude'];
            $original_long = $nearby_data['longitude'];
            $distance = $nearby_data['distance'];

            $lat = $original_lat; // original latitude
            $lon = $original_long; // original longitude
            $distance = $distance; // original your distance in KM
            /* if radius unit is miles then */
            if ($radius_unit === "Miles") {
                $distance = $distance / 1.609344; //your distance in Miles
            }

            $R = 6371.009; //constant earth radius. You can add precision here if you wish

            $maxLat = $lat + rad2deg($distance / $R);
            $minLat = $lat - rad2deg($distance / $R);
            $maxLon = $lon + rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));
            $minLon = $lon - rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));

            $data['radius'] = $R;
            $data['distance'] = $distance;
            $data['lat']['original'] = $original_lat; //$original_long;
            $data['long']['original'] = $original_long; //$original_lat;

            $data['long']['min'] = $minLon; //$minLat;
            $data['long']['max'] = $maxLon; //$maxLat;

            $data['lat']['min'] = $minLat; //$minLon;
            $data['lat']['max'] = $maxLat; //$maxLon ;
        }

        return $data;
    }

}


/* Setting up employer and canidate links starts */
add_action('init', 'carspot_wpse17106_init');

function carspot_wpse17106_init()
{
    global $wp_rewrite;
    $author_levels = array('dealer', 'individual', 'author');
    add_rewrite_tag('%author_level%', '(' . implode('|', $author_levels) . ')');
    $wp_rewrite->author_base = '%author_level%';
}

add_filter('author_rewrite_rules', 'carspot_wpse17106_author_rewrite_rules');

function carspot_wpse17106_author_rewrite_rules($author_rewrite_rules = '')
{
    foreach ($author_rewrite_rules as $pattern => $substitution) {
        if (FALSE === strpos($substitution, 'author_name')) {
            unset($author_rewrite_rules[$pattern]);
        }
    }
    return $author_rewrite_rules;
}

add_filter('author_link', 'carspot_wpse17106_author_link', 11, 3);

function carspot_wpse17106_author_link($link = '', $author_id = '')
{

    $author_levels = '';
    $user_type = get_user_meta($author_id, '_sb_user_type', true);
    $user_type = ($user_type != "") ? $user_type : '';
    if ($user_type == "dealer") {
        $author_levels = 'dealer';
    } else if ($user_type == "individual") {
        $author_levels = 'individual';
    } else if ($user_type == "") {
        $author_levels = 'individual';
    }

    if ($author_levels != "") {
        $link = str_replace('%author_level%', $author_levels, $link);
    }
    return $link;
}

/* Setting up employer and canidate links ends */
//then add users to query_vars:

add_filter('query_vars', 'users_query_vars');

function users_query_vars($vars = '')
{
    // add lid to the valid list of variables
    $new_vars = array('users');
    $vars = $new_vars + $vars;
    return $vars;
}

/* remove payload */

function strip_tags_content($text = '', $tags = '', $invert = FALSE)
{

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);
    $output = '';
    if (is_array($tags) and count($tags) > 0) {
        if ($invert == FALSE) {
            $output = preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            $output = preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif ($invert == FALSE) {
        $output = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    if (strpos($output, ">") != '') {
        return '';
    } else {
        return esc_html($output);
    }
}
