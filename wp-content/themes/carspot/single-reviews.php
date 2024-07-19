<?php
get_header();
global $carspot_theme;
$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
if (have_posts()) {
    $cols = '';
    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'no-sidebar') {
        $cols = 'col-md-12 col-xs-12 col-sm-12';
    } else {
        $cols = 'col-md-8 col-xs-12 col-sm-12';
    }
    while (have_posts()) {
        the_post();
        ?>
        <div class="main-content-area clearfix">
            <section class="section-padding <?php echo carspot_returnEcho($top_padding); ?> gray review-details ">
                <!-- Main Container -->
                <div class="container">
                    <!-- Row -->
                    <div class="row">
                        <?php
                        if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'left')
                            get_sidebar('reviews');
                        ?>
                        <!-- Middle Content Area -->
                        <div class="<?php echo esc_attr($cols); ?>">
                            <div class="blog-detial">
                                <!-- Blog Archive -->
                                <div class="blog-post">
                                    <?php
                                    $img = $responsel = '';
                                    $response = carspot_get_feature_image(get_the_ID(), 'carspot-single-post');
                                    $response1 = carspot_get_feature_image(get_the_ID(), '');
                                    if ($response != '') {
                                        if ($response[0] != "") {
                                            $img = $response[0];
                                            $responsel = $response[0];
                                        }
                                    } else {
                                        $img = $carspot_theme['review_related_image_large']['url'];
                                    }
                                    ?>
                                    <div class="post-img">
                                        <span class="badge text-uppercase badge-overlay badge-tech">
                                            <?php echo esc_html(get_queried_object()->name); ?></span>
                                        <a href="<?php echo str_replace('-760x410', '', $responsel); ?>"
                                           data-fancybox="group"> <img class="img-responsive large-img"
                                                                       alt="<?php echo esc_attr(get_queried_object()->name); ?>"
                                                                       src="<?php echo esc_url($img); ?>"> </a>
                                    </div>

                                    <div class="review-excerpt">
                                        <h3><?php echo esc_html__('Overview Of Car', 'carspot'); ?></h3>
                                        <?php the_excerpt(); ?>
                                        <?php
                                        if (function_exists('carspot_get_meta')) {
                                            echo carspot_get_meta();
                                        }
                                        ?>
                                        <div class="row pro-cons">
                                            <?php
                                            if (isset($post->tab_desc_1) && ($post->tab_heading) != '') {
                                                ?>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="pro-section">
                                                        <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/like.png' ?>"
                                                             alt="<?php echo esc_html__('Like', 'carspot'); ?>"/>
                                                        <h3><?php echo "" . ($post->tab_heading); ?></h3>
                                                        <?php echo "" . ($post->tab_desc_1); ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if (isset($post->tab_desc_2) && ($post->tab_heading_2) != '') {
                                                ?>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="cons-section">
                                                        <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/dislike.png' ?>"
                                                             alt="<?php echo esc_html__('Dislike', 'carspot'); ?>"/>
                                                        <h3><?php echo "" . ($post->tab_heading_2); ?></h3>
                                                        <?php echo "" . ($post->tab_desc_2); ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="entry-content post-excerpt post-desc">
                                            <?php echo(the_content());
                                            if (isset($post->youtube_video) && ($post->youtube_video) != '') {
                                                ?>
                                                <h3><?php echo esc_html__('Video Review', 'carspot'); ?></h3>
                                                <iframe src="https://www.youtube.com/embed/<?php echo "" . ($post->youtube_video); ?>"
                                                        allowfullscreen></iframe>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (has_post_format('gallery')) {
                                            ?>
                                            <h3><?php echo esc_html__('Related Gallery', 'carspot'); ?></h3>
                                            <ul class="gallery list-inline clearfix">
                                                <?php
                                                $gallery = get_post_gallery_images(get_the_ID());
                                                foreach ($gallery as $src) {
                                                    ?>
                                                    <li>
                                                        <a data-fancybox="gallery"
                                                           href="<?php echo esc_url(str_replace('-150x150', '', $src)); ?>">
                                                            <img src="<?php echo esc_url($src); ?>"
                                                                 alt="<?php echo esc_html__('Related Gallery', 'carspot'); ?>"/>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                        }
                                        ?>

                                        <div class="clearfix"></div>
                                        <br>
                                        <?php
                                        if (function_exists('carspot_get_meta_verdict')) {
                                            echo carspot_get_meta_verdict();
                                        }
                                        ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!-- Blog Grid -->
                            </div>
                        </div>
                        <!-- Right Sidebar -->
                        <!-- Right Sidebar -->
                        <?php
                        if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'right')
                            get_sidebar('reviews');
                        ?>
                        <!-- Middle Content Area  End -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Main Container End -->
            </section>
        </div>
        <?php
    }
} else {
    get_template_part('template-parts/content', 'none');
}
?>
<?php get_footer();