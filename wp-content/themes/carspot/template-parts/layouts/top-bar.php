<?php
global $carspot_theme;
$msg_count = 0;
if (!$carspot_theme['sb_top_bar']) {
    return;
}
$register_process = isset($carspot_theme['cs_register_proces']) ? $carspot_theme['cs_register_proces'] : "true";
?>
<?php
$class = '';
if (isset($carspot_theme['top_bar_color']) && $carspot_theme['top_bar_color']) {
    $class = $carspot_theme['top_bar_color'];
}
?>
<div class="header-top <?php echo esc_attr($class); ?>">
    <div class="container">
        <div class="row">
            <div class="header-top-left col-md-5 col-sm-5 col-xs-12 hidden-xs">
                <ul class="listnone">
                    <?php
                    if (isset($carspot_theme["cs_lang_switcher"]) && $carspot_theme["cs_lang_switcher"] == true) {
                        echo '<li>' . cs_language_switcher() . '</li>';
                    }

                    if (isset($carspot_theme['top_bar_pages']) && $carspot_theme['top_bar_pages'] != "" && count($carspot_theme['top_bar_pages']) > 0) {
                        foreach ($carspot_theme['top_bar_pages'] as $foot_page) {
                            $single_page_id = cs_language_page_id_callback($foot_page);
                            echo '<li><a href="' . esc_url(get_the_permalink($single_page_id)) . '">' . esc_html(get_the_title($single_page_id)) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php
            $menu_flip = '';
            if (is_rtl()) {
                $menu_flip = 'flip';
            }
            ?>
            <div class="header-right col-md-7 col-sm-7 col-xs-12 ">
                <div class="pull-right <?php echo esc_attr($menu_flip); ?>">
                    <ul class="listnone">
                        <?php
                        if (isset($carspot_theme['show_cart_top']) && ($carspot_theme['show_cart_top'] == '1') && class_exists('WooCommerce')) {
                            ?>
                            <li>
                                <a class="shopping_bag_btn"
                                   href="<?php echo esc_url(get_permalink(WC_Admin_Settings::get_option('woocommerce_cart_page_id'))); ?>"><i
                                            class="fa fa-shopping-cart"></i><span><?php echo WC()->cart->get_cart_contents_count(); ?></span></a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (!is_user_logged_in()) {
                            if ($register_process) {
                                if (isset($carspot_theme['sb_sign_in_page']) && $carspot_theme['sb_sign_in_page'] != "") {
                                    $sing_page_id = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_the_permalink($sing_page_id)); ?>">
                                            <i class="fa fa-sign-in"></i>
                                            <?php echo esc_html(get_the_title($sing_page_id)); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if (isset($carspot_theme['sb_sign_up_page']) && $carspot_theme['sb_sign_up_page'] != "") {
                                    $singup_page_id = cs_language_page_id_callback($carspot_theme['sb_sign_up_page']);
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_the_permalink($singup_page_id)); ?>">
                                            <i class="fa fa-unlock" aria-hidden="true"></i>
                                            <?php echo esc_html(get_the_title($singup_page_id)); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                        } else {
                            $user_id = get_current_user_id();
                            $user_info = get_userdata($user_id);
                            if (isset($carspot_theme['communication_mode']) && ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message')) {
                                ?>
                                <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light"
                                                        data-toggle="dropdown" href="#" aria-expanded="true"><i
                                                class="icon-envelope"></i><?php echo esc_html__('Messages', 'carspot'); ?>
                                        <div class="notify">
                                            <?php
                                            global $wpdb;
                                            $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                            if ($unread_msgs > 0) {
                                                $msg_count = $unread_msgs;
                                                ?>
                                                <span class="heartbit"></span><span class="point"></span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu mailbox animated bounceInDown">
                                        <li>
                                            <div class="drop-title">
                                                <?php echo esc_html__('You have', 'carspot') . " <span class='msgs_count'>" . $unread_msgs . "</span> " . esc_html__('new notification(s)', 'carspot'); ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <?php if ($unread_msgs > 0) { ?>
                                                <?php
                                                $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC LIMIT 5", OBJECT);

                                                if (count((array)$notes) > 0) {
                                                    ?>

                                                    <?php
                                                    foreach ($notes as $note) {
                                                        $ad_img = $carspot_theme['default_related_image']['url'];
                                                        $get_arr = explode('_', $note->meta_key);
                                                        $ad_id = $get_arr[0];
                                                        $media = get_attached_media('image', $ad_id);
                                                        if (count((array)$media) > 0) {
                                                            $counting = 1;
                                                            foreach ($media as $m) {
                                                                if ($counting > 1) {
                                                                    $image = wp_get_attachment_image_src($m->ID, 'carspot-single-small');
                                                                    if ($image[0] != "") {
                                                                        $ad_img = $image[0];
                                                                    }
                                                                    break;
                                                                }
                                                                $counting++;
                                                            }
                                                        }

                                                        $action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1];
                                                        $poster_id = get_post_field('post_author', $ad_id);
                                                        if ($poster_id == $user_id) {
                                                            $action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1];
                                                        }
                                                        $user_data = get_userdata($get_arr[1]);
                                                        if (count((array)$user_data) > 0 && $user_data != '') {
                                                            $user_pic = carspot_get_user_dp($get_arr[1]);
                                                            ?>
                                                            <a href="<?php echo esc_url($action); ?>">
                                                                <div class="user-img"><img
                                                                            src="<?php echo esc_url($user_pic); ?>"
                                                                            alt="<?php echo($user_data->display_name); ?>"
                                                                            width="30" height="50"></div>
                                                                <div class="mail-contnet">
                                                                    <h5><?php echo($user_data->display_name) ?></h5>
                                                                    <span class="mail-desc">
                                                                            <?php echo esc_html(get_the_title($ad_id)); ?></span>
                                                                </div>
                                                            </a>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <?php
                                        if ($unread_msgs > 0 && isset($carspot_theme['sb_notification_page']) && $carspot_theme['sb_notification_page'] != "") {
                                            ?>
                                            <li>
                                                <a class="text-center"
                                                   href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_notification_page'])); ?>">
                                                    <strong><?php echo esc_html__('See all notifications', 'carspot'); ?></strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    $user_pic = carspot_get_user_dp(get_current_user_id(), 'carspot-single-small');
                                    $img = '<img class="img-circle resize" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url($user_pic) . '" />';
                                    ?>
                                    <?php echo "" . $img; ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    $logi_redirect_url = '';
                                    if ($carspot_theme['after_login'] == 'dashboard_page') {
                                        $logi_redirect_url = carspot_set_url_params_multi(get_the_permalink(cs_language_page_id_callback($carspot_theme['new_dashboard'])), array('page-type' => 'dashboard'));
                                    } else {
                                        $logi_redirect_url = carspot_set_url_params_multi(get_the_permalink(cs_language_page_id_callback($carspot_theme['new_dashboard'])), array('page-type' => 'edit-profile'));
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url($logi_redirect_url); ?>"><?php echo esc_html__("Dashboard", "carspot"); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo wp_logout_url(get_the_permalink($carspot_theme['sb_sign_in_page'])); ?>"><?php echo esc_html__("Logout", "carspot"); ?></a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php if (isset($carspot_theme['sb_header']) && ($carspot_theme['sb_header'] == 'white')) { ?>
                            <li><?php echo(get_template_part('template-parts/layouts/ad', 'button')); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>