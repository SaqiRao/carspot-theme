<?php global $carspot_theme;
$pid = get_the_ID();
$post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
$type = '';
$link = '';
$type = $carspot_theme['cat_and_location'];
?>
<div class="pricing-area">
    <div class="col-md-8 col-xs-12 col-sm-8">
        <div class="heading-zone">
            <h1><?php the_title(); ?></h1>
            <div class="short-history">
                <ul>
                    <li><b><?php echo esc_html(get_the_date()); ?></b></li>
                    <li><?php echo esc_html__('Views', 'carspot'); ?>: <b><?php echo carspot_getPostViews($pid); ?></b>
                    </li>

                    <li>
                        <?php
                        if (isset($_COOKIE["cookie_1"]) && $_COOKIE["cookie_1"] == $pid || isset($_COOKIE["cookie_2"]) && $_COOKIE["cookie_2"] == $pid) {
                            ?>
                            <a href="javaScript:void(0)" class="remove_compare"
                               data-post_id="<?php echo esc_attr($pid); ?>"> <?php echo esc_html__('Remove from Compare', 'carspot'); ?></a>
                            <a href="javaScript:void(0)" style="display:none" class="add_compare"
                               data-post_id="<?php echo esc_attr($pid); ?>"> <?php echo esc_html__('Add to Compare', 'carspot'); ?></a>
                            <?php
                        } else {
                            ?>
                            <a href="javaScript:void(0)" style="display:none" class="remove_compare"
                               data-post_id="<?php echo esc_attr($pid); ?>"> <?php echo esc_html__('Remove from Compare', 'carspot'); ?></a>
                            <a href="javaScript:void(0)" class="add_compare"
                               data-post_id="<?php echo esc_attr($pid); ?>"> <?php echo esc_html__('Add to Compare', 'carspot'); ?></a>
                            <?php

                        }
                        ?>
                    </li>


                    <?php
                    $my_url = carspot_get_current_url();
                    if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
                        if (is_super_admin(get_current_user_id())) {
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_post_ad_page'])); ?>?id=<?php echo esc_attr($pid); ?>"><?php echo esc_html__('Edit', 'carspot'); ?></a>
                            </li>
                            <li>
                                <div class="photo-rearrange">
                                    <i class="fa fa-bars" aria-hidden="true"></i><a data-toggle="modal"
                                                                                    data-target=".sortable-images"><?php echo esc_html__('Rearrange Photos', 'carspot'); ?></a>
                                </div>

                            </li>
                            <?php
                        }
                    } else {
                        if (get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) {
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_post_ad_page'])); ?>?id=<?php echo esc_attr($pid); ?>"><?php echo esc_html__('Edit', 'carspot'); ?></a>
                            </li>

                            <li>
                                <div class="photo-rearrange 1212">
                                    <i class="fa fa-bars" aria-hidden="true"></i><a data-toggle="modal"
                                                                                    data-target=".sortable-images"><?php echo esc_html__('Rearrange Photos', 'carspot'); ?></a>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <?php
    if ((get_post_meta($pid, '_carspot_ad_price_type', true) == "no_price") || (get_post_meta($pid, '_carspot_ad_price', true) == "") || (get_post_meta($pid, '_carspot_ad_price_type', true) == "free") || (get_post_meta($pid, '_carspot_ad_price_type', true) == "on_call")) {
    } else {
        ?>
        <div class="col-md-4 col-sm-4 detail_price col-xs-12">
            <div class="singleprice-tag">
                <?php echo carspot_adPrice($pid); ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>