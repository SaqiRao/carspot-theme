<?php
global $carspot_theme;
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$user_pic = carspot_get_dealer_logo($current_user_id);
/* COUNT FAV POSTS */
global $wpdb;
$rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$current_user_id' AND meta_key LIKE '_sb_fav_id_%'");
$pids = array(0);
foreach ($rows as $row) {
    $pids[] = $row->meta_value;
}
$args = array(
    'post_type' => 'ad_post',
    'post__in' => $pids,
    'post_status' => 'publish',
);
// The Query
$the_query = new WP_Query($args);

$total_count = $the_query->found_posts;


//$page_type  = (isset($_GET['page-type'])) ? $_GET['page-type'] : '';
if (isset($_GET['page-type'])) {
    ?>
    <!-- LEFT SIDEBAR -->

    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li class="welcome-text"><img src="<?php echo esc_url($user_pic) ?>" class="img-responsive"
                                                  alt="<?php echo esc_html__('Profile Picture', 'carspot') ?>">
                        <div class="text-box">
                            <?php
                            //echo esc_html__( 'Welcome back', 'carspot' );
                            if (isset($carspot_theme['welcome_text']) && $carspot_theme['welcome_text'] != "") {
                                echo $carspot_theme['welcome_text'];
                            }
                            ?>
                            <span><?php echo esc_html($current_user->display_name); ?> </span></div>
                    </li>
                    <?php
                    $menu_items = $carspot_theme['menu_sortable'];

                    foreach ($menu_items as $menu_item => $menu_name) {
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'Home Page') {
                            ?>
                            <li><a href="<?php echo esc_url(get_home_url()); ?>"><i class="la la-reply"></i>
                                    <span><?php echo($menu_name); ?></span></a>
                            </li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'Dashboard') {
                            $carspot_update_url = '';
                            $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'dashboard'));
                            ?>
                            <li><a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                   class="<?php
                                   if ($_GET['page-type'] == "dashboard") {
                                       echo "active";
                                   }
                                   ?>"><i class="la la-home"></i> <span><?php echo($menu_name); ?></span></a>
                            </li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'Edit profile') {
                            $carspot_update_url = '';
                            $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'edit-profile'));
                            ?>
                            <li><a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                   class="<?php
                                   if ($_GET['page-type'] == "edit-profile") {
                                       echo "active";
                                   }
                                   ?>"><i class="la la-pencil"></i> <span><?php echo($menu_name); ?></span></a>
                            </li>
                            <?php
                        }

                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'My Profile') {
                            ?>
                            <li><a href="<?php echo esc_url(get_author_posts_url($current_user_id)); ?> "><i
                                            class="la la-user"></i> <span><?php echo esc_html($menu_name); ?></span></a>
                            </li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'My Messages') {
                            $carspot_update_url = '';
                            $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'my-messages'));
                            ?>
                            <li><a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                   class="<?php
                                   if ($_GET['page-type'] == "my-messages") {
                                       echo "active";
                                   }
                                   ?>"><i class="la la-envelope"></i> <span><?php echo($menu_name); ?></span></a></li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'My Inventory') {
                            ?>
                            <li><a href="#subPages" class="<?php
                                if ($_GET['page-type'] == "published-ads" || $_GET['page-type'] == "expired-ads" || $_GET['page-type'] == "sold-ads" || $_GET['page-type'] == "fav-ads") {
                                    echo "active";
                                } else {
                                    echo "collapsed";
                                }
                                ?>" data-toggle="collapse" class="collapsed"><i class="la la-tasks"></i>
                                    <span><?php echo esc_html($menu_name); ?></span> <i
                                            class="icon-submenu la la-chevron-left"></i></a>
                                <div id="subPages" class="collapse <?php
                                if ($_GET['page-type'] == "published-ads" || $_GET['page-type'] == "expired-ads" || $_GET['page-type'] == "sold-ads" || $_GET['page-type'] == "fav-ads" || $_GET['page-type'] == "pending-ads") {
                                    echo "in";
                                }
                                ?>">
                                    <ul class="nav">
                                        <?php
                                        $carspot_update_url = '';
                                        $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'published-ads'));
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                               class="">
                                                <?php echo esc_html__('Published', 'carspot') ?>
                                                <span class="badge">
                                                    <?php echo(get_post_total_count($current_user_id, 'active', '')); ?>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                        $carspot_update_url = '';
                                        $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'expired-ads'));
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                               class="">
                                                <?php echo esc_html__('Expired', 'carspot') ?>
                                                <span class="badge">
                                                    <?php echo(get_post_total_count($current_user_id, 'expired', '')); ?>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                        $carspot_update_url = '';
                                        $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'sold-ads'));
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                               class="">
                                                <?php echo esc_html__('Sold', 'carspot') ?>
                                                <span class="badge">
                                                    <?php echo(get_post_total_count($current_user_id, 'sold', '')); ?>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                        $carspot_update_url = '';
                                        $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'pending-ads'));
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                               class="">
                                                <?php echo esc_html__('Pending', 'carspot') ?>
                                                <span class="badge">
                                                    <?php echo carspot_get_disbale_ads($current_user_id); ?>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                        $carspot_update_url = '';
                                        $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'fav-ads'));
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                               class="">
                                                <?php echo esc_html__('Saved', 'carspot') ?>
                                                <span class="badge">
                                                    <?php echo esc_html($total_count); ?>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'My Ratings') {
                            $carspot_update_url = '';
                            $carspot_update_url = carspot_set_url_params_multi(get_the_permalink(), array('page-type' => 'my_ratings'));
                            ?>
                            <li><a href="<?php echo esc_url(cs_page_lang_url_callback($carspot_update_url)); ?>"
                                   class="<?php
                                   if ($_GET['page-type'] == "my_ratings") {
                                       echo "active";
                                   }
                                   ?>"><i class="la la-star"></i> <span><?php echo esc_html($menu_name); ?> </span></a>
                            </li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'My Orders') {
                            ?>
                            <li><a href="<?php echo esc_url(get_home_url()); ?>/my-account/orders/" target="_blank"><i
                                            class="la la-check-circle-o"></i>
                                    <span> <?php echo esc_html($menu_name); ?></span></a></li>
                            <?php
                        }
                        if (isset($menu_name) && $menu_name != '' && $menu_item == 'Logout') {
                            ?>
                            <li>
                                <a href="<?php echo wp_logout_url(get_the_permalink($carspot_theme['sb_sign_in_page'])); ?>"
                                   class=""><i class="fa fa-sign-out"></i>
                                    <span><?php echo esc_html($menu_name); ?></span></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <?php
} else {
    $url = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=dashboard';
    wp_redirect($url);
}
?>