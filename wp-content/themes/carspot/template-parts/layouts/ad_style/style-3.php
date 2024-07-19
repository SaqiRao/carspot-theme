<?php
global $carspot_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$time = get_post_meta(get_the_ID(), '_ad_time_key', true);
/* ribbon if featured or not */
$ribbon_html = '';
if (get_post_meta($pid, '_carspot_is_feature', true) == '1' && get_post_meta($pid, '_carspot_ad_status_', true) == 'active') {
    $ribbon_html = '<img class="feturd" src="' . get_template_directory_uri() . '/images/layer-1095.png" alt="">';
}
/* Ad Condition */
$ad_condition = get_post_meta($pid, '_carspot_ad_condition', true);
$ad_condition = (isset($ad_condition) && $ad_condition != '') ? $ad_condition : '';
/* Ad Type */
$ad_type = get_post_meta($pid, '_carspot_ad_type', true);
$ad_type = (isset($ad_type) && $ad_type != '') ? $ad_type : '';
/* User DP */
$user_pic = carspot_get_user_dp($poster_id);
?>
    <!-- cp-singlepage-detail-start -->
    <section class="cp-singlepage-detail">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="porsche-ftd-car-dtl">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7">
                                <div class="left-cont">
                                    <div class="owl-carousel owl-theme cars-dtl-carousel">
                                        <?php get_template_part('template-parts/layouts/ad_style/gallery', '6'); ?>
                                    </div>
                                    <div class="extra-links outer-links">
                                        <?php
                                        if (isset($carspot_theme['share_ads_on']) && $carspot_theme['share_ads_on'] != "") {
                                            ?>
                                            <a href="javascript:void(0);" data-toggle="modal"
                                               data-target=".share-ads"><span class="iconify"
                                                                              data-icon="carbon:share"></span></a>
                                            <?php
                                        }
                                        ?>
                                        <a href="javascript:void(0);" data-target=".report-quote_"
                                           data-toggle="modal"><span class="iconify"
                                                                     data-icon="clarity:warning-standard-line"></span></a>

                                        <a href="javascript:void(0);" id="ad_to_fav"
                                           data-adid="<?php echo esc_attr(get_the_ID()); ?>"><input type="hidden"
                                                                                                    id="fav_ad_nonce"
                                                                                                    value="<?php echo wp_create_nonce('carspot_fav_ad_secure') ?>"/><span
                                                    class="iconify" data-icon="cil:heart"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5">
                                <div class="right-cont">
                                    <div class="top-btn">
                                        <a class="new" href="javascript:void(0)"><?php echo $ad_condition; ?></a>
                                        <a class="sell" href="javascript:void(0)"><?php echo $ad_type; ?></a>
                                    </div>
                                    <div class="title">
                                        <h5><?php echo esc_html(get_the_title()); ?></h5>
                                    </div>
                                    <div class="list-view">
                                        <div class="left">
                                            <span class="iconify" data-icon="flat-color-icons:clock"></span>
                                            <span><?php echo esc_html__("Listed on ", "carspot"); ?><?php echo carspot_get_date(get_the_ID()); ?></span>
                                        </div>
                                        <div class="right">
                                            <b><?php echo esc_html__("Views :", "carspot"); ?></b><span><?php echo carspot_getPostViews($pid); ?></span>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <?php
                                        if (get_post_meta($pid, '_carspot_ad_price_type', true) == "no_price" || (get_post_meta($pid, '_carspot_ad_price', true) == "" && get_post_meta($pid, '_carspot_ad_price_type', true) != "free" && get_post_meta($pid, '_carspot_ad_price_type', true) != "on_call")) {
                                        } else {
                                            ?>
                                            <h5><?php echo carspot_adPrice($pid); ?></h5>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="carspot-profile-dtl">
                                        <div class="profile">
                                            <div class="left-img">
                                                <a href="#"><img src="<?php echo esc_url($user_pic); ?>"
                                                                 alt="<?php echo esc_html__('Profile Picture', 'carspot'); ?>"
                                                                 width="100" height="100"></a>
                                            </div>
                                            <div class="right-meta">
                                                <div class="rating-reviews">
                                                    <?php
                                                    if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {
                                                        echo avg_user_rating($pid) . ' (';
                                                        echo esc_html__("Review ", "carspot") . carspot_dealer_review_count($pid) . ')';
                                                    }
                                                    ?>
                                                </div>
                                                <a href="<?php echo esc_url(get_author_posts_url($poster_id)); ?>">
                                                    <h4><?php echo get_the_author_meta('display_name', $poster_id); ?></h4>
                                                </a>
                                                <!--                                            <img class="check" src="images/layer-1099.png" alt="">-->
                                            </div>
                                        </div>
                                        <?php if (carspot_display_adLocation($pid) != "") { ?>
                                            <div class="location">
                                                <div class="left">
                                                    <span class="iconify" data-icon="entypo:location"></span>
                                                    <span class="style2-location"><?php echo carspot_display_adLocation($pid); ?></span>
                                                    -
                                                </div>
                                                <div class="right">
                                                    <a href="#map_location"><?php echo esc_html__("View on Map", "carspot"); ?></a>
                                                </div>
                                            </div>
                                        <?php }
                                        if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'phone') {
                                            ?>
                                           <div class="cell-number">
                                            <span class="iconify" data-icon="bx:bxs-phone-call"></span>
                                            <a href="tel:<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>"
                                                class="number"
                                                data-last="<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>"
                                                onclick="showPhoneNumber(event)">
                                                <span class="phone-num">8888*********</span>
                                                <strong><?php echo esc_html__("Click to View", "carspot"); ?></strong>
                                            </a>
                                        </div>
                                        <?php }
                                            $whatapp_icon    =  isset($carspot_theme['whatsapp_icon'])   ?  $carspot_theme['whatsapp_icon']   : "1";
                                            if($whatapp_icon == 1){
                                        ?>
                                        
                                        <div class="whatapp-style-3"> 
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i> 
                                                <span class=""><?php echo esc_html__('WhatsApp', 'carspot'); ?></span>
                                            </a>
                                            </div>
                                        
                                        <?php  } ?>
                                        <div class="offer-schedule-btn">
                                            <?php
                                             $make_offer_form    =  isset($carspot_theme['make_offer_form_on'])   ?  $carspot_theme['make_offer_form_on']   : "1";
                                             if($make_offer_form == 1){
                                            ?>
                                            <a class="offer-btn" href="#" data-toggle="modal"
                                                data-target="#make-offer-modal"><?php echo esc_html__("Make an Offer Price", "carspot"); ?></a>
                                            <?php  }
                                             $test_drive_form    =  isset($carspot_theme['test_drive_form_on'])   ?  $carspot_theme['test_drive_form_on']   : "1";
                                             if($test_drive_form == 1){
                                            ?> 
                                            <a class="schedule-btn" href="#" data-toggle="modal"
                                                data-target="#test-drive-modal"><?php echo esc_html__("Schedule Test Drive", "carspot"); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $ribbon_html; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                    <div class="desc-ftd">
                        <?php
                        get_template_part('template-parts/layouts/ad_style/ad', 'detail3');
                        ?>
                        <div class="ftd-links">
                            <?php
                            /* Social Links */
                            $fb = esc_url(get_user_meta($poster_id, '_sb_user_facebook', true));
                            $fb = (isset($fb) && $fb != '') ? $fb : '#';
                            $tw = esc_url(get_user_meta($poster_id, '_sb_user_twitter', true));
                            $tw = (isset($tw) && $tw != '') ? $tw : '#';
                            $lin = esc_url(get_user_meta($poster_id, '_sb_user_linkedin', true));
                            $lin = (isset($lin) && $lin != '') ? $lin : '#';
                            $yutube = esc_url(get_user_meta($poster_id, '_sb_user_youtube', true));
                            $yutube = (isset($yutube) && $yutube != '') ? $yutube : '#';
                            ?>
                            <ul>
                                <li>
                                    <a href="<?php echo $fb; ?>">
                                        <span class="iconify" data-icon="icomoon-free:facebook"></span> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $tw; ?>">
                                        <span class="iconify" data-icon="cib:twitter"></span> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $lin; ?>">
                                        <span class="iconify" data-icon="fontisto:linkedin"></span> LinkedIn
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $yutube; ?>">
                                        <span class="iconify" data-icon="cib:youtube"></span> Youtube
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php
                        get_template_part('template-parts/layouts/ad_style/car', 'features3');
                        ?>
                    </div>
                    <div class="desc-ftd">
                        <?php
                        $mapType = carspot_mapType();
                        if ($mapType != 'no_map') {
                            ?>
                            <div class="singlemap-location" id='map_location'>
                                <?php
                                if (get_post_meta($pid, '_carspot_ad_map_location', true) != "") {
                                    ?>
                                    <div class="template-icons">
                                        <div class="icon-box-icon flaticon-location"></div>
                                        <div class="class-name"><?php echo esc_html(get_post_meta($pid, '_carspot_ad_map_location', true)); ?></div>
                                    </div>
                                    <?php
                                }
                                if (get_post_meta($pid, '_carspot_ad_map_lat', true) != "" && get_post_meta($pid, '_carspot_ad_map_long', true) != "") {
                                    ?>
                                    <div id="itemMap"></div>
                                    <input type="hidden" id="lat"
                                            value="<?php echo esc_attr(get_post_meta($pid, '_carspot_ad_map_lat', true)); ?>"/>
                                    <input type="hidden" id="lon"
                                            value="<?php echo esc_attr(get_post_meta($pid, '_carspot_ad_map_long', true)); ?>"/>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <?php 
                    if ($carspot_theme['sb_enable_comments_offer'] == 1) { ?>
                    <div class="desc-ftd">
                    
                        <?php
                        if ($carspot_theme['sb_enable_comments_offer'] == 1) {
                            ?>
                            <div class="bidding-states" id="bidding-area">
                                <?php
                                if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_carspot_ad_status_', true) != 'sold' && get_post_meta($pid, '_carspot_ad_status_', true) != 'expired' && get_post_meta($pid, '_carspot_ad_price', true) != "0") {
                                    if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 1) {
                                        echo carspot_bidding_stats($pid);
                                    } else if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 0) {
                                    } else {
                                        echo carspot_bidding_stats($pid);
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_carspot_ad_status_', true) != 'sold' && get_post_meta($pid, '_carspot_ad_status_', true) != 'expired' && get_post_meta($pid, '_carspot_ad_price', true) != "0") {
                                if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 1) {
                                    get_template_part('template-parts/layouts/ad_style/video', 'bidding2');
                                } else if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 0) {
                                } else {
                                    get_template_part('template-parts/layouts/ad_style/video', 'bidding2');
                                }
                            }
                            ?>
                        <?php } ?>
                        <?php get_template_part('template-parts/layouts/ad_style/related', 'ads'); ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                    <?php
                    $user_info = get_userdata(get_current_user_id());
                    $user_name = isset($user_info->display_name) ? esc_attr($user_info->display_name) : '';
                    $user_email = isset($user_info->user_email) ? esc_attr($user_info->user_email) : '';
                    if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {
                    ?>
                    <div class="seller-message">
                        <div class="form-group">
                            <h5>Message Seller</h5>
                            <form id="send_message_pop">
                                <div class="input-field">
                                    <p><?php echo esc_html__('Your Name', 'carspot'); ?></p>
                                    <input class="form-control" name="name" readonly type="text"
                                        placeholder="<?php echo esc_html__('Your Name', 'carspot'); ?>"
                                        value="<?php echo($user_name); ?>">
                                </div>
                                <div class="input-field">
                                    <p><?php echo esc_html__('Your Email', 'carspot'); ?></p>
                                    <input class="form-control" readonly type="email" name="email"
                                        placeholder="<?php echo esc_html__('Email', 'carspot'); ?>"
                                        value="<?php echo $user_email; ?>">
                                </div>
                                <div class="input-field">
                                    <p><?php echo esc_html__('Message', 'carspot'); ?></p>
                                    <textarea id="sb_forest_message" class="txt-area"
                                            placeholder="<?php echo esc_html__('Type here...', 'carspot'); ?>"
                                            rows="4"
                                            data-parsley-error-message="<?php echo esc_html__('This field is required.', 'carspot'); ?>"></textarea>
                                </div>
                                <div class="botm-btn">
                                    <input type="hidden" name="ad_post_id" value="<?php echo esc_attr($pid); ?>"/>
                                    <input type="hidden" name="usr_id"
                                        value="<?php echo esc_attr(get_current_user_id()); ?>"/>
                                    <input type="hidden" name="msg_receiver_id" value="<?php echo($poster_id); ?>"/>
                                    <input type="hidden" id="message_nonce"
                                        value="<?php echo wp_create_nonce('carspot_message_secure'); ?>"/>
                                    <button type="submit" id="send_ad_message"
                                            class="btn btn-theme btn-block"><?php echo esc_html__('Request Info', 'carspot'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php  }
                     if ($carspot_theme['finacne_calc_on']) {  ?>
                    <div class="seller-message motgag-calc">
                        <div class="form-group">
                            <h5><?php echo esc_html__("Mortgage Calculater", "carspot"); ?></h5>
                            <?php get_template_part('template-parts/layouts/ad_style/finance', 'calculator'); ?>
                        </div>
                    </div>
                    <?php  }  ?>
                    <!--Starts Didding Timer-->
                    <?php 
                         if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer']) {
                             if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user']) {
                              if($carspot_theme['timer_bid_on'] == 1){
                                ?>
                                 <div class="clock" data-rand="714825182" data-date="<?php echo $time; ?>">
                                  <div class="bid-time-tilte"><h2><b>Bidding Time </b> </h2></div>
                                  <hr>
                                  <div class="column-time clock-days"><div class="bidding_timer days-714825182" id="days-714825182">57</div>
                                  <div class="text">Days</div></div><div class="column-time">
                                      <div class="bidding_timer hours-714825182" id="hours-714825182">07</div>
                                      <div class="text">Hrs</div>
                                    </div>
                                      <div class="column-time">
                                          <div class="bidding_timer minutes-714825182" id="minutes-714825182">27</div>
                                          <div class="text">Min</div>
                                        </div>
                                        <div class="column-time"><div class="bidding_timer seconds-714825182" id="seconds-714825182">26</div>
                                        <div class="text">Sec</div>
                                    </div>
                                </div>
                                <?php
                                  }
                                }
                            }
                         ?>
                     <!--Ends Didding Timer-->
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade report-quote_" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&#10005;</span><span
                                class="sr-only"><?php echo esc_html__('Close', 'carspot'); ?></span></button>
                    <h3 class="modal-title"><?php echo esc_html__('Why are you reporting this ad?', 'carspot'); ?></h3>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="finance_form" data-parsley-validate="">
                        <div class="skin-minimal">
                            <div class="form-group col-md-12 col-sm-12">
                                <ul class="list">
                                    <li>
                                        <select class="alerts" id="report_option">
                                            <?php
                                            $options = explode('|', $carspot_theme['report_options']);
                                            foreach ($options as $option) {
                                                ?>
                                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group  col-md-12 col-sm-12">
                            <label></label>
                            <textarea placeholder="<?php echo esc_html__('Write your comments.', 'carspot'); ?>"
                                    rows="3"
                                    class="form-control" id="report_comments"></textarea>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 margin-bottom-20 margin-top-20">
                            <input type="hidden" id="ad_id" value="<?php echo esc_attr($pid); ?>"/>
                            <button type="button" class="btn btn-theme btn-block"
                                    id="sb_mark_it"><?php echo esc_html__('Submit', 'carspot'); ?></button>
                            <input type="hidden" id="report_ad_nonce"
                                value="<?php echo wp_create_nonce('carspot_report_secure') ?>"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
if ($carspot_theme['share_ads_on']) {
    $flip_it = 'text-left';
    if (is_rtl()) {
        $flip_it = 'text-right';
    }
    ?>
    <div class="modal fade share-ads" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content <?php echo esc_attr($flip_it); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&#10005;</span><span
                                class="sr-only"><?php echo esc_html__('Close', 'carspot'); ?></span>
                    </button>
                    <h3 class="modal-title"><?php echo esc_html__('Share', 'carspot'); ?></h3>
                </div>
                <div class="modal-body <?php echo esc_attr($flip_it); ?>">
                    <div class="recent-ads">
                        <div class="recent-ads-list">
                            <div class="recent-ads-container">
                                <div class="recent-ads-list-image">
                                    <?php
                                    $media = carspot_fetch_listing_gallery($pid);
                                    $img = $carspot_theme['default_related_image']['url'];
                                    if (count((array)$media) > 0) {
                                        foreach ($media as $m) {
                                            $mid = '';
                                            if (isset($m->ID)) {
                                                $mid = $m->ID;
                                            } else {
                                                $mid = $m;
                                            }
                                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                            $img = isset($image[0]) ? $image[0] : '';
                                            break;
                                        }
                                        ?>
                                        <a href="javascript:void(0);" class="recent-ads-list-image-inner">
                                            <img src="<?php echo esc_url($img); ?>"
                                                alt="<?php echo esc_attr(get_the_title()); ?>">
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="recent-ads-list-content">
                                    <h3 class="recent-ads-list-title">
                                        <a href="javascript:void(0);"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="recent-ads-list-price">
                                        <?php echo carspot_adPrice($pid); ?>
                                    </div>
                                    <p><?php echo carspot_words_count(get_the_excerpt(get_the_ID()), 250); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><?php echo esc_html__('Link', 'carspot'); ?></h3>
                    <p><a href="javascript:void(0);"><?php the_permalink(); ?></a></p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <?php echo carspot_social_share(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php }