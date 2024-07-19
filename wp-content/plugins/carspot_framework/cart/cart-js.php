<?php
function sb_add_to_cart_func() {
    ?>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('.sb_variation').on('change', function ()
            {
                var get_var = '';
                $(".sb_variation").each(function () {
                    var val = $(this).val();

                    get_var = get_var + val.replace(/\s+/g, '') + '_';
                });
                if ($('#' + get_var).length > 0)
                {
                    var res = $('#' + get_var).val();
                    var arr = res.split("-");
                    var sale_price = arr[0];
                    var old_price = arr[1];
                    var vid = arr[2];
                    if (sale_price == "0")
                    {
                        $('#v_msg').html('<?php echo carspot_translate('variation_not_available'); ?>');
                        $('#sale_price').html('');
                        $('#old_price').html('');
                        $('#sb_add_to_cart').hide();
                        $('.quantity').hide();
                        $('#product_qty').hide();
                    } else
                    {
                        $('#sale_price').html('<?php echo (get_woocommerce_currency_symbol()); ?>' + sale_price);
                        $('#old_price').html('<?php echo (get_woocommerce_currency_symbol()); ?>' + old_price);
                        $('#v_msg').html('');
                        $('#sb_add_to_cart').show();
                        $('.quantity').show();
                        $('#product_qty').show();
                    }
                    $('#variation_id').val(vid);
                }
            });
            $(".sb_variation").trigger("change");

            $('#sb_add_to_cart').on('click', function ()
            {
                if ($('#cart_msg').html() != 'Adding...')
                {
                    $('#cart_msg').html("<?php echo carspot_translate('adding_to_cart'); ?>");
                    //Getting values
                    var variation_id = $('#variation_id').val();
                    var pid = $('#product_id').val();
                    var qty = $('#product_qty').val();
                    $.post('<?php echo admin_url('admin-ajax.php'); ?>',
                            {action: 'sb_cart', product_id: pid, qty: qty, variation_id: variation_id}).done(function (response)
                    {

                        $('#cart_msg').html("<?php echo carspot_translate('add_to_cart'); ?>");

                        if (response != 0)
                        {
                            var cart_url = '';
    <?php
    if (class_exists('WooCommerce')) {
        ?>
                                var cart_url = '<br /><a href="<?php echo esc_url(get_permalink(WC_Admin_Settings::get_option('woocommerce_cart_page_id'))); ?>"><?php echo carspot_translate('view_cart'); ?></a>';
        <?php
    }
    ?>
                            toastr.success('<?php echo carspot_translate('cart_success_msg'); ?>' + cart_url, '<?php echo carspot_translate('cart_success'); ?>!', {timeOut: 10000, "closeButton": true, "positionClass": "toast-bottom-right"})
                        } else
                        {
                            toastr.error('<?php echo carspot_translate('cart_error_msg'); ?>', '<?php echo carspot_translate('cart_error'); ?>!', {timeOut: 15000, "closeButton": true, "positionClass": "toast-bottom-right"})
                        }
                    });
                }

            });

        })(jQuery);
    </script>
    <?php
}

add_action('wp_footer', 'sb_add_to_cart_func');
// Ajax handler for add to cart
add_action('wp_ajax_sb_cart', 'sb_chimppro_add_to_cart');
add_action('wp_ajax_nopriv_sb_cart', 'sb_chimppro_add_to_cart');

function sb_chimppro_add_to_cart() {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    $variation_id = $_POST['variation_id'];
    global $woocommerce;
    if ($variation_id != 0) {
        echo ($woocommerce->cart->add_to_cart($product_id, $qty, $variation_id));
    } else {
        echo ($woocommerce->cart->add_to_cart($product_id, $qty));
    }
    die();
}

function carspot_category_pricing_custom_js() {

    if ('product' != get_post_type()) :
        return;
    endif;
    ?><script type='text/javascript'>
        jQuery(document).ready(function () {

            jQuery('#sb_thmemes_carspot_metaboxes_adons').hide();
            jQuery('.options_group.pricing').addClass('show_if_carspot_category_pricing').show();
            jQuery('.options_group.pricing').addClass('show_if_carspot_category_pricing').show();

            jQuery('#product-type').on('change', function ()
            {
                if (jQuery(this).val() == 'carspot_category_pricing')
                {
                    jQuery('#sb_thmemes_carspot_metaboxes_adons').show();
                    jQuery('.sale_schedule').hide();
                    jQuery('#product_catdiv').hide();
                    jQuery('#tagsdiv-product_tag').hide();

                } else
                {
                    jQuery('#sb_thmemes_carspot_metaboxes_adons').hide();
                    jQuery('._regular_price_field').show();
                    jQuery('.sale_schedule').show();
                    jQuery('#product_catdiv').show();
                    jQuery('#tagsdiv-product_tag').show();
                }
            });
            jQuery('#product-type').trigger('change');

        });
    </script><?php
}

add_action('admin_footer', 'carspot_category_pricing_custom_js');

// adding product type
function register_carspot_category_pricing_product_type() {
    if (class_exists('WooCommerce')) {

        class WC_Product_carspot_category_pricing extends WC_Product {

            public function __construct($product) {
                $this->product_type = 'carspot_category_pricing';
                parent::__construct($product);
            }

        }

    }
}

add_action('init', 'register_carspot_category_pricing_product_type', 0);

function add_simple_rental_product($types) {
    // Key should be exactly the same as in the class product_type parameter
    $types['carspot_category_pricing'] = __('Carspot based pricing');
    return $types;
}

add_filter('product_type_selector', 'add_simple_rental_product', 0);

function carspot_category_pricing_hide_attributes_data_panel($tabs) {
    // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
    $tabs['attribute']['class'][] = 'hide_if_carspot_category_pricing';
    $tabs['shipping']['class'][] = 'hide_if_carspot_category_pricing';
    $tabs['linked_product']['class'][] = 'hide_if_carspot_category_pricing';
    $tabs['advanced']['class'][] = 'hide_if_carspot_category_pricing';
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'carspot_category_pricing_hide_attributes_data_panel');
