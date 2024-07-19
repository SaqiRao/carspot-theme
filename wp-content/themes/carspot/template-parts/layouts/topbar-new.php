<?php
global $carspot_theme;
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
<div class="carspot-top-bar <?php echo esc_attr($class); ?>">
    <div class="container">
        <div class="carspot-top-bar-container">
            <div class="left-cont">
                <div class="logo" data-mobile-logo="<?php echo esc_url($carspot_theme['sb_site_logo_light']['url']); ?>"
                     image-sticky-logo="<?php echo esc_url($carspot_theme['sb_site_logo_light']['url']); ?>">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo esc_url($carspot_theme['sb_site_logo_light']['url']); ?>"
                             alt="<?php echo esc_html__('Logo', 'carspot'); ?>">
                    </a>
                </div>
                <?php
                $all_countries = carspot_get_cats('ad_country', 0);
                if (isset($all_countries) && !empty($all_countries) && $all_countries != '') {
                    ?>
                    <div class="choose-location">
                        <span class="iconify" data-icon="whh:scope"></span>
                        <select class="form-select" id="topbar-country-select">
                            <option selected><?php echo esc_html__("Select Country", "carspot"); ?></option>
                            <?php
                            foreach ($all_countries as $country) { ?>
                                <option value="<?php echo $country->term_id; ?>"><?php echo $country->name; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <div class="right-cont">
                <nav class="carspot-menu">
                    <ul>
                        <?php
                        $user_id = get_current_user_id();
                        $user_info = get_userdata($user_id);
                        if (isset($carspot_theme['communication_mode']) && ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') && is_user_logged_in()) {
                            ?>
                            <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light"
                                                    data-toggle="dropdown" href="#" aria-expanded="true">
                                    <?php if (isset($carspot_theme['top_bar_type']) && $carspot_theme['top_bar_type'] == "modern") {
                                        echo '<div class="links">';
                                    } ?>
                                    <i
                                            class="icon-envelope"></i><span><?php echo esc_html__('Messages', 'carspot'); ?></span>
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
                                    <?php if (isset($carspot_theme['top_bar_type']) && $carspot_theme['top_bar_type'] == "modern") {
                                        echo '</div>';
                                    } ?>
                                </a>
                                <ul class="dropdown-menu mailbox animated bounceInDown">
                                    <li>
                                        <div class="drop-title">
                                            <?php echo esc_html__('You have', 'carspot') . " <span class='msgs_count'>" . $unread_msgs . "</span> " . esc_html__('new notification(s)', 'carspot'); ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php if ($unread_msgs > 0) {
                                            $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC LIMIT 5", OBJECT);
                                            if (count((array)$notes) > 0) {
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
                        <?php }
                        ?>
                        <li>
                            <a href="<?php echo get_the_permalink($carspot_theme['sb_search_page']); ?>">
                                <div class="links">
                                    <span class="iconify" data-icon="ant-design:search-outlined"></span>
                                    <span><?php echo esc_html__("Search", "carspot"); ?></span>
                                </div>
                            </a>
                        </li>
                        <!--                        <li>-->
                        <!--                            <a href="# ">-->
                        <!--                                <div class="links">-->
                        <!--                                    <span class="iconify" data-icon="codicon:heart"></span>-->
                        <!--                                    <span>Favourites</span>-->
                        <!--                                </div>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <a href="# ">-->
                        <!--                                <div class="links">-->
                        <!--                                    <span class="iconify" data-icon="ic:outline-notifications-active"></span>-->
                        <!--                                    <span>Notifications</span>-->
                        <!--                                </div>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <?php if (!is_user_logged_in()) {
                            if (isset($carspot_theme['sb_sign_in_page']) && $carspot_theme['sb_sign_in_page'] != "") {
                                $sing_page_id = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
                                ?>
                                <li class="signin">
                                    <a href="<?php echo esc_url(get_the_permalink($sing_page_id)); ?>">
                                        <div class="links account">
                                            <span><?php echo esc_html(get_the_title($sing_page_id)); ?></span></div>
                                    </a>
                                </li>
                            <?php }
                            if (isset($carspot_theme['sb_sign_up_page']) && $carspot_theme['sb_sign_up_page'] != "") {
                                $singup_page_id = cs_language_page_id_callback($carspot_theme['sb_sign_up_page']);
                                ?>
                                <li class="signup">
                                    <a href="<?php echo esc_url(get_the_permalink($singup_page_id)); ?>">
                                        <div class="links account">
                                            <span><?php echo esc_html(get_the_title($singup_page_id)); ?></span></div>
                                    </a>
                                </li>
                            <?php }
                        } else {
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
                        get_template_part('template-parts/layouts/ad', 'button'); ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
