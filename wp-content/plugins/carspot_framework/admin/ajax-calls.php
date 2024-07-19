<?php
/* ========== */
/* Get States */
/* ========== */
add_action('wp_ajax_sb_get_sub_states', 'carspot_get_sub_states');
add_action('wp_ajax_nopriv_sb_get_sub_states', 'carspot_get_sub_states');
if (!function_exists('carspot_get_sub_states')) {

    function carspot_get_sub_states()
    {
        $cat_id = !empty($_POST['cat_id']) ? $_POST['cat_id'] : '';
        if ($cat_id != '') {
            $ad_cats = carspot_get_cats('ad_country', $cat_id);
            if (count((array)$ad_cats) > 0) {
                $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">';
                $cats_html .= '<option label="' . esc_html__('Select Option', 'redux-framework') . '"></option>';
                foreach ($ad_cats as $ad_cat) {
                    $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
                }
                $cats_html .= '</select>';
                echo($cats_html);
                die();
            }
        } else {
            echo "";
            die();
        }
    }
}
/* ================================================= */
/* Chooose Maker, Model, Version, etc in admin side  */
/*  Get sub cats */
/* ================================================= */
add_action('wp_ajax_sb_get_sub_cat', 'carspot_get_sub_cats');
if (!function_exists('carspot_get_sub_cats')) {

    function carspot_get_sub_cats()
    {
        $cat_id = $_POST['cat_id'];
        if ($cat_id != '') {
            $ad_cats = carspot_get_cats('ad_cats', $cat_id);
            if (count((array)$ad_cats) > 0) {
                $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">';
                $cats_html .= '<option label="' . esc_html__('Select Option', 'redux-framework') . '"></option>';
                foreach ($ad_cats as $ad_cat) {
                    $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
                }
                $cats_html .= '</select>';
                echo($cats_html);
                die();
            }
        } else {
            return "";
            die();
        }
    }

}
/* ============================ */
/* ajax calls for bump the adds */
/* ============================ */
add_action('wp_ajax_carspot_make_ad_bumb', 'carspot_make_ad_bumb_admin');

function carspot_make_ad_bumb_admin()
{
    $id = ($_POST['post_id'] != "") ? $_POST['post_id'] : '';
    $time = current_time('mysql');
    $updated = wp_update_post(array('ID' => $id, 'post_date' => $time, 'post_date_gmt' => get_gmt_from_date($time)));
    if ($updated) {
        echo '1';
    } else {
        echo '0';
    }
    die();
}

/* Get image ID from URL in admin side gallery */
function shift8_portfolio_get_image_id($image_url)
{
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
    return $attachment[0];
}

/* Dynamic Fields starts */
add_action('wp_ajax_sb_get_sub_template_admin', 'sb_get_sub_template_admin');

function sb_get_sub_template_admin()
{
    global $carspot_theme;
    $html = '';
    $id = isset($_POST['is_update']) ? $_POST['is_update'] : '';
    $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';

    $termTemplate = carspot_dynamic_templateID($cat_id);
    $termTemplate = ($termTemplate == 0) ? '' : $termTemplate;

    //only for category based pricing
    if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based') {
        carspot_removeProductsFrom_cart($id, $cat_id);
    } else {
        //make cart empty
        if (class_exists('WooCommerce')) {
            global $woocommerce;
            $woocommerce->cart->empty_cart();
        }
    }
    $html .= carspot_get_term_form($termTemplate, $id);
    $html .= carspot_get_dynamic_form($termTemplate, $id);
    echo($html);
    die();
}