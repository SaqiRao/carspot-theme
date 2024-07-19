<?php
/* Template Name: Notification */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carspot
 */
get_header();
global $carspot_theme;
$cs_dashboard_page = cs_language_page_id_callback($carspot_theme['new_dashboard']);
?>
    <div class="main-content-area clearfix">
        <section class="section-padding notification-history">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul>
                            <?php
                            $user_id = get_current_user_id();
                            $user_info = get_userdata($user_id);
                            global $wpdb;
                            $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                            $msg_count = $unread_msgs;
                            ?>
                            <li>
                                <div class="drop-title">
                                    <?php echo esc_html__('You have', 'carspot') . " <span class='msgs_count'>" . $unread_msgs . "</span> " . esc_html__('new notification(s)', 'carspot'); ?>
                                </div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <?php if ($unread_msgs > 0) {
                                        $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC", OBJECT);

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
                                                $action = '';
                                                $action = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'my-messages', 'sb_action' => 'sb_get_messages', 'ad_id' => $ad_id, 'user_id' => $user_id, 'uid' => $get_arr[1]));
                                                //$action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1];
                                                $poster_id = get_post_field('post_author', $ad_id);
                                                if ($poster_id == $user_id) {
                                                    $action = '';
                                                    $action = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), array('page-type' => 'my-messages', 'sb_action' => 'sb_load_messages', 'ad_id' => $ad_id, 'uid' => $get_arr[1]));
                                                    //$action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1];
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
                                                            <h5><?php echo esc_html($user_data->display_name) ?></h5>
                                                            <span
                                                                    class="mail-desc">
									<?php echo esc_html(get_the_title($ad_id)); ?></span></div>
                                                    </a>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php get_footer();