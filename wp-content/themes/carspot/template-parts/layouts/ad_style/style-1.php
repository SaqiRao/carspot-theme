<?php
global $carspot_theme;
$time = get_post_meta(get_the_ID(), '_ad_time_key', true);
$min_bid = get_post_meta(get_the_ID(), 'ad_min_bid_key', true);
$dif_bid = get_post_meta(get_the_ID(), 'ad_dif_bid_key', true);
// $all_bid = get_post_meta(get_the_ID());
 //print_r($all_bid);
// echo "<br>";
// echo $min_bid;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$user_pic = carspot_get_user_dp($poster_id);
$address = get_post_meta($pid, '_carspot_ad_location', true);

$ribbon_html = '';
if (get_post_meta($pid, '_carspot_is_feature', true) == '1' && get_post_meta($pid, '_carspot_ad_status_', true) == 'active') {
    $ribbion = 'featured-ribbon';
    if (is_rtl()) {
        $ribbion = 'featured-ribbon-rtl';
    }
    $ribbon_html = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
}

$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
?>
    <div class="main-content-area clearfix">
        <section class="section-padding <?php echo carspot_returnEcho($top_padding); ?> gray">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <?php
                    if ($carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
                    } else {
                        get_template_part('template-parts/layouts/ad_style/short-summary', 'title');
                    }
                    ?>
                    <?php
                    if (isset($carspot_theme['ad_slider_type']) && $carspot_theme['ad_slider_type'] == 2) {
                        get_template_part('template-parts/layouts/ad_style/gallery', $carspot_theme['ad_slider_type']);
                    }
                    ?>
                    <?php
                    if (isset($carspot_theme['ad_slider_type']) && $carspot_theme['ad_slider_type'] == 4) {
                        ?>
                        <?php get_template_part('template-parts/layouts/ad_style/gallery', $carspot_theme['ad_slider_type']); ?>
                        <?php
                    }
                    ?>
                    <!-- Middle Content Area -->
                    <div class="col-md-8 col-xs-12 col-sm-12">
                        <!-- Single Ad -->
                        <div class="singlepage-detail">
                            <?php
                            get_template_part('template-parts/layouts/ad_style/feature', 'notification');
                            ?>
                            <?php
                            if (get_post_meta($pid, '_carspot_ad_status_', true) != "" && get_post_meta($pid, '_carspot_ad_status_', true) != 'active') {
                                ?>
                                <div role="alert" class="alert alert-info alert-outline alert-dismissible">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span
                                                aria-hidden="true">&#10005;</span></button>
                                    <strong><?php echo esc_html__('Info', 'carspot'); ?></strong> -
                                    <?php echo esc_html__('This ad has been', 'carspot') . " "; ?>
                                    <?php echo carspot_ad_statues(get_post_meta($pid, '_carspot_ad_status_', true)); ?>
                                    .
                                </div>
                                <?php
                            }
                            ?>
                            <div class="rebbon-clear">
                                <?php
                                if ($carspot_theme['ad_slider_type'] == 1 || $carspot_theme['ad_slider_type'] == 3) {
                                    echo($ribbon_html);
                                }
                                /* Listing Slider */
                                if (isset($carspot_theme['ad_slider_type']) && $carspot_theme['ad_slider_type'] == 1) {
                                    get_template_part('template-parts/layouts/ad_style/slider', $carspot_theme['ad_slider_type']);
                                }
                                ?>
                                <?php
                                if (isset($carspot_theme['ad_slider_type']) && $carspot_theme['ad_slider_type'] == 3) {
                                    get_template_part('template-parts/layouts/ad_style/gallery', $carspot_theme['ad_slider_type']);
                                }
                                ?>
                            </div>
                            <?php
                            get_template_part('template-parts/layouts/ad_style/key', 'features');
                            /* Short Description */
                            get_template_part('template-parts/layouts/ad_style/ad', 'detail');
                            ?>
                            <div class="clearfix"></div>
                            <?php if (isset($carspot_theme['style_ad_720_2']) && $carspot_theme['style_ad_720_2'] != "") { ?>
                                <div class="margin-top-30 margin-bottom-30">
                                    <?php echo "" . $carspot_theme['style_ad_720_2']; ?>
                                </div>
                            <?php } ?>
                            <?php
                            /* Share Ad report Ad */
                            get_template_part('template-parts/layouts/ad_style/ad', 'tabs');
                            ?>
                            <div class="clearfix"></div>
                            <?php
                            get_template_part('template-parts/layouts/ad_style/video', 'bidding');
                            ?>
                            <div class="clearfix"></div>
                        </div>
                        <?php get_template_part('template-parts/layouts/ad_style/related', 'ads'); ?>
                    </div>
                    <!--sidebar-->
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <?php if (is_active_sidebar('carspot_ad_sidebar_top')) { ?>
                            <?php dynamic_sidebar('carspot_ad_sidebar_top'); ?>
                        <?php } ?>
                        <div class="sidebar">
                            <?php
                            if (get_post_meta($pid, '_carspot_ad_status_', true) == 'expired') {
                                ?>
                                <div class="final_ad_status expired-out">
                                    <p><?php echo carspot_ad_statues(get_post_meta($pid, '_carspot_ad_status_', true)); ?></p>
                                </div>
                                <?php
                            } else if (get_post_meta($pid, '_carspot_ad_status_', true) == 'sold') {
                                ?>
                                <div class="final_ad_status sold-out">
                                    <?php echo carspot_ad_statues(get_post_meta($pid, '_carspot_ad_status_', true)); ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <!--review stamp logo-->
                                
                                <?php
                                if ($carspot_theme['enable_review_stamp'] == true) {
                                    $review_stamp_db = get_post_meta($pid, '_carspot_ad_review_stamp', true);
                                    if ($review_stamp_db != '') {
                                        $get_termID = get_term_by('name', $review_stamp_db, 'ad_review_stamp');
                                        if (!empty($get_termID)) {
                                            $term_logo_url = get_term_meta($get_termID->term_id, 'saved_review_logo_url', true);
                                            $rev_compny_url = get_term_meta($get_termID->term_id, 'review_company_url', true);
                                            $output_stamps = isset($review_stamp_db) ? $review_stamp_db : '';
                                            $vin_num_db = get_post_meta($pid, 'carspot_ad_vin_number', true);
                                            if ($output_stamps != '' && $vin_num_db && $term_logo_url != '') {
                                                ?>
                                                
                                                <div class="bid-info">
                                                    <?php
                                                    $final_url = str_replace("{{vin}}", $vin_num_db, $rev_compny_url);
                                                    ?>
                                                    <div class="small-box review-stamp  col-md-12 col-sm-12 col-xs-12">
                                                        <a href="<?php echo $final_url; ?>" target="_blank"><img
                                                                    src="<?php echo esc_url($term_logo_url); ?>"
                                                                    width="150px" height="150px"/></a>
                                                    </div>
                                                    <?php
                                                    ?>
                                               
                                                </div>
                                              
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                   <!--Starts Didding Timer-->
                                <?php 
                                if($carspot_theme['sb_enable_comments_offer']){
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
                                ?>
                                    <!--Ends Didding Timer-->
                                <!--End Review Stamp logo-->
                                <?php
                                if (isset($carspot_theme['allow_ad_economy']) && $carspot_theme['allow_ad_economy'] && (get_post_meta($pid, '_carspot_ad_avg_city', true) != '') && (get_post_meta($pid, '_carspot_ad_avg_hwy', true) != '')) {
                                    ?>
                                    <div class="fule-economy">
                                        <h4><?php echo esc_html__('Fuel Economy', 'carspot'); ?></h4>
                                        <ul class="list-inline">
                                            <li>
                                                <h5><?php echo esc_html(get_post_meta($pid, '_carspot_ad_avg_city', true)); ?></h5>
                                                <?php
                                                $avg_city = isset($carspot_theme['avg_city_title']) ? $carspot_theme['avg_city_title'] : esc_html__('City MPG', 'carspot');
                                                ?>
                                                <p> <?php echo $avg_city; ?></p>
                                            </li>
                                            <li>
                                                <h5><?php echo esc_html(get_post_meta($pid, '_carspot_ad_avg_hwy', true)); ?></h5>
                                                <?php
                                                $avg_highway = isset($carspot_theme['avg_highway_title']) ? $carspot_theme['avg_highway_title'] : esc_html__('Highway MPG', 'carspot');
                                                ?>
                                                <p> <?php echo $avg_highway; ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>


                                <?php
                                if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {
                                    ?>
                                    <div class="category-list-icon">
                                        <?php
                                        if (isset($carspot_theme['communication_icon_message']) && $carspot_theme['communication_icon_message'] != "") {
                                            echo '<i class="green ' . $carspot_theme['communication_icon_message'] . '"></i>';
                                        }
                                        ?>
                                        <div class="category-list-title">
                                            <!-- Email Button trigger modal -->
                                            <?php
                                            if (get_current_user_id() == "" ||  get_current_user_id() == 0) {
                                                ?>
                                                <h5>
                                                    <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_sign_in_page'])); ?>"><?php echo esc_html__('Contact Seller Via Email', 'carspot'); ?></a>
                                                </h5>
                                                <?php
                                            } else {
                                                ?>
                                                <h5><a href="javascript:void(0)" data-toggle="modal"
                                                    data-target=".price-quote"><?php echo esc_html__('Message Seller', 'carspot'); ?></a>
                                                </h5>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'phone') {
                                    ?>
                                    <div class="category-list-icon">
                                        <?php
                                        if (isset($carspot_theme['communication_icon_phone']) && $carspot_theme['communication_icon_phone'] != "") {
                                            echo '<i class="purple ' . $carspot_theme['communication_icon_phone'] . '"></i>';
                                        }
                                        ?>
                                        <div class="category-list-title">
                                            <h5>
                                            <a href="tel:<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>"
                                                class="number"
                                                data-last="<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>"><span><?php echo esc_html__('Click to View', 'carspot'); ?></span></a>
                                            </h5>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ///// WhatsApp Button Starts///SR//
                            $whatapp_icon    =  isset($carspot_theme['whatsapp_icon'])   ?  $carspot_theme['whatsapp_icon']   : "1";
                            if($whatapp_icon == 1){
                            ?>
                            <div class="stm_social_buttons_wrap  vc_custom_1641548377760">
		    	               <div class="whatsapp">
			                       <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr(strip_tags_content(get_post_meta($pid, '_carspot_poster_contact', true))); ?>"  target="_blank" class="external" rel="nofollow">
				                    <div class="whatsapp-btn heading-font " id="social_button_5879">
					                <i class="fa fa-whatsapp"></i>
				              	  <?php  	
                                    echo esc_html__('Chat via WhatsApp', 'carspot');
                                    ?>
                                 </div>
			                    </a>
		                     </div>
	                        </div>
                            <?php }
                            ///// WhatsApp Button Ends///SR//
                            ?>
                            
                            <?php if ($carspot_theme['make_offer_form_on'] || $carspot_theme['test_drive_form_on']) { ?>
                                <div class="additional-btns">
                                    <ul>
                                        <?php if ($carspot_theme['make_offer_form_on']) { ?>
                                            <li>
                                                <a href="" class="" data-toggle="modal" data-target="#make-offer-modal">
                                                    <i class="la la-money"></i>
                                                    <span><?php echo esc_html__('Make an Offer Price', 'carspot'); ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($carspot_theme['test_drive_form_on']) { ?>
                                            <li>
                                                <a href="" class="" data-toggle="modal" data-target="#test-drive-modal">
                                                    <i class="la la-support"></i>
                                                    <span> <?php echo esc_html__('Schedule Test Drive ', 'carspot'); ?> </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <!--PDF Brochure-->
    
                            <?php
                            if ($carspot_theme['pdf_brochure_section'] == true) {
                                ?>
                                <div class="additional-btns">
                                    <ul>
                                        <?php
                                        $brochure_file = get_post_meta($pid, 'carspot_pdf_brochure_arrangement_', true);
                                        $brochure_ids = (explode(",", $brochure_file));
                                        if (count($brochure_ids) > 0 && is_array($brochure_ids) && $brochure_ids[0] != "-1" && $brochure_ids[0] != '') {
                                            $mid = '';
                                            for ($i = 0; $i < count($brochure_ids); $i++) {
                                                $pdf_attributes = wp_get_attachment_url($brochure_ids[$i]);
                                                if ($pdf_attributes != '') {
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo esc_url($pdf_attributes); ?>"
                                                        target="_blank">
                                                        <i class="la la-file-pdf-o"></i>
                                                        <span><?php echo get_the_title($brochure_ids[$i]); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <!--End PDF brochure-->
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
                            <div class="white-bg ">
                                <div class="user-info-card">
                                    <div class="user-photo col-md-4 col-sm-3  col-xs-4">
                                        <a href="<?php echo esc_url(get_author_posts_url($poster_id)); ?>"
                                        class="link">
                                            <img class="img-circle" src="<?php echo esc_url($user_pic); ?>"
                                        alt="<?php echo esc_html__('Profile Pic', 'carspot'); ?>">
                                        </a>
                                    </div>
                                    <div class="user-information  col-md-8 col-sm-9 col-xs-8">
                                        <?php
                                        $poster_name = get_post_meta($pid, '_carspot_poster_name', true);
                                        if ($poster_name == "") {
                                            $user_info = get_userdata($poster_id);
                                            $poster_name = $user_info->display_name;
                                        }
                                        ?>
                                        <span class="user-name">
                                        <a class="hover-color"
                                        href="<?php echo esc_url(get_author_posts_url($poster_id)); ?>">
                                            <?php echo esc_html($poster_name); ?>
                                        </a>
                                    </span>
                                        <div class="item-date">
                                            <span class="ad-pub"><?php echo esc_html__('Logged in at', 'carspot') . ': ' . carspot_get_last_login($poster_id) . ' ' . esc_html__('Ago', 'carspot'); ?></span>
                                            <?php
                                            if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {
                                                echo avg_user_rating($poster_id) . ' (';
                                                echo carspot_dealer_review_count($poster_id) . ')';
                                            }
                                            ?>
                                            <?php
                                            if (get_user_meta($poster_id, '_sb_badge_type', true) != "" && get_user_meta($poster_id, '_sb_badge_text', true) != "" && isset($carspot_theme['sb_enable_user_badge']) && $carspot_theme['sb_enable_user_badge'] && $carspot_theme['sb_enable_user_badge']) {
                                                ?>
                                                <span class="label <?php echo esc_attr(get_user_meta($poster_id, '_sb_badge_type', true)); ?>">
                                                <?php echo esc_html(get_user_meta($poster_id, '_sb_badge_text', true)); ?>
                                            </span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php
                            $mapType = carspot_mapType();
                            if ($mapType != 'no_map') {
                                ?>
                                <div class="singlemap-location">
                                    <?php
                                    if (get_post_meta($pid, '_carspot_ad_map_location', true) != "") {
                                        ?>
                                        <div class="template-icons">
                                            <div class="icon-box-icon flaticon-location"></div>
                                            <div class="class-name"><?php echo esc_html(get_post_meta($pid, '_carspot_ad_map_location', true)); ?></div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
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
                            }
                            if (is_active_sidebar('carspot_ad_sidebar_bottom')) {
                                ?>
                                <?php dynamic_sidebar('carspot_ad_sidebar_bottom'); ?>
                            <?php } ?>
                            <!-- Saftey Tips  -->
                            <?php
                            if ($carspot_theme['tips_title'] != '' && $carspot_theme['tips_for_ad'] != "") {
                                ?>
                                <div class="widget">
                                    <div class="widget-heading">
                                        <h4 class="panel-title">
                                            <span><?php echo($carspot_theme['tips_title']); ?></span></h4>
                                    </div>
                                    <div class="widget-content saftey">
                                        <?php echo($carspot_theme['tips_for_ad']); ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php if ($carspot_theme['finacne_calc_on']) {
                                ?>
                                <div class="widget">
                                    <div class="widget-heading">
                                        <h4 class="panel-title">
                                            <span> <?php echo esc_html__('Financing Calculator', 'carspot'); ?></span>
                                        </h4>
                                    </div>
                                    <div class="widget-content ">
                                        <?php get_template_part('template-parts/layouts/ad_style/finance', 'calculator'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        //only for category based pricing
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
            //sticky action buttons
            get_template_part('template-parts/layouts/ad_style/sticky-buttons/sticky', 'buttons');
        }
        ?>
    </div>
<?php get_template_part('template-parts/layouts/ad_style/message', 'seller'); ?>