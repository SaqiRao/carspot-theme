<?php
global $carspot_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$user_pic = carspot_get_user_dp($poster_id);

$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
$type = '';
$link = '';
$type = $carspot_theme['cat_and_location'];
?>
<div class="col-lg-8 col-xs-12 col-md-12 col-sm-12">
    <div class="single-bar-main-section">
        <div class="single-bar-image"><a href="<?php echo esc_url(get_author_posts_url($poster_id)); ?>"><img
                        src="<?php echo esc_url($user_pic); ?>"
                        alt="<?php echo esc_html__('Profile Pic', 'carspot'); ?>" class="img-responsive"> </a></div>
        <div class="single-bar-text-section">
            <div class="single-price-section">
                <?php
                if (get_post_meta($pid, '_carspot_ad_price_type', true) == "no_price" || (get_post_meta($pid, '_carspot_ad_price', true) == "" && get_post_meta($pid, '_carspot_ad_price_type', true) != "free" && get_post_meta($pid, '_carspot_ad_price_type', true) != "on_call")) {
                } else {
                    ?>

                    <h2><?php echo carspot_adPrice($pid); ?></h2>
                    <?php
                }
                ?>
            </div>
            <div class="single-details-section">
                <h3><?php the_title(); ?></h3>
                <?php if (get_post_meta($pid, '_carspot_is_feature', true) == '1') { ?>
                    <div class="featured-categories">
                        <span class="f-badge"><?php echo esc_html__('Featured', 'carspot'); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="single-page-anchors-section">
                <ul class="style-5">

                    <li><?php echo esc_html__('Stock id', 'carspot'); ?> #<b><?php echo esc_html($pid); ?></b></li>
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
                            $sb_post_ad_page = cs_language_page_id_callback($carspot_theme['sb_post_ad_page']);
                            $sb_post_ad_page_ = carspot_set_url_params_multi(get_the_permalink($sb_post_ad_page), array('id' => $pid));

                            ?>
                            <li>
                                <a href="<?php echo esc_url($sb_post_ad_page_); ?>"><?php echo esc_html__('Edit', 'carspot'); ?></a>
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
                            $sb_post_ad_page = cs_language_page_id_callback($carspot_theme['sb_post_ad_page']);
                            $sb_post_ad_page_ = carspot_set_url_params_multi(get_the_permalink($sb_post_ad_page), array('id' => $pid));
                            ?>
                            <li>
                                <a href="<?php echo esc_url($sb_post_ad_page_); ?>"><?php echo esc_html__('Edit', 'carspot'); ?></a>
                            </li>
                            <li>
                                <div class="photo-rearrange">
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
</div>
<div class="col-lg-4 col-xs-12 col-md-12 col-sm-12 no-padding">
    <div class="single-bar-buttons-section">
        <ul class="list-inline style-6">
            <?php
            /*Share Ad report Ad*/
            get_template_part('template-parts/layouts/ad_style/ad', 'tabs');
            ?>
        </ul>
    </div>
</div>
