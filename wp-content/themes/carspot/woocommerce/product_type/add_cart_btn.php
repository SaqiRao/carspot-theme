<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
if (!defined('ABSPATH')) {
    exit;
}
global $product;
do_action('woocommerce_before_add_to_cart_button');
if ($product->get_type() == 'external') {
    $link = get_post_meta(get_the_ID(), '_product_url', true);
    $btn_text = get_post_meta(get_the_ID(), '_button_text', true);
    ?>
    <div class="point-of-action">
        <div class="add-to-cart">
            <a class="btn btn-theme" href="<?php echo esc_url($link); ?>">
                <i class="fa fa-shopping-cart"></i>
                <?php echo esc_html($btn_text); ?>
            </a> 
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="point-of-action">
        <span class="quantity">
            <label><?php echo esc_html__('Quantity', 'carspot'); ?>:</label>
            <input placeholder="1" id="product_qty" value="1" min="1" max="1000" type="number">
        </span>
        <span class="add-to-cart">
            <a class="btn btn-theme" href="javascript:void(0);" id="sb_add_to_cart">
                <i class="fa fa-shopping-cart"></i> <span id="cart_msg"><?php echo esc_html__('add to cart', 'carspot'); ?></span>
            </a> 
        </span>
    <?php
    $pid = 0;
    if ($product->get_type() == 'grouped') {
        $args = array(
            'post_parent' => get_the_ID(),
            'post_type' => 'product',
        );
        $children = get_children($args);
        foreach ($children as $child) {
            $pid = $child->ID;
            break;
        }
    } else {
        $pid = $product->get_id();
    }
    if ($pid != 0) {
        ?>
            <input type="hidden" name="add-to-cart" id="add-to-cart" value="<?php echo absint($pid); ?>" />
            <input type="hidden" name="product_id" id="product_id" value="<?php echo absint($pid); ?>" />
            <input type="hidden" name="variation_id" id="variation_id" value="0" />
            <?php
        }
        ?>
    </div>
        <?php
    }
    do_action('woocommerce_after_add_to_cart_button');
    ?>