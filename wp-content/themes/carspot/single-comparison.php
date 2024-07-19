<?php
get_header();
global $carspot_theme;
$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $comparison_id = get_the_ID();
        ?>
        <div class="main-content-area clearfix">
            <section class="section-padding <?php echo carspot_returnEcho($top_padding); ?> gray ">
                <!-- Main Container -->
                <div class="container">
                    <!-- Row -->
                    <div class="row">
                        <!-- Left Sidebar -->
                        <?php
                        if ($carspot_theme['blog_sidebar'] == 'left')
                            get_sidebar();
                        ?>
                        <div class="col-md-8 col-xs-12 col-sm-12">
                            <div class="single-blog blog-detial">
                                <!-- Blog Archive -->
                                <div class="blog-post">
                                    <?php
                                    $no_img = 'no-img';
                                    $response = carspot_get_feature_image($comparison_id, 'carspot-single-post');
                                    if (isset($response[0]) && $response[0] != "") {
                                        $no_img = '';
                                        ?>
                                        <div class="post-img">
                                            <a href="<?php echo esc_url($response[0]); ?>" data-fancybox>
                                                <img class="img-responsive" src="<?php echo esc_url($response[0]); ?>"
                                                     alt="<?php the_title(); ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="post-info <?php echo esc_attr($no_img); ?>">
                                        <a href="javascript:void(0);"><?php echo carspot_get_date(get_the_ID()); ?></a>
                                        <a href="javascript:void(0);"><?php echo carspot_get_comments(); ?></a>
                                    </div>
                                    <h3 class="post-title">
                                        <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
                                    </h3>
                                    <div class="post-excerpt post-desc">
                                        <?php the_content(); ?>
                                        <div class="col-md-12 add-pages">
                                            <?php
                                            $args = array(
                                                'before' => '',
                                                'after' => '',
                                                'link_before' => '<span class="btn btn-default">',
                                                'link_after' => '</span>',
                                                'next_or_number' => 'number',
                                                'separator' => ' ',
                                                'nextpagelink' => esc_html__('Next >>', 'carspot'),
                                                'previouspagelink' => esc_html__('<< Prev', 'carspot'),
                                                'highlight' => 'iAmActive'
                                            );
                                            wp_link_pages($args);
                                            ?>
                                        </div>
                                        <?php
                                        $posttags = get_the_tags();
                                        $count = 0;
                                        $tags = '';
                                        if ($posttags) {
                                            ?>
                                            <div class="clearfix"></div>
                                            <div class="tags-share clearfix">
                                                <div class="tags pull-left">
                                                    <i class="fa fa-tags"></i>
                                                    <ul>
                                                        <?php
                                                        foreach ($posttags as $tag) {
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                                                   title="<?php echo esc_attr($tag->name); ?>">
                                                                    #<?php echo esc_attr($tag->name); ?>
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if (isset($carspot_theme['enable_share_post']) && $carspot_theme['enable_share_post']) {
                                            ?>
                                            <div class="share pull-right">
                                                <ul>
                                                    <?php echo carspot_social_share(); ?>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="clearfix"></div>
                                        <?php comments_template('', true); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Blog Grid -->
                        </div>
                        <?php
                        if (isset($carspot_theme['blog_sidebar']) && $carspot_theme['blog_sidebar'] == 'right')
                            get_sidebar();
                        if (!isset($carspot_theme['blog_sidebar']))
                            get_sidebar();
                        ?>
                    </div>
                    <!-- Middle Content Area  End -->
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