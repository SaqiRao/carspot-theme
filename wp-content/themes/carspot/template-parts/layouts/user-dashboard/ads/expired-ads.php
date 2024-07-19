<?php
global $carspot_theme;
$pid = get_the_ID();

$current_user = get_current_user_id();
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    /* This will occur if on front page. */
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
// The Query
$query_ = array(
    'author__in' => array($current_user),
    'post_type' => 'ad_post',
    'meta_query' => array(
        array(
            'key' => '_carspot_ad_status_',
            'value' => 'expired',
            'compare' => '=',
        ),
    ),
    'paged' => $paged,
    'post_status' => 'publish'
);
$query_ = carspot_wpml_show_all_posts_callback($query_);
$the_query = new WP_Query($query_);

$total_count = $the_query->found_posts;
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title"> <?php echo esc_html__('Expired', 'carspot') . ' <span>( ' . $total_count . ' )</span>'; ?></h3>
        </div>
        <div class="panel-body">
            <table class="table dashboard-table table-fit table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th> <?php echo esc_html__('detail', 'carspot') ?></th>
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
                                            <?php if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                                                ?>
                                                <span class="is-ad-featured"> 
                                                    <?php echo esc_html__('Featured', 'carspot'); ?>
                                                </span>
                                            <?php }
                                            ?>
                                        </span>

                                </a>
                                <span class="ad-date"> <i class="la la-calendar-o"></i>
                                        <?php echo esc_html($posted_date); ?></span>
                            </td>
                            <td><span class="ad-cats">	<?php echo($cats_html); ?></span></td>
                            <td><?php echo carspot_getPostViews($pid); ?></td>
                            <td>
                                    <span class="ad-actions">
                                        <?php
                                        if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                                            ?>
                                            <span class="tooltip-disabled" data-toggle="tooltip"
                                                  title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                                <ul class="nav navbar-nav">
                                                    <li>
                                                        <a href="javascript:void(0);" class="protip""> <i
                                                                class="la la-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="protip" href="javascript:void(0);"> <i
                                                                    class="la la-trash"></i></a>
                                                    </li>
                                                    <a class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                                                                    class="la la-ellipsis-v"></i></a>
                                                        <ul class="dropdown-menu">
                                                            <li data-val="active">
                                                                <a href="javascript:void(0);"> <i
                                                                            class="la la-exclamation-triangle"></i> <?php echo esc_attr__('Mark Active', 'carspot') ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);"> <i
                                                                            class="la la-power-off"></i> <?php echo esc_attr__('Mark Sold', 'carspot') ?></a>
                                                            </li>
                                                        </ul>
                                        </a>
                                                </ul>  
                                            </span>
                                            <?php
                                        } else {
                                            ?>
                                            <ul class="nav navbar-nav">
                                                <li>
                                                    <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_post_ad_page'])); ?>?id=<?php echo esc_attr($pid); ?>"
                                                       class="protip"
                                                       data-pt-title=" <?php echo esc_attr__('Edit Ad', 'carspot') ?>"
                                                       data-pt-position="top" data-pt-scheme="dark-transparent"
                                                       data-pt-size="small"> <i class="la la-edit"></i></a>
                                                </li>
                                                <li>
                                                    <a class="protip delete_ad"
                                                       data-pt-title=" <?php echo esc_attr__('Delete Ad', 'carspot') ?>"
                                                       data-pt-position="top" data-pt-scheme="dark-transparent"
                                                       data-pt-size="small" href="javascript:void(0);"
                                                       data-adid="<?php echo esc_attr($pid); ?>"> <i
                                                                class="la la-trash"></i></a>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                                                                class="la la-ellipsis-v"></i></a>
                                                    <ul class="dropdown-menu ad_status_new">
                                                        <li data-val="active" data-adid="<?php echo esc_attr($pid); ?>">
                                                            <a href="javascript:void(0);"> <i
                                                                        class="la la-exclamation-triangle"></i> <?php echo esc_attr__('Mark Active', 'carspot') ?></a>
                                                        </li>
                                                        <li data-val="sold" data-adid="<?php echo esc_attr($pid); ?>">
                                                            <a href="javascript:void(0);" class="ad_status"
                                                               data-adid="<?php echo esc_attr($pid); ?>"> <i
                                                                        class="la la-power-off"></i> <?php echo esc_attr__('Mark Sold', 'carspot') ?></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <input type="hidden" id="edit_post_nonce"
                                                   value="<?php echo wp_create_nonce('carspot_edit_post_secure') ?>"/>
                                            <?php
                                        }
                                        ?>
                                    </span>
                            </td>
                        </tr>
                        <?php
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                } else {
                    ?>
                    <tr>
                        <td colspan="5"><h4> <?php echo esc_html__('No Inventory found', 'carspot') ?></h4></td>
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
