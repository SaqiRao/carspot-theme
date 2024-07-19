<?php
global $carspot_theme;
if (is_page_template('page-profile.php')) {

} else {
    if (isset($carspot_theme['footer_type']) && $carspot_theme['footer_type'] == 'white' || $carspot_theme['footer_type'] == 'dark') {
        get_template_part('template-parts/layouts/footer', '2');
    } else if (isset($carspot_theme['footer_type']) && $carspot_theme['footer_type'] == 'transparent') {
        get_template_part('template-parts/layouts/footer', 'transparent');
    } else if (isset($carspot_theme['footer_type']) && ($carspot_theme['footer_type'] == 'elementorproFooter') && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        elementor_theme_do_location('footer');
    } else {
        get_template_part('template-parts/layouts/footer', 'short');
    }
}


//if (in_array('carspot_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
if (is_plugin_active('carspot_framework/index.php')) {
    if (is_rtl()) {
        ?>
        <input type="hidden" id="is_rtl" value="1"/>
    <?php } else { ?>
        <input type="hidden" id="is_rtl" value="0"/>
    <?php } ?>
    <?php
    if (isset($carspot_theme['sb_video_icon']) && $carspot_theme['sb_video_icon'] == "1") {
        echo("<input type='hidden' id='is_video_active' value='1' />");
    } else {
        echo("<input type='hidden' id='is_video_active' value='0' />");
    }

    if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == "category_based") {
        echo("<input type='hidden' id='is_category_based' value='1' />");
    } else {
        echo("<input type='hidden' id='is_category_based' value='0' />");
    }
    ?>
    <?php
    if ($carspot_theme['after_login'] == 'dashboard_page') {
        //$logi_redirect = '?page-type=dashboard';
        $logi_redirect = array('page-type' => 'dashboard');
    } else {
        //$logi_redirect = '?page-type=edit-profile';
        $logi_redirect = array('page-type' => 'edit-profile');
    }

    /* for dashboard */
    $cs_dashboard_page = cs_language_page_id_callback($carspot_theme['new_dashboard']);
    $action_dashboard = carspot_set_url_params_multi(get_the_permalink($cs_dashboard_page), $logi_redirect);

    /* sign-in page */
    $cs_sign_in_page = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
    
    $nonce_security = wp_create_nonce('check-security');
   

    ?>
    <input type="hidden" id="nonce_security" value="<?php echo $nonce_security; ?>">
    <input type="hidden" id="profile_page"
           value="<?php echo $action_dashboard; ?>"/>
    <input type="hidden" id="previous_url"
           value="<?php echo wp_get_referer(); ?>"/>
    <input type="hidden" id="login_page"
           value="<?php echo esc_url(get_the_permalink($cs_sign_in_page)); ?>"/>
    <input type="hidden" id="theme_path" value="<?php echo trailingslashit(get_template_directory_uri()); ?>"/>
    <input type="hidden" id="carspot_ajax_url" value="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"/>
    <input type="hidden" id="carspot_forgot_msg"
           value="<?php echo esc_html__('Password sent on your email.', 'carspot'); ?>"/>
    <input type="hidden" id="carspot_profile_msg"
           value="<?php echo esc_html__('Profile saved successfully.', 'carspot'); ?>"/>
    <input type="hidden" id="carspot_max_upload_reach"
           value="<?php echo esc_html__('Maximum upload limit reached', 'carspot'); ?>"/>
    <input type="hidden" id="not_logged_in" value="<?php echo esc_html__('You have been logged out.', 'carspot'); ?>"/>
    <input type="hidden" id="sb_upload_limit" value="<?php echo esc_attr($carspot_theme['sb_upload_limit']); ?>"/>
    <!--gallery upload size-->
    <input type="hidden" id="sb_upload_size" value="<?php echo $carspot_theme['sb_upload_size']; ?>"/>
    <?php
    $time_zones_val = isset($carspot_theme['bid_timezone']) && $carspot_theme['bid_timezone'] != '' ? $carspot_theme['bid_timezone'] : 'Etc/UTC';
        if (function_exists('carspot_timezone_list') && isset($carspot_theme['bid_timezone']) && $carspot_theme['bid_timezone'] != '') {
            $time_zones_val = carspot_timezone_list('', $carspot_theme['bid_timezone']);
            date_default_timezone_set($time_zones_val);
        }
        ?>
    <input type="hidden" id="sb-bid-timezone" value="<?php echo $time_zones_val; ?>"/> 
    <input type="hidden" id="facebook_key" value="<?php echo esc_attr($carspot_theme['fb_api_key']); ?>"/>
    <input type="hidden" id="google_key" value="<?php echo esc_attr($carspot_theme['gmail_api_key']); ?>"/>
    <input type="hidden" id="confirm_delete"
           value="<?php echo esc_html__('Are you sure to delete this?', 'carspot'); ?>"/>
    <input type="hidden" id="confirm_update"
           value="<?php echo esc_html__('Are you sure to update this?', 'carspot'); ?>"/>
    <input type="hidden" id="ad_updated" value="<?php echo esc_html__('Ad updated successfully.', 'carspot'); ?>"/>
    <input type="hidden" id="ad_posted" value="<?php echo esc_html__('Ad posted successfully.', 'carspot'); ?>"/>
    <input type="hidden" id="inpection_posted" value="<?php echo esc_html__('Inspection posted successfully.', 'carspot'); ?>"/>
    <input type="hidden" id="redirect_uri" value="<?php echo esc_url($carspot_theme['redirect_uri']); ?>"/>
    <input type="hidden" id="select_place_holder" value="<?php echo esc_html__('Select an option', 'carspot'); ?>"/>
    <input type="hidden" id="is_sticky_header" value="<?php echo esc_attr($carspot_theme['sb_sticky_header']); ?>"/>
    <input type="hidden" id="current_currency" value="<?php echo esc_attr($carspot_theme['sb_currency']); ?>"/>
    <input type="hidden" id="is_sub_active" value="1"/>
    <input type="hidden" id="account_deleted"
           value="<?php echo esc_html__('Your account have been deleted permanently..', 'carspot'); ?>"/>
    <input type="hidden" id="nonce_error" value="<?php echo esc_html__('This is a secure website', 'carspot'); ?>"/>


    <!--Sticky header logic-->
    <input type="hidden" id="header_style" value="<?php echo esc_attr($carspot_theme['sb_header']); ?>"/>
    <input type="hidden" id="is_sticky_header" value="<?php echo esc_attr($carspot_theme['sb_sticky_header']); ?>"/>
    <input type="hidden" id="sticky_sb_logo_url"
           value="<?php echo esc_url($carspot_theme['sb_site_logo_light']['url']); ?>"/>
    <input type="hidden" id="static_sb_logo_url" value="<?php echo esc_url($carspot_theme['sb_site_logo']['url']); ?>"/>
    <?php
    $yes = 0;
    $not_time = '30000';
    if (isset($carspot_theme['msg_notification_on']) && isset($carspot_theme['communication_mode']) && ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message')) {
        $yes = $carspot_theme['msg_notification_on'];
        $not_time = $carspot_theme['msg_notification_time'];
    }
    global $wpdb;
    $user_id = get_current_user_id();
    $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
    ?>
    <input type="hidden" id="msg_notification_on" value="<?php echo esc_attr($yes); ?>"/>
    <input type="hidden" id="msg_notification_time" value="<?php echo esc_attr($not_time); ?>"/>
    <input type="hidden" id="is_unread_msgs" value="<?php echo esc_attr($unread_msgs); ?>"/>
    <?php
} else {
    ?>
    <input type="hidden" id="is_sub_active" value="0"/>
    <?php
}
?>
<?php get_template_part('template-parts/layouts/scroll', 'up'); ?>
<!-- Email verification and reset password -->
<?php get_template_part('template-parts/verification', 'logic'); ?>



