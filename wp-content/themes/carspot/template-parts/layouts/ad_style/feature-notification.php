<?php
$pid = get_the_ID();
$uid = get_current_user_id();
global $carspot_theme;
$poster_id = get_post_field('post_author', $pid);
if (get_post_status($pid) == 'pending') {
    ?>
    <div role="alert" class="alert alert-info alert-outline alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
        <?php echo esc_html__('Waiting for admin approval.', 'carspot'); ?>
    </div>
    <?php
    return;
}
if (class_exists('WooCommerce')) {
    if (get_post_meta($pid, '_carspot_ad_order_id', true) != "" && $poster_id == $uid) {
        $order_id = get_post_meta($pid, '_carspot_ad_order_id', true);
        if (get_post_status($order_id) == 'wc-processing') {
            ?>
            <div role="alert" class="alert alert-outline alert-info alert-dismissible">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
            <?php echo esc_html__('Your order has been processed & waiting for admin approval.', 'carspot'); ?>
            </div>
                <?php
            }
        }
    }