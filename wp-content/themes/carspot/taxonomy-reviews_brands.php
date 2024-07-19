<?php
get_header();
global $carspot_theme; ?>
    <div class="main-content-area clearfix">
        <section class="section-padding no-top reviews  gray ">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <!-- Left Sidebar -->
                    <?php
                    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'left')
                        get_sidebar();
                    ?>
                    <!-- Middle Content Area -->
                    <?php
                    $blog_type = 'col-md-8 col-xs-12 col-sm-12';
                    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'no-sidebar') {
                        $blog_type = 'col-md-12 col-xs-12 col-sm-12 news';
                    } else {
                        $blog_type = 'col-md-8 col-xs-12 col-sm-12 news';
                    }
                    ?>
                    <div class="<?php echo esc_attr($blog_type); ?>">
                        <div class="row">
                            <!-- Blog Archive -->
                            <div class="posts-masonry">
                                <!-- Blog Post-->
                                <?php get_template_part('template-parts/layouts/reviews', 'brands'); ?>
                            </div>
                            <!-- Pagination -->
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?php carspot_pagination(); ?>
                            </div>
                        </div>
                    </div>

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
<?php get_footer();