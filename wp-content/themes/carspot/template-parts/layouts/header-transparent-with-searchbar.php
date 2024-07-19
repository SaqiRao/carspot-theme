<?php global $carspot_theme;

$cs_dashboard_page = cs_language_page_id_callback($carspot_theme['new_dashboard']);
$cs_sign_in_page = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
$sb_sign_up_page = cs_language_page_id_callback($carspot_theme['sb_sign_up_page']);
$sb_notification_page = cs_language_page_id_callback($carspot_theme['sb_notification_page']);
$sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);

?>

<div class="colored-header">
    <!-- Navigation Menu -->
    <div class="clearfix"></div>
    <?php
    $make_relative = '';
    if (isset($carspot_theme['sb_header']) == "transparent2" && is_singular('ad_post') && $carspot_theme['single_ad_style'] == "2") {
        $make_relative = 'make-relative';
    }
    $register_process = isset($carspot_theme['cs_register_proces']) ? $carspot_theme['cs_register_proces'] : "true";
    ?>

    <!-- menu start -->
    <nav id="menu-1"
         class="mega-menu header-transparent with-search  <?php echo carspot_returnEcho($make_relative); ?>">
        <!-- menu list items container -->
        <section class="menu-list-items">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <!-- menu logo -->
                        <ul class="menu-logo">
                            <li> <?php get_template_part('template-parts/layouts/site', 'logo'); ?> </li>
                        </ul>

                        <!-- menu links -->
                        <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                        <ul class="menu-search-bar">
                            <li>
                                <form class="form-inline" action="<?php echo esc_url(get_the_permalink()); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="ad_title" autocomplete="off"
                                               id="autocomplete-dynamic"
                                               placeholder="<?php echo esc_html__('What are you looking for...', 'carspot') ?>">
                                    </div>
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    <?php //echo apply_filters('cs_form_lang_field','false'); ?>
                                </form>
                            </li>
                            <?php
                            if (!is_user_logged_in()) {
                                if ($register_process) {
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
                            <li>
                                <?php get_template_part('template-parts/layouts/ad', 'button'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </nav>
    <!-- menu end -->
</div>























