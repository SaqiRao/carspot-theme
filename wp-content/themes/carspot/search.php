<?php
get_header();
global $carspot_theme;
$top_padding = 'no-top';
if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
    $top_padding = '';
}
?>
    <div class="main-content-area clearfix">
        <section class="section-padding  <?php echo carspot_returnEcho($top_padding) ?> gray ">
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <?php
                    if (isset($carspot_theme['blog_sidebar']) && $carspot_theme['blog_sidebar'] == 'left')
                        get_sidebar();
                    ?>
                    <?php
                    $blog_type = '';
                    if (isset($carspot_theme['blog_sidebar']) && $carspot_theme['blog_sidebar'] == 'no-sidebar') {
                        $blog_type = 'col-md-12 col-xs-12 col-sm-12';
                    } else {
                        $blog_type = 'col-md-8 col-xs-12 col-sm-12';
                    }
                    ?>
                    <div class="<?php echo esc_attr($blog_type); ?>">
                        <div class="row">
                            <div class="posts-masonry">
                                <?php get_template_part('template-parts/layouts/blog', 'loop'); ?>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?php carspot_pagination(); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($carspot_theme['blog_sidebar']) && $carspot_theme['blog_sidebar'] == 'right')
                        get_sidebar();

                    if (!isset($carspot_theme['blog_sidebar']))
                        get_sidebar();
                    ?>
                </div>
            </div>
        </section>
    </div>
<?php get_footer();