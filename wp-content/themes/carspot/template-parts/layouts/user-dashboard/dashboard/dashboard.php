<?php
global $carspot_theme;
$current_user = get_current_user_id();

$pid = get_the_ID();
//$abc = wp_get_current_user();
$the_query = new WP_Query(
    array(
        'author__in' => array($current_user),
        'post_type' => 'ad_post',
        'meta_key' => 'sb_post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'posts_per_page' => 5,
    )
);

if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
    if (get_user_meta($current_user, '_sb_simple_ads', true) != '-1') {
        $free_ads = get_user_meta($current_user, '_sb_simple_ads', true);
    } else {
        $free_ads = esc_html__('Unlimited', 'carspot');
    }
    if (get_user_meta($current_user, '_carspot_expire_ads', true) != '-1') {
        $expiry = get_user_meta($current_user, '_carspot_expire_ads', true);
    } else {
        $expiry = __('Never', 'carspot');
    }
    if (get_user_meta($current_user, '_carspot_featured_ads', true) != '-1') {
        $featured_ads = get_user_meta($current_user, '_carspot_featured_ads', true);
    } else {
        $featured_ads = __('Unlimited', 'carspot');
    }

    if (get_user_meta($current_user, '_carspot_bump_ads', true) != '-1') {
        $bump_ads = get_user_meta($current_user, '_carspot_bump_ads', true);
    } else {
        $bump_ads = __('Unlimited', 'carspot');
    }

    $new_simple = '<dt><strong>' . __('Simple Ads ', 'carspot') . ' </strong></dt>
	<dd>
	   ' . $free_ads . '
	</dd>';

    $new_featureds = '<dt><strong>' . __('Feature Ads ', 'carspot') . ' </strong></dt>
		<dd>
		   ' . $featured_ads . '
		</dd>';

    $new_bumps = '<dt><strong>' . __('Bump-up Ads ', 'carspot') . ' </strong></dt>
		<dd>
		   ' . $bump_ads . '
		</dd>';
    $new_expiry = '<dt><strong>' . __('Package Expiry', 'carspot') . ' </strong></dt>
		<dd>
		   ' . $expiry . '
		</dd>';
}
?>

