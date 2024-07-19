<?php
global $carspot_theme;
$cs_dashboard_page = cs_language_page_id_callback($carspot_theme['new_dashboard']);
$cs_sign_in_page = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
?>
<!-- NAVBAR -->
<nav class="navbar navbar-default navbar-fixed-top user-dashboard-nav">
    <div class="brand">
        <?php get_template_part('template-parts/layouts/site', 'logo'); ?>
    </div>
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="la la-arrow-circle-left"></i></button>
            <button type="button" class="" id="full-screen"><i class="la la-arrows-alt"></i></button>
        </div>
        <div class="navbar-btn navbar-btn-right post-btn">
            <?php get_template_part('template-parts/layouts/ad', 'button'); ?>
        </div>
        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                <?php
                $user_id = get_current_user_id();
                $user_info = get_userdata($user_id);
                if (isset($carspot_theme['communication_mode']) && ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message')) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="la la-bell"></i>
                            <?php
                            global $wpdb;
                            $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                            if ($unread_msgs > 0) {
                                $msg_count = $unread_msgs;
                                ?>
                                <span class="badge bg-danger"><?php echo esc_html($unread_msgs); ?></span>
                                <?php
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu notifications">
                            <?php
                            if ($unread_msgs > 0) {
                                ?>
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


                                        $action = '';
                                        $action = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'my-messages', 'sb_action' => 'sb_get_messages', 'ad_id' => $ad_id, 'user_id' => $user_id, 'uid' => $get_arr[1]));
                                        //$action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1];
                                        $poster_id = get_post_field('post_author', $ad_id);
                                        if ($poster_id == $user_id) {
                                            $action = '';
                                            $action = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'my-messages', 'sb_action' => 'sb_load_messages', 'ad_id' => $ad_id, 'user_id' => $user_id, 'uid' => $get_arr[1]));
                                            //$action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1];
                                        }
                                        $user_data = get_userdata($get_arr[1]);
                                        if (count((array)$user_data) > 0) {
                                            $user_pic = carspot_get_user_dp($get_arr[1]);
                                            ?>
                                            <li><a href="<?php echo esc_url($action); ?>">
                                                    <div class="user-img"><img src="<?php echo esc_url($user_pic); ?>"
                                                                               alt="<?php echo($user_data->display_name); ?>"
                                                                               width="30" height="50"></div>
                                                    <div class="mail-contnet">
                                                        <h5><?php echo($user_data->display_name) ?></h5> <span
                                                                class="mail-desc"><?php echo esc_html(get_the_title($ad_id)); ?></span>
                                                    </div>
                                                </a></li>
                                            <?php
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <li>
                                    <a href=""
                                       class="text-center"><?php echo esc_html__('You have', 'carspot') . " <strong>" . $unread_msgs . "</strong> " . esc_html__('new notification(s)', 'carspot'); ?></a>
                                </li>
                            <?php }
                            ?>
                            <?php if ($unread_msgs > 0 && isset($carspot_theme['sb_notification_page']) && $carspot_theme['sb_notification_page'] != "") {
                                ?>
                                <li>
                                    <a class="more"
                                       href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_notification_page'])); ?>">
                                        <strong><?php echo esc_html__('See all notifications', 'carspot'); ?></strong>
                                    </a>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <?php
                $current_user = wp_get_current_user();
                $user_pic = carspot_get_user_dp(get_current_user_id(), 'carspot-single-small');
                $img = '<img class="img-circle resize" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url($user_pic) . '" />';
                ?>
                <?php
                if ($carspot_theme['after_login'] == 'dashboard_page') {
                    $logi_redirect = '';
                    $logi_redirect = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'dashboard'));
                } else {
                    $logi_redirect = '';
                    $logi_redirect = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'edit-profile'));
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "" . $img; ?>
                        <span><?php echo esc_html($current_user->display_name); ?></span> <i
                                class="icon-submenu la la-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo esc_url($logi_redirect); ?>"><i class="la la-home"></i>
                                <span> <?php echo esc_html__("Dashboard", "carspot"); ?></span></a></li>
                        <li><a href="<?php echo wp_logout_url(get_the_permalink($cs_sign_in_page)); ?>"><i
                                        class="la la-sign-out"></i>
                                <span><?php echo esc_html__("Logout", "carspot"); ?></span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->