<?php global $carspot_theme;
$pid = get_the_ID();

$current_user = get_current_user_id();
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    /*This will occur if on front page.*/
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
global $wpdb;
$uid = get_current_user_id();
$rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$uid' AND meta_key LIKE '_sb_fav_id_%'");
$pids = array(0);
foreach ($rows as $row) {
    $pids[] = $row->meta_value;
}
$args = array(
    'post_type' => 'ad_post',
    'post__in' => $pids,
    'post_status' => 'publish',
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'date'
);
// The Query
$args = carspot_wpml_show_all_posts_callback($args);
$the_query = new WP_Query($args);

$total_count = $the_query->found_posts;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title"> <?php echo esc_html__('Favorite', 'carspot') . ' <span>( ' . $total_count . ' )</span>'; ?></h3>
        </div>
        <div class="panel-body">
            <table class="table dashboard-table table-fit table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th> <?php echo esc_html__('Detail', 'carspot') ?></th>
                    <th> <?php echo esc_html__('Category', 'carspot') ?></th>
                    <th> <?php echo esc_html__('Views', 'carspot') ?></th>
                    <th> <?php echo esc_html__('action', 'carspot') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                // The Loop
                $posted_date = '';
                if ($the_query->have_posts()) {
                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        $pid = get_the_ID();
                        $cats_html = carspot_display_cats($pid);
                        $posted_date = get_the_date(get_option('date_format'), $pid);
                        //echo '<li>' . get_the_title() . ''.get_the_ID().'</li>';
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
                                <a href="<?php echo get_correct_link_by_postID($pid); ?>">
                                        <span class="ad-title">
											<?php echo esc_html(get_the_title()); ?>
                                            <?php if (get_post_meta($pid, '_carspot_is_feature', true) == '1') { ?>
                                                <span class="is-ad-featured">
												<?php echo esc_html__('Featured', 'carspot'); ?>
												</span>
                                                <?php
                                            } ?>
                                        </span>

                                </a>
                                <span class="ad-date"> <i class="la la-calendar-o"></i>
                                    	<?php echo($posted_date); ?></span>
                            </td>
                            <td><span class="ad-cats">	<?php echo($cats_html); ?></span></td>
                            <td><?php echo carspot_getPostViews($pid); ?></td>
                            <td>
                                	<span class="ad-actions">
                                    	<ul class="nav navbar-nav">
                                        <li>
                                            <a class="protip remove_fav_ad"
                                               data-pt-title=" <?php echo esc_attr__('Remove from Fav', 'carspot') ?>"
                                               data-pt-position="top" data-pt-scheme="dark-transparent"
                                               data-pt-size="small" href="javascript:void(0);"
                                               data-adid="<?php echo esc_attr($pid); ?>"> <i
                                                        class="la la-trash"></i></a>
                                        </li>
                                        <input type="hidden" id="edit_post_nonce"
                                               value="<?php echo wp_create_nonce('carspot_edit_post_secure') ?>"/>
                         </ul>               
                                        
                                    </span>
                            </td>
                        </tr>
                        <?php
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                } else { ?>
                    <tr>
                        <td colspan="5"><h4> <?php echo esc_html__('no Inventory found', 'carspot') ?></h4></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php carspot_pagination_search($the_query); ?>
        </div>
    </div>
</div>