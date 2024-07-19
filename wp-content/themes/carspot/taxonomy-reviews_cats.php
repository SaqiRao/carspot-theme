<?php
get_header();
global $carspot_theme; ?>
    <div class="main-content-area clearfix">
        <section class="section-padding no-top reviews  gray ">
            <div class="container">
                <div class="row">
                    <?php
                    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'left')
                        get_sidebar();
                    $blog_type = 'col-md-8 col-xs-12 col-sm-12';
                    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'no-sidebar') {
                        $blog_type = 'col-md-12 col-xs-12 col-sm-12 news';
                    } else {
                        $blog_type = 'col-md-8 col-xs-12 col-sm-12 news';
                    }
                    ?>
                    <div class="<?php echo esc_attr($blog_type); ?>">
                        <div class="row">
                            <div class="posts-masonry">
                                <?php get_template_part('template-parts/layouts/reviews', 'loop'); ?>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?php carspot_pagination(); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'right')
                        get_sidebar('reviews');
                    ?>
                </div>
            </div>
        </section>
    </div>
<?php get_footer();