<?php
global $carspot_theme;
$current_user_id = get_current_user_id();
$author_id = get_query_var('author');
$product_id = isset($carspot_theme['carspot_profile_badge']) ? $carspot_theme['carspot_profile_badge'] : '';
$badge_image = isset($carspot_theme['carspot_badge11-default-image']) ? $carspot_theme['carspot_badge11-default-image'] : '';



if ($author_id == "" && is_page_template('page-dealer-reviews.php') || is_page_template('page-inventory.php')) {
    $author_id = $_GET["user_id"];
}
$user_pic = carspot_get_dealer_logo($author_id);
$user_type = get_user_meta($author_id, '_sb_user_type', true);
?>

<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
    <aside class="sidebar transparen-listing-sidebar">
        <div class="contact-box">
                <?php 

                    $meta_value = get_user_meta($current_user_id, '_carspot_profile_badge', true);

                    // $check_badge = check_baged_user($product_id);
                    // if($check_badge)
                    if($meta_value)
                    {
                    ?>
                        <?php 
                        if(badge_validation($product_id,$current_user_id))
                        {
                            ?>
                            <div>
                                <img src="<?php echo $badge_image['url']?>" class="badge_image" height="100px" width="100px" style="display: block; margin-left: auto;"/>
                            </div>
                    <?php
                        }
                    }
                ?>
            <div class="contact-img">
                <img src="<?php echo esc_url($user_pic) ?>" class="img-responsive" alt="<?php echo esc_html__('Profile Picture', 'carspot') ?>">
            </div>
        </div>
        <div class="profile-widget">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1default" data-toggle="tab"><?php echo esc_html__('Detail', 'carspot') ?></a></li>
                        <?php if ($carspot_theme['sb_dealer_contact']) {
                            ?>
                            <li><a href="#tab2default" data-toggle="tab"><?php echo esc_html__('Contact', 'carspot') ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
                            <ul class="widget-listing-details">
                                <?php
                                if ($user_type == 'dealer') {
                                    ?>
                                    <li> 
                                        <span> <i class="la la-map-marker"></i></span> 
                                        <span> 
                                            <h4><?php echo esc_html__('Address', 'carspot') ?></h4>
                                            <?php echo strip_tags_content(get_user_meta($author_id, '_sb_address', true)); ?>
                                        </span> 
                                    </li>
                                <?php } ?>
                                <li> 
                                    <span> <i class="la la-mobile"></i></span> 
                                    <span>
                                        <h4><?php echo esc_html__('Contact Number', 'carspot') ?></h4> 
                                        <a  class="phonenumber" href="javascript:void(0)" ><?php
                                            if (get_user_meta($author_id, '_sb_contact', true) != "") {
                                                //echo strip_tags(get_user_meta($author_id, '_sb_contact', true));
                                                $contact_num = get_user_meta($author_id, '_sb_contact', true);
                                                echo strip_tags_content($contact_num);
                                            } else {
                                                echo esc_html__('Not available', 'carspot');
                                            }
                                            ?></a>
                                    </span>
                                </li>
                                <?php
                                if ($user_type == 'dealer') {
                                    ?>
                                    <li>
                                        <span> <i class="la la-globe"></i></span>
                                        <span> 
                                            <h4><?php echo esc_html__('Website', 'carspot') ?></h4> 
                                            <a target="_blank" href="<?php echo esc_url(get_user_meta($author_id, '_sb_user_web_url', true)); ?>"><?php echo esc_url(get_user_meta($author_id, '_sb_user_web_url', true)); ?></a>
                                        </span> 
                                    </li>
                                <?php } ?>
                            </ul>
                            <?php
                            if ($user_type == 'dealer') {
                                ?>
                                <ul class="social-media">
                                    <?php
                                    if (get_user_meta($author_id, '_sb_user_facebook', true) != '') {
                                        ?>
                                        <li><a target="_blank" href="<?php echo esc_url(strip_tags_content(get_user_meta($author_id, '_sb_user_facebook', true))); ?>"><i class="la la-facebook"></i></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (get_user_meta($author_id, '_sb_user_twitter', true) != '') {
                                        ?>
                                        <li><a target="_blank" href="<?php echo esc_url(get_user_meta($author_id, '_sb_user_twitter', true)); ?>"><i class="la la-twitter"></i></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (get_user_meta($author_id, '_sb_user_linkedin', true) != '') {
                                        ?>
                                        <li><a target="_blank" href="<?php echo esc_url(get_user_meta($author_id, '_sb_user_linkedin', true)); ?>"><i class="la la-linkedin"></i></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (get_user_meta($author_id, '_sb_user_youtube', true) != '') {
                                        ?>
                                        <li><a target="_blank" href="<?php echo esc_url(get_user_meta($author_id, '_sb_user_youtube', true)); ?>"><i class="la  la-youtube-play"></i></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            <?php } ?>
                        </div>
                        <?php
                        if ($carspot_theme['sb_dealer_contact']) {
                            ?>
                            <div class="tab-pane fade" id="tab2default">
                                <form  data-parsley-validate="" method="post" id="dealer-contact-form">
                                    <div class="form-group">
                                        <input placeholder="<?php echo esc_attr__('Full name', 'carspot') ?>" name="name" required="" class="form-control" type="text"  data-parsley-error-message="<?php echo esc_attr__('Please write your name', 'carspot'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="<?php echo esc_attr__('Email address', 'carspot') ?>" name="email" required="" class="form-control" type="email"  data-parsley-error-message="<?php echo esc_attr__('Correct email please', 'carspot'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="<?php echo esc_attr__('Phone number', 'carspot') ?>" name="phone"  data-parsley-type="number" required="" class="form-control" type="text" data-parsley-error-message="<?php echo esc_attr__('Provide your contact number', 'carspot'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <textarea cols="6" placeholder="<?php echo esc_attr__('Your message', 'carspot') ?>" required name="message" rows="6" class="form-control" data-parsley-error-message="<?php echo esc_attr__('Please write your message', 'carspot'); ?>"></textarea>
                                    </div>
                                    <?php if ($carspot_theme['google_api_key'] != "") { ?>
                                        <div class="form-group col-md-12  col-sm-12">
                                            <div class="g-recaptcha" name="dealer_review_captcha" data-sitekey="<?php echo esc_html($carspot_theme['google_api_key']); ?>" required></div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="ad_dealer_id" value="<?php echo esc_attr($author_id); ?>" />
                                    <input type="hidden" id="user_contact_nonce" value="<?php echo wp_create_nonce('carspot_user_contact_secure'); ?>"  />
                                    <input class="btn btn-theme" value="<?php echo esc_attr__('Send Message', 'carspot'); ?>" type="submit">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($user_type == 'dealer') {
            ?>
            <div>
                <?php
                $mapType = carspot_mapType();
                if ($mapType != 'no_map') {
                    ?>
                    <div class="singlemap-location">
                        <?php
                        if (get_user_meta($author_id, '_sb_user_address_lat', true) != "" && get_user_meta($author_id, '_sb_user_address_long', true) != "") {
                            ?> 
                            <div id="itemMap"></div>
                            <input type="hidden" id="lat" value="<?php echo esc_attr(get_user_meta($author_id, '_sb_user_address_lat', true)); ?>" />
                            <input type="hidden" id="lon" value="<?php echo esc_attr(get_user_meta($author_id, '_sb_user_address_long', true)); ?>" />
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
    </aside>
    <?php
    if (isset($carspot_theme['dealer_ad_320']) && $carspot_theme['dealer_ad_320'] != "") {
        ?>
        <div class="margin-top-30 margin-bottom-30">
            <?php echo "" . $carspot_theme['dealer_ad_320']; ?>
        </div>
    <?php }
    ?>
</div>