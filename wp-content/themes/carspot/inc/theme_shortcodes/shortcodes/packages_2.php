<?php
/* ------------------------------------------------ */
/* Blog */
/* ------------------------------------------------ */
if (!function_exists('carspot_packages_2_short')) {

    function carspot_packages_2_short()
    {
        vc_map(array(
            "name" => esc_html__("Packages Style 2", 'carspot'),
            "base" => "carspot_packages_2_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('packages.png') . esc_html__('Output of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'carspot'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'carspot') => '',
                        esc_html__('White', 'carspot') => '',
                        esc_html__('Gray', 'carspot') => 'gray',
                        esc_html__('Image', 'carspot') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'carspot'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Section Top Padding", 'carspot'),
                    "param_name" => "section_padding",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Section Padding', 'carspot') => '',
                        esc_html__('No', 'carspot') => '',
                        esc_html__('Yes', 'carspot') => 'yes',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Remove Padding From Section Top.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Header Style", 'carspot'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Section Header Style', 'carspot') => '',
                        esc_html__('No Header', 'carspot') => '',
                        esc_html__('Classic', 'carspot') => 'classic',
                        esc_html__('Regular', 'carspot') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Chose header style.", 'carspot'),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title",
                    "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'carspot'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "'carspot"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'carspot'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array
                (
                    'group' => __('Packages', 'carspot'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'carspot'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select package", 'carspot'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => carspot_get_packages(),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'carspot_packages_2_short');

if (!function_exists('carspot_packages_2_base_func')) {

    function carspot_packages_2_base_func($atts, $content = '')
    {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        global $carspot_theme;
        $p_b_style = '';
        $pricing_bg_url = '';
        $pricing_bg_url = trailingslashit(get_template_directory_uri()) . "images/price-2-bg.png";

        $p_b_style = ($pricing_bg_url != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $pricing_bg_url . ') "' : "";
        $parallex = $html = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $rows = vc_param_group_parse_atts($woo_products);
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['product'])) {
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
										<h2>' . $product->get_title() . '</h2>
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
        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent2' || $carspot_theme['sb_header'] == 'transparent') {
            $top_padding = '';
        }

        return '<section class="pricing-table ' . $parallex . ' ' . $top_padding . ' ' . $bg_color . '" ' . $style . '>
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

if (function_exists('carspot_add_code')) {
    carspot_add_code('carspot_packages_2_base', 'carspot_packages_2_base_func');
}