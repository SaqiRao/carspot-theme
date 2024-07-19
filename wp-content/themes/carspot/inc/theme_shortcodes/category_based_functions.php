<?php
// Get cart total
add_action('wp_ajax_sb_get_car_total', 'carspot_get_cart_total');
add_action('wp_ajax_nopriv_sb_get_car_total', 'carspot_get_cart_total');

function carspot_get_cart_total() {
    global $woocommerce;
    echo ($woocommerce->cart->get_cart_total());
    die();
}

if (!function_exists('carspot_getPostAd_adons')) {

    function carspot_getPostAd_adons($show_on = 'both') {
        global $carspot_theme;
        $extraFeatures = '';
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'carspot_package_type',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing'
                ),
            ),
            'meta_query' =>
            array(
                'key' => 'carspot_package_type',
                'value' => 'adons_based',
                'compare' => '=',
            ),
            'posts_per_page' => -1,
        );
        $is_edit = ( isset($_GET['id']) && $_GET['id'] != "" ) ? 1 : 0;
        $loop = new WP_Query($args);
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                global $product;

                $id = get_post_meta(get_the_ID(), "carspot_package_ad_type", true);

                if ($id == 'bump' && $is_edit == 0)
                    continue;

                $extraFeatures .= '<div class="pricing-list"><div class="row">
		   <div class="col-md-9 col-sm-9 col-xs-12">
			  <h3>' . get_the_title() . '</h3>
			  <p>' . get_the_content() . '</p>
		   </div>
		   <div class="col-md-3 col-sm-3 col-xs-12">
			  <div class="pricing-list-price text-center">
				 <h4>' . wc_price($product->get_price()) . '</h4>
				 <div id="btn-div-' . get_the_ID() . '">
				 ' . carspot_adon_cart_button_text(get_the_ID()) . '
				 <input type="hidden" id="pay_per_post_nonce" value="' . wp_create_nonce('carspot_pay_per_post_secure') . '"  />
				 </div>
			  </div>
		   </div>
		</div></div>';
            }
            wp_reset_query();


            return '<div class="select-package">
					<div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
					 <h3 class="margin-bottom-20">' . esc_html__("Adons", "carspot") . '</h3>
						' . $extraFeatures . '
				  </div>
				</div>';
        } else {
            return '';
        }
    }

}
add_action('wp_ajax_carspot_add_ad_adons', 'carspot_add_ad_to_cart');

if (!function_exists('carspot_add_ad_to_cart')) {

    function carspot_add_ad_to_cart($adon_id = '', $html = 'yes', $die = 'yes') {
        //check_ajax_referer('carspot_pay_per_post_secure', 'security');
        global $carspot_theme;
        global $woocommerce;
        if ($html == 'yes') {
            $adon_id = (isset($_POST['adon_id']) && $_POST['adon_id'] != "" ) ? $_POST['adon_id'] : "";
        }
        if ($html == 'no') {
            
        }
        $found = false;
        if ($adon_id == "")
            return '';
        $product_id = $adon_id;
        $popup_text1 = esc_html__("Added to cart successfully.", "carspot");
        $button_text1 = esc_html__('Remove', 'carspot');
        $popup_text2 = esc_html__("Removed from cart.", "carspot");
        $button_text2 = esc_html__('Add to cart', 'carspot');
        $popup_text3 = esc_html__("Nothing in cart.", "carspot");

        //check if product already in cart
        if (sizeof(WC()->cart->get_cart()) > 0) {

            $found = false;
            foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                $_product = $values['data'];
                if ($_product->id == $product_id) {
                    $found = true;
                }
            }
            if (!$found) {

                WC()->cart->add_to_cart($product_id);
                if ($html == 'yes') {
                    echo '1|' . $product_id . '|' . $popup_text1 . '|' . $button_text1 . '|' . $woocommerce->cart->get_cart_total();
                }
            } else {
                $cart = WC()->instance()->cart;
                $id = $product_id;
                $cart_id = $cart->generate_cart_id($id);
                $cart_item_id = $cart->find_product_in_cart($cart_id);
                if ($cart_item_id) {
                    WC()->cart->remove_cart_item($cart_id);
                    if ($html == 'yes') {
                        echo '0|' . $product_id . '|' . $popup_text2 . '|' . $button_text2 . '|' . $woocommerce->cart->get_cart_total();
                    }
                $cart->set_quantity($cart_item_id, 0);
            } else {
                if ($html == 'yes') {
                    echo '1|' . $product_id . '|' . $popup_text3 . '|' . $button_text2 . '|' . $woocommerce->cart->get_cart_total();
                }
                }
            }
        } else {
            // if no products in cart, add it
            WC()->cart->add_to_cart($product_id);
            if ($html == 'yes') {
                echo '1|' . $product_id . '|' . $popup_text1 . '|' . $button_text1 . '|' . $woocommerce->cart->get_cart_total();
            }
        }
        /* die(); */
    }

}
/* Cart Button */
if (!function_exists('carspot_adon_cart_button_text')) {

    function carspot_adon_cart_button_text($pid) {
        $WC_CartData = new WC_Cart();
        if ($WC_CartData->cart_contents) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                $_product = $values['data'];
                if ($pid == $_product->id) {
                    return '<a href="javascript:void(0)" class="btn btn-theme btn-sm btn-block" data-adon-id="' . $pid . '" data-adon-type="remove">' . esc_html__('Remove', 'carspot') . '</a>';
                }
            }
        }
        return '<a href="javascript:void(0)" class="btn btn-theme btn-sm btn-block" data-adon-id="' . $pid . '">' . esc_html__('Add To Cart', 'carspot') . '</a>';
    }

}

