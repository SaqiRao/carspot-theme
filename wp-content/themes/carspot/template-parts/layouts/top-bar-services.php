<?php global $carspot_theme;
$msg_count = 0;
if (!$carspot_theme['sb_top_bar']) {
    return;
}

$class = '';
if (isset($carspot_theme['top_bar_color']) && $carspot_theme['top_bar_color']) {
    $class = $carspot_theme['top_bar_color'];
}
?>
<?php
$menu_flip = '';
if (is_rtl()) {
    $menu_flip = 'flip';
}
?>
<div id="header-info-bar" class="<?php echo esc_attr($class); ?>">
    <div class="container">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <ul class="header-social pull-left <?php echo esc_attr($menu_flip); ?>">
                <?php
                if (isset($carspot_theme['social_media']) && $carspot_theme['social_media'] != "") {
                    foreach ($carspot_theme['social_media'] as $index => $val) {
                        ?>
                        <?php
                        if ($val != "") {
                            ?>
                            <li>
                                <a class="<?php echo esc_attr($index); ?>" href="<?php echo esc_url($val); ?>">
                                    <i class="<?php echo carspot_social_icons($index); ?>"></i>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <?php
            if (isset($carspot_theme['top_bar_pages']) && $carspot_theme['top_bar_pages'] != "" && count($carspot_theme['top_bar_pages']) > 0) {
                foreach ($carspot_theme['top_bar_pages'] as $foot_page) {
                    echo '<a href="' . esc_url(get_the_permalink($foot_page)) . '" class="info-bar-meta-link"><i class="fa fa-caret-right fa-fw"></i>' . esc_html(get_the_title($foot_page)) . '</a>';
                }
            }
            ?>

            <?php
            if (isset($carspot_theme['show_cart_top']) && ( $carspot_theme['show_cart_top'] == '1') && class_exists('WooCommerce')) {
                ?> 
                <a class="info-bar-meta-link shopping_bag_btn" href="<?php echo esc_url(get_permalink(WC_Admin_Settings::get_option('woocommerce_cart_page_id'))); ?>"><i class="fa fa-shopping-cart"></i><span><?php echo WC()->cart->get_cart_contents_count(); ?></span></a>
                        <?php
                    }
                    ?>
        </div>
    </div>
</div>