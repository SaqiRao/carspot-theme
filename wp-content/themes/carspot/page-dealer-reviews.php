<?php
/* Template Name: Dealer Reviews */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package carspot
 */
global $carspot_theme;
$author_id = $_GET["user_id"];
//$author_id = get_query_var( 'user_id' );
$author_detail = get_userdata($author_id);
if (isset($author_detail) && $author_detail != "") {
    $user_type = get_user_meta($author_id, '_sb_user_type', true);
    get_header();
    ?>
    <div class="main-content-area clearfix">
        <section class="section-padding pattern_dots">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12">
                        <!-- Row -->
                        <div class="row">
                            <div class="clearfix"></div>
                            <!-- Ads Archive -->
                            <div class="dealers-single-page">
                                <div class="col-md-8 col-xs-12 col-sm-8 col-lg-8">
                                    <div class="profile-title-box">
                                        <div class="profile-heading">
                                            <h2>
                                                <?php
                                                if (get_user_meta($author_id, '_sb_camp_name', true) != "") {
                                                    echo esc_html(get_user_meta($author_id, '_sb_camp_name', true));
                                                } else {
                                                    echo esc_html($author_detail->display_name);
                                                }
                                                ?>
                                                <?php
                                                if (get_user_meta($author_id, '_sb_badge_text', true) != "" && get_user_meta($author_id, '_sb_badge_type', true) != "") { ?>
                                                    <span class="label <?php echo esc_html(get_user_meta($author_id, '_sb_badge_type', true)); ?>">  <?php echo esc_html(get_user_meta($author_id, '_sb_badge_text', true)); ?></span>
                                                <?php } ?>
                                            </h2>
                                        </div>
                                        <div class="profile-meta">
                                            <ul>
                                                <li>
                                                    <i class="la la-certificate icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__('Ratings: ', 'carspot'); ?> </span>
                                                    <?php
                                                    if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {
                                                        echo avg_user_rating($author_id) . ' (';
                                                        echo carspot_dealer_review_count($author_id) . ')';
                                                    }
                                                    ?>
                                                </li>
                                                <li>
                                                    <i class="la la-calendar-o icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__('Member since: ', 'carspot'); ?> </span>
                                                    <?php echo date("F j, Y", strtotime($author_detail->user_registered)); ?>
                                                </li>
                                                <?php
                                                if ($user_type == 'dealer') {
                                                    ?>
                                                    <li>
                                                        <i class="la la-clock-o icon"></i>
                                                        <span class="profile-meta-title"><?php echo esc_html__('Working Hours: ', 'carspot'); ?> </span>
                                                        <?php echo esc_html(get_user_meta($author_id, '_sb_user_timings', true)); ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php get_template_part('template-parts/layouts/profile/rating'); ?>
                                </div>
                                <?php get_template_part('template-parts/layouts/profile/profile-simple-sidebar'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
    get_footer();
} else {
    wp_redirect(home_url());
}