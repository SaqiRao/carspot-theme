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
if (isset($_GET['search_title']) && $_GET['search_title'] != "") {
    $title = $_GET['search_title'];

    $query_args = array(
        's' => $title,
        'author__in' => array($current_user),
        'post_type' => 'ad_post',
        'paged' => $paged,
        'post_status' => 'publish'
    );
    $query_args = carspot_wpml_show_all_posts_callback($query_args);
    $the_query = new WP_Query($query_args);
    $total_count = $the_query->found_posts;
} else {
// The Query
    $args2 = array(
        'author__in' => array($current_user),
        'post_type' => 'ad_post',
        'meta_query' => array(
            array(
                'key' => '_carspot_ad_status_',
                'value' => 'active',
                'compare' => '=',
            ),
        ),
        'paged' => $paged,
        'post_status' => 'publish'
    );
    $args2 = carspot_wpml_show_all_posts_callback($args2);
    $the_query = new WP_Query($args2);

    $total_count = $the_query->found_posts;
}
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title"> <?php echo esc_html__('Published', 'carspot') . ' <span>( ' . $total_count . ' )</span>'; ?></h3>
            <?php //$the_query->sb_post_views_count;   ?>
            <form class="form form-inline form-published-search" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" name="search_title" value="<?php echo esc_attr($title); ?>"
                           placeholder="<?php echo esc_html__('Search Inventory', 'carspot') ?>">
                    <input type="hidden" name="page-type" value="published-ads"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-theme"><?php echo esc_html__('Search', 'carspot') ?></button>
                </div>
                <?php echo cs_form_lang_field_callback(true) ?>
            </form>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table dashboard-table table-fit">
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
                                        $outer_html = '<a class="sasas" href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> ';
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
                                    <span class="ad-date"><i
                                                class="la la-calendar-o"></i> <?php echo esc_html($posted_date); ?></span>
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
                                                            <a href="javascript:void(0);" class="protip"> <i
                                                                        class="la la-edit"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="protip " href="javascript:void(0);"> <i
                                                                        class="la la-trash"></i></a>
                                                        </li>
                                                        <li class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                                                                        class="la la-ellipsis-v"></i></a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="javascript:void(0);"> <i
                                                                                class="la la-times-circle-o"></i> <?php echo esc_attr__('Mark Expired', 'carspot') ?></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="ad_status"> <i
                                                                                class="la la-power-off"></i> <?php echo esc_attr__('Mark Sold', 'carspot') ?></a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </span>
                                                <?php
                                            } else {
                                                ?>
                                                <ul class="nav navbar-nav">
                                                    <li>
                                                        <?php
                                                        $cs_post_ad_page = cs_language_page_id_callback($carspot_theme['sb_post_ad_page']);
                                                        $cs_post_ad_page_ = carspot_set_url_params_multi(get_the_permalink($cs_post_ad_page), array("id" => esc_attr($pid)));
                                                        ?>
                                                        <a href="<?php echo $cs_post_ad_page_; ?>"
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
                                                            <li data-val="expired"
                                                                data-adid="<?php echo esc_attr($pid); ?>">
                                                                <a href="javascript:void(0);"> <i
                                                                            class="la la-times-circle-o"></i> <?php echo esc_attr__('Mark Expired', 'carspot') ?></a>
                                                            </li>
                                                            <li data-val="sold"
                                                                data-adid="<?php echo esc_attr($pid); ?>">
                                                                <a href="javascript:void(0);" class="ad_status"
                                                                   data-adid="<?php echo esc_attr($pid); ?>"
                                                                   disabled> <i
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
                        //carspot_pagination_search( $the_query );
                        /* Restore original Post Data */
                        wp_reset_postdata();
                    } else {
                        ?>
                        <tr>
                            <td colspan="5"><h4> <?php echo esc_html__('no Inventory found', 'carspot') ?></h4></td>
                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>
            <?php carspot_pagination_search($the_query); ?>

        </div>
    </div>
</div>