<?php
global $carspot_theme;
$author_id = get_query_var('author');
if ($author_id == "" && is_page_template('page-dealer-reviews.php')) {
    $author_id = $_GET["user_id"];
}
if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) { ?>
    <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
        <div class="dealers-review-section">
            <h3 class="profile-heading">
                <?php
                if (isset($carspot_theme['sb_reviews_title']) && $carspot_theme['sb_reviews_title']) {
                    echo esc_html($carspot_theme['sb_reviews_title']);
                }
                ?>
            </h3>

            <?php get_template_part('template-parts/layouts/profile/all-ratings'); ?>
        </div>
        <?php
        if (is_user_logged_in()) {
            ?>
            <div class="review-form">
                <h3 class="profile-heading">
                    <?php
                    if (isset($carspot_theme['sb_write_reviews_title']) && $carspot_theme['sb_write_reviews_title']) {
                        echo esc_html($carspot_theme['sb_write_reviews_title']);
                    }
                    ?>
                </h3>
                <form action="" id="user_ratting_form" data-parsley-validate="" method="post">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <ul class="review-star-box">
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($carspot_theme['sb_first_rating_stars_title']) && $carspot_theme['sb_first_rating_stars_title']) {
                                                echo esc_html($carspot_theme['sb_first_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <div dir="lrt">
                                            <input name="rating_service" value="0" autocomplete="off" type="text"
                                                   data-show-clear="false" class="rating" data-min="0" data-max="5"
                                                   min="0" data-step="1" data-size="xs"
                                                   required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($carspot_theme['sb_second_rating_stars_title']) && $carspot_theme['sb_second_rating_stars_title']) {
                                                echo esc_html($carspot_theme['sb_second_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <input name="rating_process" autocomplete="off" value="0" type="text"
                                               data-show-clear="false" class="rating" data-min="0" data-max="5" min="0"
                                               data-step="1" data-size="xs"
                                               required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($carspot_theme['sb_third_rating_stars_title']) && $carspot_theme['sb_third_rating_stars_title']) {
                                                echo esc_html($carspot_theme['sb_third_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <input name="rating_selection" value="0" autocomplete="off" type="text"
                                               data-show-clear="false" class="rating" data-min="0" data-max="5" min="0"
                                               data-step="1" data-size="xs"
                                               required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo esc_html__('Review Title', 'carspot') ?></label>
                                <input class="form-control" type="text" name="review_title" required
                                       data-parsley-error-message="<?php echo esc_html__('Provide title', 'carspot') ?>"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo esc_html__('Will you Recommend this vandor?', 'carspot') ?></label>
                                <div class="recomamand-check">
                                    <input type="radio" name="rating_recommand" value="yes" class="icheck"
                                           checked><?php echo esc_html__('Yes', 'carspot') ?>
                                    <input type="radio" name="rating_recommand" value="no"
                                           class="icheck"><?php echo esc_html__('No', 'carspot') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label protip"><?php echo esc_html__('Your Review', 'carspot') ?></label>
                                <textarea name="review_message" class="form-control" cols="30" rows="10" required
                                          data-parsley-error-message="<?php echo esc_html__('write you review here', 'carspot') ?>"></textarea>
                            </div>
                        </div>
                        <?php
                        if ($carspot_theme['google_api_key'] != "") { ?>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" name="dealer_contact_captcha"
                                         data-sitekey="<?php echo esc_attr($carspot_theme['google_api_key']); ?>"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <input class="btn btn-theme <?php if (is_rtl()) { ?> pull-left <?php } else { ?> pull-right <?php } ?>"
                                       type="submit" value="<?php echo esc_html__('Submit Rating', 'carspot') ?>"/>
                                <input type="hidden" name="dealer_id" value="<?php echo esc_attr($author_id); ?>"/>
                                <input type="hidden" id="rating_nonce"
                                       value="<?php echo wp_create_nonce('carspot_rating_secure') ?>"/>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <?php
        } else { ?>
            <div class="alert custom-alert custom-alert-warning" role="alert">
                <div class="custom-alert_top-side">
                    <span class="alert-icon custom-alert_icon la la-info-circle"></span>
                    <div class="custom-alert_body">
                        <h6 class="custom-alert_heading">
                            <?php echo esc_html__('Login To Write A Review. ', 'carspot'); ?>
                        </h6>
                        <div class="custom-alert_content">
                            <?php echo esc_html__('Sorry, only login users are eligibale to post a review.. ', 'carspot'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php }
?>