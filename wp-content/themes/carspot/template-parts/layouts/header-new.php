<?php
global $carspot_theme;
$cs_dashboard_page = cs_language_page_id_callback($carspot_theme['new_dashboard']);
$cs_sign_in_page = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
$sb_sign_up_page = cs_language_page_id_callback($carspot_theme['sb_sign_up_page']);
$sb_notification_page = cs_language_page_id_callback($carspot_theme['sb_notification_page']);
if (isset($carspot_theme['top_bar_type']) && $carspot_theme['top_bar_type'] == "modern") {
    get_template_part('template-parts/layouts/topbar', 'new');
} else {
    get_template_part('template-parts/layouts/top-bar', 'services');
}
?>
<div class="sb-header header-shadow viewport-sm sb-carspot modern-naviga">
    <div class="container">
        <!-- sb header -->
        <div class="sb-header-container">
            <!-- Burger menu -->
            <div class="burger-menu ">
                <div class="line-menu line-half first-line "></div>
                <div class="line-menu "></div>
                <div class="line-menu line-half last-line "></div>
            </div>
            <?php
   
    ?>
            <!--Navigation menu-->
            <nav class="sb-menu menu-caret submenu-top-border submenu-scale ">
                <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                <ul class="menu-right-links">
                            <?php
                            if (!is_user_logged_in()) {
                              //  if ($register_process) {
                                    if (isset($carspot_theme['sb_sign_in_page']) && $carspot_theme['sb_sign_in_page'] != "") {
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_the_permalink($cs_sign_in_page)); ?>">

                                                <?php echo esc_html(get_the_title($cs_sign_in_page)); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if (isset($carspot_theme['sb_sign_up_page']) && $carspot_theme['sb_sign_up_page'] != "") {
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_attr(get_the_permalink($sb_sign_up_page)); ?>">

                                                <?php echo esc_html(get_the_title($sb_sign_up_page)); ?>
                                            </a>
                                        </li>

                                        <?php
                                    }
                            //    }
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
                                                            if (count((array)$user_data) > 0) {
                                                                $user_pic = carspot_get_user_dp($get_arr[1]);
                                                                ?>
                                                                <a href="<?php echo esc_url($action); ?>">
                                                                    <div class="user-img"><img
                                                                                src="<?php echo esc_url($user_pic); ?>"
                                                                                alt="<?php echo($user_data->display_name); ?>"
                                                                                width="30" height="50"></div>
                                                                    <div class="mail-contnet">
                                                                        <h5><?php echo($user_data->display_name) ?></h5>
                                                                        <span class="mail-desc"><?php echo esc_html(get_the_title($ad_id)); ?></span>
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
                                                       href="<?php echo esc_url(get_the_permalink($sb_notification_page)); ?>">
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
                                    <?php
                                }
                                ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <?php
                                        $user_pic = carspot_get_user_dp(get_current_user_id(), 'carspot-single-small');
                                        $img = '<img class="img-circle resize" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url($user_pic) . '" />';
                                        ?>
                                        <?php echo "" . $img; ?>
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        if ($carspot_theme['after_login'] == 'dashboard_page') {
                                            $logi_redirect = '';
                                            $logi_redirect = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'dashboard'));
                                        } else {
                                            $logi_redirect = '';
                                            $logi_redirect = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'edit-profile'));
                                        }
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url($logi_redirect); ?>"><?php echo esc_html__("Dashboard", "carspot"); ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo wp_logout_url(get_the_permalink($cs_sign_in_page)); ?>"><?php echo esc_html__("Logout", "carspot"); ?></a>
                                        </li>
                                    </ul>
                                </li>

                                <?php
                            }
                            ?>
                    <li class="signup ">
                        <a href="# ">
                            <div class="call-box">
                                <div class="left-icon">
                                    <span class="iconify" data-icon="bx:bxs-phone-call"></span>
                                </div>
                                <div class="right-meta">
                                    <p><?php echo esc_html__("Call Us", "carspot"); ?>:</p>
                                    <h6><?php echo $carspot_theme['ad_contact_number'] ?></h6>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php if (isset($carspot_theme["for_location"]) && $carspot_theme["for_location"] != '') { ?>
                        <li class="signin">
                            <a href="javascript:void(0)">
                                <div class="location-box">
                                    <div class="left-icon">
                                        <span class="iconify" data-icon="gis:location-poi"></span>
                                    </div>
                                    <div class="right-meta">
                                        <p>
                                            Location: <?php echo esc_html($carspot_theme["for_location"]['rane_field_1']); ?></p>
                                        <h6 id="address"><?php echo esc_html($carspot_theme["for_location"]['rane_field_2']); ?></h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>