<?php
if (is_singular("ad_post")) {
    $pid = get_the_ID();
    $my_url = carspot_get_current_url();
    if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
        if (is_super_admin(get_current_user_id())) {
            ?>

            <!-- =-=-=-=-=-=-= Images Sorting =-=-=-=-=-=-= -->
            <div class="modal fade sortable-images" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title"><?php echo esc_html__('ReArrange Ad Images', 'carspot'); ?></h3>
                        </div>
                        <div class="modal-body">

                            <small><?php echo esc_html__('*First image will be main display image of this ad.', 'carspot'); ?></small>
                            <ul id="sortable">
                                <?php
                                $media = carspot_fetch_listing_gallery($pid);
                                $img_ids = '';
                                if (count($media) > 0) {
                                    foreach ($media as $m) {
                                        $mid = '';
                                        if (isset($m->ID))
                                            $mid = $m->ID;
                                        else
                                            $mid = $m;
                                        $img = wp_get_attachment_image_src($mid, 'carspot-small-thumb');
                                        if ($img[0] == "")
                                            continue;
                                        $img_ids = $img_ids . $mid . ',';
                                        ?>
                                        <li class="ui-state-default">
                                            <img alt="<?php echo esc_attr(get_the_title()); ?>"
                                                 data-img-id="<?php echo '' . $mid; ?>" draggable="false"
                                                 src="<?php echo esc_attr($img[0]); ?>">
                                        </li>
                                        <?php
                                    }
                                }
                                $img_ids = rtrim($img_ids, ',');
                                if (get_post_meta($pid, 'carspot_photo_arrangement_', true) == "")
                                    update_post_meta($pid, 'carspot_photo_arrangement_', $img_ids);
                                ?>
                            </ul>
                            <input type="hidden" id="ad_imgz_ids" value="<?php echo esc_attr($img_ids); ?>"/>
                            <input type="hidden" id="current_ad_id" value="<?php echo esc_attr($pid); ?>"/>
                            <input type="hidden" id="sort_images_nonce"
                                   value="<?php echo wp_create_nonce('carspot_sort_images_secure'); ?>"/>
                            <button type="button" class="btn btn-theme sonu-button  btn-block"
                                    id="listing_sort_images"><?php echo esc_html__("Re Arrange Images", 'carspot'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
            <?php
        }
    } else {
        if (get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) {
            ?>
            <!-- =-=-=-=-=-=-= Images Sorting =-=-=-=-=-=-= -->
            <div class="modal fade sortable-images" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title"><?php echo esc_html__('ReArrange Ad Images', 'carspot'); ?></h3>
                        </div>
                        <div class="modal-body">

                            <small><?php echo esc_html__('*First image will be main display image of this ad.', 'carspot'); ?></small>
                            <ul id="sortable">
                                <?php
                                $media = carspot_fetch_listing_gallery($pid);
                                $img_ids = '';
                                if (count($media) > 0) {
                                    foreach ($media as $m) {
                                        $mid = '';
                                        if (isset($m->ID))
                                            $mid = $m->ID;
                                        else
                                            $mid = $m;
                                        $img = wp_get_attachment_image_src($mid, 'carspot-small-thumb');
                                        if ($img[0] == "")
                                            continue;
                                        $img_ids = $img_ids . $mid . ',';
                                        ?>
                                        <li class="ui-state-default">
                                            <img alt="<?php echo esc_attr(get_the_title()); ?>"
                                                 data-img-id="<?php echo '' . $mid; ?>" draggable="false"
                                                 src="<?php echo esc_attr($img[0]); ?>">
                                        </li>
                                        <?php
                                    }
                                }
                                $img_ids = rtrim($img_ids, ',');
                                if (get_post_meta($pid, 'carspot_photo_arrangement_', true) == "")
                                    update_post_meta($pid, 'carspot_photo_arrangement_', $img_ids);
                                ?>
                            </ul>
                            <input type="hidden" id="ad_imgz_ids" value="<?php echo esc_attr($img_ids); ?>"/>
                            <input type="hidden" id="current_ad_id" value="<?php echo esc_attr($pid); ?>"/>
                            <input type="hidden" id="sort_images_nonce"
                                   value="<?php echo wp_create_nonce('carspot_sort_images_secure'); ?>"/>
                            <button type="button" class="btn btn-theme sonu-button  btn-block"
                                    id="listing_sort_images"><?php echo esc_html__("Re Arrange Images", 'carspot'); ?></button>


                        </div>
                    </div>
                </div>
            </div>
            </li>
            <?php
        }
    }
}
/* TEST DRIVE MODAL */
if (is_singular("ad_post")) {
    ?>
    <div class="modal fade test-drive-modal" id="test-drive-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"> &#10005; </span>
                    </button>
                    <?php echo esc_html__('Schedule test drive for', 'carspot'); ?> <h3 class="modal-title"
                                                                                        id="lineModalLabel">  <?php the_title(); ?></h3>
                </div>
                <div class="modal-body">
                    <form id="test_drive_pop-form" data-parsley-validate="" method="post">
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Your Name', 'carspot'); ?></label>
                            <input type="text" name="name" class="form-control" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please write your name', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Email Address', 'carspot'); ?></label>
                            <input type="email" name="email" class="form-control" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please valid email address', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Phone', 'carspot'); ?></label>
                            <input type="text" name="phone" class="form-control" data-parsley-type="number" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please enter your contact number', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Set Date', 'carspot'); ?></label>
                            <input type="text" name="date_time" class="date-pop form-control" data-timepicker="true"
                                   autocomplete="off" data-date-format="dd MM yyyy" data-time-format='hh:ii aa'
                                   required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please select test drive date and time', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-12  col-sm-12">
                            <label><?php echo esc_html__('Message', 'carspot'); ?></label>
                            <textarea class="form-control" rows="5" name="message"></textarea>
                        </div>
                        <?php if ($carspot_theme['google_api_key'] != "") { ?>
                            <div class="form-group col-md-12  col-sm-12">
                                <div class="g-recaptcha" name="test_drive_captcha"
                                     data-sitekey="<?php echo esc_attr($carspot_theme['google_api_key']); ?>"></div>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <div class="col-md-12  col-sm-12 margin-bottom-20 margin-top-20">
                            <input type="hidden" name="ad_post_id" value="<?php echo esc_attr($pid); ?>"/>
                            <!--<input type="hidden" name="usr_id" value="<?php //echo esc_attr(get_current_user_id());    ?>" />
                            <input type="hidden" name="receiver_id" value="<?php //echo esc_attr( $poster_id );     ?>" />-->
                            <input type="hidden" id="test_drive_nonce"
                                   value="<?php echo wp_create_nonce('carspot_test_drive_secure'); ?>"/>
                            <button type="submit"
                                    class="btn btn-theme btn-block"><?php echo esc_html__('Submit', 'carspot'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}


/* MAKE OFFER MODAL */
if (is_singular("ad_post")) {
    ?>
    <div class="modal fade make-offer-modal" id="make-offer-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"> &#10005; </span>
                    </button>
                    <?php echo esc_html__('Make an offer for', 'carspot'); ?> <h3 class="modal-title"
                                                                                  id="lineModalLabel">  <?php the_title(); ?></h3>
                </div>
                <div class="modal-body">
                    <form id="make_offer_pop_form" data-parsley-validate="">
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Your Name', 'carspot'); ?></label>
                            <input type="text" name="name" class="form-control" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please write your name', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Email Address', 'carspot'); ?></label>
                            <input type="email" name="email" class="form-control" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please valid email address', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Phone', 'carspot'); ?></label>
                            <input type="text" name="phone" class="form-control" data-parsley-type="number" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please enter your contact number', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-6  col-sm-6">
                            <label><?php echo esc_html__('Your Price', 'carspot'); ?></label>
                            <input type="text" name="price" class="form-control" data-parsley-type="number" required=""
                                   data-parsley-error-message="<?php echo esc_attr__('Please enter your price', 'carspot'); ?>">
                        </div>
                        <div class="form-group  col-md-12  col-sm-12">
                            <label><?php echo esc_html__('Message', 'carspot'); ?></label>
                            <textarea class="form-control" rows="5" name="message"></textarea>
                        </div>
                        <?php if ($carspot_theme['google_api_key'] != "") { ?>
                            <div class="form-group col-md-12  col-sm-12">
                                <div class="g-recaptcha" name="make_offer_captcha"
                                     data-sitekey="<?php echo esc_attr($carspot_theme['google_api_key']); ?>"></div>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <div class="col-md-12  col-sm-12 margin-bottom-20 margin-top-20">
                            <input type="hidden" name="ad_post_id" value="<?php echo esc_attr($pid); ?>"/>
                            <!--<input type="hidden" name="usr_id" value="<?php //echo esc_attr(get_current_user_id());    ?>" />
                            <input type="hidden" name="receiver_id" value="<?php //echo esc_attr( $poster_id );    ?>" />-->
                            <input type="hidden" id="make_offer_nonce"
                                   value="<?php echo wp_create_nonce('carspot_register_secure'); ?>"/>
                            <button type="submit"
                                    class="btn btn-theme btn-block"><?php echo esc_html__('Submit', 'carspot'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}


if (is_page_template('page-profile.php')) {
    if (is_user_logged_in()) {
        if (get_user_meta(get_current_user_id(), '_sb_user_type', true) == "") {
            ?>
            <div id="ask_for_user_type" class="modal fade ask_for_user_type" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header rte">
                            <h2 class="modal-title"><?php echo esc_html__('Please select your user type', 'carspot'); ?></h2>
                        </div>
                        <form id="save_user_type_old_users">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label><?php echo esc_html__('User Type ', 'carspot'); ?></label>
                                    <select class="form-control"
                                            data-placeholder="<?php echo esc_html__('Select user type', 'carspot'); ?>"
                                            name="sb_user_type" data-parsley-required="true"
                                            data-parsley-error-message="<?php echo __('Please select user type.', 'carspot') ?>">
                                        <option value=""><?php echo esc_html__('Select user type.', 'carspot'); ?></option>
                                        <option value="individual"><?php echo esc_html__('Individual', 'carspot'); ?></option>
                                        <option value="dealer"><?php echo esc_html__('Dealer', 'carspot'); ?></option>
                                    </select>
                                    <p> <?php echo esc_html__('NOTE: Please note that you cannot change it later so please make it sure if you are a dealer or individual', 'carspot'); ?></p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-theme" type="submit"
                                            id="user_type"><?php echo esc_html__('Save', 'carspot'); ?></button>
                                    <input type="hidden" id="user_type_nonce"
                                           value="<?php echo wp_create_nonce('carspot_user_type_secure') ?>"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}


// Password Reset Html	
if (isset($_GET['token']) && $_GET['token'] != "" && !is_user_logged_in()) {
    ?>
    <input type="hidden" id="adforest_password_mismatch_msg"
           value="<?php echo __('Password not matched.', 'carspot'); ?>"/>
    <div id="sb_reset_password_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header rte">
                    <h2 class="modal-title"><?php echo __('Set your Password', 'carspot'); ?></h2>
                </div>
                <form id="sb-reset-password-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo __('New Password', 'carspot'); ?></label>
                            <input placeholder="<?php echo __('Enter Password', 'carspot'); ?>" class="form-control"
                                   type="password" data-parsley-required="true"
                                   data-parsley-error-message="<?php echo __('This field this required.', 'carspot'); ?>"
                                   data-parsley-trigger="change" name="sb_new_password" id="sb_new_password">
                        </div>
                        <div class="form-group">
                            <label><?php echo __('Confirm New Password', 'carspot'); ?></label>
                            <input placeholder="<?php echo __('Confirm Password', 'carspot'); ?>" class="form-control"
                                   type="password" data-parsley-required="true"
                                   data-parsley-error-message="<?php echo __('This field this required.', 'carspot'); ?>"
                                   data-parsley-trigger="change" name="sb_confirm_new_password"
                                   id="sb_confirm_new_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-theme btn-sm" type="submit"
                                id="sb_reset_password_submit"><?php echo __('Change Password', 'carspot'); ?></button>
                        <button class="btn btn-theme btn-sm" type="button"
                                id="sb_reset_password_msg"><?php echo __('Processing...', 'carspot'); ?></button>
                        <input type="hidden" name="token" value="<?php echo esc_attr($_GET['token']); ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>
<style>
    .compare-floating-btn {
        position: fixed;
        right: 0;
        top: 30%;
        background-color: #242424;
        color: #fff;
        box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.07);
        z-index: 999;
        border-radius: 4px 0 0 4px;
    }

    .compare-floating-btn a {
        padding: 15px 20px;
        color: #fff;
        display: inline-block;
    }

    .compare-floating-btn span.badge {
        position: absolute;
        border-radius: 50%;
        top: -12px;
        left: -12px;
        background-color: #E52D27;
        padding: 5px 10px;
        font-family: "Poppins", sans-serif;
        border: 2px solid #FFF;
        font-size: 12px;
        box-shadow: 0px 0px 22px rgba(0, 0, 0, 0.07);
    }
</style>
<?php
$visible = "style='display:none;'";
if (isset($_COOKIE["cookie_1"]) && $_COOKIE["cookie_1"] != null || isset($_COOKIE["cookie_2"]) && $_COOKIE["cookie_2"] != null) {
    $visible = "style='display:block;'";
}
?>

<span class="compare-floating-btn " <?php echo($visible); ?>>
    <a href="<?php
    if (isset($carspot_theme['compare_ad_front'])) {
        echo esc_url(get_the_permalink($carspot_theme['compare_ad_front']));
    }
    ?>" class="protip" data-pt-title=" <?php echo esc_attr__('Compare Ads', 'carspot') ?>" data-pt-position="left"
       data-pt-scheme="dark-transparent" data-pt-size="small">
        <i class="fa fa-clone"></i>
    </a>
    <?php
    if (isset($_COOKIE["cookie_1"]) && isset($_COOKIE["cookie_2"])) {
        ?>
        <span class="badge"><?php echo esc_attr__('2', 'carspot') ?></span>
        <?php
    } else if (isset($_COOKIE["cookie_1"]) || isset($_COOKIE["cookie_2"])) {
        ?>
        <span class="badge"><?php echo esc_attr__('1', 'carspot') ?></span>
        <?php
    }
    ?>
</span>
<?php wp_footer(); ?>
</body>
</html>