/* Remove Product From Cart */
if (!function_exists('carspot_removeProductsFrom_cart')) {

    function carspot_removeProductsFrom_cart($id = '', $cat_id = '') {
        global $woocommerce;

        $extraFeatures = '';
        $pkgCats = carspot_category_package($cat_id);
        $child = get_term_by('id', $cat_id, 'ad_cats');

        if ($child->parent > 0) {
            return;
        } else {
            carspot_unset_product_cart();
        }

        $cat_id = $child->term_id;
        if (count($pkgCats) > 0) {
            $mainCatId = $product_id = $productID = '';

            foreach ($pkgCats as $pkgCat) {
                $pkg_cats = $pkgCat['cats'];
                if (in_array($cat_id, $pkg_cats)) {
                    foreach ($pkg_cats as $pkg_cat_id) {
                        if ($pkg_cat_id == $cat_id) {
                            $mainCatId = $pkg_cat_id;
                            $product_id = ($pkgCat['id']);
                        }
                    }
                } else {
                    carspot_unset_product_cart();
                }
            }

            $term_list = array();
            if ($product_id != "") {

                /* IF AD IS UPDATING */
                $term_list = ($id != "") ? wp_get_post_terms($id, 'ad_cats', array("fields" => "ids")) : array();
                if (in_array($mainCatId, $term_list)) {
                    carspot_unset_product_cart();
                } else {
                    carspot_add_ad_to_cart($product_id, 'no', 'no');

                    $product_id_arr = carspot_product_ids();
                    //$product_id_arr = array_diff($product_id_arr, $product_id);
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $cart_item_id = $cart_item['data']->id;
                        if (in_array($cart_item_id, $product_id_arr)) {
                            WC()->cart->remove_cart_item($cart_item_key);
                        }
                    }
                }
            }
        }
    }

}


/* Unset Product Cart */
if (!function_exists('carspot_unset_product_cart')) {

    function carspot_unset_product_cart() {
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'carspot_package_type',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing'
                ),
            ),
            'meta_query' => array(
                'key' => 'carspot_package_type',
                'value' => 'category_based',
                'compare' => '=',),
        );
        $los = get_posts($args);
        $cart = WC()->instance()->cart;
        foreach ($los as $lo) {
            $id = $lo->ID;
            $cart_id = $cart->generate_cart_id($id);
            $cart_item_id = $cart->find_product_in_cart($cart_id);
            $cart->set_quantity($cart_item_id, 0);
        }
        return '';
    }

}

/* category package */
if (!function_exists('carspot_product_ids')) {

    function carspot_product_ids($meta_val = 'category_based') {
        $arr = array();
        $extraFeatures = '';
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'carspot_package_type',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing'
                ),
            ),
            'meta_query' =>
            array(
                'key' => 'carspot_package_type',
                'value' => $meta_val,
                'compare' => '=',
            ),
            'posts_per_page' => -1,
        );
        $los = get_posts($args);
        if (count($los) > 0) {
            foreach ($los as $lo) {
                $arr[]['id'] = $lo->ID;
            }
        }
        return $arr;
    }

}

/* category package */
if (!function_exists('carspot_category_package')) {

    function carspot_category_package($cat_id = '') {
        $arr = array();
        $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);

        if ($simple_ads == '-1' && $simple_ads > 0)
            return $arr;

        $extraFeatures = '';
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'carspot_package_type',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'carspot_category_pricing'
                ),
            ),
            'meta_query' =>
            array(
                'key' => 'carspot_package_type',
                'value' => 'category_based',
                'compare' => '=',
            ),
            'posts_per_page' => -1,
        );

        $los = get_posts($args);
        $i = 0;
        $cart = WC()->instance()->cart;
        if (count($los) > 0) {
            foreach ($los as $lo) {
                $arr[$i]['id'] = $lo->ID;
                $arr[$i]['title'] = $lo->post_title;
                $arr[$i]['cats'] = get_post_meta($lo->ID, 'carspot_package_cats', true);
                $i++;
            }
        }

        return $arr;
    }

}