<div class="container-fluid">
    <!-- OVERVIEW -->
   
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Dashboard Overview', 'carspot'); ?> </h3>
                    <p class="panel-subtitle"><?php
                        echo esc_html__('Last logged in ', 'carspot');
                        echo carspot_get_last_login($current_user);
                        echo esc_html__(' Ago', 'carspot');
                        ?></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-star"></i></span>
                                <p>
                                    <span class="title"><?php echo esc_html__('Featured Posts', 'carspot'); ?></span>
                                    <span class="number"><?php echo esc_html(get_post_total_count($current_user, 'active', 'featured')); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-tasks"></i></span>
                                <p>
                                    <span class="title"><?php echo esc_html__('Active', 'carspot'); ?></span>
                                    <span class="number"><?php echo esc_html(get_post_total_count($current_user, 'active', '')); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-warning"></i></span>
                                <p>
                                    <span class="title"><?php echo esc_html__('Expired', 'carspot'); ?></span>
                                    <span class="number"><?php echo esc_html(get_post_total_count($current_user, 'expired', '')); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                <p>
                                    <span class="title"><?php echo esc_html__('Sold', 'carspot'); ?></span>
                                    <span class="number"><?php echo esc_html(get_post_total_count($current_user, 'sold', '')); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel  panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Most Viewed Posts', 'carspot') ?></h3>
                    <a href="<?php echo esc_url(get_the_permalink()); ?>?page-type=published-ads"
                       class=""> <?php echo esc_html__('View All Posts', 'carspot') ?></a>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table dashboard-table table-fit table-striped">
                        <!--<thead>
                            <tr>
                                <th></th>
                                <th> <?php echo esc_html__('detail', 'carspot') ?></th>
                                <th> <?php echo esc_html__('Views', 'carspot') ?></th>
                            </tr>
                        </thead>-->
                        <tbody>
                        <?php
                        $posted_date = '';
                        if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $pid = get_the_ID();
                                $cats_html = carspot_display_cats($pid);
                                $posted_date = get_the_date(get_option('date_format'), $pid);
                                $outer_html = '';
                                $media = carspot_fetch_listing_gallery($pid);
                                if (count((array)$media) > 0) {
                                    $counting = 1;
                                    foreach ($media as $m) {
                                        if ($counting > 1)
                                            break;

                                        $mid = '';
                                        if (isset($m->ID)) {
                                            $mid = $m->ID;
                                        } else {
                                            $mid = $m;
                                        }
                                        $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                        if (wp_attachment_is_image($mid)) {
                                            $outer_html = '<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> ';
                                        } else {
                                            $outer_html = '<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> ';
                                        }
                                        $counting++;
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                            <span class="ad-image">
                                                <?php echo($outer_html); ?>
                                            </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <span class="ad-title">
                                                    <?php echo esc_html(get_the_title()); ?>
                                                    <?php if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                                                        ?>
                                                        <span class="is-ad-featured"> 
                                                            <?php echo esc_html__('Featured', 'carspot'); ?>
                                                        </span>
                                                    <?php }
                                                    ?>
                                                </span>

                                        </a>
                                        <span class="ad-date"> <i
                                                    class="la la-calendar-o"></i> <?php echo esc_html($posted_date); ?></span>
                                    </td>
                                    <td><?php echo carspot_getPostViews($pid); ?></td>
                                </tr>
                                <?php
                            }
                            //carspot_pagination_search( $the_query );
                            /* Restore original Post Data */
                            wp_reset_postdata();
                        } else {
                            ?>
                            <tr>
                                <td colspan="5"><h4> <?php echo esc_html__('No Inventory Found', 'carspot') ?></h4></td>
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {
                ?>
                <div class="panel  panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo esc_html__('Most Recent Reviews', 'carspot') ?></h3>
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?page-type=my_ratings"
                           class=""> <?php echo esc_html__('View All Reviews', 'carspot') ?></a>

                    </div>
                    <div class="panel-body">
                        <?php
                        //echo " Review Limit = ".$limit;
                        $args = array(
                            'user_id' => $current_user,
                            'type' => 'dealer_review',
                            'order' => 'DESC',
                            'number' => '3',
                        );

                        $get_rating = get_comments($args);

                        if (count((array)$get_rating) > 0) {
                            ?>
                            <div class="profile-review-section">
                                <?php
                                foreach ($get_rating as $get_ratings) {
                                    $comment_ids = $get_ratings->comment_ID;

                                    $service_stars = get_comment_meta($comment_ids, '_rating_service', true);
                                    $process_stars = get_comment_meta($comment_ids, '_rating_proces', true);
                                    $selection_stars = get_comment_meta($comment_ids, '_rating_selection', true);

                                    $single_avg = 0;
                                    $total_stars = $service_stars + $process_stars + $selection_stars;
                                    $single_avg = round($total_stars / "3", 1);
                                    //echo  $single_avg;
                                    ?>
                                    <div class="review-box">
                                        <div class="main-review">
                                            <div class="review-avg-rating">
                                                <span> <?php echo $single_avg ?></span>
                                                <ul class="">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $single_avg)
                                                            echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                                                        else
                                                            echo '<li class="star"><i class="fa fa-star"></i></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="review-content-box">
                                                <div class="review-content-meta">
                                                    <div class="review-author-name">
                                                        <h4><?php echo esc_html(get_comment_meta($comment_ids, '_rating_title', true)); ?></h4>
                                                    </div>
                                                    <div class="review-text-box">
                                                        <p><?php echo esc_html($get_ratings->comment_content); ?></p>
                                                    </div>
                                                    <div class="review-date">
                                                        <span class="user-profile">
                                                            <a href="<?php echo esc_url(get_author_posts_url($get_ratings->comment_post_ID)); ?>">
                                                                <?php
                                                                $comment_poster = get_userdata($get_ratings->comment_post_ID);
                                                                $comment_poster = (isset($comment_poster->display_name) && $comment_poster->display_name != '') ? $comment_poster->display_name : '';
                                                                echo esc_html($comment_poster);
                                                                ?>
                                                            </a> <?php echo esc_html__('has', 'carspot'); ?>
                                                            <span class="recommend">
                                                                <?php
                                                                $recomment = get_comment_meta($comment_ids, '_rating_recommand', true);
                                                                if ($recomment == 'yes') {
                                                                    echo esc_html__('Recommended', 'carspot');
                                                                } else {
                                                                    echo esc_html__('Not Recommended', 'carspot');
                                                                }
                                                                ?> 
                                                            </span> <?php echo esc_html__('this vendor on', 'carspot'); ?>
                                                        </span>
                                                        <span><?php echo date(get_option('date_format'), strtotime($get_ratings->comment_date)); ?></span>
                                                    </div>
                                                </div>
                                                <div class="rating-stars-box">
                                                    <div class="rating-stars">
                                                        <label>
                                                            <?php
                                                            if (isset($carspot_theme['sb_first_rating_stars_title']) && $carspot_theme['sb_first_rating_stars_title']) {
                                                                echo esc_html($carspot_theme['sb_first_rating_stars_title']);
                                                            }
                                                            ?>
                                                        </label>
                                                        <ul>
                                                            <?php
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $service_stars)
                                                                    echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                                                                else
                                                                    echo '<li class="star"><i class="fa fa-star"></i></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="rating-stars">
                                                        <label>
                                                            <?php
                                                            if (isset($carspot_theme['sb_second_rating_stars_title']) && $carspot_theme['sb_second_rating_stars_title']) {
                                                                echo esc_html($carspot_theme['sb_second_rating_stars_title']);
                                                            }
                                                            ?>
                                                        </label>
                                                        <ul>
                                                            <?php
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $process_stars)
                                                                    echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                                                                else
                                                                    echo '<li class="star"><i class="fa fa-star"></i></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="rating-stars">
                                                        <label>
                                                            <?php
                                                            if (isset($carspot_theme['sb_third_rating_stars_title']) && $carspot_theme['sb_third_rating_stars_title']) {
                                                                echo esc_html($carspot_theme['sb_third_rating_stars_title']);
                                                            }
                                                            ?>
                                                        </label>
                                                        <ul>
                                                            <?php
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $selection_stars)
                                                                    echo '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                                                                else
                                                                    echo '<li class="star"><i class="fa fa-star"></i></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert custom-alert custom-alert-info" role="alert">
                                <div class="custom-alert_top-side">
                                    <span class="alert-icon custom-alert_icon la la-info-circle"></span>
                                    <div class="custom-alert_body">
                                        <h6 class="custom-alert_heading">
                                            <?php echo esc_html__('No Review Available. ', 'carspot'); ?>
                                        </h6>
                                        <div class="custom-alert_content">
                                            <?php
                                            echo esc_html__('Your reviews will be visible here. ', 'carspot');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="col-md-4">
            <?php
            if ($carspot_theme['dash_notif_title'] != "" && $carspot_theme['dash_notif_desc']) {
                ?>
                <div class="panel  panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo esc_html($carspot_theme['dash_notif_title']); ?></h3>
                    </div>
                    <div class="panel-body">
                        <p><?php echo wp_kses($carspot_theme['dash_notif_desc'], carspot_required_tags()); ?> </p>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
                ?>
                <div class="panel  panel-headline colored-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo esc_html__('Package Details', 'carspot') ?></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="profile-details">
                            <li>
                                <i class="la la-plus"></i>
                                <div class="profile-meta">
                                    <h6><?php echo esc_html__('Simple Ads', 'carspot') ?></h6>
                                    <span><?php echo esc_html($free_ads); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="la la-star"></i>
                                <div class="profile-meta">
                                    <h6> <?php echo esc_html__('Featured Ads', 'carspot') ?></h6>
                                    <span><?php echo esc_html($featured_ads); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="la la-retweet"></i>
                                <div class="profile-meta">
                                    <h6><?php echo esc_html__('Bump up Ads', 'carspot') ?></h6>
                                    <span><?php echo esc_html($bump_ads); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="la la-calendar"></i>
                                <div class="profile-meta">
                                    <h6><?php echo esc_html__('Package Expiry date', 'carspot') ?></h6>
                                    <span>
                                        <?php
                                        $curr_date = strtotime(date("F j, Y"));
                                        $expiry_date = strtotime($expiry);
                                        if ($expiry == __('Never', 'carspot') || $expiry == '-1') {
                                            echo esc_html__('Never Expire', 'carspot');
                                        } else if ($curr_date > $expiry_date) {
                                            echo esc_html__('Package Expired ', 'carspot');
                                        } else {
                                            //echo date("F jS, Y", strtotime($expiry));
                                            echo date_i18n(get_option('date_format'), strtotime($expiry), false);
                                        }
                                        ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>